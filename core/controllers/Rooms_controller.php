<?php

defined('_EXEC') or die;

class Rooms_controller extends Controller
{
	public function __construct()
	{
		parent::__construct();
	}

	public function index()
	{
        if (Format::exist_ajax_request() == true)
		{
			if ($_POST['action'] == 'get_room')
			{
				$query = $this->model->get_room($_POST['id']);

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

			if ($_POST['action'] == 'new_room')
			{
				$labels = [];

				if (!isset($_POST['type']) OR empty($_POST['type']))
					array_push($labels, ['type', '']);

				if ($_POST['type'] == 'many')
				{
					if (!isset($_POST['since']) OR empty($_POST['since']))
						array_push($labels, ['since', '']);
				}
				else if ($_POST['type'] == 'one')
				{
					if (!isset($_POST['name']) OR empty($_POST['name']))
						array_push($labels, ['name', '']);
				}

				if (empty($labels))
				{
					$query = $this->model->new_room($_POST);

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

			if ($_POST['action'] == 'download_rooms')
			{
				$rooms = Functions::api('zaviapms', Session::get_value('account')['zaviapms'], 'get', 'rooms');

				if (!empty($rooms))
				{
					foreach ($rooms as $value)
					{
						$this->model->new_room([
							'type' => 'one',
							'name' => $value['Number'],
							'folio' => $value['Number']
						]);
					}
				}

				Functions::environment([
					'status' => 'success',
					'message' => '{$lang.operation_success}'
				]);
			}

			if ($_POST['action'] == 'edit_room')
			{
				$labels = [];

				if (!isset($_POST['name']) OR empty($_POST['name']))
					array_push($labels, ['name', '']);

				if (empty($labels))
				{
					$query = $this->model->edit_room($_POST);

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

			if ($_POST['action'] == 'delete_room')
			{
				$query = $this->model->delete_room($_POST['id']);

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

			$tbl_rooms = '';

			foreach ($this->model->get_rooms() as $value)
			{
				$tbl_rooms .=
				'<tr>
					<td align="left">' . $value['token'] . '</td>
					<td align="left">' . $value['name'] . '</td>
					<td align="right" class="icon"><a href="{$path.uploads}' . $value['qr'] . '" download="' . $value['qr'] . '"><i class="fas fa-qrcode"></i></a></td>
					' . ((Functions::check_user_access(['{rooms_delete}']) == true) ? '<td align="right" class="icon"><a data-action="delete_room" data-id="' . $value['id'] . '" class="delete"><i class="fas fa-trash"></i></a></td>' : '') . '
					' . ((Functions::check_user_access(['{rooms_update}']) == true) ? '<td align="right" class="icon"><a data-action="edit_room" data-id="' . $value['id'] . '" class="edit"><i class="fas fa-pen"></i></a></td>' : '') . '
				</tr>';
			}

			$replace = [
				'{$tbl_rooms}' => $tbl_rooms,
			];

			$template = $this->format->replace($replace, $template);

			echo $template;
		}
	}
}
