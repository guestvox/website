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

	public function products()
	{
        if (Format::exist_ajax_request() == true)
		{
			if ($_POST['action'] == 'get_menu_products_outstandings')
			{
				Functions::environment([
					'status' => 'success',
					'data' => $this->model->get_menu_products_outstandings()
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

					$html = '';

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

				Session::set_value('temporal', $temporal);

				Functions::environment([
					'status' => 'success',
					'html' => $html
				]);
			}

			if ($_POST['action'] == 'update_menu_topic_price')
			{
				$temporal = Session::get_value('temporal');

				$temporal['menu_topics_groups'][$_POST['key']][$_POST['subkey']]['price'] = !empty($_POST['price']) ? $_POST['price'] : 0;

				Session::set_value('temporal', $temporal);

				Functions::environment([
					'status' => 'success',
					'price' => !empty($_POST['price']) ? $_POST['price'] : 0
				]);
			}

			if ($_POST['action'] == 'clear_menu_topics_groups')
			{
				$temporal = Session::get_value('temporal');

				$temporal['menu_topics_groups'] = [];

				Session::set_value('temporal', $temporal);

				Functions::environment([
					'status' => 'success'
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

				if (!isset($_POST['price']) OR empty($_POST['price']))
					array_push($labels, ['price','']);

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

			if ($_POST['action'] == 'deactivate_menu_product' OR $_POST['action'] == 'activate_menu_product' OR $_POST['action'] == 'delete_menu_product')
			{
				if ($_POST['action'] == 'deactivate_menu_product')
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

			$tbl_menu_products = '';

			foreach ($this->model->get_menu_products() as $value)
			{
				$tbl_menu_products .=
				'<div>
					<div class="datas">
						<div class="itm_1">
							<h2>' . $value['name'][$this->lang] .'</h2>
							<span>' . (!empty($value['description'][$this->lang]) ? $value['description'][$this->lang] : '{$lang.not_description}') . '</span>
							' . ((Session::get_value('account')['settings']['menu']['multi'] == true) ? '<span>' . (!empty($value['restaurant']) ? $value['restaurant'][$this->lang] : '{$lang.not_restaurant}') . '</span>' : '') . '
							<span>' . (!empty($value['outstanding']) ? '{$lang.outstanding}: ' . $value['outstanding'] : '{$lang.not_outstanding}') . '</span>
							<span>' . Functions::get_formatted_currency($value['price'], (!empty(Session::get_value('account')['settings']['menu']['currency']) ? Session::get_value('account')['settings']['menu']['currency'] : Session::get_value('account')['currency'])) . (!empty($value['topics']) ? ' (+ {$lang.topics})' : '') . '</span>
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
						' . ((Functions::check_user_access(['{menu_products_deactivate}','{menu_products_activate}']) == true) ? '<a class="big" data-action="' . (($value['status'] == true) ? 'deactivate_menu_product' : 'activate_menu_product') . '" data-id="' . $value['id'] . '">' . (($value['status'] == true) ? '<i class="fas fa-ban"></i><span>{$lang.deactivate}</span>' : '<i class="fas fa-check"></i><span>{$lang.activate}</span>') . '</a>' : '') . '
						' . ((Functions::check_user_access(['{menu_products_update}']) == true) ? '<a class="edit" data-action="edit_menu_product" data-id="' . $value['id'] . '"><i class="fas fa-pen"></i></a>' : '') . '
						' . ((Functions::check_user_access(['{menu_products_delete}']) == true) ? '<a class="delete" data-action="delete_menu_product" data-id="' . $value['id'] . '"><i class="fas fa-trash"></i></a>' : '') . '
					</div>
				</div>';
			}

			$cbx_menu_topics_groups = '';

			foreach (Session::get_value('temporal')['menu_topics_groups'] as $key => $value)
			{
				$cbx_menu_topics_groups .= '<div>';

				foreach ($value as $subkey => $subvalue)
				{
					$subvalue['topic'] = $this->model->get_menu_topic($subvalue['id']);

					if (!empty($subvalue['topic']))
					{
						$cbx_menu_topics_groups .=
						'<div>
							<p>' . $subvalue['topic']['name'][$this->lang] . '</p>
							<span>{$lang.' . $subvalue['selection'] . '}</span>
							<input type="text" name="update_menu_topic_price" value="' . $subvalue['price'] . '" data-key="' . $key . '" data-subkey="' . $subkey . '">
							<span>' . (!empty(Session::get_value('account')['settings']['menu']['currency']) ? Session::get_value('account')['settings']['menu']['currency'] : Session::get_value('account')['currency']) . '</span>
							<a data-action="remove_menu_topics_group" data-key="' . $key . '" data-subkey="' . $subkey . '"><i class="fas fa-times"></i></a>
						</div>';
					}
				}

				$cbx_menu_topics_groups .= '</div>';
			}

			$cbx_menu_topics = '';

            foreach ($this->model->get_menu_topics('actives') as $value)
            {
				$cbx_menu_topics .=
				'<div>
					<input type="checkbox" name="topics[]" value="' . $value['id'] . '">
					<span>' . $value['name'][$this->lang] . '</span>
				</div>';
            }

			$cbx_icons = '';

            foreach ($this->model->get_icons('menu') as $key => $value)
            {
				$cbx_icons .=
				'<p>{$lang.' . $key . '}</p>
				<div>';

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

			$cbx_menu_categories = '';

            foreach ($this->model->get_menu_categories('actives') as $value)
            {
				$cbx_menu_categories .=
				'<div>
					<input type="checkbox" name="categories[]" value="' . $value['id'] . '">
					<span>' . $value['name'][$this->lang] . '</span>
				</div>';
            }

			$opt_menu_restaurants = '';

            foreach ($this->model->get_menu_restaurants('actives') as $value)
				$opt_menu_restaurants .= '<option value="' . $value['id'] . '">' . $value['name'][$this->lang] . '</option>';

			$replace = [
				'{$tbl_menu_products}' => $tbl_menu_products,
				'{$cbx_menu_topics_groups}' => $cbx_menu_topics_groups,
				'{$cbx_menu_topics}' => $cbx_menu_topics,
				'{$cbx_icons}' => $cbx_icons,
				'{$cbx_menu_categories}' => $cbx_menu_categories,
				'{$opt_menu_restaurants}' => $opt_menu_restaurants
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

	public function categories()
	{
        if (Format::exist_ajax_request() == true)
		{
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

			if ($_POST['action'] == 'deactivate_menu_category' OR $_POST['action'] == 'activate_menu_category' OR $_POST['action'] == 'delete_menu_category')
			{
				if ($_POST['action'] == 'deactivate_menu_category')
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

			$tbl_menu_categories = '';

			foreach ($this->model->get_menu_categories() as $value)
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
						' . ((Functions::check_user_access(['{menu_categories_deactivate}','{menu_categories_activate}']) == true) ? '<a class="big" data-action="' . (($value['status'] == true) ? 'deactivate_menu_category' : 'activate_menu_category') . '" data-id="' . $value['id'] . '">' . (($value['status'] == true) ? '<i class="fas fa-ban"></i><span>{$lang.deactivate}</span>' : '<i class="fas fa-check"></i><span>{$lang.activate}</span>') . '</a>' : '') . '
						' . ((Functions::check_user_access(['{menu_categories_update}']) == true) ? '<a class="edit" data-action="edit_menu_category" data-id="' . $value['id'] . '"><i class="fas fa-pen"></i></a>' : '') . '
						' . ((Functions::check_user_access(['{menu_categories_delete}']) == true) ? '<a class="delete" data-action="delete_menu_category" data-id="' . $value['id'] . '"><i class="fas fa-trash"></i></a>' : '') . '
					</div>
				</div>';
			}

			$cbx_icons = '';

            foreach ($this->model->get_icons('menu') as $key => $value)
            {
				$cbx_icons .=
				'<p>{$lang.' . $key . '}</p>
				<div>';

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

			if ($_POST['action'] == 'deactivate_menu_topic' OR $_POST['action'] == 'activate_menu_topic' OR $_POST['action'] == 'delete_menu_topic')
			{
				if ($_POST['action'] == 'deactivate_menu_topic')
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

			$tbl_menu_topics = '';

			foreach ($this->model->get_menu_topics() as $value)
			{
				$tbl_menu_topics .=
				'<div>
					<div class="datas">
						<h2>' . $value['name'][$this->lang] . '</h2>
					</div>
					<div class="buttons flex_right">
						' . ((Functions::check_user_access(['{menu_topics_deactivate}','{menu_topics_activate}']) == true) ? '<a class="big" data-action="' . (($value['status'] == true) ? 'deactivate_menu_topic' : 'activate_menu_topic') . '" data-id="' . $value['id'] . '">' . (($value['status'] == true) ? '<i class="fas fa-ban"></i><span>{$lang.deactivate}</span>' : '<i class="fas fa-check"></i><span>{$lang.activate}</span>') . '</a>' : '') . '
						' . ((Functions::check_user_access(['{menu_topics_update}']) == true) ? '<a class="edit" data-action="edit_menu_topic" data-id="' . $value['id'] . '"><i class="fas fa-pen"></i></a>' : '') . '
						' . ((Functions::check_user_access(['{menu_topics_delete}']) == true) ? '<a class="delete" data-action="delete_menu_topic" data-id="' . $value['id'] . '"><i class="fas fa-trash"></i></a>' : '') . '
					</div>
				</div>';
			}

			$replace = [
				'{$tbl_menu_topics}' => $tbl_menu_topics
			];

			$template = $this->format->replace($replace, $template);

			echo $template;
		}
	}
}
