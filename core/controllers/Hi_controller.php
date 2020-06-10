<?php

defined('_EXEC') or die;

class Hi_controller extends Controller
{
	private $lang;

	public function __construct()
	{
		parent::__construct();

		$this->lang = Session::get_value('lang');
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
				if (!isset($_POST['rooms']) OR empty($_POST['rooms']))
					array_push($labels, ['rooms', '']);
			}

			if (!isset($_POST['name']) OR empty($_POST['name']))
				array_push($labels, ['name', '']);

			if (!isset($_POST['email']) OR empty($_POST['email']) OR Functions::check_email($_POST['email']) == false)
				array_push($labels, ['email', '']);

			if (!isset($_POST['phone']) OR empty($_POST['phone']))
				array_push($labels, ['phone', '']);

			if (empty($labels))
			{
				$mail1 = new Mailer(true);

				try
				{
					$mail1->setFrom('noreply@guestvox.com', 'Guestvox');
					$mail1->addAddress($_POST['email'], $_POST['name']);
					$mail1->Subject = Languages::words('thanks_request_demo')[$this->lang];
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
											<img style="width:100%;max-width:300px;" src="https://' . Configuration::$domain . '/images/hi/operation/logotype_color.png" />
										</figure>
									</td>
								</tr>
								<tr style="width:100%;margin:0px 0px 10px 0px;padding:0px;border:0px;">
									<td style="width:100%;margin:0px;padding:40px 20px;border:0px;box-sizing:border-box;background-color:#fff;">
										<h4 style="width:100%;margin:0px 0px 20px 0px;padding:0px;font-size:18px;font-weight:600;text-align:center;color:#212121;">' . $mail1->Subject . '</h4>
										<p style="width:100%;margin:0px;padding:0px;font-size:14px;font-weight:400;text-align:center;color:#757575;">' . Languages::words('representative_contact_you')[$this->lang] . '</p>
									</td>
								</tr>
								<tr style="width:100%;margin:0px;padding:0px;border:0px;">
									<td style="width:100%;margin:0px;padding:20px;border:0px;box-sizing:border-box;background-color:#fff;">
										<a style="width:100%;display:block;padding:20px 0px;box-sizing:border-box;font-size:14px;font-weight:400;text-align:center;text-decoration:none;color:#757575;" href="https://' . Configuration::$domain . '/operation">' . Configuration::$domain . '/operation</a>
									</td>
								</tr>
							</table>
						</body>
					</html>';
					$mail1->send();
				}
				catch (Exception $e) {}

				$mail2 = new Mailer(true);

				try
				{
					$mail2->setFrom('noreply@guestvox.com', 'Guestvox');
					$mail2->addAddress('contacto@guestvox.com', 'Guestvox');
					$mail2->Subject = 'Operación | Nueva solicitud de demo';
					$mail2->Body =
					'Compañía: ' . $_POST['business'] . '<br>
					Tipo: ' . Languages::words($_POST['type'])['es'] . '<br>
					' . (($_POST['type'] == 'hotel') ? 'Número de habitaciones: ' . $_POST['rooms'] . '<br>' : '') . '
					Nombre: ' . $_POST['name'] . '<br>
					Correo electrónico: ' . $_POST['email'] . '<br>
					Número telefónico: ' . $_POST['phone'];
					$mail2->send();
				}
				catch (Exception $e) {}

				Functions::environment([
					'status' => 'success',
					'message' => '{$lang.thanks_request_demo}'
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
			$template = $this->view->render($this, 'operation');

			define('_title', 'Guestvox | {$lang.operation} | {$lang.we_are_guestvox}');

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
				if (!isset($_POST['rooms']) OR empty($_POST['rooms']))
					array_push($labels, ['rooms', '']);
			}

			if (!isset($_POST['name']) OR empty($_POST['name']))
				array_push($labels, ['name', '']);

			if (!isset($_POST['email']) OR empty($_POST['email']) OR Functions::check_email($_POST['email']) == false)
				array_push($labels, ['email', '']);

			if (!isset($_POST['phone']) OR empty($_POST['phone']))
				array_push($labels, ['phone', '']);

			if (empty($labels))
			{
				$mail1 = new Mailer(true);

				try
				{
					$mail1->setFrom('noreply@guestvox.com', 'Guestvox');
					$mail1->addAddress($_POST['email'], $_POST['name']);
					$mail1->Subject = Languages::words('thanks_request_demo')[$this->lang];
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
											<img style="width:100%;max-width:300px;" src="https://' . Configuration::$domain . '/images/hi/reputation/logotype_color.png" />
										</figure>
									</td>
								</tr>
								<tr style="width:100%;margin:0px 0px 10px 0px;padding:0px;border:0px;">
									<td style="width:100%;margin:0px;padding:40px 20px;border:0px;box-sizing:border-box;background-color:#fff;">
										<h4 style="width:100%;margin:0px 0px 20px 0px;padding:0px;font-size:18px;font-weight:600;text-align:center;color:#212121;">' . $mail1->Subject . '</h4>
										<p style="width:100%;margin:0px;padding:0px;font-size:14px;font-weight:400;text-align:center;color:#757575;">' . Languages::words('representative_contact_you')[$this->lang] . '</p>
									</td>
								</tr>
								<tr style="width:100%;margin:0px;padding:0px;border:0px;">
									<td style="width:100%;margin:0px;padding:20px;border:0px;box-sizing:border-box;background-color:#fff;">
										<a style="width:100%;display:block;padding:20px 0px;box-sizing:border-box;font-size:14px;font-weight:400;text-align:center;text-decoration:none;color:#757575;" href="https://' . Configuration::$domain . '/reputation">' . Configuration::$domain . '/reputation</a>
									</td>
								</tr>
							</table>
						</body>
					</html>';
					$mail1->send();
				}
				catch (Exception $e) {}

				$mail2 = new Mailer(true);

				try
				{
					$mail2->setFrom('noreply@guestvox.com', 'Guestvox');
					$mail2->addAddress('contacto@guestvox.com', 'Guestvox');
					$mail2->Subject = 'Reputación | Nueva solicitud de demo';
					$mail2->Body =
					'Compañía: ' . $_POST['business'] . '<br>
					Tipo: ' . Languages::words($_POST['type'])['es'] . '<br>
					' . (($_POST['type'] == 'hotel') ? 'Número de habitaciones: ' . $_POST['rooms'] . '<br>' : '') . '
					Nombre: ' . $_POST['name'] . '<br>
					Correo electrónico: ' . $_POST['email'] . '<br>
					Número telefónico: ' . $_POST['phone'];
					$mail2->send();
				}
				catch (Exception $e) {}

				Functions::environment([
					'status' => 'success',
					'message' => '{$lang.thanks_request_demo}'
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
			$template = $this->view->render($this, 'reputation');

			define('_title', 'Guestvox | {$lang.reputation} | {$lang.we_are_guestvox}');

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

			if (!isset($_POST['email']) OR empty($_POST['email']) OR Functions::check_email($_POST['email']) == false)
				array_push($labels, ['email', '']);

			if (!isset($_POST['business']) OR empty($_POST['business']))
				array_push($labels, ['business', '']);

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
						$mail1->setFrom('noreply@guestvox.com', 'Guestvox');
						$mail1->addAddress($_POST['email'], $_POST['name']);
						$mail1->Subject = Languages::words('thanks_signup_webinar')[$this->lang];
						$mail1->Body =
						'<html>
							<head>
								<title>' . $mail1->Subject . '</title>
							</head>
							<body>
								<table style="width:600px;margin:0px;padding:20px;border:0px;box-sizing:border-box;background-color:#eee">
									<tr style="width:100%;margin:0px;padding:0px;border:0px;">
										<td style="width:100%;margin:0px;padding:40px 20px;border:0px;box-sizing:border-box;background-color:#fff;">
											<figure style="width:100%;margin:0px;padding:0px;text-align:center;">
												<img style="width:100%;max-width:300px;" src="https://' . Configuration::$domain . '/images/hi/webinar/logotype_color.png" />
											</figure>
										</td>
									</tr>
									<tr style="width:100%;margin:0px;padding:0px;border:0px;">
										<td style="width:100%;margin:0px;padding:40px 20px;border:0px;box-sizing:border-box;background-color:#fff;">
											<h4 style="width:100%;margin:0px 0px 20px 0px;padding:0px;font-size:18px;font-weight:600;text-align:center;color:#212121;">' . $mail1->Subject . '</h4>
											<figure style="width:100%;margin:0px 0px 20px 0px;padding:0px;text-align:center;">
												<img style="width:100%;" src="https://' . Configuration::$domain . '/images/hi/webinar/' . $webinar['image'] . '" />
											</figure>
											<a style="width:100%;display:block;margin:0px;padding:20px 0px;border-radius:40px;box-sizing:border-box;background-color:#00a5ab;font-size:14px;font-weight:400;text-align:center;text-decoration:none;color:#fff;" href="' . $webinar['link'] . '">' . Languages::words('go_to_webinar')[$this->lang] . '</a>
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
						$mail1->send();
					}
					catch (Exception $e) {}

					$mail2 = new Mailer(true);

					try
					{
						$mail2->setFrom('noreply@guestvox.com', 'Guestvox');
						$mail2->addAddress('contacto@guestvox.com', 'Guestvox');
						$mail2->Subject = 'Webinar | Nuevo resgistro';
						$mail2->Body =
						'Nombre: ' . $_POST['name'] . '<br>
						Correo electrónico: ' . $_POST['email'] . '<br>
						Compañía: ' . $_POST['business'] . '<br>
						Puesto: ' . $_POST['job'];
						$mail2->send();
					}
					catch (Exception $e) {}

					Functions::environment([
						'status' => 'success',
						'message' => '{$lang.thanks_signup_webinar_1} <strong>' . $_POST['email'] . '</strong> {$lang.thanks_signup_webinar_2}'
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
			$template = $this->view->render($this, 'webinar');

			define('_title', 'Guestvox | {$lang.webinar} | {$lang.we_are_guestvox}');

			$replace = [
				'{$image}' => '{$path.images}hi/webinar/' . $webinar['image'],
				'{$date}' => Functions::get_formatted_date_hour($webinar['date'], $webinar['hour'])
			];

			$template = $this->format->replace($replace, $template);

			echo $template;
		}
	}
}
