<?php

defined('_EXEC') or die;

class Userlevels_controller extends Controller
{
	public function __construct()
	{
		parent::__construct();
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

			if ($_POST['action'] == 'new_user_level' OR $_POST['action'] == 'edit_user_level')
			{
				$labels = [];

				if (!isset($_POST['name']) OR empty($_POST['name']))
					array_push($labels, ['name', '']);

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

			if ($_POST['action'] == 'delete_user_level')
			{
				$query = $this->model->delete_user_level($_POST['id']);

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

			$tbl_user_levels = '';

			foreach ($this->model->get_user_levels() as $value)
			{
				$tbl_user_levels .=
				'<tr>
					<td align="left">' . $value['name'] . '</td>
					<td align="left">
                        ' . (($value['user_permissions']['supervision'] == true) ? '{$lang.supervision}.' : '') . '
                        ' . (($value['user_permissions']['administrative'] == true) ? '{$lang.administrative}.' : '') . '
                        ' . (($value['user_permissions']['operational'] == true) ? '{$lang.operational}.' : '') . '
                    </td>
					' . ((Functions::check_user_access(['{user_levels_delete}']) == true) ? '<td align="right" class="icon"><a data-action="delete_user_level" data-id="' . $value['id'] . '" class="delete"><i class="fas fa-trash"></i></a></td>' : '') . '
					' . ((Functions::check_user_access(['{user_levels_update}']) == true) ? '<td align="right" class="icon"><a data-action="edit_user_level" data-id="' . $value['id'] . '" class="edit"><i class="fas fa-pencil-alt"></i></a></td>' : '') . '
				</tr>';
			}

            $cbx_user_permissions =
            '<div>
                <h4><i class="fas fa-user-secret"></i>{$lang.supervision}</h4>';

            foreach ($this->model->get_user_permissions('supervision') as $key => $value)
            {
                $cbx_user_permissions .=
    			'<div>
                    <p>{$lang.' . $key . '}</p>';

                foreach ($value as $subvalue)
                {
                    $cbx_user_permissions .=
    				'<div>
    					<input type="' . (($subvalue['unique'] == true) ? 'radio' : 'checkbox') . '" name="user_permissions[]" value="' . $subvalue['id'] . '">
    					<span>' . $subvalue['name'][Session::get_value('account')['language']] . '</span>
    				</div>';
                }

                $cbx_user_permissions .=
                '</div>';
            }

            $cbx_user_permissions .=
            '</div>
            <div>
                <h4><i class="fas fa-user-cog"></i>{$lang.administrative}</h4>';

            foreach ($this->model->get_user_permissions('administrative') as $key => $value)
            {
                $cbx_user_permissions .=
    			'<div>
                    <p>{$lang.' . $key . '}</p>';

                foreach ($value as $subvalue)
                {
                    $cbx_user_permissions .=
    				'<div>
    					<input type="' . (($subvalue['unique'] == true) ? 'radio' : 'checkbox') . '" name="user_permissions[]" value="' . $subvalue['id'] . '">
    					<span>' . $subvalue['name'][Session::get_value('account')['language']] . '</span>
    				</div>';
                }

                $cbx_user_permissions .=
                '</div>';
            }

            $cbx_user_permissions .=
            '</div>
            <div>
                <h4><i class="fas fa-user-tie"></i>{$lang.operational}</h4>';

            foreach ($this->model->get_user_permissions('operational') as $key => $value)
            {
                $cbx_user_permissions .=
    			'<div>
                    <p>{$lang.' . $key . '}</p>';

                foreach ($value as $subvalue)
                {
                    $cbx_user_permissions .=
    				'<div>
    					<input type="' . (($subvalue['unique'] == true) ? 'radio' : 'checkbox') . '" name="user_permissions[]" value="' . $subvalue['id'] . '">
    					<span>' . $subvalue['name'][Session::get_value('account')['language']] . '</span>
    				</div>';
                }

                $cbx_user_permissions .=
                '</div>';
            }

            $cbx_user_permissions .=
            '</div>';

			$replace = [
				'{$tbl_user_levels}' => $tbl_user_levels,
				'{$cbx_user_permissions}' => $cbx_user_permissions,
			];

			$template = $this->format->replace($replace, $template);

			echo $template;
		}
	}
}
