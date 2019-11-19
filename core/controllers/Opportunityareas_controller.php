<?php

defined('_EXEC') or die;

class Opportunityareas_controller extends Controller
{
	public function __construct()
	{
		parent::__construct();
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
						'data' => $query,
					]);
				}
				else
				{
					Functions::environment([
						'status' => 'error',
						'message' => '{$lang.operation_error}',
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
							'message' => '{$lang.operation_success}',
						]);
					}
					else
					{
						Functions::environment([
							'status' => 'error',
							'message' => '{$lang.operation_error}',
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

			if ($_POST['action'] == 'delete_opportunity_area')
			{
				$query = $this->model->delete_opportunity_area($_POST['id']);

				if (!empty($query))
				{
					Functions::environment([
						'status' => 'success',
						'message' => '{$lang.operation_success}',
					]);
				}
				else
				{
					Functions::environment([
						'status' => 'error',
						'message' => '{$lang.operation_error}',
					]);
				}
			}
		}
		else
		{
			define('_title', 'GuestVox');

			$template = $this->view->render($this, 'index');

			$tbl_opportunity_areas = '';

			foreach ($this->model->get_opportunity_areas() as $value)
			{
				$tbl_opportunity_areas .=
				'<tr>
					<td align="left">' . $value['name'][Session::get_value('account')['language']] . '</td>
					<td align="left" class="flag">' . (($value['request'] == true) ? '<span><i class="fas fa-check"></i></span>' : '<span><i class="fas fa-times"></i></span>') . '</td>
					<td align="left" class="flag">' . (($value['incident'] == true) ? '<span><i class="fas fa-check"></i></span>' : '<span><i class="fas fa-times"></i></span>') . '</td>
					<td align="left" class="flag">' . (($value['public'] == true) ? '<span><i class="fas fa-check"></i></span>' : '<span><i class="fas fa-times"></i></span>') . '</td>
					' . ((Functions::check_user_access(['{opportunity_areas_delete}']) == true) ? '<td align="right" class="icon"><a data-action="delete_opportunity_area" data-id="' . $value['id'] . '" class="delete"><i class="fas fa-trash"></i></a></td>' : '') . '
					' . ((Functions::check_user_access(['{opportunity_areas_update}']) == true) ? '<td align="right" class="icon"><a data-action="edit_opportunity_area" data-id="' . $value['id'] . '" class="edit"><i class="fas fa-pen"></i></a></td>' : '') . '
				</tr>';
			}

			$replace = [
				'{$tbl_opportunity_areas}' => $tbl_opportunity_areas,
			];

			$template = $this->format->replace($replace, $template);

			echo $template;
		}
	}
}
