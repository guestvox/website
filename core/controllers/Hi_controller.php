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
				if (!isset($_POST['rooms']) OR empty($_POST['rooms']))
					array_push($labels, ['rooms', '']);
			}
			else if ($_POST['type'] == 'restaurant')
			{
				if (!isset($_POST['tables']) OR empty($_POST['tables']))
					array_push($labels, ['tables', '']);
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
				$mail2 = new Mailer(true);

				try {
					$mail1->isSMTP();
					$mail1->setFrom($_POST['email'], $_POST['contact']);
					$mail1->addAddress('contacto@guestvox.com', 'GuestVox');
					$mail1->isHTML(true);
					$mail1->Subject = 'Solicitud de demo (Operación)';
					$mail1->Body =
					'Negocio: ' . $_POST['business'] .
					'Tipo: ' . $_POST['business'] .
					(($_POST['type'] == 'hotel') ? 'Habitaciones: ' . $_POST['rooms'] : '') .
					(($_POST['type'] == 'restaurant') ? 'Mesas: ' . $_POST['tables'] : '') .
					'Contacto: ' . $_POST['contact'] .
					'Correo electrónico: ' . $_POST['email'] .
					'Número telefonico: ' . $_POST['phone'];
					$mail1->AltBody = $mail1->Body;
					$mail1->send();
				} catch (Exception $e) {}

				try {
					$mail2->isSMTP();
					$mail2->setFrom('contacto@guestvox.com', 'GuestVox');
					$mail2->addAddress($_POST['email'], $_POST['contact']);
					$mail2->isHTML(true);
					$mail2->Subject = '¡Gracias! Hemos recibido tu petición';
					$mail2->Body = '¡Muchas gracias por ponerte en contacto con nosotros! En breve nos pondremos en contacto contigo.';
					$mail2->AltBody = $mail2->Body;
					$mail2->send();
				} catch (Exception $e) {}

				Functions::environment([
					'status' => 'success',
					'message' => '{$lang.operation_success}'
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
			define('_title', 'GuestVox | {$lang.we_are_guestvox}');

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
				if (!isset($_POST['rooms']) OR empty($_POST['rooms']))
					array_push($labels, ['rooms', '']);
			}
			else if ($_POST['type'] == 'restaurant')
			{
				if (!isset($_POST['tables']) OR empty($_POST['tables']))
					array_push($labels, ['tables', '']);
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
				$mail2 = new Mailer(true);

				try {
					$mail1->isSMTP();
					$mail1->setFrom($_POST['email'], $_POST['contact']);
					$mail1->addAddress('contacto@guestvox.com', 'GuestVox');
					$mail1->isHTML(true);
					$mail1->Subject = 'Solicitud de demo (Reputación)';
					$mail1->Body =
					'Negocio: ' . $_POST['business'] .
					'Tipo: ' . $_POST['business'] .
					(($_POST['type'] == 'hotel') ? 'Habitaciones: ' . $_POST['rooms'] : '') .
					(($_POST['type'] == 'restaurant') ? 'Mesas: ' . $_POST['tables'] : '') .
					'Contacto: ' . $_POST['contact'] .
					'Correo electrónico: ' . $_POST['email'] .
					'Número telefonico: ' . $_POST['phone'];
					$mail1->AltBody = $mail1->Body;
					$mail1->send();
				} catch (Exception $e) {}

				try {
					$mail2->isSMTP();
					$mail2->setFrom('contacto@guestvox.com', 'GuestVox');
					$mail2->addAddress($_POST['email'], $_POST['contact']);
					$mail2->isHTML(true);
					$mail2->Subject = '¡Gracias! Hemos recibido tu petición';
					$mail2->Body = '¡Muchas gracias por ponerte en contacto con nosotros! En breve nos pondremos en contacto contigo.';
					$mail2->AltBody = $mail2->Body;
					$mail2->send();
				} catch (Exception $e) {}

				Functions::environment([
					'status' => 'success',
					'message' => '{$lang.operation_success}'
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
			define('_title', 'GuestVox | {$lang.we_are_guestvox}');

			$template = $this->view->render($this, 'reputation');

			echo $template;
		}
	}
}
