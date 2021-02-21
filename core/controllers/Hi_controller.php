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

	public function hotels()
	{
		if (Format::exist_ajax_request() == true)
		{
			$labels = [];

			if (!isset($_POST['business']) OR empty($_POST['business']))
				array_push($labels, ['business','']);

			if (!isset($_POST['type']) OR empty($_POST['type']))
				array_push($labels, ['type','']);

			if ($_POST['type'] == 'hotel')
			{
				if (!isset($_POST['rooms']) OR empty($_POST['rooms']))
					array_push($labels, ['rooms','']);
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
					$mail1->Subject = Languages::email('thanks_request_demo')[$this->lang];
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
											<img style="width:100%;max-width:300px;" src="https://' . Configuration::$domain . '/images/hi/hotels/logotype_color.png">
										</figure>
									</td>
								</tr>
								<tr style="width:100%;margin:0px 0px 10px 0px;padding:0px;border:0px;">
									<td style="width:100%;margin:0px;padding:40px 20px;border:0px;box-sizing:border-box;background-color:#fff;">
										<h4 style="width:100%;margin:0px 0px 20px 0px;padding:0px;font-size:18px;font-weight:600;text-align:center;color:#212121;">' . $mail1->Subject . '</h4>
										<p style="width:100%;margin:0px;padding:0px;font-size:14px;font-weight:400;text-align:center;color:#757575;">' . Languages::email('representative_contact_you')[$this->lang] . '</p>
									</td>
								</tr>
								<tr style="width:100%;margin:0px;padding:0px;border:0px;">
									<td style="width:100%;margin:0px;padding:20px;border:0px;box-sizing:border-box;background-color:#fff;">
										<a style="width:100%;display:block;padding:20px 0px;box-sizing:border-box;font-size:14px;font-weight:400;text-align:center;text-decoration:none;color:#757575;" href="https://' . Configuration::$domain . '/hola/hoteles">' . Configuration::$domain . '/hola/hoteles</a>
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
					$mail2->Subject = 'Hoteles | Nueva solicitud de demo';
					$mail2->Body =
					'Compañía: ' . $_POST['business'] . '<br>
					Tipo: ' . Languages::email($_POST['type'])['es'] . '<br>
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
			$template = $this->view->render($this, 'hotels');

			define('_title', 'Guestvox | {$lang.hotels} | {$lang.we_are_guestvox}');

			echo $template;
		}
	}

	public function restaurants()
	{
		if (Session::exists_var('hi') == true)
		{
			$hi = Session::get_value('hi');

			if (!isset(Session::get_value('hi')['restaurant']['target']) OR empty(Session::get_value('hi')['restaurant']['target']))
				$hi['restaurant']['target'] = '1';

			if (!isset(Session::get_value('hi')['restaurant']['demo']) OR empty(Session::get_value('hi')['restaurant']['demo']))
			{
				$hi['restaurant']['demo'] = [
					'step' => '1',
					'name' => '',
					'logotype' => '',
					'topics' => [],
					'categories' => [],
					'products' => []
				];
			}

			Session::set_value('hi', $hi);
		}
		else
		{
			Session::set_value('hi', [
				'restaurant' => [
					'target' => '1',
					'demo' => [
						'step' => '1',
						'name' => '',
						'logotype' => '',
						'topics' => [],
						'categories' => [],
						'products' => []
					]
				]
			]);
		}

		if (Format::exist_ajax_request() == true)
		{
			if ($_POST['action'] == 'change_target')
			{
				$hi = Session::get_value('hi');

				$hi['restaurant']['target'] = $_POST['target'];

				Session::set_value('hi', $hi);

				Functions::environment([
					'status' => 'success'
				]);
			}

			if ($_POST['action'] == 'go_to_next_step')
			{
				$hi = Session::get_value('hi');

				if ($_POST['current_step'] == '1')
				{
					$labels = [];

					if (!isset($_POST['name']) OR empty($_POST['name']))
						array_push($labels, ['name','']);

					if (empty($labels))
					{
						$hi['restaurant']['demo']['step'] = $_POST['next_step'];

						Functions::environment([
							'status' => 'success'
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
				else if ($_POST['current_step'] == '2')
				{
					$labels = [];

					if (!isset($_FILES['logotype']['name']) OR empty($_FILES['logotype']['name']))
						array_push($labels, ['logotype','']);

					if (empty($labels))
					{
						$hi['restaurant']['demo']['step'] = $_POST['next_step'];

						Functions::environment([
							'status' => 'success'
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
					Functions::environment([
						'status' => 'error',
						'message' => '{$lang.operation_error}'
					]);
				}

				Session::set_value('hi', $hi);
			}

			if ($_POST['action'] == 'return_to_back_step')
			{
				$hi = Session::get_value('hi');

				$hi['restaurant']['demo']['step'] = $_POST['back_step'];

				Session::set_value('hi', $hi);

				Functions::environment([
					'status' => 'success'
				]);
			}
		}
		else
		{
			$template = $this->view->render($this, 'restaurants');

			define('_title', 'Guestvox | {$lang.restaurants} | {$lang.we_are_guestvox}');

			$lst_menu_categories = '';

			foreach ($this->model->get_menu_categories() as $value)
			{
				$lst_menu_categories .=
				'<div>
					<figure>
						<img src="{$path.images}icons/' . $value['icon_type'] . '/' . $value['icon_url'] . '">
					</figure>
					<span>' . $value['name'][$this->lang] . '</span>
				</div>';
			}

			$lst_menu_products = '';

			foreach ($this->model->get_menu_products() as $value)
			{
				$lst_menu_products .=
				'<div>
					<figure class="' . $value['avatar'] . '" ' . (($value['avatar'] == 'icon') ? 'style="background-color:' . $value['icon_color'] . ';"' : '') . '>';

				if ($value['avatar'] == 'image')
					$lst_menu_products .= '<img src="{$path.uploads}' . $value['image'] . '">';
				else if ($value['avatar'] == 'icon')
					$lst_menu_products .= '<img src="{$path.images}icons/' . $value['icon_type'] . '/' . $value['icon_url'] . '"></figure>';

				$lst_menu_products .=
				'	</figure>
					<div>
						<h2>' . $value['name'][$this->lang] . '</h2>
						' . (!empty($value['price']) ? '<span>' . Functions::get_formatted_currency($value['price'], 'MXN') . (!empty($value['topics']) ? ' (+ {$lang.topics})' : '') . '</span>' : '') . '
						<a data-action="open_menu_preview" data-id="' . $value['id'] . '"></a>
					</div>
				</div>';
			}

			$lst_menu_previews = '';

			foreach ($this->model->get_menu_products() as $value)
			{
				$lst_menu_previews .=
				'<div class="modal" data-id="' . $value['id'] . '">
					<figure class="' . $value['avatar'] . '" ' . (($value['avatar'] == 'icon') ? 'style="background-color:' . $value['icon_color'] . ';"' : '') . '>';

					if ($value['avatar'] == 'image')
						$lst_menu_previews .= '<img src="{$path.uploads}' . $value['image'] . '">';
					else if ($value['avatar'] == 'icon')
						$lst_menu_previews .= '<img src="{$path.images}icons/' . $value['icon_type'] . '/' . $value['icon_url'] . '">';

					$lst_menu_previews .=
					'</figure>
					<h2>' . $value['name'][$this->lang] . '</h2>
					<p>' . (!empty($value['description'][$this->lang]) ? $value['description'][$this->lang] : '') . '</p>
					' . (!empty($value['price']) ? '<span>' . Functions::get_formatted_currency($value['price'], 'MXN') . (!empty($value['topics']) ? ' (+ {$lang.topics})' : '') . '</span>' : '') . '
					<form>';

					foreach ($value['topics'] as $subvalue)
					{
						$lst_menu_previews .= '<div>';

						foreach ($subvalue as $parentvalue)
						{
							$lst_menu_previews .=
							'<label>
								<input type="' . $parentvalue['selection'] . '" disabled>
								<p>' . $parentvalue['name'][$this->lang] . '</p>
								<span>' . (!empty($parentvalue['price']) ? Functions::get_formatted_currency($parentvalue['price'], 'MXN') . ' +' : '') . '</span>
							</label>';
						}

						$lst_menu_previews .= '</div>';
					}

					$lst_menu_previews .=
					'	<div class="buttons">
							<a class="delete" data-action="close_menu_preview"><i class="fas fa-times"></i></a>
							<a><i class="fas fa-minus"></i></a>
							<input type="text" value="1">
							<a><i class="fas fa-plus"></i></a>
							<a class="new" data-action="close_menu_preview"><i class="fas fa-check"></i></a>
						</div>
					</form>
				</div>';
			}

			$replace = [
				'{$lst_menu_categories}' => $lst_menu_categories,
				'{$lst_menu_products}' => $lst_menu_products,
				'{$lst_menu_previews}' => $lst_menu_previews
			];

			$template = $this->format->replace($replace, $template);

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
				array_push($labels, ['name','']);

			if (!isset($_POST['email']) OR empty($_POST['email']) OR Functions::check_email($_POST['email']) == false)
				array_push($labels, ['email','']);

			if (!isset($_POST['business']) OR empty($_POST['business']))
				array_push($labels, ['business','']);

			if (!isset($_POST['job']) OR empty($_POST['job']))
				array_push($labels, ['job','']);

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
						$mail1->Subject = Languages::email('thanks_signup_webinar')[$this->lang];
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
												<img style="width:100%;max-width:300px;" src="https://' . Configuration::$domain . '/images/hi/webinar/logotype_color.png">
											</figure>
										</td>
									</tr>
									<tr style="width:100%;margin:0px;padding:0px;border:0px;">
										<td style="width:100%;margin:0px;padding:40px 20px;border:0px;box-sizing:border-box;background-color:#fff;">
											<h4 style="width:100%;margin:0px 0px 20px 0px;padding:0px;font-size:18px;font-weight:600;text-align:center;color:#212121;">' . $mail1->Subject . '</h4>
											<figure style="width:100%;margin:0px 0px 20px 0px;padding:0px;text-align:center;">
												<img style="width:100%;" src="https://' . Configuration::$domain . '/uploads/' . $webinar['image'] . '">
											</figure>
											<a style="width:100%;display:block;margin:0px;padding:20px 0px;border-radius:40px;box-sizing:border-box;background-color:#00a5ab;font-size:14px;font-weight:400;text-align:center;text-decoration:none;color:#fff;" href="' . $webinar['link'] . '">' . Languages::email('go_to_webinar')[$this->lang] . '</a>
										</td>
									</tr>
									<tr style="width:100%;margin:0px;padding:0px;border:0px;">
										<td style="width:100%;margin:0px;padding:20px;border:0px;box-sizing:border-box;background-color:#fff;">
											<a style="width:100%;display:block;padding:20px 0px;box-sizing:border-box;font-size:14px;font-weight:400;text-align:center;text-decoration:none;color:#757575;" href="https://' . Configuration::$domain . '/enlace">' . Configuration::$domain . '/enlace</a>
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

			define('_title', 'Guestvox | {$lang.link} | {$lang.we_are_guestvox}');

			$replace = [
				'{$image}' => '{$path.uploads}' . $webinar['image'],
				'{$date}' => Functions::get_formatted_date_hour($webinar['date'], $webinar['hour'])
			];

			$template = $this->format->replace($replace, $template);

			echo $template;
		}
	}
}
