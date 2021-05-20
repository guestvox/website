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

            $date = date('Y-m-d');
            $start_time = date('H:i:s', strtotime($value['report']['time']));
            $end_time = date('H:i:s', strtotime('+ 59 minute', strtotime(date('H:i:s', strtotime($start_time)))));
            $current_time = date('H:i:s', time());

            if ($current_time >= $start_time AND $current_time <= $end_time)
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
                $nps = 0;
                $comments = '';

                foreach ($answers as $subkey => $subvalue)
                {
                    $subvalue['values'] = json_decode($subvalue['values'], true);
                    $subvalue['reservation'] = json_decode($subvalue['reservation'], true);

                	foreach ($subvalue['values'] as $intkey => $intvalue)
                	{
                		$intvalue = $database->select('surveys_questions', [
                			'type'
                		], [
                			'id' => $intkey
                		]);

                		if ($intvalue[0]['type'] == 'rate')
                		{
                			$average = $average + $subvalue['values'][$intkey];
                			$count = $count + 1;
                		}
                	}

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
            	   $average = round(($average / $count), 1);

                $mail = new Mailer(true);

                try
                {
                    $mail->setFrom('noreply@guestvox.com', 'Guestvox');
                    $mail->addAddress($value['report']['email'], $value['account_name']);
                    $mail->Subject = Languages::email('check_out_todays_survey_stats')[$value['account_language']];
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
                                        <h6 style="width:100%;margin:0px 0px 20px 0px;padding:0px;font-size:18px;font-weight:400;text-align:center;color:#757575;">' . Languages::email('day_report')[$value['account_language']] . ' ' . $date . '</h6>
                                        <h6 style="width:100%;margin:0px 0px 5px 0px;padding:0px;font-size:18px;font-weight:400;color:#757575;">' . Languages::email('average_day')[$value['account_language']] . ': ' . (($average > 0 AND $count > 0) ? $average : Languages::email('not_available')[$value['account_language']]) . '</h6>
                                        ' . (($value['nps'] == true) ? '<h6 style="width:100%;margin:0px 0px 5px 0px;padding:0px;font-size:18px;font-weight:400;color:#757575;">' . Languages::email('day_nps')[$value['account_language']] . ': ' . $nps . '</h6>' : '') . '
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
