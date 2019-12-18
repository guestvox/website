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

			$mdl_new_table = '';

			if (Functions::check_user_access(['{tables_create}']) == true)
			{
				$mdl_new_table .=
				'<section class="modal new" data-modal="new_table">
				    <div class="content">
				        <header>
				            <h3>{$lang.new}</h3>
				        </header>
				        <main>';

				if ($this->model->get_count_tables() < Session::get_value('account')['table_package']['quantity_end'])
				{
					$mdl_new_table .=
					'<form name="new_table">
		                <div class="row">
		                    <div class="span12">
		                        <div class="label">
		                            <label>
		                                <p>{$lang.type}</p>
		                            </label>
		                            <div class="checkboxes">
		                                <div>
		                    				<div>
		                                        <div>
		                        					<input type="radio" name="type" value="many" checked>
		                        					<span>{$lang.many_tables}</span>
		                        				</div>
		                                        <div>
		                        					<input type="radio" name="type" value="one">
		                        					<span>{$lang.one_table}</span>
		                        				</div>
		                                    </div>
		                    			</div>
		                            </div>
		                        </div>
		                    </div>
		                    <div class="span6">
		                        <div class="label">
		                            <label>
		                                <p>{$lang.since}</p>
		                                <input type="number" name="since" />
		                            </label>
		                        </div>
		                    </div>
		                    <div class="span6">
		                        <div class="label">
		                            <label>
		                                <p>{$lang.to}</p>
		                                <input type="number" name="to" />
		                            </label>
		                        </div>
		                    </div>
		                    <div class="span12 hidden">
		                        <div class="label">
		                            <label>
		                                <p>{$lang.number}</p>
		                                <input type="number" name="number" />
		                            </label>
		                        </div>
		                    </div>
		                    <div class="span12 hidden">
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
					$mdl_new_table .=
					'<div class="maximum-exceeded">
						<i class="far fa-frown"></i>
						<p>{$lang.maximum_tables_exceeded}</p>
					</div>';
				}

				$mdl_new_table .=
				'        </main>
				        <footer>
				            <div class="action-buttons">
				                ' . (($this->model->get_count_tables() < Session::get_value('account')['table_package']['quantity_end']) ? '<button class="btn btn-flat" button-cancel>{$lang.cancel}</button>' : '') . '
				                ' . (($this->model->get_count_tables() < Session::get_value('account')['table_package']['quantity_end']) ? '<button class="btn" button-success>{$lang.accept}</button>' : '') . '
								' . (($this->model->get_count_tables() >= Session::get_value('account')['table_package']['quantity_end']) ? '<button class="btn btn-flat" button-close>{$lang.accept}</accept>' : '') . '
				            </div>
				        </footer>
				    </div>
				</section>';
			}

			$replace = [
				'{$tbl_tables}' => $tbl_tables,
				'{$mdl_new_table}' => $mdl_new_table
			];

			$template = $this->format->replace($replace, $template);

			echo $template;
		}
	}
}
