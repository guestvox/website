<?php

defined('_EXEC') or die;

class Hi_controller extends Controller
{
	public function __construct()
	{
		parent::__construct();
	}

	public function operation()
	{
		if (Format::exist_ajax_request() == true)
		{
			$labels = [];

			if (!isset($_POST['business']) OR empty($_POST['business']))
				array_push($labels, ['business', '']);

			if (!isset($_POST['type']) OR empty($_POST['type']))
				array_push($labels, ['type', '']);

			if ($_POST['type'] == 'hotel')
			{
				if (!isset($_POST['owners']) OR empty($_POST['owners']))
					array_push($labels, ['owners', '']);
			}

			if (!isset($_POST['contact']) OR empty($_POST['contact']))
				array_push($labels, ['contact', '']);

			if (!isset($_POST['email']) OR empty($_POST['email']))
				array_push($labels, ['email', '']);

			if (!isset($_POST['phone']) OR empty($_POST['phone']))
				array_push($labels, ['phone', '']);

			if (empty($labels))
			{
				$mail1 = new Mailer(true);

				try
				{
					$mail1->isSMTP();
					$mail1->setFrom($_POST['email'], $_POST['contact']);
					$mail1->addAddress('contacto@guestvox.com', 'Guestvox');
					$mail1->isHTML(true);
					$mail1->Subject = 'Nueva solicitud para demo de Operación)';
					$mail1->Body =
					'Negocio: ' . $_POST['business'] .
					(($_POST['type'] == 'hotel') ? 'Tipo: Hotel' : '') .
					(($_POST['type'] == 'restaurant') ? 'Tipo: Restaurante' : '') .
					(($_POST['type'] == 'hospital') ? 'Tipo: Hospital' : '') .
					(($_POST['type'] == 'others') ? 'Tipo: Otros' : '') .
					(($_POST['type'] == 'hotel') ? 'Habitaciones: ' . $_POST['owners'] : '') .
					'Contacto: ' . $_POST['contact'] .
					'Correo electrónico: ' . $_POST['email'] .
					'Número telefonico: ' . $_POST['phone'];
					$mail1->AltBody = $mail1->Body;
					$mail1->send();
				}
				catch (Exception $e) {}

				$mail2 = new Mailer(true);

				try
				{
					$mail2->isSMTP();
					$mail2->setFrom('contacto@guestvox.com', 'Guestvox');
					$mail2->addAddress($_POST['email'], $_POST['contact']);
					$mail2->isHTML(true);
					$mail2->Subject = '¡Gracias! Hemos recibido tu solicitud';
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
											<img style="width:100%;max-width:300px;" src="https://' . Configuration::$domain . '/images/hi/operation/logotype-color.png" />
										</figure>
									</td>
								</tr>
								<tr style="width:100%;margin:0px 0px 10px 0px;padding:0px;border:0px;">
									<td style="width:100%;margin:0px;padding:40px 20px;border:0px;box-sizing:border-box;background-color:#fff;">
										<h4 style="width:100%;margin:0px 0px 50px 0px;padding:0px;font-size:18px;font-weight:600;text-align:center;color:#212121;">' . $mail2->Subject . '</h4>
										<p style="width:100%;margin:0px;padding:0px;font-size:14px;font-weight:400;text-align:center;color:#757575;">¡Muchas gracias por ponerte en contacto con nosotros! En breve uno de nuestros asesores se pondrá en contacto contigo.</p>
									</td>
								</tr>
								<tr style="width:100%;margin:0px;padding:0px;border:0px;">
									<td style="width:100%;margin:0px;padding:20px;border:0px;box-sizing:border-box;background-color:#fff;">
										<a style="width:100%;display:block;padding:20px 0px;box-sizing:border-box;font-size:14px;font-weight:400;text-align:center;text-decoration:none;color:#757575;" href="https://' . Configuration::$domain . '/operacion">' . Configuration::$domain . '/operacion</a>
									</td>
								</tr>
							</table>
						</body>
					</html>';
					$mail2->AltBody = $mail2->Body;
					$mail2->send();
				}
				catch (Exception $e) {}

				Functions::environment([
					'status' => 'success',
					'message' => '¡Muchas gracias por ponerte en contacto con nosotros! En breve uno de nuestros asesores se pondrá en contacto contigo.'
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
		else
		{
			define('_title', 'Guestvox | {$lang.operation} | {$lang.we_are_guestvox}');

			$template = $this->view->render($this, 'operation');

			echo $template;
		}
	}

	public function reputation()
	{
		if (Format::exist_ajax_request() == true)
		{
			$labels = [];

			if (!isset($_POST['business']) OR empty($_POST['business']))
				array_push($labels, ['business', '']);

			if (!isset($_POST['type']) OR empty($_POST['type']))
				array_push($labels, ['type', '']);

			if ($_POST['type'] == 'hotel')
			{
				if (!isset($_POST['owners']) OR empty($_POST['owners']))
					array_push($labels, ['owners', '']);
			}

			if (!isset($_POST['contact']) OR empty($_POST['contact']))
				array_push($labels, ['contact', '']);

			if (!isset($_POST['email']) OR empty($_POST['email']))
				array_push($labels, ['email', '']);

			if (!isset($_POST['phone']) OR empty($_POST['phone']))
				array_push($labels, ['phone', '']);

			if (empty($labels))
			{
				$mail1 = new Mailer(true);

				try
				{
					$mail1->isSMTP();
					$mail1->setFrom($_POST['email'], $_POST['contact']);
					$mail1->addAddress('contacto@guestvox.com', 'Guestvox');
					$mail1->isHTML(true);
					$mail1->Subject = 'Nueva solicitud para demo de Reputación)';
					$mail1->Body =
					'Negocio: ' . $_POST['business'] .
					(($_POST['type'] == 'hotel') ? 'Tipo: Hotel' : '') .
					(($_POST['type'] == 'restaurant') ? 'Tipo: Restaurante' : '') .
					(($_POST['type'] == 'hospital') ? 'Tipo: Hospital' : '') .
					(($_POST['type'] == 'others') ? 'Tipo: Otros' : '') .
					(($_POST['type'] == 'hotel') ? 'Habitaciones: ' . $_POST['owners'] : '') .
					'Contacto: ' . $_POST['contact'] .
					'Correo electrónico: ' . $_POST['email'] .
					'Número telefonico: ' . $_POST['phone'];
					$mail1->AltBody = $mail1->Body;
					$mail1->send();
				}
				catch (Exception $e) {}

				$mail2 = new Mailer(true);

				try
				{
					$mail2->isSMTP();
					$mail2->setFrom('contacto@guestvox.com', 'Guestvox');
					$mail2->addAddress($_POST['email'], $_POST['contact']);
					$mail2->isHTML(true);
					$mail2->Subject = '¡Gracias! Hemos recibido tu solicitud';
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
											<img style="width:100%;max-width:300px;" src="https://' . Configuration::$domain . '/images/hi/reputation/logotype-color.png" />
										</figure>
									</td>
								</tr>
								<tr style="width:100%;margin:0px 0px 10px 0px;padding:0px;border:0px;">
									<td style="width:100%;margin:0px;padding:40px 20px;border:0px;box-sizing:border-box;background-color:#fff;">
										<h4 style="width:100%;margin:0px 0px 50px 0px;padding:0px;font-size:18px;font-weight:600;text-align:center;color:#212121;">' . $mail2->Subject . '</h4>
										<p style="width:100%;margin:0px;padding:0px;font-size:14px;font-weight:400;text-align:center;color:#757575;">¡Muchas gracias por ponerte en contacto con nosotros! En breve uno de nuestros asesores se pondrá en contacto contigo.</p>
									</td>
								</tr>
								<tr style="width:100%;margin:0px;padding:0px;border:0px;">
									<td style="width:100%;margin:0px;padding:20px;border:0px;box-sizing:border-box;background-color:#fff;">
										<a style="width:100%;display:block;padding:20px 0px;box-sizing:border-box;font-size:14px;font-weight:400;text-align:center;text-decoration:none;color:#757575;" href="https://' . Configuration::$domain . '/reputacion">' . Configuration::$domain . '/reputacion</a>
									</td>
								</tr>
							</table>
						</body>
					</html>';
					$mail2->AltBody = $mail2->Body;
					$mail2->send();
				}
				catch (Exception $e) {}

				Functions::environment([
					'status' => 'success',
					'message' => '¡Muchas gracias por ponerte en contacto con nosotros! En breve uno de nuestros asesores se pondrá en contacto contigo.'
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
		else
		{
			define('_title', 'Guestvox | {$lang.reputation} | {$lang.we_are_guestvox}');

			$template = $this->view->render($this, 'reputation');

			echo $template;
		}
	}

	public function webinar()
	{
		$webinar = $this->model->get_webinar();

		if (Format::exist_ajax_request() == true)
		{
			$labels = [];

			if (!isset($_POST['name']) OR empty($_POST['name']))
				array_push($labels, ['name', '']);

			if (!isset($_POST['email']) OR empty($_POST['email']))
				array_push($labels, ['email', '']);

			if (!isset($_POST['company']) OR empty($_POST['company']))
				array_push($labels, ['company', '']);

			if (!isset($_POST['job']) OR empty($_POST['job']))
				array_push($labels, ['job', '']);

			if (empty($labels))
			{
				$_POST['webinar'] = $webinar['id'];

				$query = $this->model->new_webinar_signup($_POST);

				if (!empty($query))
				{
					$mail1 = new Mailer(true);

					try
					{
						$mail1->isSMTP();
						$mail1->setFrom($_POST['email'], $_POST['name']);
						$mail1->addAddress('contacto@guestvox.com', 'Guestvox');
						$mail1->isHTML(true);
						$mail1->Subject = $_POST['name'] . ' se ha registrado al Webinar';
						$mail1->Body =
						'Nombre: ' . $_POST['name'] .
						'Correo electrónico: ' . $_POST['email'] .
						'Empresa: ' . $_POST['company'] .
						'Puesto: ' . $_POST['job'];
						$mail1->AltBody = $mail1->Body;
						$mail1->send();
					}
					catch (Exception $e) {}

					$mail2 = new Mailer(true);

					try
					{
						$mail2->isSMTP();
						$mail2->setFrom('contacto@guestvox.com', 'Guestvox');
						$mail2->addAddress($_POST['email'], $_POST['name']);
						$mail2->isHTML(true);
						$mail2->Subject = '¡Gracias por registrarte al Webinar!';
						$mail2->Body =
						'<html>
							<head>
								<title>' . $mail2->Subject . '</title>
							</head>
							<body>
								<table style="width:600px;margin:0px;padding:20px;border:0px;box-sizing:border-box;background-color:#eee">
									<tr style="width:100%;margin:0px;padding:0px;border:0px;">
										<td style="width:100%;margin:0px;padding:40px 20px;border:0px;box-sizing:border-box;background-color:#fff;">
											<figure style="width:100%;margin:0px;padding:0px;text-align:center;">
												<img style="width:100%;max-width:300px;" src="https://' . Configuration::$domain . '/images/hi/webinar/logotype-color.png" />
											</figure>
										</td>
									</tr>
									<tr style="width:100%;margin:0px;padding:0px;border:0px;">
										<td style="width:100%;margin:0px;padding:40px 20px;border:0px;box-sizing:border-box;background-color:#00a5ab;">
											<h4 style="width:100%;margin:0px 0px 50px 0px;padding:0px;font-size:18px;font-weight:600;text-align:center;color:#fff;">' . $mail2->Subject . '</h4>
											<figure style="width:100%;margin:0px 0px 50px 0px;padding:0px;text-align:center;">
												<img style="width:100%;" src="https://' . Configuration::$domain . '/images/hi/webinar/' . $webinar['image'] . '" />
											</figure>
											<a style="width:100%;display:block;margin:0px;padding:20px 0px;border-radius:50px;box-sizing:border-box;background-color:#fff;font-size:14px;font-weight:400;text-align:center;text-decoration:none;color:#00a5ab;" href="' . $webinar['link'] . '">Ir al Webinar</a>
										</td>
									</tr>
									<tr style="width:100%;margin:0px;padding:0px;border:0px;">
										<td style="width:100%;margin:0px;padding:20px;border:0px;box-sizing:border-box;background-color:#fff;">
											<a style="width:100%;display:block;padding:20px 0px;box-sizing:border-box;font-size:14px;font-weight:400;text-align:center;text-decoration:none;color:#757575;" href="https://' . Configuration::$domain . '/webinar">' . Configuration::$domain . '/webinar</a>
										</td>
									</tr>
								</table>
							</body>
						</html>';
						$mail2->AltBody = $mail2->Body;
						$mail2->send();
					}
					catch (Exception $e) {}

					Functions::environment([
						'status' => 'success',
						'message' => '¡Gracias por registrarte al Webinar! Te hemos enviado un correo electrónico a <strong>' . $_POST['email'] . '</strong> con los detalles del Webinar.'
					]);
				}
				else
				{
					Functions::environment([
						'status' => 'success',
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
		else
		{
			define('_title', 'Guestvox | {$lang.webinar} | {$lang.we_are_guestvox}');

			$template = $this->view->render($this, 'webinar');

			$btn_signup = '';
			$mdl_signup = '';

			if ($webinar['status'] == true)
			{
				$btn_signup .= '<a data-button-modal="signup">Regístrate</a>';
				$mdl_signup .=
				'<section class="modal" data-modal="signup">
				    <div class="content">
				        <header>
				            <h3>Regístrate al Webinar</h3>
				        </header>
				        <main>
				            <form name="signup">
				                <div class="row">
				                    <div class="span6">
				                        <div class="label">
				                            <label>
				                                <p>Nombre</p>
				                                <input type="text" name="name" />
				                            </label>
				                        </div>
				                    </div>
				                    <div class="span6">
				                        <div class="label">
				                            <label>
				                                <p>Correo electrónico</p>
				                                <input type="email" name="email" />
				                            </label>
				                        </div>
				                    </div>
				                    <div class="span6">
				                        <div class="label">
				                            <label>
				                                <p>Empresa</p>
				                                <input type="text" name="company" />
				                            </label>
				                        </div>
				                    </div>
				                    <div class="span6">
				                        <div class="label">
				                            <label>
				                                <p>Puesto</p>
				                                <input type="text" name="job" />
				                            </label>
				                        </div>
				                    </div>
				                </div>
				            </form>
				        </main>
				        <footer>
				            <div class="action-buttons">
				                <button class="btn btn-flat" button-cancel>{$lang.cancel}</button>
				                <button class="btn btn-colored" button-success>¡Registrate!</button>
				            </div>
				        </footer>
				    </div>
				</section>';
			}

			$replace = [
				'{$image}' => $webinar['image'],
				'{$status}' => ($webinar['status'] == true) ? 'Faltan' : 'Cerrado',
				'{$date}' => Functions::get_formatted_date_hour($webinar['date'], $webinar['hour']),
				'{$btn_signup}' => $btn_signup,
				'{$mdl_signup}' => $mdl_signup
			];

			$template = $this->format->replace($replace, $template);

			echo $template;
		}
	}
}
