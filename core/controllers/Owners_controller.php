<?php

defined('_EXEC') or die;

class Owners_controller extends Controller
{
	public function __construct()
	{
		parent::__construct();
	}

	public function index()
	{
        if (Format::exist_ajax_request() == true)
		{
			if ($_POST['action'] == 'get_owner')
			{
				$query = $this->model->get_owner($_POST['id']);

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

			if ($_POST['action'] == 'new_owner')
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
					$query = $this->model->new_owner($_POST);

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

			if ($_POST['action'] == 'download_owners')
			{
				$owners = Functions::api('zaviapms', Session::get_value('account')['zaviapms'], 'get', 'owners');

				if (!empty($owners))
				{
					foreach ($owners as $value)
					{
						$this->model->new_owner([
							'type' => 'one',
							'number' => $value['Number'],
							'name' => ''
						]);
					}
				}

				Functions::environment([
					'status' => 'success',
					'message' => '{$lang.operation_success}'
				]);
			}

			if ($_POST['action'] == 'edit_owner')
			{
				$labels = [];

				if (!isset($_POST['number']) OR empty($_POST['number']))
					array_push($labels, ['number', '']);

				if (empty($labels))
				{
					$query = $this->model->edit_owner($_POST);

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

			if ($_POST['action'] == 'edit_department')
			{
				$labels = [];

				if (!isset($_POST['name']) OR empty($_POST['name']))
					array_push($labels, ['name', '']);

				if (empty($labels))
				{
					$query = $this->model->edit_owner($_POST);

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

			if ($_POST['action'] == 'delete_owner')
			{
				$query = $this->model->delete_owner($_POST['id']);

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

			$tbl_owners = '';

			foreach ($this->model->get_owners() as $value)
			{
				$tbl_owners .=
				'<tr>
					<td align="left">' . $value['token'] . '</td>
					<td align="left">' . (!empty($value['number']) ? '#' .  $value['number'] . '' : '') . '</td>
					<td align="left">' . $value['name'] . '</td>
					<td align="right" class="icon">' . (!empty($value['number']) ? '<a href="{$path.uploads}' . $value['qr'] . '" download="' . $value['qr'] . '"><i class="fas fa-qrcode"></i></a>' : '') . '</td>
					' . ((Functions::check_user_access(['{owners_delete}']) == true) ? '<td align="right" class="icon"><a data-action="delete_owner" data-id="' . $value['id'] . '" class="delete"><i class="fas fa-trash"></i></a></td>' : '') . '
					' . ((Functions::check_user_access(['{owners_update}']) == true) ? (($value['status'] == false) ? '<td align="right" class="icon"><a data-action="edit_owner" data-id="' . $value['id'] . '" class="edit"><i class="fas fa-pen"></i></a></td>' : '<td align="right" class="icon"><a data-action="edit_department" data-id="' . $value['id'] . '" class="edit"><i class="fas fa-pen"></i></a></td>') : '') . '
				</tr>';
			}

			$mdl_new_owner = '';

			if (Functions::check_user_access(['{owners_create}']) == true)
			{
				$mdl_new_owner .=
				'<section class="modal new" data-modal="new_owner">
				    <div class="content">
				        <header>
				            <h3>{$lang.new}</h3>
				        </header>
				        <main>';

				if ($this->model->get_count_owners() < Session::get_value('account')['owner_package']['quantity_end'])
				{
					$mdl_new_owner .=
					'<form name="new_owner">
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
		                        					<span>{$lang.many_owners}</span>
		                        				</div>
		                                        <div>
		                        					<input type="radio" name="type" value="one">
		                        					<span>{$lang.one_owner}</span>
		                        				</div>
		                                        <div>
		                        					<input type="radio" name="type" value="department">
		                        					<span>{$lang.department}</span>
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
					$mdl_new_owner .=
					'<div class="maximum-exceeded">
						<i class="far fa-frown"></i>
						<p>{$lang.maximum_owners_exceeded}</p>
					</div>';
				}

				$mdl_new_owner .=
				'        </main>
				        <footer>
				            <div class="action-buttons">
				                ' . (($this->model->get_count_owners() < Session::get_value('account')['owner_package']['quantity_end']) ? '<button class="btn btn-flat" button-cancel>{$lang.cancel}</button>' : '') . '
				                ' . (($this->model->get_count_owners() < Session::get_value('account')['owner_package']['quantity_end']) ? '<button class="btn" button-success>{$lang.accept}</button>' : '') . '
								' . (($this->model->get_count_owners() >= Session::get_value('account')['owner_package']['quantity_end']) ? '<button class="btn btn-flat" button-close>{$lang.accept}</accept>' : '') . '
				            </div>
				        </footer>
				    </div>
				</section>';
			}

			$mdl_download_owners = '';

			if (Functions::check_user_access(['{owners_create}']) == true AND Session::get_value('account')['zaviapms']['status'] == true)
			{
				$mdl_download_owners .=
				'<section class="modal" data-modal="download_owners">
				    <div class="content">
				        <header>
				            <h3>{$lang.download}</h3>
				        </header>';

				if ($this->model->get_count_owners() >= Session::get_value('account')['owner_package']['quantity_end'])
				{
					$mdl_download_owners .=
					'<main>
						<div class="maximum-exceeded">
							<i class="far fa-frown"></i>
							<p>{$lang.maximum_owners_exceeded}</p>
						</div>
					</main>';
				}

				$mdl_download_owners .=
				'        <footer>
				            <div class="action-buttons">
								' . (($this->model->get_count_owners() < Session::get_value('account')['owner_package']['quantity_end']) ? '<button class="btn btn-flat" button-close>{$lang.cancel}</button>' : '') . '
								' . (($this->model->get_count_owners() < Session::get_value('account')['owner_package']['quantity_end']) ? '<button class="btn" button-success>{$lang.accept}</button>' : '') . '
								' . (($this->model->get_count_owners() >= Session::get_value('account')['owner_package']['quantity_end']) ? '<button class="btn btn-flat" button-close>{$lang.accept}</accept>' : '') . '
				            </div>
				        </footer>
				    </div>
				</section>';
			}

			$replace = [
				'{$tbl_owners}' => $tbl_owners,
				'{$mdl_new_owner}' => $mdl_new_owner,
				'{$mdl_download_owners}' => $mdl_download_owners
			];

			$template = $this->format->replace($replace, $template);

			echo $template;
		}
	}
}
