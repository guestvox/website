<?php

defined('_EXEC') or die;

class Index_controller extends Controller
{
	public function __construct()
	{
		parent::__construct();
	}

	public function index()
	{
		$template = $this->view->render($this, 'index');

		define('_title', 'Guestvox | {$lang.we_are_guestvox}');

		echo $template;
	}
}
