<?php

defined('_EXEC') or die;

class Opportunityareas_controller extends Controller
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
			if ($_POST['action'] == 'get_opportunity_area')
			{
				$query = $this->model->get_opportunity_area($_POST['id']);

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

			if ($_POST['action'] == 'new_opportunity_area' OR $_POST['action'] == 'edit_opportunity_area')
			{
				$labels = [];

				if (!isset($_POST['name_es']) OR empty($_POST['name_es']))
					array_push($labels, ['name_es', '']);

				if (!isset($_POST['name_en']) OR empty($_POST['name_en']))
					array_push($labels, ['name_en', '']);

				if (empty($labels))
				{
					if ($_POST['action'] == 'new_opportunity_area')
						$query = $this->model->new_opportunity_area($_POST);
					else if ($_POST['action'] == 'edit_opportunity_area')
						$query = $this->model->edit_opportunity_area($_POST);

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

			if ($_POST['action'] == 'deactivate_opportunity_area' OR $_POST['action'] == 'activate_opportunity_area' OR $_POST['action'] == 'delete_opportunity_area')
			{
				if ($_POST['action'] == 'deactivate_opportunity_area')
					$query = $this->model->deactivate_opportunity_area($_POST['id']);
				else if ($_POST['action'] == 'activate_opportunity_area')
					$query = $this->model->activate_opportunity_area($_POST['id']);
				else if ($_POST['action'] == 'delete_opportunity_area')
					$query = $this->model->delete_opportunity_area($_POST['id']);

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

			define('_title', 'Guestvox | {$lang.opportunity_areas}');

			$tbl_opportunity_areas = '';

			foreach ($this->model->get_opportunity_areas() as $value)
			{
				$tbl_opportunity_areas .=
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
						' . ((Functions::check_user_access(['{opportunity_areas_deactivate}','{opportunity_areas_activate}']) == true) ? '<a data-action="' . (($value['status'] == true) ? 'deactivate_opportunity_area' : 'activate_opportunity_area') . '" data-id="' . $value['id'] . '">' . (($value['status'] == true) ? '<i class="fas fa-ban"></i>' : '<i class="fas fa-check"></i>') . '</a>' : '') . '
						' . ((Functions::check_user_access(['{opportunity_areas_update}']) == true) ? '<a class="edit" data-action="edit_opportunity_area" data-id="' . $value['id'] . '"><i class="fas fa-pen"></i></a>' : '') . '
						' . ((Functions::check_user_access(['{opportunity_areas_delete}']) == true) ? '<a class="delete" data-action="delete_opportunity_area" data-id="' . $value['id'] . '"><i class="fas fa-trash"></i></a>' : '') . '
					</div>
				</div>';
			}

			$replace = [
				'{$tbl_opportunity_areas}' => $tbl_opportunity_areas
			];

			$template = $this->format->replace($replace, $template);

			echo $template;
		}
	}
}
