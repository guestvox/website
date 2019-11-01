<?php

defined('_EXEC') or die;

class Public_sites_controller extends Controller
{
	public function __construct()
	{
		parent::__construct();
	}

	public function hola()
	{
		define('_title', '');

		$template = $this->view->render($this, 'hola');

		$replace = [
		];

		$template = $this->format->replace($replace, $template);

		echo $template;
	}
}
