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
			if ($_POST['action'] == 'get_menu_product')
			{
				if ($_POST['action'] == 'get_menu_product')
					$query = $this->model->get_menu_products($_POST['id']);

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
					array_push($labels, ['name_es', '']);

				if (!isset($_POST['name_en']) OR empty($_POST['name_en']))
					array_push($labels, ['name_en', '']);

				if (!isset($_POST['description_es']) OR empty($_POST['description_es']))
					array_push($labels, ['description_es', '']);

				if (!isset($_POST['description_en']) OR empty($_POST['description_en']))
					array_push($labels, ['description_en', '']);

				if (!isset($_POST['price']) OR empty($_POST['price']))
					array_push($labels, ['price', '']);

				if (!isset($_POST['categories']) OR empty($_POST['categories']))
					array_push($labels, ['categories', '']);

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

			define('_title', 'Guestvox | {$lang.menu}');

			$tbl_menu_products = '';

			foreach ($this->model->get_menu_products(null) as $value)
			{
				$tbl_menu_products .=
				'<div>
					<div class="datas">
						<div class="itm_1">
							<h2>' . $value['name'][$this->lang] .'</h2>
							<span>' . $value['description'][$this->lang] . '</span>
							<span>'  . Functions::get_formatted_currency((!empty($value['price']) ? $value['price'] : '0'), Session::get_value('account')['currency']) .  '</span>
						</div>
						<div class="itm_2">
							<figure>
								<img src="' . (!empty($value['avatar']) ? '{$path.uploads}' . $value['avatar'] : '{$path.images}empty.png') . '">
							</figure>
						</div>
					</div>
					<div class="buttons">
						' . ((Functions::check_user_access(['{menu_deactivate}','{menu_activate}']) == true) ? '<a data-action="' . (($value['status'] == true) ? 'deactivate_menu_product' : 'activate_menu_product') . '" data-id="' . $value['id'] . '">' . (($value['status'] == true) ? '<i class="fas fa-ban"></i>' : '<i class="fas fa-check"></i>') . '</a>' : '') . '
						' . ((Functions::check_user_access(['{menu_update}']) == true) ? '<a class="edit" data-action="edit_menu_product" data-id="' . $value['id'] . '"><i class="fas fa-pen"></i></a>' : '') . '
						' . ((Functions::check_user_access(['{menu_delete}']) == true) ? '<a class="delete" data-action="delete_menu_product" data-id="' . $value['id'] . '"><i class="fas fa-trash"></i></a>' : '') . '
					</div>
				</div>';
			}

			$cbx_categories =
            '<div>
				<div>';

            foreach ($this->model->get_menu_categories() as $key => $value)
            {
				$cbx_categories .=
				'<div>
						<input type="checkbox" name="categories[]" value="' . $value['id'] . '">
						<span>' . $value['name'][$this->lang] . '</span>
				</div>';
            }

			$cbx_categories .=
            '	</div>
			</div>';

			$replace = [
				'{$tbl_menu_products}' => $tbl_menu_products,
				'{$cbx_categories}' => $cbx_categories,
			];

			$template = $this->format->replace($replace, $template);

			echo $template;
		}
	}

	public function owners()
	{
        if (Format::exist_ajax_request() == true)
		{
			if ($_POST['action'] == 'get_menu_owner')
			{
				if ($_POST['action'] == 'get_menu_owner')
					$query = $this->model->get_menu_owners($_POST['id']);

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

			if ($_POST['action'] == 'new_menu_owner' OR $_POST['action'] == 'edit_menu_owner')
			{
				$labels = [];

				if (!isset($_POST['name_es']) OR empty($_POST['name_es']))
					array_push($labels, ['name_es', '']);

				if (!isset($_POST['name_en']) OR empty($_POST['name_en']))
					array_push($labels, ['name_en', '']);

				if (empty($labels))
				{
					if ($_POST['action'] == 'new_menu_owner')
						$query = $this->model->new_menu_owner($_POST);
					else if ($_POST['action'] == 'edit_menu_owner')
						$query = $this->model->edit_menu_owner($_POST);

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

			if ($_POST['action'] == 'deactivate_menu_owner' OR $_POST['action'] == 'activate_menu_owner' OR $_POST['action'] == 'delete_menu_owner')
			{
				if ($_POST['action'] == 'deactivate_menu_owner')
					$query = $this->model->deactivate_menu_owner($_POST['id']);
				else if ($_POST['action'] == 'activate_menu_owner')
					$query = $this->model->activate_menu_owner($_POST['id']);
				else if ($_POST['action'] == 'delete_menu_owner')
					$query = $this->model->delete_menu_owner($_POST['id']);

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
			$template = $this->view->render($this, 'owners');

			define('_title', 'Guestvox | {$lang.menu}');

			$tbl_menu_owners = '';

			foreach ($this->model->get_menu_owners() as $value)
			{
				$tbl_menu_owners .=
				'<div>
					<div class="datas">
						<div class="itm_1">
							<h2>' . $value['name'][$this->lang] .'</h2>
						</div>
						<div class="itm_2">
							<figure>
								<img src="' . (!empty($value['avatar']) ? '{$path.uploads}' . $value['avatar'] : '{$path.images}empty.png') . '">
							</figure>
						</div>
					</div>
					<div class="buttons">
						' . ((Functions::check_user_access(['{menu_owners_deactivate}','{menu_owners_activate}']) == true) ? '<a data-action="' . (($value['status'] == true) ? 'deactivate_menu_owner' : 'activate_menu_owner') . '" data-id="' . $value['id'] . '">' . (($value['status'] == true) ? '<i class="fas fa-ban"></i>' : '<i class="fas fa-check"></i>') . '</a>' : '') . '
						' . ((Functions::check_user_access(['{menu_owners_update}']) == true) ? '<a class="edit" data-action="edit_menu_owner" data-id="' . $value['id'] . '"><i class="fas fa-pen"></i></a>' : '') . '
						' . ((Functions::check_user_access(['{menu_owners_delete}']) == true) ? '<a class="delete" data-action="delete_menu_owner" data-id="' . $value['id'] . '"><i class="fas fa-trash"></i></a>' : '') . '
					</div>
				</div>';
			}

			$cbx_categories =
            '<div>
				<div>';

            foreach ($this->model->get_menu_categories() as $key => $value)
            {
				$cbx_categories .=
				'<div>
						<input type="checkbox" name="categories[]" value="' . $value['id'] . '">
						<span>' . $value['name'][$this->lang] . '</span>
				</div>';
            }

			$cbx_categories .=
            '	</div>
			</div>';

			$replace = [
				'{$tbl_menu_owners}' => $tbl_menu_owners,
				'{$cbx_categories}' => $cbx_categories,
			];

			$template = $this->format->replace($replace, $template);

			echo $template;
		}
	}
}
