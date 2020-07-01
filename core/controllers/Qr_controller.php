<?php

defined('_EXEC') or die;

class Qr_controller extends Controller
{
	private $lang;

	public function __construct()
	{
		parent::__construct();

		$this->lang = Session::get_value('account')['language'];
	}

	public function index()
	{
		$template = $this->view->render($this, 'index');

		define('_title', 'Guestvox | {$lang.qr}');

		$div_url_reviews = '';

		if (Session::get_value('account')['reputation'] == true)
		{
			$div_url_reviews .=
			'<div>
				<p><strong>{$lang.reviews_page}:</strong><span>https://' . Configuration::$domain . '/' . Session::get_value('account')['path'] . '/reviews</span></p>
				<a href="https://' . Configuration::$domain . '/' . Session::get_value('account')['path'] . '/reviews" target="_blank"><i class="fas fa-share"></i></a>
				<a data-action="copy_to_clipboard"><i class="fas fa-copy"></i></a>
			</div>';
		}

		$replace = [
			'{$div_url_reviews}' => $div_url_reviews
		];

		$template = $this->format->replace($replace, $template);

		echo $template;
	}
}
