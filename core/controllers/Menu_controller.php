<?php

defined('_EXEC') or die;

class Menu_controller extends Controller
{
	private $lang;

	public function __construct()
	{
		parent::__construct();

		$this->lang = Session::get_value('account')['language'];
	}

	public function orders()
	{
        if (Format::exist_ajax_request() == true)
		{
			if ($_POST['action'] == 'view_map_menu_order')
			{
				$query = $this->model->get_menu_order($_POST['id'], 'map');

                if (!empty($query))
                {
					Functions::environment([
    					'status' => 'success',
    					'data' => $query
    				]);
                }
                else
                {
                    Functions::environment([
    					'status' => 'error',
    					'message' => '{$lang.operation_error}'
    				]);
                }
			}

			if ($_POST['action'] == 'decline_menu_order' OR $_POST['action'] == 'accept_menu_order' OR $_POST['action'] == 'deliver_menu_order')
			{
				$menu_order = $this->model->get_menu_order($_POST['id']);

				if (!empty($menu_order))
				{
					if ($_POST['action'] == 'decline_menu_order')
						$query = $this->model->decline_menu_order($_POST['id']);
					else if ($_POST['action'] == 'accept_menu_order')
						$query = $this->model->accept_menu_order($_POST['id']);
					else if ($_POST['action'] == 'deliver_menu_order')
						$query = $this->model->deliver_menu_order($_POST['id']);

					if (!empty($query))
					{
						if ($menu_order['type_service'] == 'delivery')
						{
							$mail = new Mailer(true);

							try
							{
								$mail->setFrom('noreply@guestvox.com', 'Guestvox');
								$mail->addAddress($menu_order['contact']['email'], $menu_order['contact']['firstname'] . ' ' . $menu_order['contact']['lastname']);
								$mail->Subject = Languages::email($_POST['action'])[$this->lang];
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
														<img style="width:100%;max-width:300px;" src="https://' . Configuration::$domain . '/uploads/' . Session::get_value('myvox')['account']['logotype'] . '">
													</figure>
												</td>
											</tr>
											<tr style="width:100%;margin:0px 0px 10px 0px;padding:0px;border:0px;">
												<td style="width:100%;margin:0px;padding:40px 20px;border:0px;box-sizing:border-box;background-color:#fff;">
													<h4 style="width:100%;margin:0px 0px 20px 0px;padding:0px;font-size:24px;font-weight:600;text-align:center;color:#212121;">' . $mail->Subject . '</h4>';

								if ($_POST['action'] == 'decline_menu_order')
									$mail->Body .= '<h6 style="width:100%;margin:0px;padding:0px;font-size:14px;font-weight:400;text-align:left;color:#757575;">' . Languages::email('decline_menu_order_error')[$this->lang] . '</h6>';
								else if ($_POST['action'] == 'accept_menu_order')
									$mail->Body .= '<h6 style="width:100%;margin:0px;padding:0px;font-size:14px;font-weight:400;text-align:left;color:#757575;">' . Languages::email('accept_menu_order_success')[$this->lang] . '</h6>';
								else if ($_POST['action'] == 'deliver_menu_order')
									$mail->Body .= '<h6 style="width:100%;margin:0px;padding:0px;font-size:14px;font-weight:400;text-align:left;color:#757575;">' . Languages::email('deliver_menu_order_success')[$this->lang] . '</h6>';

								$mail->Body .=
								'				</td>
											</tr>
											<tr style="width:100%;margin:0px;padding:0px;border:0px;">
												<td style="width:100%;margin:0px;padding:20px;border:0px;box-sizing:border-box;background-color:#fff;">
													<a style="width:100%;display:block;padding:20px 0px;box-sizing:border-box;font-size:14px;font-weight:400;text-align:center;text-decoration:none;color:#757575;" href="https://' . Configuration::$domain . '">Power by Guestvox</a>
												</td>
											</tr>
										</table>
									</body>
								</html>';
								$mail->send();
							}
							catch (Exception $e) { }

							$sms = $this->model->get_sms();

							if ($sms > 0)
							{
								$sms_basic  = new \Nexmo\Client\Credentials\Basic('45669cce', 'CR1Vg1bpkviV8Jzc');
								$sms_client = new \Nexmo\Client($sms_basic);
								$sms_text = Session::get_value('myvox')['account']['name'] . '. ' . Languages::email($_POST['action'])[$this->lang];

								if ($_POST['action'] == 'decline_menu_order')
									$sms_text .= Languages::email('decline_menu_order_error')[$this->lang];
								else if ($_POST['action'] == 'accept_menu_order')
									$sms_text .= Languages::email('accept_menu_order_success')[$this->lang];
								else if ($_POST['action'] == 'deliver_menu_order')
									$sms_text .= Languages::email('deliver_menu_order_success')[$this->lang];

								$sms_text = '. Power by Guestvox.';

								try
								{
									$sms_client->message()->send([
										'to' => $_POST['phone_lada'] . $_POST['phone_number'],
										'from' => 'Guestvox',
										'text' => $sms_text
									]);

									$sms = $sms - 1;
								}
								catch (Exception $e) { }

								$this->model->edit_sms($sms);
							}
						}

						Functions::environment([
							'status' => 'success',
							'message' => '{$lang.operation_success}'
						]);
					}
					else
					{
						Functions::environment([
							'status' => 'error',
							'message' => '{$lang.operation_error}'
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
			}

			// if ($_POST['action'] == 'filter_menu_orders')
			// {
			// 	$settings = Session::get_value('settings');
			//
			// 	$settings['menu']['orders']['filter']['type_service'] = $_POST['type_service'];
			// 	$settings['menu']['orders']['filter']['delivery'] = $_POST['delivery'];
			// 	$settings['menu']['orders']['filter']['accepted'] = $_POST['accepted'];
			// 	$settings['menu']['orders']['filter']['delivered'] = $_POST['delivered'];
			//
			// 	Session::set_value('settings', $settings);
			//
			// 	Functions::environment([
			// 		'status' => 'success'
			// 	]);
			// }
		}
		else
		{
			$template = $this->view->render($this, 'orders');

			define('_title', 'Guestvox | {$lang.menu_orders}');

			$menu_products = $this->model->get_menu_products();
			$menu_categories = $this->model->get_menu_categories('actives');

			$tbl_menu_orders = '';

			if (!empty($menu_products) AND !empty($menu_categories))
			{
				foreach ($this->model->get_menu_orders() as $value)
				{
					$tbl_menu_orders .=
					'<div>
						<div class="datas">
							<h2>' . $value['token'] . ' | ';

					if ($value['type_service'] == 'owner')
						$tbl_menu_orders .= $value['owner_name'] . (!empty($value['owner_number']) ? '#' . $value['owner_number'] : '');
					else if ($value['type_service'] == 'delivery')
						$tbl_menu_orders .= $value['contact']['firstname'] . ' ' . $value['contact']['lastname'] . ' | +' . $value['contact']['phone']['lada'] . ' ' . $value['contact']['phone']['number'] . ' | ' . $value['contact']['email'];

					$tbl_menu_orders .=
					'</h2>
					<p>' . Functions::get_formatted_date($value['date'], 'd/m/Y') . ' ' . Functions::get_formatted_hour($value['hour'], '+ hrs') . ' | {$lang.service_' . $value['type_service'] . '}' . (($value['type_service'] == 'delivery') ? ' | ' . (($value['delivery'] == 'bring') ? '{$lang.take_home}' : '{$lang.pick_up_restaurant}') : '') . '</p>
					<p>{$lang.total}: ' . '$ ' . $value['total'] . ' ' . $value['currency'] . ' | {$lang.payment_method}: {$lang.' . $value['payment_method'] . '} ' . (($value['payment_method'] == 'cash') ? '($ ' . $value['payment_cash'] . ' ' . $value['currency'] . ') | Cambio: $ ' . ($value['payment_cash'] - $value['total']) . ' ' . $value['currency'] : '') . '</p>';

					if ($value['type_service'] == 'delivery' AND $value['delivery'] == 'bring')
						$tbl_menu_orders .= '<p>' . $value['address'] . '</p>';

					foreach ($value['shopping_cart'] as $subvalue)
					{
						foreach ($subvalue as $intvalue)
						{
							$tbl_menu_orders .= '<p><strong>x' . $intvalue['quantity'] . ' ' . $intvalue['name'][$this->lang];

							if (!empty($intvalue['topics']))
							{
								$tbl_menu_orders .= ' (';

								foreach ($intvalue['topics'] as $parentvalue)
									$tbl_menu_orders .= $parentvalue['name'][$this->lang] . ', ';

								$tbl_menu_orders .= ')';
							}

							$tbl_menu_orders .= '</strong></p>';
						}
					}

					$tbl_menu_orders .=
					'</div>
					<div class="buttons flex_right">';

					if ($value['delivered'] == false)
					{
						if ($value['declined'] == false)
						{
							if ($value['type_service'] == 'delivery')
								$tbl_menu_orders .= '<a class="big" data-action="view_map_menu_order" data-id="' . $value['id'] . '"><i class="fas fa-map-marked-alt"></i><span>{$lang.view_map}</span></a>';

							$tbl_menu_orders .= '<a class="delete big" data-action="decline_menu_order" data-id="' . $value['id'] . '"><i class="fas fa-times"></i><span>{$lang.decline}</span></a>';

							if ($value['accepted'] == false)
								$tbl_menu_orders .= '<a class="edit big" data-action="accept_menu_order" data-id="' . $value['id'] . '"><i class="fas fa-check"></i><span>{$lang.accept}</span></a>';
							else if ($value['accepted'] == true)
								$tbl_menu_orders .= '<a class="new big" data-action="deliver_menu_order" data-id="' . $value['id'] . '"><i class="fas fa-check"></i><span>{$lang.deliver}</span></a>';
						}
						else if ($value['declined'] == true)
							$tbl_menu_orders .= '<a class="delete big"><i class="fas fa-times"></i><span>{$lang.order_declined}</span></a>';
					}
					else if ($value['delivered'] == true)
						$tbl_menu_orders .= '<a class="new big"><i class="fas fa-check"></i><span>{$lang.order_delivered}</span></a>';

					$tbl_menu_orders .=
					'	</div>
					</div>';
				}
			}
			else
			{
				$tbl_menu_orders .=
				'<div class="more_info_steps">
					<div>
						<i class="fas fa-tag"></i>
						<h4>{$lang.step_1}</h4>
						<p>' . (!empty($menu_categories) ? '{$lang.menu_products_description_step_1_1}' : '{$lang.menu_products_description_step_1_2}') . '</p>
						<a href="/menu/categories">' . (!empty($menu_categories) ? '{$lang.create_more_categories}' : '{$lang.create_categories}') . '</a>
					</div>
					<div>
						<i class="fas fa-bookmark"></i>
						<h4>{$lang.step_2} ({$lang.optional})</h4>
						<p>' . (!empty($menu_topics) ? '{$lang.menu_products_description_step_2_1}' : '{$lang.menu_products_description_step_2_2}') . '</p>
						<a href="/menu/topics">' . (!empty($menu_topics) ? '{$lang.create_more_topics}' : '{$lang.create_topics}') . '</a>
					</div>
					<div>
						<i class="fas fa-cocktail"></i>
						<h4>{$lang.step_3}</h4>
						<p>{$lang.menu_products_description_step_3_b}</p>
						<a href="/menu/products">{$lang.create_products}</a>
					</div>
				</div>';
			}

			$replace = [
				'{$tbl_menu_orders}' => $tbl_menu_orders
			];

			$template = $this->format->replace($replace, $template);

			echo $template;
		}
	}

	public function products()
	{
        if (Format::exist_ajax_request() == true)
		{
			if ($_POST['action'] == 'get_menu_product_position')
			{
				Functions::environment([
					'status' => 'success',
					'data' => $this->model->get_menu_product_position()
				]);
			}

			if ($_POST['action'] == 'add_menu_topics_group')
			{
				$labels = [];

				if (!isset($_POST['topics']) OR empty($_POST['topics']))
					array_push($labels, ['topics','']);

				if (!isset($_POST['selection']) OR empty($_POST['selection']))
					array_push($labels, ['selection','']);

				if (empty($labels))
				{
					$temporal = Session::get_value('temporal');

					foreach ($_POST['topics'] as $key => $value)
					{
						$_POST['topics'][$key] = [
							'id' => $value,
							'price' => '0',
							'selection' => $_POST['selection']
						];
					}

					array_push($temporal['menu_topics_groups'], $_POST['topics']);

					$html = '<div class="full_topics_groups">';

					foreach ($temporal['menu_topics_groups'] as $key => $value)
					{
						$html .= '<div>';

						foreach ($value as $subkey => $subvalue)
						{
							$subvalue['topic'] = $this->model->get_menu_topic($subvalue['id']);

							if (!empty($subvalue['topic']))
							{
								$html .=
								'<div>
									<p>' . $subvalue['topic']['name'][$this->lang] . '</p>
									<span>{$lang.' . $subvalue['selection'] . '}</span>
									<input type="text" name="update_menu_topic_price" value="' . $subvalue['price'] . '" data-key="' . $key . '" data-subkey="' . $subkey . '">
									<span>' . (!empty(Session::get_value('account')['settings']['menu']['currency']) ? Session::get_value('account')['settings']['menu']['currency'] : Session::get_value('account')['currency']) . '</span>
									<a data-action="remove_menu_topics_group" data-key="' . $key . '" data-subkey="' . $subkey . '"><i class="fas fa-times"></i></a>
								</div>';
							}
						}

						$html .= '</div>';
					}

					$html .= '</div>';

					Session::set_value('temporal', $temporal);

					Functions::environment([
						'status' => 'success',
						'html' => $html
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

			if ($_POST['action'] == 'remove_menu_topics_group')
			{
				$temporal = Session::get_value('temporal');

				unset($temporal['menu_topics_groups'][$_POST['key']][$_POST['subkey']]);

				if (empty($temporal['menu_topics_groups'][$_POST['key']]))
					unset($temporal['menu_topics_groups'][$_POST['key']]);

				$html = '';

				if (!empty($temporal['menu_topics_groups']))
				{
					$html .= '<div class="full_topics_groups">';

					foreach ($temporal['menu_topics_groups'] as $key => $value)
					{
						$html .= '<div>';

						foreach ($value as $subkey => $subvalue)
						{
							$subvalue['topic'] = $this->model->get_menu_topic($subvalue['id']);

							if (!empty($subvalue['topic']))
							{
								$html .=
								'<div>
									<p>' . $subvalue['topic']['name'][$this->lang] . '</p>
									<span>{$lang.' . $subvalue['selection'] . '}</span>
									<input type="text" name="update_menu_topic_price" value="' . $subvalue['price'] . '" data-key="' . $key . '" data-subkey="' . $subkey . '">
									<span>' . (!empty(Session::get_value('account')['settings']['menu']['currency']) ? Session::get_value('account')['settings']['menu']['currency'] : Session::get_value('account')['currency']) . '</span>
									<a data-action="remove_menu_topics_group" data-key="' . $key . '" data-subkey="' . $subkey . '"><i class="fas fa-times"></i></a>
								</div>';
							}
						}

						$html .= '</div>';
					}

					$html .= '</div>';
				}
				else
				{
					$html .=
					'<div class="empty_topics_groups">
						<p>{$lang.empty_topics_groups_1}</p>
						<div>
							<div>
								<i class="fas fa-hand-pointer"></i>
								<p>{$lang.empty_topics_groups_2}</p>
							</div>
							<div>
								<i class="far fa-check-square"></i>
								<p>{$lang.empty_topics_groups_3}</p>
							</div>
							<div>
								<i class="fas fa-plus"></i>
								<p>{$lang.empty_topics_groups_4}</p>
							</div>
						</div>
					</div>';
				}

				Session::set_value('temporal', $temporal);

				Functions::environment([
					'status' => 'success',
					'html' => $html
				]);
			}

			if ($_POST['action'] == 'update_menu_topic_price')
			{
				$temporal = Session::get_value('temporal');

				$temporal['menu_topics_groups'][$_POST['key']][$_POST['subkey']]['price'] = (!empty($_POST['price']) AND $_POST['price'] > 0) ? $_POST['price'] : 0;

				Session::set_value('temporal', $temporal);

				Functions::environment([
					'status' => 'success',
					'price' => (!empty($_POST['price']) AND $_POST['price'] > 0) ? $_POST['price'] : 0
				]);
			}

			if ($_POST['action'] == 'clear_menu_topics_groups')
			{
				$temporal = Session::get_value('temporal');

				$temporal['menu_topics_groups'] = [];

				Session::set_value('temporal', $temporal);

				$html =
				'<div class="empty_topics_groups">
					<p>{$lang.empty_topics_groups_1}</p>
					<div>
						<div>
							<i class="fas fa-hand-pointer"></i>
							<p>{$lang.empty_topics_groups_2}</p>
						</div>
						<div>
							<i class="far fa-check-square"></i>
							<p>{$lang.empty_topics_groups_3}</p>
						</div>
						<div>
							<i class="fas fa-plus"></i>
							<p>{$lang.empty_topics_groups_4}</p>
						</div>
					</div>
				</div>';

				Functions::environment([
					'status' => 'success',
					'html' => $html
				]);
			}

			if ($_POST['action'] == 'get_menu_product')
			{
				$query = $this->model->get_menu_product($_POST['id']);

                if (!empty($query))
                {
					$temporal = Session::get_value('temporal');

					$temporal['menu_topics_groups'] = $query['topics'];

					$query['topics'] = '';

					if (!empty($temporal['menu_topics_groups']))
					{
						$query['topics'] .= '<div class="full_topics_groups">';

						foreach ($temporal['menu_topics_groups'] as $key => $value)
						{
							$query['topics'] .= '<div>';

							foreach ($value as $subkey => $subvalue)
							{
								$subvalue['topic'] = $this->model->get_menu_topic($subvalue['id']);

								if (!empty($subvalue['topic']))
								{
									$query['topics'] .=
									'<div>
										<p>' . $subvalue['topic']['name'][$this->lang] . '</p>
										<span>{$lang.' . $subvalue['selection'] . '}</span>
										<input type="text" name="update_menu_topic_price" value="' . $subvalue['price'] . '" data-key="' . $key . '" data-subkey="' . $subkey . '">
										<span>' . (!empty(Session::get_value('account')['settings']['menu']['currency']) ? Session::get_value('account')['settings']['menu']['currency'] : Session::get_value('account')['currency']) . '</span>
										<a data-action="remove_menu_topics_group" data-key="' . $key . '" data-subkey="' . $subkey . '"><i class="fas fa-times"></i></a>
									</div>';
								}
							}

							$query['topics'] .= '</div>';
						}

						$query['topics'] .= '</div>';
					}
					else
					{
						$query['topics'] .=
						'<div class="empty_topics_groups">
							<p>{$lang.empty_topics_groups_1}</p>
							<div>
								<div>
									<i class="fas fa-hand-pointer"></i>
									<p>{$lang.empty_topics_groups_2}</p>
								</div>
								<div>
									<i class="far fa-check-square"></i>
									<p>{$lang.empty_topics_groups_3}</p>
								</div>
								<div>
									<i class="fas fa-plus"></i>
									<p>{$lang.empty_topics_groups_4}</p>
								</div>
							</div>
						</div>';
					}

					Session::set_value('temporal', $temporal);

                    Functions::environment([
    					'status' => 'success',
    					'data' => $query
    				]);
                }
                else
                {
                    Functions::environment([
    					'status' => 'error',
    					'message' => '{$lang.operation_error}'
    				]);
                }
			}

			if ($_POST['action'] == 'new_menu_product' OR $_POST['action'] == 'edit_menu_product')
			{
				$labels = [];

				if (!isset($_POST['name_es']) OR empty($_POST['name_es']))
					array_push($labels, ['name_es','']);

				if (!isset($_POST['name_en']) OR empty($_POST['name_en']))
					array_push($labels, ['name_en','']);

				if (!empty($_POST['description_es']) OR !empty($_POST['description_en']))
				{
					if (!isset($_POST['description_es']) OR empty($_POST['description_es']))
						array_push($labels, ['description_es','']);

					if (!isset($_POST['description_en']) OR empty($_POST['description_en']))
						array_push($labels, ['description_en','']);
				}

				if (!empty($_POST['price']) AND $_POST['price'] < 0)
					array_push($labels, ['price','']);

				if (!isset($_POST['position']) OR empty($_POST['position']) OR $_POST['position'] < 1)
					array_push($labels, ['position','']);

				if (!isset($_POST['available_days']) OR empty($_POST['available_days']))
					array_push($labels, ['available_days','']);

				if (!empty($_POST['available_end_date']) AND (!isset($_POST['available_start_date']) OR empty($_POST['available_start_date'])))
					array_push($labels, ['available_start_date','']);

				if (!empty($_POST['available_start_date']) AND (!isset($_POST['available_end_date']) OR empty($_POST['available_end_date'])))
					array_push($labels, ['available_end_date','']);

				if (!empty($_POST['available_start_date']) AND !empty($_POST['available_end_date']) AND $_POST['available_start_date'] >= $_POST['available_end_date'])
				{
					array_push($labels, ['available_start_date','']);
					array_push($labels, ['available_end_date','']);
				}

				if (!isset($_POST['avatar']) OR empty($_POST['avatar']))
					array_push($labels, ['avatar','']);

				if ($_POST['avatar'] == 'image' AND $_POST['action'] == 'new_menu_product')
				{
					if (!isset($_FILES['image']['name']) OR empty($_FILES['image']['name']))
						array_push($labels, ['image','']);
				}
				else if ($_POST['avatar'] == 'icon')
				{
					if (!isset($_POST['icon']) OR empty($_POST['icon']))
						array_push($labels, ['icon','']);
				}

				if (empty($labels))
				{
					if ($_POST['avatar'] == 'image')
						$_POST['image'] = $_FILES['image'];

					if ($_POST['action'] == 'new_menu_product')
						$query = $this->model->new_menu_product($_POST);
					else if ($_POST['action'] == 'edit_menu_product')
						$query = $this->model->edit_menu_product($_POST);

					if (!empty($query))
					{
						$temporal = Session::get_value('temporal');

						$temporal['menu_topics_groups'] = [];

						Session::set_value('temporal', $temporal);

						Functions::environment([
							'status' => 'success',
							'message' => '{$lang.operation_success}'
						]);
					}
					else
					{
						Functions::environment([
							'status' => 'error',
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

			if ($_POST['action'] == 'up_menu_product' OR $_POST['action'] == 'down_menu_product' OR $_POST['action'] == 'deactivate_menu_product' OR $_POST['action'] == 'activate_menu_product' OR $_POST['action'] == 'delete_menu_product')
			{
				if ($_POST['action'] == 'up_menu_product')
					$query = $this->model->up_menu_product($_POST['id']);
				else if ($_POST['action'] == 'down_menu_product')
					$query = $this->model->down_menu_product($_POST['id']);
				else if ($_POST['action'] == 'deactivate_menu_product')
					$query = $this->model->deactivate_menu_product($_POST['id']);
				else if ($_POST['action'] == 'activate_menu_product')
					$query = $this->model->activate_menu_product($_POST['id']);
				else if ($_POST['action'] == 'delete_menu_product')
					$query = $this->model->delete_menu_product($_POST['id']);

				if (!empty($query))
				{
					Functions::environment([
						'status' => 'success',
						'message' => '{$lang.operation_success}'
					]);
				}
				else
				{
					Functions::environment([
						'status' => 'error',
						'message' => '{$lang.operation_error}'
					]);
				}
			}
		}
		else
		{
			$template = $this->view->render($this, 'products');

			define('_title', 'Guestvox | {$lang.menu} | {$lang.products}');

			$menu_products = $this->model->get_menu_products();
			$menu_categories = $this->model->get_menu_categories('actives');
			$menu_topics = $this->model->get_menu_topics('actives');

			$tbl_menu_products = '';

			if (!empty($menu_products) AND !empty($menu_categories))
			{
				$tbl_menu_products .=
				'<div class="menu_preview">
		            <div class="phone">
		                <article>
		                    <header>
								<figure>
									<img src="{$path.uploads}' . Session::get_value('account')['logotype'] . '">
								</figure>
							</header>
		                    <main>
								<div class="categories">';

				foreach ($menu_categories as $value)
				{
					$tbl_menu_products .=
					'<div>
						<figure>
							<img src="{$path.images}icons/' . $value['icon_type'] . '/' . $value['icon_url'] . '">
							<a data-action="filter_menu_products_by_categories" data-id="' . $value['id'] . '"></a>
						</figure>
						<span>' . $value['name'][$this->lang] . '</span>
					</div>';
				}

				$tbl_menu_products .=
				'</div>
				<div class="products">';

				foreach ($this->model->get_menu_products('actives') as $value)
				{
					$tbl_menu_products .=
					'<div>
						<figure class="' . $value['avatar'] . '" ' . (($value['avatar'] == 'icon') ? 'style="background-color:' . $value['icon_color'] . ';"' : '') . '>';

					if ($value['avatar'] == 'image')
						$tbl_menu_products .= '<img src="{$path.uploads}' . $value['image'] . '">';
					else if ($value['avatar'] == 'icon')
						$tbl_menu_products .= '<img src="{$path.images}icons/' . $value['icon_type'] . '/' . $value['icon_url'] . '"></figure>';

					$tbl_menu_products .=
					'	</figure>
						<div>
							<h2>' . $value['name'][$this->lang] . '</h2>
							' . (!empty($value['price']) ? '<span>' . Functions::get_formatted_currency($value['price'], (!empty(Session::get_value('account')['settings']['menu']['currency']) ? Session::get_value('account')['settings']['menu']['currency'] : Session::get_value('account')['currency'])) . (!empty($value['topics']) ? ' (+ {$lang.topics})' : '') . '</span>' : '') . '
							<a data-action="open_preview_menu_product" data-id="' . $value['id'] . '"></a>
						</div>
					</div>';
				}

				$tbl_menu_products .=
				'	</div>
				</main>
                <footer>
					<div>
						<a href="" class="active"><i class="fas fa-igloo"></i><span>{$lang.home}</span></a>
						<a href=""><i class="fas fa-search"></i><span>{$lang.search}</span></a>
						<a href=""><i class="fas fa-shopping-cart"></i><span>$ 0.00 ' . (!empty(Session::get_value('account')['settings']['menu']['currency']) ? Session::get_value('account')['settings']['menu']['currency'] : Session::get_value('account')['currency']) . '</span></a>
					</div>
				</footer>';

				foreach ($this->model->get_menu_products('actives') as $value)
				{
					$tbl_menu_products .=
					'<div class="modal" data-id="' . $value['id'] . '">
						<figure class="' . $value['avatar'] . '" ' . (($value['avatar'] == 'icon') ? 'style="background-color:' . $value['icon_color'] . ';"' : '') . '>';

						if ($value['avatar'] == 'image')
							$tbl_menu_products .= '<img src="{$path.uploads}' . $value['image'] . '">';
						else if ($value['avatar'] == 'icon')
							$tbl_menu_products .= '<img src="{$path.images}icons/' . $value['icon_type'] . '/' . $value['icon_url'] . '">';

						$tbl_menu_products .=
						'</figure>
						<h2>' . $value['name'][$this->lang] . '</h2>
						<p>' . (!empty($value['description'][$this->lang]) ? $value['description'][$this->lang] : '') . '</p>
						' . (!empty($value['price']) ? '<span>' . Functions::get_formatted_currency($value['price'], (!empty(Session::get_value('account')['settings']['menu']['currency']) ? Session::get_value('account')['settings']['menu']['currency'] : Session::get_value('account')['currency'])) . (!empty($value['topics']) ? ' (+ {$lang.topics})' : '') . '</span>' : '') . '
						<form>';

						foreach ($value['topics'] as $subvalue)
						{
							$tbl_menu_products .= '<div>';

							foreach ($subvalue as $parentvalue)
							{
								$tbl_menu_products .=
								'<label>
									<input type="' . $parentvalue['selection'] . '" disabled>
									<p>' . $parentvalue['name'][$this->lang] . '</p>
									<span>' . (!empty($parentvalue['price']) ? Functions::get_formatted_currency($parentvalue['price'], (!empty(Session::get_value('account')['settings']['menu']['currency']) ? Session::get_value('account')['settings']['menu']['currency'] : Session::get_value('account')['currency'])) . ' +' : '') . '</span>
								</label>';
							}

							$tbl_menu_products .= '</div>';
						}

						$tbl_menu_products .=
						'	<div class="buttons">
								<a class="delete" data-action="close_preview_menu_product" data-id="' . $value['id'] . '"><i class="fas fa-times"></i></a>
								<a><i class="fas fa-minus"></i></a>
								<input type="text" value="1">
								<a><i class="fas fa-plus"></i></a>
								<a class="new" data-action="close_preview_menu_product" data-id="' . $value['id'] . '"><i class="fas fa-check"></i></a>
							</div>
						</form>
					</div>';
				}

				$tbl_menu_products .=
	            '    </article>
	            </div>
	            <div class="tbl_stl_3" data-table>';

				foreach ($menu_products as $value)
				{
					$tbl_menu_products .=
					'<div>
						<div class="datas">
							<div class="itm_1">
								<h2>' . $value['name'][$this->lang] .'</h2>
								<span>' . (!empty($value['price']) ? Functions::get_formatted_currency($value['price'], (!empty(Session::get_value('account')['settings']['menu']['currency']) ? Session::get_value('account')['settings']['menu']['currency'] : Session::get_value('account')['currency'])) . (!empty($value['topics']) ? ' (+ {$lang.topics})' : '') : '{$lang.not_price}') . '</span>';

					if (!empty($value['categories']))
					{
						$tbl_menu_products .= '<span>';

						foreach ($value['categories'] as $subkey => $subvalue)
							$tbl_menu_products .= $subvalue['name'][$this->lang] . ' ';

						$tbl_menu_products .= '</span>';
					}

					$tbl_menu_products .=
					((Session::get_value('account')['settings']['menu']['multi'] == true) ? '<span>' . (!empty($value['restaurant']) ? $value['restaurant'][$this->lang] : '{$lang.not_restaurant}') . '</span>' : '') . '
					</div>
					<div class="itm_2">
						<figure>';

					if ($value['avatar'] == 'image')
						$tbl_menu_products .= '<img src="{$path.uploads}' . $value['image'] . '">';
					else if ($value['avatar'] == 'icon')
						$tbl_menu_products .= '<img src="{$path.images}icons/' . $value['icon_type'] . '/' . $value['icon_url'] . '">';

					$tbl_menu_products .=
					'			</figure>
							</div>
						</div>
						<div class="buttons">
							' . ((Functions::check_user_access(['{menu_products_update}']) == true) ? '<a data-action="up_menu_product" data-id="' . $value['id'] . '"><i class="fas fa-arrow-circle-up"></i></a>' : '') . '
							' . ((Functions::check_user_access(['{menu_products_update}']) == true) ? '<a data-action="down_menu_product" data-id="' . $value['id'] . '"><i class="fas fa-arrow-circle-down"></i></a>' : '') . '
							' . ((Functions::check_user_access(['{menu_products_deactivate}','{menu_products_activate}']) == true) ? '<a class="big" data-action="' . (($value['status'] == true) ? 'deactivate_menu_product' : 'activate_menu_product') . '" data-id="' . $value['id'] . '">' . (($value['status'] == true) ? '<i class="fas fa-ban"></i><span>{$lang.deactivate}</span>' : '<i class="fas fa-check"></i><span>{$lang.activate}</span>') . '</a>' : '') . '
							' . ((Functions::check_user_access(['{menu_products_update}']) == true) ? '<a class="edit" data-action="edit_menu_product" data-id="' . $value['id'] . '"><i class="fas fa-pen"></i></a>' : '') . '
							' . ((Functions::check_user_access(['{menu_products_delete}']) == true) ? '<a class="delete" data-action="delete_menu_product" data-id="' . $value['id'] . '"><i class="fas fa-trash"></i></a>' : '') . '
						</div>
					</div>';
				}

				$tbl_menu_products .=
		        '    </div>
		        </div>';
			}
			else
			{
				$tbl_menu_products .=
				'<div class="more_info_steps">
					<div>
						<i class="fas fa-tag"></i>
						<h4>{$lang.step_1}</h4>
						<p>' . (!empty($menu_categories) ? '{$lang.menu_products_description_step_1_1}' : '{$lang.menu_products_description_step_1_2}') . '</p>
						<a href="/menu/categories">' . (!empty($menu_categories) ? '{$lang.create_more_categories}' : '{$lang.create_categories}') . '</a>
					</div>
					<div>
						<i class="fas fa-bookmark"></i>
						<h4>{$lang.step_2} ({$lang.optional})</h4>
						<p>' . (!empty($menu_topics) ? '{$lang.menu_products_description_step_2_1}' : '{$lang.menu_products_description_step_2_2}') . '</p>
						<a href="/menu/topics">' . (!empty($menu_topics) ? '{$lang.create_more_topics}' : '{$lang.create_topics}') . '</a>
					</div>
					<div>
						<i class="fas fa-cocktail"></i>
						<h4>{$lang.step_3}</h4>
						<p>{$lang.menu_products_description_step_3}</p>
					</div>
				</div>';
			}

			$sct_buttons = '';
			$cbx_menu_topics = '';
			$cbx_icons = '';
			$cbx_menu_categories = '';
			$opt_menu_restaurants = '';

			if (!empty($menu_categories))
			{
				$sct_buttons .=
				'<section class="buttons">
			        <div>
						' . ((Functions::check_user_access(['{menu_products_create}']) == true) ? '<a class="new" data-button-modal="new_menu_product"><i class="fas fa-plus"></i></a>' : '') . '
					</div>
			    </section>';

				if (!empty($menu_topics))
				{
					$cbx_menu_topics .= '<aside>';

					if (!empty(Session::get_value('temporal')['menu_topics_groups']))
					{
						$cbx_menu_topics .= '<div class="full_topics_groups">';

						foreach (Session::get_value('temporal')['menu_topics_groups'] as $key => $value)
						{
							$cbx_menu_topics .= '<div>';

							foreach ($value as $subkey => $subvalue)
							{
								$subvalue['topic'] = $this->model->get_menu_topic($subvalue['id']);

								if (!empty($subvalue['topic']))
								{
									$cbx_menu_topics .=
									'<div>
										<p>' . $subvalue['topic']['name'][$this->lang] . '</p>
										<span>{$lang.' . $subvalue['selection'] . '}</span>
										<input type="text" name="update_menu_topic_price" value="' . $subvalue['price'] . '" data-key="' . $key . '" data-subkey="' . $subkey . '">
										<span>' . (!empty(Session::get_value('account')['settings']['menu']['currency']) ? Session::get_value('account')['settings']['menu']['currency'] : Session::get_value('account')['currency']) . '</span>
										<a data-action="remove_menu_topics_group" data-key="' . $key . '" data-subkey="' . $subkey . '"><i class="fas fa-times"></i></a>
									</div>';
								}
							}

							$cbx_menu_topics .= '</div>';
						}

						$cbx_menu_topics .= '</div>';
					}
					else
					{
						$cbx_menu_topics .=
						'<div class="empty_topics_groups">
							<p>{$lang.empty_topics_groups_1}</p>
							<div>
								<div>
									<i class="fas fa-hand-pointer"></i>
									<p>{$lang.empty_topics_groups_2}</p>
								</div>
								<div>
									<i class="far fa-check-square"></i>
									<p>{$lang.empty_topics_groups_3}</p>
								</div>
								<div>
									<i class="fas fa-plus"></i>
									<p>{$lang.empty_topics_groups_4}</p>
								</div>
							</div>
						</div>';
					}

					$cbx_menu_topics .=
					'</aside>
					<div class="label">
						<label required>
							<select name="selection">
								<option value="checkbox">{$lang.multi_selection}</option>
								<option value="radio">{$lang.one_selection}</option>
							</select>
						</label>
					</div>
					<div class="checkboxes stl_1">
						<div>';

					foreach ($menu_topics as $value)
					{
						$cbx_menu_topics .=
						'<div>
							<input type="checkbox" name="topics[]" value="' . $value['id'] . '">
							<span>' . $value['name'][$this->lang] . '</span>
						</div>';
					}

					$cbx_menu_topics .=
					'		<div class="button">
								<a href="/menu/topics">{$lang.create_more_topics}</a>
							</div>
						</div>
					</div>
					<a data-action="add_menu_topics_group">{$lang.add}</a>';
				}
				else
				{
					$cbx_menu_topics .=
					'<div class="empty">
						<i class="fas fa-bookmark"></i>
						<p>{$lang.menu_products_description_step_4}</p>
						<a href="/menu/topics">{$lang.create_topics}</a>
					</div>';
				}

				foreach ($this->model->get_icons('menu') as $key => $value)
				{
					$cbx_icons .= '<div>';

					foreach ($value as $subvalue)
					{
						$cbx_icons .=
						'<label>
							<input type="radio" name="icon" value="' . $subvalue['id'] . '">
							<figure>
								<img src="{$path.images}icons/' . $subvalue['type'] . '/' . $subvalue['url'] . '">
							</figure>
							<p>' . $subvalue['name'][$this->lang] . '</p>
						</label>';
					}

					$cbx_icons .= '</div>';
				}

				foreach ($menu_categories as $value)
				{
					$cbx_menu_categories .=
					'<div>
						<input type="checkbox" name="categories[]" value="' . $value['id'] . '">
						<span>' . $value['name'][$this->lang] . '</span>
					</div>';
				}

				foreach ($this->model->get_menu_restaurants('actives') as $value)
					$opt_menu_restaurants .= '<option value="' . $value['id'] . '">' . $value['name'][$this->lang] . '</option>';
			}

			$opt_categories = '';

			foreach ($this->model->get_menu_categories() as $value)
				$opt_categories .= '<option value="' . $value['id'] . '" ' . ((Session::get_value('settings')['voxes']['opportunity_areas']['filter']['id'] == $value['id']) ? 'selected' : '') . '>' . $value['name'][$this->lang] . '</option>';

			$replace = [
				'{$tbl_menu_products}' => $tbl_menu_products,
				'{$sct_buttons}' => $sct_buttons,
				'{$cbx_menu_topics}' => $cbx_menu_topics,
				'{$cbx_icons}' => $cbx_icons,
				'{$cbx_menu_categories}' => $cbx_menu_categories,
				'{$opt_menu_restaurants}' => $opt_menu_restaurants,
				'{$opt_categories}' => $opt_categories
			];

			$template = $this->format->replace($replace, $template);

			echo $template;
		}
	}

	public function categories()
	{
        if (Format::exist_ajax_request() == true)
		{
			if ($_POST['action'] == 'get_menu_category_position')
			{
				Functions::environment([
					'status' => 'success',
					'data' => $this->model->get_menu_category_position()
				]);
			}

			if ($_POST['action'] == 'get_menu_category')
			{
				$query = $this->model->get_menu_category($_POST['id']);

                if (!empty($query))
                {
                    Functions::environment([
    					'status' => 'success',
    					'data' => $query
    				]);
                }
                else
                {
                    Functions::environment([
    					'status' => 'error',
    					'message' => '{$lang.operation_error}'
    				]);
                }
			}

			if ($_POST['action'] == 'new_menu_category' OR $_POST['action'] == 'edit_menu_category')
			{
				$labels = [];

				if (!isset($_POST['name_es']) OR empty($_POST['name_es']))
					array_push($labels, ['name_es','']);

				if (!isset($_POST['name_en']) OR empty($_POST['name_en']))
					array_push($labels, ['name_en','']);

				if (!isset($_POST['position']) OR empty($_POST['position']) OR $_POST['position'] < 1)
					array_push($labels, ['position','']);

				if (!isset($_POST['icon']) OR empty($_POST['icon']))
					array_push($labels, ['icon','']);

				if (empty($labels))
				{
					if ($_POST['action'] == 'new_menu_category')
						$query = $this->model->new_menu_category($_POST);
					else if ($_POST['action'] == 'edit_menu_category')
						$query = $this->model->edit_menu_category($_POST);

					if (!empty($query))
					{
						Functions::environment([
							'status' => 'success',
							'message' => '{$lang.operation_success}'
						]);
					}
					else
					{
						Functions::environment([
							'status' => 'error',
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

			if ($_POST['action'] == 'up_menu_category' OR $_POST['action'] == 'down_menu_category' OR $_POST['action'] == 'deactivate_menu_category' OR $_POST['action'] == 'activate_menu_category' OR $_POST['action'] == 'delete_menu_category')
			{
				if ($_POST['action'] == 'up_menu_category')
					$query = $this->model->up_menu_category($_POST['id']);
				else if ($_POST['action'] == 'down_menu_category')
					$query = $this->model->down_menu_category($_POST['id']);
				else if ($_POST['action'] == 'deactivate_menu_category')
					$query = $this->model->deactivate_menu_category($_POST['id']);
				else if ($_POST['action'] == 'activate_menu_category')
					$query = $this->model->activate_menu_category($_POST['id']);
				else if ($_POST['action'] == 'delete_menu_category')
					$query = $this->model->delete_menu_category($_POST['id']);

				if (!empty($query))
				{
					Functions::environment([
						'status' => 'success',
						'message' => '{$lang.operation_success}'
					]);
				}
				else
				{
					Functions::environment([
						'status' => 'error',
						'message' => '{$lang.operation_error}'
					]);
				}
			}
		}
		else
		{
			$template = $this->view->render($this, 'categories');

			define('_title', 'Guestvox | {$lang.menu} | {$lang.categories}');

			$menu_categories = $this->model->get_menu_categories();

			$tbl_menu_categories = '';

			if (!empty($menu_categories))
			{
				$tbl_menu_categories .= '<div class="tbl_stl_3" data-table>';

				foreach ($menu_categories as $value)
				{
					$tbl_menu_categories .=
					'<div>
						<div class="datas">
							<div class="itm_1">
								<h2>' . $value['name'][$this->lang] .'</h2>
							</div>
							<div class="itm_2">
								<figure>
									<img src="{$path.images}icons/' . $value['icon_type'] . '/' . $value['icon_url'] . '">
								</figure>
							</div>
						</div>
						<div class="buttons">
							' . ((Functions::check_user_access(['{menu_categories_update}']) == true) ? '<a data-action="up_menu_category" data-id="' . $value['id'] . '"><i class="fas fa-arrow-circle-up"></i></a>' : '') . '
							' . ((Functions::check_user_access(['{menu_categories_update}']) == true) ? '<a data-action="down_menu_category" data-id="' . $value['id'] . '"><i class="fas fa-arrow-circle-down"></i></a>' : '') . '
							' . ((Functions::check_user_access(['{menu_categories_deactivate}','{menu_categories_activate}']) == true) ? '<a class="big" data-action="' . (($value['status'] == true) ? 'deactivate_menu_category' : 'activate_menu_category') . '" data-id="' . $value['id'] . '">' . (($value['status'] == true) ? '<i class="fas fa-ban"></i><span>{$lang.deactivate}</span>' : '<i class="fas fa-check"></i><span>{$lang.activate}</span>') . '</a>' : '') . '
							' . ((Functions::check_user_access(['{menu_categories_update}']) == true) ? '<a class="edit" data-action="edit_menu_category" data-id="' . $value['id'] . '"><i class="fas fa-pen"></i></a>' : '') . '
							' . ((Functions::check_user_access(['{menu_categories_delete}']) == true) ? '<a class="delete" data-action="delete_menu_category" data-id="' . $value['id'] . '"><i class="fas fa-trash"></i></a>' : '') . '
						</div>
					</div>';
				}

		        $tbl_menu_categories .= '</div>';
			}
			else
			{
				$tbl_menu_categories .=
				'<div class="more_info">
					<i class="fas fa-tag"></i>
					<p>{$lang.menu_categories_description}</p>
				</div>';
			}

			$cbx_icons = '';

			foreach ($this->model->get_icons('menu') as $key => $value)
			{
				$cbx_icons .= '<div>';

				foreach ($value as $subvalue)
				{
					$cbx_icons .=
					'<label>
						<input type="radio" name="icon" value="' . $subvalue['id'] . '">
						<figure>
							<img src="{$path.images}icons/' . $subvalue['type'] . '/' . $subvalue['url'] . '">
						</figure>
						<p>' . $subvalue['name'][$this->lang] . '</p>
					</label>';
				}

				$cbx_icons .= '</div>';
			}

			$replace = [
				'{$tbl_menu_categories}' => $tbl_menu_categories,
				'{$cbx_icons}' => $cbx_icons
			];

			$template = $this->format->replace($replace, $template);

			echo $template;
		}
	}

	public function topics()
	{
        if (Format::exist_ajax_request() == true)
		{
			if ($_POST['action'] == 'get_menu_topic_position')
			{
				Functions::environment([
					'status' => 'success',
					'data' => $this->model->get_menu_topic_position()
				]);
			}

			if ($_POST['action'] == 'get_menu_topic')
			{
				$query = $this->model->get_menu_topic($_POST['id']);

                if (!empty($query))
                {
                    Functions::environment([
    					'status' => 'success',
    					'data' => $query
    				]);
                }
                else
                {
                    Functions::environment([
    					'status' => 'error',
    					'message' => '{$lang.operation_error}'
    				]);
                }
			}

			if ($_POST['action'] == 'new_menu_topic' OR $_POST['action'] == 'edit_menu_topic')
			{
				$labels = [];

				if (!isset($_POST['name_es']) OR empty($_POST['name_es']))
					array_push($labels, ['name_es','']);

				if (!isset($_POST['name_en']) OR empty($_POST['name_en']))
					array_push($labels, ['name_en','']);

				if (!isset($_POST['position']) OR empty($_POST['position']) OR $_POST['position'] < 1)
					array_push($labels, ['position','']);

				if (empty($labels))
				{
					if ($_POST['action'] == 'new_menu_topic')
						$query = $this->model->new_menu_topic($_POST);
					else if ($_POST['action'] == 'edit_menu_topic')
						$query = $this->model->edit_menu_topic($_POST);

					if (!empty($query))
					{
						Functions::environment([
							'status' => 'success',
							'message' => '{$lang.operation_success}'
						]);
					}
					else
					{
						Functions::environment([
							'status' => 'error',
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

			if ($_POST['action'] == 'up_menu_topic' OR $_POST['action'] == 'down_menu_topic' OR $_POST['action'] == 'deactivate_menu_topic' OR $_POST['action'] == 'activate_menu_topic' OR $_POST['action'] == 'delete_menu_topic')
			{
				if ($_POST['action'] == 'up_menu_topic')
					$query = $this->model->up_menu_topic($_POST['id']);
				else if ($_POST['action'] == 'down_menu_topic')
					$query = $this->model->down_menu_topic($_POST['id']);
				else if ($_POST['action'] == 'deactivate_menu_topic')
					$query = $this->model->deactivate_menu_topic($_POST['id']);
				else if ($_POST['action'] == 'activate_menu_topic')
					$query = $this->model->activate_menu_topic($_POST['id']);
				else if ($_POST['action'] == 'delete_menu_topic')
					$query = $this->model->delete_menu_topic($_POST['id']);

				if (!empty($query))
				{
					Functions::environment([
						'status' => 'success',
						'message' => '{$lang.operation_success}'
					]);
				}
				else
				{
					Functions::environment([
						'status' => 'error',
						'message' => '{$lang.operation_error}'
					]);
				}
			}
		}
		else
		{
			$template = $this->view->render($this, 'topics');

			define('_title', 'Guestvox | {$lang.menu} | {$lang.topics}');

			$menu_topics = $this->model->get_menu_topics();

			$tbl_menu_topics = '';

			if (!empty($menu_topics))
			{
				$tbl_menu_topics .= '<div class="tbl_stl_2" data-table>';

				foreach ($menu_topics as $value)
				{
					$tbl_menu_topics .=
					'<div>
						<div class="datas">
							<h2>' . $value['name'][$this->lang] . '</h2>
						</div>
						<div class="buttons flex_right">
							' . ((Functions::check_user_access(['{menu_topics_update}']) == true) ? '<a data-action="up_menu_topic" data-id="' . $value['id'] . '"><i class="fas fa-arrow-circle-up"></i></a>' : '') . '
							' . ((Functions::check_user_access(['{menu_topics_update}']) == true) ? '<a data-action="down_menu_topic" data-id="' . $value['id'] . '"><i class="fas fa-arrow-circle-down"></i></a>' : '') . '
							' . ((Functions::check_user_access(['{menu_topics_deactivate}','{menu_topics_activate}']) == true) ? '<a class="big" data-action="' . (($value['status'] == true) ? 'deactivate_menu_topic' : 'activate_menu_topic') . '" data-id="' . $value['id'] . '">' . (($value['status'] == true) ? '<i class="fas fa-ban"></i><span>{$lang.deactivate}</span>' : '<i class="fas fa-check"></i><span>{$lang.activate}</span>') . '</a>' : '') . '
							' . ((Functions::check_user_access(['{menu_topics_update}']) == true) ? '<a class="edit" data-action="edit_menu_topic" data-id="' . $value['id'] . '"><i class="fas fa-pen"></i></a>' : '') . '
							' . ((Functions::check_user_access(['{menu_topics_delete}']) == true) ? '<a class="delete" data-action="delete_menu_topic" data-id="' . $value['id'] . '"><i class="fas fa-trash"></i></a>' : '') . '
						</div>
					</div>';
				}

				$tbl_menu_topics .= '</div>';
			}
			else
			{
				$tbl_menu_topics .=
				'<div class="more_info">
					<i class="fas fa-bookmark"></i>
					<p>{$lang.menu_topics_description}</p>
				</div>';
			}

			$replace = [
				'{$tbl_menu_topics}' => $tbl_menu_topics
			];

			$template = $this->format->replace($replace, $template);

			echo $template;
		}
	}

	public function restaurants()
	{
        if (Format::exist_ajax_request() == true)
		{
			if ($_POST['action'] == 'get_menu_restaurant')
			{
				$query = $this->model->get_menu_restaurant($_POST['id']);

                if (!empty($query))
                {
                    Functions::environment([
    					'status' => 'success',
    					'data' => $query
    				]);
                }
                else
                {
                    Functions::environment([
    					'status' => 'error',
    					'message' => '{$lang.operation_error}'
    				]);
                }
			}

			if ($_POST['action'] == 'new_menu_restaurant' OR $_POST['action'] == 'edit_menu_restaurant')
			{
				$labels = [];

				if (!isset($_POST['name_es']) OR empty($_POST['name_es']))
					array_push($labels, ['name_es','']);

				if (!isset($_POST['name_en']) OR empty($_POST['name_en']))
					array_push($labels, ['name_en','']);

				if (empty($labels))
				{
					if ($_POST['action'] == 'new_menu_restaurant')
						$query = $this->model->new_menu_restaurant($_POST);
					else if ($_POST['action'] == 'edit_menu_restaurant')
						$query = $this->model->edit_menu_restaurant($_POST);

					if (!empty($query))
					{
						Functions::environment([
							'status' => 'success',
							'message' => '{$lang.operation_success}'
						]);
					}
					else
					{
						Functions::environment([
							'status' => 'error',
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

			if ($_POST['action'] == 'deactivate_menu_restaurant' OR $_POST['action'] == 'activate_menu_restaurant' OR $_POST['action'] == 'delete_menu_restaurant')
			{
				if ($_POST['action'] == 'deactivate_menu_restaurant')
					$query = $this->model->deactivate_menu_restaurant($_POST['id']);
				else if ($_POST['action'] == 'activate_menu_restaurant')
					$query = $this->model->activate_menu_restaurant($_POST['id']);
				else if ($_POST['action'] == 'delete_menu_restaurant')
					$query = $this->model->delete_menu_restaurant($_POST['id']);

				if (!empty($query))
				{
					Functions::environment([
						'status' => 'success',
						'message' => '{$lang.operation_success}'
					]);
				}
				else
				{
					Functions::environment([
						'status' => 'error',
						'message' => '{$lang.operation_error}'
					]);
				}
			}
		}
		else
		{
			$template = $this->view->render($this, 'restaurants');

			define('_title', 'Guestvox | {$lang.menu} | {$lang.restaurants}');

			$tbl_menu_restaurants = '';

			foreach ($this->model->get_menu_restaurants() as $value)
			{
				$tbl_menu_restaurants .=
				'<div>
					<div class="datas">
						<div class="itm_1">
							<h2>' . $value['name'][$this->lang] . '</h2>
							<span>' . $value['token'] . '</span>
						</div>
						<div class="itm_2">
							<figure>
								<a href="{$path.uploads}' . $value['qr'] . '" download="' . $value['qr'] . '"><img src="{$path.uploads}' . $value['qr'] . '"></a>
							</figure>
						</div>
					</div>
					<div class="buttons">
						' . ((Functions::check_user_access(['{menu_restaurants_deactivate}','{menu_restaurants_activate}']) == true) ? '<a class="big" data-action="' . (($value['status'] == true) ? 'deactivate_menu_restaurant' : 'activate_menu_restaurant') . '" data-id="' . $value['id'] . '">' . (($value['status'] == true) ? '<i class="fas fa-ban"></i><span>{$lang.deactivate}</span>' : '<i class="fas fa-check"></i><span>{$lang.activate}</span>') . '</a>' : '') . '
						' . ((Functions::check_user_access(['{menu_restaurants_update}']) == true) ? '<a class="edit" data-action="edit_menu_restaurant" data-id="' . $value['id'] . '"><i class="fas fa-pen"></i></a>' : '') . '
						' . ((Functions::check_user_access(['{menu_restaurants_delete}']) == true) ? '<a class="delete" data-action="delete_menu_restaurant" data-id="' . $value['id'] . '"><i class="fas fa-trash"></i></a>' : '') . '
					</div>
				</div>';
			}

			$replace = [
				'{$tbl_menu_restaurants}' => $tbl_menu_restaurants
			];

			$template = $this->format->replace($replace, $template);

			echo $template;
		}
	}
}
