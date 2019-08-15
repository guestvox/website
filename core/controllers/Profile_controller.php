<?php

defined('_EXEC') or die;

class Profile_controller extends Controller
{
	public function __construct()
	{
		parent::__construct();
	}

	public function index()
	{
		$user = $this->model->get_user();

		if (Format::exist_ajax_request() == true)
		{
			if ($_POST['action'] == 'edit_profile')
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

				if (empty($labels))
				{
					$query = $this->model->edit_profile($_POST);

					Functions::environment([
						'status' => !empty($query) ? 'success' : 'error',
						'message' => !empty($query) ? '{$lang.success_operation_database}' : '{$lang.error_operation_database}',
						'path' => '/profile',
					]);
				}
			}

			if ($_POST['action'] == 'reset_password')
			{
				$labels = [];

				if (!isset($_POST['password']) OR empty($_POST['password']))
					array_push($labels, ['password', '']);

				if (empty($labels))
				{
					$query = $this->model->reset_password($_POST);

					Functions::environment([
						'status' => !empty($query) ? 'success' : 'error',
						'message' => !empty($query) ? '{$lang.success_operation_database}' : '{$lang.error_operation_database}',
						'path' => '/profile',
					]);
				}
			}
		}
		else
		{
			define('_title', 'GuestVox | Perfil');

			$template = $this->view->render($this, 'index');

			$opportunity_areas = '';

			foreach ($user['opportunity_areas'] as $value)
				$opportunity_areas .= '<h6>' . $value[Session::get_value('settings')['language']] . '</h6>';

			$user_permissions = '';

			foreach ($user['user_permissions'] as $value)
				$user_permissions .= '<h6>' . $value . '</h6>';

			$replace = [
				'{$account}' => $user['account'],
				'{$name}' => $user['name'],
				'{$lastname}' => $user['lastname'],
				'{$email}' => $user['email'],
				'{$cellphone}' => $user['cellphone'],
				'{$username}' => $user['username'],
				'{$temporal_password}' => (!empty($user['temporal_password']) ? '<h6>' . $user['temporal_password'] . '</h6>' : ''),
				'{$password}' => $user['temporal_password'],
				'{$user_level}' => $user['user_level'],
				'{$opportunity_areas}' => $opportunity_areas,
				'{$user_permissions}' => $user_permissions,
				'{$status}' => (($user['status'] == true) ? '<h6>Activo</h6>' : '<h6>Inactivo</h6>'),
			];

			$template = $this->format->replace($replace, $template);

			echo $template;
		}
	}
}
