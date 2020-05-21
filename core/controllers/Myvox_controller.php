<?php

defined('_EXEC') or die;

require_once 'plugins/nexmo/vendor/autoload.php';

class Myvox_controller extends Controller
{
	public function __construct()
	{
		parent::__construct();
	}

    public function index($params)
    {
		$break = true;

		$data['account'] = $this->model->get_account($params[0]);

		if (!empty($data['account']))
		{
			Session::set_value('account', $data['account']);

			if (isset($params[1]) AND !empty($params[1]))
			{
				if (isset($params[2]) AND !empty($params[2]))
					$data['owner'] = $params[2];
				else
					$data['owner'] = $params[1];
			}
			else
			{
				if (Session::exists_var('owner') == true AND !empty(Session::get_value('owner')['id']))
					$data['owner'] = Session::get_value('owner')['id'];
				else
					$data['owner'] = null;
			}

			$data['owner'] = $this->model->get_owner($data['owner']);

			if (!empty($data['owner']))
			{
				if (Session::get_value('account')['type'] == 'hotel')
					$data['owner']['reservation'] = $this->model->get_reservation($data['owner']['number']);

				Session::set_value('owner', $data['owner']);

				$break = false;
			}
		}

		if ($break == false)
		{
			if (Format::exist_ajax_request() == true)
			{
				if ($_POST['action'] == 'get_opt_owners')
				{
					$html = '<option value="" selected hidden>{$lang.choose}</option>';

					foreach ($this->model->get_owners($_POST['type']) as $value)
						$html .= '<option value="' . $value['id'] . '">' . $value['name'] . (!empty($value['number']) ? ' #' . $value['number'] : '') . '</option>';

					Functions::environment([
						'status' => 'success',
						'html' => $html
					]);
				}

				if ($_POST['action'] == 'get_opt_opportunity_areas')
				{
					$html = '<option value="" selected hidden>{$lang.choose}</option>';

					foreach ($this->model->get_opportunity_areas($_POST['type']) as $value)
						$html .= '<option value="' . $value['id'] . '">' . $value['name'][Session::get_value('lang')] . '</option>';

					Functions::environment([
						'status' => 'success',
						'html' => $html
					]);
				}

				if ($_POST['action'] == 'get_opt_opportunity_types')
				{
					$html = '<option value="" selected hidden>{$lang.choose}</option>';

					foreach ($this->model->get_opportunity_types($_POST['opportunity_area'], $_POST['type']) as $value)
						$html .= '<option value="' . $value['id'] . '">' . $value['name'][Session::get_value('lang')] . '</option>';

					Functions::environment([
						'status' => 'success',
						'html' => $html
					]);
				}

				if ($_POST['action'] == 'get_opt_locations')
				{
					$html = '<option value="" selected hidden>{$lang.choose}</option>';

					foreach ($this->model->get_locations($_POST['type']) as $value)
						$html .= '<option value="' . $value['id'] . '">' . $value['name'][Session::get_value('lang')] . '</option>';

					Functions::environment([
						'status' => 'success',
						'html' => $html
					]);
				}

				if ($_POST['action'] == 'get_owner')
				{
					$data['owner'] = $this->model->get_owner($_POST['owner']);

					if (!empty($data['owner']))
					{
						if (Session::get_value('account')['type'] == 'hotel')
							$data['owner']['reservation'] = $this->model->get_reservation($data['owner']['number']);

						Session::set_value('owner', $data['owner']);

						Functions::environment([
							'status' => 'success'
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

				if ($_POST['action'] == 'new_vox')
				{
					$labels = [];

					if (!isset($params[1]) OR empty($params[1]))
					{
						if (!isset($_POST['owner']) OR empty($_POST['owner']))
							array_push($labels, ['owner','']);
					}

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
					else if ($_POST['type'] == 'incident')
					{
						if (!empty($_POST['subject']) AND strlen($_POST['subject']) > 120)
							array_push($labels, ['subject','']);
					}

					if (empty($labels))
					{
						$_POST['token'] = Functions::get_random(8);

						$query = $this->model->new_vox($_POST);

						if (!empty($query))
						{
							$_POST['opportunity_area'] = $this->model->get_opportunity_area($_POST['opportunity_area']);
							$_POST['opportunity_type'] = $this->model->get_opportunity_type($_POST['opportunity_type']);
							$_POST['location'] = $this->model->get_location($_POST['location']);
							$_POST['assigned_users'] = $this->model->get_assigned_users($_POST['opportunity_area']['id']);

							$mail = new Mailer(true);

							try
							{
								$mail->isSMTP();
								$mail->setFrom('noreply@guestvox.com', 'Guestvox');

								foreach ($_POST['assigned_users'] as $value)
									$mail->addAddress($value['email'], $value['firstname'] . ' ' . $value['lastname']);

								$mail->isHTML(true);
								$mail->Subject = Mailer::lang('new', $_POST['type'])[Session::get_value('account')['language']];
								$mail->Body =
								'<html>
									<head>
										<title>' . Mailer::lang('new', $_POST['type'])[Session::get_value('account')['language']] . '</title>
									</head>
									<body>
										<table style="width:600px;margin:0px;padding:20px;border:0px;box-sizing:border-box;background-color:#eee">
											<tr style="width:100%;margin:0px 0px 10px 0px;padding:0px;border:0px;">
												<td style="width:100%;margin:0px;padding:40px 20px;border:0px;box-sizing:border-box;background-color:#fff;">
													<figure style="width:100%;margin:0px;padding:0px;text-align:center;">
														<img style="width:100%;max-width:300px;" src="https://' . Configuration::$domain . '/images/logotype-color.png" />
													</figure>
												</td>
											</tr>
											<tr style="width:100%;margin:0px 0px 10px 0px;padding:0px;border:0px;">
												<td style="width:100%;margin:0px;padding:40px 20px;border:0px;box-sizing:border-box;background-color:#fff;">
													<h4 style="width:100%;margin:0px 0px 20px 0px;padding:0px;font-size:24px;font-weight:600;text-align:center;color:#212121;">' . Mailer::lang('new', $_POST['type'])[Session::get_value('account')['language']] . '</h4>
													<h6 style="width:100%;margin:0px 0px 5px 0px;padding:0px;font-size:14px;font-weight:400;text-align:left;color:#757575;">' . Mailer::lang('token')[Session::get_value('account')['language']] . ': ' . $_POST['token'] . '</h6>
													<h6 style="width:100%;margin:0px 0px 5px 0px;padding:0px;font-size:14px;font-weight:400;text-align:left;color:#757575;">' . Mailer::lang('owner')[Session::get_value('account')['language']] . ': ' . Session::get_value('owner')['name'] . (!empty(Session::get_value('owner')['number']) ? ' #' . Session::get_value('owner')['number'] : '') . '</h6>
													<h6 style="width:100%;margin:0px 0px 5px 0px;padding:0px;font-size:14px;font-weight:400;text-align:left;color:#757575;">' . Mailer::lang('opportunity_area')[Session::get_value('account')['language']] . ': ' . $_POST['opportunity_area']['name'][Session::get_value('account')['language']] . '</h6>
													<h6 style="width:100%;margin:0px 0px 5px 0px;padding:0px;font-size:14px;font-weight:400;text-align:left;color:#757575;">' . Mailer::lang('opportunity_type')[Session::get_value('account')['language']] . ': ' . $_POST['opportunity_type']['name'][Session::get_value('account')['language']] . '</h6>
													<h6 style="width:100%;margin:0px 0px 5px 0px;padding:0px;font-size:14px;font-weight:400;text-align:left;color:#757575;">' . Mailer::lang('started_date')[Session::get_value('account')['language']] . ': ' . Functions::get_formatted_date($_POST['started_date'], 'd M, Y') . '</h6>
													<h6 style="width:100%;margin:0px 0px 5px 0px;padding:0px;font-size:14px;font-weight:400;text-align:left;color:#757575;">' . Mailer::lang('started_hour')[Session::get_value('account')['language']] . ': ' . Functions::get_formatted_hour($_POST['started_hour'], '+ hrs') . '</h6>
													<h6 style="width:100%;margin:0px 0px 5px 0px;padding:0px;font-size:14px;font-weight:400;text-align:left;color:#757575;">' . Mailer::lang('location')[Session::get_value('account')['language']] . ': ' . $_POST['location']['name'][Session::get_value('account')['language']] . '</h6>
													<h6 style="width:100%;margin:0px 0px 5px 0px;padding:0px;font-size:14px;font-weight:400;text-align:left;color:#757575;">' . Mailer::lang('urgency')[Session::get_value('account')['language']] . ': ' . Mailer::lang('medium')[Session::get_value('account')['language']] . '</h6>';

								if ($_POST['type'] == 'request')
									$mail->Body = '<p style="width:100%;margin:0px 0px 20px 0px;padding:0px;font-size:14px;font-weight:400;text-align:justify;color:#757575;">' . Mailer::lang('Observations')[Session::get_value('account')['language']] . ': ' . (!empty($_POST['observations']) ? $_POST['observations'] : Mailer::lang('empty')[Session::get_value('account')['language']]) . '</p>';
								else if ($vox['type'] == 'incident')
								{
									$mail->Body .=
									'<h6 style="width:100%;margin:0px 0px 5px 0px;padding:0px;font-size:14px;font-weight:400;text-align:left;color:#757575;">' . Mailer::lang('confidentiality')[Session::get_value('account')['language']] . ': ' . Mailer::lang((!empty($_POST['confidentiality']) ? 'yes' : 'not'))[Session::get_value('account')['language']] . '</h6>
									<p style="width:100%;margin:0px 0px 20px 0px;padding:0px;font-size:14px;font-weight:400;text-align:justify;color:#757575;">' . Mailer::lang('subject')[Session::get_value('account')['language']] . ': ' . $_POST['subject'] . '</p>';
								}

								$mail->Body .=
								'					<a style="width:100%;display:block;margin:0px;padding:20px 0px;border-radius:50px;box-sizing:border-box;background-color:#00a5ab;font-size:14px;font-weight:400;text-align:center;text-decoration:none;color:#fff;" href="https://' . Configuration::$domain . '/voxes/details/' . $query . '">' . Mailer::lang('give_follow_up')[Session::get_value('account')['language']] . '</a>
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
								$mail->AltBody = '';
								$mail->send();
							}
							catch (Exception $e) { }

							$sms = $this->model->get_sms();

							if ($sms > 0)
							{
								$sms_basic  = new \Nexmo\Client\Credentials\Basic('45669cce', 'CR1Vg1bpkviV8Jzc');
								$sms_client = new \Nexmo\Client($sms_basic);
								$sms_text = Mailer::lang('new', $_POST['type'])[Session::get_value('account')['language']] . '. ';
								$sms_text .= Mailer::lang('token')[Session::get_value('account')['language']] . ': ' . $_POST['token'] . '. ';
								$sms_text .= Mailer::lang('owner')[Session::get_value('account')['language']] . ': ' . Session::get_value('owner')['name'] . (!empty(Session::get_value('owner')['number']) ? ' #' . Session::get_value('owner')['number'] : '') . '. ';
								$sms_text .= Mailer::lang('opportunity_area')[Session::get_value('account')['language']] . ': ' . $_POST['opportunity_area']['name'][Session::get_value('account')['language']] . '. ';
								$sms_text .= Mailer::lang('opportunity_type')[Session::get_value('account')['language']] . ': ' . $_POST['opportunity_type']['name'][Session::get_value('account')['language']] . '. ';
								$sms_text .= Mailer::lang('started_date')[Session::get_value('account')['language']] . ': ' . Functions::get_formatted_date($_POST['started_date'], 'd M y') . '. ';
								$sms_text .= Mailer::lang('started_hour')[Session::get_value('account')['language']] . ': ' . Functions::get_formatted_hour($_POST['started_hour'], '+ hrs') . '. ';
								$sms_text .= Mailer::lang('location')[Session::get_value('account')['language']] . ': ' . $_POST['location']['name'][Session::get_value('account')['language']] . '. ';
								$sms_text .= Mailer::lang('urgency')[Session::get_value('account')['language']] . ': ' . Mailer::lang('medium')[Session::get_value('account')['language']] . '. ';

								if ($_POST['type'] == 'request')
									$sms_text .= Mailer::lang('observations')[Session::get_value('account')['language']] . ': ' . (!empty($_POST['observations']) ? $_POST['observations'] : Mailer::lang('empty')[Session::get_value('account')['language']]) . '. ';
								else if ($_POST['type'] == 'incident')
								{
									$sms_text .= Mailer::lang('confidentiality')[Session::get_value('account')['language']] . ': ' . Mailer::lang((!empty($_POST['confidentiality']) ? 'yes' : 'not'))[Session::get_value('account')['language']] . '. ';
									$sms_text .= Mailer::lang('subject')[Session::get_value('account')['language']] . ': ' . (!empty($_POST['subject']) ? $_POST['subject'] : Mailer::lang('empty')[Session::get_value('account')['language']]) . '. ';
								}

								$sms_text .= 'https://' . Configuration::$domain . '/voxes/details/' . $query;

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

							if (!isset($params[1]) OR empty($params[1]))
							{
								$data['owner'] = $this->model->get_owner();

								Session::set_value('owner', $data['owner']);
							}

							Functions::environment([
								'status' => 'success',
								'message' => '{$lang.thanks_trus_us_vox_send_correctly}'
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

				if ($_POST['action'] == 'new_survey_answer')
				{
					$labels = [];

					if (!empty($_POST['phone_lada']) OR !empty($_POST['phone_number']))
					{
						if (!isset($_POST['phone_lada']) OR empty($_POST['phone_lada']))
							array_push($labels, ['phone_lada','']);

						if (!isset($_POST['phone_number']) OR empty($_POST['phone_number']))
							array_push($labels, ['phone_number','']);
					}

					if (!isset($params[1]) OR empty($params[1]))
					{
						if (!isset($_POST['owner']) OR empty($_POST['owner']))
							array_push($labels, ['owner','']);
					}

					if (empty($labels))
					{
						$_POST['token'] = Functions::get_random(8);
						$_POST['answers'] = $_POST;

						unset($_POST['answers']['comment']);
						unset($_POST['answers']['firstname']);
						unset($_POST['answers']['lastname']);
						unset($_POST['answers']['email']);
						unset($_POST['answers']['phone_lada']);
						unset($_POST['answers']['phone_number']);
						unset($_POST['answers']['owner']);
						unset($_POST['answers']['action']);
						unset($_POST['answers']['token']);

						foreach ($_POST['answers'] as $key => $value)
						{
							$explode = explode('-', $key);

							if ($explode[0] == 'pn' OR $explode[0] == 'pr' OR $explode[0] == 'pt' OR $explode[0] == 'po' OR $explode[0] == 'pc')
							{
								if ($explode[0] == 'pn')
									$explode[0] = 'nps';
								else if ($explode[0] == 'pr')
									$explode[0] = 'rate';
								else if ($explode[0] == 'pt')
									$explode[0] = 'twin';
								else if ($explode[0] == 'po')
									$explode[0] = 'open';
								else if ($explode[0] == 'pc')
								{
									$explode[0] = 'check';
									$value = json_encode($value);
								}

								$_POST['answers'][$explode[1]] = [
									'id' => $explode[1],
									'answer' => $value,
									'type' => $explode[0],
									'subanswers' => []
								];

								unset($_POST['answers'][$key]);
							}
							else if ($explode[0] == 'sr' OR $explode[0] == 'st' OR $explode[0] == 'so')
							{
								if (!empty($value))
								{
									if ($explode[0] == 'sr')
										$explode[0] = 'rate';
									else if ($explode[0] == 'st')
										$explode[0] = 'twin';
									else if ($explode[0] == 'so')
										$explode[0] = 'open';

									array_push($_POST['answers'][$explode[1]]['subanswers'], [
										'id' => $explode[2],
										'type' => $explode[0],
										'answer' => $value,
										'subanswers' => []
									]);
								}

								unset($_POST['answers'][$key]);
							}
							else if ($explode[0] == 'ssr' OR $explode[0] == 'sst' OR $explode[0] == 'sso')
							{
								if (!empty($value))
								{
									if ($explode[0] == 'ssr')
										$explode[0] = 'rate';
									else if ($explode[0] == 'sst')
										$explode[0] = 'twin';
									else if ($explode[0] == 'sso')
										$explode[0] = 'open';

									array_push($_POST['answers'][$explode[1]]['subanswers'][$explode[2]]['subanswers'], [
										'id' => $explode[4],
										'type' => $explode[0],
										'answer' => $value
									]);
								}

								unset($_POST['answers'][$key]);
							}
						}

						sort($_POST['answers']);

						$query = $this->model->new_survey_answer($_POST);

						if (!empty($query))
						{
							if (!empty($_POST['email']))
							{
								$mail = new Mailer(true);

								try
								{
									$mail->isSMTP();
									$mail->setFrom('noreply@guestvox.com', 'Guestvox');
									$mail->addAddress($_POST['email'], $_POST['firstname'] . ' ' . $_POST['lastname']);
									$mail->isHTML(true);
									$mail->Subject = Session::get_value('account')['settings']['myvox']['survey_mail']['title'][Session::get_value('account')['language']];
									$mail->Body =
									'<html>
										<head>
											<title>' . Session::get_value('account')['settings']['myvox']['survey_mail']['title'][Session::get_value('account')['language']] . '</title>
										</head>
										<body>
											<table style="width:600px;margin:0px;padding:20px;border:0px;box-sizing:border-box;background-color:#eee">
												<tr style="width:100%;margin:0px 0px 10px 0px;padding:0px;border:0px;">
													<td style="width:100%;margin:0px;padding:40px 20px;border:0px;box-sizing:border-box;background-color:#fff;">
														<figure style="width:100%;margin:0px;padding:0px;text-align:center;">
															<img style="width:100%;max-width:300px;" src="https://' . Configuration::$domain . '/uploads/' . Session::get_value('account')['logotype'] . '" />
														</figure>
													</td>
												</tr>
												<tr style="width:100%;margin:0px 0px 10px 0px;padding:0px;border:0px;">
													<td style="width:100%;margin:0px;padding:40px 20px;border:0px;box-sizing:border-box;background-color:#fff;">
														<h4 style="width:100%;margin:0px 0px 5px 0px;padding:0px;font-size:24px;font-weight:600;text-align:center;color:#212121;">' . Session::get_value('account')['settings']['myvox']['survey_mail']['description'][Session::get_value('account')['language']] . '</h4>
														<h6 style="width:100%;margin:0px;padding:0px;font-size:24px;font-weight:400;text-align:left;center:#757575;">' . $_POST['token'] . '</h6>';

									if (!empty(Session::get_value('account')['settings']['myvox']['survey_mail']['image']))
									{
										$mail->Body .=
										'<figure style="width:100%;margin:20px 0px 0px 0px;padding:0px;text-align:center;">
											<img style="width:100%;" src="https://' . Configuration::$domain . '/uploads/' . Session::get_value('account')['settings']['myvox']['survey_mail']['image'] . '" />
										</figure>';
									}

									if (!empty(Session::get_value('account')['settings']['myvox']['survey_mail']['attachment']))
										$mail->Body .= '<a style="width:100%;display:block;margin:20px 0px 0px 0px;padding:20px 0px;border-radius:50px;box-sizing:border-box;background-color:#00a5ab;font-size:14px;font-weight:400;text-align:center;text-decoration:none;color:#fff;" href="https://' . Configuration::$domain . '/uploads/' . Session::get_value('account')['settings']['myvox']['survey_mail']['attachment']['file'] . '" download="'. Session::get_value('account')['settings']['myvox']['survey_mail']['attachment']['file'] . '">' . Mailer::lang('download_file')[Session::get_value('account')['language']] . '</a>';

									$mail->Body .=
									'				</td>
												</tr>
												<tr style="width:100%;margin:0px;padding:0px;border:0px;">
													<td style="width:100%;margin:0px;padding:20px;border:0px;box-sizing:border-box;background-color:#fff;">
														<a style="width:100%;display:block;padding:20px 0px;box-sizing:border-box;font-size:14px;font-weight:400;text-align:center;text-decoration:none;color:#757575;" href="https://' . Configuration::$domain . '">Power by Guestvox</a>
													</td>
												</tr>
											</table>
										</body>
									</html>';
									$mail->AltBody = '';
									$mail->send();
								}
								catch (Exception $e) { }
							}

							if (!empty($_POST['phone_lada']) AND !empty($_POST['phone_number']))
							{
								$sms = $this->model->get_sms();

								if ($sms > 0)
								{
									$sms_basic  = new \Nexmo\Client\Credentials\Basic('45669cce', 'CR1Vg1bpkviV8Jzc');
									$sms_client = new \Nexmo\Client($sms_basic);
									$sms_text = Session::get_value('account')['settings']['myvox']['survey_mail']['title'][Session::get_value('account')['language']] . '. ' . Mailer::lang('token')[Session::get_value('account')['language']] . ': ' . $_POST['token'];

									try
									{
										$sms_client->message()->send([
											'to' => $_POST['phone_lada'] . $_POST['phone_number'],
											'from' => 'Guestvox',
											'text' => $sms_text
										]);

										$sms = $sms - 1;
									}
									catch (Exception $e) { }

									$this->model->edit_sms($sms);
								}
							}

							$widget = false;

							if (!empty(Session::get_value('account')['settings']['myvox']['survey_widget']))
							{
								$survey_average = $this->model->get_survey_average($query);

								if ($survey_average >= 4)
									$widget = true;
							}

							if (!isset($params[1]) OR empty($params[1]))
							{
								$data['owner'] = $this->model->get_owner();

								Session::set_value('owner', $data['owner']);
							}

							Functions::environment([
								'status' => 'success',
								'widget' => $widget,
								'message' => '{$lang.thanks_for_answering_our_survey}'
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
				$template = $this->view->render($this, 'index');

				define('_title', 'Guestvox | {$lang.myvox}');

				$a_new_request = '';
				$a_new_incident = '';
				$mdl_new_vox = '';

				if (Session::get_value('account')['operation'] == true)
				{
					if (Session::get_value('account')['settings']['myvox']['request'] == true)
						$a_new_request .= '<a data-action="new_vox" data-type="request">{$lang.make_a_request}</a>';

					if (Session::get_value('account')['settings']['myvox']['incident'] == true)
						$a_new_incident .= '<a data-action="new_vox" data-type="incident">{$lang.make_a_incident_' . Session::get_value('account')['type'] . '}</a>';

					if (Session::get_value('account')['settings']['myvox']['request'] == true OR Session::get_value('account')['settings']['myvox']['incident'] == true)
					{
						$mdl_new_vox .=
						'<section class="modal" data-modal="new_vox">
							<div class="content">
								<main>
									<form name="new_vox">
										<div class="row">';

						if (!isset($params[1]) OR empty($params[1]))
						{
							$mdl_new_vox .=
							'<div class="span12">
								<div class="label">
									<label required>
										<p>{$lang.owner}</p>
										<select name="owner"></select>
									</label>
								</div>
							</div>';
						}

						$mdl_new_vox .=
						'					<div class="span12">
												<div class="label">
													<label required>
														<p>{$lang.opportunity_area}</p>
														<select name="opportunity_area"></select>
													</label>
												</div>
											</div>
											<div class="span12">
												<div class="label">
													<label required>
														<p>{$lang.opportunity_type}</p>
														<select name="opportunity_type" disabled></select>
													</label>
												</div>
											</div>
											<div class="span6">
												<div class="label">
													<label class="success" required>
														<p>{$lang.date}</p>
														<input type="date" name="started_date" value="' . Functions::get_current_date('Y-m-d') . '">
													</label>
												</div>
											</div>
											<div class="span6">
												<div class="label">
													<label class="success" required>
														<p>{$lang.hour}</p>
														<input type="time" name="started_hour" value="' . Functions::get_current_hour() . '">
													</label>
												</div>
											</div>
											<div class="span12">
												<div class="label">
													<label required>
														<p>{$lang.location}</p>
														<select name="location"></select>
													</label>
												</div>
											</div>';

						if (Session::get_value('account')['settings']['myvox']['request'] == true)
						{
							$mdl_new_vox .=
							'<div class="span12 hidden">
								<div class="label">
									<label required>
										<p>{$lang.observations}</p>
										<input type="text" name="observations" maxlength="120" />
										<p class="description">{$lang.max_120_characters}</p>
									</label>
								</div>
							</div>';
						}

						if (Session::get_value('account')['settings']['myvox']['incident'] == true)
						{
							$mdl_new_vox .=
							'<div class="span12 hidden">
								<div class="label">
									<label required>
										<p>{$lang.subject}</p>
										<input type="text" name="subject" maxlength="120" />
										<p class="description">{$lang.max_120_characters}</p>
									</label>
								</div>
							</div>';
						}

						$mdl_new_vox .=
						'					<div class="span12">
												<div class="label">
													<label unrequired>
														<p>{$lang.firstname}</p>
														<input type="text" name="firstname" />
													</label>
												</div>
											</div>
											<div class="span12">
												<div class="label">
													<label unrequired>
														<p>{$lang.lastname}</p>
														<input type="text" name="lastname" />
													</label>
												</div>
											</div>
											<div class="span12">
												<div class="buttons">
													<button type="submit">{$lang.accept}</button>
													<button button-cancel>{$lang.cancel}</button>
												</div>
											</div>
										</div>
									</form>
								</main>
							</div>
						</section>';
					}
				}

				$a_new_survey_answer = '';
				$mdl_new_survey_answer = '';
				$mdl_survey_widget = '';

				if (Session::get_value('account')['reputation'] == true)
				{
					if (Session::get_value('account')['settings']['myvox']['survey'] == true)
					{
						$a_new_survey_answer .= '<a data-button-modal="new_survey_answer">' . Session::get_value('account')['settings']['myvox']['survey_title'][Session::get_value('lang')] . '</a>';

						$mdl_new_survey_answer .=
						'<section class="modal" data-modal="new_survey_answer">
							<div class="content">
								<main>
									<form name="new_survey_answer">';

						foreach ($this->model->get_surveys_questions() as $value)
						{
							$mdl_new_survey_answer .=
							'<article>
						   		<h6>' . $value['name'][Session::get_value('lang')] . '</h6>';

							if ($value['type'] == 'nps')
							{
								$mdl_new_survey_answer .=
								'<div class="rate">
								   <label><i style="font-size:18px;">1</i><input type="radio" name="pn-' . $value['id'] . '" value="1"></label>
								   <label><i style="font-size:18px;">2</i><input type="radio" name="pn-' . $value['id'] . '" value="2"></label>
								   <label><i style="font-size:18px;">3</i><input type="radio" name="pn-' . $value['id'] . '" value="3"></label>
								   <label><i style="font-size:18px;">4</i><input type="radio" name="pn-' . $value['id'] . '" value="4"></label>
								   <label><i style="font-size:18px;">5</i><input type="radio" name="pn-' . $value['id'] . '" value="5"></label>
								   <label><i style="font-size:18px;">6</i><input type="radio" name="pn-' . $value['id'] . '" value="6"></label>
								   <label><i style="font-size:18px;">7</i><input type="radio" name="pn-' . $value['id'] . '" value="7"></label>
								   <label><i style="font-size:18px;">8</i><input type="radio" name="pn-' . $value['id'] . '" value="8"></label>
								   <label><i style="font-size:18px;">9</i><input type="radio" name="pn-' . $value['id'] . '" value="9"></label>
								   <label><i style="font-size:18px;">10</i><input type="radio" name="pn-' . $value['id'] . '" value="10"></label>
								</div>';
							}
							else if ($value['type'] == 'rate')
							{
								$mdl_new_survey_answer .=
								'<div class="rate">
								   <label><i class="far fa-sad-cry" style="font-size:18px;"></i><input type="radio" name="pr-' . $value['id'] . '" value="1" data-action="open_subquestion"></label>
								   <label><i class="far fa-frown" style="font-size:18px;"></i><input type="radio" name="pr-' . $value['id'] . '" value="2" data-action="open_subquestion"></label>
								   <label><i class="far fa-meh-rolling-eyes" style="font-size:18px;"></i><input type="radio" name="pr-' . $value['id'] . '" value="3" data-action="open_subquestion"></label>
								   <label><i class="far fa-smile" style="font-size:18px;"></i><input type="radio" name="pr-' . $value['id'] . '" value="4" data-action="open_subquestion"></label>
								   <label><i class="far fa-grin-stars" style="font-size:18px;"></i><input type="radio" name="pr-' . $value['id'] . '" value="5" data-action="open_subquestion"></label>
								</div>';
							}
							else if ($value['type'] == 'twin')
							{
								$mdl_new_survey_answer .=
								'<div>
								   <label>{$lang.to_yes}</label>
								   <label><input type="radio" name="pt-' . $value['id'] . '" value="yes" data-action="open_subquestion"></label>
								   <label><input type="radio" name="pt-' . $value['id'] . '" value="no" data-action="open_subquestion"></label>
								   <label>{$lang.to_not}</label>
								</div>';
							}
							else if ($value['type'] == 'open')
							{
								$mdl_new_survey_answer .=
								'<div>
								   <input type="text" name="po-' . $value['id'] . '">
								</div>';
							}
							else if ($value['type'] == 'check')
							{
								foreach ($value['values'] as $subkey => $subvalue)
								{
									$mdl_new_survey_answer .=
									'<div class="checkboxes">
										<input type="checkbox" name="pc-' . $value['id'] . '-values[]" value="' . $subkey . '">
										<span>' . $subvalue[Session::get_value('lang')] . '</span>
									</div>';
								}
							}

							$mdl_new_survey_answer .= '</article>';

							if (!empty($value['subquestions']))
							{
								if ($value['type'] == 'rate')
								   $mdl_new_survey_answer .= '<article id="pr-' . $value['id'] . '" class="subquestions hidden">';
								else if ($value['type'] == 'twin')
								   $mdl_new_survey_answer .= '<article id="pt-' . $value['id'] . '" class="subquestions hidden">';

								foreach ($value['subquestions'] as $subkey => $subvalue)
								{
								   	if ($subvalue['status'] == true)
								   	{
									   	$mdl_new_survey_answer .= '<h6>' . $subvalue['name'][Session::get_value('lang')] . '</h6>';

									   	if ($subvalue['type'] == 'rate')
									   	{
										   	$mdl_new_survey_answer .=
										   	'<div class="rate">
											   	<label><i class="far fa-sad-cry" style="font-size:18px;"></i><input type="radio" name="sr-' . $value['id'] . '-' . $subvalue['id'] . '" value="1" data-action="open_subquestion_sub"></label>
											   	<label><i class="far fa-frown" style="font-size:18px;"></i><input type="radio" name="sr-' . $value['id'] . '-' . $subvalue['id'] . '" value="2" data-action="open_subquestion_sub"></label>
											   	<label><i class="far fa-meh-rolling-eyes" style="font-size:18px;"></i><input type="radio" name="sr-' . $value['id'] . '-' . $subvalue['id'] . '" value="3" data-action="open_subquestion_sub"></label>
											   	<label><i class="far fa-smile" style="font-size:18px;"></i><input type="radio" name="sr-' . $value['id'] . '-' . $subvalue['id'] . '" value="4" data-action="open_subquestion_sub"></label>
											   	<label><i class="far fa-grin-stars" style="font-size:18px;"></i><input type="radio" name="sr-' . $value['id'] . '-' . $subvalue['id'] . '" value="5" data-action="open_subquestion_sub"></label>
										   	</div>';
									   	}
									   	else if ($subvalue['type'] == 'twin')
									   	{
										   	$mdl_new_survey_answer .=
										   	'<div>
											   	<label>{$lang.to_yes}</label>
											   	<label><input type="radio" name="st-' . $value['id'] . '-' . $subvalue['id'] . '" value="yes" data-action="open_subquestion_sub"></label>
											   	<label><input type="radio" name="st-' . $value['id'] . '-' . $subvalue['id'] . '" value="no" data-action="open_subquestion_sub"></label>
											   	<label>{$lang.to_not}</label>
										  	</div>';
									   	}
									   	else if ($subvalue['type'] == 'open')
									   	{
										   	$mdl_new_survey_answer .=
										   	'<div>
											   	<input type="text" name="so-' . $value['id'] . '-' . $subvalue['id'] . '">
										   	</div>';
									   	}

									   	if (!empty($subvalue['subquestions']))
									   	{
										   	if ($subvalue['type'] == 'rate')
		   								   		$mdl_new_survey_answer .= '<article id="sr-' . $value['id'] . '-' . $subvalue['id'] . '" class="subquestions-sub hidden">';
			   								else if ($subvalue['type'] == 'twin')
			   								   	$mdl_new_survey_answer .= '<article id="st-' . $value['id'] . '-' . $subvalue['id'] . '" class="subquestions-sub hidden">';

										   	foreach ($subvalue['subquestions'] as $parentkey => $parentvalue)
										   	{
												if ($parentvalue['status'] == true)
												{
													$mdl_new_survey_answer .= '<h6>' . $parentvalue['name'][Session::get_value('lang')] . '</h6>';

												  	if ($parentvalue['type'] == 'rate')
													{
														$mdl_new_survey_answer .=
														'<div class="rate">
														   <label><i class="far fa-sad-cry" style="font-size:18px;"></i><input type="radio" name="ssr-' . $value['id'] . '-' . $subkey . '-' . $subvalue['id'] . '-' . $parentvalue['id'] . '" value="1"></label>
														   <label><i class="far fa-frown" style="font-size:18px;"></i><input type="radio" name="ssr-' . $value['id'] . '-' . $subkey . '-' . $subvalue['id'] . '-' . $parentvalue['id'] . '" value="2"></label>
														   <label><i class="far fa-meh-rolling-eyes" style="font-size:18px;"></i><input type="radio" name="ssr-' . $value['id'] . '-' . $subkey . '-' . $subvalue['id'] . '-' . $parentvalue['id'] . '" value="3"></label>
														   <label><i class="far fa-smile" style="font-size:18px;"></i><input type="radio" name="ssr-' . $value['id'] . '-' . $subkey . '-' . $subvalue['id'] . '-' . $parentvalue['id'] . '" value="4"></label>
														   <label><i class="far fa-grin-stars" style="font-size:18px;"></i><input type="radio" name="ssr-' . $value['id'] . '-' . $subkey . '-' . $subvalue['id'] . '-' . $parentvalue['id'] . '" value="5"></label>
														</div>';
													}
													else if ($parentvalue['type'] == 'twin')
													{
														$mdl_new_survey_answer .=
														'<div>
														   <label>{$lang.to_yes}</label>
														   <label><input type="radio" name="sst-' . $value['id'] . '-' . $subkey . '-' . $subvalue['id'] . '-' . $parentvalue['id'] . '" value="yes"></label>
														   <label><input type="radio" name="sst-' . $value['id'] . '-' . $subkey . '-' . $subvalue['id'] . '-' . $parentvalue['id'] . '" value="no"></label>
														   <label>{$lang.to_not}</label>
														</div>';
													}
													else if ($parentvalue['type'] == 'open')
													{
														$mdl_new_survey_answer .=
														'<div>
														   <input type="text" name="sso-' . $value['id'] . '-' . $subkey . '-' . $subvalue['id'] . '-' . $parentvalue['id'] . '">
														</div>';
													}
												}
										   	}

											$mdl_new_survey_answer .= '</article>';
								   		}
								   	}
								}

								$mdl_new_survey_answer .= '</article>';
							}
					   	}

						$mdl_new_survey_answer .=
						'<div class="row">
							<div class="span12">
								<div class="label">
									<label unrequired>
										<p>{$lang.comments}</p>
										<textarea name="comment"></textarea>
									</label>
								</div>
							</div>
							<div class="span12">
								<div class="label">
									<label unrequired>
										<p>{$lang.firstname}</p>
										<input type="text" name="firstname" />
									</label>
								</div>
							</div>
							<div class="span12">
								<div class="label">
									<label unrequired>
										<p>{$lang.lastname}</p>
										<input type="text" name="lastname" />
									</label>
								</div>
							</div>
							<div class="span12">
								<div class="label">
									<label unrequired>
										<p>{$lang.email}</p>
										<input type="email" name="email">
									</label>
								</div>
							</div>
							<div class="span4">
								<div class="label">
									<label unrequired>
										<p>{$lang.lada}</p>
										<select name="phone_lada">
											<option value="" selected hidden>{$lang.choose}</option>';

						foreach ($this->model->get_countries() as $value)
							$mdl_new_survey_answer .= '<option value="' . $value['lada'] . '">' . $value['name'][Session::get_value('lang')] . ' (+' . $value['lada'] . ')</option>';

						$mdl_new_survey_answer .=
						'			</select>
								</label>
							</div>
						</div>
						<div class="span8">
							<div class="label">
								<label unrequired>
									<p>{$lang.phone}</p>
									<input type="number" name="phone_number">
								</label>
							</div>
						</div>';

						if (!isset($params[1]) OR empty($params[1]))
						{
							$mdl_new_survey_answer .=
							'<div class="span12">
								<div class="label">
									<label required>
										<p>{$lang.owner}</p>
										<select name="owner"></select>
									</label>
								</div>
							</div>';
						}

						$mdl_new_survey_answer .=
						'					<div class="span12">
												<div class="buttons">
													<button type="submit">{$lang.accept}</button>
													<button button-cancel>{$lang.cancel}</button>
												</div>
											</div>
										</div>
									</form>
								</main>
							</div>
						</section>';

						if (!empty(Session::get_value('account')['settings']['myvox']['survey_widget']))
						{
							$mdl_survey_widget .=
							'<section class="modal" data-modal="survey_widget">
							    <div class="content">
							        <main>
										<div class="row">
											<div class="span12">
												<div class="widget">
													' . Session::get_value('account')['settings']['myvox']['survey_widget'] . '
												</div>
											</div>
											<div class="span12">
												<div class="buttons">
													<button button-close>{$lang.accept}</button>
												</div>
											</div>
										</div>
									</main>
							    </div>
							</section>';
						}
					}
				}

				$replace = [
					'{$logotype}' => '{$path.uploads}' . Session::get_value('account')['logotype'],
					'{$a_new_request}' => $a_new_request,
					'{$a_new_incident}' => $a_new_incident,
					'{$a_new_survey_answer}' => $a_new_survey_answer,
					'{$mdl_new_vox}' => $mdl_new_vox,
					'{$mdl_new_survey_answer}' => $mdl_new_survey_answer,
					'{$mdl_survey_widget}' => $mdl_survey_widget
				];

				$template = $this->format->replace($replace, $template);

				echo $template;
			}
		}
		else
			header('Location: /');
    }
}
