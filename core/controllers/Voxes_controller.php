<?php

defined('_EXEC') or die;

// require_once 'plugins/nexmo/vendor/autoload.php';

class Voxes_controller extends Controller
{
	private $lang;

	public function __construct()
	{
		parent::__construct();

		$this->lang = Session::get_value('account')['language'];
	}

	public function index()
	{
		if (Format::exist_ajax_request() == true)
		{
			if ($_POST['action'] == 'get_opt_owners')
			{
				$html = '<option value="all" ' . ((Session::get_value('settings')['voxes']['voxes']['filter']['owner'] == 'all') ? 'selected' : '') . '>{$lang.all}</option>';

				foreach ($this->model->get_owners($_POST['type']) as $value)
					$html .= '<option value="' . $value['id'] . '" ' . ((Session::get_value('settings')['voxes']['voxes']['filter']['owner'] == $value['id']) ? 'selected' : '') . '>' . $value['name'][$this->lang] . (!empty($value['number']) ? ' #' . $value['number'] : '') . '</option>';

				Functions::environment([
					'status' => 'success',
					'html' => $html
				]);
			}

			if ($_POST['action'] == 'get_opt_opportunity_areas')
			{
				$html = '<option value="all" ' . ((Session::get_value('settings')['voxes']['voxes']['filter']['opportunity_area'] == 'all') ? 'selected' : '') . '>{$lang.all}</option>';

				foreach ($this->model->get_opportunity_areas($_POST['type']) as $value)
					$html .= '<option value="' . $value['id'] . '" ' . ((Session::get_value('settings')['voxes']['voxes']['filter']['opportunity_area'] == $value['id']) ? 'selected' : '') . '>' . $value['name'][$this->lang] . '</option>';

				Functions::environment([
					'status' => 'success',
					'html' => $html
				]);
			}

			if ($_POST['action'] == 'get_opt_opportunity_types')
			{
				$html = '<option value="all" ' . ((Session::get_value('settings')['voxes']['voxes']['filter']['opportunity_type'] == 'all') ? 'selected' : '') . '>{$lang.all}</option>';

				if (!empty($_POST['opportunity_area']) AND $_POST['opportunity_area'] != 'all')
				{
					foreach ($this->model->get_opportunity_types($_POST['opportunity_area'], $_POST['type']) as $value)
						$html .= '<option value="' . $value['id'] . '" ' . ((Session::get_value('settings')['voxes']['voxes']['filter']['opportunity_type'] == $value['id']) ? 'selected' : '') . '>' . $value['name'][$this->lang] . '</option>';
				}

				Functions::environment([
					'status' => 'success',
					'html' => $html
				]);
			}

			if ($_POST['action'] == 'get_opt_locations')
			{
				$html = '<option value="all" ' . ((Session::get_value('settings')['voxes']['voxes']['filter']['location'] == 'all') ? 'selected' : '') . '>{$lang.all}</option>';

				foreach ($this->model->get_locations($_POST['type']) as $value)
					$html .= '<option value="' . $value['id'] . '" ' . ((Session::get_value('settings')['voxes']['voxes']['filter']['location'] == $value['id']) ? 'selected' : '') . '>' . $value['name'][$this->lang] . '</option>';

				Functions::environment([
					'status' => 'success',
					'html' => $html
				]);
			}

			if ($_POST['action'] == 'filter_voxes')
			{
				$settings = Session::get_value('settings');

				$settings['voxes']['voxes']['filter']['type'] = $_POST['type'];
				$settings['voxes']['voxes']['filter']['owner'] = $_POST['owner'];
				$settings['voxes']['voxes']['filter']['opportunity_area'] = $_POST['opportunity_area'];
				$settings['voxes']['voxes']['filter']['opportunity_type'] = $_POST['opportunity_type'];
				$settings['voxes']['voxes']['filter']['location'] = $_POST['location'];
				$settings['voxes']['voxes']['filter']['urgency'] = $_POST['urgency'];
				$settings['voxes']['voxes']['filter']['assigned'] = $_POST['assigned'];
				$settings['voxes']['voxes']['filter']['order'] = $_POST['order'];
				$settings['voxes']['voxes']['filter']['status'] = $_POST['status'];

				Session::set_value('settings', $settings);

				Functions::environment([
					'status' => 'success'
				]);
			}
		}
		else
		{
			$template = $this->view->render($this, 'index');

			define('_title', 'Guestvox | {$lang.voxes}');

			$tbl_voxes = '';

			foreach ($this->model->get_voxes() as $value)
			{
				$tbl_voxes .=
				'<div>
	                <div>
						<div class="itm_1">';

				if (!empty($value['assigned_users']))
				{
					foreach (array_reverse($value['assigned_users']) as $subvalue)
					{
						$tbl_voxes .=
						'<figure>
							<img src="' . (!empty($subvalue['avatar']) ? '{$path.uploads}' . $subvalue['avatar'] : '{$path.images}avatar.png') . '">
						</figure>';
					}
				}
				else
				{
					$tbl_voxes .=
					'<figure>
						<img src="' . (($value['origin'] == 'myvox') ? '{$path.images}myvox.png' : (!empty($value['created_user']['avatar']) ? '{$path.uploads}' . $value['created_user']['avatar'] : '{$path.images}avatar.png')) . '">
					</figure>';
				}

				$tbl_voxes .=
				'       </div>
	                    <div class="itm_2">
							<div>
								<span class="' . $value['urgency'] . '">';

				if ($value['type'] == 'request')
					$tbl_voxes .= '<i class="fas fa-rocket"></i>';
				else if ($value['type'] == 'incident')
					$tbl_voxes .= '<i class="fas fa-meteor"></i>';
				else if ($value['type'] == 'workorder')
					$tbl_voxes .= '<i class="fas fa-bomb"></i>';

				$tbl_voxes .=
				'	</span>
				</div>
				<div>
					<h2><i class="fas fa-user-circle"></i>' . (($value['type'] == 'request' OR $value['type'] == 'incident') ? (((Session::get_value('account')['type'] == 'hotel' AND !empty($value['menu_order'])) OR (Session::get_value('account')['type'] == 'restaurant' AND !empty($value['menu_order']) AND $value['menu_order']['type_service'] == 'restaurant')) ? '{$lang.not_apply}' : ((!empty($value['firstname']) AND !empty($value['lastname'])) ? ((Session::get_value('account')['type'] == 'hotel' AND !empty($value['guest_treatment'])) ? $value['guest_treatment']['name'] . ' ' : '') . $value['firstname'] . ' ' . $value['lastname'] :  '{$lang.not_name}')) : '{$lang.not_apply}') . '</h2>
					<span><i class="fas fa-shapes"></i>' . ((Session::get_value('account')['type'] == 'restaurant' AND !empty($value['menu_order']) AND $value['menu_order']['type_service'] == 'delivery') ? (($value['menu_order']['delivery'] == 'home') ? '{$lang.home_service}' : '{$lang.pick_up_restaurant}') : $value['owner']['name'][$this->lang] . (!empty($value['owner']['number']) ? ' #' . $value['owner']['number'] : '')) . '</span>';

				if ($value['type'] == 'request' OR $value['type'] == 'workorder')
					$tbl_voxes .= '<span><i class="fas fa-quote-right"></i>' . (!empty($value['observations']) ? $value['observations'] : '{$lang.not_observations}') . '</span>';
				else if ($value['type'] == 'incident')
					$tbl_voxes .= '<span><i class="fas fa-quote-right"></i>' . (!empty($value['subject']) ? $value['subject'] : '{$lang.not_subject}') . '</span>';

				$tbl_voxes .=
				'				<span
									data-date-1="' . Functions::get_formatted_date_hour($value['started_date'], $value['started_hour']) . '"
									data-date-2="' . ((!empty($value['completed_date']) AND !empty($value['completed_hour'])) ? Functions::get_formatted_date_hour($value['completed_date'], $value['completed_hour']) : '') . '"
									data-time-zone="' . Session::get_value('account')['time_zone'] . '"
									data-status="' . $value['status'] . '"
									data-elapsed-time><i class="fas fa-clock"></i><strong></strong></span>
							</div>
	                    </div>
	                    <div class="itm_3">
							<div>
								<i class="fas fa-key"></i>
								<p><strong>' . strtoupper($value['token']) . '</strong></p>
							</div>
							<div>
								<i class="fas fa-mask"></i>
								<p>' . $value['opportunity_area']['name'][$this->lang] . '</p>
							</div>
							<div>
								<i class="fas fa-feather-alt"></i>
								<p>' . $value['opportunity_type']['name'][$this->lang] . '</p>
							</div>
							<div>
								<i class="fas fa-map-marker-alt"></i>
								<p>' . ((Session::get_value('account')['type'] == 'restaurant' AND !empty($value['menu_order'])) ? (($value['menu_order']['type_service'] == 'delivery' AND $value['menu_order']['delivery'] == 'home') ? $value['address'] : '{$lang.not_apply}') : $value['location']['name'][$this->lang]) . '</p>
							</div>
	                    </div>
	                    <div class="itm_4">
							' . (!empty($value['assigned_users']) ? '<span><i class="fas fa-users"></i></span>' : '') . '
							' . (!empty($value['comments']) ? '<span><i class="fas fa-comment"></i></span>' : '') . '
							' . (!empty($value['attachments']) ? '<span><i class="fas fa-paperclip"></i></span>' : '') . '
							' . (($value['confidentiality'] == true) ? '<span><i class="fas fa-lock"></i></span>' : '') . '
						</div>
						<a href="/voxes/details/' . $value['token'] . '"></a>
	                </div>
	            </div>';
			}

			$opt_owners = '';

			foreach ($this->model->get_owners(Session::get_value('settings')['voxes']['voxes']['filter']['type']) as $value)
				$opt_owners .= '<option value="' . $value['id'] . '" ' . ((Session::get_value('settings')['voxes']['voxes']['filter']['owner'] == $value['id']) ? 'selected' : '') . '>' . $value['name'][$this->lang] . (!empty($value['number']) ? ' #' . $value['number'] : '') . '</option>';

			$opt_opportunity_areas = '';

			foreach ($this->model->get_opportunity_areas(Session::get_value('settings')['voxes']['voxes']['filter']['type']) as $value)
				$opt_opportunity_areas .= '<option value="' . $value['id'] . '" ' . ((Session::get_value('settings')['voxes']['voxes']['filter']['opportunity_area'] == $value['id']) ? 'selected' : '') . '>' . $value['name'][$this->lang] . '</option>';

			$opt_opportunity_types = '';

			if (Session::get_value('settings')['voxes']['voxes']['filter']['opportunity_area'] != 'all')
			{
				foreach ($this->model->get_opportunity_types(Session::get_value('settings')['voxes']['voxes']['filter']['opportunity_area'], Session::get_value('settings')['voxes']['voxes']['filter']['type']) as $value)
					$opt_opportunity_types .= '<option value="' . $value['id'] . '" ' . ((Session::get_value('settings')['voxes']['voxes']['filter']['opportunity_type'] == $value['id']) ? 'selected' : '') . '>' . $value['name'][$this->lang] . '</option>';
			}

			$opt_locations = '';

			foreach ($this->model->get_locations(Session::get_value('settings')['voxes']['voxes']['filter']['type']) as $value)
				$opt_locations .= '<option value="' . $value['id'] . '" ' . ((Session::get_value('settings')['voxes']['voxes']['filter']['location'] == $value['id']) ? 'selected' : '') . '>' . $value['name'][$this->lang] . '</option>';

			$opt_assigned = '';

			if (Functions::check_user_access(['{view_all}']) == true)
			{
				foreach ($this->model->get_users() as $value)
				{
					if (Session::get_value('user')['id'] != $value['id'])
						$opt_assigned .= '<option value="' . $value['id'] . '" ' . ((Session::get_value('settings')['voxes']['voxes']['filter']['assigned'] == $value['id']) ? 'selected' : '') . '>{$lang.assigned_to} ' . $value['firstname'] . ' ' . $value['lastname'] . '</option>';
				}
			}

			$replace = [
				'{$tbl_voxes}' => $tbl_voxes,
				'{$opt_owners}' => $opt_owners,
				'{$opt_opportunity_areas}' => $opt_opportunity_areas,
				'{$opt_opportunity_types}' => $opt_opportunity_types,
				'{$opt_locations}' => $opt_locations,
				'{$opt_assigned}' => $opt_assigned
			];

			$template = $this->format->replace($replace, $template);

			echo $template;
		}
	}

	public function create()
	{
		if (Format::exist_ajax_request() == true)
		{
			if ($_POST['action'] == 'get_opt_owners')
			{
				$html = '<option value="" hidden>{$lang.choose}</option>';

				foreach ($this->model->get_owners($_POST['type']) as $value)
					$html .= '<option value="' . $value['id'] . '">' . $value['name'][$this->lang] . (!empty($value['number']) ? ' #' . $value['number'] : '') . '</option>';

				Functions::environment([
					'status' => 'success',
					'html' => $html
				]);
			}

			if ($_POST['action'] == 'get_reservation')
			{
				$query = $this->model->get_owner($_POST['owner']);

				if (!empty($query))
				{
					$query = $this->model->get_reservation($query['number']);

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
				$html = '<option value="" hidden>{$lang.choose}</option>';

				foreach ($this->model->get_opportunity_areas($_POST['type']) as $value)
					$html .= '<option value="' . $value['id'] . '">' . $value['name'][$this->lang] . '</option>';

				Functions::environment([
					'status' => 'success',
					'html' => $html
				]);
			}

			if ($_POST['action'] == 'get_opt_opportunity_types')
			{
				$html = '<option value="" hidden>{$lang.choose}</option>';

				if (!empty($_POST['opportunity_area']))
				{
					foreach ($this->model->get_opportunity_types($_POST['opportunity_area'], $_POST['type']) as $value)
						$html .= '<option value="' . $value['id'] . '">' . $value['name'][$this->lang] . '</option>';
				}

				Functions::environment([
					'status' => 'success',
					'html' => $html
				]);
			}

			if ($_POST['action'] == 'get_opt_locations')
			{
				$html = '<option value="" hidden>{$lang.choose}</option>';

				foreach ($this->model->get_locations($_POST['type']) as $value)
					$html .= '<option value="' . $value['id'] . '">' . $value['name'][$this->lang] . '</option>';

				Functions::environment([
					'status' => 'success',
					'html' => $html
				]);
			}

			if ($_POST['action'] == 'new_vox')
			{
				$labels = [];

				if (!isset($_POST['type']) OR empty($_POST['type']))
					array_push($labels, ['type','']);

				if (!isset($_POST['owner']) OR empty($_POST['owner']))
					array_push($labels, ['owner','']);

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

				if (empty($labels))
				{
					$_POST['token'] = strtolower(Functions::get_random(8));
					$_POST['assigned_users'] = !empty($_POST['assigned_users']) ? $_POST['assigned_users'] : [];
					$_POST['attachments'] = $_FILES['attachments'];

					$query = $this->model->new_vox($_POST);

					if (!empty($query))
					{
						$_POST['owner'] = $this->model->get_owner($_POST['owner']);
						$_POST['opportunity_area'] = $this->model->get_opportunity_area($_POST['opportunity_area']);
						$_POST['opportunity_type'] = $this->model->get_opportunity_type($_POST['opportunity_type']);
						$_POST['location'] = $this->model->get_location($_POST['location']);
						$_POST['assigned_users'] = $this->model->get_assigned_users($_POST['assigned_users'], $_POST['opportunity_area']['id']);

						$mail = new Mailer(true);

						try
						{
							$mail->setFrom('noreply@guestvox.com', 'Guestvox');

							foreach ($_POST['assigned_users'] as $value)
								$mail->addAddress($value['email'], $value['firstname'] . ' ' . $value['lastname']);

							$mail->Subject = Languages::email('new', $_POST['type'])[$this->lang];
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
													<img style="width:100%;max-width:300px;" src="https://' . Configuration::$domain . '/images/logotype_color.png">
												</figure>
											</td>
										</tr>
										<tr style="width:100%;margin:0px 0px 10px 0px;padding:0px;border:0px;">
											<td style="width:100%;margin:0px;padding:40px 20px;border:0px;box-sizing:border-box;background-color:#fff;">
												<h4 style="width:100%;margin:0px 0px 20px 0px;padding:0px;font-size:24px;font-weight:600;text-align:center;color:#212121;">' . $mail->Subject . '</h4>
												<h6 style="width:100%;margin:0px 0px 5px 0px;padding:0px;font-size:14px;font-weight:400;text-align:left;color:#757575;">' . Languages::email('token')[$this->lang] . ': ' . $_POST['token'] . '</h6>
												<h6 style="width:100%;margin:0px 0px 5px 0px;padding:0px;font-size:14px;font-weight:400;text-align:left;color:#757575;">' . Languages::email('owner')[$this->lang] . ': ' . $_POST['owner']['name'][$this->lang] . (!empty($_POST['owner']['number']) ? ' #' . $_POST['owner']['number'] : '') . '</h6>
												<h6 style="width:100%;margin:0px 0px 5px 0px;padding:0px;font-size:14px;font-weight:400;text-align:left;color:#757575;">' . Languages::email('opportunity_area')[$this->lang] . ': ' . $_POST['opportunity_area']['name'][$this->lang] . '</h6>
						    					<h6 style="width:100%;margin:0px 0px 5px 0px;padding:0px;font-size:14px;font-weight:400;text-align:left;color:#757575;">' . Languages::email('opportunity_type')[$this->lang] . ': ' . $_POST['opportunity_type']['name'][$this->lang] . '</h6>
												<h6 style="width:100%;margin:0px 0px 5px 0px;padding:0px;font-size:14px;font-weight:400;text-align:left;color:#757575;">' . Languages::email('started_date')[$this->lang] . ': ' . Functions::get_formatted_date($_POST['started_date'], 'd.m.Y') . '</h6>
												<h6 style="width:100%;margin:0px 0px 5px 0px;padding:0px;font-size:14px;font-weight:400;text-align:left;color:#757575;">' . Languages::email('started_hour')[$this->lang] . ': ' . Functions::get_formatted_hour($_POST['started_hour'], '+ hrs') . '</h6>
												<h6 style="width:100%;margin:0px 0px 5px 0px;padding:0px;font-size:14px;font-weight:400;text-align:left;color:#757575;">' . Languages::email('location')[$this->lang] . ': ' . $_POST['location']['name'][$this->lang] . '</h6>
												<h6 style="width:100%;margin:0px 0px 5px 0px;padding:0px;font-size:14px;font-weight:400;text-align:left;color:#757575;">' . Languages::email('urgency')[$this->lang] . ': ' . Languages::email($_POST['urgency'])[$this->lang] . '</h6>';

							if ($_POST['type'] == 'request' OR $_POST['type'] == 'workorder')
								$mail->Body .= '<p style="width:100%;margin:0px 0px 20px 0px;padding:0px;font-size:14px;font-weight:400;text-align:left;color:#757575;">' . Languages::email('observations')[$this->lang] . ': ' . (!empty($_POST['observations']) ? $_POST['observations'] : Languages::email('not_observations')[$this->lang]) . '</p>';
							else if ($_POST['type'] == 'incident')
							{
								$mail->Body .=
								'<h6 style="width:100%;margin:0px 0px 5px 0px;padding:0px;font-size:14px;font-weight:400;text-align:left;color:#757575;">' . Languages::email('confidentiality')[$this->lang] . ': ' . Languages::email((!empty($_POST['confidentiality']) ? 'yes' : 'not'))[$this->lang] . '</h6>
								<p style="width:100%;margin:0px 0px 20px 0px;padding:0px;font-size:14px;font-weight:400;text-align:left;color:#757575;">' . Languages::email('subject')[$this->lang] . ': ' . (!empty($_POST['subject']) ? $_POST['subject'] : Languages::email('not_subject')[$this->lang]) . '</p>';
							}

							$mail->Body .=
							'                   <a style="width:100%;display:block;margin:0px;padding:20px 0px;border-radius:50px;box-sizing:border-box;background-color:#00a5ab;font-size:14px;font-weight:400;text-align:center;text-decoration:none;color:#fff;" href="https://' . Configuration::$domain . '/voxes/details/' . $_POST['token'] . '">' . Languages::email('give_follow_up')[$this->lang] . '</a>
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

						$sms = $this->model->get_sms();

						if ($sms > 0)
						{
							$sms_basic  = new \Nexmo\Client\Credentials\Basic('45669cce', 'CR1Vg1bpkviV8Jzc');
							$sms_client = new \Nexmo\Client($sms_basic);
							$sms_text = 'Guestvox. ' . Languages::email('new', $_POST['type'])[$this->lang] . ' . ';
							$sms_text .= Languages::email('token')[$this->lang] . ': ' . $_POST['token'] . ' . ';
							$sms_text .= Languages::email('owner')[$this->lang] . ': ' . $_POST['owner']['name'][$this->lang] . (!empty($_POST['owner']['number']) ? ' #' . $_POST['owner']['number'] : '') . ' . ';
							$sms_text .= Languages::email('opportunity_area')[$this->lang] . ': ' . $_POST['opportunity_area']['name'][$this->lang] . ' . ';
							$sms_text .= Languages::email('opportunity_type')[$this->lang] . ': ' . $_POST['opportunity_type']['name'][$this->lang] . ' . ';
							$sms_text .= Languages::email('started_date')[$this->lang] . ': ' . Functions::get_formatted_date($_POST['started_date'], 'd M y') . ' . ';
							$sms_text .= Languages::email('started_hour')[$this->lang] . ': ' . Functions::get_formatted_hour($_POST['started_hour'], '+ hrs') . ' . ';
							$sms_text .= Languages::email('location')[$this->lang] . ': ' . $_POST['location']['name'][$this->lang] . ' . ';
							$sms_text .= Languages::email('urgency')[$this->lang] . ': ' . Languages::email($_POST['urgency'])[$this->lang] . ' . ';

							if ($_POST['type'] == 'request' OR $_POST['type'] == 'workorder')
								$sms_text .= Languages::email('observations')[$this->lang] . ': ' . (!empty($_POST['observations']) ? $_POST['observations'] : Languages::email('not_observations')[$this->lang]) . ' . ';
							else if ($_POST['type'] == 'incident')
							{
								$sms_text .= Languages::email('confidentiality')[$this->lang] . ': ' . Languages::email((!empty($_POST['confidentiality']) ? 'yes' : 'not'))[$this->lang] . ' . ';
								$sms_text .= Languages::email('subject')[$this->lang] . ': ' . (!empty($_POST['subject']) ? $_POST['subject'] : Languages::email('not_subject')[$this->lang]) . ' . ';
							}

							$sms_text .= 'https://' . Configuration::$domain . '/voxes/details/' . $_POST['token'];

							foreach ($_POST['assigned_users'] as $value)
							{
								if ($sms > 0)
								{
									try
									{
										$sms_client->message()->send([
											'to' => $value['phone']['lada'] . $value['phone']['number'],
											'from' => 'Guestvox',
											'text' => $sms_text
										]);

										$sms = $sms - 1;
									}
									catch (Exception $e) { }
								}
							}

							$this->model->edit_sms($sms);
						}

						Functions::environment([
							'status' => 'success',
							'path' => '/voxes/details/' . $_POST['token'],
							'message' => '{$lang.operation_success}'
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
			$template = $this->view->render($this, 'create');

			define('_title', 'Guestvox | {$lang.voxes} | {$lang.create}');

			$opt_owners = '';

			foreach ($this->model->get_owners('request') as $value)
				$opt_owners .= '<option value="' . $value['id'] . '">' . $value['name'][$this->lang] . (!empty($value['number']) ? ' #' . $value['number'] : '') . '</option>';

			$opt_opportunity_areas = '';

			foreach ($this->model->get_opportunity_areas('request') as $value)
				$opt_opportunity_areas .= '<option value="' . $value['id'] . '">' . $value['name'][$this->lang] . '</option>';

			$opt_locations = '';

			foreach ($this->model->get_locations('request') as $value)
				$opt_locations .= '<option value="' . $value['id'] . '">' . $value['name'][$this->lang] . '</option>';

			$opt_guests_treatments = '';
			$opt_guests_types = '';
			$opt_reservations_statuses = '';

			if (Session::get_value('account')['type'] == 'hotel')
			{
				foreach ($this->model->get_guests_treatments() as $value)
					$opt_guests_treatments .= '<option value="' . $value['id'] . '">' . $value['name'] . '</option>';

				foreach ($this->model->get_guests_types() as $value)
					$opt_guests_types .= '<option value="' . $value['id'] . '">' . $value['name'] . '</option>';

				foreach ($this->model->get_reservations_statuses() as $value)
					$opt_reservations_statuses .= '<option value="' . $value['id'] . '">' . $value['name'] . '</option>';
			}

			$opt_users = '';

			foreach ($this->model->get_users() as $value)
				$opt_users .= '<option value="' . $value['id'] . '">' . $value['firstname'] . ' ' . $value['lastname'] . '</option>';

			$replace = [
				'{$opt_owners}' => $opt_owners,
				'{$opt_opportunity_areas}' => $opt_opportunity_areas,
				'{$opt_locations}' => $opt_locations,
				'{$opt_guests_treatments}' => $opt_guests_treatments,
				'{$opt_guests_types}' => $opt_guests_types,
				'{$opt_reservations_statuses}' => $opt_reservations_statuses,
				'{$opt_users}' => $opt_users
			];

			$template = $this->format->replace($replace, $template);

			echo $template;
		}
	}

	public function details($params)
	{
		$vox = $this->model->get_vox($params[0]);

		if (!empty($vox))
		{
			if (Format::exist_ajax_request() == true)
			{
				if ($_POST['action'] == 'comment_vox')
				{
					$labels = [];

					if (!isset($_POST['comment']) OR empty($_POST['comment']))
						array_push($labels, ['comment','']);

					if (empty($labels))
					{
						$_POST['id'] = $vox['id'];
						$_POST['attachments'] = $_FILES['attachments'];

						$query = $this->model->comment_vox($_POST);

						if (!empty($query))
						{
							$vox['assigned_users'] = $this->model->get_assigned_users($vox['assigned_users'], $vox['opportunity_area']['id']);

							$mail = new Mailer(true);

							try
							{
								$mail->setFrom('noreply@guestvox.com', 'Guestvox');

								foreach ($vox['assigned_users'] as $value)
									$mail->addAddress($value['email'], $value['firstname'] . ' ' . $value['lastname']);

								$mail->Subject = Languages::email('commented_vox')[$this->lang];
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
														<img style="width:100%;max-width:300px;" src="https://' . Configuration::$domain . '/images/logotype_color.png">
													</figure>
												</td>
											</tr>
											<tr style="width:100%;margin:0px 0px 10px 0px;padding:0px;border:0px;">
												<td style="width:100%;margin:0px;padding:40px 20px;border:0px;box-sizing:border-box;background-color:#fff;">
													<h4 style="width:100%;margin:0px 0px 20px 0px;padding:0px;font-size:24px;font-weight:600;text-align:center;color:#212121;">' . $mail->Subject . '</h4>
													<a style="width:100%;display:block;margin:0px;padding:20px 0px;border-radius:50px;box-sizing:border-box;background-color:#00a5ab;font-size:14px;font-weight:400;text-align:center;text-decoration:none;color:#fff;" href="https://' . Configuration::$domain . '/voxes/details/' . $vox['token'] . '">' . Languages::email('view_details')[$this->lang] . '</a>
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

							$sms = $this->model->get_sms();

							if ($sms > 0)
							{
								$sms_basic  = new \Nexmo\Client\Credentials\Basic('45669cce', 'CR1Vg1bpkviV8Jzc');
								$sms_client = new \Nexmo\Client($sms_basic);
								$sms_text = Languages::email('commented_vox')[$this->lang] . '. https://' . Configuration::$domain . '/voxes/details/' . $vox['token'];

								foreach ($vox['assigned_users'] as $value)
								{
									if ($sms > 0)
									{
										try
										{
											$sms_client->message()->send([
												'to' => $value['phone']['lada'] . $value['phone']['number'],
												'from' => 'Guestvox',
												'text' => $sms_text
											]);

											$sms = $sms - 1;
										}
										catch (Exception $e) { }
									}
								}

								$this->model->edit_sms($sms);
							}

							Functions::environment([
								'status' => 'success',
								'message' => '{$lang.operation_success}'
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

				if ($_POST['action'] == 'complete_vox' OR $_POST['action'] == 'reopen_vox')
				{
					if ($_POST['action'] == 'complete_vox')
						$query = $this->model->complete_vox($vox['id']);
					else if ($_POST['action'] == 'reopen_vox')
						$query = $this->model->reopen_vox($vox['id']);

					if (!empty($query))
					{
						$vox['assigned_users'] = $this->model->get_assigned_users($vox['assigned_users'], $vox['opportunity_area']['id']);

						$mail = new Mailer(true);

						if ($_POST['action'] == 'complete_vox')
							$mail_subject = Languages::email('completed_vox')[$this->lang];
						else if ($_POST['action'] == 'reopen_vox')
							$mail_subject = Languages::email('reopened_vox')[$this->lang];

						try
						{
							$mail->setFrom('noreply@guestvox.com', 'Guestvox');

							foreach ($vox['assigned_users'] as $value)
								$mail->addAddress($value['email'], $value['firstname'] . ' ' . $value['lastname']);

							$mail->Subject = $mail_subject;
							$mail->Body =
							'<html>
								<head>
									<title>' . $mail_subject . '</title>
								</head>
								<body>
									<table style="width:600px;margin:0px;padding:20px;border:0px;box-sizing:border-box;background-color:#eee">
										<tr style="width:100%;margin:0px 0px 10px 0px;padding:0px;border:0px;">
											<td style="width:100%;margin:0px;padding:40px 20px;border:0px;box-sizing:border-box;background-color:#fff;">
												<figure style="width:100%;margin:0px;padding:0px;text-align:center;">
													<img style="width:100%;max-width:300px;" src="https://' . Configuration::$domain . '/images/logotype_color.png">
												</figure>
											</td>
										</tr>
										<tr style="width:100%;margin:0px 0px 10px 0px;padding:0px;border:0px;">
											<td style="width:100%;margin:0px;padding:40px 20px;border:0px;box-sizing:border-box;background-color:#fff;">
												<h4 style="width:100%;margin:0px 0px 20px 0px;padding:0px;font-size:24px;font-weight:600;text-align:center;color:#212121;">' . $mail_subject . '</h4>
												<a style="width:100%;display:block;margin:0px;padding:20px 0px;border-radius:50px;box-sizing:border-box;background-color:#00a5ab;font-size:14px;font-weight:400;text-align:center;text-decoration:none;color:#fff;" href="https://' . Configuration::$domain . '/voxes/details/' . $vox['token'] . '">' . Languages::email('view_details')[$this->lang] . '</a>
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

						$sms = $this->model->get_sms();

						if ($sms > 0)
						{
							$sms_basic  = new \Nexmo\Client\Credentials\Basic('45669cce', 'CR1Vg1bpkviV8Jzc');
							$sms_client = new \Nexmo\Client($sms_basic);
							$sms_text = $mail_subject . '. https://' . Configuration::$domain . '/voxes/details/' . $vox['token'];

							foreach ($vox['assigned_users'] as $value)
							{
								if ($sms > 0)
								{
									try
									{
										$sms_client->message()->send([
											'to' => $value['phone']['lada'] . $value['phone']['number'],
											'from' => 'Guestvox',
											'text' => $sms_text
										]);

										$sms = $sms - 1;
									}
									catch (Exception $e) { }
								}
							}

							$this->model->edit_sms($sms);
						}

						Functions::environment([
							'status' => 'success',
							'message' => '{$lang.operation_success}'
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
			}
			else
			{
				$template = $this->view->render($this, 'details');

				define('_title', 'Guestvox | {$lang.voxes} | {$lang.details}');

				$spn_type = '<span class="' . $vox['urgency'] . '">';

				if ($vox['type'] == 'request')
					$spn_type .= '<i class="fas fa-rocket"></i>';
				else if ($vox['type'] == 'incident')
					$spn_type .= '<i class="fas fa-meteor"></i>';
				else if ($vox['type'] == 'workorder')
					$spn_type .= '<i class="fas fa-bomb"></i>';

				$spn_type .= '</span>';

				$p_observations = '';

				if ($vox['type'] == 'request' OR $vox['type'] == 'workorder')
				{
					if ($vox['type'] == 'request')
					{
						if (Session::get_value('account')['type'] == 'hotel' OR Session::get_value('account')['type'] == 'restaurant')
						{
							if (!empty($vox['menu_order']))
							{
								foreach ($vox['menu_order']['shopping_cart'] as $value)
								{
									foreach ($value as $subvalue)
									{
										$p_observations .= '<p><strong>(' . $subvalue['quantity'] . ') ' . $subvalue['name'][$this->lang] . ' (' . Functions::get_formatted_currency($subvalue['total'], $vox['menu_order']['currency']) . ')</strong></p>';

										foreach ($subvalue['topics'] as $parentvalue)
											$p_observations .= '<p>- ' . $parentvalue['name'][$this->lang] . '</p>';
									}
								}

								$p_observations .= '<p><strong>{$lang.total}: ' . Functions::get_formatted_currency($vox['menu_order']['total'], $vox['menu_order']['currency']) . '</strong></p>';

								if (Session::get_value('account')['type'] == 'restaurant' AND $vox['menu_order']['type_service'] == 'delivery')
								{
									$p_observations .=
									'<p>{$lang.email}: ' . $vox['email'] . '</p>
									<p>{$lang.phone}: + (' . $vox['phone']['lada'] . ') ' . $vox['phone']['number'] . '</p>';
								}
							}
						}
					}

					$p_observations .= '<p><i class="fas fa-quote-right"></i>' . (!empty($vox['observations']) ? $vox['observations'] : '{$lang.not_observations}') . '</p>';
				}

				$spn_reservation = '';

				if (Session::get_value('account')['type'] == 'hotel')
				{
					if ($vox['type'] == 'incident')
					{
						$spn_reservation .=
						'<span class="' . (!empty($vox['guest_id']) ? 'active' : '') . '"><i class="fas fa-key"></i><span>{$lang.guest_id}</span>' . (!empty($vox['guest_id']) ? $vox['guest_id'] : '{$lang.not_guest_id}') . '</span>
						<span class="' . (!empty($vox['guest_type']) ? 'active' : '') . '"><i class="fas fa-tag"></i><span>{$lang.guest_type}</span>' . (!empty($vox['guest_type']) ? $vox['guest_type']['name'] : '{$lang.not_guest_type}') . '</span>
						<span class="' . (!empty($vox['reservation_number']) ? 'active' : '') . '"><i class="fas fa-suitcase-rolling"></i><span>{$lang.reservation_number}</span>' . (!empty($vox['reservation_number']) ? $vox['reservation_number'] : '{$lang.not_reservation_number}') . '</span>
						<span class="' . (!empty($vox['reservation_status']) ? 'active' : '') . '"><i class="fas fa-hotel"></i><span>{$lang.reservation_status}</span>' . (!empty($vox['reservation_status']) ? $vox['reservation_status']['name'] : '{$lang.not_reservation_status}') . '</span>
						<span class="' . (!empty($vox['check_in']) ? 'active' : '') . '"><i class="fas fa-calendar-check"></i><span>{$lang.check_in}</span>' . (!empty($vox['check_in']) ? Functions::get_formatted_date($vox['check_in'], 'd.m.Y') : '{$lang.not_check_in}') . '</span>
						<span class="' . (!empty($vox['check_out']) ? 'active' : '') . '"><i class="fas fa-calendar-times"></i><span>{$lang.check_out}</span>' . (!empty($vox['check_out']) ? Functions::get_formatted_date($vox['check_out'], 'd.m.Y') : '{$lang.not_check_out}') . '</span>';
					}
				}

				$div_actions = '';

				if ((!empty($vox['edited_date']) AND !empty($vox['edited_hour'])) OR (!empty($vox['completed_date']) AND !empty($vox['completed_hour'])) OR (!empty($vox['reopened_date']) AND !empty($vox['reopened_hour'])))
				{
					$div_actions .= '<div class="stl_8">';

					if (!empty($vox['edited_date']) AND !empty($vox['edited_hour']))
					{
						$div_actions .=
						'<div>
							<figure>
								<img src="' . (!empty($vox['edited_user']['avatar']) ? '{$path.uploads}' . $vox['edited_user']['avatar'] : '{$path.images}avatar.png') . '">
							</figure>
							<div>
								<h2>' . $vox['edited_user']['firstname'] . ' ' . $vox['edited_user']['lastname'] . '</h2>
								<span>@' . $vox['edited_user']['username'] . '</span>
								<span>{$lang.edited_at} ' . Functions::get_formatted_date($vox['edited_date'], 'd.m.Y') . ' {$lang.at} ' . Functions::get_formatted_hour($vox['edited_hour'], '+ hrs') . '</span>
							</div>
						</div>';
					}

					if (!empty($vox['completed_date']) AND !empty($vox['completed_hour']))
					{
						$div_actions .=
						'<div>
							<figure>
								<img src="' . (!empty($vox['completed_user']['avatar']) ? '{$path.uploads}' . $vox['completed_user']['avatar'] : '{$path.images}avatar.png') . '">
							</figure>
							<div>
								<h2>' . $vox['completed_user']['firstname'] . ' ' . $vox['completed_user']['lastname'] . '</h2>
								<span>@' . $vox['completed_user']['username'] . '</span>
								<span>{$lang.completed_at} ' . Functions::get_formatted_date($vox['completed_date'], 'd.m.Y') . ' {$lang.at} ' . Functions::get_formatted_hour($vox['completed_hour'], '+ hrs') . '</span>
							</div>
						</div>';
					}

					if (!empty($vox['reopened_date']) AND !empty($vox['reopened_hour']))
					{
						$div_actions .=
						'<div>
							<figure>
								<img src="' . (!empty($vox['reopened_user']['avatar']) ? '{$path.uploads}' . $vox['reopened_user']['avatar'] : '{$path.images}avatar.png') . '">
							</figure>
							<div>
								<h2>' . $vox['reopened_user']['firstname'] . ' ' . $vox['reopened_user']['lastname'] . '</h2>
								<span>@' . $vox['reopened_user']['username'] . '</span>
								<span>{$lang.reopened_at} ' . Functions::get_formatted_date($vox['reopened_date'], 'd.m.Y') . ' {$lang.at} ' . Functions::get_formatted_hour($vox['reopened_hour'], '+ hrs') . '</span>
							</div>
						</div>';
					}

					$div_actions .= '</div>';
				}

				$mdl_get_attachments = '';

				if (!empty($vox['attachments']))
				{
					$mdl_get_attachments .=
					'<section class="modal fullscreen" data-modal="get_attachments">
						<div class="content">
							<main class="vox_details">
								<div class="stl_10">';

					foreach ($vox['attachments'] as $value)
					{
						if ($value['status'] == 'success')
						{
							$ext = strtoupper(explode('.', $value['file'])[1]);

							if ($ext == 'JPG' OR $ext == 'JPEG' OR $ext == 'PNG')
							{
								$mdl_get_attachments .=
								'<figure>
									<img src="{$path.uploads}' . $value['file'] . '">
								</figure>';
							}
							else if ($ext == 'PDF' OR $ext == 'DOC' OR $ext == 'DOCX' OR $ext == 'XLS' OR $ext == 'XLSX')
								$mdl_get_attachments .= '<iframe src="https://docs.google.com/viewer?url=https://' . Configuration::$domain . '/uploads/' . $value['file'] . '&embedded=true"></iframe>';
						}
					}

					$mdl_get_attachments .=
					'			</div>
								<div class="buttons">
									<a class="new" button-close><i class="fas fa-check"></i></a>
								</div>
							</main>
						</div>
					</section>';
				}

				$div_assigned_users = '';

				foreach ($vox['assigned_users'] as $value)
				{
					$div_assigned_users .=
					'<div>
						<figure>
							<img src="' . (!empty($value['avatar']) ? '{$path.uploads}' . $value['avatar'] : '{$path.images}avatar.png') . '">
						</figure>
						<div>
							<h2>' . $value['firstname'] . ' ' . $value['lastname'] . '</h2>
							<span>@' . $value['username'] . '</span>
						</div>
					</div>';
				}

				$div_viewed_by = '';

				foreach ($vox['viewed_by'] as $value)
				{
					$div_viewed_by .=
					'<div>
						<figure>
							<img src="' . (!empty($value['avatar']) ? '{$path.uploads}' . $value['avatar'] : '{$path.images}avatar.png') . '">
						</figure>
						<div>
							<h2>' . $value['firstname'] . ' ' . $value['lastname'] . '</h2>
							<span>@' . $value['username'] . '</span>
						</div>
					</div>';
				}

				$mdl_get_comments = '';

				if (!empty($vox['comments']))
				{
					$mdl_get_comments .=
					'<section class="modal fullscreen" data-modal="get_comments">
						<div class="content">
							<main class="vox_details">
								<div class="stl_12">';

					foreach ($vox['comments'] as $value)
					{
						$mdl_get_comments .=
						'<div>
							<div>
								<figure>
									<img src="' . (!empty($value['user']['avatar']) ? '{$path.uploads}' . $value['user']['avatar'] : '{$path.images}avatar.png') . '">
								</figure>
								<p>' . $value['comment'] . '</p>
								<p>' . Functions::get_formatted_currency((!empty($value['cost']) ? $value['cost'] : '0'), Session::get_value('account')['currency']) . '</p>
								<p><strong>' . $value['user']['firstname'] . ' ' . $value['user']['lastname'] . ' @' . $value['user']['username'] . '</strong> {$lang.the} ' . Functions::get_formatted_date($value['date'], 'd.m.y') . ' {$lang.at} ' . Functions::get_formatted_hour($value['hour'], '+ hrs') . '</p>
							</div>
						</div>';
					}

					$mdl_get_comments .=
					'			</div>
								<div class="buttons">
									<a class="new" button-close><i class="fas fa-check"></i></a>
								</div>
							</main>
						</div>
					</section>';
				}

				$div_changes_history = '';

				foreach ($vox['changes_history'] as $value)
				{
					$div_changes_history .=
					'<div>
						<figure>
							<img src="' . (($value['type'] == 'created' AND $vox['origin'] == 'myvox') ? '{$path.images}myvox.png' : (!empty($value['user']['avatar']) ? '{$path.uploads}' . $value['user']['avatar'] : '{$path.images}avatar.png')) . '">
						</figure>
						<div>
							<h2>' . (($value['type'] == 'created' AND $vox['origin'] == 'myvox') ? '{$lang.myvox}' : $value['user']['firstname'] . ' ' . $value['user']['lastname']) . '</h2>
							<span>@' . (($value['type'] == 'created' AND $vox['origin'] == 'myvox') ? '{$lang.myvox}' : $value['user']['username']) . '</span>
							<span>{$lang.' . $value['type'] . '_at} ' . Functions::get_formatted_date($value['date'], 'd F Y') . ' {$lang.at} ' . Functions::get_formatted_hour($value['hour'], '+ hrs') . '</span>';

					if ($value['type'] == 'edited')
					{
						$div_changes_history .= '<ul>';

						foreach ($value['fields'] as $subvalue)
							$div_changes_history .= '<li>{$lang.' . $subvalue['field'] . '}</li>';

						$div_changes_history .= '</ul>';
					}

					$div_changes_history .=
					'	</div>
					</div>';
				}

				$mdl_comment_vox = '';
				$mdl_complete_vox = '';
				$mdl_reopen_vox = '';

				if ($vox['status'] == true)
				{
					$mdl_comment_vox .=
					'<section class="modal fullscreen" data-modal="comment_vox">
					    <div class="content">
					        <main>
					            <form name="comment_vox">
					                <div class="row">
					                    <div class="span12">
					                        <div class="label">
					                            <label required>
					                                <p>{$lang.commentary}</p>
					                                <textarea name="comment"></textarea>
					                            </label>
					                        </div>
					                    </div>
										<div class="span12">
					                        <div class="label">
					                            <label unrequired>
					                                <p>(' . Session::get_value('account')['currency'] . ') {$lang.cost}</p>
					                                <input type="number" name="cost">
					                            </label>
					                        </div>
					                    </div>
					                    <div class="span12">
											<div class="stl_3" data-uploader="multiple">
												<div data-preview>
													<div data-image>
														<i class="fas fa-file-image"></i>
														<span><strong>0</strong>{$lang.images}</span>
													</div>
													<div data-pdf>
														<i class="fas fa-file-pdf"></i>
														<span><strong>0</strong>{$lang.pdf}</span>
													</div>
													<div data-word>
														<i class="fas fa-file-word"></i>
														<span><strong>0</strong>{$lang.word}</span>
													</div>
													<div data-excel>
														<i class="fas fa-file-excel"></i>
														<span><strong>0</strong>{$lang.excel}</span>
													</div>
												</div>
												<a data-select><i class="fas fa-cloud-upload-alt"></i></a>
												<input type="file" name="attachments[]" accept="image/*, application/pdf, application/vnd.ms-word, application/vnd.openxmlformats-officedocument.wordprocessingml.document, application/vnd.ms-excel, application/vnd.openxmlformats-officedocument.spreadsheetml.sheet" multiple data-upload>
											</div>
					                    </div>
					                    <div class="span12">
					                        <div class="buttons">
					                            <a class="delete" button-cancel><i class="fas fa-times"></i></a>
					                            <button type="submit" class="new"><i class="fas fa-check"></i></button>
					                        </div>
					                    </div>
					                </div>
					            </form>
					        </main>
					    </div>
					</section>';

					$mdl_complete_vox .=
					'<section class="modal edit" data-modal="complete_vox">
					    <div class="content">
					        <footer>
					            <a button-close><i class="fas fa-times"></i></a>
					            <a button-success><i class="fas fa-check"></i></a>
					        </footer>
					    </div>
					</section>';
				}
				else
				{
					$mdl_reopen_vox .=
					'<section class="modal edit" data-modal="reopen_vox">
					    <div class="content">
					        <footer>
					            <a button-close><i class="fas fa-times"></i></a>
					            <a button-success><i class="fas fa-check"></i></a>
					        </footer>
					    </div>
					</section>';
				}

				$replace = [
					'{$spn_type}' => $spn_type,
					'{$h3_elapsed_time}' => '<h3
	                    data-date-1="' . Functions::get_formatted_date_hour($vox['started_date'], $vox['started_hour']) . '"
	                    data-date-2="' . ((!empty($vox['completed_date']) AND !empty($vox['completed_hour'])) ? Functions::get_formatted_date_hour($vox['completed_date'], $vox['completed_hour']) : '') . '"
	                    data-time-zone="' . Session::get_value('account')['time_zone'] . '"
	                    data-status="' . $vox['status'] . '"
	                    data-elapsed-time>' . (($vox['status'] == true) ? '{$lang.opened}' : '{$lang.closed}') . '<i class="fas fa-circle"></i><strong></strong></h3>',
					'{$h1_name}' => '<h1>' . (($vox['type'] == 'request' OR $vox['type'] == 'incident') ? (((Session::get_value('account')['type'] == 'hotel' AND !empty($vox['menu_order'])) OR (Session::get_value('account')['type'] == 'restaurant' AND !empty($vox['menu_order']) AND $vox['menu_order']['type_service'] == 'restaurant')) ? '{$lang.not_apply}' : ((!empty($vox['firstname']) AND !empty($vox['lastname'])) ? ((Session::get_value('account')['type'] == 'hotel' AND !empty($vox['guest_treatment'])) ? $vox['guest_treatment']['name'] . ' ' : '') . $vox['firstname'] . ' ' . $vox['lastname'] :  '{$lang.not_name}')) : '{$lang.not_apply}') . '</h1>',
					'{$token}' => $vox['token'],
					'{$owner}' => (Session::get_value('account')['type'] == 'restaurant' AND !empty($vox['menu_order']) AND $vox['menu_order']['type_service'] == 'delivery') ? (($vox['menu_order']['delivery'] == 'home') ? '{$lang.home_service}' : '{$lang.pick_up_restaurant}') : $vox['owner']['name'][$this->lang] . (!empty($vox['owner']['number']) ? ' #' . $vox['owner']['number'] : ''),
					'{$opportunity_area}' => $vox['opportunity_area']['name'][$this->lang],
					'{$opportunity_type}' => $vox['opportunity_type']['name'][$this->lang],
					'{$location}' => (Session::get_value('account')['type'] == 'restaurant' AND !empty($vox['menu_order'])) ? (($vox['menu_order']['type_service'] == 'delivery' AND $vox['menu_order']['delivery'] == 'home') ? $vox['address'] . (!empty($vox['references']) ? ' / ' . $vox['references'] : '') : '{$lang.not_apply}') : $vox['location']['name'][$this->lang],
					'{$started_date}' => Functions::get_formatted_date($vox['started_date'], 'd.m.Y') . ' ' . Functions::get_formatted_hour($vox['started_hour'], '+ hrs'),
					'{$spn_cost}' => ($vox['type'] == 'incident' OR $vox['type'] == 'workorder') ? '<span><i class="fas fa-dollar-sign"></i>' . Functions::get_formatted_currency((!empty($vox['cost']) ? $vox['cost'] : '0'), Session::get_value('account')['currency']) . '</span>' : '',
					'{$p_observations}' => $p_observations,
					'{$p_subject}' => ($vox['type'] == 'incident') ? '<p><i class="fas fa-quote-right"></i>' . (!empty($vox['subject']) ? $vox['subject'] : '{$lang.not_subject}') . '</p>' : '',
					'{$p_description}' => ($vox['type'] == 'incident') ? '<p><i class="fas fa-quote-right"></i>' . (!empty($vox['description']) ? $vox['description'] : '{$lang.not_description}') . '</p>' : '',
					'{$p_action_taken}' => ($vox['type'] == 'incident') ? '<p><i class="fas fa-quote-right"></i>' . (!empty($vox['action_taken']) ? $vox['action_taken'] : '{$lang.not_action_taken}') . '</p>' : '',
					'{$div_confidentiality}' => ($vox['type'] == 'incident') ? '<div class="stl_4"><span class="' . (($vox['confidentiality'] == true) ? 'confidentiality' : '') . '">' . (($vox['confidentiality'] == true) ? '<i class="fas fa-lock"></i>{$lang.yes_confidentiality}' : '<i class="fas fa-lock-open"></i>{$lang.not_confidentiality}') . '</span></div>' : '',
					'{$spn_reservation}' => $spn_reservation,
					'{$btn_get_attachments}' => !empty($vox['attachments']) ? '<a data-button-modal="get_attachments"><i class="fas fa-paperclip"></i><span>{$lang.attachments}</span></a>' : '',
					'{$btn_get_comments}' => !empty($vox['comments']) ? '<a data-button-modal="get_comments"><i class="fas fa-comments"></i><span>{$lang.comments}</span></a>' : '',
					'{$created_user_avatar}' => ($vox['origin'] == 'myvox') ? '{$path.images}myvox.png' : (!empty($vox['created_user']['avatar']) ? '{$path.uploads}' . $vox['created_user']['avatar'] : '{$path.images}avatar.png'),
					'{$created_user_name}' => ($vox['origin'] == 'myvox') ? '{$lang.myvox}' : $vox['created_user']['firstname'] . ' ' . $vox['created_user']['lastname'],
					'{$created_user_username}' => '@' . (($vox['origin'] == 'myvox') ? '{$lang.myvox}' : $vox['created_user']['username']),
					'{$created_date}' => Functions::get_formatted_date($vox['created_date'], 'd.m.Y') . ' {$lang.at} ' . Functions::get_formatted_hour($vox['created_hour'], '+ hrs'),
					'{$div_actions}' => $div_actions,
					'{$btn_comment_vox}' => ($vox['status'] == true) ? '<a class="big new" data-button-modal="comment_vox"><i class="fas fa-comment"></i><span>{$lang.comment}</span></a>' : '',
					'{$btn_edit_vox}' => ($vox['status'] == true AND $vox['origin'] != 'myvox') ? '<a href="/voxes/edit/' . $vox['token'] . '" class="edit"><i class="fas fa-pen"></i></a>' : '',
					'{$btn_complete_vox}' => ($vox['status'] == true) ? '<a class="new" data-button-modal="complete_vox"><i class="fas fa-check"></i></a>' : '',
					'{$btn_reopen_vox}' => ($vox['status'] == false) ? '<a class="new" data-button-modal="reopen_vox"><i class="fas fa-reply"></i></a>' : '',
					'{$mdl_get_attachments}' => $mdl_get_attachments,
					'{$div_assigned_users}' => $div_assigned_users,
					'{$div_viewed_by}' => $div_viewed_by,
					'{$mdl_get_comments}' => $mdl_get_comments,
					'{$div_changes_history}' => $div_changes_history,
					'{$mdl_comment_vox}' => $mdl_comment_vox,
					'{$mdl_complete_vox}' => $mdl_complete_vox,
					'{$mdl_reopen_vox}' => $mdl_reopen_vox
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
		$vox = $this->model->get_vox($params[0], true);

		if (!empty($vox))
		{
			if (Format::exist_ajax_request() == true)
			{
				if ($_POST['action'] == 'get_opt_owners')
				{
					$html = '<option value="" hidden>{$lang.choose}</option>';

					foreach ($this->model->get_owners($_POST['type']) as $value)
						$html .= '<option value="' . $value['id'] . '">' . $value['name'][$this->lang] . (!empty($value['number']) ? ' #' . $value['number'] : '') . '</option>';

					Functions::environment([
						'status' => 'success',
						'html' => $html
					]);
				}

				if ($_POST['action'] == 'get_reservation')
				{
					$query = $this->model->get_owner($_POST['owner']);

					if (!empty($query))
					{
						$query = $this->model->get_reservation($query['number']);

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
					$html = '<option value="" hidden>{$lang.choose}</option>';

					foreach ($this->model->get_opportunity_areas($_POST['type']) as $value)
						$html .= '<option value="' . $value['id'] . '">' . $value['name'][$this->lang] . '</option>';

					Functions::environment([
						'status' => 'success',
						'html' => $html
					]);
				}

				if ($_POST['action'] == 'get_opt_opportunity_types')
				{
					$html = '<option value="" hidden>{$lang.choose}</option>';

					if (!empty($_POST['opportunity_area']))
					{
						foreach ($this->model->get_opportunity_types($_POST['opportunity_area'], $_POST['type']) as $value)
							$html .= '<option value="' . $value['id'] . '">' . $value['name'][$this->lang] . '</option>';
					}

					Functions::environment([
						'status' => 'success',
						'html' => $html
					]);
				}

				if ($_POST['action'] == 'get_opt_locations')
				{
					$html = '<option value="" hidden>{$lang.choose}</option>';

					foreach ($this->model->get_locations($_POST['type']) as $value)
						$html .= '<option value="' . $value['id'] . '">' . $value['name'][$this->lang] . '</option>';

					Functions::environment([
						'status' => 'success',
						'html' => $html
					]);
				}

				if ($_POST['action'] == 'edit_vox')
				{
					$labels = [];

					if (!isset($_POST['type']) OR empty($_POST['type']))
						array_push($labels, ['type','']);

					if (!isset($_POST['owner']) OR empty($_POST['owner']))
						array_push($labels, ['owner','']);

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

					if (empty($labels))
					{
						$_POST['id'] = $vox['id'];
						$_POST['token'] = $vox['token'];
						$_POST['assigned_users'] = !empty($_POST['assigned_users']) ? $_POST['assigned_users'] : [];
						$_POST['attachments'] = $_FILES['attachments'];

						$query = $this->model->edit_vox($_POST);

						if (!empty($query))
						{
							$_POST['assigned_users'] = $this->model->get_assigned_users($_POST['assigned_users'], $_POST['opportunity_area']);

							$mail = new Mailer(true);

							try
							{
								$mail->setFrom('noreply@guestvox.com', 'Guestvox');

								foreach ($_POST['assigned_users'] as $value)
									$mail->addAddress($value['email'], $value['firstname'] . ' ' . $value['lastname']);

								$mail->Subject = Languages::email('edited_vox')[$this->lang];
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
														<img style="width:100%;max-width:300px;" src="https://' . Configuration::$domain . '/images/logotype_color.png">
													</figure>
												</td>
											</tr>
											<tr style="width:100%;margin:0px 0px 10px 0px;padding:0px;border:0px;">
												<td style="width:100%;margin:0px;padding:40px 20px;border:0px;box-sizing:border-box;background-color:#fff;">
													<h4 style="width:100%;margin:0px 0px 20px 0px;padding:0px;font-size:24px;font-weight:600;text-align:center;color:#212121;">' . $mail->Subject . '</h4>
													<a style="width:100%;display:block;margin:0px;padding:20px 0px;border-radius:50px;box-sizing:border-box;background-color:#00a5ab;font-size:14px;font-weight:400;text-align:center;text-decoration:none;color:#fff;" href="https://' . Configuration::$domain . '/voxes/details/' . $vox['token'] . '">' . Languages::email('view_details')[$this->lang] . '</a>
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

							$sms = $this->model->get_sms();

							if ($sms > 0)
							{
								$sms_basic  = new \Nexmo\Client\Credentials\Basic('45669cce', 'CR1Vg1bpkviV8Jzc');
								$sms_client = new \Nexmo\Client($sms_basic);
								$sms_text = Languages::email('edited_vox')[$this->lang] . '. https://' . Configuration::$domain . '/voxes/details/' . $vox['token'];

								foreach ($_POST['assigned_users'] as $value)
								{
									if ($sms > 0)
									{
										try
										{
											$sms_client->message()->send([
												'to' => $value['phone']['lada'] . $value['phone']['number'],
												'from' => 'Guestvox',
												'text' => $sms_text
											]);

											$sms = $sms - 1;
										}
										catch (Exception $e) { }
									}
								}

								$this->model->edit_sms($sms);
							}

							Functions::environment([
								'status' => 'success',
								'path' => '/voxes/details/' . $vox['token'],
								'message' => '{$lang.operation_success}'
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
				$template = $this->view->render($this, 'edit');

				define('_title', 'Guestvox | {$lang.voxes} | {$lang.edit}');

				$frm_edit_vox =
				'<div class="span12">
                    <div class="tabers">
                        <div>
                            <input id="rqrd" type="radio" name="type" value="request" ' . (($vox['type'] == 'request') ? 'checked' : '') . '>
                            <label for="rqrd">
								<i class="fas fa-rocket"></i>
								<span>{$lang.request}</span>
							</label>
                        </div>
                        <div>
                            <input id="inrd" type="radio" name="type" value="incident" ' . (($vox['type'] == 'incident') ? 'checked' : '') . '>
                            <label for="inrd">
								<i class="fas fa-meteor"></i>
								<span>{$lang.incident}</span>
							</label>
                        </div>
                        <div>
                            <input id="wkrd" type="radio" name="type" value="workorder" ' . (($vox['type'] == 'workorder') ? 'checked' : '') . '>
                            <label for="wkrd">
								<i class="fas fa-bomb"></i>
								<span>{$lang.work_o}</span>
							</label>
                        </div>
                    </div>
                </div>
				<div class="span3">
					<div class="label">
						<label required>
							<p>{$lang.owner}</p>
							<select name="owner">';

				foreach ($this->model->get_owners($vox['type']) as $value)
					$frm_edit_vox .= '<option value="' . $value['id'] . '" ' . (($vox['owner'] == $value['id']) ? 'selected' : '') . '>' . $value['name'][$this->lang] . (!empty($value['number']) ? ' #' . $value['number'] : '') . '</option>';

				$frm_edit_vox .=
				'			</select>
						</label>
					</div>
				</div>
				<div class="span3">
					<div class="label">
						<label required>
							<p>{$lang.opportunity_area}</p>
							<select name="opportunity_area">';

				foreach ($this->model->get_opportunity_areas($vox['type']) as $value)
					$frm_edit_vox .= '<option value="' . $value['id'] . '" ' . (($vox['opportunity_area'] == $value['id']) ? 'selected' : '') . '>' . $value['name'][$this->lang] . '</option>';

				$frm_edit_vox .=
				'			</select>
						</label>
					</div>
				</div>
				<div class="span3">
					<div class="label">
						<label required>
							<p>{$lang.opportunity_type}</p>
							<select name="opportunity_type">';

				foreach ($this->model->get_opportunity_types($vox['opportunity_area'], $vox['type']) as $value)
					$frm_edit_vox .= '<option value="' . $value['id'] . '" ' . (($vox['opportunity_type'] == $value['id']) ? 'selected' : '') . '>' . $value['name'][$this->lang] . '</option>';

				$frm_edit_vox .=
				'			</select>
						</label>
					</div>
				</div>
				<div class="span3">
					<div class="label">
						<label required>
							<p>{$lang.date}</p>
							<input type="date" name="started_date" value="' . $vox['started_date'] . '">' . '
						</label>
					</div>
				</div>
				<div class="span3">
					<div class="label">
						<label required>
							<p>{$lang.hour}</p>
							<input type="time" name="started_hour" value="' . $vox['started_hour'] . '">
						</label>
					</div>
				</div>
				<div class="span3">
					<div class="label">
						<label required>
							<p>{$lang.location}</p>
							<select name="location">';

				foreach ($this->model->get_locations($vox['type']) as $value)
					$frm_edit_vox .= '<option value="' . $value['id'] . '" ' . (($vox['location'] == $value['id']) ? 'selected' : '') . '>' . $value['name'][$this->lang] . '</option>';

				$frm_edit_vox .=
				'			</select>
						</label>
					</div>
				</div>
				<div class="span3 ' . (($vox['type'] == 'incident' OR $vox['type'] == 'workorder') ? '' : 'hidden') . '">
					<div class="label">
						<label unrequired>
							<p>(' . Session::get_value('account')['currency'] . ') {$lang.cost}</p>
							<input type="number" name="cost" value="' . $vox['cost'] . '">
						</label>
					</div>
				</div>
				<div class="span3">
					<div class="label">
						<label required>
							<p>{$lang.urgency}</p>
							<select name="urgency">
								<option value="low" ' . (($vox['urgency'] == 'low') ? 'selected' : '') . '>{$lang.low}</option>
								<option value="medium" ' . (($vox['urgency'] == 'medium') ? 'selected' : '') . '>{$lang.medium}</option>
								<option value="high" ' . (($vox['urgency'] == 'high') ? 'selected' : '') . '>{$lang.high}</option>
							</select>
						</label>
					</div>
				</div>
				<div class="span3 ' . (($vox['type'] == 'request' OR $vox['type'] == 'workorder') ? '' : 'hidden') . '">
					<div class="label">
						<label class="' . (!empty($vox['observations']) ? 'success' : '') . '" unrequired>
							<p>{$lang.observations}</p>
							<input type="text" name="observations" value="' . $vox['observations'] . '">
						</label>
					</div>
				</div>
				<div class="span3 ' . (($vox['type'] == 'incident') ? '' : 'hidden') . '">
					<div class="label">
						<label unrequired>
							<p>{$lang.confidentiality}</p>
							<div class="switch ' . (($vox['confidentiality'] == true) ? 'checked' : '') . '">
								<input id="cfsw" type="checkbox" name="confidentiality" data-switcher ' . (($vox['confidentiality'] == true) ? 'checked' : '') . '>
								<label for="cfsw"></label>
							</div>
						</label>
					</div>
				</div>
				<div class="span3">
					<div class="label">
						<label unrequired>
							<p>{$lang.assigned_users}</p>
							<select name="assigned_users[]" class="chosen-select" multiple>';

				foreach ($this->model->get_users() as $value)
					$frm_edit_vox .= '<option value="' . $value['id'] . '" ' . (in_array($value['id'], $vox['assigned_users']) ? 'selected' : '') . '>' . $value['firstname'] . ' ' . $value['lastname'] . '</option>';

				$frm_edit_vox .=
				'			</select>
						</label>
					</div>
				</div>
				<div class="span6 ' . (($vox['type'] == 'incident') ? '' : 'hidden') . '">
					<div class="label">
						<label unrequired>
							<p>{$lang.subject}</p>
							<input type="text" name="subject" value="' . $vox['subject'] . '">
						</label>
					</div>
				</div>
				<div class="span6 ' . (($vox['type'] == 'incident') ? '' : 'hidden') . '">
					<div class="label">
						<label unrequired>
							<p>{$lang.description}</p>
							<textarea name="description">' . $vox['description'] . '</textarea>
						</label>
					</div>
				</div>
				<div class="span6 ' . (($vox['type'] == 'incident') ? '' : 'hidden') . '">
					<div class="label">
						<label unrequired>
							<p>{$lang.action_taken}</p>
							<textarea name="action_taken">' . $vox['action_taken'] . '</textarea>
						</label>
					</div>
				</div>';

				if (Session::get_value('account')['type'] == 'hotel')
				{
					$frm_edit_vox .=
					'<div class="span3 ' . (($vox['type'] == 'request' OR $vox['type'] == 'incident') ? '' : 'hidden') . '">
						<div class="label">
							<label unrequired>
								<p>{$lang.guest_treatment}</p>
								<select name="guest_treatment">
									<option value="">{$lang.empty} ({$lang.choose})</option>';

					foreach ($this->model->get_guests_treatments() as $value)
						$frm_edit_vox .= '<option value="' . $value['id'] . '" ' . (($vox['guest_treatment'] == $value['id']) ? 'selected' : '') . '>' . $value['name'] . '</option>';

					$frm_edit_vox .=
					'			</select>
							</label>
						</div>
					</div>';
				}

				$frm_edit_vox .=
				'<div class="span3 ' . (($vox['type'] == 'request' OR $vox['type'] == 'incident') ? '' : 'hidden') . '">
					<div class="label">
						<label unrequired>
							<p>{$lang.firstname}</p>
							<input type="text" name="firstname" value="' . $vox['firstname'] . '">
						</label>
					</div>
				</div>
				<div class="span3 ' . (($vox['type'] == 'request' OR $vox['type'] == 'incident') ? '' : 'hidden') . '">
					<div class="label">
						<label unrequired>
							<p>{$lang.lastname}</p>
							<input type="text" name="lastname" value="' . $vox['lastname'] . '">
						</label>
					</div>
				</div>';

				if (Session::get_value('account')['type'] == 'hotel')
				{
					$frm_edit_vox .=
					'<div class="span3 ' . (($vox['type'] == 'incident') ? '' : 'hidden') . '">
						<div class="label">
							<label unrequired>
								<p>{$lang.guest_id}</p>
								<input type="text" name="guest_id" value="' . $vox['guest_id'] . '">
							</label>
						</div>
					</div>
					<div class="span3 ' . (($vox['type'] == 'incident') ? '' : 'hidden') . '">
						<div class="label">
							<label unrequired>
								<p>{$lang.guest_type}</p>
								<select name="guest_type">
									<option value="">{$lang.empty} ({$lang.choose})</option>';

					foreach ($this->model->get_guests_types() as $value)
						$frm_edit_vox .= '<option value="' . $value['id'] . '" ' . (($vox['guest_type'] == $value['id']) ? 'selected' : '') . '>' . $value['name'] . '</option>';

					$frm_edit_vox .=
					'			</select>
							</label>
						</div>
					</div>
					<div class="span3 ' . (($vox['type'] == 'incident') ? '' : 'hidden') . '">
						<div class="label">
							<label unrequired>
								<p>{$lang.reservation_number}</p>
								<input type="text" name="reservation_number" value="' . $vox['reservation_number'] . '">
							</label>
						</div>
					</div>
					<div class="span3 ' . (($vox['type'] == 'incident') ? '' : 'hidden') . '">
						<div class="label">
							<label unrequired>
								<p>{$lang.reservation_status}</p>
								<select name="reservation_status">
									<option value="">{$lang.empty} ({$lang.choose})</option>';

					foreach ($this->model->get_reservations_statuses() as $value)
						$frm_edit_vox .= '<option value="' . $value['id'] . '" ' . (($vox['reservation_status'] == $value['id']) ? 'selected' : '') . '>' . $value['name'] . '</option>';

					$frm_edit_vox .=
					'			</select>
							</label>
						</div>
					</div>
					<div class="span3 ' . (($vox['type'] == 'incident') ? '' : 'hidden') . '">
						<div class="label">
							<label unrequired>
								<p>{$lang.check_in}</p>
								<input type="date" name="check_in" value="' . Functions::get_formatted_date($vox['check_in']) . '">
							</label>
						</div>
					</div>
					<div class="span3 ' . (($vox['type'] == 'incident') ? '' : 'hidden') . '">
						<div class="label">
							<label unrequired>
								<p>{$lang.check_out}</p>
								<input type="date" name="check_out" value="' . Functions::get_formatted_date($vox['check_out']) . '">
							</label>
						</div>
					</div>';
				}

				$frm_edit_vox .=
				'<div class="span12">
                    <div class="stl_3" data-uploader="multiple">
                        <div data-preview>
						<div data-image>
								<i class="fas fa-file-image"></i>
								<span><strong>0</strong>{$lang.images}</span>
							</div>
							<div data-pdf>
								<i class="fas fa-file-pdf"></i>
								<span><strong>0</strong>{$lang.pdf}</span>
							</div>
							<div data-word>
								<i class="fas fa-file-word"></i>
								<span><strong>0</strong>{$lang.word}</span>
							</div>
							<div data-excel>
								<i class="fas fa-file-excel"></i>
								<span><strong>0</strong>{$lang.excel}</span>
							</div>
						</div>
                        <a data-select><i class="fas fa-cloud-upload-alt"></i></a>
                        <input type="file" name="attachments[]" accept="image/*, application/pdf, application/vnd.ms-word, application/vnd.openxmlformats-officedocument.wordprocessingml.document, application/vnd.ms-excel, application/vnd.openxmlformats-officedocument.spreadsheetml.sheet" multiple data-upload>
                    </div>
                </div>';

				$replace = [
					'{$frm_edit_vox}' => $frm_edit_vox,
					'{$token}' => $vox['token']
			];

				$template = $this->format->replace($replace, $template);

				echo $template;
			}
		}
		else
			header('Location: /voxes');
	}

	public function stats()
	{
		if (Format::exist_ajax_request() == true)
		{
			if ($_POST['action'] == 'filter_voxes_stats')
			{
				$settings = Session::get_value('settings');

				$settings['voxes']['stats']['filter']['started_date'] = $_POST['started_date'];
				$settings['voxes']['stats']['filter']['end_date'] = $_POST['end_date'];
				$settings['voxes']['stats']['filter']['type'] = $_POST['type'];

				Session::set_value('settings', $settings);

				Functions::environment([
					'status' => 'success'
				]);
			}
		}
		else
		{
			$template = $this->view->render($this, 'stats');

			define('_title', 'Guestvox | {$lang.voxes} | {$lang.stats}');

			$replace = [
				'{$voxes_average}' => $this->model->get_voxes_average(),
				'{$voxes_count_open}' => $this->model->get_voxes_count('open'),
				'{$voxes_count_close}' => $this->model->get_voxes_count('close'),
				'{$voxes_count_total}' => $this->model->get_voxes_count('total'),
				'{$voxes_count_today}' => $this->model->get_voxes_count('today'),
				'{$voxes_count_week}' => $this->model->get_voxes_count('week'),
				'{$voxes_count_month}' => $this->model->get_voxes_count('month'),
				'{$voxes_count_year}' => $this->model->get_voxes_count('year')
			];

			$template = $this->format->replace($replace, $template);

			echo $template;
		}
	}

	public function charts()
	{
		header('Content-Type: application/javascript');

		$v_oa_chart_data = $this->model->get_chart_data('v_oa_chart');
		$v_o_chart_data = $this->model->get_chart_data('v_o_chart');
		$v_l_chart_data = $this->model->get_chart_data('v_l_chart');
		$ar_oa_chart_data = $this->model->get_chart_data('ar_oa_chart');
		$ar_o_chart_data = $this->model->get_chart_data('ar_o_chart');
		$ar_l_chart_data = $this->model->get_chart_data('ar_l_chart');
		$c_oa_chart_data = $this->model->get_chart_data('c_oa_chart');
		$c_o_chart_data = $this->model->get_chart_data('c_o_chart');
		$c_l_chart_data = $this->model->get_chart_data('c_l_chart');

		$js =
		"'use strict';

		var v_oa_chart = {
	        type: 'doughnut',
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
					text: '" . Languages::charts('v_oa_chart')[$this->lang] . "'
				},
				legend: {
					display: true,
					position: 'left'
				},
	            responsive: true
            }
        };

		var v_o_chart = {
	        type: 'doughnut',
	        data: {
				labels: [
	                " . $v_o_chart_data['labels'] . "
	            ],
				datasets: [{
	                data: [
	                    " . $v_o_chart_data['datasets']['data'] . "
	                ],
	                backgroundColor: [
	                    " . $v_o_chart_data['datasets']['colors'] . "
	                ],
	            }],
	        },
	        options: {
				title: {
					display: true,
					text: '" . Languages::charts('v_o_chart')[$this->lang] . "'
				},
				legend: {
					display: true,
					position: 'left'
				},
	            responsive: true
            }
        };

		var v_l_chart = {
	        type: 'doughnut',
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
					text: '" . Languages::charts('v_l_chart')[$this->lang] . "'
				},
				legend: {
					display: true,
					position: 'left'
				},
	            responsive: true
            }
        };

		var ar_oa_chart = {
	        type: 'pie',
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
					text: '" . Languages::charts('ar_oa_chart')[$this->lang] . "'
				},
				legend: {
					display: true,
					position: 'left'
				},
	            responsive: true
            }
        };

		var ar_o_chart = {
	        type: 'pie',
	        data: {
				labels: [
	                " . $ar_o_chart_data['labels'] . "
	            ],
				datasets: [{
	                data: [
	                    " . $ar_o_chart_data['datasets']['data'] . "
	                ],
	                backgroundColor: [
	                    " . $ar_o_chart_data['datasets']['colors'] . "
	                ],
	            }],
	        },
	        options: {
				title: {
					display: true,
					text: '" . Languages::charts('ar_o_chart')[$this->lang] . "'
				},
				legend: {
					display: true,
					position: 'left'
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
					text: '" . Languages::charts('ar_l_chart')[$this->lang] . "'
				},
				legend: {
					display: true,
					position: 'left'
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
					text: '" . Languages::charts('c_oa_chart')[$this->lang] . "'
				},
				legend: {
					display: true,
					position: 'left'
				},
	            responsive: true
            }
        };

		var c_o_chart = {
	        type: 'pie',
	        data: {
				labels: [
	                " . $c_o_chart_data['labels'] . "
	            ],
				datasets: [{
	                data: [
	                    " . $c_o_chart_data['datasets']['data'] . "
	                ],
	                backgroundColor: [
	                    " . $c_o_chart_data['datasets']['colors'] . "
	                ],
	            }],
	        },
	        options: {
				title: {
					display: true,
					text: '" . Languages::charts('c_o_chart')[$this->lang] . "'
				},
				legend: {
					display: true,
					position: 'left'
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
					text: '" . Languages::charts('c_l_chart')[$this->lang] . "'
				},
				legend: {
					display: true,
					position: 'left'
				},
	            responsive: true
            }
        };

		window.onload = function()
		{
			v_oa_chart = new Chart(document.getElementById('v_oa_chart').getContext('2d'), v_oa_chart);
			v_o_chart = new Chart(document.getElementById('v_o_chart').getContext('2d'), v_o_chart);
			v_l_chart = new Chart(document.getElementById('v_l_chart').getContext('2d'), v_l_chart);
			ar_oa_chart = new Chart(document.getElementById('ar_oa_chart').getContext('2d'), ar_oa_chart);
			ar_o_chart = new Chart(document.getElementById('ar_o_chart').getContext('2d'), ar_o_chart);
			ar_l_chart = new Chart(document.getElementById('ar_l_chart').getContext('2d'), ar_l_chart);
			c_oa_chart = new Chart(document.getElementById('c_oa_chart').getContext('2d'), c_oa_chart);
			c_o_chart = new Chart(document.getElementById('c_o_chart').getContext('2d'), c_o_chart);
			c_l_chart = new Chart(document.getElementById('c_l_chart').getContext('2d'), c_l_chart);
		};";

		$js = trim(str_replace(array("\t\t\t"), '', $js));

		echo $js;
	}

	public function reports($params)
	{
		if (Format::exist_ajax_request() == true)
		{
			if ($_POST['action'] == 'get_vox_report')
			{
				$query = $this->model->get_vox_report($_POST['id']);

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

			if ($_POST['action'] == 'get_opt_owners')
			{
				$html = '<option value="">{$lang.all}</option>';

				foreach ($this->model->get_owners($_POST['type']) as $value)
					$html .= '<option value="' . $value['id'] . '">' . $value['name'][$this->lang] . (!empty($value['number']) ? ' #' . $value['number'] : '') . '</option>';

				Functions::environment([
					'status' => 'success',
					'html' => $html
				]);
			}

			if ($_POST['action'] == 'get_opt_opportunity_areas')
			{
				$html = '<option value="">{$lang.all}</option>';

				foreach ($this->model->get_opportunity_areas($_POST['type']) as $value)
					$html .= '<option value="' . $value['id'] . '">' . $value['name'][$this->lang] . '</option>';

				Functions::environment([
					'status' => 'success',
					'html' => $html
				]);
			}

			if ($_POST['action'] == 'get_opt_opportunity_types')
			{
				$html = '<option value="">{$lang.all}</option>';

				if (!empty($_POST['opportunity_area']) AND $_POST['opportunity_area'] != 'all')
				{
					foreach ($this->model->get_opportunity_types($_POST['opportunity_area'], $_POST['type']) as $value)
						$html .= '<option value="' . $value['id'] . '">' . $value['name'][$this->lang] . '</option>';
				}

				Functions::environment([
					'status' => 'success',
					'html' => $html
				]);
			}

			if ($_POST['action'] == 'get_opt_locations')
			{
				$html = '<option value="">{$lang.all}</option>';

				foreach ($this->model->get_locations($_POST['type']) as $value)
					$html .= '<option value="' . $value['id'] . '">' . $value['name'][$this->lang] . '</option>';

				Functions::environment([
					'status' => 'success',
					'html' => $html
				]);
			}

			if ($_POST['action'] == 'get_cbx_opportunity_areas')
			{
				$html =
				'<div>
					<input type="checkbox" name="checked_all">
					<span><strong>{$lang.all}</strong></span>
				</div>';

				foreach ($this->model->get_opportunity_areas($_POST['type']) as $value)
				{
					$html .=
					'<div>
						<input type="checkbox" name="opportunity_areas[]" value="' . $value['id'] . '">
						<span>' . $value['name'][$this->lang] . '</span>
					</div>';
				}

				Functions::environment([
					'status' => 'success',
					'html' => $html
				]);
			}

			if ($_POST['action'] == 'get_cbx_vox_report_fields')
			{
				$html =
				'<div>
					<input type="checkbox" name="checked_all">
					<span><strong>{$lang.all}</strong></span>
				</div>';

				foreach ($this->model->get_vox_report_fields($_POST['type']) as $value)
				{
					$html .=
					'<div>
						<input type="checkbox" name="fields[]" value="' . $value['id'] . '">
						<span>{$lang.' . $value['name'] . '}</span>
					</div>';
				}

				Functions::environment([
					'status' => 'success',
					'html' => $html
				]);
			}

			if ($_POST['action'] == 'filter_vox_report')
			{
				$labels = [];

				if (!isset($_POST['report']) OR empty($_POST['report']))
					array_push($labels, ['report','']);

				if (!isset($_POST['type']) OR empty($_POST['type']))
					array_push($labels, ['type','']);

				if (!isset($_POST['order']) OR empty($_POST['order']))
					array_push($labels, ['order','']);

				if (!isset($_POST['started_date']) OR empty($_POST['started_date']) OR $_POST['started_date'] > Functions::get_current_date() OR $_POST['started_date'] > $_POST['end_date'])
					array_push($labels, ['started_date','']);

				if (!isset($_POST['end_date']) OR empty($_POST['end_date']) OR $_POST['end_date'] > Functions::get_current_date() OR $_POST['end_date'] < $_POST['started_date'])
					array_push($labels, ['end_date','']);

				if (!isset($_POST['fields']) OR empty($_POST['fields']))
					array_push($labels, ['fields[]','']);

				if (empty($labels))
				{
					$query = $this->model->get_voxes('report', $_POST);

					$html =
					'<div style="width:100%;display:flex;align-items:center;justify-content:center;flex-direction:column;padding:0px 40px 40px 40px;border-bottom:1px solid #eee;box-sizing:border-box;">
						<figure style="width:auto;height:200px;">
							<img style="width:auto;height:200px;" src="{$path.uploads}' . Session::get_value('account')['logotype'] . '">
						</figure>
						<p style="font-size:14px;font-weight:400;text-align:center;color:#757575;"><strong style="color:#212121;">' . Session::get_value('account')['name'] . '</strong></p>
						<p style="font-size:14px;font-weight:400;text-align:center;color:#757575;">{$lang.report_generate_by} ' . Session::get_value('user')['firstname'] . ' ' . Session::get_value('user')['lastname'] . ' {$lang.the} ' . Functions::get_current_date() . ' {$lang.at} ' . Functions::get_formatted_hour(Functions::get_current_hour(), '+ hrs') . '</p>
					</div>';

					foreach ($query as $value)
					{
						$html .= '<div style="width:100%;padding:40px;border-bottom:1px solid #eee;box-sizing:border-box;">';

						if (in_array('type', $_POST['fields']))
							$html .= '<p style="font-size:14px;font-weight:400;color:#757575;"><strong style="color:#212121;">{$lang.type}:</strong> {$lang.' . $value['type'] . '}</p>';

						$html .= '<p style="font-size:14px;font-weight:400;color:#757575;"><strong style="color:#212121;">{$lang.token}:</strong> ' . $value['token'] . '</p>';

						if (in_array('owner', $_POST['fields']))
							$html .= '<p style="font-size:14px;font-weight:400;color:#757575;"><strong style="color:#212121;">{$lang.owner}:</strong> ' . ((Session::get_value('account')['type'] == 'restaurant' AND !empty($value['menu_order']) AND $value['menu_order']['type_service'] == 'delivery') ? '{$lang.home_service}' : $value['owner']['name'][$this->lang] . (!empty($value['owner']['number']) ? ' #' . $value['owner']['number'] : '')) . '</p>';

						if (in_array('opportunity_area', $_POST['fields']))
							$html .= '<p style="font-size:14px;font-weight:400;color:#757575;"><strong style="color:#212121;">{$lang.opportunity_area}:</strong> ' . $value['opportunity_area']['name'][$this->lang] . '</p>';

						if (in_array('opportunity_type', $_POST['fields']))
							$html .= '<p style="font-size:14px;font-weight:400;color:#757575;"><strong style="color:#212121;">{$lang.opportunity_type}:</strong> ' . $value['opportunity_type']['name'][$this->lang] . '</p>';

						if (in_array('date', $_POST['fields']))
							$html .= '<p style="font-size:14px;font-weight:400;color:#757575;"><strong style="color:#212121;">{$lang.date}:</strong> ' . Functions::get_formatted_date($value['started_date'], 'd F, Y') . ' ' . Functions::get_formatted_hour($value['started_hour'], '+ hrs') . '</p>';

						if (in_array('location', $_POST['fields']))
							$html .= '<p style="font-size:14px;font-weight:400;color:#757575;"><strong style="color:#212121;">{$lang.location}:</strong> ' . ((Session::get_value('account')['type'] == 'restaurant' AND !empty($value['menu_order'])) ? (($value['menu_order']['type_service'] == 'delivery') ? $value['address'] : '{$lang.not_apply}') : $value['location']['name'][$this->lang]) . '</p>';

						if ($value['type'] == 'incident' OR $value['type'] == 'workorder')
						{
							if (in_array('cost', $_POST['fields']))
								$html .= '<p style="font-size:14px;font-weight:400;color:#757575;"><strong style="color:#212121;">{$lang.cost}:</strong> ' . Functions::get_formatted_currency((!empty($value['cost']) ? $value['cost'] : '0'), Session::get_value('account')['currency']) . '</p>';
						}

						if (in_array('urgency', $_POST['fields']))
							$html .= '<p style="font-size:14px;font-weight:400;color:#757575;"><strong style="color:#212121;">{$lang.urgency}:</strong> {$lang.' . $value['urgency'] . '}</p>';

						if ($value['type'] == 'incident')
						{
							if (in_array('confidentiality', $_POST['fields']))
								$html .= '<p style="font-size:14px;font-weight:400;color:#757575;"><strong style="color:#212121;">{$lang.confidentiality}:</strong> ' . (($value['confidentiality'] == true) ? '{$lang.yes_confidentiality}' : '{$lang.not_confidentiality}') . '</p>';
						}

						if (in_array('assigned_users', $_POST['fields']))
						{
							$str = '';

				            if (!empty($value['assigned_users']))
							{
								foreach ($value['assigned_users'] as $subvalue)
					                $str .= $subvalue['firstname'] . ' ' . $subvalue['lastname'] . ', ';

					            $str = substr($str, 0, -2);
							}
							else
								$str .= '{$lang.empty}';

							$html .= '<p style="font-size:14px;font-weight:400;color:#757575;"><strong style="color:#212121;">{$lang.assigned_users}:</strong> ' . $str . '</p>';
						}

						if ($value['type'] == 'request' OR $value['type'] == 'workorder')
						{
							if (in_array('observations', $_POST['fields']))
							{
								$str = '';

								if ($value['type'] == 'request')
								{
									if (Session::get_value('account')['type'] == 'hotel' OR Session::get_value('account')['type'] == 'restaurant')
									{
										if (!empty($value['menu_order']))
										{
											foreach ($value['menu_order']['shopping_cart'] as $subvalue)
												$str .= '(' . $subvalue['quantity'] . ') ' . $subvalue['name'][$this->lang] . ', ';

											$str .= Functions::get_formatted_currency($value['menu_order']['total'], $value['menu_order']['currency']) . '.';
										}
									}
								}

								$str .= (!empty($value['observations']) ? ' ' . $value['observations'] : ' {$lang.not_observations}');

								$html .= '<p style="font-size:14px;font-weight:400;color:#757575;"><strong style="color:#212121;">{$lang.observations}:</strong> ' . $str . '</p>';
							}
						}

						if ($value['type'] == 'incident')
						{
							if (in_array('subject', $_POST['fields']))
								$html .= '<p style="font-size:14px;font-weight:400;color:#757575;"><strong style="color:#212121;">{$lang.subject}:</strong> ' . (!empty($value['subject']) ? $value['subject'] : '{$lang.empty}') . '</p>';

							if (in_array('description', $_POST['fields']))
								$html .= '<p style="font-size:14px;font-weight:400;color:#757575;"><strong style="color:#212121;">{$lang.description}:</strong> ' . (!empty($value['description']) ? $value['description'] : '{$lang.empty}') . '</p>';

							if (in_array('action_taken', $_POST['fields']))
								$html .= '<p style="font-size:14px;font-weight:400;color:#757575;"><strong style="color:#212121;">{$lang.action_taken}:</strong> ' . (!empty($value['action_taken']) ? $value['action_taken'] : '{$lang.empty}') . '</p>';
						}

						if ($value['type'] == 'request' OR $value['type'] == 'incident')
						{
							if (in_array('name', $_POST['fields']))
								$html .= '<p style="font-size:14px;font-weight:400;color:#757575;"><strong style="color:#212121;">{$lang.name}:</strong> ' . (((Session::get_value('account')['type'] == 'hotel' AND !empty($value['menu_order'])) OR (Session::get_value('account')['type'] == 'restaurant' AND !empty($value['menu_order']) AND $value['menu_order']['type_service'] == 'restaurant')) ? '{$lang.not_apply}' : ((!empty($value['firstname']) AND !empty($value['lastname'])) ? ((Session::get_value('account')['type'] == 'hotel' AND !empty($value['guest_treatment'])) ? $value['guest_treatment']['name'] . ' ' : '') . $value['firstname'] . ' ' . $value['lastname'] :  '{$lang.empty}')) . '</p>';
						}

						if (Session::get_value('account')['type'] == 'hotel')
						{
							if ($value['type'] == 'incident')
							{
								if (in_array('guest_id', $_POST['fields']))
									$html .= '<p style="font-size:14px;font-weight:400;color:#757575;"><strong style="color:#212121;">{$lang.guest_id}:</strong> ' . (!empty($value['guest_id']) ? $value['guest_id'] : '{$lang.empty}') . '</p>';

								if (in_array('guest_type', $_POST['fields']))
									$html .= '<p style="font-size:14px;font-weight:400;color:#757575;"><strong style="color:#212121;">{$lang.guest_type}:</strong> ' . (!empty($value['guest_type']) ? $value['guest_type']['name'] : '{$lang.empty}') . '</p>';

								if (in_array('reservation_number', $_POST['fields']))
									$html .= '<p style="font-size:14px;font-weight:400;color:#757575;"><strong style="color:#212121;">{$lang.reservation_number}:</strong> ' . (!empty($value['reservation_number']) ? $value['reservation_number'] : '{$lang.empty}') . '</p>';

								if (in_array('reservation_status', $_POST['fields']))
									$html .= '<p style="font-size:14px;font-weight:400;color:#757575;"><strong style="color:#212121;">{$lang.reservation_status}:</strong> ' . (!empty($value['reservation_status']) ? $value['reservation_status']['name'] : '{$lang.empty}') . '</p>';

								if (in_array('staying', $_POST['fields']))
									$html .= '<p style="font-size:14px;font-weight:400;color:#757575;"><strong style="color:#212121;">{$lang.staying}:</strong> ' . ((!empty($value['check_in']) AND !empty($value['check_out'])) ? Functions::get_formatted_date($value['check_in'], 'd F, Y') . ' / ' . Functions::get_formatted_date($value['check_out'], 'd F, Y') : '{$lang.empty}') . '</p>';
							}
						}

						if (in_array('attachments', $_POST['fields']))
						{
							$str = '';

							if (!empty($value['attachments']))
							{
								$img = 0;
								$pdf = 0;
								$wrd = 0;
								$exl = 0;

								foreach ($value['attachments'] as $subvalue)
								{
									if ($subvalue['status'] == 'success')
									{
										$ext = strtoupper(explode('.', $subvalue['file'])[1]);

										if ($ext == 'JPG' OR $ext == 'JPEG' OR $ext == 'PNG')
											$img = $img + 1;
										else if ($ext == 'PDF')
											$pdf = $pdf + 1;
										else if ($ext == 'DOC' OR $ext == 'DOCX')
											$wrd = $wrd + 1;
										else if ($ext == 'XLS' OR $ext == 'XLSX')
											$exl = $exl + 1;
									}
								}

								if ($img > 0)
									$str .= '<img style="width:auto;height:20px;margin-right:5px;" src="{$path.images}empty.png">' . $img . ' {$lang.files}, ';

								if ($pdf > 0)
									$str .= '<img style="width:auto;height:20px;margin-right:5px;" src="{$path.images}pdf.png">' . $pdf . ' {$lang.files}, ';

								if ($wrd > 0)
									$str .= '<img style="width:auto;height:20px;margin-right:5px;" src="{$path.images}word.png">' . $wrd . ' {$lang.files}, ';

								if ($exl > 0)
									$str .= '<img style="width:auto;height:20px;margin-right:5px;" src="{$path.images}excel.png">' . $exl . ' {$lang.files}, ';

								$str = substr($str, 0, -2);
							}
							else
								$str .= '{$lang.empty}';

							$html .= '<p style="font-size:14px;font-weight:400;color:#757575;"><strong style="color:#212121;">{$lang.attachments}:</strong> ' . $str . '</p>';
						}

						if (in_array('viewed_by', $_POST['fields']))
						{
							$str = '';

							if (!empty($value['viewed_by']))
							{
								foreach ($value['viewed_by'] as $subvalue)
									$str .= $subvalue['firstname'] . ' ' . $subvalue['lastname'] . ', ';

								$str = substr($str, 0, -2);
							}
							else
								$str .= '{$lang.empty}';

							$html .= '<p style="font-size:14px;font-weight:400;color:#757575;"><strong style="color:#212121;">{$lang.viewed_by}:</strong> ' . $str . '</p>';
						}

						if (in_array('created', $_POST['fields']))
							$html .= '<p style="font-size:14px;font-weight:400;color:#757575;"><strong style="color:#212121;">{$lang.created}:</strong> ' . (($value['origin'] == 'myvox') ? '{$lang.myvox}' : $value['created_user']['firstname'] . ' ' . $value['created_user']['lastname']) . ' {$lang.at} ' . Functions::get_formatted_date_hour($value['created_date'], $value['created_hour']) . '</p>';

						if (in_array('edited', $_POST['fields']))
							$html .= '<p style="font-size:14px;font-weight:400;color:#757575;"><strong style="color:#212121;">{$lang.edited}:</strong> ' . (!empty($value['edited_user']) ? $value['edited_user']['firstname'] . ' ' . $value['edited_user']['lastname'] . ' {$lang.at} ' . Functions::get_formatted_date_hour($value['edited_date'], $value['edited_hour']) : '{$lang.empty}') . '</p>';

						if (in_array('completed', $_POST['fields']))
							$html .= '<p style="font-size:14px;font-weight:400;color:#757575;"><strong style="color:#212121;">{$lang.completed}:</strong> ' . (!empty($value['completed_user']) ? $value['completed_user']['firstname'] . ' ' . $value['completed_user']['lastname'] . ' {$lang.at} ' . Functions::get_formatted_date_hour($value['completed_date'], $value['completed_hour']) : '{$lang.empty}') . '</p>';

						if (in_array('reopened', $_POST['fields']))
							$html .= '<p style="font-size:14px;font-weight:400;color:#757575;"><strong style="color:#212121;">{$lang.reopened}:</strong> ' . (!empty($value['reopened_user']) ? $value['reopened_user']['firstname'] . ' ' . $value['reopened_user']['lastname'] . ' {$lang.at} ' . Functions::get_formatted_date_hour($value['reopened_date'], $value['reopened_hour']) : '{$lang.empty}') . '</p>';

						if (in_array('status', $_POST['fields']))
							$html .= '<p style="font-size:14px;font-weight:400;color:#757575;"><strong style="color:#212121;">{$lang.status}:</strong> {$lang.' . (($value['status'] == true) ? 'opened' : 'closed') . '}</p>';

						if (in_array('origin', $_POST['fields']))
							$html .= '<p style="font-size:14px;font-weight:400;color:#757575;"><strong style="color:#212121;">{$lang.origin}:</strong> {$lang.' . $value['origin'] . '}</p>';

						if (in_array('average_resolution', $_POST['fields']))
						{
							$str = '';

							if ($value['status'] == false AND !empty($value['completed_date']) AND !empty($value['completed_hour']))
							{
								$date1 = new DateTime($value['started_date'] . ' ' . $value['started_hour']);
								$date2 = new DateTime($value['completed_date'] . ' ' . $value['completed_hour']);
								$date3 = $date1->diff($date2);

								if ($date3->h == 0 AND $date3->i == 0)
									$str .= $date3->s . ' Seg';
								else if ($date3->h == 0 AND $date3->i > 0)
									$str .= $date3->i . ' Min';
								else if ($date3->h > 0 AND $date3->i == 0)
									$str .= $date3->h . ' Hrs';
								else if ($date3->h > 0 AND $date3->i > 0)
									$str .= $date3->h . ' Hrs ' . $date3->i . ' Min';
							}
							else
								$str .= '{$lang.empty}';

							$html .= '<p style="font-size:14px;font-weight:400;color:#757575;"><strong style="color:#212121;">{$lang.average_resolution}:</strong> ' . $str . '</p>';
						}

						if (in_array('comments', $_POST['fields']))
						{
							$str = '';

							if (!empty($value['comments']))
							{
								foreach ($value['comments'] as $subvalue)
									$str .= $subvalue['user']['firstname'] . ' ' . $subvalue['user']['lastname'] . ': ' . $subvalue['comment'];
							}
							else
								$str .= '{$lang.empty}';

							$html .= '<p style="font-size:14px;font-weight:400;color:#757575;"><strong style="color:#212121;">{$lang.comments}:</strong> ' . $str . '</p>';
						}

						$html .= '</div>';
					}

					$html .=
					'<div style="width:100%;display:flex;align-items:center;justify-content:center;flex-direction:column;padding:40px 40px 0px 40px;border-bottom:0px;box-sizing:border-box;">
						<p style="display:flex;align-items:center;justify-content:center;font-size:14px;font-weight:400;text-align:center;color:#757575;"><strong style="color:#212121;">Power by</strong> <img style="width:auto;height:20px;margin:0px 5px;" src="images/logotype_color.png"></p>
						<p style="display:flex;align-items:center;justify-content:center;font-size:14px;font-weight:400;text-align:center;color:#757575;">Copyright <i style="margin:0px 5px;" class="far fa-copyright" aria-hidden="true"></i> {$lang.all_right_reserved}</p>
					</div>';

					Functions::environment([
						'status' => 'success',
						'html' => $html,
						'print' => !empty($query) ? true : false
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

			if ($_POST['action'] == 'new_vox_report' OR $_POST['action'] == 'edit_vox_report')
			{
				$labels = [];

				if (!isset($_POST['name']) OR empty($_POST['name']))
					array_push($labels, ['name','']);

				if (!isset($_POST['type']) OR empty($_POST['type']))
					array_push($labels, ['type','']);

				if (!isset($_POST['order']) OR empty($_POST['order']))
					array_push($labels, ['order','']);

				if (!isset($_POST['time_period_type']) OR empty($_POST['time_period_type']))
					array_push($labels, ['time_period_type','']);

				if (!isset($_POST['time_period_number']) OR empty($_POST['time_period_number']) OR !is_numeric($_POST['time_period_number']) OR $_POST['time_period_number'] < 1)
					array_push($labels, ['time_period_number','']);

				if (!isset($_POST['addressed_to']) OR empty($_POST['addressed_to']))
					array_push($labels, ['addressed_to','']);

				if ($_POST['addressed_to'] == 'opportunity_areas')
				{
					if (!isset($_POST['opportunity_areas']) OR empty($_POST['opportunity_areas']))
						array_push($labels, ['opportunity_areas[]','']);
				}

				if (!isset($_POST['fields']) OR empty($_POST['fields']))
					array_push($labels, ['fields[]','']);

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
							'message' => '{$lang.operation_success}'
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

			if ($_POST['action'] == 'deactivate_vox_report' OR $_POST['action'] == 'activate_vox_report' OR $_POST['action'] == 'delete_vox_report')
			{
				if ($_POST['action'] == 'deactivate_vox_report')
					$query = $this->model->deactivate_vox_report($_POST['id']);
				else if ($_POST['action'] == 'activate_vox_report')
					$query = $this->model->activate_vox_report($_POST['id']);
				else if ($_POST['action'] == 'delete_vox_report')
					$query = $this->model->delete_vox_report($_POST['id']);

				if (!empty($query))
				{
					Functions::environment([
						'status' => 'success',
						'message' => '{$lang.operation_success}'
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
		}
		else
		{
			$template = $this->view->render($this, 'reports');

			define('_title', 'Guestvox | {$lang.voxes} | {$lang.reports}');

			$div_options = '';

			if (Functions::check_user_access(['{voxes_reports_create}','{voxes_reports_update}','{voxes_reports_deactivate}','{voxes_reports_activate}','{voxes_reports_delete}']) == true AND Functions::check_user_access(['{voxes_reports_print}']) == true)
			{
				$div_options .=
				'<div class="tabers">
					<div>
						<input id="sasw" type="radio" value="saved" ' . (($params[0] == 'saved') ? 'checked' : '') . '>
						<label for="sasw">
							<i class="fas fa-save"></i>
							<span>{$lang.saved}</span>
						</label>
					</div>
					<div>
		                <input id="gesw" type="radio" value="generate" ' . (($params[0] == 'generate') ? 'checked' : '') . '>
		                <label for="gesw">
							<i class="fas fa-bug"></i>
							<span>{$lang.generate}</span>
						</label>
		            </div>
				</div>';
			}

			$tbl_voxes_reports = '';
			$btn_new_vox_report = '';
			$mdl_new_vox_report = '';
			$mdl_deactivate_vox_report = '';
			$mdl_activate_vox_report = '';
			$mdl_delete_vox_report = '';

			if (Functions::check_user_access(['{voxes_reports_create}','{voxes_reports_update}','{voxes_reports_deactivate}','{voxes_reports_activate}','{voxes_reports_delete}']) == true)
			{
				if ($params[0] == 'saved')
				{
					$tbl_voxes_reports .= '<div class="tbl_stl_2" data-table>';

					foreach ($this->model->get_voxes_reports() as $value)
					{
						$tbl_voxes_reports .=
						'<div>
							<div class="datas">
								<h2>' . $value['name'] . '</h2>
								<span>{$lang.type}: {$lang.' . $value['type'] . '}</span>
								<span>{$lang.time_period}: ' . $value['time_period']['number'] . ' {$lang.' . $value['time_period']['type'] . '}</span>
								<span>{$lang.addressed_to}: {$lang.' . $value['addressed_to'] . '}</span>
							</div>
							<div class="buttons flex_right">
								' . ((Functions::check_user_access(['{voxes_reports_deactivate}','{voxes_reports_activate}']) == true) ? '<a class="big" data-action="' . (($value['status'] == true) ? 'deactivate_vox_report' : 'activate_vox_report') . '" data-id="' . $value['id'] . '">' . (($value['status'] == true) ? '<i class="fas fa-ban"></i><span>{$lang.deactivate}</span>' : '<i class="fas fa-check"></i><span>{$lang.activate}</span>') . '</a>' : '') . '
								' . ((Functions::check_user_access(['{voxes_reports_update}']) == true) ? '<a class="edit" data-action="edit_vox_report" data-id="' . $value['id'] . '"><i class="fas fa-pen"></i></a>' : '') . '
								' . ((Functions::check_user_access(['{voxes_reports_delete}']) == true) ? '<a class="delete" data-action="delete_vox_report" data-id="' . $value['id'] . '"><i class="fas fa-trash"></i></a>' : '') . '
							</div>
						</div>';
					}

					$tbl_voxes_reports .= '</div>';

					if (Functions::check_user_access(['{voxes_reports_create}']) == true)
						$btn_new_vox_report .= '<a class="new" data-button-modal="new_vox_report"><i class="fas fa-plus"></i></a>';

					if (Functions::check_user_access(['{voxes_reports_create}','{voxes_reports_update}']) == true)
					{
						$mdl_new_vox_report .=
						'<section class="modal fullscreen" data-modal="new_vox_report">
						    <div class="content">
						        <main>
						            <form name="new_vox_report">
						                <div class="row">
											<div class="span12">
												<div class="label">
													<label required>
														<p>{$lang.name}</p>
														<input type="text" name="name">
													</label>
												</div>
											</div>
											<div class="span6">
												<div class="label">
													<label required>
														<p>{$lang.type}</p>
														<select name="type">
															<option value="all">{$lang.all}</option>
															<option value="request">{$lang.request}</option>
															<option value="incident">{$lang.incident}</option>
															<option value="workorder">{$lang.workorder}</option>
														</select>
													</label>
												</div>
											</div>
											<div class="span6">
												<div class="label">
													<label unrequired>
														<p>{$lang.owner}</p>
														<select name="owner">
															<option value="">{$lang.all}</option>';

						foreach ($this->model->get_owners() as $value)
							$mdl_new_vox_report .= '<option value="' . $value['id'] . '">' . $value['name'][$this->lang] . (!empty($value['number']) ? ' #' . $value['number'] : '') . '</option>';

						$mdl_new_vox_report .=
						'			</select>
								</label>
							</div>
						</div>
						<div class="span6">
							<div class="label">
								<label unrequired>
									<p>{$lang.opportunity_area}</p>
									<select name="opportunity_area">
										<option value="">{$lang.all}</option>';

						foreach ($this->model->get_opportunity_areas() as $value)
							$mdl_new_vox_report .= '<option value="' . $value['id'] . '">' . $value['name'][$this->lang] . '</option>';

						$mdl_new_vox_report .=
						'			</select>
								</label>
							</div>
						</div>
						<div class="span6">
							<div class="label">
								<label unrequired>
									<p>{$lang.opportunity_type}</p>
									<select name="opportunity_type">
										<option value="">{$lang.all}</option>
									</select>
								</label>
							</div>
						</div>
						<div class="span6">
							<div class="label">
								<label unrequired>
									<p>{$lang.location}</p>
									<select name="location">
										<option value="">{$lang.all}</option>';

						foreach ($this->model->get_locations() as $value)
							$mdl_new_vox_report .= '<option value="' . $value['id'] . '">' . $value['name'][$this->lang] . '</option>';

						$mdl_new_vox_report .=
						'			</select>
								</label>
							</div>
						</div>
						<div class="span6">
							<div class="label">
								<label required>
									<p>{$lang.order_by}</p>
									<select name="order">
										<option value="owner">{$lang.owner}</option>
										<option value="name">{$lang.name}</option>
									</select>
								</label>
							</div>
						</div>
						<div class="span3">
							<div class="label">
								<label required>
									<p>{$lang.time_period_type}</p>
									<select name="time_period_type">
										<option value="days">{$lang.days}</option>
										<option value="months">{$lang.months}</option>
										<option value="years">{$lang.years}</option>
									</select>
								</label>
							</div>
						</div>
						<div class="span3">
							<div class="label">
								<label required>
									<p>{$lang.time_period_number}</p>
									<input type="number" name="time_period_number" min="1" value="7">
								</label>
							</div>
						</div>
						<div class="span6">
							<div class="label">
								<label required>
									<p>{$lang.addressed_to}</p>
									<select name="addressed_to">
										' . ((Functions::check_user_access(['{view_all}']) == true) ? '<option value="alls">{$lang.alls}</option>' : '') . '
										' . ((Functions::check_user_access(['{view_all}','{view_opportunity_areas}']) == true) ? '<option value="opportunity_areas">{$lang.only_opportunity_areas}</option>' : '') . '
										<option value="me">{$lang.only_me}</option>
									</select>
								</label>
							</div>
						</div>
						<div class="span12 hidden">
							<div class="checkboxes stl_1">
								<p>{$lang.opportunity_areas}</p>
								<div>
									<input type="checkbox" name="checked_all">
									<span><strong>{$lang.all}</strong></span>
								</div>';

							foreach ($this->model->get_opportunity_areas() as $value)
							{
								$mdl_new_vox_report .=
								'<div>
									<input type="checkbox" name="opportunity_areas[]" value="' . $value['id'] . '">
									<span>' . $value['name'][$this->lang] . '</span>
								</div>';
							}

							$mdl_new_vox_report .=
							'	</div>
							</div>
							<div class="span12">
								<div class="checkboxes stl_1">
									<p>{$lang.fields}</p>
									<div>
										<input type="checkbox" name="checked_all">
										<span><strong>{$lang.all}</strong></span>
									</div>';

							foreach ($this->model->get_vox_report_fields() as $value)
							{
								$mdl_new_vox_report .=
								'<div>
									<input type="checkbox" name="fields[]" value="' . $value['id'] . '">
									<span>{$lang.' . $value['name'] . '}</span>
								</div>';
							}

							$mdl_new_vox_report .=
							'						</div>
												</div>
							                    <div class="span12">
							                        <div class="buttons">
							                            <a class="delete" button-cancel><i class="fas fa-times"></i></a>
							                            <button type="submit" class="new"><i class="fas fa-check"></i></button>
							                        </div>
							                    </div>
							                </div>
							            </form>
							        </main>
							    </div>
							</section>';
					}

					if (Functions::check_user_access(['{voxes_reports_deactivate}']) == true)
					{
						$mdl_deactivate_vox_report .=
						'<section class="modal edit" data-modal="deactivate_vox_report">
						    <div class="content">
						        <footer>
						            <a button-close><i class="fas fa-times"></i></a>
						            <a button-success><i class="fas fa-check"></i></a>
						        </footer>
						    </div>
						</section>';
					}

					if (Functions::check_user_access(['{voxes_reports_activate}']) == true)
					{
						$mdl_activate_vox_report .=
						'<section class="modal edit" data-modal="activate_vox_report">
						    <div class="content">
						        <footer>
						            <a button-close><i class="fas fa-times"></i></a>
						            <a button-success><i class="fas fa-check"></i></a>
						        </footer>
						    </div>
						</section>';
					}

					if (Functions::check_user_access(['{voxes_reports_delete}']) == true)
					{
						$mdl_delete_vox_report .=
						'<section class="modal delete" data-modal="delete_vox_report">
						    <div class="content">
						        <footer>
						            <a button-close><i class="fas fa-times"></i></a>
						            <a button-success><i class="fas fa-check"></i></a>
						        </footer>
						    </div>
						</section>';
					}
				}
			}

			$div_print_vox_report = '';
			$btn_filter_vox_report = '';
			$btn_print_vox_report = '';
			$mdl_filter_vox_report = '';

			if (Functions::check_user_access(['{voxes_reports_print}']) == true)
			{
				if ($params[0] == 'generate')
				{
					$div_print_vox_report .= '<div id="print_vox_report" class="tbl_stl_4" data-table></div>';
					$btn_filter_vox_report .= '<a class="big new" data-button-modal="filter_vox_report"><i class="fas fa-stream"></i><span>{$lang.filter}</span></a>';
					$btn_print_vox_report .= '<a class="big new hidden" data-action="print_vox_report"><i class="fas fa-print"></i><span>{$lang.print}</span></a>';
					$mdl_filter_vox_report .=
					'<section class="modal fullscreen" data-modal="filter_vox_report">
						<div class="content">
							<main>
								<form name="filter_vox_report">
									<div class="row">
										<div class="span12">
											<div class="label">
												<label required>
													<p>{$lang.report}</p>
													<select name="report">
														<option value="free">{$lang.free}</option>';

					foreach ($this->model->get_voxes_reports('actives') as $value)
						$mdl_filter_vox_report .= '<option value="' . $value['id'] . '">' . $value['name'] . '</option>';

					$mdl_filter_vox_report .=
					'			</select>
							</label>
						</div>
					</div>
					<div class="span6">
						<div class="label">
							<label required>
								<p>{$lang.type}</p>
								<select name="type">
									<option value="all">{$lang.all}</option>
									<option value="request">{$lang.request}</option>
									<option value="incident">{$lang.incident}</option>
									<option value="workorder">{$lang.workorder}</option>
								</select>
							</label>
						</div>
					</div>
					<div class="span6">
						<div class="label">
							<label unrequired>
								<p>{$lang.owner}</p>
								<select name="owner">
									<option value="">{$lang.all}</option>';

					foreach ($this->model->get_owners() as $value)
						$mdl_filter_vox_report .= '<option value="' . $value['id'] . '">' . $value['name'][$this->lang] . (!empty($value['number']) ? ' #' . $value['number'] : '') . '</option>';

					$mdl_filter_vox_report .=
					'			</select>
							</label>
						</div>
					</div>
					<div class="span6">
						<div class="label">
							<label unrequired>
								<p>{$lang.opportunity_area}</p>
								<select name="opportunity_area">
									<option value="">{$lang.all}</option>';

					foreach ($this->model->get_opportunity_areas() as $value)
						$mdl_filter_vox_report .= '<option value="' . $value['id'] . '">' . $value['name'][$this->lang] . '</option>';

					$mdl_filter_vox_report .=
					'			</select>
							</label>
						</div>
					</div>
					<div class="span6">
						<div class="label">
							<label unrequired>
								<p>{$lang.opportunity_type}</p>
								<select name="opportunity_type">
									<option value="">{$lang.all}</option>
								</select>
							</label>
						</div>
					</div>
					<div class="span6">
						<div class="label">
							<label unrequired>
								<p>{$lang.location}</p>
								<select name="location">
									<option value="">{$lang.all}</option>';

					foreach ($this->model->get_locations() as $value)
						$mdl_filter_vox_report .= '<option value="' . $value['id'] . '">' . $value['name'][$this->lang] . '</option>';

					$mdl_filter_vox_report .=
					'			</select>
							</label>
						</div>
					</div>
					<div class="span6">
						<div class="label">
							<label required>
								<p>{$lang.order_by}</p>
								<select name="order">
									<option value="owner">{$lang.owner}</option>
									<option value="name">{$lang.name}</option>
								</select>
							</label>
						</div>
					</div>
					<div class="span6">
	                    <div class="label">
	                        <label required>
	                            <p>{$lang.started_date}</p>
	                            <input type="date" name="started_date" value="' . Functions::get_current_date() . '" max="' . Functions::get_current_date() . '">
	                        </label>
	                    </div>
	                </div>
	                <div class="span6">
	                    <div class="label">
	                        <label required>
	                            <p>{$lang.end_date}</p>
	                            <input type="date" name="end_date" value="' . Functions::get_current_date() . '" max="' . Functions::get_current_date() . '">
	                        </label>
	                    </div>
	                </div>
					<div class="span12">
						<div class="checkboxes stl_1">
							<p>{$lang.fields}</p>
							<div>
								<input type="checkbox" name="checked_all">
								<span><strong>{$lang.all}</strong></span>
							</div>';

					foreach ($this->model->get_vox_report_fields() as $value)
					{
						$mdl_filter_vox_report .=
						'<div>
							<input type="checkbox" name="fields[]" value="' . $value['id'] . '">
							<span>{$lang.' . $value['name'] . '}</span>
						</div>';
					}

					$mdl_filter_vox_report .=
					'						</div>
										</div>
										<div class="span12">
											<div class="buttons">
												<a class="delete" button-cancel><i class="fas fa-times"></i></a>
												<button type="submit" class="new"><i class="fas fa-check"></i></button>
											</div>
										</div>
									</div>
								</form>
							</main>
						</div>
					</section>';
				}
			}

			$replace = [
				'{$menu_focus}' => $params[0],
				'{$div_options}' => $div_options,
				'{$tbl_voxes_reports}' => $tbl_voxes_reports,
				'{$div_print_vox_report}' => $div_print_vox_report,
				'{$btn_new_vox_report}' => $btn_new_vox_report,
				'{$btn_filter_vox_report}' => $btn_filter_vox_report,
				'{$btn_print_vox_report}' => $btn_print_vox_report,
				'{$mdl_new_vox_report}' => $mdl_new_vox_report,
				'{$mdl_deactivate_vox_report}' => $mdl_deactivate_vox_report,
				'{$mdl_activate_vox_report}' => $mdl_activate_vox_report,
				'{$mdl_delete_vox_report}' => $mdl_delete_vox_report,
				'{$mdl_filter_vox_report}' => $mdl_filter_vox_report
			];

			$template = $this->format->replace($replace, $template);

			echo $template;
		}
	}
}
