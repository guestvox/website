<?php

defined('_EXEC') or die;

// require_once 'plugins/nexmo/vendor/autoload.php';

class Voxes_controller extends Controller
{
	public function __construct()
	{
		parent::__construct();
	}

	public function index()
	{
		define('_title', 'GuestVox | {$lang.voxes}');

		$template = $this->view->render($this, 'index');

		$tbl_voxes = '';

		foreach ($this->model->get_voxes() as $value)
		{
			$value['data']['readed'] = ($value['data']['readed'] == true) ? 'readed' : 'no-readed';
			$value['data']['confidentiality'] = ($value['data']['confidentiality'] == true) ? '<span><i class="fas fa-key"></i></span>' : '';
			$value['data']['assigned_users'] = (!empty($value['data']['assigned_users'])) ? '<span><i class="fas fa-users"></i></span>' : '';
			$value['data']['comments'] = (!empty($value['data']['comments'])) ? '<span><i class="fas fa-comment"></i></span>' : '';
			$value['data']['attachments'] = (!empty($value['data']['attachments'])) ? '<span><i class="fas fa-paperclip"></i></span>' : '';

			if ($value['data']['status'] == 'open' AND Functions::get_current_date_hour() < Functions::get_formatted_date_hour($value['data']['started_date'], $value['data']['started_hour']))
			{
				if ($value['data']['urgency'] == 'low')
					$value['data']['urgency'] = '<span style="background-color:#4caf50;color:#fff;"><i class="fas fa-clock"></i></span>';
				else if ($value['data']['urgency'] == 'medium')
					$value['data']['urgency'] = '<span style="background-color:#ffc107;color:#fff;"><i class="fas fa-clock"></i></span>';
				else if ($value['data']['urgency'] == 'high')
					$value['data']['urgency'] = '<span style="background-color:#f44336;color:#fff;"><i class="fas fa-clock"></i></span>';
			}
			else if ($value['data']['status'] == 'open')
			{
				if ($value['data']['urgency'] == 'low')
					$value['data']['urgency'] = '<span style="background-color:#4caf50;color:#fff;"><i class="fas fa-lock-open"></i></span>';
				else if ($value['data']['urgency'] == 'medium')
					$value['data']['urgency'] = '<span style="background-color:#ffc107;color:#fff;"><i class="fas fa-lock-open"></i></span>';
				else if ($value['data']['urgency'] == 'high')
					$value['data']['urgency'] = '<span style="background-color:#f44336;color:#fff;"><i class="fas fa-lock-open"></i></span>';
			}
			else if ($value['data']['status'] == 'close')
			{
				if ($value['data']['urgency'] == 'low')
					$value['data']['urgency'] = '<span style="background-color:#4caf50;color:#fff;"><i class="fas fa-lock"></i></span>';
				else if ($value['data']['urgency'] == 'medium')
					$value['data']['urgency'] = '<span style="background-color:#ffc107;color:#fff;"><i class="fas fa-lock"></i></span>';
				else if ($value['data']['urgency'] == 'high')
					$value['data']['urgency'] = '<span style="background-color:#f44336;color:#fff;"><i class="fas fa-lock"></i></span>';
			}

			$tbl_voxes .=
			'<tr class="' . $value['data']['status'] . ' ' . $value['data']['readed'] . '" data-id="' . $value['id'] . '">
				<td align="left" class="touchable">' . $value['data']['room'] . '</td>
				<td align="left" class="touchable">' . $value['data']['guest_treatment'] . ' ' . $value['data']['name'] . ' ' . $value['data']['lastname'] . '</td>
				<td align="left" class="touchable">' . $value['data']['observations'] . ' ' . $value['data']['subject'] . '</td>
				<td align="left" class="touchable">' . $value['data']['opportunity_area'] . '</td>
				<td align="left" class="touchable">' . $value['data']['opportunity_type'] . '</td>
				<td align="left" class="touchable">' . $value['data']['location'] . '</td>
				<td align="left" class="touchable">' . Functions::get_formatted_date($value['data']['started_date'], 'd M, y') . '</td>
				<td align="left" class="touchable"
					data-started-date="' . Functions::get_formatted_date_hour($value['data']['started_date'], $value['data']['started_hour']) . '"
					data-completed-date="' . Functions::get_formatted_date_hour($value['data']['completed_date'], $value['data']['completed_hour']) . '"
					data-status="' . $value['data']['status'] . '" data-elapsed-time></td>
				<td align="right" class="touchable icon">' . $value['data']['confidentiality'] . '</td>
				<td align="right" class="touchable icon">' . $value['data']['assigned_users'] . '</td>
				<td align="right" class="touchable icon">' . $value['data']['comments'] . '</td>
				<td align="right" class="touchable icon">' . $value['data']['attachments'] . '</td>
				<td align="right" class="touchable icon">' . $value['data']['urgency'] . '</td>
			</tr>';
		}

		$replace = [
			'{$tbl_voxes}' => $tbl_voxes
		];

		$template = $this->format->replace($replace, $template);

		echo $template;
	}

	public function create()
	{
		if (Format::exist_ajax_request() == true)
		{
			if ($_POST['action'] == 'get_api')
			{
				if (Session::get_value('user')['id'] == 106)
				{
					$api = curl_init();

					curl_setopt($api, CURLOPT_URL, 'https://admin.zaviaerp.com/pms/hotels/api/check_room2/?UserName=demo&UserPassword=demo&RoomNumber=' . $this->model->get_room($_POST['room'])['name']);
					curl_setopt($api, CURLOPT_RETURNTRANSFER, true);

					$data = Functions::get_json_decoded_query(curl_exec($api));

					curl_close($api);

					if ($data['Status'] == 'success')
					{
						Functions::environment([
							'status' => 'success',
							'data' => $data
						]);
					}
					else if ($data['Status'] == 'error')
					{
						Functions::environment([
							'status' => 'error',
						]);
					}
				}
				else
				{
					Functions::environment([
						'status' => 'error',
					]);
				}
			}

			if ($_POST['action'] == 'get_opt_opportunity_areas')
			{
				$data = '<option value="" selected hidden>{$lang.choose}</option>';

				foreach ($this->model->get_opportunity_areas($_POST['option']) as $value)
					$data .= '<option value="' . $value['id'] . '">' . $value['name'][Session::get_value('settings')['language']] . '</option>';

				Functions::environment([
					'status' => 'success',
					'data' => $data
				]);
			}

			if ($_POST['action'] == 'get_opt_opportunity_types')
			{
				$data = '<option value="" selected hidden>{$lang.choose}</option>';

				foreach ($this->model->get_opportunity_types($_POST['opportunity_area'], $_POST['option']) as $value)
					$data .= '<option value="' . $value['id'] . '">' . $value['name'][Session::get_value('settings')['language']] . '</option>';

				Functions::environment([
					'status' => 'success',
					'data' => $data
				]);
			}

			if ($_POST['action'] == 'get_opt_locations')
			{
				$data = '<option value="" selected hidden>{$lang.choose}</option>';

				foreach ($this->model->get_locations($_POST['option']) as $value)
					$data .= '<option value="' . $value['id'] . '">' . $value['name'][Session::get_value('settings')['language']] . '</option>';

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

				if (!isset($_POST['urgency']) OR empty($_POST['urgency']))
					array_push($labels, ['urgency','']);

				if ($_POST['type'] == 'request')
				{
					if (!empty($_POST['observations']) AND strlen($_POST['observations']) > 120)
						array_push($labels, ['observations','']);
				}

				if ($_POST['type'] == 'incident')
				{
					if (!empty($_POST['subject']) AND strlen($_POST['subject']) > 120)
						array_push($labels, ['subject','']);
				}

				if (empty($labels))
				{
					$_POST['confidentiality'] = (!empty($_POST['confidentiality'])) ? true : false;
					$_POST['attachments'] = $_FILES['attachments'];

					$query = $this->model->new_vox($_POST);

					if (!empty($query))
					{
						if (!empty($_POST['assigned_users']))
							$_POST['assigned_users'] = $this->model->get_users('ids', $_POST['assigned_users']);
						else
							$_POST['assigned_users'] = $this->model->get_users('opportunity_area', $_POST['opportunity_area']);

						$_POST['room'] = $this->model->get_room($_POST['room'])['name'];
						$_POST['opportunity_area'] = $this->model->get_opportunity_area($_POST['opportunity_area'])['name'][Session::get_value('settings')['language']];
						$_POST['opportunity_type'] = $this->model->get_opportunity_type($_POST['opportunity_type'])['name'][Session::get_value('settings')['language']];
						$_POST['location'] = $this->model->get_location($_POST['location'])['name'][Session::get_value('settings')['language']];

						$mail = new Mailer(true);

						try
						{
							if (Session::get_value('settings')['language'] == 'es')
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
								else if ($_POST['urgency'] == 'low')
									$mail_urgency = 'Urgencia: Baja';
								else if ($_POST['urgency'] == 'medium')
									$mail_urgency = 'Urgencia: Media';
								else if ($_POST['urgency'] == 'high')
									$mail_urgency = 'Urgencia: Alta';

								if ($_POST['confidentiality'] == true)
									$mail_confidentiality = 'Confidencialidad: Si';
								else if ($_POST['confidentiality'] == false)
									$mail_confidentiality = 'Confidencialidad: No';

								$mail_observations = 'Observaciones: ';
								$mail_description = 'Descripción: ';
								$mail_give_follow_up = 'Dar seguimiento';
							}
							else if (Session::get_value('settings')['language'] == 'en')
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
								else if ($_POST['urgency'] == 'low')
									$mail_urgency = 'Urgency: Low';
								else if ($_POST['urgency'] == 'medium')
									$mail_urgency = 'Urgency: Medium';
								else if ($_POST['urgency'] == 'high')
									$mail_urgency = 'Urgency: High';

								if ($_POST['confidentiality'] == true)
									$mail_confidentiality = 'Confidentiality: Yes';
								else if ($_POST['confidentiality'] == false)
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
						                    	<h6 style="font-size:14px;font-weight:400;text-align:center;color:#212121;margin:0px;margin-bottom:5px;padding:0px;">' . $mail_room . $_POST['room'] . '</h6>
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

						// $basic  = new \Nexmo\Client\Credentials\Basic('45669cce', 'CR1Vg1bpkviV8Jzc');
						// $client = new \Nexmo\Client($basic);
						//
						// $sms = $this->model->get_sms();
						//
						// if ($sms > 0)
						// {
						// 	if (Session::get_value('settings')['language'] == 'es')
						// 	{
						// 		if ($_POST['type'] == 'request')
						// 			$sms_subject = 'Nueva petición';
						// 		else if ($_POST['type'] == 'incident')
						// 			$sms_subject = 'Nueva incidencia';
						//
						// 		$sms_room = 'Hab: ';
						// 		$sms_opportunity_area = 'AO: ';
						// 		$sms_opportunity_type = 'TO: ';
						// 		$sms_started_date = 'Fecha: ';
						// 		$sms_started_hour = 'Hr: ';
						// 		$sms_location = 'Ubic: ';
						//
						// 		if (Functions::get_current_date_hour() < Functions::get_formatted_date_hour($_POST['started_date'], $_POST['started_hour']))
						// 			$sms_urgency = 'Urg: Programada';
						// 		else if ($_POST['urgency'] == 'low')
						// 			$sms_urgency = 'Urg: Baja';
						// 		else if ($_POST['urgency'] == 'medium')
						// 			$sms_urgency = 'Urg: Media';
						// 		else if ($_POST['urgency'] == 'high')
						// 			$sms_urgency = 'Urg: Alta';
						//
						// 		if ($_POST['confidentiality'] == true)
						// 			$sms_confidentiality = 'Conf: Si';
						// 		else if ($_POST['confidentiality'] == false)
						// 			$sms_confidentiality = 'Conf: No';
						//
						// 		$sms_observations = 'Obs: ';
						// 		$sms_description = 'Desc: ';
						// 	}
						// 	else if (Session::get_value('settings')['language'] == 'en')
						// 	{
						// 		if ($_POST['type'] == 'request')
						// 			$sms_subject = 'New request';
						// 		else if ($_POST['type'] == 'incident')
						// 			$sms_subject = 'New incident';
						//
						// 		$sms_room = 'Room: ';
						// 		$sms_opportunity_area = 'OA: ';
						// 		$sms_opportunity_type = 'OT: ';
						// 		$sms_started_date = 'Date: ';
						// 		$sms_started_hour = 'Hr: ';
						// 		$sms_location = 'Loc: ';
						//
						// 		if (Functions::get_current_date_hour() < Functions::get_formatted_date_hour($_POST['started_date'], $_POST['started_hour']))
						// 			$sms_urgency = 'Urg: Programmed';
						// 		else if ($_POST['urgency'] == 'low')
						// 			$sms_urgency = 'Urg: Low';
						// 		else if ($_POST['urgency'] == 'medium')
						// 			$sms_urgency = 'Urg: Medium';
						// 		else if ($_POST['urgency'] == 'high')
						// 			$sms_urgency = 'Urg: High';
						//
						// 		if ($_POST['confidentiality'] == true)
						// 			$sms_confidentiality = 'Conf: Yes';
						// 		else if ($_POST['confidentiality'] == false)
						// 			$sms_confidentiality = 'Conf: No';
						//
						// 		$sms_observations = 'Obs: ';
						// 		$sms_description = 'Desc: ';
						// 	}
						//
						// 	$sms_text = $sms_subject . ' ' . $sms_room . $_POST['room'] . ' ' . $sms_opportunity_area . $_POST['opportunity_area'] . ' ' . $sms_opportunity_type . $_POST['opportunity_type'] . ' ' . $sms_started_date . Functions::get_formatted_date($_POST['started_date'], 'd M y') . ' ' . $sms_started_hour . Functions::get_formatted_hour($_POST['started_hour'], '+ hrs') . ' ' . $sms_location . $_POST['location'] . ' ' . $sms_urgency . ' ';
						//
						// 	if ($_POST['type'] == 'request')
						// 		$sms_text .= $sms_observations . $_POST['observations'];
						// 	else if ($_POST['type'] == 'incident')
						// 		$sms_text .= $sms_confidentiality . ' ' . $sms_description . $_POST['description'];
						//
						// 	foreach ($_POST['assigned_users'] as $value)
						// 	{
						// 		if ($sms > 0)
						// 		{
						// 			$client->message()->send([
						// 				'to' => '52' . $value['cellphone'],
						// 				'from' => 'GuestVox',
						// 				'text' => $sms_text
						// 			]);
						//
						// 			$sms = $sms - 1;
						// 		}
						// 	}
						//
						// 	$this->model->edit_sms($sms);
						// }

						Functions::environment([
							'status' => 'success',
							'message' => '{$lang.success_operation_database}',
							'path' => '/voxes'
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
			define('_title', 'GuestVox | {$lang.new_vox}');

			$template = $this->view->render($this, 'create');

			$opt_rooms = '';

			foreach ($this->model->get_rooms() as $value)
				$opt_rooms .= '<option value="' . $value['id'] . '">' . $value['name'] . '</option>';

			$opt_opportunity_areas = '';

			foreach ($this->model->get_opportunity_areas('request') as $value)
				$opt_opportunity_areas .= '<option value="' . $value['id'] . '">' . $value['name'][Session::get_value('settings')['language']] . '</option>';

			$opt_locations = '';

			foreach ($this->model->get_locations('request') as $value)
				$opt_locations .= '<option value="' . $value['id'] . '">' . $value['name'][Session::get_value('settings')['language']] . '</option>';

			$opt_guest_treatments = '';

			foreach ($this->model->get_guest_treatments() as $value)
				$opt_guest_treatments .= '<option value="' . $value['id'] . '">' . $value['name'] . '</option>';

			$opt_guest_types = '';

			foreach ($this->model->get_guest_types() as $value)
				$opt_guest_types .= '<option value="' . $value['id'] . '">' . $value['name'] . '</option>';

			$opt_reservation_status = '';

			foreach ($this->model->get_reservation_statuss() as $value)
				$opt_reservation_status .= '<option value="' . $value['id'] . '">' . $value['name'] . '</option>';

			$opt_users = '';

			foreach ($this->model->get_users() as $value)
				$opt_users .= '<option value="' . $value['id'] . '">' . $value['username'] . '</option>';

			$replace = [
				'{$opt_rooms}' => $opt_rooms,
				'{$opt_opportunity_areas}' => $opt_opportunity_areas,
				'{$opt_locations}' => $opt_locations,
				'{$opt_guest_treatments}' => $opt_guest_treatments,
				'{$opt_guest_types}' => $opt_guest_types,
				'{$opt_reservation_status}' => $opt_reservation_status,
				'{$opt_users}' => $opt_users,
			];

			$template = $this->format->replace($replace, $template);

			echo $template;
		}
	}

	public function view($params)
	{
		$vox = $this->model->get_vox($params[0], true);

		if (!empty($vox))
		{
			if (Format::exist_ajax_request() == true)
			{
				if ($_POST['action'] == 'complete_vox')
				{
					$query = $this->model->complete_vox($params[0]);

					Functions::environment([
						'status' => !empty($query) ? 'success' : 'error',
						'message' => !empty($query) ? '{$lang.success_operation_database}' : '{$lang.error_operation_database}',
						'path' => '/voxes',
					]);
				}

				if ($_POST['action'] == 'reopen_vox')
				{
					$query = $this->model->reopen_vox($params[0]);

					Functions::environment([
						'status' => !empty($query) ? 'success' : 'error',
						'message' => !empty($query) ? '{$lang.success_operation_database}' : '{$lang.error_operation_database}',
						'path' => '/voxes/view/' . $params[0],
					]);
				}

				if ($_POST['action'] == 'new_comment_vox')
				{
					$labels = [];

					if (!isset($_POST['message']) OR empty($_POST['message']))
						array_push($labels, ['message', '']);

					if (empty($labels))
					{
						$_POST['attachments'] = $_FILES['attachments'];

						$query = $this->model->new_comment_vox($params[0], $_POST);

						Functions::environment([
							'status' => !empty($query) ? 'success' : 'error',
							'message' => !empty($query) ? '{$lang.success_operation_database}' : '{$lang.error_operation_database}',
							'path' => '/voxes/view/' . $params[0],
						]);
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
				define('_title', 'GuestVox | {$lang.view_vox}');

				$template = $this->view->render($this, 'view');

				if ($vox['data']['status'] == 'open' AND Functions::get_current_date_hour() < Functions::get_formatted_date_hour($vox['data']['started_date'], $vox['data']['started_hour']))
					$div_urgency = '<div><h3>{$lang.urgency}:</h3><div>{$lang.programmed}</div></div>';
				else if ($vox['data']['urgency'] == 'low')
					$div_urgency = '<div><h3>{$lang.urgency}:</h3><div style="background-color:#4caf50;color:#fff;">{$lang.low}</div></div>';
				else if ($vox['data']['urgency'] == 'medium')
					$div_urgency = '<div><h3>{$lang.urgency}:</h3><div style="background-color:#ffc107;color:#fff;">{$lang.medium}</div></div>';
				else if ($vox['data']['urgency'] == 'high')
					$div_urgency = '<div><h3>{$lang.urgency}:</h3><div style="background-color:#f44336;color:#fff;">{$lang.high}</div></div>';

				$art_attachments = '';

				if (!empty($vox['data']['attachments']))
				{
					$art_attachments .=
					'<article>
						<main class="tables">';

					foreach ($vox['data']['attachments'] as $value)
					{
						if ($value['status'] == 'success')
						{
							$ext = strtoupper(explode('.', $value['file'])[1]);

							if ($ext == 'JPG' OR $ext == 'JPEG' OR $ext == 'PNG')
								$art_attachments .= '<figure class="attachment"><img src="{$path.uploads}' . $value['file'] . '"><a href="{$path.uploads}' . $value['file'] . '" class="fancybox-thumb" rel="fancybox-thumb"></a></figure>';
							else if ($ext == 'PDF' OR $ext == 'DOC' OR $ext == 'DOCX' OR $ext == 'XLS' OR $ext == 'XLSX')
								$art_attachments .= '<iframe class="attachment" src="https://docs.google.com/viewer?url=https://guestvox.com/uploads/' . $value['file'] . '&embedded=true"></iframe>';
						}
					}

					$art_attachments .=
					'		<div class="clear"></div>
						</main>
					</article>';
				}

				$art_comments = '';

				if (!empty($vox['data']['comments']) OR $vox['data']['status'] == 'open')
				{
					$art_comments .= '<article>';

					if (!empty($vox['data']['comments']))
					{
						$art_comments .=
						'<main class="tables">
							<div class="timeline">';

						foreach ($vox['data']['comments'] as $value)
						{
							$art_comments .=
							'<div class="follow">
								<div class="text">' . $value['message'] . '</div>
								<div class="attachments-follow">';

							if (!empty($value['attachments']))
							{
								foreach ($value['attachments'] as $subvalue)
								{
									if ($subvalue['status'] == 'success')
									{
										$ext = strtoupper(explode('.', $subvalue['file'])[1]);

										if ($ext == 'JPG' OR $ext == 'JPEG' OR $ext == 'PNG')
											$art_comments .= '<figure class="attachment"><img src="{$path.uploads}' . $subvalue['file'] . '"><a href="{$path.uploads}' . $subvalue['file'] . '" class="fancybox-thumb" rel="fancybox-thumb"></a></figure>';
										else if ($ext == 'PDF' OR $ext == 'DOC' OR $ext == 'DOCX' OR $ext == 'XLS' OR $ext == 'XLSX')
											$art_comments .= '<iframe class="attachment" src="https://docs.google.com/viewer?url=https://guestvox.com/uploads/' . $subvalue['file'] . '&embedded=true"></iframe>';
									}
								}
							}

							$art_comments .=
							'	<div class="clear"></div>
							</div>
							<div class="user">
								<h1>@' . $value['user']['username'] . '</h1>
								<h2>{$lang.commented_at_day}: ' . Functions::get_formatted_date($value['date'], 'd M, y') . ' {$lang.at} ' . Functions::get_formatted_hour($value['hour'], '+ hrs') . '</h2>';

							if ($vox['data']['status'] == 'open')
								$art_comments .= '<a data-response-to="' . $value['user']['username'] . '" data-button-modal="new_comment_vox">{$lang.reply}</a>';

							$art_comments .=
							'	</div>
							</div class="follow">';
						}

						$art_comments .=
						'	</div>
						</main>';
					}

					if ($vox['data']['status'] == 'open')
					{
						$art_comments .=
						'<footer>
							<div class="buttons text-center">
								<a class="btn" data-button-modal="new_comment_vox">{$lang.comment}</a>
							</div>
						</footer>';
					}

					$art_comments .= '</article>';
				}

				$art_assigned_users = '';

				if (!empty($vox['data']['assigned_users']))
				{
					$art_assigned_users .=
					'<article>
						<main class="tables">
							<ul class="info">
								<li><strong>{$lang.assigned_users}</strong></li>';

					foreach ($vox['data']['assigned_users'] as $value)
						$art_assigned_users .= '<li>@' . $value['username'] . '</li>';

					$art_assigned_users .=
					'		</ul>
						</main>
					</article>';
				}

				$art_viewed_by = '';

				if (!empty($vox['data']['viewed_by']))
				{
					$art_viewed_by .=
					'<article>
						<main class="tables">
							<ul class="info">
								<li><strong>{$lang.viewed_by}</strong></li>';

					foreach ($vox['data']['viewed_by'] as $value)
						$art_viewed_by .= '<li>@' . $value['username'] . '</li>';

					$art_viewed_by .=
					'		</ul>
						</main>
					</article>';
				}

				$div_changes_history = '';

				if (!empty($vox['data']['changes_history']))
				{
					foreach ($vox['data']['changes_history'] as $value)
					{
						$div_changes_history .= '<div class="history">';

						if ($value['type'] == 'create')
							$div_changes_history .= '<p><span style="background-color:#2196F3;"><i class="fas fa-plus-square"></i></span> ' . $value['user']['name'] . ' ' . $value['user']['lastname'] . ' <strong>{$lang.created}</strong> {$lang.the} ' . Functions::get_formatted_date($value['date'], 'd F Y') . ' {$lang.at} ' . Functions::get_formatted_hour($value['hour'], '+ hrs') . '</p>';
						else if ($value['type'] == 'viewed')
							$div_changes_history .= '<p><span style="background-color:#f44336;"><i class="fas fa-eye"></i></span> ' . $value['user']['name'] . ' ' . $value['user']['lastname'] . ' <strong>{$lang.viewed}</strong> {$lang.the} ' . Functions::get_formatted_date($value['date'], 'd F Y') . ' {$lang.at} ' . Functions::get_formatted_hour($value['hour'], '+ hrs') . '</p>';
						else if ($value['type'] == 'complete')
							$div_changes_history .= '<p><span style="background-color:#4caf50;"><i class="fas fa-check-square"></i></span> ' . $value['user']['name'] . ' ' . $value['user']['lastname'] . ' <strong>{$lang.completed}</strong> {$lang.the} ' . Functions::get_formatted_date($value['date'], 'd F Y') . ' {$lang.at} ' . Functions::get_formatted_hour($value['hour'], '+ hrs') . '</p>';
						else if ($value['type'] == 'reopen')
							$div_changes_history .= '<p><span style="background-color:#ffeb3b;"><i class="fas fa-undo"></i></span> ' . $value['user']['name'] . ' ' . $value['user']['lastname'] . ' <strong>{$lang.reopened}</strong> {$lang.the} ' . Functions::get_formatted_date($value['date'], 'd F Y') . ' {$lang.at} ' . Functions::get_formatted_hour($value['hour'], '+ hrs') . '</p>';
						else if ($value['type'] == 'new_comment')
							$div_changes_history .= '<p><span style="background-color:#9c27b0;"><i class="fas fa-comments"></i></span> ' . $value['user']['name'] . ' ' . $value['user']['lastname'] . ' <strong>{$lang.commented}</strong> {$lang.the} ' . Functions::get_formatted_date($value['date'], 'd F Y') . ' {$lang.at} ' . Functions::get_formatted_hour($value['hour'], '+ hrs') . '</p>';
						else if ($value['type'] == 'edit')
						{
							$div_changes_history .=
							'<p><span style="background-color:#3f51b5;"><i class="fas fa-pen-square"></i></span> ' . $value['user']['name'] . ' ' . $value['user']['lastname'] . ' <strong>{$lang.edited}</strong> {$lang.the} ' . Functions::get_formatted_date($value['date'], 'd F Y') . ' {$lang.at} ' . Functions::get_formatted_hour($value['hour'], '+ hrs') . '</p>
							<ul>';

							foreach ($value['fields'] as $subvalue)
								$div_changes_history .= '<li><strong>{$lang.' . $subvalue['field'] . '}:</strong> ' . $subvalue['before'] . ' <i class="fas fa-arrow-right"></i> ' . $subvalue['after'] . '</li>';

							$div_changes_history .= '</ul>';
						}

						$div_changes_history .= '</div>';
					}
				}

				$replace = [
					'{$type}' => $vox['type'],
					'{$room}' => $vox['data']['room']['name'],
					'{$opportunity_area}' => $vox['data']['opportunity_area']['name'][Session::get_value('settings')['language']],
					'{$opportunity_type}' => $vox['data']['opportunity_type']['name'][Session::get_value('settings')['language']],
					'{$started_date}' => Functions::get_formatted_date($vox['data']['started_date'], 'd F, Y'),
					'{$started_hour}' => Functions::get_formatted_hour($vox['data']['started_hour'], '+ hrs'),
					'{$location}' => $vox['data']['location']['name'][Session::get_value('settings')['language']],
					'{$div_cost}' => ($vox['type'] == 'incident') ? '<div><h3>{$lang.cost}:</h3><div>' . $vox['data']['cost'] . '</div></div>' : '',
					'{$div_urgency}' => $div_urgency,
					'{$div_confidentiality}' => ($vox['type'] == 'incident') ? '<div><h3>{$lang.confidentiality}:</h3><div>' . (($vox['data']['confidentiality'] == true) ? '{$lang.to_yes}' : '{$lang.to_not}') . '</div></div>' : '',
					'{$div_observations}' => ($vox['type'] == 'request') ? '<div><h3>{$lang.observations}:</h3><div>' .  $vox['data']['observations'] . '</div></div>' : '',
					'{$div_subject}' => ($vox['type'] == 'incident') ? '<div><h3>{$lang.subject}:</h3><div>' . $vox['data']['subject'] . '</div></div>' : '',
					'{$div_description}' => ($vox['type'] == 'incident') ? '<div><h3>{$lang.description}:</h3><div>' . $vox['data']['description'] . '</div></div>' : '',
					'{$div_action_taken}' => ($vox['type'] == 'incident') ? '<div><h3>{$lang.action_taken}:</h3><div>' . $vox['data']['action_taken'] . '</div></div>' : '',
					'{$art_attachments}' => $art_attachments,
					'{$art_comments}' => $art_comments,
					'{$art_assigned_users}' => $art_assigned_users,
					'{$art_viewed_by}' => $art_viewed_by,
					'{$guest_treatment}' => $vox['data']['guest_treatment']['name'],
					'{$name}' => $vox['data']['name'],
					'{$lastname}' => $vox['data']['lastname'],
					'{$uli_guest_id}' => ($vox['type'] == 'incident') ? '<li><strong>{$lang.guest_id}:</strong> ' . $vox['data']['guest_id'] . '</li>' : '',
					'{$uli_guest_type}' => ($vox['type'] == 'incident') ? '<li><strong>{$lang.guest_type}:</strong> ' . $vox['data']['guest_type']['name'] . '</li>' : '',
					'{$uli_reservation_number}' => ($vox['type'] == 'incident') ? '<li><strong>{$lang.reservation_number}:</strong> ' . $vox['data']['reservation_number'] . '</li>' : '',
					'{$uli_reservation_status}' => ($vox['type'] == 'incident') ? '<li><strong>{$lang.reservation_status}:</strong> ' . $vox['data']['reservation_status']['name'] . '</li>' : '',
					'{$uli_check_in}' => ($vox['type'] == 'incident') ? '<li><strong>{$lang.check_in}:</strong> ' . Functions::get_formatted_date($vox['data']['check_in'], 'd F, Y') . '</li>' : '',
					'{$uli_check_out}' => ($vox['type'] == 'incident') ? '<li><strong>{$lang.check_out}:</strong> ' . Functions::get_formatted_date($vox['data']['check_out'], 'd F, Y') . '</li>' : '',
					'{$token}' => $vox['data']['token'],
					'{$uli_created_user}' => !empty($vox['data']['created_user']) ? '<li><strong>{$lang.created_by}</strong> ' . $vox['data']['created_user']['name'] . ' ' . $vox['data']['created_user']['lastname'] . ' {$lang.the} ' . Functions::get_formatted_date($vox['data']['created_date'], 'd F, Y') . ' {$lang.at} ' . Functions::get_formatted_hour($vox['data']['created_hour'], '+ hrs') . '</li>' : '',
					'{$uli_edited_user}' => !empty($vox['data']['edited_user']) ? '<li><strong>{$lang.edited_by}</strong> ' . $vox['data']['edited_user']['name'] . ' ' . $vox['data']['edited_user']['lastname'] . ' {$lang.the} ' . Functions::get_formatted_date($vox['data']['edited_date'], 'd F, Y') . ' {$lang.at} ' . Functions::get_formatted_hour($vox['data']['edited_hour'], '+ hrs') . '</li>' : '',
					'{$uli_completed_user}' => !empty($vox['data']['completed_user']) ? '<li><strong>{$lang.completed_by}</strong> ' . $vox['data']['completed_user']['name'] . ' ' . $vox['data']['completed_user']['lastname'] . ' {$lang.the} ' . Functions::get_formatted_date($vox['data']['completed_date'], 'd F, Y') . ' {$lang.at} ' . Functions::get_formatted_hour($vox['data']['completed_hour'], '+ hrs') . '</li>' : '',
					'{$uli_reopened_user}' => !empty($vox['data']['reopened_user']) ? '<li><strong>{$lang.reopened_by}</strong> ' . $vox['data']['reopened_user']['name'] . ' ' . $vox['data']['reopened_user']['lastname'] . ' {$lang.the} ' . Functions::get_formatted_date($vox['data']['reopened_date'], 'd F, Y') . ' {$lang.at} ' . Functions::get_formatted_hour($vox['data']['reopened_hour'], '+ hrs') . '</li>' : '',
					'{$status}' => (($vox['data']['status'] == 'open') ? '{$lang.opened}' : '{$lang.closed}'),
					'{$origin}' => (($vox['data']['origin'] == 'internal') ? '{$lang.internal}' : '{$lang.external}'),
					'{$btn_edit}' => (Functions::check_access(['{voxes_update}']) == true AND $vox['data']['status'] == 'open') ? '<a href="/voxes/edit/' . $vox['id'] . '" class="btn">{$lang.edit}</a>' : '',
					'{$btn_complete}' => (Functions::check_access(['{voxes_complete}']) == true AND $vox['data']['status'] == 'open') ? '<a class="btn" data-button-modal="complete_vox">{$lang.complete}</a>' : '',
					'{$btn_reopen}' => (Functions::check_access(['{voxes_reopen}']) == true AND $vox['data']['status'] == 'close') ? '<a class="btn" data-button-modal="reopen_vox">{$lang.reopen}</a>' : '',
					'{$div_changes_history}' => $div_changes_history,
				];

				$template = $this->format->replace($replace, $template);

				echo $template;
			}
		}
		else
			header('Location: /voxes');
	}

	public function edit($params)
	{
		$vox = $this->model->get_vox($params[0]);

		if (!empty($vox))
		{
			if (Format::exist_ajax_request() == true)
			{
				if ($_POST['action'] == 'get_opt_opportunity_areas')
				{
					$data = '<option value="" selected hidden>{$lang.choose}</option>';

					foreach ($this->model->get_opportunity_areas($_POST['option']) as $value)
						$data .= '<option value="' . $value['id'] . '">' . $value['name'][Session::get_value('settings')['language']] . '</option>';

					Functions::environment([
						'status' => 'success',
						'data' => $data
					]);
				}

				if ($_POST['action'] == 'get_opt_opportunity_types')
				{
					$data = '<option value="" selected hidden>{$lang.choose}</option>';

					foreach ($this->model->get_opportunity_types($_POST['opportunity_area'], $_POST['option']) as $value)
						$data .= '<option value="' . $value['id'] . '">' . $value['name'][Session::get_value('settings')['language']] . '</option>';

					Functions::environment([
						'status' => 'success',
						'data' => $data
					]);
				}

				if ($_POST['action'] == 'get_opt_locations')
				{
					$data = '<option value="" selected hidden>{$lang.choose}</option>';

					foreach ($this->model->get_locations($_POST['option']) as $value)
						$data .= '<option value="' . $value['id'] . '">' . $value['name'][Session::get_value('settings')['language']] . '</option>';

					Functions::environment([
						'status' => 'success',
						'data' => $data
					]);
				}

				if ($_POST['action'] == 'edit_vox')
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

					if (!isset($_POST['urgency']) OR empty($_POST['urgency']))
						array_push($labels, ['urgency','']);

					if ($_POST['type'] == 'request')
					{
						if (!empty($_POST['observations']) AND strlen($_POST['observations']) > 120)
							array_push($labels, ['observations','']);
					}

					if ($_POST['type'] == 'incident')
					{
						if (!empty($_POST['subject']) AND strlen($_POST['subject']) > 120)
							array_push($labels, ['subject','']);
					}

					if (empty($labels))
					{
						$_POST['id'] = $vox['id'];
						$_POST['attachments'] = $_FILES['attachments'];

						$query = $this->model->edit_vox($_POST);

						if (!empty($query))
						{
							Functions::environment([
								'status' => 'success',
								'message' => '{$lang.success_operation_database}',
								'path' => '/voxes/view/' . $vox['id']
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
				define('_title', 'GuestVox | {$lang.edit_vox}');

				$template = $this->view->render($this, 'edit');

				$html =
				'<div class="span3">
					<label class="tmp-1">
						<span>{$lang.request}</span>
						<span><i class="fas fa-hand-peace"></i></span>
						<input type="radio" name="type" value="request" ' . (($vox['type'] == 'request') ? 'checked' : '') . '>
					</label>
					<label class="tmp-1">
						<span>{$lang.incident}</span>
						<span><i class="fas fa-thumbs-down"></i></span>
						<input type="radio" name="type" value="incident" ' . (($vox['type'] == 'incident') ? 'checked' : '') . '>
					</label>
				</div>
				<div class="span3">
					<div class="label">
						<label class="success" important>
							<p>{$lang.room}</p>
							<select name="room">
								<option value="" selected hidden>{$lang.choose}</option>';

				foreach ($this->model->get_rooms() as $value)
					$html .= '<option value="' . $value['id'] . '" ' . (($vox['data']['room']['id'] == $value['id']) ? 'selected' : '') . '>' . $value['name'] . '</option>';

				$html .=
				'			</select>
						</label>
					</div>
				</div>
				<div class="span3">
					<div class="label">
						<label class="success" important>
							<p>{$lang.opportunity_area}</p>
							<select name="opportunity_area">';

				foreach ($this->model->get_opportunity_areas($vox['type']) as $value)
					$html .= '<option value="' . $value['id'] . '"'. (($vox['data']['opportunity_area']['id'] == $value['id']) ? 'selected' : '') . '>' . $value['name'][Session::get_value('settings')['language']] . '</option>';

				$html .=
				'			</select>
						</label>
					</div>
				</div>
				<div class="span3">
					<div class="label">
						<label class="success" important>
							<p>{$lang.opportunity_type}</p>
							<select name="opportunity_type">';

				foreach ($this->model->get_opportunity_types($vox['data']['opportunity_area']['id'], $vox['type']) as $value)
					$html .= '<option value="' . $value['id'] . '"'. (($vox['data']['opportunity_type']['id'] == $value['id']) ? 'selected' : '') . '>' . $value['name'][Session::get_value('settings')['language']] . '</option>';

				$html .=
				'			</select>
						</label>
					</div>
				</div>
				<div class="span3">
					<div class="label">
						<label class="success">
							<p>{$lang.date}</p>
							<input type="text" name="started_date" class="datepicker" placeholder="{$lang.choose}" value="' . $vox['data']['started_date'] . '" />' . '
							<p class="description ' . (($vox['type'] == 'incident') ? 'hidden' : '') . '">{$lang.what_date_need}</p>
							<p class="description ' . (($vox['type'] == 'request') ? 'hidden' : '') . '">{$lang.what_date_happened}</p>
						</label>
					</div>
				</div>
				<div class="span3">
					<div class="label">
						<label class="success">
							<p>{$lang.hour}</p>
							<input type="time" name="started_hour" value="' . $vox['data']['started_hour'] . '" />
							<!-- <div class="time__input">
								<input type="text" name="started_hour" class="timepicker" placeholder="{$lang.choose}" value="' . $vox['data']['started_hour'] . '" />
							</div> -->
							<p class="description ' . (($vox['type'] == 'incident') ? 'hidden' : '') . '">{$lang.what_hour_need}</p>
							<p class="description ' . (($vox['type'] == 'request') ? 'hidden' : '') . '">{$lang.what_hour_happened}</p>
						</label>
					</div>
				</div>
				<div class="span3">
					<div class="label">
						<label class="success" important>
							<p>{$lang.location}</p>
							<select name="location">';

				foreach ($this->model->get_locations($vox['type']) as $value)
					$html .= '<option value="' . $value['id'] . '"'. (($vox['data']['location']['id'] == $value['id']) ? 'selected' : '') . '>' . $value['name'][Session::get_value('settings')['language']] . '</option>';

				$html .=
				'			</select>
							<p class="description ' . (($vox['type'] == 'incident') ? 'hidden' : '') . '">{$lang.when_need}</p>
							<p class="description ' . (($vox['type'] == 'request') ? 'hidden' : '') . '">{$lang.when_happened}</p>
						</label>
					</div>
				</div>
				<div class="span3 ' . (($vox['type'] == 'request') ? 'hidden' : '') . '">
					<div class="label">
						<label class="success">
							<p>{$lang.cost}</p>
							<input type="number" name="cost" value="' . $vox['data']['cost'] . '"/>
							<p class="description">{$lang.how_money_cost}</p>
						</label>
					</div>
				</div>
				<div class="span3">
					<div class="label">
						<label class="success">
							<p>{$lang.urgency}</p>
							<select name="urgency">
								<option value="low" ' . (($vox['data']['urgency'] == 'low') ? 'selected' : '') . '>{$lang.low}</option>
								<option value="medium" ' . (($vox['data']['urgency'] == 'medium') ? 'selected' : '') . '>{$lang.medium}</option>
								<option value="high" ' . (($vox['data']['urgency'] == 'high') ? 'selected' : '') . '>{$lang.high}</option>
							</select>
						</label>
					</div>
				</div>
				<div class="span3 ' . (($vox['type'] == 'request') ? 'hidden' : '') . '">
					<div class="label">
						<label class="success">
							<p>{$lang.confidentiality}</p>
							<div class="switch">
								<input id="confidentiality" type="checkbox" name="confidentiality" class="switch-checkbox" ' . (($vox['data']['confidentiality'] == true) ? 'checked' : '') . '>
								<label class="switch-label" for="confidentiality"></label>
							</div>
						</label>
					</div>
				</div>
				<div class="span3 ' . (($vox['type'] == 'incident') ? 'hidden' : '') . '">
					<div class="label">
						<label class="success">
							<p>{$lang.observations}</p>
							<input type="text" name="observations" value="' . $vox['data']['observations'] . '" maxlength="120" />
							<p class="description">{$lang.max_120_characters}</p>
						</label>
					</div>
				</div>
				<div class="span3 ' . (($vox['type'] == 'request') ? 'hidden' : '') . '">
					<div class="label">
						<label class="success">
							<p>{$lang.subject}</p>
							<input type="text" name="subject" value="' . $vox['data']['subject'] . '" maxlength="120" />
							<p class="description">{$lang.max_120_characters}</p>
						</label>
					</div>
				</div>
				<div class="span3">
					<div class="label">
						<label class="success">
							<p>{$lang.assigned_users}</p>
							<select name="assigned_users[]" class="chosen-select" multiple>';

				foreach ($this->model->get_users() as $value)
				{
					foreach ($vox['data']['assigned_users'] as $subvalue)
						$html .= '<option value="' . $value['id'] . '" ' . (($subvalue['id'] == $value['id']) ? 'selected' : '') . '>' . $value['username'] . '</option>';
				}

				$html .=
				'			</select>
							<p class="description">{$lang.assigned_users_keep_in_mind}</p>
						</label>
					</div>
				</div>
				<div class="span6 ' . (($vox['type'] == 'request') ? 'hidden' : '') . '">
					<div class="label">
						<label class="success">
							<p>{$lang.description}</p>
							<textarea name="description">' . $vox['data']['description'] . '</textarea>
							<p class="description">{$lang.what_happened} {$lang.dont_forget_mention_relevant_details}</p>
						</label>
					</div>
				</div>
				<div class="span6 ' . (($vox['type'] == 'request') ? 'hidden' : '') . '">
					<div class="label">
						<label class="success">
							<p>{$lang.action_taken}</p>
							<textarea name="action_taken">' . $vox['data']['action_taken'] . '</textarea>
							<p class="description">{$lang.what_action_taken}</p>
						</label>
					</div>
				</div>
				<div class="' . (($vox['type'] == 'request') ? 'span3' : 'span2') . '">
					<div class="label">
						<label class="success">
							<p>{$lang.guest_treatment}</p>
							<select name="guest_treatment">
								<option value="" selected hidden>{$lang.choose}</option>';

				foreach ($this->model->get_guest_treatments() as $value)
					$html .= '<option value="' . $value['id'] . '"'. (($vox['data']['guest_treatment']['id'] == $value['id']) ? 'selected' : '') . '>' . $value['name'] . '</option>';

				$html .=
				'			</select>
						</label>
					</div>
				</div>
				<div class="span3 ' . (($vox['type'] == 'request') ? 'hidden' : '') . '">
					<div class="label">
						<label class="success">
							<p>{$lang.firstname}</p>
							<input type="text" name="name" value="' . $vox['data']['name'] . '"/>
						</label>
					</div>
				</div>
				<div class="span3">
					<div class="label">
						<label class="success">
							<p>{$lang.lastname}</p>
							<input type="text" name="lastname" value="' . $vox['data']['lastname'] . '"/>
						</label>
					</div>
				</div>
				<div class="span2 ' . (($vox['type'] == 'request') ? 'hidden' : '') . '">
					<div class="label">
						<label class="success">
							<p>{$lang.guest_id}</p>
							<input type="text" name="guest_id" value="' . $vox['data']['guest_id'] . '"/>
						</label>
					</div>
				</div>
				<div class="span2 ' . (($vox['type'] == 'request') ? 'hidden' : '') . '">
					<div class="label">
						<label class="success">
							<p>{$lang.guest_type}</p>
							<select name="guest_type">
								<option value="" selected hidden>{$lang.choose}</option>';

				foreach ($this->model->get_guest_types() as $value)
					$html .= '<option value="' . $value['id'] . '"'. (($vox['data']['guest_type']['id'] == $value['id']) ? 'selected' : '') . '>' . $value['name'] . '</option>';

				$html .=
				'			</select>
						</label>
					</div>
				</div>
				<div class="span3 ' . (($vox['type'] == 'request') ? 'hidden' : '') . '">
					<div class="label">
						<label class="success">
							<p>{$lang.reservation_number}</p>
							<input type="text" name="reservation_number" value="' . $vox['data']['reservation_number'] . '"/>
						</label>
					</div>
				</div>
				<div class="span3 ' . (($vox['type'] == 'request') ? 'hidden' : '') . '">
					<div class="label">
						<label class="success">
							<p>{$lang.reservation_status}</p>
							<select name="reservation_status">
								<option value="" selected hidden>{$lang.choose}</option>';

				foreach ($this->model->get_reservation_statuss() as $value)
					$html .= '<option value="' . $value['id'] . '"'. (($vox['data']['reservation_status']['id'] == $value['id']) ? 'selected' : '') . '>' . $value['name'] . '</option>';

				$html .=
				'			</select>
						</label>
					</div>
				</div>
				<div class="span3 ' . (($vox['type'] == 'request') ? 'hidden' : '') . '">
					<div class="label">
						<label class="success">
							<p>{$lang.check_in}</p>
							<input type="text" name="check_in" class="datepicker" placeholder="{$lang.choose}" value="' . Functions::get_formatted_date($vox['data']['check_in']) . '"/>
							</label>
					</div>
				</div>
				<div class="span3 ' . (($vox['type'] == 'request') ? 'hidden' : '') . '">
					<div class="label">
						<label class="success">
							<p>{$lang.check_out}</p>
							<input type="text" name="check_out" class="datepicker" placeholder="{$lang.choose}" value="' . Functions::get_formatted_date($vox['data']['check_out']) . '"/>
						</label>
					</div>
				</div>
				<div class="span12">
					<div class="label">
						<label>
							<p>{$lang.attachments}</p>
							<input type="file" name="attachments[]" multiple />
							<!-- <div class="box">
								<input id="input-file" type="file" name="attachments[]" class="inputfile" data-multiple-caption="{count} {$lang.files_selected}" multiple />
								<label for="input-file">
									<span>{$lang.select_file}&hellip;</span>
								</label>
							</div> -->
						</label>
					</div>
				</div>';

				if (!empty($vox['data']['attachments']))
				{
					$html .=
					'<article>
						<main class="tables">';

					foreach ($vox['data']['attachments'] as $value)
					{
						if ($value['status'] == 'success')
						{
							$ext = strtoupper(explode('.', $value['file'])[1]);

							if ($ext == 'JPG' OR $ext == 'JPEG' OR $ext == 'PNG')
								$html .= '<figure class="attachment"><img src="{$path.uploads}' . $value['file'] . '"><a href="{$path.uploads}' . $value['file'] . '" class="fancybox-thumb" rel="fancybox-thumb"></a></figure>';
							else if ($ext == 'PDF' OR $ext == 'DOC' OR $ext == 'DOCX' OR $ext == 'XLS' OR $ext == 'XLSX')
								$html .= '<iframe class="attachment" src="https://docs.google.com/viewer?url=https://guestvox.com/uploads/' . $value['file'] . '&embedded=true"></iframe>';
						}
					}

					$html .=
					'		<div class="clear"></div>
						</main>
					</article>';
				}

				$replace = [
					'{$html}' => $html
				];

				$template = $this->format->replace($replace, $template);

				echo $template;
			}
		}
		else
			header('Location: /voxes');
	}
}
