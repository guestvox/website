<?php

defined('_EXEC') or die;

class Index_controller extends Controller
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
			$labels = [];

			if (!isset($_POST['business']) OR empty($_POST['business']))
				array_push($labels, ['business','']);

			if ($_POST['quote'] == 'hotel' OR $_POST['quote'] == 'restaurant')
			{
				if (!isset($_POST['quantity']) OR empty($_POST['quantity']))
					array_push($labels, ['quantity','']);
			}

			if (!isset($_POST['name']) OR empty($_POST['name']))
				array_push($labels, ['name','']);

			if (!isset($_POST['email']) OR empty($_POST['email']) OR Functions::check_email($_POST['email']) == false)
				array_push($labels, ['email','']);

			if (!isset($_POST['phone']) OR empty($_POST['phone']))
				array_push($labels, ['phone','']);

			if (empty($labels))
			{
				$mail1 = new Mailer(true);

				try
				{
					$mail1->setFrom('noreply@guestvox.com', 'Guestvox');
					$mail1->addAddress($_POST['email'], $_POST['name']);
					$mail1->Subject = Languages::email('thanks_request_quote')[$this->lang];
					$mail1->Body =
					'<html>
						<head>
							<title>' . $mail1->Subject . '</title>
						</head>
						<body>
							<table style="width:600px;margin:0px;padding:20px;border:0px;box-sizing:border-box;background-color:#eee">
								<tr style="width:100%;margin:0px 0px 10px 0px;padding:0px;border:0px;">
									<td style="width:100%;margin:0px;padding:40px 20px;border:0px;box-sizing:border-box;background-color:#fff;">
										<figure style="width:100%;margin:0px;padding:0px;text-align:center;">';

					if ($_POST['quote'] == 'hotel')
						$mail1->Body .= '<img style="width:100%;max-width:300px;" src="https://' . Configuration::$domain . '/images/hi/hotels/logotype_color.png">';
					else if ($_POST['quote'] == 'restaurant')
						$mail1->Body .= '<img style="width:100%;max-width:300px;" src="https://' . Configuration::$domain . '/images/hi/restaurants/logotype_color.png">';
					else if ($_POST['quote'] == 'personalize')
						$mail1->Body .= '<img style="width:100%;max-width:300px;" src="https://' . Configuration::$domain . '/images/logotype_color.png">';

					$mail1->Body .=
					'					</figure>
									</td>
								</tr>
								<tr style="width:100%;margin:0px 0px 10px 0px;padding:0px;border:0px;">
									<td style="width:100%;margin:0px;padding:40px 20px;border:0px;box-sizing:border-box;background-color:#fff;">
										<h4 style="width:100%;margin:0px 0px 20px 0px;padding:0px;font-size:18px;font-weight:600;text-align:center;color:#212121;">' . $mail1->Subject . '</h4>
										<p style="width:100%;margin:0px;padding:0px;font-size:14px;font-weight:400;text-align:center;color:#757575;">' . Languages::email('representative_contact_you')[$this->lang] . '</p>
									</td>
								</tr>
								<tr style="width:100%;margin:0px;padding:0px;border:0px;">
									<td style="width:100%;margin:0px;padding:20px;border:0px;box-sizing:border-box;background-color:#fff;">';

					if ($_POST['quote'] == 'hotel')
						$mail1->Body .= '<a style="width:100%;display:block;padding:20px 0px;box-sizing:border-box;font-size:14px;font-weight:400;text-align:center;text-decoration:none;color:#757575;" href="https://' . Configuration::$domain . '/hoteles">' . Configuration::$domain . '/hoteles</a>';
					else if ($_POST['quote'] == 'restaurant')
						$mail1->Body .= '<a style="width:100%;display:block;padding:20px 0px;box-sizing:border-box;font-size:14px;font-weight:400;text-align:center;text-decoration:none;color:#757575;" href="https://' . Configuration::$domain . '/restaurantes">' . Configuration::$domain . '/restaurantes</a>';
					else if ($_POST['quote'] == 'personalize')
						$mail1->Body .= '<a style="width:100%;display:block;padding:20px 0px;box-sizing:border-box;font-size:14px;font-weight:400;text-align:center;text-decoration:none;color:#757575;" href="https://' . Configuration::$domain . '">' . Configuration::$domain . '</a>';

					$mail1->body .=
					'				</td>
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

					if ($_POST['quote'] == 'hotel')
						$mail2->Subject = 'Hoteles | Nueva solicitud cotización';
					else if ($_POST['quote'] == 'restaurant')
						$mail2->Subject = 'Restaurantes | Nueva solicitud cotización';
					else if ($_POST['quote'] == 'personalize')
						$mail2->Subject = 'Personalizado | Nueva solicitud cotización';

					$mail2->Body =
					'Compañía: ' . $_POST['business'] . '<br>
					' . (($_POST['quote'] == 'hotel') ? 'Número de habitaciones: ' . $_POST['quantity'] . '<br>' : '') . '
					' . (($_POST['quote'] == 'restaurant') ? 'Número de mesas: ' . $_POST['quantity'] . '<br>' : '') . '
					Nombre de contacto: ' . $_POST['name'] . '<br>
					Correo electrónico de contacto: ' . $_POST['email'] . '<br>
					Teléfono de contacto: ' . $_POST['phone'];
					$mail2->send();
				}
				catch (Exception $e) {}

				Functions::environment([
					'status' => 'success',
					'message' => '{$lang.thanks_request_quote}'
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
			$template = $this->view->render($this, 'index');

			define('_title', 'Guestvox | {$lang.we_are_guestvox}');

			echo $template;
		}
	}
}
