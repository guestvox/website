<?php

defined('_EXEC') or die;

class Policies_controller extends Controller
{
	public function __construct()
	{
		parent::__construct();
	}

    public function terms()
    {
        define('_title', 'GuestVox | {$lang.terms_and_conditions}');

        $template = $this->view->render($this, 'terms');

        echo $template;
    }

	public function privacy()
    {
        define('_title', 'GuestVox | {$lang.privacy_policies}');

        $template = $this->view->render($this, 'privacy');

        echo $template;
    }
}
