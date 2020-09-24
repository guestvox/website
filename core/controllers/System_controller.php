<?php

defined('_EXEC') or die;

class System_controller extends Controller
{
	private $lang;

	public function __construct()
	{
		parent::__construct();

		$this->lang = Session::get_value('account')['language'];
	}

	public function translate()
	{
        if (Format::exist_ajax_request() == true)
		{
			Functions::environment([
				'status' => 'success',
				'data' => [
                    'en' => Functions::translate($_POST['string'], 'en')
                ]
			]);
		}
	}

    public function logout()
	{
		Session::destroy();

		header('Location: /login');
	}
}
