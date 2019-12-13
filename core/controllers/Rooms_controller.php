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

			if ($_POST['action'] == 'new_room')
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
					$query = $this->model->new_room($_POST);

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

			if ($_POST['action'] == 'download_rooms')
			{
				$rooms = Functions::api('zaviapms', Session::get_value('account')['zaviapms'], 'get', 'rooms');

				if (!empty($rooms))
				{
					foreach ($rooms as $value)
					{
						$this->model->new_room([
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

			if ($_POST['action'] == 'edit_room')
			{
				$labels = [];

				if (!isset($_POST['number']) OR empty($_POST['number']))
					array_push($labels, ['number', '']);

				if (empty($labels))
				{
					$query = $this->model->edit_room($_POST);

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

			if ($_POST['action'] == 'delete_room')
			{
				$query = $this->model->delete_room($_POST['id']);

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

			$tbl_rooms = '';

			foreach ($this->model->get_rooms() as $value)
			{
				$tbl_rooms .=
				'<tr>
					<td align="left">' . $value['token'] . '</td>
					<td align="left">#' . $value['number'] . '</td>
					<td align="left">' . $value['name'] . '</td>
					<td align="right" class="icon"><a href="{$path.uploads}' . $value['qr'] . '" download="' . $value['qr'] . '"><i class="fas fa-qrcode"></i></a></td>
					' . ((Functions::check_user_access(['{rooms_delete}']) == true) ? '<td align="right" class="icon"><a data-action="delete_room" data-id="' . $value['id'] . '" class="delete"><i class="fas fa-trash"></i></a></td>' : '') . '
					' . ((Functions::check_user_access(['{rooms_update}']) == true) ? '<td align="right" class="icon"><a data-action="edit_room" data-id="' . $value['id'] . '" class="edit"><i class="fas fa-pen"></i></a></td>' : '') . '
				</tr>';
			}

			$mdl_new_room = '';

			if (Functions::check_user_access(['{rooms_create}']) == true)
			{
				$mdl_new_room .=
				'<section class="modal new" data-modal="new_room">
				    <div class="content">
				        <header>
				            <h3>{$lang.new}</h3>
				        </header>
				        <main>';

				if ($this->model->get_count_rooms() < Session::get_value('account')['room_package']['quantity_end'])
				{
					$mdl_new_room .=
					'<form name="new_room">
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
		                        					<span>{$lang.many_rooms}</span>
		                        				</div>
		                                        <div>
		                        					<input type="radio" name="type" value="one">
		                        					<span>{$lang.one_room}</span>
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
					$mdl_new_room .=
					'<div class="maximum-exceeded">
						<i class="far fa-frown"></i>
						<p>{$lang.maximum_rooms_exceeded}</p>
					</div>';
				}

				$mdl_new_room .=
				'        </main>
				        <footer>
				            <div class="action-buttons">
				                ' . (($this->model->get_count_rooms() < Session::get_value('account')['room_package']['quantity_end']) ? '<button class="btn btn-flat" button-cancel>{$lang.cancel}</button>' : '') . '
				                ' . (($this->model->get_count_rooms() < Session::get_value('account')['room_package']['quantity_end']) ? '<button class="btn" button-success>{$lang.accept}</button>' : '') . '
								' . (($this->model->get_count_rooms() >= Session::get_value('account')['room_package']['quantity_end']) ? '<button class="btn btn-flat" button-close>{$lang.accept}</accept>' : '') . '
				            </div>
				        </footer>
				    </div>
				</section>';
			}

			$mdl_download_rooms = '';

			if (Functions::check_user_access(['{rooms_create}']) == true AND Session::get_value('account')['zaviapms']['status'] == true)
			{
				$mdl_download_rooms .=
				'<section class="modal" data-modal="download_rooms">
				    <div class="content">
				        <header>
				            <h3>{$lang.download}</h3>
				        </header>';

				if ($this->model->get_count_rooms() >= Session::get_value('account')['room_package']['quantity_end'])
				{
					$mdl_download_rooms .=
					'<main>
						<div class="maximum-exceeded">
							<i class="far fa-frown"></i>
							<p>{$lang.maximum_rooms_exceeded}</p>
						</div>
					</main>';
				}

				$mdl_download_rooms .=
				'        <footer>
				            <div class="action-buttons">
								' . (($this->model->get_count_rooms() < Session::get_value('account')['room_package']['quantity_end']) ? '<button class="btn btn-flat" button-close>{$lang.cancel}</button>' : '') . '
								' . (($this->model->get_count_rooms() < Session::get_value('account')['room_package']['quantity_end']) ? '<button class="btn" button-success>{$lang.accept}</button>' : '') . '
								' . (($this->model->get_count_rooms() >= Session::get_value('account')['room_package']['quantity_end']) ? '<button class="btn btn-flat" button-close>{$lang.accept}</accept>' : '') . '
				            </div>
				        </footer>
				    </div>
				</section>';
			}

			$replace = [
				'{$tbl_rooms}' => $tbl_rooms,
				'{$mdl_new_room}' => $mdl_new_room,
				'{$mdl_download_rooms}' => $mdl_download_rooms
			];

			$template = $this->format->replace($replace, $template);

			echo $template;
		}
	}
}
