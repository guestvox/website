<?php

defined('_EXEC') or die;

class Dashboard_controller extends Controller
{
	public function __construct()
	{
		parent::__construct();
	}

	public function index()
	{
		define('_title', 'GuestVox | {$lang.dashboard}');

		$template = $this->view->render($this, 'index');

		echo $template;
	}

	public function logout()
	{
		Session::destroy();

		header("Location: /login");
	}
}
