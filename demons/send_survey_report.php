<?php

    define('_EXEC', 1);

    include_once(dirname(__DIR__) . DIRECTORY_SEPARATOR . 'configuration.php');
    include_once(dirname(__DIR__) . DIRECTORY_SEPARATOR . 'libraries' . DIRECTORY_SEPARATOR . 'valkyrie' . DIRECTORY_SEPARATOR . 'Medoo.class.php');
    include_once(dirname(__DIR__) . DIRECTORY_SEPARATOR . 'libraries' . DIRECTORY_SEPARATOR . 'AuthMailerDemon.class.php');
    include_once(dirname(__DIR__) . DIRECTORY_SEPARATOR . 'libraries' . DIRECTORY_SEPARATOR . 'Languages.class.php');

    $database = new Medoo();

    $query = $database->select('surveys', [
        '[>]accounts' => [
            'account' => 'id'
        ]
    ], [
        'surveys.id',
        'accounts.name(account_name)',
        'accounts.time_zone(account_time_zone)',
        'accounts.language(account_language)',
        'accounts.logotype(account_logotype)',
        'surveys.name',
        'surveys.nps',
        'surveys.report'
    ], [
        'AND' => [
            'accounts.surveys' => true,
            'accounts.status' => true
        ]
    ]);

    foreach ($query as $key => $value)
    {
        $value['name'] = json_decode($value['name'], true);
        $value['report'] = json_decode($value['report'], true);

        if ($value['report']['status'] == true)
        {
            date_default_timezone_set($value['account_time_zone']);

            $days = [
                '1' => 'monday',
                '2' => 'tuesday',
                '3' => 'wednesday',
                '4' => 'thursday',
                '5' => 'friday',
                '6' => 'saturday',
                '7' => 'sunday'
            ];

            $date = date('Y-m-d');
            $day = date("w");
            $start_time = date('H:i:s', strtotime($value['report']['time']));
            $end_time = date('H:i:s', strtotime('+ 59 minute', strtotime(date('H:i:s', strtotime($start_time)))));
            $current_time = date('H:i:s', time());

            if (in_array($days[$day], $value['report']['days']) AND $current_time >= $start_time AND $current_time <= $end_time)
            {
                $answers = $database->select('surveys_answers', [
                    'values',
                    'firstname',
                    'lastname',
                    'comment',
                    'reservation',
                    'hour'
                ], [
                    'AND' => [
                        'survey' => $value['id'],
                        'date' => $date
                    ]
                ]);

                $average = 0;
                $count = 0;
                $nps_1 = 0;
                $nps_2 = 0;
                $nps_3 = 0;
                $nps_4 = 0;
                $nps_detractores = 0;
                $nps_pasivos = 0;
                $nps_promotores = 0;
                $nps_answers = 0;
                $comments = '';

                foreach ($answers as $subkey => $subvalue)
                {
                    $subvalue['values'] = json_decode($subvalue['values'], true);
                    $subvalue['reservation'] = json_decode($subvalue['reservation'], true);
                    $nps_average = 0;
                    $nps_count = 0;
                    $nps_status = false;

                	foreach ($subvalue['values'] as $intkey => $intvalue)
                	{
                		$intvalue = $database->select('surveys_questions', [
                			'type'
                		], [
                			'id' => $intkey
                		]);

                		if (!empty($intvalue))
                        {
                            if ($intvalue[0]['type'] == 'rate')
                    		{
                    			$average = $average + $subvalue['values'][$intkey];
                    			$count = $count + 1;
                    		}

                            if ($intvalue[0]['type'] == 'nps')
                    		{
                    			$nps_average = $nps_average + $subvalue['values'][$intkey];
                    			$nps_count = $nps_count + 1;
                                $nps_status = true;
                    		}
                        }
                	}

                    if ($nps_average > 0 AND $nps_count > 0)
                    {
                        $nps_average = round(($nps_average / $nps_count), 2);

                        if ($nps_average <= 6)
                            $nps_detractores = $nps_detractores + 1;
                        else if ($nps_average > 6 AND $nps_average <= 8)
                            $nps_pasivos = $nps_pasivos + 1;
                        else if ($nps_average > 8)
                            $nps_promotores = $nps_promotores + 1;
                    }

                    if ($nps_status == true)
                        $nps_answers = $nps_answers + 1;

                    if (!empty($subvalue['comment']))
                    {
                        $comments .=
                        '<p style="width:100%;margin:0px 0px 5px 0px;padding:0px 0px 0px 20px;box-sizing:border-box;font-size:14px;font-weight:400;color:#757575;">' . $subvalue['comment'] . '</p>
                        <p style="width:100%;margin:0px 0px 5px 0px;padding:0px 0px 0px 40px;box-sizing:border-box;font-size:12px;font-weight:400;color:#757575;">' . $subvalue['hour'] . ' | ';

                        if (!empty($subvalue['reservation']))
                            $comments .= $subvalue['reservation']['firstname'] . ' ' . $subvalue['reservation']['lastname'];
                        else
                            $comments .= $subvalue['firstname'] . ' ' . $subvalue['lastname'];

                        $comments .= '</p>';
                    }
                }

                if ($average > 0 AND $count > 0)
            	   $average = round(($average / $count), 2);

               if ($nps_answers > 0)
               {
                   $nps_1 = round((($nps_detractores / $nps_answers) * 100), 2);
                   $nps_2 = round((($nps_pasivos / $nps_answers) * 100), 2);
                   $nps_3 = round((($nps_promotores / $nps_answers) * 100), 2);
                   $nps_4 = round(($nps_3 - $nps_1), 2);
               }

                $mail = new Mailer(true);

                try
                {
                    $mail->setFrom('noreply@guestvox.com', 'Guestvox');
                    $mail->addAddress($value['report']['email'], $value['account_name']);
                    $mail->Subject = date('d-m-Y') . ' | ' . Languages::email('day_report')[$value['account_language']] . ' | Encuestas';
                    $mail->Body =
                    '<html>
                        <head>
                            <title>' . $mail->Subject . '</title>
                        </head>
                        <body>
                            <table style="width:600px;margin:0px;padding:20px;border:0px;box-sizing:border-box;background-color:#eee">
                                <tr style="width:100%;margin:0px 0px 10px 0px;padding:0px;border:0px;">
                                    <td style="width:100%;margin:0px;padding:40px 20px;border:0px;box-sizing:border-box;background-color:#fff;">
                                        <figure style="width:100%;margin:0px;padding:0px;text-align:center;">
                                            <img style="width:100%;max-width:300px;" src="https://' . Configuration::$domain . '/uploads/' . $value['account_logotype'] . '">
                                        </figure>
                                    </td>
                                </tr>
                                <tr style="width:100%;margin:0px 0px 10px 0px;padding:0px;border:0px;">
                                    <td style="width:100%;margin:0px;padding:40px 20px;border:0px;box-sizing:border-box;background-color:#fff;">
                                        <h4 style="width:100%;margin:0px 0px 10px 0px;padding:0px;font-size:18px;font-weight:600;text-align:center;color:#212121;">' . $value['name'][$value['account_language']] . '</h4>
                                        <h6 style="width:100%;margin:0px 0px 20px 0px;padding:0px;font-size:18px;font-weight:400;text-align:center;color:#757575;">' . Languages::email('day_report')[$value['account_language']] . ' ' . date('d-m-Y') . '</h6>
                                        <h6 style="width:100%;margin:0px 0px 5px 0px;padding:0px;font-size:18px;font-weight:400;color:#757575;">' . Languages::email('average_day')[$value['account_language']] . ': ' . (($average > 0 AND $count > 0) ? $average . ' Estrellas' : Languages::email('not_available')[$value['account_language']]) . '</h6>
                                        ' . (($value['nps'] == true) ? '<h6 style="width:100%;margin:0px 0px 5px 0px;padding:0px;font-size:18px;font-weight:400;color:#757575;">' . Languages::email('day_nps')[$value['account_language']] . ': ' . (($nps_answers > 0) ? $nps_4 . '% (Detractores: ' . $nps_1 . '%, Pasivos: ' . $nps_2 . '%, Promotores: ' . $nps_3 . '%)' : Languages::email('not_available')[$value['account_language']]) . '</h6>' : '') . '
                                        <h6 style="width:100%;margin:0px 0px 5px 0px;padding:0px;font-size:18px;font-weight:400;color:#757575;">' . Languages::email('day_total_answers')[$value['account_language']] . ': ' . count($answers) . '</h6>
                                        <h6 style="width:100%;margin:0px 0px 5px 0px;padding:0px;font-size:18px;font-weight:400;color:#757575;">' . (!empty($comments) ? Languages::email('comments')[$value['account_language']] . ': ' : Languages::email('not_comments')[$value['account_language']]) . '</h6>
                                        ' . (!empty($comments) ? $comments : '') . '
                                    </td>
                                </tr>
                                <tr style="width:100%;margin:0px;padding:0px;border:0px;">
                                    <td style="width:100%;margin:0px;padding:20px;border:0px;box-sizing:border-box;background-color:#fff;">
                                        <a style="width:100%;display:block;padding:20px 0px;box-sizing:border-box;font-size:14px;font-weight:400;text-align:center;text-decoration:none;color:#757575;" href="https://' . Configuration::$domain . '">' . Configuration::$domain . '</a>
                                    </td>
                                </tr>
                            </table>
                        </body>
                    </html>';
                    $mail->send();
                }
                catch (Exception $e) { }
            }
        }
    }
