<?php

defined('_EXEC') or die;

class Qrs_controller extends Controller
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

		define('_title', 'Guestvox | {$lang.qrs}');

		$fgr_qr_menu_delivery = '';
		$div_url_menu_delivery = '';

		if (Session::get_value('account')['operation'] == true AND Session::get_value('account')['type'] == 'restaurant')
		{
			$fgr_qr_menu_delivery .=
			'<figure>
				<h2>{$lang.menu_delivery}</h2>
                <img src="{$path.uploads}' . Session::get_value('account')['qrs']['menu_delivery'] . '">
            </figure>';

			$div_url_menu_delivery .=
			'<div>
				<p><strong>{$lang.menu_delivery}:</strong><span>https://' . Configuration::$domain . '/' . Session::get_value('account')['path'] . '/myvox/delivery</span></p>
				<a data-action="copy_to_clipboard"><i class="fas fa-copy"></i></a>
				<a href="{$path.uploads}' . Session::get_value('account')['qrs']['menu_delivery'] . '" download="' . Session::get_value('account')['qrs']['menu_delivery'] . '"><i class="fas fa-download"></i></a>
				<a href="https://' . Configuration::$domain . '/' . Session::get_value('account')['path'] . '/myvox/delivery" target="_blank"><i class="fas fa-share"></i></a>
			</div>';
		}

		$fgr_qr_reviews = '';
		$div_url_reviews = '';

		if (Session::get_value('account')['reputation'] == true)
		{
			$fgr_qr_reviews .=
			'<figure>
				<h2>{$lang.reviews}</h2>
                <img src="{$path.uploads}' . Session::get_value('account')['qrs']['reviews'] . '">
            </figure>';

			$div_url_reviews .=
			'<div>
				<p><strong>{$lang.reviews}:</strong><span>https://' . Configuration::$domain . '/' . Session::get_value('account')['path'] . '/reviews</span></p>
				<a data-action="copy_to_clipboard"><i class="fas fa-copy"></i></a>
				<a href="{$path.uploads}' . Session::get_value('account')['qrs']['reviews'] . '" download="' . Session::get_value('account')['qrs']['reviews'] . '"><i class="fas fa-download"></i></a>
				<a href="https://' . Configuration::$domain . '/' . Session::get_value('account')['path'] . '/reviews" target="_blank"><i class="fas fa-share"></i></a>
			</div>';
		}

		$replace = [
			'{$fgr_qr_menu_delivery}' => $fgr_qr_menu_delivery,
			'{$div_url_menu_delivery}' => $div_url_menu_delivery,
			'{$fgr_qr_reviews}' => $fgr_qr_reviews,
			'{$div_url_reviews}' => $div_url_reviews
		];

		$template = $this->format->replace($replace, $template);

		echo $template;
	}
}
