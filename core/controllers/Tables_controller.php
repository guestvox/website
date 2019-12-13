<?php

defined('_EXEC') or die;

class Tables_controller extends Controller
{
	public function __construct()
	{
		parent::__construct();
	}

	public function index()
	{
        if (Format::exist_ajax_request() == true)
		{
			if ($_POST['action'] == 'get_table')
			{
				$query = $this->model->get_table($_POST['id']);

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

			if ($_POST['action'] == 'new_table')
			{
				$labels = [];

				if (!isset($_POST['type']) OR empty($_POST['type']))
					array_push($labels, ['type', '']);

				if ($_POST['type'] == 'many')
				{
					if (!isset($_POST['since']) OR empty($_POST['since']))
						array_push($labels, ['since', '']);

					if (!isset($_POST['to']) OR empty($_POST['to']))
						array_push($labels, ['to', '']);
				}
				else if ($_POST['type'] == 'one')
				{
					if (!isset($_POST['number']) OR empty($_POST['number']))
						array_push($labels, ['number', '']);
				}

				if (empty($labels))
				{
					$query = $this->model->new_table($_POST);

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

			if ($_POST['action'] == 'edit_table')
			{
				$labels = [];

				if (!isset($_POST['number']) OR empty($_POST['number']))
					array_push($labels, ['number', '']);

				if (empty($labels))
				{
					$query = $this->model->edit_table($_POST);

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

			if ($_POST['action'] == 'delete_table')
			{
				$query = $this->model->delete_table($_POST['id']);

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
			define('_title', 'GuestVox');

			$template = $this->view->render($this, 'index');

			$tbl_tables = '';

			foreach ($this->model->get_tables() as $value)
			{
				$tbl_tables .=
				'<tr>
					<td align="left">' . $value['token'] . '</td>
					<td align="left">#' . $value['number'] . '</td>
					<td align="left">' . $value['name'] . '</td>
					<td align="right" class="icon"><a href="{$path.uploads}' . $value['qr'] . '" download="' . $value['qr'] . '"><i class="fas fa-qrcode"></i></a></td>
					' . ((Functions::check_user_access(['{tables_delete}']) == true) ? '<td align="right" class="icon"><a data-action="delete_table" data-id="' . $value['id'] . '" class="delete"><i class="fas fa-trash"></i></a></td>' : '') . '
					' . ((Functions::check_user_access(['{tables_update}']) == true) ? '<td align="right" class="icon"><a data-action="edit_table" data-id="' . $value['id'] . '" class="edit"><i class="fas fa-pen"></i></a></td>' : '') . '
				</tr>';
			}

			$replace = [
				'{$tbl_tables}' => $tbl_tables
			];

			$template = $this->format->replace($replace, $template);

			echo $template;
		}
	}
}
