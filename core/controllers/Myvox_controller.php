<?php

defined('_EXEC') or die;

class Myvox_controller extends Controller
{
	public function __construct()
	{
		parent::__construct();
	}

    public function index($params)
    {
        $room = $this->model->get_room(strtoupper($params[0]));

        if (!empty($room))
        {
            $account = $this->model->get_account($room['account']);

            Session::set_value('account', [
                'id' => $account['id']
            ]);

            if (Format::exist_ajax_request() == true)
            {
                if ($_POST['action'] == 'get_opt_opportunity_areas')
                {
                    $data = '<option value="" selected hidden>{$lang.choose}</option>';

                    foreach ($this->model->get_opportunity_areas($_POST['option'], $account['id']) as $value)
                        $data .= '<option value="' . $value['id'] . '">' . $value['name'][$account['settings']['language']] . '</option>';

                    Functions::environment([
                        'status' => 'success',
                        'data' => $data
                    ]);
                }

                if ($_POST['action'] == 'get_opt_opportunity_types')
                {
                    $data = '<option value="" selected hidden>{$lang.choose}</option>';

                    foreach ($this->model->get_opportunity_types($_POST['opportunity_area'], $_POST['option']) as $value)
                        $data .= '<option value="' . $value['id'] . '">' . $value['name'][$account['settings']['language']] . '</option>';

                    Functions::environment([
                        'status' => 'success',
                        'data' => $data
                    ]);
                }

                if ($_POST['action'] == 'get_opt_locations')
                {
                    $data = '<option value="" selected hidden>{$lang.choose}</option>';

                    foreach ($this->model->get_locations($_POST['option'], $account['id']) as $value)
                        $data .= '<option value="' . $value['id'] . '">' . $value['name'][$account['settings']['language']] . '</option>';

                    Functions::environment([
                        'status' => 'success',
                        'data' => $data
                    ]);
                }

                if ($_POST['action'] == 'new_vox')
                {
                    $labels = [];

                    if (!isset($_POST['type']) OR empty($_POST['type']))
                        array_push($labels, ['type','']);

                    if (!isset($_POST['opportunity_area']) OR empty($_POST['opportunity_area']))
                        array_push($labels, ['opportunity_area','']);

                    if (!isset($_POST['opportunity_type']) OR empty($_POST['opportunity_type']))
                        array_push($labels, ['opportunity_type','']);

                    if (!isset($_POST['started_date']) OR empty($_POST['started_date']))
                        array_push($labels, ['started_date','']);

                    if (!isset($_POST['started_hour']) OR empty($_POST['started_hour']))
                        array_push($labels, ['started_hour','']);

                    if (!isset($_POST['location']) OR empty($_POST['location']))
                        array_push($labels, ['location','']);

                    if ($_POST['type'] == 'request')
                    {
                        if (!empty($_POST['observations']) AND strlen($_POST['observations']) > 120)
                            array_push($labels, ['observations','']);
                    }

                    if ($_POST['type'] == 'incident')
                    {
                        if (!isset($_POST['description']) OR empty($_POST['description']))
                            array_push($labels, ['description','']);
                    }

                    if (!isset($_POST['lastname']) OR empty($_POST['lastname']))
                        array_push($labels, ['lastname','']);

                    if (empty($labels))
                    {
                        $_POST['account'] = $account['id'];
                        $_POST['room'] = $room['id'];

                        $query = $this->model->new_vox($_POST);

                        if (!empty($query))
                        {
                            $_POST['assigned_users'] = $this->model->get_users('opportunity_area', $_POST['opportunity_area'], $account['id']);
                            $_POST['opportunity_area'] = $this->model->get_opportunity_area($_POST['opportunity_area'])['name'][$account['settings']['language']];
                            $_POST['opportunity_type'] = $this->model->get_opportunity_type($_POST['opportunity_type'])['name'][$account['settings']['language']];
                            $_POST['location'] = $this->model->get_location($_POST['location'])['name'][$account['settings']['language']];

                            $mail = new Mailer(true);

                            try
                            {
                                if ($account['settings']['language'] == 'es')
                                {
                                    if ($_POST['type'] == 'request')
                                        $mail_subject = 'Tienes una nueva petición en GuestVox';
                                    else if ($_POST['type'] == 'incident')
                                        $mail_subject = 'Tienes una nueva incidencia en GuestVox';

                                    $mail_room = 'Habitación: ';
                                    $mail_opportunity_area = 'Área de oportunidad: ';
                                    $mail_opportunity_type = 'Tipo de oportunidad: ';
                                    $mail_started_date = 'Fecha de inicio: ';
                                    $mail_started_hour = 'Hora de inicio: ';
                                    $mail_location = 'Ubicación: ';

                                    if (Functions::get_current_date_hour() < Functions::get_formatted_date_hour($_POST['started_date'], $_POST['started_hour']))
                                        $mail_urgency = 'Urgencia: Programada';
                                    else
                                        $mail_urgency = 'Urgencia: Media';

                                    $mail_confidentiality = 'Confidencialidad: No';
                                    $mail_observations = 'Observaciones: ';
                                    $mail_description = 'Descripción: ';
                                    $mail_give_follow_up = 'Dar seguimiento';
                                }
                                else if ($account['settings']['language'] == 'en')
                                {
                                    if ($_POST['type'] == 'request')
                                        $mail_subject = 'You have a new request in GuestVox';
                                    else if ($_POST['type'] == 'incident')
                                        $mail_subject = 'You have a new incident in GuestVox';

                                    $mail_room = 'Room: ';
                                    $mail_opportunity_area = 'Opportunity area: ';
                                    $mail_opportunity_type = 'Opportunity type: ';
                                    $mail_started_date = 'Start date: ';
                                    $mail_started_hour = 'Start hour: ';
                                    $mail_location = 'Location: ';

                                    if (Functions::get_current_date_hour() < Functions::get_formatted_date_hour($_POST['started_date'], $_POST['started_hour']))
                                        $mail_urgency = 'Urgency: Programmed';
                                    else
                                        $mail_urgency = 'Urgency: Medium';

                                    $mail_confidentiality = 'Confidentiality: No';
                                    $mail_observations = 'Observations: ';
                                    $mail_description = 'Description: ';
                                    $mail_give_follow_up = 'Give follow up';
                                }

                                $mail->isSMTP();
                                $mail->setFrom('noreply@guestvox.com', 'GuestVox');

                                foreach ($_POST['assigned_users'] as $value)
                                    $mail->addAddress($value['email'], $value['name'] . ' ' . $value['lastname']);

                                $mail->isHTML(true);
                                $mail->Subject = $mail_subject;
                                $mail->Body =
                                '<html>
                                    <head>
                                        <title>' . $mail_subject . '</title>
                                    </head>
                                    <body>
                                        <table style="width:600px;margin:0px;border:0px;padding:20px;box-sizing:border-box;background-color:#eee">
                                            <tr style="width:100%;margin:0px:margin-bottom:10px;border:0px;padding:0px;">
                                                <td style="width:100%;margin:0px;border:0px;padding:40px 20px;box-sizing:border-box;background-color:#fff;">
                                                    <figure style="width:100%;margin:0px;padding:0px;text-align:center;">
                                                        <img style="width:100%;max-width:300px;" src="https://guestvox.com/images/logotype-color.png" />
                                                    </figure>
                                                </td>
                                            </tr>
                                            <tr style="width:100%;margin:0px;margin-bottom:10px;border:0px;padding:0px;">
                                                <td style="width:100%;margin:0px;border:0px;padding:40px 20px;box-sizing:border-box;background-color:#fff;">
                                                    <h4 style="font-size:24px;font-weight:600;text-align:center;color:#212121;margin:0px;margin-bottom:20px;padding:0px;">' . $mail_subject . '</h4>
                                                    <h6 style="font-size:14px;font-weight:400;text-align:center;color:#212121;margin:0px;margin-bottom:5px;padding:0px;">' . $mail_room . $room['name'] . '</h6>
                                                    <h6 style="font-size:14px;font-weight:400;text-align:center;color:#212121;margin:0px;margin-bottom:5px;padding:0px;">' . $mail_opportunity_area . $_POST['opportunity_area'] . '</h6>
                                                    <h6 style="font-size:14px;font-weight:400;text-align:center;color:#212121;margin:0px;margin-bottom:5px;padding:0px;">' . $mail_opportunity_type . $_POST['opportunity_type'] . '</h6>
                                                    <h6 style="font-size:14px;font-weight:400;text-align:center;color:#212121;margin:0px;margin-bottom:5px;padding:0px;">' . $mail_started_date . Functions::get_formatted_date($_POST['started_date'], 'd M, Y') . '</h6>
                                                    <h6 style="font-size:14px;font-weight:400;text-align:center;color:#212121;margin:0px;margin-bottom:5px;padding:0px;">' . $mail_started_hour . Functions::get_formatted_hour($_POST['started_hour'], '+ hrs') . '</h6>
                                                    <h6 style="font-size:14px;font-weight:400;text-align:center;color:#212121;margin:0px;margin-bottom:5px;padding:0px;">' . $mail_location . $_POST['location'] . '</h6>
                                                    <h6 style="font-size:14px;font-weight:400;text-align:center;color:#212121;margin:0px;margin-bottom:5px;padding:0px;">' . $mail_urgency . '</h6>';

                                if ($_POST['type'] == 'request')
                                    $mail->Body .= '<p style="font-size:14px;font-weight:400;text-align:center;color:#212121;margin:0px;padding:0px;">' . $mail_observations . $_POST['observations'] . '</p>';
                                else if ($_POST['type'] == 'incident')
                                {
                                    $mail->Body .=
                                    '<h6 style="font-size:14px;font-weight:400;text-align:center;color:#212121;margin:0px;margin-bottom:5px;padding:0px;">' . $mail_confidentiality . '</h6>
                                    <p style="font-size:14px;font-weight:400;text-align:center;color:#212121;margin:0px;padding:0px;">' . $mail_description . $_POST['description'] . '</p>';
                                }

                                $mail->Body .=
                                '                   <a style="width:100%;display:block;margin:15px 0px 20px 0px;padding:20px 0px;box-sizing:border-box;font-size:14px;font-weight:400;text-align:center;text-decoration:none;color:#fff;background-color:#201d33;" href="https://guestvox.com/voxes/view/' . $query . '">' . $mail_give_follow_up . '</a>
                                                </td>
                                            </tr>
                                            <tr style="width:100%;margin:0px;border:0px;padding:0px;">
                                                <td style="width:100%;margin:0px;border:0px;padding:20px;box-sizing:border-box;background-color:#fff;">
                                                    <a style="width:100%;display:block;padding:20px 0px;box-sizing:border-box;font-size:14px;font-weight:400;text-align:center;text-decoration:none;color:#201d33;" href="https://guestvox.com/">www.guestvox.com</a>
                                                </td>
                                            </tr>
                                        </table>
                                    </body>
                                </html>';
                                $mail->AltBody = '';
                                $mail->send();
                            }
                            catch (Exception $e) { }

                            Functions::environment([
                                'status' => 'success',
                                'message' => '{$lang.thanks_trus_us_vox_send_correctly}',
                                'path' => '/'
                            ]);
                        }
                        else
                        {
                            Functions::environment([
                                'status' => 'error',
                                'message' => '{$lang.error_operation_database}'
                            ]);
                        }
                    }
                    else
                    {
                        Functions::environment([
                            'status' => 'error',
                            'labels' => $labels
                        ]);
                    }
                }
            }
            else
            {
                define('_title', 'GuestVox | {$lang.im_the_guests_voice}');

                $template = $this->view->render($this, 'index');

                $opt_opportunity_areas = '';

                foreach ($this->model->get_opportunity_areas('request', $account['id']) as $value)
                    $opt_opportunity_areas .= '<option value="' . $value['id'] . '">' . $value['name'][$account['settings']['language']] . '</option>';

                $opt_locations = '';

                foreach ($this->model->get_locations('request', $account['id']) as $value)
                    $opt_locations .= '<option value="' . $value['id'] . '">' . $value['name'][$account['settings']['language']] . '</option>';

                $opt_guest_treatments = '';

                foreach ($this->model->get_guest_treatments($account['id']) as $value)
                    $opt_guest_treatments .= '<option value="' . $value['id'] . '">' . $value['name'] . '</option>';

                $replace = [
                    '{$opt_opportunity_areas}' => $opt_opportunity_areas,
                    '{$opt_locations}' => $opt_locations,
                    '{$opt_guest_treatments}' => $opt_guest_treatments,
                ];

                $template = $this->format->replace($replace, $template);

                echo $template;
            }
        }
        else
            header('Location: /');
    }
}
