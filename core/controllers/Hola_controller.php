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
					'name' => 'Emilio Calderón',
					'email' => 'emilio_c@ymail.com'
				],
				'6501' => [
					'name' => 'Alexa Zamora',
					'email' => 'alexa@guestvox.com'
				],
				'6502' => [
					'name' => 'David Gómez',
					'email' => 'davidgomezmacias@gmail.com'
				],
			];

			$post['name_contact'] = ( isset($_POST['name_contact']) && !empty($_POST['name_contact']) ) ? $_POST['name_contact'] : "";
			$post['name_hotel'] = ( isset($_POST['name_hotel']) && !empty($_POST['name_hotel']) ) ? $_POST['name_hotel'] : "";
			$post['number_rooms'] = ( isset($_POST['number_rooms']) && !empty($_POST['number_rooms']) ) ? $_POST['number_rooms'] : "";
			$post['email'] = ( isset($_POST['email']) && !empty($_POST['email']) ) ? $_POST['email'] : "";
			$post['phone'] = ( isset($_POST['phone']) && !empty($_POST['phone']) ) ? $_POST['phone'] : "";
			$post['ref'] = ( isset($_POST['ref']) && !empty($_POST['ref']) && array_key_exists($_POST['ref'], $referrals) ) ? $referrals[$_POST['ref']] : "";

			$mail = new Mailer(true);

			try {
				// Administración
				$mail->isSMTP();
				$mail->setFrom('noreply@guestvox.com', 'GuestVox');
				$mail->addAddress('info@guestvox.com', $post['name_contact']);
				$mail->isHTML(true);
				$mail->Subject = "Hola, me llamo {$post['name_contact']}, solicito ponerme en contacto con Guestvox.";
				$mail->Body = "Hola, me llamo {$post['name_contact']}, solicito ponerme en contacto con Guestvox. Mi hotel es {$post['name_hotel']} y cuenta con {$post['number_rooms']} habitaciones. Pueden escribirme al correo electrónico {$post['email']} o llamarme a mi teléfono {$post['phone']}.";

				if ( !empty($post['ref']) )
					$mail->Body .= "-- Referido de {$post['ref']['name']} --";

				$mail->AltBody = $mail->Body;
				$mail->send();

				// Cliente
				$mail->isSMTP();
				$mail->setFrom('noreply@guestvox.com', 'GuestVox');
				$mail->addAddress($post['email'], 'GuestVox');
				$mail->isHTML(true);
				$mail->Subject = "¡Gracias! Hemos recibido tu petición.";
				$mail->Body = "¡Muchas gracias por ponerte en contacto con nosotros! En breve nos pondremos en contacto contigo.";
				$mail->AltBody = $mail->Body;
				$mail->send();

				// Referido
				$mail->isSMTP();
				$mail->setFrom('noreply@guestvox.com', 'GuestVox');
				$mail->addAddress($post['ref']['email'], $post['ref']['name']);
				$mail->isHTML(true);
				$mail->Subject = "Tienes un referido registrado.";
				$mail->Body = "Hola {$post['ref']['name']}, tienes un referido ({$post['name_contact']}) registrado en GuestVox.";
				$mail->AltBody = $mail->Body;
				$mail->send();
			} catch (Exception $e) {}

			echo json_encode([
				'success' => 'OK'
			]);
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
}
