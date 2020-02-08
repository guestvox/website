<?php

defined('_EXEC') or die;

class Clients_controller extends Controller
{
	public function __construct()
	{
		parent::__construct();
	}

	public function index()
	{
        if (Format::exist_ajax_request() == true)
		{
			if ($_POST['action'] == 'get_client')
			{
				$query = $this->model->get_client($_POST['id']);

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

			if ($_POST['action'] == 'new_client' OR $_POST['action'] == 'edit_client')
			{
				$labels = [];

                if (!isset($_POST['name']) OR empty($_POST['name']))
					array_push($labels, ['name', '']);

				if (empty($labels))
				{
                    if ($_POST['action'] == 'new_client')
					    $query = $this->model->new_client($_POST);
                    else if ($_POST['action'] == 'edit_client')
                        $query = $this->model->edit_client($_POST);

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

			if ($_POST['action'] == 'delete_client')
			{
				$query = $this->model->delete_client($_POST['id']);

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

			$tbl_clients = '';

			foreach ($this->model->get_clients() as $value)
			{
				$tbl_clients .=
				'<tr>
					<td align="left">' . $value['token'] . '</td>
					<td align="left">' . $value['name'] . '</td>
					<td align="right" class="icon"><a href="{$path.uploads}' . $value['qr'] . '" download="' . $value['qr'] . '"><i class="fas fa-qrcode"></i></a></td>
					' . ((Functions::check_user_access(['{clients_delete}']) == true) ? '<td align="right" class="icon"><a data-action="delete_client" data-id="' . $value['id'] . '" class="delete"><i class="fas fa-trash"></i></a></td>' : '') . '
					' . ((Functions::check_user_access(['{clients_update}']) == true) ? '<td align="right" class="icon"><a data-action="edit_client" data-id="' . $value['id'] . '" class="edit"><i class="fas fa-pen"></i></a></td>' : '') . '
				</tr>';
			}

			$mdl_new_client = '';

			if (Functions::check_user_access(['{clients_create}']) == true)
			{
				$mdl_new_client .=
				'<section class="modal new" data-modal="new_client">
				    <div class="content">
				        <header>
				            <h3>{$lang.new}</h3>
				        </header>
				        <main>';

				if ($this->model->get_count_clients() < Session::get_value('account')['client_package']['quantity_end'])
				{
					$mdl_new_client .=
					'<form name="new_client">
		                <div class="row">
		                    <div class="span12">
		                        <div class="label">
		                            <label>
		                                <p>{$lang.name}</p>
		                                <input type="text" name="name" />
		                            </label>
		                        </div>
		                    </div>
		                </div>
		            </form>';
				}
				else
				{
					$mdl_new_client .=
					'<div class="maximum-exceeded">
						<i class="far fa-frown"></i>
						<p>{$lang.maximum_clients_exceeded}</p>
					</div>';
				}

				$mdl_new_client .=
				'        </main>
				        <footer>
				            <div class="action-buttons">
				                ' . (($this->model->get_count_clients() < Session::get_value('account')['client_package']['quantity_end']) ? '<button class="btn btn-flat" button-cancel>{$lang.cancel}</button>' : '') . '
				                ' . (($this->model->get_count_clients() < Session::get_value('account')['client_package']['quantity_end']) ? '<button class="btn" button-success>{$lang.accept}</button>' : '') . '
								' . (($this->model->get_count_clients() >= Session::get_value('account')['client_package']['quantity_end']) ? '<button class="btn btn-flat" button-close>{$lang.accept}</accept>' : '') . '
				            </div>
				        </footer>
				    </div>
				</section>';
			}

			$replace = [
				'{$tbl_clients}' => $tbl_clients,
				'{$mdl_new_client}' => $mdl_new_client
			];

			$template = $this->format->replace($replace, $template);

			echo $template;
		}
	}
}
