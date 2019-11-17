<?php

defined('_EXEC') or die;

class Guesttypes_controller extends Controller
{
	public function __construct()
	{
		parent::__construct();
	}

	public function index()
	{
        if (Format::exist_ajax_request() == true)
		{
			if ($_POST['action'] == 'get_guest_type')
			{
				$query = $this->model->get_guest_type($_POST['id']);

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

			if ($_POST['action'] == 'new_guest_type' OR $_POST['action'] == 'edit_guest_type')
			{
				$labels = [];

				if (!isset($_POST['name']) OR empty($_POST['name']))
					array_push($labels, ['name', '']);

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

			if ($_POST['action'] == 'delete_guest_type')
			{
				$query = $this->model->delete_guest_type($_POST['id']);

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

			$tbl_guest_types = '';

			foreach ($this->model->get_guest_types() as $value)
			{
				$tbl_guest_types .=
				'<tr>
					<td align="left">' . $value['name'] . '</td>
					' . ((Functions::check_user_access(['{guest_types_delete}']) == true) ? '<td align="right" class="icon"><a data-action="delete_guest_type" data-id="' . $value['id'] . '" class="delete"><i class="fas fa-trash"></i></a></td>' : '') . '
					' . ((Functions::check_user_access(['{guest_types_update}']) == true) ? '<td align="right" class="icon"><a data-action="edit_guest_type" data-id="' . $value['id'] . '" class="edit"><i class="fas fa-pencil-alt"></i></a></td>' : '') . '
				</tr>';
			}

			$replace = [
				'{$tbl_guest_types}' => $tbl_guest_types,
			];

			$template = $this->format->replace($replace, $template);

			echo $template;
		}
	}
}
