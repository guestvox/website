<?php

defined('_EXEC') or die;

class About_controller extends Controller
{
	private $lang;

	public function __construct()
	{
		parent::__construct();

		$this->lang = Session::get_value('lang');
	}

	public function index()
	{
		$template = $this->view->render($this, 'index');

		define('_title', 'Guestvox | {$lang.about_us}');

		echo $template;
	}
}
