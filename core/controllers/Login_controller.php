<?php

defined('_EXEC') or die;

class Login_controller extends Controller
{
	public function __construct()
	{
		parent::__construct();
	}

	public function Login()
	{
		if (Format::exist_ajax_request() == true)
		{
                        if ($_POST['action'] == 'login')
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
										'status' => 'success'
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
		}
		else
		{
			define('_title', 'GuestVox');

			$template = $this->view->render($this, 'login');

			$opt_countries = '';

			foreach ($this->model->get_countries() as $value)
				$opt_countries .= '<option value="' . $value['code'] . '">' . $value['name'][Session::get_value('lang')] . '</option>';

			$opt_time_zones = '';

			foreach ($this->model->get_time_zones() as $value)
				$opt_time_zones .= '<option value="' . $value['code'] . '">' . $value['code'] . '</option>';

			$opt_currencies = '';

			foreach ($this->model->get_currencies() as $value)
				$opt_currencies .= '<option value="' . $value['code'] . '">(' . $value['code'] . ') ' . $value['name'][Session::get_value('lang')] . '</option>';

			$opt_languages = '';

			foreach ($this->model->get_languages() as $value)
				$opt_languages .= '<option value="' . $value['code'] . '">' . $value['name'] . '</option>';

			$opt_ladas = '';

			foreach ($this->model->get_countries() as $value)
				$opt_ladas .= '<option value="' . $value['lada'] . '">(+' . $value['lada'] . ') ' . $value['name'][Session::get_value('lang')] . '</option>';

			$replace = [
				'{$opt_countries}' => $opt_countries,
				'{$opt_time_zones}' => $opt_time_zones,
				'{$opt_currencies}' => $opt_currencies,
				'{$opt_languages}' => $opt_languages,
				'{$opt_ladas}' => $opt_ladas
			];

			$template = $this->format->replace($replace, $template);

			echo $template;
		}
	}
}
