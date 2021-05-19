<?php

    define('_EXEC', 1);

    include_once('../configuration.php');
    include_once('../libraries/valkyrie/Medoo.class.php');
    include_once('../libraries/AuthMailerDemon.class.php');
    include_once('../libraries/Languages.class.php');

    $database = new Medoo();

    $query = $database->select('surveys', [
        '[>]accounts' => [
            'account' => 'id'
        ]
    ], [
        'accounts.name(account_name)',
        'accounts.time_zone(account_time_zone)',
        'accounts.language(account_language)',
        'accounts.logotype(account_logotype)',
        'surveys.name',
        'surveys.report'
    ], [
        'AND' => [
            'accounts.surveys' => true,
            'accounts.status' => true
        ]
    ]);

    foreach ($query as $value)
    {
        $value['report'] = json_decode($value['report'], true);

        if ($value['report']['status'] == true)
        {
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
                                    <h4 style="width:100%;margin:0px 0px 20px 0px;padding:0px;font-size:18px;font-weight:600;text-align:center;color:#212121;">' . $value['name'][$value['account_language']] . '</h4>
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
