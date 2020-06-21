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

	public function index()
	{
		$template = $this->view->render($this, 'index');

		define('_title', 'Guestvox | {$lang.menu}');

		if (Functions::check_user_access(['{menu_products_create}','{menu_products_update}','{menu_products_deactivate}','{menu_products_activate}','{menu_products_delete}']) == true)
			header('Location: /menu/products');
		else if (Functions::check_user_access(['{menu_restaurants_create}','{menu_restaurants_update}','{menu_restaurants_deactivate}','{menu_restaurants_activate}','{menu_restaurants_delete}']) == true)
			header('Location: /menu/restaurants');

		echo $template;
	}

	public function products()
	{
        if (Format::exist_ajax_request() == true)
		{
			if ($_POST['action'] == 'get_menu_product')
			{
				$query = $this->model->get_menu_product($_POST['id']);

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

			if ($_POST['action'] == 'new_menu_product' OR $_POST['action'] == 'edit_menu_product')
			{
				$labels = [];

				if (!isset($_POST['name_es']) OR empty($_POST['name_es']))
					array_push($labels, ['name_es','']);

				if (!isset($_POST['name_en']) OR empty($_POST['name_en']))
					array_push($labels, ['name_en','']);

				if (!isset($_POST['description_es']) OR empty($_POST['description_es']))
					array_push($labels, ['description_es','']);

				if (!isset($_POST['description_en']) OR empty($_POST['description_en']))
					array_push($labels, ['description_en','']);

				if (!isset($_POST['price']) OR empty($_POST['price']))
					array_push($labels, ['price','']);

				if (!isset($_FILES['avatar']['name']) OR empty($_FILES['avatar']['name']))
					array_push($labels, ['avatar','']);

				if (!isset($_POST['categories']) OR empty($_POST['categories']))
					array_push($labels, ['categories','']);

				if (Session::get_value('account')['settings']['menu']['multi'] == true)
				{
					if (!isset($_POST['restaurant']) OR empty($_POST['restaurant']))
						array_push($labels, ['restaurant','']);
				}

				if (empty($labels))
				{
					$_POST['avatar'] = $_FILES['avatar'];

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

			define('_title', 'Guestvox | {$lang.menu_products}');

			$tbl_menu_products = '';

			foreach ($this->model->get_menu_products() as $value)
			{
				$tbl_menu_products .=
				'<div>
					<div class="datas">
						<div class="itm_1">
							<h2>' . $value['name'][$this->lang] .'</h2>
							<span>' . $value['description'][$this->lang] . '</span>
							' . ((Session::get_value('account')['settings']['menu']['multi'] == true) ? '<span>' . (!empty($value['restaurant']) ? $value['restaurant'][$this->lang] : '{$lang.not_restaurant}') . '</span>' : '') . '
							<span>' . Functions::get_formatted_currency($value['price'], (!empty(Session::get_value('account')['settings']['menu']['currency']) ? Session::get_value('account')['settings']['menu']['currency'] : Session::get_value('account')['currency'])) . '</span>
						</div>
						<div class="itm_2">
							<figure>
								<img src="{$path.uploads}' . $value['avatar'] . '">
							</figure>
						</div>
					</div>
					<div class="buttons">
						' . ((Functions::check_user_access(['{menu_products_deactivate}','{menu_products_activate}']) == true) ? '<a data-action="' . (($value['status'] == true) ? 'deactivate_menu_product' : 'activate_menu_product') . '" data-id="' . $value['id'] . '">' . (($value['status'] == true) ? '<i class="fas fa-ban"></i>' : '<i class="fas fa-check"></i>') . '</a>' : '') . '
						' . ((Functions::check_user_access(['{menu_products_update}']) == true) ? '<a class="edit" data-action="edit_menu_product" data-id="' . $value['id'] . '"><i class="fas fa-pen"></i></a>' : '') . '
						' . ((Functions::check_user_access(['{menu_products_delete}']) == true) ? '<a class="delete" data-action="delete_menu_product" data-id="' . $value['id'] . '"><i class="fas fa-trash"></i></a>' : '') . '
					</div>
				</div>';
			}

			$cbx_menu_categories = '';

            foreach ($this->model->get_menu_categories() as $value)
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

			define('_title', 'Guestvox | {$lang.menu_restaurants}');

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
						' . ((Functions::check_user_access(['{menu_restaurants_deactivate}','{menu_restaurants_activate}']) == true) ? '<a data-action="' . (($value['status'] == true) ? 'deactivate_menu_restaurant' : 'activate_menu_restaurant') . '" data-id="' . $value['id'] . '">' . (($value['status'] == true) ? '<i class="fas fa-ban"></i>' : '<i class="fas fa-check"></i>') . '</a>' : '') . '
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
