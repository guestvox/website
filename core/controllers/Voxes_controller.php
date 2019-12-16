<?php

defined('_EXEC') or die;

require_once 'plugins/nexmo/vendor/autoload.php';

class Voxes_controller extends Controller
{
	public function __construct()
	{
		parent::__construct();
	}

	public function index()
	{
		define('_title', 'GuestVox');

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
			'<tr class="' . $value['data']['status'] . ' ' . $value['data']['readed'] . '" data-id="' . $value['id'] . '">';

			if (Session::get_value('account')['type'] == 'hotel')
				$tbl_voxes_unresolve .= '<td align="left" class="touchable">#' . $value['data']['room']['number'] . ' ' . $value['data']['room']['name'] . '</td>';
			else if (Session::get_value('account')['type'] == 'restaurant')
				$tbl_voxes_unresolve .= '<td align="left" class="touchable">#' . $value['data']['table']['number'] . ' ' . $value['data']['table']['name'] . '</td>';

			$tbl_voxes .=
			'	<td align="left" class="touchable">' . $value['data']['firstname'] . ' ' . $value['data']['lastname'] . '</td>
				<td align="left" class="touchable">' . $value['data']['opportunity_area']['name'][Session::get_value('account')['language']] . '</td>
				<td align="left" class="touchable">' . $value['data']['opportunity_type']['name'][Session::get_value('account')['language']] . '</td>
				<td align="left" class="touchable">' . $value['data']['location']['name'][Session::get_value('account')['language']] . '</td>
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
			if ($_POST['action'] == 'get_guest')
			{
				$query = $this->model->get_room($_POST['room']);

				if (!empty($query))
				{
					$query = $this->model->get_guest($query['number']);

					if (!empty($query))
					{
						Functions::environment([
							'status' => 'success',
							'data' => $query
						]);
					}
					else
					{
						Functions::environment([
							'status' => 'error',
							'message' => '{$lang.operation_error}'
						]);
					}
				}
				else
				{
					Functions::environment([
						'status' => 'error',
						'message' => '{$lang.operation_error}'
					]);
				}
			}

			if ($_POST['action'] == 'get_opt_opportunity_areas')
			{
				$data = '<option value="" selected hidden>{$lang.choose}</option>';

				foreach ($this->model->get_opportunity_areas($_POST['option']) as $value)
					$data .= '<option value="' . $value['id'] . '">' . $value['name'][Session::get_value('account')['language']] . '</option>';

				Functions::environment([
					'status' => 'success',
					'data' => $data
				]);
			}

			if ($_POST['action'] == 'get_opt_opportunity_types')
			{
				$data = '<option value="" selected hidden>{$lang.choose}</option>';

				foreach ($this->model->get_opportunity_types($_POST['opportunity_area'], $_POST['option']) as $value)
					$data .= '<option value="' . $value['id'] . '">' . $value['name'][Session::get_value('account')['language']] . '</option>';

				Functions::environment([
					'status' => 'success',
					'data' => $data
				]);
			}

			if ($_POST['action'] == 'get_opt_locations')
			{
				$data = '<option value="" selected hidden>{$lang.choose}</option>';

				foreach ($this->model->get_locations($_POST['option']) as $value)
					$data .= '<option value="' . $value['id'] . '">' . $value['name'][Session::get_value('account')['language']] . '</option>';

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

				// if (Session::get_value('account')['type'] == 'hotel')
				// {
				// 	if (!isset($_POST['room']) OR empty($_POST['room']))
				// 		array_push($labels, ['room','']);
				// }
				// else if (Session::get_value('account')['type'] == 'restaurant')
				// {
				// 	if (!isset($_POST['table']) OR empty($_POST['table']))
				// 		array_push($labels, ['table','']);
				// }

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
				else if ($_POST['type'] == 'incident')
				{
					if (!empty($_POST['subject']) AND strlen($_POST['subject']) > 120)
						array_push($labels, ['subject','']);
				}

				if (empty($labels))
				{
					$_POST['confidentiality'] = !empty($_POST['confidentiality']) ? true : false;
					$_POST['attachments'] = $_FILES['attachments'];

					$query = $this->model->new_vox($_POST);

					if (!empty($query))
					{
						if (!empty($_POST['assigned_users']))
							$_POST['assigned_users'] = $this->model->get_users('assigned_users', $_POST['assigned_users']);
						else
							$_POST['assigned_users'] = $this->model->get_users('opportunity_area', $_POST['opportunity_area']);

						if (Session::get_value('account')['type'] == 'hotel')
						{
							$_POST['room'] = $this->model->get_room($_POST['room']);
							$_POST['room'] = '#' . $_POST['room']['number'] . (!empty($_POST['room']['name']) ? ' - ' . $_POST['room']['name'] : '');
						}
						if (Session::get_value('account')['type'] == 'hotel')
						{
							$_POST['table'] = $this->model->get_table($_POST['table']);
							$_POST['table'] = '#' . $_POST['table']['number'] . (!empty($_POST['table']['name']) ? ' - ' . $_POST['table']['name'] : '');
						}

						$_POST['opportunity_area'] = $this->model->get_opportunity_area($_POST['opportunity_area'])['name'][Session::get_value('account')['language']];
						$_POST['opportunity_type'] = $this->model->get_opportunity_type($_POST['opportunity_type'])['name'][Session::get_value('account')['language']];
						$_POST['location'] = $this->model->get_location($_POST['location'])['name'][Session::get_value('account')['language']];

						$mail = new Mailer(true);

						try
						{
							if (Session::get_value('account')['language'] == 'es')
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
							else if (Session::get_value('account')['language'] == 'en')
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
								$mail->addAddress($value['email'], $value['firstname'] . ' ' . $value['lastname']);

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
							                        <img style="width:100%;max-width:300px;" src="https://' . Configuration::$domain . '/images/logotype-color.png" />
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
							'                   <a style="width:100%;display:block;margin:15px 0px 20px 0px;padding:20px 0px;box-sizing:border-box;font-size:14px;font-weight:400;text-align:center;text-decoration:none;color:#fff;background-color:#201d33;" href="https://' . Configuration::$domain . '/voxes/view/details/' . $query . '">' . $mail_give_follow_up . '</a>
							                </td>
							            </tr>
							            <tr style="width:100%;margin:0px;border:0px;padding:0px;">
							                <td style="width:100%;margin:0px;border:0px;padding:20px;box-sizing:border-box;background-color:#fff;">
							                    <a style="width:100%;display:block;padding:20px 0px;box-sizing:border-box;font-size:14px;font-weight:400;text-align:center;text-decoration:none;color:#201d33;" href="https://' . Configuration::$domain . '">' . Configuration::$domain . '</a>
							                </td>
							            </tr>
							        </table>
							    </body>
							</html>';
							$mail->AltBody = '';
							$mail->send();
						}
						catch (Exception $e) { }

						if (Session::get_value('account')['sms'] > 0)
						{
							$sms_basic  = new \Nexmo\Client\Credentials\Basic('45669cce', 'CR1Vg1bpkviV8Jzc');
							$sms_client = new \Nexmo\Client($sms_basic);

							if (Session::get_value('account')['language'] == 'es')
							{
								if ($_POST['type'] == 'request')
									$sms_subject = 'GuestVox: Nueva petición';
								else if ($_POST['type'] == 'incident')
									$sms_subject = 'GuestVox: Nueva incidencia';

								$sms_room = 'Hab: ';
								$sms_opportunity_area = 'AO: ';
								$sms_opportunity_type = 'TO: ';
								$sms_started_date = 'Fecha: ';
								$sms_started_hour = 'Hr: ';
								$sms_location = 'Ubic: ';

								if (Functions::get_current_date_hour() < Functions::get_formatted_date_hour($_POST['started_date'], $_POST['started_hour']))
									$sms_urgency = 'Urg: Programada';
								else if ($_POST['urgency'] == 'low')
									$sms_urgency = 'Urg: Baja';
								else if ($_POST['urgency'] == 'medium')
									$sms_urgency = 'Urg: Media';
								else if ($_POST['urgency'] == 'high')
									$sms_urgency = 'Urg: Alta';

								if ($_POST['confidentiality'] == true)
									$sms_confidentiality = 'Conf: Si';
								else if ($_POST['confidentiality'] == false)
									$sms_confidentiality = 'Conf: No';

								$sms_observations = 'Obs: ';
								$sms_description = 'Desc: ';
							}
							else if (Session::get_value('account')['language'] == 'en')
							{
								if ($_POST['type'] == 'request')
									$sms_subject = 'GuestVox: New request';
								else if ($_POST['type'] == 'incident')
									$sms_subject = 'GuestVox: New incident';

								$sms_room = 'Room: ';
								$sms_opportunity_area = 'OA: ';
								$sms_opportunity_type = 'OT: ';
								$sms_started_date = 'Date: ';
								$sms_started_hour = 'Hr: ';
								$sms_location = 'Loc: ';

								if (Functions::get_current_date_hour() < Functions::get_formatted_date_hour($_POST['started_date'], $_POST['started_hour']))
									$sms_urgency = 'Urg: Programmed';
								else if ($_POST['urgency'] == 'low')
									$sms_urgency = 'Urg: Low';
								else if ($_POST['urgency'] == 'medium')
									$sms_urgency = 'Urg: Medium';
								else if ($_POST['urgency'] == 'high')
									$sms_urgency = 'Urg: High';

								if ($_POST['confidentiality'] == true)
									$sms_confidentiality = 'Conf: Yes';
								else if ($_POST['confidentiality'] == false)
									$sms_confidentiality = 'Conf: No';

								$sms_observations = 'Obs: ';
								$sms_description = 'Desc: ';
							}

							$sms_text = $sms_subject . $sms_room . $_POST['room'] . ' ' . $sms_opportunity_area . $_POST['opportunity_area'] . ' ' . $sms_opportunity_type . $_POST['opportunity_type'] . ' ' . $sms_started_date . Functions::get_formatted_date($_POST['started_date'], 'd M y') . ' ' . $sms_started_hour . Functions::get_formatted_hour($_POST['started_hour'], '+ hrs') . ' ' . $sms_location . $_POST['location'] . ' ' . $sms_urgency . ' ';

							if ($_POST['type'] == 'request')
								$sms_text .= $sms_observations . $_POST['observations'];
							else if ($_POST['type'] == 'incident')
								$sms_text .= $sms_confidentiality . ' ' . $sms_description . $_POST['description'];

							$tmp = Session::get_value('account');

							foreach ($_POST['assigned_users'] as $value)
							{
								if ($tmp['sms'] > 0)
								{
									$sms_client->message()->send([
										'to' => $value['phone']['lada'] . $value['phone']['number'],
										'from' => 'GuestVox',
										'text' => $sms_text . ' https://' . Configuration::$domain . '/voxes/view/details/' . $query
									]);

									$tmp['sms'] = $tmp['sms'] - 1;
								}
							}

							Session::set_value('account', $tmp);
							$this->model->edit_sms();
						}

						Functions::environment([
							'status' => 'success',
							'message' => '{$lang.operation_success}',
							'path' => '/voxes'
						]);
					}
					else
					{
						Functions::environment([
							'status' => 'error',
							'message' => '{$lang.operation_error}'
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
			define('_title', 'GuestVox');

			$template = $this->view->render($this, 'create');

			$opt_rooms = '';

			foreach ($this->model->get_rooms() as $value)
				$opt_rooms .= '<option value="' . $value['id'] . '">' . $value['name'] . '</option>';

			$opt_opportunity_areas = '';

			foreach ($this->model->get_opportunity_areas('request') as $value)
				$opt_opportunity_areas .= '<option value="' . $value['id'] . '">' . $value['name'][Session::get_value('account')['language']] . '</option>';

			$opt_locations = '';

			foreach ($this->model->get_locations('request') as $value)
				$opt_locations .= '<option value="' . $value['id'] . '">' . $value['name'][Session::get_value('account')['language']] . '</option>';

			$opt_guest_treatments = '';

			foreach ($this->model->get_guest_treatments() as $value)
				$opt_guest_treatments .= '<option value="' . $value['id'] . '">' . $value['name'] . '</option>';

			$opt_guest_types = '';

			foreach ($this->model->get_guest_types() as $value)
				$opt_guest_types .= '<option value="' . $value['id'] . '">' . $value['name'] . '</option>';

			$opt_reservation_status = '';

			foreach ($this->model->get_reservation_statuses() as $value)
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

	public function details($params)
	{
		$vox = $this->model->get_vox($params[0], true);

		if (!empty($vox))
		{
			if (Format::exist_ajax_request() == true)
			{
				if ($_POST['action'] == 'complete_vox')
				{
					$query = $this->model->complete_vox($params[0]);

					if (!empty($query))
					{
						Functions::environment([
							'status' => 'success',
							'message' => '{$lang.operation_success}',
							'path' => '/voxes',
						]);
					}
					else
					{
						Functions::environment([
							'status' => 'error',
							'message' => '{$lang.operation_error}',
						]);
					}
				}

				if ($_POST['action'] == 'reopen_vox')
				{
					$query = $this->model->reopen_vox($params[0]);

					if (!empty($query))
					{
						Functions::environment([
							'status' => 'success',
							'message' => '{$lang.operation_success}',
						]);
					}
					else
					{
						Functions::environment([
							'status' => 'error',
							'message' => '{$lang.operation_error}',
						]);
					}
				}

				if ($_POST['action'] == 'new_vox_comment')
				{
					$labels = [];

					if (!isset($_POST['message']) OR empty($_POST['message']))
						array_push($labels, ['message', '']);

					if (empty($labels))
					{
						$_POST['attachments'] = $_FILES['attachments'];

						$query = $this->model->new_vox_comment($params[0], $_POST);

						if (!empty($query))
						{
							Functions::environment([
								'status' => 'success',
								'message' => '{$lang.operation_success}',
							]);
						}
						else
						{
							Functions::environment([
								'status' => 'error',
								'message' => '{$lang.operation_error}',
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
				define('_title', 'GuestVox');

				$template = $this->view->render($this, 'details');

				if ($vox['data']['status'] == 'open' AND Functions::get_current_date_hour() < Functions::get_formatted_date_hour($vox['data']['started_date'], $vox['data']['started_hour']))
					$h4_urgency = '<h4>{$lang.urgency}: {$lang.programmed}</h4>';
				else if ($vox['data']['urgency'] == 'low')
					$h4_urgency = '<h4 style="background-color:#4caf50;color:#fff;">{$lang.urgency}: {$lang.low}</h4>';
				else if ($vox['data']['urgency'] == 'medium')
					$h4_urgency = '<h4 style="background-color:#ffc107;color:#fff;">{$lang.urgency}: {$lang.medium}</h4>';
				else if ($vox['data']['urgency'] == 'high')
					$h4_urgency = '<h4 style="background-color:#f44336;color:#fff;">{$lang.urgency}: {$lang.high}</h4>';

				$div_attachments = '';

				if (!empty($vox['data']['attachments']))
				{
					$div_attachments .=
					'<div class="attachments">';

					foreach ($vox['data']['attachments'] as $value)
					{
						if ($value['status'] == 'success')
						{
							$ext = strtoupper(explode('.', $value['file'])[1]);

							if ($ext == 'JPG' OR $ext == 'JPEG' OR $ext == 'PNG')
								$div_attachments .= '<figure class="attachment"><img src="{$path.uploads}' . $value['file'] . '"><a href="{$path.uploads}' . $value['file'] . '" class="fancybox-thumb" rel="fancybox-thumb"></a></figure>';
							else if ($ext == 'PDF' OR $ext == 'DOC' OR $ext == 'DOCX' OR $ext == 'XLS' OR $ext == 'XLSX')
								$div_attachments .= '<iframe class="attachment" src="https://docs.google.com/viewer?url=https://' . Configuration::$domain . '/uploads/' . $value['file'] . '&embedded=true"></iframe>';
						}
					}

					$div_attachments .=
					'</div>';
				}

				$div_comments = '';

				if (!empty($vox['data']['comments']) OR $vox['data']['status'] == 'open')
				{
					$div_comments .=
					'<div class="comments">';

					if (!empty($vox['data']['comments']))
					{
						foreach ($vox['data']['comments'] as $value)
						{
							$div_comments .=
							'<article>
								<header>
									<p><i class="fas fa-comment-alt"></i>' . $value['message'] . '</p>
								</header>
								<main>';

							if (!empty($value['attachments']))
							{
								foreach ($value['attachments'] as $subvalue)
								{
									if ($subvalue['status'] == 'success')
									{
										$ext = strtoupper(explode('.', $subvalue['file'])[1]);

										if ($ext == 'JPG' OR $ext == 'JPEG' OR $ext == 'PNG')
											$div_comments .= '<figure class="attachment"><img src="{$path.uploads}' . $subvalue['file'] . '"><a href="{$path.uploads}' . $subvalue['file'] . '" class="fancybox-thumb" rel="fancybox-thumb"></a></figure>';
										else if ($ext == 'PDF' OR $ext == 'DOC' OR $ext == 'DOCX' OR $ext == 'XLS' OR $ext == 'XLSX')
											$div_comments .= '<iframe class="attachment" src="https://docs.google.com/viewer?url=https://guestvox.com/uploads/' . $subvalue['file'] . '&embedded=true"></iframe>';
									}
								}
							}

							$div_comments .=
							'	</main>
								<footer>
									<figure>
										<img src="' . (!empty($value['user']['avatar']) ? '{$path.uploads}' . $value['user']['avatar'] : '{$path.images}avatar.png') . '" />
									</figure>
									<span>' . $value['user']['firstname'] . ' ' . $value['user']['lastname'] . '</span>
									<span>{$lang.commented_at_day}: ' . Functions::get_formatted_date($value['date'], 'd M, y') . ' {$lang.at} ' . Functions::get_formatted_hour($value['hour'], '+ hrs') . '</span>';

							if ($vox['data']['status'] == 'open')
								$div_comments .= '<a data-response-to="' . $value['user']['username'] . '" data-button-modal="new_vox_comment"><i class="fas fa-comments"></i></a>';

							$div_comments .=
							'	</footer>
							</article>';
						}
					}

					if ($vox['data']['status'] == 'open')
					{
						$div_comments .=
						'<a data-button-modal="new_vox_comment"><i class="fas fa-comment-alt"></i></a></footer>';
					}

					$div_comments .=
					'</div>';
				}

				$div_assigned_users = '';

				if (!empty($vox['data']['assigned_users']))
				{
					$div_assigned_users .=
					'<div class="assigned_users">
						<h4><i class="fas fa-users"></i>{$lang.assigned_users}</h4>';

					foreach ($vox['data']['assigned_users'] as $value)
					{
						if (!empty($value))
						{
							$div_assigned_users .=
							'<div>
								<figure>
									<img src="' . (!empty($value['avatar']) ? '{$path.uploads}' . $value['avatar'] : '{$path.images}avatar.png') . '" />
								</figure>
								<span>' . $value['firstname'] . ' ' . $value['lastname'] . '</span>
							</div>';
						}
					}

					$div_assigned_users .=
					'</div>';
				}

				$div_viewed_by = '';

				if (!empty($vox['data']['viewed_by']))
				{
					$div_viewed_by .=
					'<div class="viewed_by">
						<h4><i class="fas fa-eye"></i>{$lang.viewed_by}</h4>';

					foreach ($vox['data']['viewed_by'] as $value)
					{
						if (!empty($value))
						{
							$div_viewed_by .=
							'<div>
								<figure>
									<img src="' . (!empty($value['avatar']) ? '{$path.uploads}' . $value['avatar'] : '{$path.images}avatar.png') . '" />
								</figure>
								<span>' . $value['firstname'] . ' ' . $value['lastname'] . '</span>
							</div>';
						}
					}

					$div_viewed_by .=
					'</div>';
				}

				$h4_created_user = '';

				if (!empty($vox['data']['created_user']))
				{
					if ($vox['data']['origin'] == 'internal')
						$h4_created_user = '<h4>{$lang.created_by} ' . $vox['data']['created_user']['firstname'] . ' ' . $vox['data']['created_user']['lastname'] . ' {$lang.the} ' . Functions::get_formatted_date($vox['data']['created_date'], 'd F, Y') . ' {$lang.at} ' . Functions::get_formatted_hour($vox['data']['created_hour'], '+ hrs') . '</h4>';
					else if ($vox['data']['origin'] == 'external')
					{
						if ($vox['data']['created_user'][0] == 'myvox')
							$h4_created_user = '<h4>{$lang.created_by} GuestVox {$lang.the} ' . Functions::get_formatted_date($vox['data']['created_date'], 'd F, Y') . ' {$lang.at} ' . Functions::get_formatted_hour($vox['data']['created_hour'], '+ hrs') . '</h4>';
						else if ($vox['data']['created_user'][0] == 'zavia')
							$h4_created_user = '<h4>{$lang.created_by} Zavia PMS {$lang.the} ' . Functions::get_formatted_date($vox['data']['created_date'], 'd F, Y') . ' {$lang.at} ' . Functions::get_formatted_hour($vox['data']['created_hour'], '+ hrs') . '</h4>';
					}
				}

				$h4_completed_user = '';

				if (!empty($vox['data']['completed_user']))
				{
					if ($vox['data']['origin'] == 'internal')
						$h4_completed_user = '<h4>{$lang.completed_by} ' . $vox['data']['completed_user']['firstname'] . ' ' . $vox['data']['completed_user']['lastname'] . ' {$lang.the} ' . Functions::get_formatted_date($vox['data']['completed_date'], 'd F, Y') . ' {$lang.at} ' . Functions::get_formatted_hour($vox['data']['completed_hour'], '+ hrs') . '</h4>';
					else if ($vox['data']['origin'] == 'external')
					{
						if ($vox['data']['created_user'][0] == 'myvox')
							$h4_completed_user = '<h4>{$lang.completed_by} GuestVox {$lang.the} ' . Functions::get_formatted_date($vox['data']['completed_date'], 'd F, Y') . ' {$lang.at} ' . Functions::get_formatted_hour($vox['data']['completed_hour'], '+ hrs') . '</h4>';
						else if ($vox['data']['created_user'][0] == 'zavia')
							$h4_completed_user = '<h4>{$lang.completed_by} Zavia PMS {$lang.the} ' . Functions::get_formatted_date($vox['data']['completed_date'], 'd F, Y') . ' {$lang.at} ' . Functions::get_formatted_hour($vox['data']['completed_hour'], '+ hrs') . '</h4>';
					}
				}

				$replace = [
					'{$id}' => $vox['id'],
					'{$type}' => $vox['type'],
					'{$room}' => $vox['data']['room']['name'],
					'{$opportunity_area}' => $vox['data']['opportunity_area']['name'][Session::get_value('account')['language']],
					'{$opportunity_type}' => $vox['data']['opportunity_type']['name'][Session::get_value('account')['language']],
					'{$started_date}' => Functions::get_formatted_date($vox['data']['started_date'], 'd F, Y'),
					'{$started_hour}' => Functions::get_formatted_hour($vox['data']['started_hour'], '+ hrs'),
					'{$location}' => $vox['data']['location']['name'][Session::get_value('account')['language']],
					'{$h4_cost}' => ($vox['type'] == 'incident') ? '<h4>{$lang.cost}: ' . Functions::get_formatted_currency($vox['data']['cost'], Session::get_value('account')['currency']) . '</h4>' : '',
					'{$h4_urgency}' => $h4_urgency,
					'{$h4_confidentiality}' => ($vox['type'] == 'incident') ? '<h4 ' . (($vox['data']['confidentiality'] == true) ? 'style="background-color:#f44336;color:#fff;"' : '') . '>{$lang.confidentiality}: ' . (($vox['data']['confidentiality'] == true) ? '{$lang.to_yes}' : '{$lang.to_not}') . '</h4>' : '',
					'{$h4_observations}' => ($vox['type'] == 'request') ? '<h4>{$lang.observations}: ' .  $vox['data']['observations'] . '</h4>' : '',
					'{$h4_subject}' => ($vox['type'] == 'incident') ? '<h4>{$lang.subject}: ' . $vox['data']['subject'] . '</h4>' : '',
					'{$h4_description}' => ($vox['type'] == 'incident') ? '<h4>{$lang.description}: ' . $vox['data']['description'] . '</h4>' : '',
					'{$h4_action_taken}' => ($vox['type'] == 'incident') ? '<h4>{$lang.action_taken}: ' . $vox['data']['action_taken'] . '</h4>' : '',
					'{$div_attachments}' => $div_attachments,
					'{$div_comments}' => $div_comments,
					'{$div_assigned_users}' => $div_assigned_users,
					'{$div_viewed_by}' => $div_viewed_by,
					'{$guest_treatment}' => $vox['data']['guest_treatment']['name'],
					'{$firstname}' => $vox['data']['firstname'],
					'{$lastname}' => $vox['data']['lastname'],
					'{$h4_guest_id}' => ($vox['type'] == 'incident') ? '<h4>{$lang.guest_id}: ' . $vox['data']['guest_id'] . '</h4>' : '',
					'{$h4_guest_type}' => ($vox['type'] == 'incident') ? '<h4>{$lang.guest_type}: ' . $vox['data']['guest_type']['name'] . '</h4>' : '',
					'{$h4_reservation_number}' => ($vox['type'] == 'incident') ? '<h4>{$lang.reservation_number}: ' . $vox['data']['reservation_number'] . '</h4>' : '',
					'{$h4_reservation_status}' => ($vox['type'] == 'incident') ? '<h4>{$lang.reservation_status}: ' . $vox['data']['reservation_status']['name'] . '</h4>' : '',
					'{$h4_check_in}' => ($vox['type'] == 'incident') ? '<h4>{$lang.check_in}: ' . Functions::get_formatted_date($vox['data']['check_in'], 'd F, Y') . '</h4>' : '',
					'{$h4_check_out}' => ($vox['type'] == 'incident') ? '<h4>{$lang.check_out}: ' . Functions::get_formatted_date($vox['data']['check_out'], 'd F, Y') . '</h4>' : '',
					'{$token}' => $vox['data']['token'],
					'{$h4_created_user}' => $h4_created_user,
					'{$h4_edited_user}' => !empty($vox['data']['edited_user']) ? '<h4>{$lang.edited_by} ' . $vox['data']['edited_user']['firstname'] . ' ' . $vox['data']['edited_user']['lastname'] . ' {$lang.the} ' . Functions::get_formatted_date($vox['data']['edited_date'], 'd F, Y') . ' {$lang.at} ' . Functions::get_formatted_hour($vox['data']['edited_hour'], '+ hrs') . '</h4>' : '',
					'{$h4_completed_user}' =>  $h4_completed_user,
					'{$h4_reopened_user}' => !empty($vox['data']['reopened_user']) ? '<h4>{$lang.reopened_by} ' . $vox['data']['reopened_user']['firstname'] . ' ' . $vox['data']['reopened_user']['lastname'] . ' {$lang.the} ' . Functions::get_formatted_date($vox['data']['reopened_date'], 'd F, Y') . ' {$lang.at} ' . Functions::get_formatted_hour($vox['data']['reopened_hour'], '+ hrs') . '</h4>' : '',
					'{$status}' => (($vox['data']['status'] == 'open') ? '{$lang.opened}' : '{$lang.closed}'),
					'{$origin}' => (($vox['data']['origin'] == 'internal') ? '{$lang.internal}' : '{$lang.external}'),
					'{$btn_reopen}' => (Functions::check_user_access(['{voxes_reopen}']) == true AND $vox['data']['status'] == 'close') ? '<a data-button-modal="reopen_vox"><i class="fas fa-redo-alt"></i></a>' : '',
					'{$btn_complete}' => (Functions::check_user_access(['{voxes_complete}']) == true AND $vox['data']['status'] == 'open') ? '<a data-button-modal="complete_vox"><i class="fas fa-check"></i></a>' : '',
					'{$btn_edit}' => (Functions::check_user_access(['{voxes_update}']) == true AND $vox['data']['status'] == 'open') ? '<a href="/voxes/edit/' . $vox['id'] . '" class="edit"><i class="fas fa-pen"></i></a>' : '',
				];

				$template = $this->format->replace($replace, $template);

				echo $template;
			}
		}
		else
			header('Location: /voxes');
	}

	public function history($params)
	{
		$vox = $this->model->get_vox($params[0], true);

		if (!empty($vox))
		{
			define('_title', 'GuestVox');

			$template = $this->view->render($this, 'history');

			$div_changes = '';

			if (!empty($vox['data']['changes_history']))
			{
				foreach ($vox['data']['changes_history'] as $value)
				{
					if (!empty($value['user']))
					{
						if ($value['type'] == 'create' OR $value['type'] == 'complete')
						{
							if ($vox['data']['origin'] == 'internal')
							{
								$avatar = !empty($value['user']['avatar']) ? '{$path.uploads}' . $value['user']['avatar'] : '{$path.images}avatar.png';
								$user = $value['user']['firstname'] . ' ' . $value['user']['lastname'];
							}
							else if ($vox['data']['origin'] == 'external')
							{
								if ($vox['data']['created_user'][0] == 'myvox')
								{
									$avatar = '{$path.images}icon-color.svg';
									$user = 'GuestVox';
								}
								else if ($vox['data']['created_user'][0] == 'zavia')
								{
									$avatar = '{$path.images}avatar.png';
									$user = 'Zavia PMS';
								}
							}
						}
						else
						{
							$avatar = !empty($value['user']['avatar']) ? '{$path.uploads}' . $value['user']['avatar'] : '{$path.images}avatar.png';
							$user = $value['user']['firstname'] . ' ' . $value['user']['lastname'];
						}

						$div_changes .=
						'<div>
							<figure>
								<img src="' . $avatar . '" />
							</figure>
							<span>' . $user . '</span>';

						if ($value['type'] == 'create')
							$div_changes .= '<p>{$lang.created} {$lang.the} ' . Functions::get_formatted_date($value['date'], 'd F Y') . ' {$lang.at} ' . Functions::get_formatted_hour($value['hour'], '+ hrs') . '</p>';
						else if ($value['type'] == 'viewed')
							$div_changes .= '<p>{$lang.viewed} {$lang.the} ' . Functions::get_formatted_date($value['date'], 'd F Y') . ' {$lang.at} ' . Functions::get_formatted_hour($value['hour'], '+ hrs') . '</p>';
						else if ($value['type'] == 'complete')
							$div_changes .= '<p>{$lang.completed} {$lang.the} ' . Functions::get_formatted_date($value['date'], 'd F Y') . ' {$lang.at} ' . Functions::get_formatted_hour($value['hour'], '+ hrs') . '</p>';
						else if ($value['type'] == 'reopen')
							$div_changes .= '<p>{$lang.reopened} {$lang.the} ' . Functions::get_formatted_date($value['date'], 'd F Y') . ' {$lang.at} ' . Functions::get_formatted_hour($value['hour'], '+ hrs') . '</p>';
						else if ($value['type'] == 'new_comment')
							$div_changes .= '<p>{$lang.commented} {$lang.the} ' . Functions::get_formatted_date($value['date'], 'd F Y') . ' {$lang.at} ' . Functions::get_formatted_hour($value['hour'], '+ hrs') . '</p>';
						else if ($value['type'] == 'edit')
						{
							$div_changes .=
							'<p>{$lang.edited} {$lang.the} ' . Functions::get_formatted_date($value['date'], 'd F Y') . ' {$lang.at} ' . Functions::get_formatted_hour($value['hour'], '+ hrs') . '</p>
							<ul>';

							foreach ($value['fields'] as $subvalue)
							{
								$div_changes .=
								'<li>{$lang.' . $subvalue['field'] . '}: ' . $subvalue['before'] . ' / ' . $subvalue['after'] . '</li>';
							}

							$div_changes .=
							'</ul>';
						}

						$div_changes .=
						'</div>';
					}
				}
			}

			$replace = [
				'{$id}' => $vox['id'],
				'{$div_changes}' => $div_changes,
			];

			$template = $this->format->replace($replace, $template);

			echo $template;
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
				if ($_POST['action'] == 'get_guest')
				{
					$query = $this->model->get_room($_POST['room']);

					if (!empty($query))
					{
						$query = $this->model->get_guest($query['folio']);

						if (!empty($query))
						{
							Functions::environment([
								'status' => 'success',
								'data' => $query
							]);
						}
						else
						{
							Functions::environment([
								'status' => 'error',
								'message' => '{$lang.operation_error}'
							]);
						}
					}
					else
					{
						Functions::environment([
							'status' => 'error',
							'message' => '{$lang.operation_error}'
						]);
					}
				}

				if ($_POST['action'] == 'get_opt_opportunity_areas')
				{
					$data = '<option value="" selected hidden>{$lang.choose}</option>';

					foreach ($this->model->get_opportunity_areas($_POST['option']) as $value)
						$data .= '<option value="' . $value['id'] . '">' . $value['name'][Session::get_value('account')['language']] . '</option>';

					Functions::environment([
						'status' => 'success',
						'data' => $data
					]);
				}

				if ($_POST['action'] == 'get_opt_opportunity_types')
				{
					$data = '<option value="" selected hidden>{$lang.choose}</option>';

					foreach ($this->model->get_opportunity_types($_POST['opportunity_area'], $_POST['option']) as $value)
						$data .= '<option value="' . $value['id'] . '">' . $value['name'][Session::get_value('account')['language']] . '</option>';

					Functions::environment([
						'status' => 'success',
						'data' => $data
					]);
				}

				if ($_POST['action'] == 'get_opt_locations')
				{
					$data = '<option value="" selected hidden>{$lang.choose}</option>';

					foreach ($this->model->get_locations($_POST['option']) as $value)
						$data .= '<option value="' . $value['id'] . '">' . $value['name'][Session::get_value('account')['language']] . '</option>';

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
						$_POST['confidentiality'] = !empty($_POST['confidentiality']) ? true : false;
						$_POST['attachments'] = $_FILES['attachments'];

						$query = $this->model->edit_vox($_POST);

						if (!empty($query))
						{
							Functions::environment([
								'status' => 'success',
								'message' => '{$lang.operation_success}',
								'path' => '/voxes/view/details/' . $vox['id']
							]);
						}
						else
						{
							Functions::environment([
								'status' => 'error',
								'message' => '{$lang.operation_error}'
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
				define('_title', 'GuestVox');

				$template = $this->view->render($this, 'edit');

				$lbl_edit_vox =
				'<div class="tmp-1">
					<label>
						<span>{$lang.request}</span>
						<span><i class="fas fa-hand-peace"></i></span>
						<input type="radio" name="type" value="request" ' . (($vox['type'] == 'request') ? 'checked' : '') . '>
					</label>
					<label>
						<span>{$lang.incident}</span>
						<span><i class="fas fa-thumbs-down"></i></span>
						<input type="radio" name="type" value="incident" ' . (($vox['type'] == 'incident') ? 'checked' : '') . '>
					</label>
				</div>
				<div class="span3">
					<div class="label">
						<label>
							<p>{$lang.room}</p>
							<select name="room">
								<option value="" selected hidden>{$lang.choose}</option>';

				foreach ($this->model->get_rooms() as $value)
					$lbl_edit_vox .= '<option value="' . $value['id'] . '" ' . (($vox['data']['room']['id'] == $value['id']) ? 'selected' : '') . '>' . $value['name'] . '</option>';

				$lbl_edit_vox .=
				'			</select>
						</label>
					</div>
				</div>
				<div class="span3">
					<div class="label">
						<label important>
							<p>{$lang.opportunity_area}</p>
							<select name="opportunity_area">';

				foreach ($this->model->get_opportunity_areas($vox['type']) as $value)
					$lbl_edit_vox .= '<option value="' . $value['id'] . '"'. (($vox['data']['opportunity_area']['id'] == $value['id']) ? 'selected' : '') . '>' . $value['name'][Session::get_value('account')['language']] . '</option>';

				$lbl_edit_vox .=
				'			</select>
						</label>
					</div>
				</div>
				<div class="span3">
					<div class="label">
						<label important>
							<p>{$lang.opportunity_type}</p>
							<select name="opportunity_type">';

				foreach ($this->model->get_opportunity_types($vox['data']['opportunity_area']['id'], $vox['type']) as $value)
					$lbl_edit_vox .= '<option value="' . $value['id'] . '"'. (($vox['data']['opportunity_type']['id'] == $value['id']) ? 'selected' : '') . '>' . $value['name'][Session::get_value('account')['language']] . '</option>';

				$lbl_edit_vox .=
				'			</select>
						</label>
					</div>
				</div>
				<div class="span3">
					<div class="label">
						<label>
							<p>{$lang.date}</p>
							<input type="date" name="started_date" value="' . $vox['data']['started_date'] . '" />' . '
						</label>
					</div>
				</div>
				<div class="span3">
					<div class="label">
						<label>
							<p>{$lang.hour}</p>
							<input type="time" name="started_hour" value="' . $vox['data']['started_hour'] . '" />
						</label>
					</div>
				</div>
				<div class="span3">
					<div class="label">
						<label important>
							<p>{$lang.location}</p>
							<select name="location">';

				foreach ($this->model->get_locations($vox['type']) as $value)
					$lbl_edit_vox .= '<option value="' . $value['id'] . '"'. (($vox['data']['location']['id'] == $value['id']) ? 'selected' : '') . '>' . $value['name'][Session::get_value('account')['language']] . '</option>';

				$lbl_edit_vox .=
				'			</select>
						</label>
					</div>
				</div>
				<div class="span3 ' . (($vox['type'] == 'request') ? 'hidden' : '') . '">
					<div class="label">
						<label>
							<p>{$lang.cost}</p>
							<input type="number" name="cost" value="' . $vox['data']['cost'] . '"/>
						</label>
					</div>
				</div>
				<div class="span3">
					<div class="label">
						<label>
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
						<label>
							<p>{$lang.confidentiality}</p>
							<div class="switch">
								<input id="confidentiality" type="checkbox" name="confidentiality" class="switch-input" ' . (($vox['data']['confidentiality'] == true) ? 'checked' : '') . '>
								<label class="switch-label" for="confidentiality"></label>
							</div>
						</label>
					</div>
				</div>
				<div class="span3 ' . (($vox['type'] == 'incident') ? 'hidden' : '') . '">
					<div class="label">
						<label>
							<p>{$lang.observations}</p>
							<input type="text" name="observations" value="' . $vox['data']['observations'] . '" maxlength="120" />
						</label>
					</div>
				</div>
				<div class="span3 ' . (($vox['type'] == 'request') ? 'hidden' : '') . '">
					<div class="label">
						<label>
							<p>{$lang.subject}</p>
							<input type="text" name="subject" value="' . $vox['data']['subject'] . '" maxlength="120" />
						</label>
					</div>
				</div>
				<div class="span3">
					<div class="label">
						<label>
							<p>{$lang.assigned_users}</p>
							<select name="assigned_users[]" class="chosen-select" multiple>';

				foreach ($this->model->get_users() as $value)
				{
					foreach ($vox['data']['assigned_users'] as $subvalue)
						$lbl_edit_vox .= '<option value="' . $value['id'] . '" ' . (($subvalue['id'] == $value['id']) ? 'selected' : '') . '>' . $value['username'] . '</option>';
				}

				$lbl_edit_vox .=
				'			</select>
						</label>
					</div>
				</div>
				<div class="span6 ' . (($vox['type'] == 'request') ? 'hidden' : '') . '">
					<div class="label">
						<label>
							<p>{$lang.description}</p>
							<textarea name="description">' . $vox['data']['description'] . '</textarea>
						</label>
					</div>
				</div>
				<div class="span6 ' . (($vox['type'] == 'request') ? 'hidden' : '') . '">
					<div class="label">
						<label>
							<p>{$lang.action_taken}</p>
							<textarea name="action_taken">' . $vox['data']['action_taken'] . '</textarea>
						</label>
					</div>
				</div>
				<div class="' . (($vox['type'] == 'request') ? 'span3' : 'span2') . '">
					<div class="label">
						<label>
							<p>{$lang.guest_treatment}</p>
							<select name="guest_treatment">
								<option value="" selected hidden>{$lang.choose}</option>';

				foreach ($this->model->get_guest_treatments() as $value)
					$lbl_edit_vox .= '<option value="' . $value['id'] . '"'. (($vox['data']['guest_treatment']['id'] == $value['id']) ? 'selected' : '') . '>' . $value['name'] . '</option>';

				$lbl_edit_vox .=
				'			</select>
						</label>
					</div>
				</div>
				<div class="span3">
					<div class="label">
						<label>
							<p>{$lang.firstname}</p>
							<input type="text" name="firstname" value="' . $vox['data']['firstname'] . '"/>
						</label>
					</div>
				</div>
				<div class="span3">
					<div class="label">
						<label>
							<p>{$lang.lastname}</p>
							<input type="text" name="lastname" value="' . $vox['data']['lastname'] . '"/>
						</label>
					</div>
				</div>
				<div class="span2 ' . (($vox['type'] == 'request') ? 'hidden' : '') . '">
					<div class="label">
						<label>
							<p>{$lang.guest_id}</p>
							<input type="text" name="guest_id" value="' . $vox['data']['guest_id'] . '"/>
						</label>
					</div>
				</div>
				<div class="span2 ' . (($vox['type'] == 'request') ? 'hidden' : '') . '">
					<div class="label">
						<label>
							<p>{$lang.guest_type}</p>
							<select name="guest_type">
								<option value="" selected hidden>{$lang.choose}</option>';

				foreach ($this->model->get_guest_types() as $value)
					$lbl_edit_vox .= '<option value="' . $value['id'] . '"'. (($vox['data']['guest_type']['id'] == $value['id']) ? 'selected' : '') . '>' . $value['name'] . '</option>';

				$lbl_edit_vox .=
				'			</select>
						</label>
					</div>
				</div>
				<div class="span3 ' . (($vox['type'] == 'request') ? 'hidden' : '') . '">
					<div class="label">
						<label>
							<p>{$lang.reservation_number}</p>
							<input type="text" name="reservation_number" value="' . $vox['data']['reservation_number'] . '"/>
						</label>
					</div>
				</div>
				<div class="span3 ' . (($vox['type'] == 'request') ? 'hidden' : '') . '">
					<div class="label">
						<label>
							<p>{$lang.reservation_statuses}</p>
							<select name="reservation_status">
								<option value="" selected hidden>{$lang.choose}</option>';

				foreach ($this->model->get_reservation_statuses() as $value)
					$lbl_edit_vox .= '<option value="' . $value['id'] . '"'. (($vox['data']['reservation_status']['id'] == $value['id']) ? 'selected' : '') . '>' . $value['name'] . '</option>';

				$lbl_edit_vox .=
				'			</select>
						</label>
					</div>
				</div>
				<div class="span3 ' . (($vox['type'] == 'request') ? 'hidden' : '') . '">
					<div class="label">
						<label>
							<p>{$lang.check_in}</p>
							<input type="date" name="check_in" value="' . Functions::get_formatted_date($vox['data']['check_in']) . '"/>
						</label>
					</div>
				</div>
				<div class="span3 ' . (($vox['type'] == 'request') ? 'hidden' : '') . '">
					<div class="label">
						<label>
							<p>{$lang.check_out}</p>
							<input type="date" name="check_out" value="' . Functions::get_formatted_date($vox['data']['check_out']) . '"/>
						</label>
					</div>
				</div>
				<div class="span12">
					<div class="label">
						<label>
							<p>{$lang.attachments}</p>
							<input type="file" name="attachments[]" multiple />
						</label>
					</div>
				</div>';

				$replace = [
					'{$lbl_edit_vox}' => $lbl_edit_vox
				];

				$template = $this->format->replace($replace, $template);

				echo $template;
			}
		}
		else
			header('Location: /voxes');
	}

	public function reports()
	{
		if (Format::exist_ajax_request() == true)
		{
			if ($_POST['action'] == 'get_opt_opportunity_areas')
			{
				$data = '<option value="all">{$lang.all}</option>';

				foreach ($this->model->get_opportunity_areas($_POST['option']) as $value)
					$data .= '<option value="' . $value['id'] . '">' . $value['name'][Session::get_value('account')['language']] . '</option>';

				Functions::environment([
					'status' => 'success',
					'data' => $data
				]);
			}

			if ($_POST['action'] == 'get_opt_opportunity_types')
			{
				$data = '<option value="all">{$lang.all}</option>';

				foreach ($this->model->get_opportunity_types($_POST['opportunity_area'], $_POST['option']) as $value)
					$data .= '<option value="' . $value['id'] . '">' . $value['name'][Session::get_value('account')['language']] . '</option>';

				Functions::environment([
					'status' => 'success',
					'data' => $data
				]);
			}

			if ($_POST['action'] == 'get_opt_locations')
			{
				$data = '<option value="all">{$lang.all}</option>';

				foreach ($this->model->get_locations($_POST['option']) as $value)
					$data .= '<option value="' . $value['id'] . '">' . $value['name'][Session::get_value('account')['language']] . '</option>';

				Functions::environment([
					'status' => 'success',
					'data' => $data
				]);
			}

			if ($_POST['action'] == 'get_cbx_addressed_to_opportunity_areas')
			{
				$data =
				'<div>
					<input type="checkbox" name="checked_all">
					<span>{$lang.all}</span>
				</div>';

				foreach ($this->model->get_opportunity_areas($_POST['option']) as $value)
				{
					$data .=
					'<div>
						<input type="checkbox" name="addressed_to_opportunity_areas[]" value="' . $value['id'] . '">
						<span>' . $value['name'][Session::get_value('account')['language']] . '</span>
					</div>';
				}

				Functions::environment([
					'status' => 'success',
					'data' => $data
				]);
			}

			if ($_POST['action'] == 'get_cbx_fields')
			{
				$data =
				'<div>
					<input type="checkbox" name="checked_all">
					<span>{$lang.all}</span>
				</div>';

				foreach ($this->model->get_vox_report_fields($_POST['option']) as $value)
				{
					$data .=
					'<div>
						<input type="checkbox" name="fields[]" value="' . $value['id'] . '">
						<span>{$lang.' . $value['name'] . '}</span>
					</div>';
				}

				Functions::environment([
					'status' => 'success',
					'data' => $data
				]);
			}

			if ($_POST['action'] == 'get_vox_report')
			{
				$query = $this->model->get_vox_report($_POST['id']);

				if (!empty($query))
				{
					Functions::environment([
						'status' => 'success',
						'data' => $query,
					]);
				}
				else
				{
					Functions::environment([
						'status' => 'error',
						'message' => '{$lang.operation_error}',
					]);
				}
			}

			if ($_POST['action'] == 'new_vox_report' OR $_POST['action'] == 'edit_vox_report')
			{
				$labels = [];

				if (!isset($_POST['name']) OR empty($_POST['name']))
					array_push($labels, ['name', '']);

				if (!isset($_POST['type']) OR empty($_POST['type']))
					array_push($labels, ['type', '']);

				if (!isset($_POST['opportunity_area']) OR empty($_POST['opportunity_area']))
					array_push($labels, ['opportunity_area', '']);

				if (!isset($_POST['opportunity_type']) OR empty($_POST['opportunity_type']))
					array_push($labels, ['opportunity_type', '']);

				if (!isset($_POST['room']) OR empty($_POST['room']))
					array_push($labels, ['room', '']);

				if (!isset($_POST['location']) OR empty($_POST['location']))
					array_push($labels, ['location', '']);

				if (!isset($_POST['order']) OR empty($_POST['order']))
					array_push($labels, ['order', '']);

				if (!isset($_POST['time_period']) OR empty($_POST['time_period']) OR !is_numeric($_POST['time_period']) OR $_POST['time_period'] < 1)
					array_push($labels, ['time_period', '']);

				if (!isset($_POST['addressed_to']) OR empty($_POST['addressed_to']))
					array_push($labels, ['addressed_to', '']);

				if ($_POST['addressed_to'] == 'opportunity_areas')
				{
					if (!isset($_POST['addressed_to_opportunity_areas']) AND empty($_POST['addressed_to_opportunity_areas']))
						array_push($labels, ['addressed_to_opportunity_areas[]', '']);
				}

				if (!isset($_POST['fields']) OR empty($_POST['fields']))
					array_push($labels, ['fields[]', '']);

				if (empty($labels))
				{
					if ($_POST['action'] == 'new_vox_report')
						$query = $this->model->new_vox_report($_POST);
					else if ($_POST['action'] == 'edit_vox_report')
						$query = $this->model->edit_vox_report($_POST);

					if (!empty($query))
					{
						Functions::environment([
							'status' => 'success',
							'message' => '{$lang.operation_success}',
						]);
					}
					else
					{
						Functions::environment([
							'status' => 'error',
							'message' => '{$lang.operation_error}',
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

			if ($_POST['action'] == 'delete_vox_report')
			{
				$query = $this->model->delete_vox_report($_POST['id']);

				if (!empty($query))
				{
					Functions::environment([
						'status' => 'success',
						'message' => '{$lang.operation_success}',
					]);
				}
				else
				{
					Functions::environment([
						'status' => 'error',
						'message' => '{$lang.operation_error}',
					]);
				}
			}
		}
		else
		{
			define('_title', 'GuestVox');

			$template = $this->view->render($this, 'reports');

			$opt_opportunity_areas = '';

			foreach ($this->model->get_opportunity_areas('all') as $value)
				$opt_opportunity_areas .= '<option value="' . $value['id'] . '">' . $value['name'][Session::get_value('account')['language']] . '</option>';

			$opt_rooms = '';

			foreach ($this->model->get_rooms() as $value)
				$opt_rooms .= '<option value="' . $value['id'] . '">' . $value['name'] . '</option>';

			$opt_locations = '';

			foreach ($this->model->get_locations('all') as $value)
				$opt_locations .= '<option value="' . $value['id'] . '">' . $value['name'][Session::get_value('account')['language']] . '</option>';

			$cbx_addressed_to_opportunity_areas = '';

			foreach ($this->model->get_opportunity_areas('all') as $value)
			{
				$cbx_addressed_to_opportunity_areas .=
				'<div>
					<input type="checkbox" name="addressed_to_opportunity_areas[]" value="' . $value['id'] . '">
					<span>' . $value['name'][Session::get_value('account')['language']] . '</span>
				</div>';
			}

			$cbx_fields = '';

			foreach ($this->model->get_vox_report_fields('all') as $value)
			{
				$cbx_fields .=
				'<div>
					<input type="checkbox" name="fields[]" value="' . $value['id'] . '">
					<span>{$lang.' . $value['name'] . '}</span>
				</div>';
			}

			$tbl_vox_reports = '';

			foreach ($this->model->get_vox_reports() as $value)
			{
				$tbl_vox_reports .=
				'<tr>
					<td align="left">' . $value['name'] . '</td>
					' . ((Functions::check_user_access(['{vox_reports_delete}']) == true) ? '<td align="right" class="icon"><a data-action="delete_vox_report" data-id="' . $value['id'] . '" class="delete"><i class="fas fa-trash"></i></a></td>' : '') . '
					' . ((Functions::check_user_access(['{vox_reports_update}']) == true) ? '<td align="right" class="icon"><a data-action="edit_vox_report" data-id="' . $value['id'] . '" class="edit"><i class="fas fa-pen"></i></a></td>' : '') . '
				</tr>';
			}

			$replace = [
				'{$opt_opportunity_areas}' => $opt_opportunity_areas,
				'{$opt_rooms}' => $opt_rooms,
				'{$opt_locations}' => $opt_locations,
				'{$cbx_addressed_to_opportunity_areas}' => $cbx_addressed_to_opportunity_areas,
				'{$cbx_fields}' => $cbx_fields,
				'{$tbl_vox_reports}' => $tbl_vox_reports,
			];

			$template = $this->format->replace($replace, $template);

			echo $template;
		}
	}

	public function generate()
	{
		if (Format::exist_ajax_request() == true)
		{
			if ($_POST['action'] == 'get_filter')
			{
				$query = $this->model->get_vox_report($_POST['report']);

				$data['type'] = $query['type'];
				$data['opportunity_area'] = (!empty($query['opportunity_area'])) ? $query['opportunity_area'] : 'all';
				$data['opt_opportunity_areas'] = '<option value="all">{$lang.all}</option>';

				foreach ($this->model->get_opportunity_areas($data['type']) as $value)
					$data['opt_opportunity_areas'] .= '<option value="' . $value['id'] . '">' . $value['name'][Session::get_value('account')['language']] . '</option>';

				$data['opportunity_type'] = (!empty($query['opportunity_type'])) ? $query['opportunity_type'] : 'all';
				$data['opt_opportunity_types'] = '<option value="all">{$lang.all}</option>';

				foreach ($this->model->get_opportunity_types($data['opportunity_area'], $data['type']) as $value)
					$data['opt_opportunity_types'] .= '<option value="' . $value['id'] . '">' . $value['name'][Session::get_value('account')['language']] . '</option>';

				$data['room'] = (!empty($query['room'])) ? $query['room'] : 'all';
				$data['location'] = (!empty($query['location'])) ? $query['location'] : 'all';
				$data['opt_locations'] = '<option value="all">{$lang.all}</option>';

				foreach ($this->model->get_locations($data['type']) as $value)
					$data['opt_locations'] .= '<option value="' . $value['id'] . '">' . $value['name'][Session::get_value('account')['language']] . '</option>';

				$data['order'] = $query['order'];
				$data['started_date'] = Functions::get_past_date(Functions::get_current_date(), $query['time_period'], 'days');
				$data['end_date'] = Functions::get_current_date();
				$data['fields'] = $query['fields'];
				$data['cbx_fields'] =
				'<div class="checkbox">
					<input type="checkbox" name="checked_all">
					<span>{$lang.all}</span>
				</div>';

				foreach ($this->model->get_vox_report_fields($data['type']) as $value)
				{
					$data['cbx_fields'] .=
					'<div class="checkbox">
						<input type="checkbox" name="fields[]" value="' . $value['id'] . '">
						<span>{$lang.' . $value['name'] . '}</span>
					</div>';
				}

				Functions::environment([
					'status' => 'success',
					'data' => $data
				]);
			}

			if ($_POST['action'] == 'get_opt_opportunity_areas')
			{
				$data = '<option value="all">{$lang.all}</option>';

				foreach ($this->model->get_opportunity_areas($_POST['option']) as $value)
					$data .= '<option value="' . $value['id'] . '">' . $value['name'][Session::get_value('account')['language']] . '</option>';

				Functions::environment([
					'status' => 'success',
					'data' => $data
				]);
			}

			if ($_POST['action'] == 'get_opt_opportunity_types')
			{
				$data = '<option value="all">{$lang.all}</option>';

				foreach ($this->model->get_opportunity_types($_POST['opportunity_area'], $_POST['option']) as $value)
					$data .= '<option value="' . $value['id'] . '">' . $value['name'][Session::get_value('account')['language']] . '</option>';

				Functions::environment([
					'status' => 'success',
					'data' => $data
				]);
			}

			if ($_POST['action'] == 'get_opt_locations')
			{
				$data = '<option value="all">{$lang.all}</option>';

				foreach ($this->model->get_locations($_POST['option']) as $value)
					$data .= '<option value="' . $value['id'] . '">' . $value['name'][Session::get_value('account')['language']] . '</option>';

				Functions::environment([
					'status' => 'success',
					'data' => $data
				]);
			}

			if ($_POST['action'] == 'get_cbx_addressed_to_opportunity_areas')
			{
				$data =
				'<div>
					<input type="checkbox" name="checked_all">
					<span>{$lang.all}</span>
				</div>';

				foreach ($this->model->get_opportunity_areas($_POST['option']) as $value)
				{
					$data .=
					'<div>
						<input type="checkbox" name="addressed_to_opportunity_areas[]" value="' . $value['id'] . '">
						<span>' . $value['name'][Session::get_value('account')['language']] . '</span>
					</div>';
				}

				Functions::environment([
					'status' => 'success',
					'data' => $data
				]);
			}

			if ($_POST['action'] == 'get_cbx_fields')
			{
				$data =
				'<div>
					<input type="checkbox" name="checked_all">
					<span>{$lang.all}</span>
				</div>';

				foreach ($this->model->get_vox_report_fields($_POST['option']) as $value)
				{
					$data .=
					'<div>
						<input type="checkbox" name="fields[]" value="' . $value['id'] . '">
						<span>{$lang.' . $value['name'] . '}</span>
					</div>';
				}

				Functions::environment([
					'status' => 'success',
					'data' => $data
				]);
			}

			if ($_POST['action'] == 'generate_report')
			{
				$labels = [];

				if (!isset($_POST['type']) OR empty($_POST['type']))
					array_push($labels, ['type', '']);

				if (!isset($_POST['opportunity_area']) OR empty($_POST['opportunity_area']))
					array_push($labels, ['opportunity_area', '']);

				if (!isset($_POST['opportunity_type']) OR empty($_POST['opportunity_type']))
					array_push($labels, ['opportunity_type', '']);

				if (!isset($_POST['room']) OR empty($_POST['room']))
					array_push($labels, ['room', '']);

				if (!isset($_POST['location']) OR empty($_POST['location']))
					array_push($labels, ['location', '']);

				if (!isset($_POST['order']) OR empty($_POST['order']))
					array_push($labels, ['order', '']);

				if (!isset($_POST['started_date']) OR empty($_POST['started_date']))
					array_push($labels, ['started_date', '']);

				if (!isset($_POST['end_date']) OR empty($_POST['end_date']))
					array_push($labels, ['end_date', '']);

				if (!isset($_POST['fields']) OR empty($_POST['fields']))
					array_push($labels, ['fields[]', '']);

				if (empty($labels))
				{
					$query = $this->model->generate_report($_POST);

					$data = '';

					foreach ($query as $value)
					{
						$data .=
						'<div class="detail">
							<p><strong>Token:</strong> ' . $value['data']['token'] . '</p><br><br>';

						if (in_array('type', $_POST['fields']))
							$data .= '<p><strong>{$lang.type}:</strong> {$lang.' . $value['type'] . '}</p>';

						if (in_array('room', $_POST['fields']))
							$data .= '<p><strong>{$lang.room}:</strong> ' . $value['data']['room'] . '</p>';

						if (in_array('opportunity_area', $_POST['fields']))
							$data .= '<p><strong>{$lang.opportunity_area}:</strong> ' . $value['data']['opportunity_area'][Session::get_value('account')['language']] . '</p>';

						if (in_array('opportunity_type', $_POST['fields']))
							$data .= '<p><strong>{$lang.opportunity_type}:</strong> ' . $value['data']['opportunity_type'][Session::get_value('account')['language']] . '</p>';

						if (in_array('started_date_hour', $_POST['fields']))
							$data .= '<p><strong>{$lang.started_date_hour}:</strong> ' . Functions::get_formatted_date($value['data']['started_date'], 'd F, Y') . ' ' . Functions::get_formatted_hour($value['data']['started_hour'], '+ hrs') . '</p>';

						if (in_array('location', $_POST['fields']))
							$data .= '<p><strong>{$lang.location}:</strong> ' . $value['data']['location'][Session::get_value('account')['language']] . '</p>';

						if (in_array('cost', $_POST['fields']) AND $value['type'] == 'incident')
							$data .= '<p><strong>{$lang.cost}:</strong> ' . Functions::get_formatted_currency($value['data']['cost']) . '</p>';

						if (in_array('urgency', $_POST['fields']))
						{
							if ($value['data']['status'] == 'open' AND Functions::get_current_date_hour() < Functions::get_formatted_date_hour($value['data']['started_date'], $value['data']['started_hour']))
								$value['data']['urgency'] = '{$lang.programmed}';
							else if ($value['data']['urgency'] == 'low')
								$value['data']['urgency'] = '{$lang.low}';
							else if ($value['data']['urgency'] == 'medium')
								$value['data']['urgency'] = '{$lang.medium}';
							else if ($value['data']['urgency'] == 'high')
								$value['data']['urgency'] = '{$lang.high}';

							$data .= '<p><strong>{$lang.urgency}:</strong> ' . $value['data']['urgency'] . '</p>';
						}

						if (in_array('confidentiality', $_POST['fields']) AND $value['type'] == 'incident')
						{
							if ($value['data']['confidentiality'] == true)
								$value['data']['confidentiality'] = '{$lang.to_yes}';
							else if ($value['data']['confidentiality'] == false)
								$value['data']['confidentiality'] = '{$lang.to_not}';

							$data .= '<p><strong>{$lang.confidentiality}:</strong> ' . $value['data']['confidentiality'] . '</p>';
						}

						if (in_array('observations', $_POST['fields']) AND $value['type'] == 'request')
							$data .= '<p><strong>{$lang.observations}:</strong> ' . $value['data']['observations'] . '</p>';

						if (in_array('subject', $_POST['fields']) AND $value['type'] == 'incident')
							$data .= '<p><strong>{$lang.subject}:</strong> ' . $value['data']['subject'] . '</p>';

						if (in_array('assigned_users', $_POST['fields']))
						{
							$str_assigned_users = '';

							foreach ($value['data']['assigned_users'] as $subvalue)
								$str_assigned_users .= $subvalue . ', ';

							$data .= '<p><strong>{$lang.assigned_users}:</strong> ' . $str_assigned_users . '</p>';
						}

						if (in_array('description', $_POST['fields']) AND $value['type'] == 'incident')
							$data .= '<p><strong>{$lang.description}:</strong> ' . $value['data']['description'] . '</p>';

						if (in_array('action_taken', $_POST['fields']) AND $value['type'] == 'incident')
							$data .= '<p><strong>{$lang.action_taken}:</strong> ' . $value['data']['action_taken'] . '</p>';

						if (in_array('guest_treatment_name_lastname', $_POST['fields']))
							$data .= '<p><strong>{$lang.guest}:</strong> ' . $value['data']['guest_treatment'] . ' ' . $value['data']['firstname'] . ' ' . $value['data']['lastname'] . '</p>';

						if (in_array('guest_id', $_POST['fields']) AND $value['type'] == 'incident')
							$data .= '<p><strong>{$lang.guest_id}:</strong> ' . $value['data']['guest_id'] . '</p>';

						if (in_array('guest_type', $_POST['fields']) AND $value['type'] == 'incident')
							$data .= '<p><strong>{$lang.guest_type}:</strong> ' . $value['data']['guest_type'] . '</p>';

						if (in_array('reservation_status', $_POST['fields']) AND $value['type'] == 'incident')
							$data .= '<p><strong>{$lang.reservation_status}:</strong> ' . $value['data']['reservation_status'] . '</p>';

						if (in_array('check_in_check_out', $_POST['fields']) AND $value['type'] == 'incident')
							$data .= '<p><strong>{$lang.staying}:</strong> ' . Functions::get_formatted_date($value['data']['check_in'], 'd F, Y') . ' - ' . Functions::get_formatted_date($value['data']['check_out'], 'd F, Y') . '</p>';

						if (in_array('attachments', $_POST['fields']))
						{
							$str_attachments = '';

							$attimg = 0;
							$attpdf = 0;
							$attwrd = 0;
							$attexl = 0;

							foreach ($value['data']['attachments'] as $key => $subvalue)
							{
								if ($subvalue['status'] == 'success')
								{
									$ext = strtoupper(explode('.', $subvalue['file'])[1]);

									if ($ext == 'JPG' OR $ext == 'JPEG' OR $ext == 'PNG')
										$attimg = $attimg + 1;
									else if ($ext == 'PDF')
										$attpdf = $attpdf + 1;
									else if ($ext == 'DOC' OR $ext == 'DOCX')
										$attwrd = $attwrd + 1;
									else if ($ext == 'XLS' OR $ext == 'XLSX')
										$attexl = $attexl + 1;
								}
							}

							if ($attimg > 0)
								$str_attachments .= '<img src="{$path.images}empty.png">' . $attimg . ' {$lang.files} ';

							if ($attpdf > 0)
								$str_attachments .= '<img src="{$path.images}pdf.png">' . $attpdf . ' {$lang.files} ';

							if ($attwrd > 0)
								$str_attachments .= '<img src="{$path.images}word.png">' . $attwrd . ' {$lang.files} ';

							if ($attexl > 0)
								$str_attachments .= '<img src="{$path.images}excel.png">' . $attexl . ' {$lang.files} ';

							$data .= '<p><strong>{$lang.attachments}:</strong> ' . $str_attachments . '</p>';
						}

						if (in_array('status', $_POST['fields']))
						{
							if ($value['data']['status'] == 'open')
								$value['data']['status'] = '{$lang.opened}';
							else if ($value['data']['status'] == 'close')
								$value['data']['status'] = '{$lang.closed}';

							$data .= '<p><strong>{$lang.status}:</strong> ' . $value['data']['status'] . '</p>';
						}

						if (in_array('origin', $_POST['fields']))
							$data .= '<p><strong>{$lang.origin}:</strong> {$lang.' . $value['data']['origin'] . '}</p>';

						if (in_array('created_by', $_POST['fields']))
							$data .= '<p><strong>{$lang.created_by}:</strong> ' . ((!empty($value['data']['created_user'])) ? $value['data']['created_user'] . ' ' . Functions::get_formatted_date_hour($value['data']['created_date'], $value['data']['created_hour']) : '') . '</p>';

						if (in_array('edited_by', $_POST['fields']))
							$data .= '<p><strong>{$lang.edited_by}:</strong> ' . ((!empty($value['data']['edited_user'])) ? $value['data']['edited_user'] . ' ' . Functions::get_formatted_date_hour($value['data']['edited_date'], $value['data']['edited_hour']) : '') . '</p>';

						if (in_array('completed_by', $_POST['fields']))
							$data .= '<p><strong>{$lang.completed_by}:</strong> ' . ((!empty($value['data']['completed_user'])) ? $value['data']['completed_user'] . ' ' . Functions::get_formatted_date_hour($value['data']['completed_date'], $value['data']['completed_hour']) : '') . '</p>';

						if (in_array('reopened_by', $_POST['fields']))
							$data .= '<p><strong>{$lang.reopened_by}:</strong> ' . ((!empty($value['data']['reopened_user'])) ? $value['data']['reopened_user'] . ' ' . Functions::get_formatted_date_hour($value['data']['reopened_date'], $value['data']['reopened_hour']) : '') . '</p>';

						if (in_array('viewed_by', $_POST['fields']))
						{
							$str_viewed_by = '';

							foreach ($value['data']['viewed_by'] as $subvalue)
								$str_viewed_by .= $subvalue . ', ';

							$data .= '<p><strong>{$lang.viewed_by}:</strong> ' . $str_viewed_by . '</p>';
						}

						if (in_array('average_resolution', $_POST['fields']))
						{
							if (!empty($value['data']['completed_date']) AND !empty($value['data']['completed_hour']))
							{
								$date1 = new DateTime($value['data']['started_date'] . ' ' . $value['data']['started_hour']);
								$date2 = new DateTime($value['data']['completed_date'] . ' ' . $value['data']['completed_hour']);
								$date3 = $date1->diff($date2);

								if ($date3->h == 0 AND $date3->i == 0)
									$str_average_resolution = $date3->s . ' Seg';
								else if ($date3->h == 0 AND $date3->i > 0)
									$str_average_resolution = $date3->i . ' Min';
								else if ($date3->h > 0 AND $date3->i == 0)
									$str_average_resolution = $date3->h . ' Hrs';
								else if ($date3->h > 0 AND $date3->i > 0)
									$str_average_resolution = $date3->h . ' Hrs ' . $date3->i . ' Min';
							}
							else
								$str_average_resolution = '{$lang.opened}';

							$data .= '<p><strong>{$lang.average_resolution}:</strong> ' . $str_average_resolution . '</p>';
						}

						if (in_array('comments', $_POST['fields']))
						{
							$str_comments = '';

							foreach ($value['data']['comments'] as $subvalue)
							{
								$str_comments_attachments = '';

								$attimg = 0;
								$attpdf = 0;
								$attwrd = 0;
								$attexl = 0;

								foreach ($subvalue['attachments'] as $key => $intvalue)
								{
									if ($intvalue['status'] == 'success')
									{
										$ext = strtoupper(explode('.', $intvalue['file'])[1]);

										if ($ext == 'JPG' OR $ext == 'JPEG' OR $ext == 'PNG')
											$attimg = $attimg + 1;
										else if ($ext == 'PDF')
											$attpdf = $attpdf + 1;
										else if ($ext == 'DOC' OR $ext == 'DOCX')
											$attwrd = $attwrd + 1;
										else if ($ext == 'XLS' OR $ext == 'XLSX')
											$attexl = $attexl + 1;
									}
								}

								if ($attimg > 0 OR $attpdf > 0 OR $attwrd > 0 OR $attexl > 0)
									$str_comments_attachments .= '<strong>{$lang.attachments}:</strong> ';

								if ($attimg > 0)
									$str_comments_attachments .= '<img src="{$path.images}empty.png">' . $attimg . ' {$lang.files} ';

								if ($attpdf > 0)
									$str_comments_attachments .= '<img src="{$path.images}pdf.png">' . $attpdf . ' {$lang.files} ';

								if ($attwrd > 0)
									$str_comments_attachments .= '<img src="{$path.images}word.png">' . $attwrd . ' {$lang.files} ';

								if ($attexl > 0)
									$str_comments_attachments .= '<img src="{$path.images}excel.png">' . $attexl . ' {$lang.files} ';

								$str_comments .= '<br><p><strong>' . $subvalue['user'] . ':</strong> ' . $subvalue['message'] . ' ' . $str_comments_attachments . '</p>';
							}

							$data .= '<br><br><p><strong>{$lang.comments}:</strong></p>' . $str_comments . '';
						}

						$data .= '</div>';
					}

					Functions::environment([
						'status' => 'success',
						'data' => $data
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
			define('_title', 'GuestVox');

			$template = $this->view->render($this, 'generate');

			$opt_reports = '';

			foreach ($this->model->get_vox_reports() as $value)
				$opt_reports .= '<option value="' . $value['id'] . '">' . $value['name'] . '</option>';

			$opt_opportunity_areas = '';

			foreach ($this->model->get_opportunity_areas('all') as $value)
				$opt_opportunity_areas .= '<option value="' . $value['id'] . '">' . $value['name'][Session::get_value('account')['language']] . '</option>';

			$opt_rooms = '';

			foreach ($this->model->get_rooms() as $value)
				$opt_rooms .= '<option value="' . $value['id'] . '">' . $value['name'] . '</option>';

			$opt_locations = '';

			foreach ($this->model->get_locations('all') as $value)
				$opt_locations .= '<option value="' . $value['id'] . '">' . $value['name'][Session::get_value('account')['language']] . '</option>';

			$cbx_fields = '';

			foreach ($this->model->get_vox_report_fields('all') as $value)
			{
				$cbx_fields .=
				'<div>
					<input type="checkbox" name="fields[]" value="' . $value['id'] . '">
					<span>{$lang.' . $value['name'] . '}</span>
				</div>';
			}

			$replace = [
				'{$opt_reports}' => $opt_reports,
				'{$opt_opportunity_areas}' => $opt_opportunity_areas,
				'{$opt_rooms}' => $opt_rooms,
				'{$opt_locations}' => $opt_locations,
				'{$cbx_fields}' => $cbx_fields,
			];

			$template = $this->format->replace($replace, $template);

			echo $template;
		}
	}

	public function stats()
	{
		if (Format::exist_ajax_request() == true)
		{
			if ($_POST['action'] == 'get_v_chart_data')
			{
				Functions::environment([
					'status' => 'success',
					'data' => [
						'oa' => $this->model->get_chart_data('v_oa_chart', $_POST, true),
						'r' => $this->model->get_chart_data('v_r_chart', $_POST, true),
						'l' => $this->model->get_chart_data('v_l_chart', $_POST, true),
					],
				]);
			}

			if ($_POST['action'] == 'get_ar_chart_data')
			{
				Functions::environment([
					'status' => 'success',
					'data' => [
						'oa' => $this->model->get_chart_data('ar_oa_chart', $_POST, true),
						'r' => $this->model->get_chart_data('ar_r_chart', $_POST, true),
						'l' => $this->model->get_chart_data('ar_l_chart', $_POST, true),
					],
				]);
			}

			if ($_POST['action'] == 'get_c_chart_data')
			{
				Functions::environment([
					'status' => 'success',
					'data' => [
						'oa' => $this->model->get_chart_data('c_oa_chart', $_POST, true),
						'r' => $this->model->get_chart_data('c_r_chart', $_POST, true),
						'l' => $this->model->get_chart_data('c_l_chart', $_POST, true),
					],
				]);
			}
		}
		else
		{
			define('_title', 'GuestVox');

			$template = $this->view->render($this, 'stats');

			$replace = [
				'{$average_resolution}' => $this->model->get_average('general_resolution'),
				'{$count_created_today}' => $this->model->get_count('created_today'),
				'{$count_created_week}' => $this->model->get_count('created_week'),
				'{$count_created_month}' => $this->model->get_count('created_month'),
				'{$count_created_year}' => $this->model->get_count('created_year'),
				'{$count_created_total}' => $this->model->get_count('created_total'),
			];

			$template = $this->format->replace($replace, $template);

			echo $template;
		}
	}

	public function charts()
	{
		header('Content-Type: application/javascript');

		$v_oa_chart_data = $this->model->get_chart_data('v_oa_chart', [
			'started_date' => Functions::get_past_date(Functions::get_current_date(), '7', 'days'),
			'date_end' => Functions::get_current_date(),
			'type' => 'all'
		]);

		$v_r_chart_data = $this->model->get_chart_data('v_r_chart', [
			'started_date' => Functions::get_past_date(Functions::get_current_date(), '7', 'days'),
			'date_end' => Functions::get_current_date(),
			'type' => 'all'
		]);

		$v_l_chart_data = $this->model->get_chart_data('v_l_chart', [
			'started_date' => Functions::get_past_date(Functions::get_current_date(), '7', 'days'),
			'date_end' => Functions::get_current_date(),
			'type' => 'all'
		]);

		$ar_oa_chart_data = $this->model->get_chart_data('ar_oa_chart', [
			'started_date' => Functions::get_past_date(Functions::get_current_date(), '7', 'days'),
			'date_end' => Functions::get_current_date(),
			'type' => 'all'
		]);

		$ar_r_chart_data = $this->model->get_chart_data('ar_r_chart', [
			'started_date' => Functions::get_past_date(Functions::get_current_date(), '7', 'days'),
			'date_end' => Functions::get_current_date(),
			'type' => 'all'
		]);

		$ar_l_chart_data = $this->model->get_chart_data('ar_l_chart', [
			'started_date' => Functions::get_past_date(Functions::get_current_date(), '7', 'days'),
			'date_end' => Functions::get_current_date(),
			'type' => 'all'
		]);

		$c_oa_chart_data = $this->model->get_chart_data('c_oa_chart', [
			'started_date' => Functions::get_past_date(Functions::get_current_date(), '7', 'days'),
			'date_end' => Functions::get_current_date(),
		]);

		$c_r_chart_data = $this->model->get_chart_data('c_r_chart', [
			'started_date' => Functions::get_past_date(Functions::get_current_date(), '7', 'days'),
			'date_end' => Functions::get_current_date(),
		]);

		$c_l_chart_data = $this->model->get_chart_data('c_l_chart', [
			'started_date' => Functions::get_past_date(Functions::get_current_date(), '7', 'days'),
			'date_end' => Functions::get_current_date(),
		]);

		if (Session::get_value('account')['language'] == 'es')
		{
			$v_oa_chart_data_title = 'Voxes por áreas de oportunidad';
			$v_r_chart_data_title = 'Voxes por habitación';
			$v_l_chart_data_title = 'Voxes por ubicación';
			$ar_oa_chart_data_title = 'Tiempo de resolución por áreas de oportunidad';
			$ar_r_chart_data_title = 'Tiempo de resolución por habitación';
			$ar_l_chart_data_title = 'Tiempo de resolución por ubicación';
			$c_oa_chart_data_title = 'Costos por áreas de oportunidad';
			$c_r_chart_data_title = 'Costos por habitación';
			$c_l_chart_data_title = 'Costos por ubicación';
		}
		else if (Session::get_value('account')['language'] == 'en')
		{
			$v_oa_chart_data_title = 'Voxes by opportunity areas';
			$v_r_chart_data_title = 'Voxes by room';
			$v_l_chart_data_title = 'Voxes by location';
			$ar_oa_chart_data_title = 'Resolution average by opportunity areas';
			$ar_r_chart_data_title = 'Resolution average by room';
			$ar_l_chart_data_title = 'Resolution average by location';
			$c_oa_chart_data_title = 'Costs by opportunity areas';
			$c_r_chart_data_title = 'Costs by room';
			$c_l_chart_data_title = 'Costs by location';
		}

		$js =
		"'use strict';

		var v_oa_chart = {
	        type: 'pie',
	        data: {
				labels: [
	                " . $v_oa_chart_data['labels'] . "
	            ],
				datasets: [{
	                data: [
	                    " . $v_oa_chart_data['datasets']['data'] . "
	                ],
	                backgroundColor: [
	                    " . $v_oa_chart_data['datasets']['colors'] . "
	                ],
	            }],
	        },
	        options: {
				title: {
					display: true,
					text: '" . $v_oa_chart_data_title . "'
				},
				legend: {
					display: false
				},
	            responsive: true
            }
        };

		var v_r_chart = {
	        type: 'pie',
	        data: {
				labels: [
	                " . $v_r_chart_data['labels'] . "
	            ],
				datasets: [{
	                data: [
	                    " . $v_r_chart_data['datasets']['data'] . "
	                ],
	                backgroundColor: [
	                    " . $v_r_chart_data['datasets']['colors'] . "
	                ],
	            }],
	        },
	        options: {
				title: {
					display: true,
					text: '" . $v_r_chart_data_title . "'
				},
				legend: {
					display: false
				},
	            responsive: true
            }
        };

		var v_l_chart = {
	        type: 'pie',
	        data: {
				labels: [
	                " . $v_l_chart_data['labels'] . "
	            ],
				datasets: [{
	                data: [
	                    " . $v_l_chart_data['datasets']['data'] . "
	                ],
	                backgroundColor: [
	                    " . $v_l_chart_data['datasets']['colors'] . "
	                ],
	            }],
	        },
	        options: {
				title: {
					display: true,
					text: '" . $v_l_chart_data_title . "'
				},
				legend: {
					display: false
				},
	            responsive: true
            }
        };

		var ar_oa_chart = {
	        type: 'horizontalBar',
	        data: {
				labels: [
	                " . $ar_oa_chart_data['labels'] . "
	            ],
				datasets: [{
	                data: [
	                    " . $ar_oa_chart_data['datasets']['data'] . "
	                ],
	                backgroundColor: [
	                    " . $ar_oa_chart_data['datasets']['colors'] . "
	                ],
	            }],
	        },
	        options: {
				title: {
					display: true,
					text: '" . $ar_oa_chart_data_title . "'
				},
				legend: {
					display: false
				},
	            responsive: true
            }
        };

		var ar_r_chart = {
	        type: 'pie',
	        data: {
				labels: [
	                " . $ar_r_chart_data['labels'] . "
	            ],
				datasets: [{
	                data: [
	                    " . $ar_r_chart_data['datasets']['data'] . "
	                ],
	                backgroundColor: [
	                    " . $ar_r_chart_data['datasets']['colors'] . "
	                ],
	            }],
	        },
	        options: {
				title: {
					display: true,
					text: '" . $ar_r_chart_data_title . "'
				},
				legend: {
					display: false
				},
	            responsive: true
            }
        };

		var ar_l_chart = {
	        type: 'pie',
	        data: {
				labels: [
	                " . $ar_l_chart_data['labels'] . "
	            ],
				datasets: [{
	                data: [
	                    " . $ar_l_chart_data['datasets']['data'] . "
	                ],
	                backgroundColor: [
	                    " . $ar_l_chart_data['datasets']['colors'] . "
	                ],
	            }],
	        },
	        options: {
				title: {
					display: true,
					text: '" . $ar_l_chart_data_title . "'
				},
				legend: {
					display: false
				},
	            responsive: true
            }
        };

		var c_oa_chart = {
	        type: 'pie',
	        data: {
				labels: [
	                " . $c_oa_chart_data['labels'] . "
	            ],
				datasets: [{
	                data: [
	                    " . $c_oa_chart_data['datasets']['data'] . "
	                ],
	                backgroundColor: [
	                    " . $c_oa_chart_data['datasets']['colors'] . "
	                ],
	            }],
	        },
	        options: {
				title: {
					display: true,
					text: '" . $c_oa_chart_data_title . "'
				},
				legend: {
					display: false
				},
	            responsive: true
            }
        };

		var c_r_chart = {
	        type: 'pie',
	        data: {
				labels: [
	                " . $c_r_chart_data['labels'] . "
	            ],
				datasets: [{
	                data: [
	                    " . $c_r_chart_data['datasets']['data'] . "
	                ],
	                backgroundColor: [
	                    " . $c_r_chart_data['datasets']['colors'] . "
	                ],
	            }],
	        },
	        options: {
				title: {
					display: true,
					text: '" . $c_r_chart_data_title . "'
				},
				legend: {
					display: false
				},
	            responsive: true
            }
        };

		var c_l_chart = {
	        type: 'pie',
	        data: {
				labels: [
	                " . $c_l_chart_data['labels'] . "
	            ],
				datasets: [{
	                data: [
	                    " . $c_l_chart_data['datasets']['data'] . "
	                ],
	                backgroundColor: [
	                    " . $c_l_chart_data['datasets']['colors'] . "
	                ],
	            }],
	        },
	        options: {
				title: {
					display: true,
					text: '" . $c_l_chart_data_title . "'
				},
				legend: {
					display: false
				},
	            responsive: true
            }
        };

		window.onload = function()
		{
			v_oa_chart = new Chart(document.getElementById('v_oa_chart').getContext('2d'), v_oa_chart);
			v_r_chart = new Chart(document.getElementById('v_r_chart').getContext('2d'), v_r_chart);
			v_l_chart = new Chart(document.getElementById('v_l_chart').getContext('2d'), v_l_chart);
			ar_oa_chart = new Chart(document.getElementById('ar_oa_chart').getContext('2d'), ar_oa_chart);
			ar_r_chart = new Chart(document.getElementById('ar_r_chart').getContext('2d'), ar_r_chart);
			ar_l_chart = new Chart(document.getElementById('ar_l_chart').getContext('2d'), ar_l_chart);
			c_oa_chart = new Chart(document.getElementById('c_oa_chart').getContext('2d'), c_oa_chart);
			c_r_chart = new Chart(document.getElementById('c_r_chart').getContext('2d'), c_r_chart);
			c_l_chart = new Chart(document.getElementById('c_l_chart').getContext('2d'), c_l_chart);
		};";

		$js = trim(str_replace(array("\t\t\t"), '', $js));

		echo $js;
	}
}
