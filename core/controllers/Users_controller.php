<?php

defined('_EXEC') or die;

class Users_controller extends Controller
{
	public function __construct()
	{
		parent::__construct();
	}

	public function index()
	{
		if (Format::exist_ajax_request() == true)
		{
			if ($_POST['action'] == 'get_user')
			{
				$query = $this->model->get_user($_POST['id']);

				Functions::environment([
					'status' => (!empty($query)) ? 'success' : 'error',
					'data' => (!empty($query)) ? $query : null,
					'message' => (!empty($query)) ? null : '{$lang.error_operation_database}',
				]);
			}

			if ($_POST['action'] == 'new_user' OR $_POST['action'] == 'edit_user')
			{
				$labels = [];

				if (!isset($_POST['name']) OR empty($_POST['name']))
					array_push($labels, ['name', '']);

				if (!isset($_POST['lastname']) OR empty($_POST['lastname']))
					array_push($labels, ['lastname', '']);

				if (!isset($_POST['email']) OR empty($_POST['email']) OR Functions::check_email($_POST['email']) == false)
					array_push($labels, ['email', '']);

				if (!isset($_POST['cellphone']) OR empty($_POST['cellphone']))
					array_push($labels, ['cellphone', '']);

				if (!isset($_POST['username']) OR empty($_POST['username']))
					array_push($labels, ['username', '']);

				if (!isset($_POST['user_level']) OR empty($_POST['user_level']))
					array_push($labels, ['user_level', '']);

				if (!isset($_POST['user_permissions']) OR empty($_POST['user_permissions']))
					array_push($labels, ['user_permissions[]', '']);

				if (!isset($_POST['opportunity_areas']) OR empty($_POST['opportunity_areas']))
					array_push($labels, ['opportunity_areas[]', '']);

				if (empty($labels))
				{
					if ($_POST['action'] == 'new_user')
						$query = $this->model->new_user($_POST);
					else if ($_POST['action'] == 'edit_user')
						$query = $this->model->edit_user($_POST);

					if (!empty($query))
					{
						Functions::environment([
							'status' => 'success',
							'message' => '{$lang.success_operation_database}',
						]);
					}
					else
					{
						Functions::environment([
							'status' => 'error',
							'message' => '{$lang.error_operation_database}',
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

			if ($_POST['action'] == 'restore_password_user')
			{
				$query = $this->model->restore_password_user($_POST['id']);

				if (!empty($query))
				{
					Functions::environment([
						'status' => 'success',
						'message' => '{$lang.success_operation_database}',
					]);
				}
				else
				{
					Functions::environment([
						'status' => 'error',
						'message' => '{$lang.error_operation_database}',
					]);
				}
			}

			if ($_POST['action'] == 'deactivate_user')
			{
				$query = $this->model->deactivate_user($_POST['id']);

				if (!empty($query))
				{
					Functions::environment([
						'status' => 'success',
						'message' => '{$lang.success_operation_database}',
					]);
				}
				else
				{
					Functions::environment([
						'status' => 'error',
						'message' => '{$lang.error_operation_database}',
					]);
				}
			}

			if ($_POST['action'] == 'activate_user')
			{
				$query = $this->model->activate_user($_POST['id']);

				if (!empty($query))
				{
					Functions::environment([
						'status' => 'success',
						'message' => '{$lang.success_operation_database}',
					]);
				}
				else
				{
					Functions::environment([
						'status' => 'error',
						'message' => '{$lang.error_operation_database}',
					]);
				}
			}

			if ($_POST['action'] == 'delete_user')
			{
				$query = $this->model->delete_user($_POST['id']);

				if (!empty($query))
				{
					Functions::environment([
						'status' => 'success',
						'message' => '{$lang.success_operation_database}',
					]);
				}
				else
				{
					Functions::environment([
						'status' => 'error',
						'message' => '{$lang.error_operation_database}',
					]);
				}
			}

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
						'message' => '{$lang.error_operation_database}'
					]);
				}
			}

			if ($_POST['action'] == 'new_user_level' OR $_POST['action'] == 'edit_user_level')
			{
				$labels = [];

				if (!isset($_POST['name']) OR empty($_POST['name']))
					array_push($labels, ['name', '']);

				if (!isset($_POST['user_permissions']) OR empty($_POST['user_permissions']))
					array_push($labels, ['user_permissions[]', '']);

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
							'message' => '{$lang.success_operation_database}',
						]);
					}
					else
					{
						Functions::environment([
							'status' => 'error',
							'message' => '{$lang.error_operation_database}',
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
						'message' => '{$lang.success_operation_database}',
					]);
				}
				else
				{
					Functions::environment([
						'status' => 'error',
						'message' => '{$lang.error_operation_database}',
					]);
				}
			}
		}
		else
		{
			define('_title', 'GuestVox | {$lang.users}');

			$template = $this->view->render($this, 'index');

			$tbl_users_activate = '';

			foreach ($this->model->get_users(true, true) as $value)
			{
				$tbl_users_activate .=
				'<tr>
					<td align="left">' . $value['name'] . ' ' . $value['lastname'] . '</td>
					<td align="left">' . $value['email'] . '</td>
					<td align="left">' . $value['cellphone'] . '</td>
					<td align="left">' . $value['username'] . '</td>
					<td align="left">' . $value['temporal_password'] . '</td>
					<td align="left">' . $value['user_level'] . '</td>
					' . ((Functions::check_access(['{users_restorepassword}']) == true) ? '<td align="right" class="icon"><a data-action="restore_password_user" data-id="' . $value['id'] . '"><i class="fas fa-key"></i></a></td>' : '') . '
					' . ((Functions::check_access(['{users_delete}']) == true) ? '<td align="right" class="icon">' . (($value['relation'] == false) ? '<a data-action="delete_user" data-id="' . $value['id'] . '"><i class="fas fa-trash"></i></a>' : '') . '</td>' : '') . '
					' . ((Functions::check_access(['{users_deactivate}']) == true) ? '<td align="right" class="icon"><a data-action="deactivate_user" data-id="' . $value['id'] . '"><i class="fas fa-ban"></i></a></td>' : '') . '
					' . ((Functions::check_access(['{users_update}']) == true) ? '<td align="right" class="icon"><a data-action="edit_user" data-id="' . $value['id'] . '"><i class="fas fa-pencil-alt"></i></a></td>' : '') . '
				</tr>';
			}

			$opt_user_levels = '';

			foreach ($this->model->get_user_levels() as $value)
				$opt_user_levels .= '<option value="' . $value['id'] . '">' . $value['name'] . '</option>';

			$cbx_user_permissions =
			'<p>{$lang.voxes}</p>
			<div class="checkbox">
				<input type="checkbox" checked disabled>
				<span>Crear</span>
			</div>';

			foreach ($this->model->get_user_permissions('voxes') as $value)
			{
				$cbx_user_permissions .=
				'<div class="checkbox">
					<input type="checkbox" name="user_permissions[]" value="' . $value['id'] . '">
					<span>' . $value['description'][Session::get_value('lang')] . '</span>
				</div>';
			}

			$cbx_user_permissions .= '<p>{$lang.stats}</p>';

			foreach ($this->model->get_user_permissions('stats') as $value)
			{
				$cbx_user_permissions .=
				'<div class="checkbox">
					<input type="checkbox" name="user_permissions[]" value="' . $value['id'] . '">
					<span>' . $value['description'][Session::get_value('lang')] . '</span>
				</div>';
			}

			$cbx_user_permissions .= '<p>{$lang.reports}</p>';

			foreach ($this->model->get_user_permissions('reports') as $value)
			{
				$cbx_user_permissions .=
				'<div class="checkbox">
					<input type="checkbox" name="user_permissions[]" value="' . $value['id'] . '">
					<span>' . $value['description'][Session::get_value('lang')] . '</span>
				</div>';
			}

			$cbx_user_permissions .= '<p>{$lang.settings} - {$lang.opportunity_areas}</p>';

			foreach ($this->model->get_user_permissions('opportunityareas') as $value)
			{
				$cbx_user_permissions .=
				'<div class="checkbox">
					<input type="checkbox" name="user_permissions[]" value="' . $value['id'] . '">
					<span>' . $value['description'][Session::get_value('lang')] . '</span>
				</div>';
			}

			$cbx_user_permissions .= '<p>{$lang.settings} - {$lang.opportunity_types}</p>';

			foreach ($this->model->get_user_permissions('opportunitytypes') as $value)
			{
				$cbx_user_permissions .=
				'<div class="checkbox">
					<input type="checkbox" name="user_permissions[]" value="' . $value['id'] . '">
					<span>' . $value['description'][Session::get_value('lang')] . '</span>
				</div>';
			}

			$cbx_user_permissions .= '<p>{$lang.settings} - {$lang.locations}</p>';

			foreach ($this->model->get_user_permissions('locations') as $value)
			{
				$cbx_user_permissions .=
				'<div class="checkbox">
					<input type="checkbox" name="user_permissions[]" value="' . $value['id'] . '">
					<span>' . $value['description'][Session::get_value('lang')] . '</span>
				</div>';
			}

			$cbx_user_permissions .= '<p>{$lang.settings} - {$lang.rooms}</p>';

			foreach ($this->model->get_user_permissions('rooms') as $value)
			{
				$cbx_user_permissions .=
				'<div class="checkbox">
					<input type="checkbox" name="user_permissions[]" value="' . $value['id'] . '">
					<span>' . $value['description'][Session::get_value('lang')] . '</span>
				</div>';
			}

			$cbx_user_permissions .= '<p>{$lang.settings} - {$lang.guest_treatments}</p>';

			foreach ($this->model->get_user_permissions('guesttreatments') as $value)
			{
				$cbx_user_permissions .=
				'<div class="checkbox">
					<input type="checkbox" name="user_permissions[]" value="' . $value['id'] . '">
					<span>' . $value['description'][Session::get_value('lang')] . '</span>
				</div>';
			}

			$cbx_user_permissions .= '<p>{$lang.settings} - {$lang.guest_types}</p>';

			foreach ($this->model->get_user_permissions('guesttypes') as $value)
			{
				$cbx_user_permissions .=
				'<div class="checkbox">
					<input type="checkbox" name="user_permissions[]" value="' . $value['id'] . '">
					<span>' . $value['description'][Session::get_value('lang')] . '</span>
				</div>';
			}

			$cbx_user_permissions .= '<p>{$lang.settings} - {$lang.reservation_status}</p>';

			foreach ($this->model->get_user_permissions('reservationstatus') as $value)
			{
				$cbx_user_permissions .=
				'<div class="checkbox">
					<input type="checkbox" name="user_permissions[]" value="' . $value['id'] . '">
					<span>' . $value['description'][Session::get_value('lang')] . '</span>
				</div>';
			}

			$cbx_user_permissions .= '<p>{$lang.users}</p>';

			foreach ($this->model->get_user_permissions('users') as $value)
			{
				$cbx_user_permissions .=
				'<div class="checkbox">
					<input type="checkbox" name="user_permissions[]" value="' . $value['id'] . '">
					<span>' . $value['description'][Session::get_value('lang')] . '</span>
				</div>';
			}

			$cbx_user_permissions .= '<p>{$lang.user_permissions}</p>';

			foreach ($this->model->get_user_permissions('userlevels') as $value)
			{
				$cbx_user_permissions .=
				'<div class="checkbox">
					<input type="checkbox" name="user_permissions[]" value="' . $value['id'] . '">
					<span>' . $value['description'][Session::get_value('lang')] . '</span>
				</div>';
			}

			$cbx_user_permissions .= '<p>{$lang.data_views}</p>';

			foreach ($this->model->get_user_permissions('views') as $value)
			{
				$cbx_user_permissions .=
				'<div class="checkbox">
					<input type="' . (($value['unique'] == true) ? 'radio' : 'checkbox') . '" name="user_permissions[]" value="' . $value['id'] . '">
					<span>' . $value['description'][Session::get_value('lang')] . '</span>
				</div>';
			}

			$cbx_opportunity_areas = '';

			foreach ($this->model->get_opportunity_areas() as $value)
			{
				$cbx_opportunity_areas .=
				'<div class="checkbox">
					<input type="checkbox" name="opportunity_areas[]" value="' . $value['id'] . '">
					<span>' . $value['name'][Session::get_value('settings')['language']] . '</span>
				</div>';
			}

			$tbl_users_deactivate = '';

			foreach ($this->model->get_users(false) as $value)
			{
				$tbl_users_deactivate .=
				'<tr>
					<td align="left">' . $value['name'] . ' ' . $value['lastname'] . '</td>
					<td align="left">' . $value['email'] . '</td>
					<td align="left">' . $value['cellphone'] . '</td>
					<td align="left">' . $value['username'] . '</td>
					<td align="left">' . $value['temporal_password'] . '</td>
					<td align="left">' . $value['user_level'] . '</td>
					<td align="right" class="icon"><a data-action="activate_user" data-id="' . $value['id'] . '"><i class="fas fa-check"></i></a></td>
				</tr>';
			}

			$tbl_user_levels = '';

			foreach ($this->model->get_user_levels(true) as $value)
			{
				$tbl_user_levels .=
				'<tr>
					<td align="left">' . $value['name'] . '</td>
					' . ((Functions::check_access(['{userlevels_delete}']) == true) ? '<td align="right" class="icon">' . (($value['relation'] == false) ? '<a data-action="delete_user_level" data-id="' . $value['id'] . '"><i class="fas fa-trash"></i></a>' : '') . '</td>' : '') . '
					' . ((Functions::check_access(['{userlevels_update}']) == true) ? '<td align="right" class="icon"><a data-action="edit_user_level" data-id="' . $value['id'] . '"><i class="fas fa-pencil-alt"></i></a></td>' : '') . '
				</tr>';
			}

			$replace = [
				'{$tbl_users_activate}' => $tbl_users_activate,
				'{$opt_user_levels}' => $opt_user_levels,
				'{$cbx_user_permissions}' => $cbx_user_permissions,
				'{$cbx_opportunity_areas}' => $cbx_opportunity_areas,
				'{$tbl_users_deactivate}' => $tbl_users_deactivate,
				'{$tbl_user_levels}' => $tbl_user_levels,
			];

			$template = $this->format->replace($replace, $template);

			echo $template;
		}
	}
}
