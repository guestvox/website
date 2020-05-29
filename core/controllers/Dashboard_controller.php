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
		$template = $this->view->render($this, 'index');

		define('_title', 'Guestvox | {$lang.dashboard}');

		echo $template;
	}
}
