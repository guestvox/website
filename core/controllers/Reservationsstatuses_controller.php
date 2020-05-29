<?php

defined('_EXEC') or die;

class Reservationsstatuses_controller extends Controller
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
			if ($_POST['action'] == 'get_reservation_status')
			{
				$query = $this->model->get_reservation_status($_POST['id']);

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

			if ($_POST['action'] == 'deactivate_reservation_status' OR $_POST['action'] == 'activate_reservation_status' OR $_POST['action'] == 'delete_reservation_status')
			{
				if ($_POST['action'] == 'deactivate_reservation_status')
					$query = $this->model->deactivate_reservation_status($_POST['id']);
				else if ($_POST['action'] == 'activate_reservation_status')
					$query = $this->model->activate_reservation_status($_POST['id']);
				else if ($_POST['action'] == 'delete_reservation_status')
					$query = $this->model->delete_reservation_status($_POST['id']);

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

			define('_title', 'Guestvox | {$lang.reservations_statuses}');

			$tbl_reservations_statuses = '';

			foreach ($this->model->get_reservations_statuses() as $value)
			{
				$tbl_reservations_statuses .=
				'<div>
					<div class="datas">
						<h2>' . $value['name'] . '</h2>
					</div>
					<div class="buttons flex_right">
						' . ((Functions::check_user_access(['{reservations_statuses_deactivate}','{reservations_statuses_activate}']) == true) ? '<a data-action="' . (($value['status'] == true) ? 'deactivate_reservation_status' : 'activate_reservation_status') . '" data-id="' . $value['id'] . '">' . (($value['status'] == true) ? '<i class="fas fa-ban"></i>' : '<i class="fas fa-check"></i>') . '</a>' : '') . '
						' . ((Functions::check_user_access(['{reservations_statuses_update}']) == true) ? '<a class="edit" data-action="edit_reservation_status" data-id="' . $value['id'] . '"><i class="fas fa-pen"></i></a>' : '') . '
						' . ((Functions::check_user_access(['{reservations_statuses_delete}']) == true) ? '<a class="delete" data-action="delete_reservation_status" data-id="' . $value['id'] . '"><i class="fas fa-trash"></i></a>' : '') . '
					</div>
				</div>';
			}

			$replace = [
				'{$tbl_reservations_statuses}' => $tbl_reservations_statuses
			];

			$template = $this->format->replace($replace, $template);

			echo $template;
		}
	}
}
