<?php

defined('_EXEC') or die;

class Public_sites_controller extends Controller
{
	public function __construct()
	{
		parent::__construct();
	}

	public function hola()
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

			if ( isset($_POST['ref']) && !empty($_POST['ref']) && array_key_exists($_POST['ref'], $referrals) )
			{
				$ref = $referrals[$_POST['ref']];
			}

			$mail = new Mailer(true);

			try {
				$mail->isSMTP();
				$mail->setFrom('noreply@guestvox.com', 'GuestVox');
				$mail->addAddress('davidgomezmacias@gmail.com', 'David Gomez');
				$mail->isHTML(true);
				$mail->Subject = 'prueba';
				$mail->Body = 'mensaje de prueba';
				$mail->AltBody = '';
				$mail->send();
			} catch (Exception $e) { echo $e; }
		}
		else
		{
			define('_title', '');

			$template = $this->view->render($this, 'hola');

			$replace = [
			];

			$template = $this->format->replace($replace, $template);

			echo $template;
		}
	}
}
