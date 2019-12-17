<?php

defined('_EXEC') or die;

class Index_controller extends Controller
{
	public function __construct()
	{
		parent::__construct();
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

				if ($_POST['type'] == 'hotel' AND $_POST['rooms_number'] > 0)
					$query = $this->model->get_room_package($_POST['rooms_number']);
				else if ($_POST['type'] == 'restaurant' AND $_POST['tables_number'] > 0)
					$query = $this->model->get_table_package($_POST['tables_number']);

				if (!empty($query))
				{
					$data['price']['operation'] = $query['price']['operation'];
					$data['price']['reputation'] = $query['price']['reputation'];

					if (!empty($_POST['operation']))
						$data['total'] = $data['total'] + $query['price']['operation'];

					if (!empty($_POST['reputation']))
						$data['total'] = $data['total'] + $query['price']['reputation'];

					if (!empty($_POST['operation']) AND !empty($_POST['reputation']))
						$data['total'] = $data['total'] - ($data['total'] * 0.40);
				}

				$data['price']['operation'] = Functions::get_formatted_currency($data['price']['operation'], 'MXN');
				$data['price']['reputation'] = Functions::get_formatted_currency($data['price']['reputation'], 'MXN');
				$data['total'] = Functions::get_formatted_currency($data['total'], 'MXN');

				Functions::environment([
					'status' => 'success',
					'data' => $data
				]);
			}

			if ($_POST['action'] == 'go_to_step')
			{
				if ($_POST['step'] == '1')
				{
					$labels = [];

					if (!isset($_POST['name']) OR empty($_POST['name']) OR $this->model->check_exist_account('name', $_POST['name']) == true)
				        array_push($labels, ['name','']);

					if (!isset($_POST['type']) OR empty($_POST['type']))
				        array_push($labels, ['type','']);

					if ($_POST['type'] == 'hotel')
					{
						if (!isset($_POST['rooms_number']) OR empty($_POST['rooms_number']) OR !is_numeric($_POST['rooms_number']) OR $_POST['rooms_number'] < 1)
					        array_push($labels, ['rooms_number','']);
					}
					else if ($_POST['type'] == 'restaurant')
					{
						if (!isset($_POST['tables_number']) OR empty($_POST['tables_number']) OR !is_numeric($_POST['tables_number']) OR $_POST['tables_number'] < 1)
					        array_push($labels, ['tables_number','']);
					}

					if (!isset($_POST['zip_code']) OR empty($_POST['zip_code']))
				        array_push($labels, ['zip_code','']);

					if (!isset($_POST['country']) OR empty($_POST['country']))
				        array_push($labels, ['country','']);

					if (!isset($_POST['city']) OR empty($_POST['city']))
				        array_push($labels, ['city','']);

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
							if ($_POST['language'] == 'es')
							{
								$mail1_subject = 'Saludos de GuestVox';
								$mail1_text = 'Hola <strong>' . $_POST['contact_firstname'] . '</strong> ¡Gracias por registrarte en GuestVox! Soy <strong>Daniel Basurto</strong>, CEO de GuestVox y espero te encuentres de lo mejor. Necesitamos validar tu correo electrónico para activar tu cuenta.';
								$mail1_btn = 'Validar';
								$mail1_terms = 'Terminos y condiciones';
							}
							else if ($_POST['language'] == 'en')
							{
								$mail1_subject = 'Regards from GuestVox';
								$mail1_text = 'Hi <strong>' . $_POST['contact_firstname'] . '</strong> ¡Thanks for sign up in GuestVox! I am <strong>Daniel Basurto</strong>, CEO for GuestVox and I hope you find the best. We need to validate your email to activate your account.';
								$mail1_btn = 'Validate';
								$mail1_terms = 'Terms y conditions';
							}

							$mail1->isSMTP();
							$mail1->setFrom('daniel@guestvox.com', 'Daniel Basurto');
							$mail1->addAddress($_POST['contact_email'], $_POST['contact_firstname'] . ' ' . $_POST['contact_lastname']);
							$mail1->isHTML(true);
							$mail1->Subject = $mail1_subject;
							$mail1->Body =
							'<html>
							    <head>
							        <title>' . $mail1_subject . '</title>
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
												<p style="font-size:14px;font-weight:400;text-align:center;color:#212121;margin:0px;padding:0px;">' . $mail1_text . '</p>
							                    <a style="width:100%;display:block;margin:15px 0px 10px 0px;padding:20px 0px;box-sizing:border-box;font-size:14px;font-weight:400;text-align:center;text-decoration:none;color:#fff;background-color:#201d33;" href="https://' . Configuration::$domain . '/validate/account/' . $query['account'] . '">' . $mail1_btn . '</a>
							                    <a style="width:100%;display:block;margin:0px 0px 20px 0px;padding:0px;box-sizing:border-box;font-size:12px;font-weight:400;text-align:center;text-decoration:none;color:#757575;" href="https://' . Configuration::$domain . '/terms">' . $mail1_terms . '</a>
							                </td>
							            </tr>
							            <tr style="width:100%;margin:0px;margin-bottom:10px;border:0px;padding:0px;">
							                <td style="width:100%;margin:0px;border:0px;padding:40px 20px;box-sizing:border-box;background-color:#fff;">
												<figure style="width:100%;margin:0px;border:0px;padding:40px 0px;box-sizing:border-box;text-align:center;">
													<img style="width:150px;height:150px;border-radius:50%;" src="https://' . Configuration::$domain . '/images/basurto.png">
													<span style="display:block;color:#757575;font-size:18px;">Daniel Basurto</span>
													<span style="display:block;color:#757575;font-size:18px;">CEO</span>
													<span style="display:block;color:#757575;font-size:18px;">daniel@guestvox.com</span>
													<span style="display:block;color:#757575;font-size:18px;">+52 (998) 845 28 43</span>
												</figure>
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
							$mail1->AltBody = '';
							$mail1->send();
						}
						catch (Exception $e) { }

						$mail2 = new Mailer(true);

						try
						{
							if ($_POST['language'] == 'es')
							{
								$mail2_subject = 'Saludos de GuestVox';
								$mail2_text = 'Hola <strong>' . $_POST['firstname'] . '</strong> ¡Gracias por registrarte en GuestVox! Soy <strong>Daniel Basurto</strong>, CEO de GuestVox y espero te encuentres de lo mejor. Necesitamos validar tu correo electrónico para poder activar tu usuario.';
								$mail2_btn = 'Validar';
							}
							else if ($_POST['language'] == 'en')
							{
								$mail2_subject = 'Regards from GuestVox';
								$mail2_text = 'Hi <strong>' . $_POST['firstname'] . '</strong> ¡Thanks for sign up in GuestVox! I am <strong>Daniel Basurto</strong>, CEO for GuestVox and I hope you find the best. We need to validate your email to activate your user.';
								$mail2_btn = 'Validate';
							}

							$mail2->isSMTP();
							$mail2->setFrom('daniel@guestvox.com', 'Daniel Basurto');
							$mail2->addAddress($_POST['email'], $_POST['firstname'] . ' ' . $_POST['lastname']);
							$mail2->isHTML(true);
							$mail2->Subject = $mail2_subject;
							$mail2->Body =
							'<html>
							    <head>
							        <title>' . $mail2_subject . '</title>
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
												<p style="font-size:14px;font-weight:400;text-align:center;color:#212121;margin:0px;padding:0px;">' . $mail2_text . '</p>
							                    <a style="width:100%;display:block;margin:15px 0px 20px 0px;padding:20px 0px;box-sizing:border-box;font-size:14px;font-weight:400;text-align:center;text-decoration:none;color:#fff;background-color:#201d33;" href="https://' . Configuration::$domain . '/validate/user/' . $query['user'] . '">' . $mail2_btn . '</a>
							                </td>
							            </tr>
							            <tr style="width:100%;margin:0px;margin-bottom:10px;border:0px;padding:0px;">
							                <td style="width:100%;margin:0px;border:0px;padding:40px 20px;box-sizing:border-box;background-color:#fff;">
												<figure style="width:100%;margin:0px;border:0px;padding:40px 0px;box-sizing:border-box;text-align:center;">
													<img style="width:150px;height:150px;border-radius:50%;" src="https://' . Configuration::$domain . '/images/basurto.png">
													<span style="display:block;color:#757575;font-size:18px;">Daniel Basurto</span>
													<span style="display:block;color:#757575;font-size:18px;">CEO</span>
													<span style="display:block;color:#757575;font-size:18px;">daniel@guestvox.com</span>
													<span style="display:block;color:#757575;font-size:18px;">+52 (998) 845 28 43</span>
												</figure>
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
							$mail2->AltBody = '';
							$mail2->send();
						}
						catch (Exception $e) { }

						$mail3 = new Mailer(true);

						try
						{
							$mail3->setFrom('noreply@guestvox.com', 'GuestVox');
							$mail3->addAddress('daniel@guestvox.com', 'Daniel Basurto');
							$mail3->isHTML(true);
							$mail3->Subject = 'Nuevo registro';
							$mail3->Body =
							'Nombre: ' . $_POST['name'] . '<br>
							' . (($_POST['type'] == 'hotel') ? 'Tipo: Hotel<br>' : '') . '
							' . (($_POST['type'] == 'restaurant') ? 'Tipo: Restaurante<br>' : '') . '
							' . (($_POST['type'] == 'hotel') ? 'Número de habitaciones: ' . $_POST['rooms_number'] . '<br>' : '') . '
							' . (($_POST['type'] == 'restaurant') ? 'Número de mesas: ' . $_POST['tables_number'] . '<br>' : '') . '
							Páis: ' . $_POST['zip_code'] . ' ' . $_POST['country'] . ' ' . $_POST['city'] . '<br>
							ID Fiscal: ' . $_POST['fiscal_id'] . '<br>
							Nombre fiscal: ' . $_POST['fiscal_name'] . '<br>
							Contácto: ' . $_POST['contact_firstname'] . ' ' . $_POST['contact_lastname'] . ' ' . $_POST['contact_department'] . ' ' .  $_POST['contact_email'] . ' +' . $_POST['contact_phone_lada'] . ' ' . $_POST['contact_phone_number'] . '<br>
							Administrador: ' . $_POST['firstname'] . ' ' . $_POST['lastname'] . ' ' . $_POST['email'] . ' +' . $_POST['phone_lada'] . ' ' . $_POST['phone_number'] . '<br>
							Host: ' . Configuration::$domain;
							$mail3->AltBody = '';
							$mail3->send();
						}
						catch (Exception $e) { }

						if (Session::get_value('lang') == 'es')
							$mail_message = '¡Gracias por resgistrarte en GuestVox! Hemos enviado un correo electrónico a <strong>' . $_POST['contact_email'] . '</strong> para activar tu cuenta y otro correo electrónico a <strong>' . $_POST['email'] . '</strong> para activar tu usuario';
						else if (Session::get_value('lang') == 'en')
							$mail_message = '¡Thanks for sign up in GuestVox! We have sent an email to <strong>' . $_POST['contact_email'] . '</strong> to activate your account and other email to <strong>' . $_POST['email'] . '</strong> to activate your user';

						Functions::environment([
                            'status' => 'success',
                            'message' => $mail_message
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

			if ($_POST['action'] == 'login')
			{
				$labels = [];

				if (!isset($_POST['username']) OR empty($_POST['username']))
					array_push($labels, ['username','']);

				if (!isset($_POST['password']) OR empty($_POST['password']))
					array_push($labels, ['password','']);

				if (empty($labels))
				{
					$query = $this->model->get_login($_POST);

					if (!empty($query))
					{
						if ($query['account']['status'] == true)
						{
							if ($query['user']['status'] == true)
							{
								$query['user']['password'] = explode(':', $query['user']['password']);
								$query['user']['password'] = ($this->security->create_hash('sha1', $_POST['password'] . $query['user']['password'][1]) === $query['user']['password'][0]) ? true : false;

								if ($query['user']['password'] == true)
								{
									unset($query['user']['password']);
									unset($query['user']['status']);
									unset($query['account']['status']);

									Session::init();
									Session::set_value('session', true);
									Session::set_value('user', $query['user']);
									Session::set_value('account', $query['account']);
									Session::set_value('lang', $query['account']['language']);
									Session::set_value('_vkye_last_access', Functions::get_current_date_hour());

									Functions::environment([
										'status' => 'success'
									]);
								}
								else
								{
									Functions::environment([
										'status' => 'error',
										'labels' => [['password','']]
									]);
								}
							}
							else
							{
								Functions::environment([
									'status' => 'error',
									'message' => '{$lang.user_not_activate}'
								]);
							}
						}
						else
						{
							Functions::environment([
								'status' => 'error',
								'message' => '{$lang.account_not_activate}'
							]);
						}
					}
					else
					{
						Functions::environment([
							'status' => 'error',
							'labels' => [['username','']]
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

			$template = $this->view->render($this, 'index');

			$opt_countries = '';

			foreach ($this->model->get_countries() as $value)
				$opt_countries .= '<option value="' . $value['code'] . '">' . $value['name'][Session::get_value('lang')] . '</option>';

			$opt_time_zones = '';

			foreach ($this->model->get_time_zones() as $value)
				$opt_time_zones .= '<option value="' . $value['code'] . '">' . $value['code'] . '</option>';

			$opt_currencies = '';

			foreach ($this->model->get_currencies() as $value)
				$opt_currencies .= '<option value="' . $value['code'] . '">(' . $value['code'] . ') ' . $value['name'][Session::get_value('lang')] . '</option>';

			$opt_languages = '';

			foreach ($this->model->get_languages() as $value)
				$opt_languages .= '<option value="' . $value['code'] . '">' . $value['name'] . '</option>';

			$opt_ladas = '';

			foreach ($this->model->get_countries() as $value)
				$opt_ladas .= '<option value="' . $value['lada'] . '">(+' . $value['lada'] . ') ' . $value['name'][Session::get_value('lang')] . '</option>';

			$replace = [
				'{$opt_countries}' => $opt_countries,
				'{$opt_time_zones}' => $opt_time_zones,
				'{$opt_currencies}' => $opt_currencies,
				'{$opt_languages}' => $opt_languages,
				'{$opt_ladas}' => $opt_ladas
			];

			$template = $this->format->replace($replace, $template);

			echo $template;
		}
	}

	public function validate($params)
	{
		define('_title', 'GuestVox');

		$template = $this->view->render($this, 'validate');

		$txt = '';

		if (!empty($params))
		{
			if ($params[0] == 'account' OR $params[0] == 'user')
			{
				$query = $this->model->new_validation($params);

				if (!empty($query))
				{
					if ($query['status'] == false)
					{
						if ($params[0] == 'account')
							$txt = '{$lang.your_email} <strong>' . $query['contact']['email'] . '</strong> {$lang.was_validate_and_account} <strong>' . $query['name'] . '</strong> {$lang.was_activated_a}';
						else if ($params[0] == 'user')
							$txt = '{$lang.your_email} <strong>' . $query['email'] . '</strong> {$lang.was_validate_and_user} <strong>' . $query['username'] . '</strong> {$lang.was_activated_o}';

						$mail = new Mailer(true);

						try
						{
							if ($params[0] == 'account')
							{
								if ($query['language'] == 'es')
								{
									$mail_subject = 'Tu correo electrónico ha sido validado';
									$mail_text = '¡<strong>Felicidades</strong>! Tu correo electrónico fue validado correctamente y tu cuenta ya ha sido activada ¡Bienvenido a GuestVox!';
									$mail_btn = 'Ir a GuestVox';
								}
								else if ($query['language'] == 'en')
								{
									$mail_subject = 'Your email has been validated';
									$mail_text = '¡<strong>Congratulations</strong>! Your email was validated correctly and you account has been activated ¡Welcome to GuestVox!';
									$mail_btn = 'Go to GuestVox';
								}
							}
							else if ($params[0] == 'user')
							{
								if ($query['language'] == 'es')
								{
									$mail_subject = 'Tu correo electrónico ha sido validado';
									$mail_text = '¡<strong>Felicidades</strong>! Tu correo electrónico fue validado correctamente y tu usuario ya ha sido activado ¡Bienvenido a GuestVox!';
									$mail_btn = 'Ir a GuestVox';
								}
								else if ($query['language'] == 'en')
								{
									$mail_subject = 'Your email has been validated';
									$mail_text = '¡<strong>Congratulations</strong>! Your email was validated correctly and you user has been activated ¡Welcome to GuestVox!';
									$mail_btn = 'Go to GuestVox';
								}
							}

							$mail->isSMTP();
							$mail->setFrom('daniel@guestvox.com', 'Daniel Basurto');

							if ($params[0] == 'account')
								$mail->addAddress($query['contact']['email'], $query['contact']['firstname'] . ' ' . $query['contact']['lastname']);
							else if ($params[0] == 'user')
								$mail->addAddress($query['email'], $query['firstname'] . ' ' . $query['lastname']);

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
												<p style="font-size:14px;font-weight:400;text-align:center;color:#212121;margin:0px;padding:0px;">' . $mail_text . '</p>
												<a style="width:100%;display:block;margin:15px 0px 20px 0px;padding:20px 0px;box-sizing:border-box;font-size:14px;font-weight:400;text-align:center;text-decoration:none;color:#fff;background-color:#201d33;" href="https://' . Configuration::$domain . '">' . $mail_btn . '</a>
											</td>
										</tr>
										<tr style="width:100%;margin:0px;margin-bottom:10px;border:0px;padding:0px;">
											<td style="width:100%;margin:0px;border:0px;padding:40px 20px;box-sizing:border-box;background-color:#fff;">
												<figure style="width:100%;margin:0px;border:0px;padding:40px 0px;box-sizing:border-box;text-align:center;">
													<img style="width:150px;height:150px;border-radius:50%;" src="https://' . Configuration::$domain . '/images/basurto.png">
													<span style="display:block;color:#757575;font-size:18px;">Daniel Basurto</span>
													<span style="display:block;color:#757575;font-size:18px;">CEO</span>
													<span style="display:block;color:#757575;font-size:18px;">daniel@guestvox.com</span>
													<span style="display:block;color:#757575;font-size:18px;">+52 (998) 845 28 43</span>
												</figure>
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
					}
					else
					{
						if ($params[0] == 'account')
							$txt = '{$lang.account_already_activated}';
						else if ($params[0] == 'user')
							$txt = '{$lang.user_already_activated}';
					}
				}
				else
					$txt = '{$lang.operation_error}';
			}
			else
				$txt = '{$lang.operation_error}';
		}
		else
			$txt = '{$lang.operation_error}';

		$replace = [
			'{$txt}' => $txt
		];

		$template = $this->format->replace($replace, $template);

		echo $template;
	}
}
