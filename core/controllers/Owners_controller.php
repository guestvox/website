<?php

defined('_EXEC') or die;

class Owners_controller extends Controller
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

			if ($_POST['action'] == 'new_owner' OR $_POST['action'] == 'edit_owner')
			{
				$labels = [];

				if ($_POST['action'] == 'new_owner')
				{
					if (!isset($_POST['type']) OR empty($_POST['type']))
						array_push($labels, ['type','']);

					if ($_POST['type'] == 'one')
					{
						if (!isset($_POST['name_es']) OR empty($_POST['name_es']))
							array_push($labels, ['name_es','']);

						if (!isset($_POST['name_en']) OR empty($_POST['name_en']))
							array_push($labels, ['name_en','']);
					}
					else if ($_POST['type'] == 'many')
					{
						if (!isset($_POST['since']) OR empty($_POST['since']))
							array_push($labels, ['since','']);

						if (!isset($_POST['to']) OR empty($_POST['to']))
							array_push($labels, ['to','']);
					}
				}
				else if ($_POST['action'] == 'edit_owner')
				{
					if (!isset($_POST['name_es']) OR empty($_POST['name_es']))
						array_push($labels, ['name_es','']);

					if (!isset($_POST['name_en']) OR empty($_POST['name_en']))
						array_push($labels, ['name_en','']);
				}

				if (empty($labels))
				{
					if ($_POST['action'] == 'new_owner')
						$query = $this->model->new_owner($_POST);
					else if ($_POST['action'] == 'edit_owner')
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

			if ($_POST['action'] == 'deactivate_owner' OR $_POST['action'] == 'activate_owner' OR $_POST['action'] == 'delete_owner')
			{
				if ($_POST['action'] == 'deactivate_owner')
					$query = $this->model->deactivate_owner($_POST['id']);
				else if ($_POST['action'] == 'activate_owner')
					$query = $this->model->activate_owner($_POST['id']);
				else if ($_POST['action'] == 'delete_owner')
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

			if ($_POST['action'] == 'download_qrs')
			{
				$query = $this->model->get_owners();

				if (!empty($query))
                {
					$zip_archive = new ZipArchive();
					$zip_name = Session::get_value('account')['path'] . '_owners_export_' . Functions::get_current_date() . '.zip';

					$zip_archive->open($zip_name, ZipArchive::CREATE);

					foreach ($query as $value)
						$zip_archive->addFile(PATH_UPLOADS . $value['qr'], $value['qr']);

					$zip_archive->close();

					header('Content-type: application/zip');
					header('Content-Disposition: attachment; filename="' . $zip_name . '"');
					readfile($zip_name);
					unlink($zip_name);
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

			define('_title', 'Guestvox | {$lang.owners}');

			$tbl_owners = '';

			foreach ($this->model->get_owners() as $value)
			{
				$tbl_owners .=
				'<div>
					<div class="datas">
						<div class="itm_1">
							<h2>' . $value['name'][$this->lang] . (!empty($value['number']) ? ' #' . $value['number'] : '') . '</h2>
							<span>' . $value['token'] . '</span>
							<div class="checkers">
								<span><i class="fas fa-check-square ' . (($value['request'] == true) ? 'success' : '') . '"></i>{$lang.request}</span>
								<span><i class="fas fa-check-square ' . (($value['incident'] == true) ? 'success' : '') . '"></i>{$lang.incident}</span>
								<span><i class="fas fa-check-square ' . (($value['workorder'] == true) ? 'success' : '') . '"></i>{$lang.workorder}</span>
								<span><i class="fas fa-check-square ' . (($value['survey'] == true) ? 'success' : '') . '"></i>{$lang.survey}</span>
								<span><i class="fas fa-check-square ' . (($value['public'] == true) ? 'success' : '') . '"></i>{$lang.public}</span>
							</div>
						</div>
						<div class="itm_2">
							<figure>
								<a href="{$path.uploads}' . $value['qr'] . '" download="' . $value['qr'] . '"><img src="{$path.uploads}' . $value['qr'] . '"></a>
							</figure>
						</div>
					</div>
					<div class="buttons">
						' . ((Functions::check_user_access(['{owners_deactivate}','{owners_activate}']) == true) ? '<a data-action="' . (($value['status'] == true) ? 'deactivate_owner' : 'activate_owner') . '" data-id="' . $value['id'] . '">' . (($value['status'] == true) ? '<i class="fas fa-ban"></i>' : '<i class="fas fa-check"></i>') . '</a>' : '') . '
						' . ((Functions::check_user_access(['{owners_update}']) == true) ? '<a class="edit" data-action="edit_owner" data-id="' . $value['id'] . '"><i class="fas fa-pen"></i></a>' : '') . '
						' . ((Functions::check_user_access(['{owners_delete}']) == true) ? '<a class="delete" data-action="delete_owner" data-id="' . $value['id'] . '"><i class="fas fa-trash"></i></a>' : '') . '
					</div>
				</div>';
			}

			$mdl_new_owner = '';

			if (Functions::check_user_access(['{owners_create}','{owners_update}']) == true)
			{
				$mdl_new_owner .=
				'<section class="modal fullscreen" data-modal="new_owner">
				    <div class="content">
				        <main>
							<form name="new_owner">
								<div class="row">';

				if ($this->model->get_owners(true) < Session::get_value('account')['package']['quantity_end'])
				{
					$mdl_new_owner .=
					'<div class="span12">
	                    <div class="tabers">
	                        <div>
	                            <input id="onrd" type="radio" name="type" value="one" checked>
	                            <label for="onrd"><i class="fas fa-user"></i></label>
	                        </div>
	                        <div>
	                            <input id="mnrd" type="radio" name="type" value="many">
	                            <label for="mnrd"><i class="fas fa-users"></i></label>
	                        </div>
	                    </div>
	                </div>
					<div class="span6">
                        <div class="label">
                            <label required>
                                <p>(ES) {$lang.name}</p>
                                <input type="text" name="name_es">
                            </label>
                        </div>
                    </div>
					<div class="span6">
                        <div class="label">
                            <label required>
                                <p>(EN) {$lang.name}</p>
                                <input type="text" name="name_en">
                            </label>
                        </div>
                    </div>
                    <div class="span12">
                        <div class="label">
                            <label unrequired>
                                <p>{$lang.number}</p>
                                <input type="number" name="number">
                            </label>
                        </div>
                    </div>
					<div class="span6 hidden">
						<div class="label">
							<label required>
								<p>({$lang.number}) {$lang.since}</p>
								<input type="number" name="since">
							</label>
						</div>
					</div>
					<div class="span6 hidden">
						<div class="label">
							<label required>
								<p>({$lang.number}) {$lang.to}</p>
								<input type="number" name="to">
							</label>
						</div>
					</div>
					<div class="span12">
						<div class="label">
							<label>
								<p class="center">{$lang.available_for_use_in}:</p>
							</label>
						</div>
					</div>
					<div class="span4">
						<div class="label">
							<label unrequired>
								<p>{$lang.request}</p>
								<div class="switch">
									<input id="rqsw" type="checkbox" name="request" data-switcher>
									<label for="rqsw"></label>
								</div>
							</label>
						</div>
					</div>
					<div class="span4">
						<div class="label">
							<label unrequired>
								<p>{$lang.incident}</p>
								<div class="switch">
									<input id="insw" type="checkbox" name="incident" data-switcher>
									<label for="insw"></label>
								</div>
							</label>
						</div>
					</div>
					<div class="span4">
						<div class="label">
							<label unrequired>
								<p>{$lang.workorder}</p>
								<div class="switch">
									<input id="wksw" type="checkbox" name="workorder" data-switcher>
									<label for="wksw"></label>
								</div>
							</label>
						</div>
					</div>
					<div class="span4">
						<div class="label">
							<label unrequired>
								<p>{$lang.survey}</p>
								<div class="switch">
									<input id="susw" type="checkbox" name="survey" data-switcher>
									<label for="susw"></label>
								</div>
							</label>
						</div>
					</div>
					<div class="span4">
						<div class="label">
							<label unrequired>
								<p>{$lang.public}</p>
								<div class="switch">
									<input id="pusw" type="checkbox" name="public" data-switcher>
									<label for="pusw"></label>
								</div>
							</label>
						</div>
					</div>';
				}
				else
				{
					$mdl_new_owner .=
					'<div class="span12">
						<div class="maximum_exceeded">
							<i class="far fa-frown"></i>
							<p>{$lang.maximum_exceeded}</p>
						</div>
					</div>';
				}

				$mdl_new_owner .=
				'					<div class="span12">
										<div class="buttons">
											<a ' . (($this->model->get_owners(true) < Session::get_value('account')['package']['quantity_end']) ? 'button-cancel' : 'button-close') . '><i class="fas fa-times"></i></a>
											' . (($this->model->get_owners(true) < Session::get_value('account')['package']['quantity_end']) ? '<button type="submit"><i class="fas fa-check"></i></button>' : '') . '
										</div>
									</div>
								</div>
							</form>
						</main>
				    </div>
				</section>';
			}

			$replace = [
				'{$tbl_owners}' => $tbl_owners,
				'{$mdl_new_owner}' => $mdl_new_owner
			];

			$template = $this->format->replace($replace, $template);

			echo $template;
		}
	}
}
