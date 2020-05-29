<?php

defined('_EXEC') or die;

class Userslevels_controller extends Controller
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
			if ($_POST['action'] == 'get_user_level')
			{
				$query = $this->model->get_user_level($_POST['id']);

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

			if ($_POST['action'] == 'new_user_level' OR $_POST['action'] == 'edit_user_level')
			{
				$labels = [];

				if (!isset($_POST['name']) OR empty($_POST['name']))
					array_push($labels, ['name', '']);

				if (!isset($_POST['permissions']) OR empty($_POST['permissions']))
					array_push($labels, ['permissions', '']);

				if (empty($labels))
				{
					if ($_POST['action'] == 'new_user_level')
						$query = $this->model->new_user_level($_POST);
					else if ($_POST['action'] == 'edit_user_level')
						$query = $this->model->edit_user_level($_POST);

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

			if ($_POST['action'] == 'deactivate_user_level' OR $_POST['action'] == 'activate_user_level' OR $_POST['action'] == 'delete_user_level')
			{
				if ($_POST['action'] == 'deactivate_user_level')
					$query = $this->model->deactivate_user_level($_POST['id']);
				else if ($_POST['action'] == 'activate_user_level')
					$query = $this->model->activate_user_level($_POST['id']);
				else if ($_POST['action'] == 'delete_user_level')
					$query = $this->model->delete_user_level($_POST['id']);

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

			define('_title', 'Guestvox | {$lang.users_levels}');

			$tbl_users_levels = '';

			foreach ($this->model->get_users_levels() as $value)
			{
				$tbl_users_levels .=
				'<div>
					<div class="datas">
						<h2>' . $value['name'] . '</h2>
					</div>
					<div class="buttons flex_right">
						' . ((Functions::check_user_access(['{users_levels_deactivate}','{users_levels_activate}']) == true)
								? '<a data-action="' . (($value['status'] == true) ? 'deactivate_user_level' : 'activate_user_level') . '" data-id="' . $value['id'] . '">' . (($value['status'] == true) ? '<i class="fas fa-ban"></i>' : '<i class="fas fa-check"></i>') . '</a>'
								: '') . '
						' . ((Functions::check_user_access(['{users_levels_update}']) == true) ? '<a class="edit" data-action="edit_user_level" data-id="' . $value['id'] . '"><i class="fas fa-pen"></i></a>' : '') . '
						' . ((Functions::check_user_access(['{users_levels_delete}']) == true) ? '<a class="delete" data-action="delete_user_level" data-id="' . $value['id'] . '"><i class="fas fa-trash"></i></a>' : '') . '
					</div>
				</div>';
			}

			$cbx_permissions =
            '<div>
                <h4><i class="fas fa-user-secret"></i>{$lang.supervision}</h4>';

            foreach ($this->model->get_permissions('supervision') as $key => $value)
            {
                $cbx_permissions .=
    			'<div>
                    <p>{$lang.' . $key . '}</p>';

                foreach ($value as $subvalue)
                {
                    $cbx_permissions .=
    				'<div>
    					<input type="' . (($subvalue['unique'] == true) ? 'radio' : 'checkbox') . '" name="permissions[]" value="' . $subvalue['id'] . '">
    					<span>' . $subvalue['name'][$this->lang] . '</span>
    				</div>';
                }

                $cbx_permissions .= '</div>';
            }

            $cbx_permissions .=
            '</div>
            <div>
                <h4><i class="fas fa-user-cog"></i>{$lang.administrative}</h4>';

            foreach ($this->model->get_permissions('administrative') as $key => $value)
            {
                $cbx_permissions .=
    			'<div>
                    <p>{$lang.' . $key . '}</p>';

                foreach ($value as $subvalue)
                {
                    $cbx_permissions .=
    				'<div>
    					<input type="' . (($subvalue['unique'] == true) ? 'radio' : 'checkbox') . '" name="permissions[]" value="' . $subvalue['id'] . '">
    					<span>' . $subvalue['name'][$this->lang] . '</span>
    				</div>';
                }

                $cbx_permissions .= '</div>';
            }

            $cbx_permissions .=
            '</div>
            <div>
                <h4><i class="fas fa-user-tie"></i>{$lang.operational}</h4>';

            foreach ($this->model->get_permissions('operational') as $key => $value)
            {
                $cbx_permissions .=
    			'<div>
                    <p>{$lang.' . $key . '}</p>';

                foreach ($value as $subvalue)
                {
                    $cbx_permissions .=
    				'<div>
    					<input type="' . (($subvalue['unique'] == true) ? 'radio' : 'checkbox') . '" name="permissions[]" value="' . $subvalue['id'] . '">
    					<span>' . $subvalue['name'][$this->lang] . '</span>
    				</div>';
                }

                $cbx_permissions .= '</div>';
            }

            $cbx_permissions .= '</div>';

			$replace = [
				'{$tbl_users_levels}' => $tbl_users_levels,
				'{$cbx_permissions}' => $cbx_permissions
			];

			$template = $this->format->replace($replace, $template);

			echo $template;
		}
	}
}
