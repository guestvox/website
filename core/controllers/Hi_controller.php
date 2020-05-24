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
				if (!isset($_POST['rooms_number']) OR empty($_POST['rooms_number']))
					array_push($labels, ['rooms_number', '']);
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
					$mail1->setFrom('noreply@guestvox.com', 'Guestvox');
					$mail1->addAddress($_POST['email'], $_POST['contact']);
					$mail1->Subject = Mailer::lang('thanks_request_demo')[$this->lang];
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
											<img style="width:100%;max-width:300px;" src="https://' . Configuration::$domain . '/images/hi/operation/logotype-color.png" />
										</figure>
									</td>
								</tr>
								<tr style="width:100%;margin:0px 0px 10px 0px;padding:0px;border:0px;">
									<td style="width:100%;margin:0px;padding:40px 20px;border:0px;box-sizing:border-box;background-color:#fff;">
										<h4 style="width:100%;margin:0px 0px 20px 0px;padding:0px;font-size:18px;font-weight:600;text-align:center;color:#212121;">' . $mail1->Subject . '</h4>
										<p style="width:100%;margin:0px;padding:0px;font-size:14px;font-weight:400;text-align:center;color:#757575;">' . Mailer::lang('representative_contact_you')[$this->lang] . '</p>
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
					'Negocio: ' . $_POST['business'] .
					(($_POST['type'] == 'hotel') ? 'Tipo: Hotel' : '') .
					(($_POST['type'] == 'restaurant') ? 'Tipo: Restaurante' : '') .
					(($_POST['type'] == 'hospital') ? 'Tipo: Hospital' : '') .
					(($_POST['type'] == 'others') ? 'Tipo: Otros' : '') .
					(($_POST['type'] == 'hotel') ? 'Número de habitaciones: ' . $_POST['rooms_number'] : '') .
					'Contacto: ' . $_POST['contact'] .
					'Correo electrónico: ' . $_POST['email'] .
					'Número telefonico: ' . $_POST['phone'];
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
				if (!isset($_POST['rooms_number']) OR empty($_POST['rooms_number']))
					array_push($labels, ['rooms_number', '']);
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
					$mail1->setFrom('noreply@guestvox.com', 'Guestvox');
					$mail1->addAddress($_POST['email'], $_POST['contact']);
					$mail1->Subject = Mailer::lang('thanks_request_demo')[$this->lang];
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
											<img style="width:100%;max-width:300px;" src="https://' . Configuration::$domain . '/images/hi/reputation/logotype-color.png" />
										</figure>
									</td>
								</tr>
								<tr style="width:100%;margin:0px 0px 10px 0px;padding:0px;border:0px;">
									<td style="width:100%;margin:0px;padding:40px 20px;border:0px;box-sizing:border-box;background-color:#fff;">
										<h4 style="width:100%;margin:0px 0px 20px 0px;padding:0px;font-size:18px;font-weight:600;text-align:center;color:#212121;">' . $mail1->Subject . '</h4>
										<p style="width:100%;margin:0px;padding:0px;font-size:14px;font-weight:400;text-align:center;color:#757575;">' . Mailer::lang('representative_contact_you')[$this->lang] . '</p>
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
					$mail1->send();
				}
				catch (Exception $e) {}

				$mail2 = new Mailer(true);

				try
				{
					$mail2->setFrom('norepl@guestvox.com', 'Guestvox');
					$mail2->addAddress('contacto@guestvox.com', 'Guestvox');
					$mail2->Subject = 'Reputación | Nueva solicitud de demo';
					$mail2->Body =
					'Negocio: ' . $_POST['business'] .
					(($_POST['type'] == 'hotel') ? 'Tipo: Hotel' : '') .
					(($_POST['type'] == 'restaurant') ? 'Tipo: Restaurante' : '') .
					(($_POST['type'] == 'hospital') ? 'Tipo: Hospital' : '') .
					(($_POST['type'] == 'others') ? 'Tipo: Otros' : '') .
					(($_POST['type'] == 'hotel') ? 'Número de habitaciones: ' . $_POST['rooms_number'] : '') .
					'Contacto: ' . $_POST['contact'] .
					'Correo electrónico: ' . $_POST['email'] .
					'Número telefonico: ' . $_POST['phone'];
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
						$mail1->setFrom('contacto@guestvox.com', 'Guestvox');
						$mail1->addAddress($_POST['email'], $_POST['name']);
						$mail1->Subject = Mailer::lang('thanks_signup_webinar')[$this->lang];
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
												<img style="width:100%;max-width:300px;" src="https://' . Configuration::$domain . '/images/hi/webinar/logotype-color.png" />
											</figure>
										</td>
									</tr>
									<tr style="width:100%;margin:0px;padding:0px;border:0px;">
										<td style="width:100%;margin:0px;padding:40px 20px;border:0px;box-sizing:border-box;background-color:#fff;">
											<h4 style="width:100%;margin:0px 0px 20px 0px;padding:0px;font-size:18px;font-weight:600;text-align:center;color:#212121;">' . $mail1->Subject . '</h4>
											<figure style="width:100%;margin:0px 0px 20px 0px;padding:0px;text-align:center;">
												<img style="width:100%;" src="https://' . Configuration::$domain . '/images/hi/webinar/' . $webinar['image'] . '" />
											</figure>
											<a style="width:100%;display:block;margin:0px;padding:20px 0px;border-radius:40px;box-sizing:border-box;background-color:#00a5ab;font-size:14px;font-weight:400;text-align:center;text-decoration:none;color:#fff;" href="' . $webinar['link'] . '">' . Mailer::lang('go_to_webinar')[$this->lang] . '</a>
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
						'Nombre: ' . $_POST['name'] .
						'Correo electrónico: ' . $_POST['email'] .
						'Empresa: ' . $_POST['company'] .
						'Puesto: ' . $_POST['job'];
						$mail2->send();
					}
					catch (Exception $e) {}

					Functions::environment([
						'status' => 'success',
						'message' => '{$lang.thanks_signup_webinar_1}' . $_POST['email'] . '{$lang.thanks_signup_webinar_2}'
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

			$btn_signup = '';
			$mdl_signup = '';

			if ($webinar['status'] == true)
			{
				$btn_signup .= '<a data-button-modal="signup">{$lang.signup}</a>';
				$mdl_signup .=
				'<section class="modal" data-modal="signup">
				    <div class="content">
				        <main>
				            <form name="signup">
				                <div class="row">
				                    <div class="span6">
				                        <div class="label">
				                            <label required>
				                                <p>{$lang.name}</p>
				                                <input type="text" name="name" />
				                            </label>
				                        </div>
				                    </div>
				                    <div class="span6">
				                        <div class="label">
				                            <label required>
				                                <p>{$lang.email}</p>
				                                <input type="email" name="email" />
				                            </label>
				                        </div>
				                    </div>
				                    <div class="span6">
				                        <div class="label">
				                            <label required>
				                                <p>{$lang.company}</p>
				                                <input type="text" name="company" />
				                            </label>
				                        </div>
				                    </div>
				                    <div class="span6">
				                        <div class="label">
				                            <label required>
				                                <p>{$lang.job}</p>
				                                <input type="text" name="job" />
				                            </label>
				                        </div>
				                    </div>
				                    <div class="span12">
										<div class="buttons">
											<button type="submit">¡{$lang.signup}!</button>
											<button button-cancel>{$lang.cancel}</button>
										</div>
				                    </div>
				                </div>
				            </form>
				        </main>
				    </div>
				</section>';
			}

			$replace = [
				'{$image}' => '{$path.images}hi/webinar/' $webinar['image'],
				'{$status}' => ($webinar['status'] == true) ? '{$lang.missing}' : '{$lang.closed}',
				'{$date}' => Functions::get_formatted_date_hour($webinar['date'], $webinar['hour']),
				'{$btn_signup}' => $btn_signup,
				'{$mdl_signup}' => $mdl_signup
			];

			$template = $this->format->replace($replace, $template);

			echo $template;
		}
	}
}
