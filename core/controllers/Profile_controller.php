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
		if (Format::exist_ajax_request() == true)
		{
			if ($_POST['action'] == 'edit_avatar')
			{
				$query = $this->model->edit_avatar($_FILES);

				Functions::environment([
					'status' => !empty($query) ? 'success' : 'error',
					'message' => !empty($query) ? '{$lang.success_operation_database}' : '{$lang.error_operation_database}',
					'path' => '/profile',
				]);
			}

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
				else
				{
					Functions::environment([
						'status' => 'error',
						'labels' => $labels
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
				else
				{
					Functions::environment([
						'status' => 'error',
						'labels' => $labels
					]);
				}
			}
		}
		else
		{
			define('_title', 'GuestVox | Perfil');

			$template = $this->view->render($this, 'index');

			$profile = $this->model->get_profile();

			$replace = [
				'{$avatar}' => !empty($profile['avatar']) ? '{$path.uploads}' . $profile['avatar'] : '{$path.images}empty.png',
				'{$account}' => $profile['account'],
				'{$name}' => $profile['name'],
				'{$lastname}' => $profile['lastname'],
				'{$email}' => $profile['email'],
				'{$cellphone}' => $profile['cellphone'],
				'{$profilename}' => $profile['username'],
				'{$temporal_password}' => (!empty($profile['temporal_password']) ? '<h6>' . $profile['temporal_password'] . '</h6>' : ''),
				'{$profile_level}' => $profile['user_level'],
			];

			$template = $this->format->replace($replace, $template);

			echo $template;
		}
	}
}
