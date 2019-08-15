<?php

defined('_EXEC') or die;

class Notes_controller extends Controller
{
	public function __construct()
	{
		parent::__construct();
	}

	public function index()
	{
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

		}
		else
		{
			define('_title', 'GuestVox | Notas');

			$template = $this->view->render($this, 'index');

			$replace = [
			];

			$template = $this->format->replace($replace, $template);

			echo $template;
		}
	}
}
