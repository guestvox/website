<?php

defined('_EXEC') or die;

class Subscription_controller extends Controller
{
	public function __construct()
	{
		parent::__construct();
	}

	public function index()
	{
		if (Format::exist_ajax_request() == true)
        {

        }
        else
        {
            define('_title', 'GuestVox | Mi suscripción');

    		$template = $this->view->render($this, 'index');

    		$replace = [

    		];

    		$template = $this->format->replace($replace, $template);

    		echo $template;
        }
	}
}
