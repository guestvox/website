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
        define('_title', 'GuestVox');

        $template = $this->view->render($this, 'index');

        $replace = [

        ];

        $template = $this->format->replace($replace, $template);

        echo $template;
    }
}
