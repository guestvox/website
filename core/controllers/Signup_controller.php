<?php

defined('_EXEC') or die;

class Signup_controller extends Controller
{
	private $lang;

	public function __construct()
	{
		parent::__construct();

		$this->lang = Session::get_value('lang');
	}

	public function index()
	{
		if (Format::exist_ajax_request() == true)
		{
			if ($_POST['action'] == 'get_total')
			{
				$data = [
					'price' => [
						'operation' => 0,
						'reputation' => 0
					],
					'total' => 0
				];

				$query = $this->model->get_package($_POST['type'], $_POST['quantity']);

				if (!empty($query))
				{
					$data['price']['operation'] = $query['price']['operation'];
					$data['price']['reputation'] = $query['price']['reputation'];

					if (!empty($_POST['operation']))
						$data['total'] = $data['total'] + $query['price']['operation'];

					if (!empty($_POST['reputation']))
						$data['total'] = $data['total'] + $query['price']['reputation'];
				}

				$data['price']['operation'] = Functions::get_formatted_currency($data['price']['operation'], 'MXN');
				$data['price']['reputation'] = Functions::get_formatted_currency($data['price']['reputation'], 'MXN');
				$data['total'] = Functions::get_formatted_currency($data['total'], 'MXN');

				Functions::environment([
					'status' => 'success',
					'data' => $data
				]);
			}

			if ($_POST['action'] == 'next')
			{
				if ($_POST['step'] == '1')
				{
					$labels = [];

					if (!isset($_POST['name']) OR empty($_POST['name']) OR $this->model->check_exist_account('name', $_POST['name']) == true)
				        array_push($labels, ['name','']);

					if (!isset($_POST['path']) OR empty($_POST['path']) OR $this->model->check_exist_account('path', $_POST['path']) == true)
				        array_push($labels, ['path','']);

					if (!isset($_POST['type']) OR empty($_POST['type']))
				        array_push($labels, ['type','']);

					if (!isset($_POST['quantity']) OR empty($_POST['quantity']) OR !is_numeric($_POST['quantity']) OR $_POST['quantity'] < 1)
				        array_push($labels, ['quantity','']);

					if (!isset($_POST['country']) OR empty($_POST['country']))
				        array_push($labels, ['country','']);

					if (!isset($_POST['city']) OR empty($_POST['city']))
				        array_push($labels, ['city','']);

					if (!isset($_POST['zip_code']) OR empty($_POST['zip_code']))
				        array_push($labels, ['zip_code','']);

					if (!isset($_POST['address']) OR empty($_POST['address']))
				        array_push($labels, ['address','']);

					if (!isset($_POST['time_zone']) OR empty($_POST['time_zone']))
				        array_push($labels, ['time_zone','']);

					if (!isset($_POST['currency']) OR empty($_POST['currency']))
				        array_push($labels, ['currency','']);

					if (!isset($_POST['language']) OR empty($_POST['language']))
				        array_push($labels, ['language','']);

					if (empty($labels))
					{
						Functions::environment([
							'status' => 'success'
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

				if ($_POST['step'] == '2')
				{
					$labels = [];

					if (!isset($_FILES['logotype']['name']) OR empty($_FILES['logotype']['name']))
				        array_push($labels, ['logotype','']);

					if (empty($labels))
					{
						Functions::environment([
							'status' => 'success'
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

				if ($_POST['step'] == '3')
				{
					$labels = [];

					if (!isset($_POST['fiscal_id']) OR empty($_POST['fiscal_id']))
				        array_push($labels, ['fiscal_id','']);

					if (!isset($_POST['fiscal_name']) OR empty($_POST['fiscal_name']))
				        array_push($labels, ['fiscal_name','']);

					if (!isset($_POST['fiscal_address']) OR empty($_POST['fiscal_address']))
				        array_push($labels, ['fiscal_address','']);

					if (!isset($_POST['contact_firstname']) OR empty($_POST['contact_firstname']))
				        array_push($labels, ['contact_firstname','']);

					if (!isset($_POST['contact_lastname']) OR empty($_POST['contact_lastname']))
				        array_push($labels, ['contact_lastname','']);

					if (!isset($_POST['contact_department']) OR empty($_POST['contact_department']))
				        array_push($labels, ['contact_department','']);

					if (!isset($_POST['contact_email']) OR empty($_POST['contact_email']) OR Functions::check_email($_POST['contact_email']) == false)
				        array_push($labels, ['contact_email','']);

					if (!isset($_POST['contact_phone_lada']) OR empty($_POST['contact_phone_lada']))
				        array_push($labels, ['contact_phone_lada','']);

					if (!isset($_POST['contact_phone_number']) OR empty($_POST['contact_phone_number']))
				        array_push($labels, ['contact_phone_number','']);

					if (empty($labels))
					{
						Functions::environment([
							'status' => 'success'
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

				if ($_POST['step'] == '4')
				{
					$labels = [];

					if (!isset($_POST['firstname']) OR empty($_POST['firstname']))
				        array_push($labels, ['firstname','']);

					if (!isset($_POST['lastname']) OR empty($_POST['lastname']))
				        array_push($labels, ['lastname','']);

					if (!isset($_POST['email']) OR empty($_POST['email']) OR Functions::check_email($_POST['email']) == false OR $this->model->check_exist_user('email', $_POST['email']) == true)
				        array_push($labels, ['email','']);

					if (!isset($_POST['phone_lada']) OR empty($_POST['phone_lada']))
				        array_push($labels, ['phone_lada','']);

					if (!isset($_POST['phone_number']) OR empty($_POST['phone_number']))
				        array_push($labels, ['phone_number','']);

					if (!isset($_POST['username']) OR empty($_POST['username']) OR $this->model->check_exist_user('username', $_POST['username']) == true)
				        array_push($labels, ['username','']);

					if (!isset($_POST['password']) OR empty($_POST['password']))
				        array_push($labels, ['password','']);

					if (empty($labels))
					{
						Functions::environment([
							'status' => 'success'
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

				if ($_POST['step'] == '5')
				{
					$_POST['logotype'] = $_FILES['logotype'];

					$query = $this->model->new_signup($_POST);

					if (!empty($query))
			        {
						$mail1 = new Mailer(true);

						try
						{
							$mail1->setFrom('daniel@guestvox.com', 'Daniel Basurto');
							$mail1->addAddress($_POST['contact_email'], $_POST['contact_firstname'] . ' ' . $_POST['contact_lastname']);
							$mail1->Subject = Lang::general('thanks_signup_guestvox')[$_POST['language']];
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
													<img style="width:100%;max-width:300px;" src="https://' . Configuration::$domain . '/images/logotype_color.png" />
												</figure>
											</td>
										</tr>
										<tr style="width:100%;margin:0px 0px 10px 0px;padding:0px;border:0px;">
											<td style="width:100%;margin:0px;padding:40px 20px;border:0px;box-sizing:border-box;background-color:#fff;">
												<h4 style="width:100%;margin:0px 0px 20px 0px;padding:0px;font-size:18px;font-weight:600;text-align:center;color:#212121;">' . $mail1->Subject . '</h4>
												<p style="width:100%;margin:0px 0px 20px 0px;padding:0px;font-size:14px;font-weight:400;text-align:center;color:#757575;">' . Lang::general('validate_signup_account')[$_POST['language']] . '</p>
												<a style="width:100%;display:block;margin:5px;padding:20px 0px;border-radius:40px;box-sizing:border-box;background-color:#00a5ab;font-size:14px;font-weight:400;text-align:center;text-decoration:none;color:#fff;" href="https://' . Configuration::$domain . '/activate/account/' . $_POST['path'] . '">' . Lang::general('active_account')[$_POST['language']] . '</a>
												<a style="width:100%;display:block;margin:0px;padding:0px;box-sizing:border-box;background:none;font-size:14px;font-weight:400;text-align:center;text-decoration:none;color:#757575;" href="https://' . Configuration::$domain . '/terms-and-conditions">' . Lang::general('terms_and_conditions')[$_POST['language']] . '</a>
												<a style="width:100%;display:block;margin:0px;padding:0px;box-sizing:border-box;background:none;font-size:14px;font-weight:400;text-align:center;text-decoration:none;color:#757575;" href="https://' . Configuration::$domain . '/privacy-policies">' . Lang::general('privacy_policies')[$_POST['language']] . '</a>
											</td>
										</tr>
										<tr style="width:100%;margin:0px 0px 10px 0px;padding:0px;border:0px;">
							                <td style="width:100%;margin:0px;padding:40px 20px;border:0px;box-sizing:border-box;background-color:#fff;">
												<figure style="width:100%;margin:0px;padding:40px 0px;border:0px;box-sizing:border-box;text-align:center;">
													<img style="width:150px;height:150px;border-radius:50%;" src="https://' . Configuration::$domain . '/images/index/st_8_image_1.png">
													<span style="display:block;color:#757575;font-size:18px;">Daniel Basurto</span>
													<span style="display:block;color:#757575;font-size:18px;">CEO</span>
													<span style="display:block;color:#757575;font-size:18px;">daniel@guestvox.com</span>
													<span style="display:block;color:#757575;font-size:18px;">+52 (998) 845 28 43</span>
												</figure>
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
							$mail1->send();
						}
						catch (Exception $e) { }

						$mail2 = new Mailer(true);

						try
						{
							$mail2->setFrom('daniel@guestvox.com', 'Daniel Basurto');
							$mail2->addAddress($_POST['email'], $_POST['firstname'] . ' ' . $_POST['lastname']);
							$mail2->Subject = Lang::general('thanks_signup_guestvox')[$_POST['language']];
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
												<p style="width:100%;margin:0px 0px 20px 0px;padding:0px;font-size:14px;font-weight:400;text-align:center;color:#757575;">' . Lang::general('validate_signup_user')[$_POST['language']] . '</p>
												<a style="width:100%;display:block;margin:5px;padding:20px 0px;border-radius:40px;box-sizing:border-box;background-color:#00a5ab;font-size:14px;font-weight:400;text-align:center;text-decoration:none;color:#fff;" href="https://' . Configuration::$domain . '/activate/user/' . $_POST['email'] . '">' . Lang::general('active_user')[$_POST['language']] . '</a>
												<a style="width:100%;display:block;margin:0px;padding:0px;box-sizing:border-box;background:none;font-size:14px;font-weight:400;text-align:center;text-decoration:none;color:#757575;" href="https://' . Configuration::$domain . '/terms-and-conditions">' . Lang::general('terms_and_conditions')[$_POST['language']] . '</a>
												<a style="width:100%;display:block;margin:0px;padding:0px;box-sizing:border-box;background:none;font-size:14px;font-weight:400;text-align:center;text-decoration:none;color:#757575;" href="https://' . Configuration::$domain . '/privacy-policies">' . Lang::general('privacy_policies')[$_POST['language']] . '</a>
											</td>
										</tr>
										<tr style="width:100%;margin:0px 0px 10px 0px;padding:0px;border:0px;">
							                <td style="width:100%;margin:0px;padding:40px 20px;border:0px;box-sizing:border-box;background-color:#fff;">
												<figure style="width:100%;margin:0px;padding:40px 0px;border:0px;box-sizing:border-box;text-align:center;">
													<img style="width:150px;height:150px;border-radius:50%;" src="https://' . Configuration::$domain . '/images/index/st_8_image_1.png">
													<span style="display:block;color:#757575;font-size:18px;">Daniel Basurto</span>
													<span style="display:block;color:#757575;font-size:18px;">CEO</span>
													<span style="display:block;color:#757575;font-size:18px;">daniel@guestvox.com</span>
													<span style="display:block;color:#757575;font-size:18px;">+52 (998) 845 28 43</span>
												</figure>
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

						$mail3 = new Mailer(true);

						try
						{
							$mail3->setFrom('noreply@guestvox.com', 'Guestvox');
							$mail3->addAddress('contacto@guestvox.com', 'Guestvox');
							$mail3->Subject = 'Guestvox | Nuevo registro';
							$mail3->Body =
							'Nombre: ' . $_POST['name'] . '<br>
							Tipo: ' . Lang::general($_POST['type'])['es'] . '<br>
							Cantidad: ' . $_POST['quantity'] . '<br>
							Páis: ' . $_POST['country'] . ' ' . $_POST['city'] . ' ' . $_POST['zip_code'] . '<br>
							ID Fiscal: ' . $_POST['fiscal_id'] . '<br>
							Nombre fiscal: ' . $_POST['fiscal_name'] . '<br>
							Contácto: ' . $_POST['contact_firstname'] . ' ' . $_POST['contact_lastname'] . ' ' . $_POST['contact_department'] . ' ' .  $_POST['contact_email'] . ' +' . $_POST['contact_phone_lada'] . ' ' . $_POST['contact_phone_number'] . '<br>
							Administrador: ' . $_POST['firstname'] . ' ' . $_POST['lastname'] . ' ' . $_POST['email'] . ' +' . $_POST['phone_lada'] . ' ' . $_POST['phone_number'];
							$mail3->send();
						}
						catch (Exception $e) { }

						Functions::environment([
                            'status' => 'success',
							'path' => '/',
                            'message' => '{$lang.thanks_signup_guestvox_1}' . $_POST['contact_email'] . '{$lang.thanks_signup_guestvox_2}' . $_POST['email'] . '{$lang.thanks_signup_guestvox_3}'
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
		}
		else
		{
			$template = $this->view->render($this, 'index');

			define('_title', 'Guestvox | {$lang.signup}');

			$opt_countries = '';

			foreach ($this->model->get_countries() as $value)
				$opt_countries .= '<option value="' . $value['code'] . '">' . $value['name'][$this->lang] . '</option>';

			$opt_times_zones = '';

			foreach ($this->model->get_times_zones() as $value)
				$opt_times_zones .= '<option value="' . $value['code'] . '">' . $value['code'] . '</option>';

			$opt_currencies = '';

			foreach ($this->model->get_currencies() as $value)
				$opt_currencies .= '<option value="' . $value['code'] . '">' . $value['name'][$this->lang] . ' (' . $value['code'] . ')</option>';

			$opt_languages = '';

			foreach ($this->model->get_languages() as $value)
				$opt_languages .= '<option value="' . $value['code'] . '">' . $value['name'] . '</option>';

			$opt_ladas = '';

			foreach ($this->model->get_countries() as $value)
				$opt_ladas .= '<option value="' . $value['lada'] . '">(+' . $value['lada'] . ') ' . $value['name'][$this->lang] . '</option>';

			$replace = [
				'{$opt_countries}' => $opt_countries,
				'{$opt_times_zones}' => $opt_times_zones,
				'{$opt_currencies}' => $opt_currencies,
				'{$opt_languages}' => $opt_languages,
				'{$opt_ladas}' => $opt_ladas
			];

			$template = $this->format->replace($replace, $template);

			echo $template;
		}
	}

	public function activate($params)
	{
		$template = $this->view->render($this, 'activate');

		if ($params[0] == 'account')
			define('_title', 'Guestvox | {$lang.activate_account}');
		else if ($params[0] == 'user')
			define('_title', 'Guestvox | {$lang.activate_user}');

		$query = $this->model->new_activation($params);

		$html = '';

		if (!empty($query))
		{
			if ($query['status'] == false)
			{
				if ($params[0] == 'account')
					$html = '{$lang.your_account_has_been_activated}';
				else if ($params[0] == 'user')
					$html = '{$lang.your_user_has_been_activated}';

				$mail = new Mailer(true);

				try
				{
					$mail->setFrom('daniel@guestvox.com', 'Daniel Basurto');

					if ($params[0] == 'account')
						$mail->addAddress($query['contact']['email'], $query['contact']['firstname'] . ' ' . $query['contact']['lastname']);
					else if ($params[0] == 'user')
						$mail->addAddress($query['email'], $query['firstname'] . ' ' . $query['lastname']);

					$mail->Subject = Lang::general('activated_subject', $params[0])[$query['language']];
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
											<img style="width:100%;max-width:300px;" src="https://' . Configuration::$domain . '/images/logotype_color.png" />
										</figure>
									</td>
								</tr>
								<tr style="width:100%;margin:0px 0px 10px 0px;padding:0px;border:0px;">
									<td style="width:100%;margin:0px;padding:40px 20px;border:0px;box-sizing:border-box;background-color:#fff;">
										<h4 style="width:100%;margin:0px 0px 20px 0px;padding:0px;font-size:18px;font-weight:600;text-align:center;color:#212121;">' . $mail->Subject . '</h4>
										' . (($params[0] == 'account') ? '<h6 style="width:100%;margin:0px 0px 20px 0px;padding:0px;font-size:14px;font-weight:400;text-align:center;color:#757575;">' . Lang::general('token')[$query['language']] . ': ' . $query['token'] . '</h4>' : '') . '
										<p style="width:100%;margin:0px 0px 20px 0px;padding:0px;font-size:14px;font-weight:400;text-align:center;color:#757575;">' . Lang::general('activated_text', $params[0])[$query['language']] . '</p>
										<a style="width:100%;display:block;margin:0px;padding:20px 0px;border-radius:40px;box-sizing:border-box;background-color:#00a5ab;font-size:14px;font-weight:400;text-align:center;text-decoration:none;color:#fff;" href="https://' . Configuration::$domain . '/login">' . Lang::general('login')[$query['language']] . '</a>
									</td>
								</tr>
								<tr style="width:100%;margin:0px 0px 10px 0px;padding:0px;border:0px;">
									<td style="width:100%;margin:0px;padding:40px 20px;border:0px;box-sizing:border-box;background-color:#fff;">
										<figure style="width:100%;margin:0px;padding:40px 0px;border:0px;box-sizing:border-box;text-align:center;">
											<img style="width:150px;height:150px;border-radius:50%;" src="https://' . Configuration::$domain . '/images/index/st_8_image_1.png">
											<span style="display:block;color:#757575;font-size:18px;">Daniel Basurto</span>
											<span style="display:block;color:#757575;font-size:18px;">CEO</span>
											<span style="display:block;color:#757575;font-size:18px;">daniel@guestvox.com</span>
											<span style="display:block;color:#757575;font-size:18px;">+52 (998) 845 28 43</span>
										</figure>
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
			else
			{
				if ($params[0] == 'account')
					$html = '{$lang.account_already_activated}';
				else if ($params[0] == 'user')
					$html = '{$lang.user_already_activated}';
			}
		}
		else
			$html = '{$lang.error_to_activate}';

		$replace = [
			'{$html}' => $html
		];

		$template = $this->format->replace($replace, $template);

		echo $template;
	}
}
