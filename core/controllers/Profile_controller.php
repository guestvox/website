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

				if (!empty($query))
				{
					$tmp = Session::get_value('user');

					$tmp['avatar'] = $query;

					Session::set_value('user', $tmp);

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

			if ($_POST['action'] == 'edit_profile')
			{
				$labels = [];

				if (!isset($_POST['firstname']) OR empty($_POST['firstname']))
					array_push($labels, ['firstname', '']);

				if (!isset($_POST['lastname']) OR empty($_POST['lastname']))
					array_push($labels, ['lastname', '']);

				if (!isset($_POST['email']) OR empty($_POST['email']) OR Functions::check_email($_POST['email']) == false AND $this->model->check_exist_user('email', $_POST['email']) == true)
					array_push($labels, ['email', '']);

				if (!isset($_POST['phone_lada']) OR empty($_POST['phone_lada']))
					array_push($labels, ['phone_lada', '']);

				if (!isset($_POST['phone_number']) OR empty($_POST['phone_number']))
					array_push($labels, ['phone_number', '']);

				if (!isset($_POST['username']) OR empty($_POST['username']) AND $this->model->check_exist_user('username', $_POST['username']) == true)
					array_push($labels, ['username', '']);

				if (empty($labels))
				{
					$query = $this->model->edit_profile($_POST);

					if (!empty($query))
					{
						$tmp = Session::get_value('user');

						$tmp['firstname'] = $_POST['firstname'];
						$tmp['lastname'] = $_POST['lastname'];

						Session::set_value('user', $tmp);

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

			if ($_POST['action'] == 'restore_password')
			{
				$labels = [];

				if (!isset($_POST['password']) OR empty($_POST['password']))
					array_push($labels, ['password', '']);

				if (empty($labels))
				{
					$query = $this->model->restore_password($_POST);

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
		}
		else
		{
			define('_title', 'GuestVox');

			$template = $this->view->render($this, 'index');

			$profile = $this->model->get_profile();

			$opt_ladas = '';

			foreach ($this->model->get_ladas() as $value)
				$opt_ladas .= '<option value="' . $value['lada'] . '" ' . (($value['lada'] == $profile['phone']['lada']) ? 'selected' : '') . '>' . $value['name'][Session::get_value('account')['language']] . ' (+' . $value['lada'] . ')/option>';

			$replace = [
				'{$avatar}' => !empty($profile['avatar']) ? '{$path.uploads}' . $profile['avatar'] : '{$path.images}avatar.png',
				'{$firstname}' => $profile['firstname'],
				'{$lastname}' => $profile['lastname'],
				'{$email}' => $profile['email'],
				'{$phone_lada}' => $profile['phone']['lada'],
				'{$phone_number}' => $profile['phone']['number'],
				'{$username}' => $profile['username'],
				'{$user_permissions}' => (($profile['user_permissions']['supervision'] == true) ? '{$lang.supervision}.' : '') . ' ' . (($profile['user_permissions']['administrative'] == true) ? '{$lang.administrative}.' : '') . ' ' . (($profile['user_permissions']['operational'] == true) ? '{$lang.operational}.' : ''),
				'{$opt_ladas}' => $opt_ladas,
			];

			$template = $this->format->replace($replace, $template);

			echo $template;
		}
	}
}
