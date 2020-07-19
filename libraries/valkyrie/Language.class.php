<?php
defined('_EXEC') or die;

/**
 *
 * @package Valkyrie.Libraries
 *
 * @since 1.0.0
 * @version 1.0.0
 * @license You can see LICENSE.txt
 *
 * @author David Miguel Gómez Macías < davidgomezmacias@gmail.com >
 * @copyright Copyright (C) CodeMonkey - Platform. All Rights Reserved.
 */

class Language
{
    /**
     *
     * @var object
     */
    private $security;

    /**
     *
     * @var object
     */
    private $render;

    /**
     *
     * @var object
     */
    private $format;

    /**
     * @static
     *
     * @var string
     */
    private static $path_language;

    /**
	 * Constructor.
     *
     * @return  void
     */
    public function __construct()
	{
        $this->security = new Security();
        $this->render = new Render();
        $this->format = new Format();

        self::$path_language = ( Format::check_path_admin() ) ? PATH_ADMINISTRATOR_LANGUAGE : PATH_LANGUAGE;

        $this->check_lang();
        $this->change_lang();
	}

    /**
	 * Verifica el lenguaje establecido.
     *
     * @return  void
     */
     public function check_lang()
     {
         $lang_default = Security::DS(self::$path_language . Configuration::$lang_default . '.ini');

         if ( !file_exists($lang_default) )
             Errors::system('language_default_not_found', "File: {$lang_default}");

         if ( Session::exists_var('lang') == false )
             Session::set_value('lang', Configuration::$lang_default);

 		if ( !file_exists(Security::DS(self::$path_language . Session::get_value('lang') . '.ini')) )
             setcookie('lang', Configuration::$lang_default, time() + (86400 * 30), "/");
     }

    /**
	 * Obtiene el lenguaje establecido.
     *
     * @static
     *
     * @param   string    $buffer    Buffer pre-cargado.
     * @param   string    $section   Establece que seccion del lenguaje usar.
     * @param   string    $path      Establece una ruta personalizada.
     *
     * @return  string
     */
    public static function get_lang( $buffer, $section = false, $path = false )
	{
        if ( $section == false )
            $section = 'General';

        $format = new Format();

        if ( $path != false )
            $ini = $format->import_file($path, Session::get_value('lang'), 'ini');
        else
            $ini = $format->import_file(self::$path_language, Session::get_value('lang'), 'ini');

		foreach ( $ini[$section] as $key => $value )
		{
			if ( Configuration::$debug_lang === false )
				$buffer = str_replace('{$lang.' . $key . '}', $value, $buffer);
			else
				$buffer = str_replace('{$lang.' . $key . '}', '{$lang.' . $key . '}', $buffer);
		}

		return $buffer;
	}

    /**
	 * Cambia el lenguaje.
     *
     * @return  void
     */
    private function change_lang()
	{
		if ( isset($_GET['lang']) && !empty($_GET['lang']) )
		{
            Session::unset_value('lang');

            Session::set_value('lang', $_GET['lang']);
			setcookie('lang', $_GET['lang'], time() + (86400 * 30), "/");

			$ref = isset ($_GET['ref']) ? $_GET['ref'] : '';

            if ( base64_encode(base64_decode($ref, true)) === $ref )
                $ref = base64_decode($ref);

            if ( empty($ref) )
            {
                $base = $_SERVER['REQUEST_URI'];
                $base = $this->render->replace(['?lang=' . $_GET['lang'] => ''], $base);
            }
            else
                $base = $ref;

			header("Location: {$this->security->protocol()}{$_SERVER['HTTP_HOST']}:{$_SERVER['SERVER_PORT']}{$base}");
		}
	}

    /**
	 * Obtiene la url para cambiar el lenguaje.
     *
     * @static
     *
     * @param   string    $lang    Lenguaje que desea cambiar.
     *
     * @return  string
     */
    public static function get_lang_url( $lang )
	{
		return "lang={$lang}&ref=" . base64_encode($_SERVER['REQUEST_URI']);
	}
}
