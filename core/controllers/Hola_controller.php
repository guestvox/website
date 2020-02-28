<?php

defined('_EXEC') or die;

class Hola_controller extends Controller
{
	public function __construct()
	{
		parent::__construct();
	}

	public function index()
	{
		if (Format::exist_ajax_request() == true)
		{
			$referrals = [
				'6500' => [
					'name' => 'David Gómez',
					'email' => 'davidgomezmacias@gmail.com'
				],
				'6501' => [
					'name' => 'Alexa Zamora',
					'email' => 'alexa@guestvox.com'
				],
				'6502' => [
					'name' => 'Emilio Calderón',
					'email' => 'emilio_c@gmail.com'
				],
			];

			$post['name_contact'] = ( isset($_POST['name_contact']) && !empty($_POST['name_contact']) ) ? $_POST['name_contact'] : "";
			$post['name_hotel'] = ( isset($_POST['name_hotel']) && !empty($_POST['name_hotel']) ) ? $_POST['name_hotel'] : "";
			$post['number_rooms'] = ( isset($_POST['number_rooms']) && !empty($_POST['number_rooms']) ) ? $_POST['number_rooms'] : "";
			$post['email'] = ( isset($_POST['email']) && !empty($_POST['email']) ) ? $_POST['email'] : "";
			$post['phone'] = ( isset($_POST['phone']) && !empty($_POST['phone']) ) ? $_POST['phone'] : "";
			$post['ref'] = ( isset($_POST['ref']) && !empty($_POST['ref']) && array_key_exists($_POST['ref'], $referrals) ) ? $referrals[$_POST['ref']] : "6500";

			$labels = [];

			if (empty($post['name_contact']))
				array_push($labels, ['name_contact','']);

			if (empty($post['name_hotel']))
				array_push($labels, ['name_hotel','']);

			if (empty($post['number_rooms']))
				array_push($labels, ['number_rooms','']);

			if (empty($post['email']))
				array_push($labels, ['email','']);

			if ( empty($labels) )
			{
				$mail1 = new Mailer(true);
				$mail2 = new Mailer(true);
				$mail3 = new Mailer(true);

				try {
					// Administración
					$mail1->isSMTP();
					$mail1->setFrom('noreply@guestvox.com', 'GuestVox');
					$mail1->addAddress('info@guestvox.com', $post['name_contact']);
					$mail1->isHTML(true);
					$mail1->Subject = "Hola, me llamo {$post['name_contact']}, solicito ponerme en contacto con Guestvox.";
					$mail1->Body = "Hola, me llamo {$post['name_contact']}, solicito ponerme en contacto con Guestvox. Mi hotel es {$post['name_hotel']} y cuenta con {$post['number_rooms']} habitaciones. Pueden escribirme al correo electrónico {$post['email']} o llamarme a mi teléfono {$post['phone']}.";

					if ( !empty($post['ref']) )
						$mail1->Body .= "-- Referido de {$post['ref']['name']} --";

					$mail1->AltBody = $mail1->Body;
					$mail1->send();
				} catch (Exception $e) {}

				try {
					// Cliente
					$mail2->isSMTP();
					$mail2->setFrom('noreply@guestvox.com', 'GuestVox');
					$mail2->addAddress($post['email'], 'GuestVox');
					$mail2->isHTML(true);
					$mail2->Subject = "¡Gracias! Hemos recibido tu petición.";
					$mail2->Body = "¡Muchas gracias por ponerte en contacto con nosotros! En breve nos pondremos en contacto contigo.";
					$mail2->AltBody = $mail2->Body;
					$mail2->send();
				} catch (Exception $e) {}

				try {
					// Referido
					$mail3->isSMTP();
					$mail3->setFrom('noreply@guestvox.com', 'GuestVox');
					$mail3->addAddress($post['ref']['email'], $post['ref']['name']);
					$mail3->isHTML(true);
					$mail3->Subject = "Tienes un referido registrado.";
					$mail3->Body = "Hola {$post['ref']['name']}, tienes un referido ({$post['name_contact']}) registrado en GuestVox.";
					$mail3->AltBody = $mail3->Body;
					$mail3->send();
				} catch (Exception $e) {}

				echo json_encode([
					'status' => 'OK'
				]);
			}
			else
			{
				echo json_encode([
					'status' => 'error',
					'labels' => $labels
				]);
			}
		}
		else
		{
			define('_title', '');

			$template = $this->view->render($this, 'index');

			$replace = [
			];

			$template = $this->format->replace($replace, $template);

			echo $template;
		}
	}

	public function reputation()
	{
		define('_title', '');

		$template = $this->view->render($this, 'index');

		echo $template;
	}
}
