<?php

defined('_EXEC') or die;

require_once 'plugins/nexmo/vendor/autoload.php';

class Myvox_controller extends Controller
{
	private $lang1;
	private $lang2;

	public function __construct()
	{
		parent::__construct();

		$this->lang1 = Session::get_value('lang');
		$this->lang2 = '';
	}

    public function index($params)
    {
		$account = $this->model->get_account($params[0]);

		$break = true;

		if (!empty($account))
		{
			Session::set_value('account', $account);

			if (isset($params[1]) AND !empty($params[1]))
			{
				if (isset($params[2]) AND !empty($params[2]))
					$owner = $params[2];
				else
					$owner = $params[1];
			}
			else
			{
				if (Session::exists_var('owner') == true AND !empty(Session::get_value('owner')['id']))
					$owner = Session::get_value('owner')['id'];
				else
					$owner = null;
			}

			$owner = $this->model->get_owner($owner);

			if (!empty($owner))
			{
				if (Session::get_value('account')['type'] == 'hotel')
					$owner['reservation'] = $this->model->get_reservation($owner['number']);

				Session::set_value('owner', $owner);

				$break = false;
			}

			$this->lang2 = Session::get_value('account')['language'];
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
						$html .= '<option value="' . $value['id'] . '">' . $value['name'][$this->lang1] . '</option>';

					Functions::environment([
						'status' => 'success',
						'html' => $html
					]);
				}

				if ($_POST['action'] == 'get_opt_opportunity_types')
				{
					$html = '<option value="" selected hidden>{$lang.choose}</option>';

					foreach ($this->model->get_opportunity_types($_POST['opportunity_area'], $_POST['type']) as $value)
						$html .= '<option value="' . $value['id'] . '">' . $value['name'][$this->lang1] . '</option>';

					Functions::environment([
						'status' => 'success',
						'html' => $html
					]);
				}

				if ($_POST['action'] == 'get_opt_locations')
				{
					$html = '<option value="" selected hidden>{$lang.choose}</option>';

					foreach ($this->model->get_locations($_POST['type']) as $value)
						$html .= '<option value="' . $value['id'] . '">' . $value['name'][$this->lang1] . '</option>';

					Functions::environment([
						'status' => 'success',
						'html' => $html
					]);
				}

				if ($_POST['action'] == 'get_owner')
				{
					$owner = $this->model->get_owner($_POST['owner']);

					if (!empty($owner))
					{
						if (Session::get_value('account')['type'] == 'hotel')
							$owner['reservation'] = $this->model->get_reservation($owner['number']);

						Session::set_value('owner', $owner);

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

					if (!empty($_POST['firstname']) OR !empty($_POST['lastname']))
					{
						if (!isset($_POST['firstname']) OR empty($_POST['firstname']))
							array_push($labels, ['firstname','']);

						if (!isset($_POST['lastname']) OR empty($_POST['lastname']))
							array_push($labels, ['lastname','']);
					}

					if (!isset($_POST['email']) OR empty($_POST['email']))
						array_push($labels, ['email','']);

					if (!empty($_POST['phone_lada']) OR !empty($_POST['phone_number']))
					{
						if (!isset($_POST['phone_lada']) OR empty($_POST['phone_lada']))
							array_push($labels, ['phone_lada','']);

						if (!isset($_POST['phone_number']) OR empty($_POST['phone_number']))
							array_push($labels, ['phone_number','']);
					}

					if (empty($labels))
					{
						$_POST['token'] = Functions::get_random(8);

						if (Session::get_value('account')['type'] == 'hotel')
						{
							if (!isset($_POST['firstname']) OR empty($_POST['firstname']))
								$_POST['firstname'] = Session::get_value('owner')['reservation']['firstname'];

							if (!isset($_POST['lastname']) OR empty($_POST['lastname']))
								$_POST['lastname'] = Session::get_value('owner')['reservation']['lastname'];
						}

						$query = $this->model->new_vox($_POST);

						if (!empty($query))
						{
							$mail1 = new Mailer(true);

							try
							{
								$mail1->setFrom('noreply@guestvox.com', 'Guestvox');
								$mail1->addAddress($_POST['email'], ((!empty($_POST['firstname']) AND !empty($_POST['lastname'])) ? $_POST['firstname'] . ' ' . $_POST['lastname'] : Languages::words('not_name')[$this->lang1]));
								$mail1->Subject = Languages::words('thanks_received_vox')[$this->lang1];
								$mail1->Body =
								'<html>
									<head>
										<title>' . $mail1->Subject . '</title>
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
													<h4 style="width:100%;margin:0px 0px 20px 0px;padding:0px;font-size:18px;font-weight:600;text-align:center;color:#212121;">' . $mail1->Subject . '</h4>
													<h6 style="width:100%;margin:0px;padding:0px;font-size:14px;font-weight:400;text-align:center;color:#757575;">' . Languages::words('token')[$this->lang1] . ': ' . $_POST['token'] . '</h6>
												</td>
											</tr>
											<tr style="width:100%;margin:0px;padding:0px;border:0px;">
												<td style="width:100%;margin:0px;padding:20px;border:0px;box-sizing:border-box;background-color:#fff;">
													<a style="width:100%;display:block;padding:20px 0px;box-sizing:border-box;font-size:14px;font-weight:400;text-align:center;text-decoration:none;color:#757575;" href="https://' . Configuration::$domain . '">Power by Guestvox</a>
												</td>
											</tr>
										</table>
									</body>
								</html>';
								$mail1->send();
							}
							catch (Exception $e) { }

							if (!empty($_POST['phone_lada']) AND !empty($_POST['phone_number']))
							{
								$sms1 = $this->model->get_sms();

								if ($sms1 > 0)
								{
									$sms1_basic  = new \Nexmo\Client\Credentials\Basic('45669cce', 'CR1Vg1bpkviV8Jzc');
									$sms1_client = new \Nexmo\Client($sms1_basic);
									$sms1_text = Session::get_value('account')['name'] . '. ' . Languages::words('thanks_received_vox')[$this->lang1] . '. ' . Languages::words('token')[$this->lang1] . ': ' . $_POST['token'] . '. Power by Guestvox.';

									try
									{
										$sms1_client->message()->send([
											'to' => $_POST['phone_lada'] . $_POST['phone_number'],
											'from' => 'Guestvox',
											'text' => $sms1_text
										]);

										$sms1 = $sms1 - 1;
									}
									catch (Exception $e) { }

									$this->model->edit_sms($sms1);
								}
							}

							$_POST['opportunity_area'] = $this->model->get_opportunity_area($_POST['opportunity_area']);
							$_POST['opportunity_type'] = $this->model->get_opportunity_type($_POST['opportunity_type']);
							$_POST['location'] = $this->model->get_location($_POST['location']);
							$_POST['assigned_users'] = $this->model->get_assigned_users($_POST['opportunity_area']['id']);

							$mail2 = new Mailer(true);

							try
							{
								$mail2->setFrom('noreply@guestvox.com', 'Guestvox');

								foreach ($_POST['assigned_users'] as $value)
									$mail2->addAddress($value['email'], $value['firstname'] . ' ' . $value['lastname']);

								$mail2->Subject = Languages::words('new', $_POST['type'])[$this->lang2];
								$mail2->Body =
								'<html>
									<head>
										<title>' . $mail2->Subject . '</title>
									</head>
									<body>
										<table style="width:600px;margin:0px;padding:20px;border:0px;box-sizing:border-box;background-color:#eee">
											<tr style="width:100%;margin:0px 0px 10px 0px;padding:0px;border:0px;">
												<td style="width:100%;margin:0px;padding:40px 20px;border:0px;box-sizing:border-box;background-color:#fff;">
													<figure style="width:100%;margin:0px;padding:0px;text-align:center;">
														<img style="width:100%;max-width:300px;" src="https://' . Configuration::$domain . '/images/logotype_color.png" />
													</figure>
												</td>
											</tr>
											<tr style="width:100%;margin:0px 0px 10px 0px;padding:0px;border:0px;">
												<td style="width:100%;margin:0px;padding:40px 20px;border:0px;box-sizing:border-box;background-color:#fff;">
													<h4 style="width:100%;margin:0px 0px 20px 0px;padding:0px;font-size:18px;font-weight:600;text-align:center;color:#212121;">' . $mail2->Subject . '</h4>
													<h6 style="width:100%;margin:0px 0px 5px 0px;padding:0px;font-size:14px;font-weight:400;text-align:left;color:#757575;">' . Languages::words('token')[$this->lang2] . ': ' . $_POST['token'] . '</h6>
													<h6 style="width:100%;margin:0px 0px 5px 0px;padding:0px;font-size:14px;font-weight:400;text-align:left;color:#757575;">' . Languages::words('owner')[$this->lang2] . ': ' . Session::get_value('owner')['name'] . (!empty(Session::get_value('owner')['number']) ? ' #' . Session::get_value('owner')['number'] : '') . '</h6>
													<h6 style="width:100%;margin:0px 0px 5px 0px;padding:0px;font-size:14px;font-weight:400;text-align:left;color:#757575;">' . Languages::words('opportunity_area')[$this->lang2] . ': ' . $_POST['opportunity_area']['name'][$this->lang2] . '</h6>
													<h6 style="width:100%;margin:0px 0px 5px 0px;padding:0px;font-size:14px;font-weight:400;text-align:left;color:#757575;">' . Languages::words('opportunity_type')[$this->lang2] . ': ' . $_POST['opportunity_type']['name'][$this->lang2] . '</h6>
													<h6 style="width:100%;margin:0px 0px 5px 0px;padding:0px;font-size:14px;font-weight:400;text-align:left;color:#757575;">' . Languages::words('started_date')[$this->lang2] . ': ' . Functions::get_formatted_date($_POST['started_date'], 'd M, Y') . '</h6>
													<h6 style="width:100%;margin:0px 0px 5px 0px;padding:0px;font-size:14px;font-weight:400;text-align:left;color:#757575;">' . Languages::words('started_hour')[$this->lang2] . ': ' . Functions::get_formatted_hour($_POST['started_hour'], '+ hrs') . '</h6>
													<h6 style="width:100%;margin:0px 0px 5px 0px;padding:0px;font-size:14px;font-weight:400;text-align:left;color:#757575;">' . Languages::words('location')[$this->lang2] . ': ' . $_POST['location']['name'][$this->lang2] . '</h6>
													<h6 style="width:100%;margin:0px 0px 5px 0px;padding:0px;font-size:14px;font-weight:400;text-align:left;color:#757575;">' . Languages::words('urgency')[$this->lang2] . ': ' . Languages::words('medium')[$this->lang2] . '</h6>';

								if ($_POST['type'] == 'request')
									$mail2->Body = '<p style="width:100%;margin:0px 0px 20px 0px;padding:0px;font-size:14px;font-weight:400;text-align:center;color:#757575;">' . Languages::words('Observations')[$this->lang2] . ': ' . (!empty($_POST['observations']) ? $_POST['observations'] : Languages::words('empty')[$this->lang2]) . '</p>';
								else if ($vox['type'] == 'incident')
								{
									$mail2->Body .=
									'<h6 style="width:100%;margin:0px 0px 5px 0px;padding:0px;font-size:14px;font-weight:400;text-align:left;color:#757575;">' . Languages::words('confidentiality')[$this->lang2] . ': ' . Languages::words((!empty($_POST['confidentiality']) ? 'yes' : 'not'))[$this->lang2] . '</h6>
									<p style="width:100%;margin:0px 0px 20px 0px;padding:0px;font-size:14px;font-weight:400;text-align:center;color:#757575;">' . Languages::words('subject')[$this->lang2] . ': ' . (!empty($_POST['subject']) ? $_POST['subject'] : Languages::words('empty')[$this->lang2]) . '</p>';
								}

								$mail2->Body .=
								'					<a style="width:100%;display:block;margin:0px;padding:20px 0px;border-radius:40px;box-sizing:border-box;background-color:#00a5ab;font-size:14px;font-weight:400;text-align:center;text-decoration:none;color:#fff;" href="https://' . Configuration::$domain . '/voxes/details/' . $query . '">' . Languages::words('give_follow_up')[$this->lang2] . '</a>
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
								$mail2->send();
							}
							catch (Exception $e) { }

							$sms2 = $this->model->get_sms();

							if ($sms2 > 0)
							{
								$sms2_basic  = new \Nexmo\Client\Credentials\Basic('45669cce', 'CR1Vg1bpkviV8Jzc');
								$sms2_client = new \Nexmo\Client($sms2_basic);
								$sms2_text = 'Guestvox. ' . Languages::words('new', $_POST['type'])[$this->lang2] . '. ';
								$sms2_text .= Languages::words('token')[$this->lang2] . ': ' . $_POST['token'] . '. ';
								$sms2_text .= Languages::words('owner')[$this->lang2] . ': ' . Session::get_value('owner')['name'] . (!empty(Session::get_value('owner')['number']) ? ' #' . Session::get_value('owner')['number'] : '') . '. ';
								$sms2_text .= Languages::words('opportunity_area')[$this->lang2] . ': ' . $_POST['opportunity_area']['name'][$this->lang2] . '. ';
								$sms2_text .= Languages::words('opportunity_type')[$this->lang2] . ': ' . $_POST['opportunity_type']['name'][$this->lang2] . '. ';
								$sms2_text .= Languages::words('started_date')[$this->lang2] . ': ' . Functions::get_formatted_date($_POST['started_date'], 'd M y') . '. ';
								$sms2_text .= Languages::words('started_hour')[$this->lang2] . ': ' . Functions::get_formatted_hour($_POST['started_hour'], '+ hrs') . '. ';
								$sms2_text .= Languages::words('location')[$this->lang2] . ': ' . $_POST['location']['name'][$this->lang2] . '. ';
								$sms2_text .= Languages::words('urgency')[$this->lang2] . ': ' . Languages::words('medium')[$this->lang2] . '. ';

								if ($_POST['type'] == 'request')
									$sms2_text .= Languages::words('observations')[$this->lang2] . ': ' . (!empty($_POST['observations']) ? $_POST['observations'] : Languages::words('empty')[$this->lang2]) . '. ';
								else if ($_POST['type'] == 'incident')
								{
									$sms2_text .= Languages::words('confidentiality')[$this->lang2] . ': ' . Languages::words((!empty($_POST['confidentiality']) ? 'yes' : 'not'))[$this->lang2] . '. ';
									$sms2_text .= Languages::words('subject')[$this->lang2] . ': ' . (!empty($_POST['subject']) ? $_POST['subject'] : Languages::words('empty')[$this->lang2]) . '. ';
								}

								$sms2_text .= 'https://' . Configuration::$domain . '/voxes/details/' . $query;

								foreach ($_POST['assigned_users'] as $value)
								{
									if ($sms2 > 0)
									{
										try
										{
											$sms2_client->message()->send([
												'to' => $value['phone']['lada'] . $value['phone']['number'],
												'from' => 'Guestvox',
												'text' => $sms2_text
											]);

											$sms2 = $sms2 - 1;
										}
										catch (Exception $e) { }
									}
								}

								$this->model->edit_sms($sms2);
							}

							if (!isset($params[1]) OR empty($params[1]))
							{
								$owner = $this->model->get_owner();

								Session::set_value('owner', $owner);
							}

							Functions::environment([
								'status' => 'success',
								'message' => '{$lang.thanks_received_vox_1}' . $_POST['email'] . '{$lang.thanks_received_vox_2}'
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

					if (!isset($params[1]) OR empty($params[1]))
					{
						if (!isset($_POST['owner']) OR empty($_POST['owner']))
							array_push($labels, ['owner','']);
					}

					if (!empty($_POST['firstname']) OR !empty($_POST['lastname']))
					{
						if (!isset($_POST['firstname']) OR empty($_POST['firstname']))
							array_push($labels, ['firstname','']);

						if (!isset($_POST['lastname']) OR empty($_POST['lastname']))
							array_push($labels, ['lastname','']);
					}

					if (!isset($_POST['email']) OR empty($_POST['email']))
						array_push($labels, ['email','']);

					if (!empty($_POST['phone_lada']) OR !empty($_POST['phone_number']))
					{
						if (!isset($_POST['phone_lada']) OR empty($_POST['phone_lada']))
							array_push($labels, ['phone_lada','']);

						if (!isset($_POST['phone_number']) OR empty($_POST['phone_number']))
							array_push($labels, ['phone_number','']);
					}

					if (empty($labels))
					{
						$_POST['token'] = Functions::get_random(8);
						$_POST['answers'] = $_POST;

						unset($_POST['answers']['owner']);
						unset($_POST['answers']['comment']);
						unset($_POST['answers']['firstname']);
						unset($_POST['answers']['lastname']);
						unset($_POST['answers']['email']);
						unset($_POST['answers']['phone_lada']);
						unset($_POST['answers']['phone_number']);
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
							$mail = new Mailer(true);

							try
							{
								$mail->setFrom('noreply@guestvox.com', 'Guestvox');
								$mail->addAddress($_POST['email'], ((!empty($_POST['firstname']) AND !empty($_POST['lastname'])) ? $_POST['firstname'] . ' ' . $_POST['lastname'] : Languages::words('not_name')[$this->lang1]));
								$mail->Subject = Session::get_value('account')['settings']['myvox']['survey']['mail']['subject'][$this->lang1];
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
														<img style="width:100%;max-width:300px;" src="https://' . Configuration::$domain . '/uploads/' . Session::get_value('account')['logotype'] . '" />
													</figure>
												</td>
											</tr>
											<tr style="width:100%;margin:0px 0px 10px 0px;padding:0px;border:0px;">
												<td style="width:100%;margin:0px;padding:40px 20px;border:0px;box-sizing:border-box;background-color:#fff;">
													<h4 style="width:100%;margin:0px 0px 20px 0px;padding:0px;font-size:18px;font-weight:600;text-align:center;color:#212121;">' . $mail->Subject . '</h4>
													<h6 style="width:100%;margin:0px 0px 20px 0px;padding:0px;font-size:14px;font-weight:400;text-align:center;center:#757575;">' . Languages::words('token')[$this->lang1] . ': ' . $_POST['token'] . '</h6>
													<p style="width:100%;margin:0px;padding:0px;font-size:14px;font-weight:400;text-align:center;center:#757575;">' . Session::get_value('account')['settings']['myvox']['survey']['mail']['description'][$this->lang1] . '</p>';

								if (!empty(Session::get_value('account')['settings']['myvox']['survey']['mail']['image']))
								{
									$mail->Body .=
									'<figure style="width:100%;margin:20px 0px 0px 0px;padding:0px;text-align:center;">
										<img style="width:100%;" src="https://' . Configuration::$domain . '/uploads/' . Session::get_value('account')['settings']['myvox']['survey']['mail']['image'] . '" />
									</figure>';
								}

								if (!empty(Session::get_value('account')['settings']['myvox']['survey']['mail']['attachment']))
									$mail->Body .= '<a style="width:100%;display:block;margin:20px 0px 0px 0px;padding:20px 0px;border-radius:50px;box-sizing:border-box;background-color:#00a5ab;font-size:14px;font-weight:400;text-align:center;text-decoration:none;color:#fff;" href="https://' . Configuration::$domain . '/uploads/' . Session::get_value('account')['settings']['myvox']['survey']['mail']['attachment'] . '" download="'. Session::get_value('account')['settings']['myvox']['survey']['mail']['attachment'] . '">' . Languages::words('download_file')[$this->lang1] . '</a>';

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
								$mail->send();
							}
							catch (Exception $e) { }

							if (!empty($_POST['phone_lada']) AND !empty($_POST['phone_number']))
							{
								$sms = $this->model->get_sms();

								if ($sms > 0)
								{
									$sms_basic  = new \Nexmo\Client\Credentials\Basic('45669cce', 'CR1Vg1bpkviV8Jzc');
									$sms_client = new \Nexmo\Client($sms_basic);
									$sms_text = Session::get_value('account')['name'] . '. ' . Session::get_value('account')['settings']['myvox']['survey']['mail']['subject'][$this->lang1] . '. ' . Languages::words('token')[$this->lang1] . ': ' . $_POST['token'] . '. Power by Guestvox';

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

							if (!empty(Session::get_value('account')['settings']['myvox']['survey']['widget']))
							{
								$survey_average = $this->model->get_survey_average($query);

								if ($survey_average >= 4)
									$widget = true;
							}

							if (!isset($params[1]) OR empty($params[1]))
							{
								$owner = $this->model->get_owner();

								Session::set_value('owner', $owner);
							}

							Functions::environment([
								'status' => 'success',
								'widget' => $widget,
								'message' => '{$lang.thanks_answering_survey_1}' . $_POST['email'] . '{$lang.thanks_answering_survey_2}'
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
					if (Session::get_value('account')['settings']['myvox']['request']['active'] == true)
						$a_new_request .= '<a data-action="new_vox" data-type="request">{$lang.make_a_request}</a>';

					if (Session::get_value('account')['settings']['myvox']['incident']['active'] == true)
						$a_new_incident .= '<a data-action="new_vox" data-type="incident">{$lang.make_a_' . Session::get_value('account')['type'] . '_incident}</a>';

					if (Session::get_value('account')['settings']['myvox']['request']['active'] == true OR Session::get_value('account')['settings']['myvox']['incident']['active'] == true)
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
						'<div class="span12">
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

						if (Session::get_value('account')['settings']['myvox']['request']['active'] == true)
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

						if (Session::get_value('account')['settings']['myvox']['incident']['active'] == true)
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
						'<div class="span12">
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
								<label required>
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
										<option value="" selected>{$lang.empty} ({$lang.choose})</option>';

						foreach ($this->model->get_countries() as $value)
							$mdl_new_vox .= '<option value="' . $value['lada'] . '">' . $value['name'][$this->lang1] . ' (+' . $value['lada'] . ')</option>';

						$mdl_new_survey_answer .=
						'								</select>
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
					if (Session::get_value('account')['settings']['myvox']['survey']['active'] == true)
					{
						$a_new_survey_answer .= '<a data-button-modal="new_survey_answer">' . Session::get_value('account')['settings']['myvox']['survey']['title'][$this->lang1] . '</a>';

						$mdl_new_survey_answer .=
						'<section class="modal" data-modal="new_survey_answer">
							<div class="content">
								<main>
									<form name="new_survey_answer">';

						foreach ($this->model->get_surveys_questions() as $value)
						{
							$mdl_new_survey_answer .=
							'<article>
						   		<h6>' . $value['name'][$this->lang1] . '</h6>';

							if ($value['type'] == 'nps')
							{
								$mdl_new_survey_answer .=
								'<div class="rate">
								   <label><i>1</i><input type="radio" name="pn-' . $value['id'] . '" value="1"></label>
								   <label><i>2</i><input type="radio" name="pn-' . $value['id'] . '" value="2"></label>
								   <label><i>3</i><input type="radio" name="pn-' . $value['id'] . '" value="3"></label>
								   <label><i>4</i><input type="radio" name="pn-' . $value['id'] . '" value="4"></label>
								   <label><i>5</i><input type="radio" name="pn-' . $value['id'] . '" value="5"></label>
								   <label><i>6</i><input type="radio" name="pn-' . $value['id'] . '" value="6"></label>
								   <label><i>7</i><input type="radio" name="pn-' . $value['id'] . '" value="7"></label>
								   <label><i>8</i><input type="radio" name="pn-' . $value['id'] . '" value="8"></label>
								   <label><i>9</i><input type="radio" name="pn-' . $value['id'] . '" value="9"></label>
								   <label><i>10</i><input type="radio" name="pn-' . $value['id'] . '" value="10"></label>
								</div>';
							}
							else if ($value['type'] == 'rate')
							{
								$mdl_new_survey_answer .=
								'<div class="rate">
								   <label><i class="far fa-sad-cry"></i><input type="radio" name="pr-' . $value['id'] . '" value="1" data-action="open_subquestion"></label>
								   <label><i class="far fa-frown"></i><input type="radio" name="pr-' . $value['id'] . '" value="2" data-action="open_subquestion"></label>
								   <label><i class="far fa-meh-rolling-eyes"></i><input type="radio" name="pr-' . $value['id'] . '" value="3" data-action="open_subquestion"></label>
								   <label><i class="far fa-smile"></i><input type="radio" name="pr-' . $value['id'] . '" value="4" data-action="open_subquestion"></label>
								   <label><i class="far fa-grin-stars"></i><input type="radio" name="pr-' . $value['id'] . '" value="5" data-action="open_subquestion"></label>
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
										<span>' . $subvalue[$this->lang1] . '</span>
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
									   	$mdl_new_survey_answer .= '<h6>' . $subvalue['name'][$this->lang1] . '</h6>';

									   	if ($subvalue['type'] == 'rate')
									   	{
										   	$mdl_new_survey_answer .=
										   	'<div class="rate">
											   	<label><i class="far fa-sad-cry"></i><input type="radio" name="sr-' . $value['id'] . '-' . $subvalue['id'] . '" value="1" data-action="open_subquestion_sub"></label>
											   	<label><i class="far fa-frown"></i><input type="radio" name="sr-' . $value['id'] . '-' . $subvalue['id'] . '" value="2" data-action="open_subquestion_sub"></label>
											   	<label><i class="far fa-meh-rolling-eyes"></i><input type="radio" name="sr-' . $value['id'] . '-' . $subvalue['id'] . '" value="3" data-action="open_subquestion_sub"></label>
											   	<label><i class="far fa-smile"></i><input type="radio" name="sr-' . $value['id'] . '-' . $subvalue['id'] . '" value="4" data-action="open_subquestion_sub"></label>
											   	<label><i class="far fa-grin-stars"></i><input type="radio" name="sr-' . $value['id'] . '-' . $subvalue['id'] . '" value="5" data-action="open_subquestion_sub"></label>
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
													$mdl_new_survey_answer .= '<h6>' . $parentvalue['name'][$this->lang1] . '</h6>';

												  	if ($parentvalue['type'] == 'rate')
													{
														$mdl_new_survey_answer .=
														'<div class="rate">
														   <label><i class="far fa-sad-cry"></i><input type="radio" name="ssr-' . $value['id'] . '-' . $subkey . '-' . $subvalue['id'] . '-' . $parentvalue['id'] . '" value="1"></label>
														   <label><i class="far fa-frown"></i><input type="radio" name="ssr-' . $value['id'] . '-' . $subkey . '-' . $subvalue['id'] . '-' . $parentvalue['id'] . '" value="2"></label>
														   <label><i class="far fa-meh-rolling-eyes"></i><input type="radio" name="ssr-' . $value['id'] . '-' . $subkey . '-' . $subvalue['id'] . '-' . $parentvalue['id'] . '" value="3"></label>
														   <label><i class="far fa-smile"></i><input type="radio" name="ssr-' . $value['id'] . '-' . $subkey . '-' . $subvalue['id'] . '-' . $parentvalue['id'] . '" value="4"></label>
														   <label><i class="far fa-grin-stars"></i><input type="radio" name="ssr-' . $value['id'] . '-' . $subkey . '-' . $subvalue['id'] . '-' . $parentvalue['id'] . '" value="5"></label>
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

						$mdl_new_survey_answer .= '<div class="row">';

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
						'<div class="span12">
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
								<label required>
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
										<option value="" selected>{$lang.empty} ({$lang.choose})</option>';

						foreach ($this->model->get_countries() as $value)
							$mdl_new_survey_answer .= '<option value="' . $value['lada'] . '">' . $value['name'][$this->lang1] . ' (+' . $value['lada'] . ')</option>';

						$mdl_new_survey_answer .=
						'								</select>
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

						if (!empty(Session::get_value('account')['settings']['myvox']['survey']['widget']))
						{
							$mdl_survey_widget .=
							'<section class="modal" data-modal="survey_widget">
							    <div class="content">
							        <main>
										<div class="row">
											<div class="span12">
												<div class="widget">
													' . Session::get_value('account')['settings']['myvox']['survey']['widget'] . '
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
