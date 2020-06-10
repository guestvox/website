<?php

defined('_EXEC') or die;

class Profile_controller extends Controller
{
	private $lang;

	public function __construct()
	{
		parent::__construct();

		$this->lang = Session::get_value('account')['language'];
	}

	public function index()
	{
		$profile = $this->model->get_profile();

		if (Format::exist_ajax_request() == true)
		{
			if ($_POST['action'] == 'edit_avatar')
			{
				$labels = [];

				if (!isset($_FILES['avatar']['name']) OR empty($_FILES['avatar']['name']))
					array_push($labels, ['avatar','']);

				if (empty($labels))
				{
					$query = $this->model->edit_avatar($_FILES);

					if (!empty($query))
					{
						$user = Session::get_value('user');

						$user['avatar'] = $query;

						Session::set_value('user', $user);

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

			if ($_POST['action'] == 'get_profile')
			{
				Functions::environment([
					'status' => 'success',
					'data' => $profile
				]);
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
						$user = Session::get_value('user');

						$user['firstname'] = $_POST['firstname'];
						$user['lastname'] = $_POST['lastname'];

						Session::set_value('user', $user);

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
			$template = $this->view->render($this, 'index');

			define('_title', 'Guestvox | {$lang.my_profile}');

			$opt_ladas = '';

			foreach ($this->model->get_countries() as $value)
				$opt_ladas .= '<option value="' . $value['lada'] . '">' . $value['name'][$this->lang] . ' (+' . $value['lada'] . ')</option>';

			$replace = [
				'{$avatar}' => !empty($profile['avatar']) ? '{$path.uploads}' . $profile['avatar'] : '{$path.images}avatar.png',
				'{$name}' => $profile['firstname'] . ' ' . $profile['lastname'],
				'{$username}' => '@' . $profile['username'],
				'{$email}' => $profile['email'],
				'{$phone}' => '+ (' . $profile['phone']['lada'] . ') ' . $profile['phone']['number'],
				'{$opt_ladas}' => $opt_ladas
			];

			$template = $this->format->replace($replace, $template);

			echo $template;
		}
	}
}
