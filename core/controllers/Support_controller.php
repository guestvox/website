<?php

defined('_EXEC') or die;

class Support_controller extends Controller
{
	private $lang;

	public function __construct()
	{
		parent::__construct();

		$this->lang = Session::get_value('account')['language'];
	}

	public function index()
	{
		if (Format::exist_ajax_request() == true)
		{
			if ($_POST['action'] == 'get_support')
			{
				$labels = [];

				if (!isset($_POST['message']) OR empty($_POST['message']))
					array_push($labels, ['message','']);

				if (empty($labels))
				{
					$mail = new Mailer(true);

					try
					{
						$mail->setFrom('noreply@guestvox.com', 'Guestvox');
						$mail->addAddress('soporte@guestvox.com', 'Guestvox');
						$mail->Subject = 'Soporte técnico | Nueva reporte';
						$mail->Body =
						'Cuenta: ' . Session::get_value('account')['name'] . ' (#' . Session::get_value('account')['token'] . ')<br>
						Usuario: ' . Session::get_value('user')['firstname'] . ' ' . Session::get_value('user')['lastname'] . ' (@' . Session::get_value('user')['username'] . ')<br>
						Mensaje: ' . $_POST['message'];
						$mail->send();
					}
					catch (Exception $e) { }

					Functions::environment([
						'status' => 'success',
						'message' => '{$lang.thanks_support}'
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
		else
		{
			$template = $this->view->render($this, 'index');

			define('_title', 'Guestvox | {$lang.technical_support}');

			echo $template;
		}
	}
}
