<?php

defined('_EXEC') or die;

class Login_controller extends Controller
{
	public function __construct()
	{
		parent::__construct();
	}

	public function index()
	{
		if (Format::exist_ajax_request() == true)
		{
			$labels = [];

			if (!isset($_POST['username']) OR empty($_POST['username']))
				array_push($labels, ['username','']);

			if (!isset($_POST['password']) OR empty($_POST['password']))
				array_push($labels, ['password','']);

			if (empty($labels))
			{
				$query = $this->model->get_login($_POST);

				if (!empty($query))
				{
					if ($query['account']['status'] == true)
					{
						if ($query['user']['status'] == true)
						{
							$query['user']['password'] = explode(':', $query['user']['password']);
							$query['user']['password'] = ($this->security->create_hash('sha1', $_POST['password'] . $query['user']['password'][1]) === $query['user']['password'][0]) ? true : false;

							if ($query['user']['password'] == true)
							{
								unset($query['user']['password']);
								unset($query['user']['status']);
								unset($query['account']['status']);

								Session::init();
								Session::set_value('session', true);
								Session::set_value('user', $query['user']);
								Session::set_value('account', $query['account']);
								Session::set_value('lang', $query['account']['language']);
								Session::set_value('_vkye_last_access', Functions::get_current_date_hour());

								Functions::environment([
									'status' => 'success',
									'path' => User_level::redirection()
								]);
							}
							else
							{
								Functions::environment([
									'status' => 'error',
									'labels' => [['password','']]
								]);
							}
						}
						else
						{
							Functions::environment([
								'status' => 'error',
								'message' => '{$lang.user_not_activate}'
							]);
						}
					}
					else
					{
						Functions::environment([
							'status' => 'error',
							'message' => '{$lang.account_not_activate}'
						]);
					}
				}
				else
				{
					Functions::environment([
						'status' => 'error',
						'labels' => [['username','']]
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
		else
		{
			define('_title', 'Guestvox | {$lang.login}');

			$template = $this->view->render($this, 'index');

			echo $template;
		}
	}
}
