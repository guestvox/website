<?php

defined('_EXEC') or die;

class Reservationstatuses_controller extends Controller
{
	public function __construct()
	{
		parent::__construct();
	}

	public function index()
	{
        if (Format::exist_ajax_request() == true)
		{
			if ($_POST['action'] == 'get_reservation_status')
			{
				$query = $this->model->get_reservation_status($_POST['id']);

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

			if ($_POST['action'] == 'new_reservation_status' OR $_POST['action'] == 'edit_reservation_status')
			{
				$labels = [];

				if (!isset($_POST['name']) OR empty($_POST['name']))
					array_push($labels, ['name', '']);

				if (empty($labels))
				{
					if ($_POST['action'] == 'new_reservation_status')
						$query = $this->model->new_reservation_status($_POST);
					else if ($_POST['action'] == 'edit_reservation_status')
						$query = $this->model->edit_reservation_status($_POST);

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

			if ($_POST['action'] == 'delete_reservation_status')
			{
				$query = $this->model->delete_reservation_status($_POST['id']);

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

			$tbl_reservation_statuses = '';

			foreach ($this->model->get_reservation_statuses() as $value)
			{
				$tbl_reservation_statuses .=
				'<tr>
					<td align="left">' . $value['name'] . '</td>
					' . ((Functions::check_user_access(['{reservation_statuses_delete}']) == true) ? '<td align="right" class="icon"><a data-action="delete_reservation_status" data-id="' . $value['id'] . '" class="delete"><i class="fas fa-trash"></i></a></td>' : '') . '
					' . ((Functions::check_user_access(['{reservation_statuses_update}']) == true) ? '<td align="right" class="icon"><a data-action="edit_reservation_status" data-id="' . $value['id'] . '" class="edit"><i class="fas fa-pencil-alt"></i></a></td>' : '') . '
				</tr>';
			}

			$replace = [
				'{$tbl_reservation_statuses}' => $tbl_reservation_statuses,
			];

			$template = $this->format->replace($replace, $template);

			echo $template;
		}
	}
}
