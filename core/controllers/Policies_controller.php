<?php

defined('_EXEC') or die;

class Policies_controller extends Controller
{
	private $lang;

	public function __construct()
	{
		parent::__construct();

		$this->lang = Session::get_value('lang');
	}

    public function terms()
    {
		$template = $this->view->render($this, 'terms');

        define('_title', 'Guestvox | {$lang.terms_and_conditions} | {$lang.we_are_guestvox}');

        echo $template;
    }

	public function privacy()
    {
		$template = $this->view->render($this, 'privacy');

        define('_title', 'Guestvox | {$lang.privacy_policies} | {$lang.we_are_guestvox}');

        echo $template;
    }
}
