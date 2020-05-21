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
		$template = $this->view->render($this, 'terms');

        define('_title', 'Guestvox | {$lang.terms_and_conditions}');

        echo $template;
    }

	public function privacy()
    {
		$template = $this->view->render($this, 'privacy');

        define('_title', 'Guestvox | {$lang.privacy_policies}');

        echo $template;
    }
}
