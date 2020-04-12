<?php

defined('_EXEC') or die;

class Terms_controller extends Controller
{
	public function __construct()
	{
		parent::__construct();
	}

    public function index()
    {
        define('_title', 'GuestVox | {$lang.terms_and_conditions}');

        $template = $this->view->render($this, 'index');

        echo $template;
    }
}
