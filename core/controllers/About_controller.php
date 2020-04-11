<?php

defined('_EXEC') or die;

class About_controller extends Controller
{
	public function __construct()
	{
		parent::__construct();
	}

	public function index()
	{
		define('_title', 'GuestVox | {$lang.we_are_guestvox}');

		$template = $this->view->render($this, 'index');

		echo $template;
	}
}
