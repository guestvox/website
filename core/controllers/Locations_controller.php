<?php

defined('_EXEC') or die;

class Locations_controller extends Controller
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

			if ($_POST['action'] == 'get_location')
			{
				$query = $this->model->get_location($_POST['id']);

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

			if ($_POST['action'] == 'new_location' OR $_POST['action'] == 'edit_location')
			{
				$labels = [];

				if (!isset($_POST['name_es']) OR empty($_POST['name_es']))
					array_push($labels, ['name_es','']);

				if (!isset($_POST['name_en']) OR empty($_POST['name_en']))
					array_push($labels, ['name_en','']);

				if (empty($labels))
				{
					if ($_POST['action'] == 'new_location')
						$query = $this->model->new_location($_POST);
					else if ($_POST['action'] == 'edit_location')
						$query = $this->model->edit_location($_POST);

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

			if ($_POST['action'] == 'deactivate_location' OR $_POST['action'] == 'activate_location' OR $_POST['action'] == 'delete_location')
			{
				if ($_POST['action'] == 'deactivate_location')
					$query = $this->model->deactivate_location($_POST['id']);
				else if ($_POST['action'] == 'activate_location')
					$query = $this->model->activate_location($_POST['id']);
				else if ($_POST['action'] == 'delete_location')
					$query = $this->model->delete_location($_POST['id']);

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

			define('_title', 'Guestvox | {$lang.locations}');

			$tbl_locations = '';

			foreach ($this->model->get_locations() as $value)
			{
				$tbl_locations .=
				'<div>
					<div class="datas">
						<h2>' . $value['name'][$this->lang] . '</h2>
						<div class="checkers">
							<span><i class="fas fa-check-square ' . (($value['request'] == true) ? 'success' : '') . '"></i>{$lang.request}</span>
							<span><i class="fas fa-check-square ' . (($value['incident'] == true) ? 'success' : '') . '"></i>{$lang.incident}</span>
							<span><i class="fas fa-check-square ' . (($value['workorder'] == true) ? 'success' : '') . '"></i>{$lang.workorder}</span>
							<span><i class="fas fa-check-square ' . (($value['public'] == true) ? 'success' : '') . '"></i>{$lang.public}</span>
						</div>
					</div>
					<div class="buttons flex_right">
						' . ((Functions::check_user_access(['{locations_deactivate}','{locations_activate}']) == true) ? '<a class="big" data-action="' . (($value['status'] == true) ? 'deactivate_location' : 'activate_location') . '" data-id="' . $value['id'] . '">' . (($value['status'] == true) ? '<i class="fas fa-ban"></i><span>{$lang.deactivate}</span>' : '<i class="fas fa-check"></i><span>{$lang.activate}</span>') . '</a>' : '') . '
						' . ((Functions::check_user_access(['{locations_update}']) == true) ? '<a class="edit" data-action="edit_location" data-id="' . $value['id'] . '"><i class="fas fa-pen"></i></a>' : '') . '
						' . ((Functions::check_user_access(['{locations_delete}']) == true) ? '<a class="delete" data-action="delete_location" data-id="' . $value['id'] . '"><i class="fas fa-trash"></i></a>' : '') . '
					</div>
				</div>';
			}

			$replace = [
				'{$tbl_locations}' => $tbl_locations
			];

			$template = $this->format->replace($replace, $template);

			echo $template;
		}
	}
}
