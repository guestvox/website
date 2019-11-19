<?php

defined('_EXEC') or die;

class Locations_controller extends Controller
{
	public function __construct()
	{
		parent::__construct();
	}

	public function index()
	{
        if (Format::exist_ajax_request() == true)
		{
			if ($_POST['action'] == 'get_location')
			{
				$query = $this->model->get_location($_POST['id']);

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

			if ($_POST['action'] == 'new_location' OR $_POST['action'] == 'edit_location')
			{
				$labels = [];

				if (!isset($_POST['name_es']) OR empty($_POST['name_es']))
					array_push($labels, ['name_es', '']);

				if (!isset($_POST['name_en']) OR empty($_POST['name_en']))
					array_push($labels, ['name_en', '']);

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

			if ($_POST['action'] == 'delete_location')
			{
				$query = $this->model->delete_location($_POST['id']);

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

			$tbl_locations = '';

			foreach ($this->model->get_locations() as $value)
			{
				$tbl_locations .=
				'<tr>
					<td align="left">' . $value['name'][Session::get_value('account')['language']] . '</td>
					<td align="left" class="flag">' . (($value['request'] == true) ? '<span><i class="fas fa-check"></i></span>' : '<span><i class="fas fa-times"></i></span>') . '</td>
					<td align="left" class="flag">' . (($value['incident'] == true) ? '<span><i class="fas fa-check"></i></span>' : '<span><i class="fas fa-times"></i></span>') . '</td>
					<td align="left" class="flag">' . (($value['public'] == true) ? '<span><i class="fas fa-check"></i></span>' : '<span><i class="fas fa-times"></i></span>') . '</td>
					' . ((Functions::check_user_access(['{locations_delete}']) == true) ? '<td align="right" class="icon"><a data-action="delete_location" data-id="' . $value['id'] . '" class="delete"><i class="fas fa-trash"></i></a></td>' : '') . '
					' . ((Functions::check_user_access(['{locations_update}']) == true) ? '<td align="right" class="icon"><a data-action="edit_location" data-id="' . $value['id'] . '" class="edit"><i class="fas fa-pen"></i></a></td>' : '') . '
				</tr>';
			}

			$replace = [
				'{$tbl_locations}' => $tbl_locations,
			];

			$template = $this->format->replace($replace, $template);

			echo $template;
		}
	}
}
