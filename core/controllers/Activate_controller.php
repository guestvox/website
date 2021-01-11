<?php

defined('_EXEC') or die;

class Activate_controller extends Controller
{
	private $lang;

	public function __construct()
	{
		parent::__construct();

		$this->lang = Session::get_value('lang');
	}

	public function index($params)
	{
		$template = $this->view->render($this, 'activate');

		define('_title', 'Guestvox | {$lang.activate_user}');

		$query = $this->model->activate_user($params[0]);

		$html = '';

		if (!empty($query))
		{
			if ($query['status'] == false)
			{
				$html = '{$lang.your_user_has_been_activated}';

				$mail = new Mailer(true);

				try
				{
					$mail->setFrom('daniel@guestvox.com', 'Daniel Basurto');
					$mail->addAddress($query['email'], $query['firstname'] . ' ' . $query['lastname']);
					$mail->Subject = Languages::email('activated_user_subject')[$query['language']];
					$mail->Body =
					'<html>
						<head>
							<title>' . $mail->Subject . '</title>
						</head>
						<body>
							<table style="width:600px;margin:0px;padding:20px;border:0px;box-sizing:border-box;background-color:#eee">
								<tr style="width:100%;margin:0px 0px 10px 0px;padding:0px;border:0px;">
									<td style="width:100%;margin:0px;padding:40px 20px;border:0px;box-sizing:border-box;background-color:#fff;">
										<figure style="width:100%;margin:0px;padding:0px;text-align:center;">
											<img style="width:100%;max-width:300px;" src="https://' . Configuration::$domain . '/images/logotype_color.png">
										</figure>
									</td>
								</tr>
								<tr style="width:100%;margin:0px 0px 10px 0px;padding:0px;border:0px;">
									<td style="width:100%;margin:0px;padding:40px 20px;border:0px;box-sizing:border-box;background-color:#fff;">
										<h4 style="width:100%;margin:0px 0px 20px 0px;padding:0px;font-size:18px;font-weight:600;text-align:center;color:#212121;">' . $mail->Subject . '</h4>
										<p style="width:100%;margin:0px 0px 20px 0px;padding:0px;font-size:14px;font-weight:400;text-align:center;color:#757575;">' . Languages::email('activated_user_text')[$query['language']] . '</p>
										<a style="width:100%;display:block;margin:0px;padding:20px 0px;border-radius:40px;box-sizing:border-box;background-color:#00a5ab;font-size:14px;font-weight:400;text-align:center;text-decoration:none;color:#fff;" href="https://' . Configuration::$domain . '/login">' . Languages::email('login')[$query['language']] . '</a>
									</td>
								</tr>
								<tr style="width:100%;margin:0px 0px 10px 0px;padding:0px;border:0px;">
									<td style="width:100%;margin:0px;padding:40px 20px;border:0px;box-sizing:border-box;background-color:#fff;">
										<figure style="width:100%;margin:0px;padding:40px 0px;border:0px;box-sizing:border-box;text-align:center;">
											<img style="width:150px;height:150px;border-radius:50%;" src="https://' . Configuration::$domain . '/images/index/stl_6_image_1.png">
											<span style="display:block;color:#757575;font-size:18px;">Daniel Basurto</span>
											<span style="display:block;color:#757575;font-size:18px;">CEO</span>
											<span style="display:block;color:#757575;font-size:18px;">daniel@guestvox.com</span>
											<span style="display:block;color:#757575;font-size:18px;">+52 (998) 845 28 43</span>
										</figure>
									</td>
								</tr>
								<tr style="width:100%;margin:0px;padding:0px;border:0px;">
									<td style="width:100%;margin:0px;padding:20px;border:0px;box-sizing:border-box;background-color:#fff;">
										<a style="width:100%;display:block;padding:20px 0px;box-sizing:border-box;font-size:14px;font-weight:400;text-align:center;text-decoration:none;color:#757575;" href="https://' . Configuration::$domain . '">' . Configuration::$domain . '</a>
									</td>
								</tr>
							</table>
						</body>
					</html>';
					$mail->send();
				}
				catch (Exception $e) { }
			}
			else
				$html = '{$lang.user_already_activated}';
		}
		else
			$html = '{$lang.error_to_activate}';

		$replace = [
			'{$html}' => $html
		];

		$template = $this->format->replace($replace, $template);

		echo $template;
	}
}
