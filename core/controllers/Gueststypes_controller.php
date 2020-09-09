<?php

defined('_EXEC') or die;

class Gueststypes_controller extends Controller
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
			if ($_POST['action'] == 'translate')
			{
				$data = Functions::translate($_POST['name_es']);

				Functions::environment([
					'status' => 'success',
					'data' => $data
				]);
			}
			
			if ($_POST['action'] == 'get_guest_type')
			{
				$query = $this->model->get_guest_type($_POST['id']);

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

			if ($_POST['action'] == 'new_guest_type' OR $_POST['action'] == 'edit_guest_type')
			{
				$labels = [];

				if (!isset($_POST['name']) OR empty($_POST['name']))
					array_push($labels, ['name','']);

				if (empty($labels))
				{
					if ($_POST['action'] == 'new_guest_type')
						$query = $this->model->new_guest_type($_POST);
					else if ($_POST['action'] == 'edit_guest_type')
						$query = $this->model->edit_guest_type($_POST);

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

			if ($_POST['action'] == 'deactivate_guest_type' OR $_POST['action'] == 'activate_guest_type' OR $_POST['action'] == 'delete_guest_type')
			{
				if ($_POST['action'] == 'deactivate_guest_type')
					$query = $this->model->deactivate_guest_type($_POST['id']);
				else if ($_POST['action'] == 'activate_guest_type')
					$query = $this->model->activate_guest_type($_POST['id']);
				else if ($_POST['action'] == 'delete_guest_type')
					$query = $this->model->delete_guest_type($_POST['id']);

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
			$template = $this->view->render($this, 'index');

			define('_title', 'Guestvox | {$lang.guests_types}');

			$tbl_guests_types = '';

			foreach ($this->model->get_guests_types() as $value)
			{
				$tbl_guests_types .=
				'<div>
					<div class="datas">
						<h2>' . $value['name'] . '</h2>
					</div>
					<div class="buttons flex_right">
						' . ((Functions::check_user_access(['{guests_types_deactivate}','{guests_types_activate}']) == true) ? '<a class="big" data-action="' . (($value['status'] == true) ? 'deactivate_guest_type' : 'activate_guest_type') . '" data-id="' . $value['id'] . '">' . (($value['status'] == true) ? '<i class="fas fa-ban"></i><span>{$lang.deactivate}</span>' : '<i class="fas fa-check"></i><span>{$lang.activate}</span>') . '</a>' : '') . '
						' . ((Functions::check_user_access(['{guests_types_update}']) == true) ? '<a class="edit" data-action="edit_guest_type" data-id="' . $value['id'] . '"><i class="fas fa-pen"></i></a>' : '') . '
						' . ((Functions::check_user_access(['{guests_types_delete}']) == true) ? '<a class="delete" data-action="delete_guest_type" data-id="' . $value['id'] . '"><i class="fas fa-trash"></i></a>' : '') . '
					</div>
				</div>';
			}

			$replace = [
				'{$tbl_guests_types}' => $tbl_guests_types
			];

			$template = $this->format->replace($replace, $template);

			echo $template;
		}
	}
}
