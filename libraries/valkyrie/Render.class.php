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

class Render
{
    /**
     *
     * @var object
     */
    private $format;

    /**
	 * Constructor.
     *
     * @return  void
     */
    public function __construct()
	{
        $this->format = new Format();
	}

    /**
	 * Remplaza los placeholders
     *
     * @param   string    $buffer   Buffer pre-cargado.
     *
     * @return  string
     */
    public function placeholders( $buffer )
    {
        $replace = [
            '{$vkye_lang}'       => Session::get_value('lang'),
            '{$vkye_title}'      => Language::get_lang(_title, 'Titles'),
            '{$vkye_webpage}'    => Configuration::$web_page,
            '{$vkye_domain}'     => Security::protocol() . Configuration::$domain,
            '{$vkye_base}'       => $this->format->baseurl()
        ];

        return Format::replace($replace, $buffer);
    }

    /**
	 * Remplaza los paths.
     *
     * @param   string    $buffer   Buffer pre-cargado.
     *
     * @return  string
     */
    public function paths( $buffer )
    {
        $path = ( Format::check_path_admin() ) ? PATH_ADMINISTRATOR_INCLUDES : PATH_INCLUDES;
        $path = Security::DS("{$path}paths.ini");

        $ini = parse_ini_file($path);

        foreach ( $ini as $key => $value )
            $buffer = str_replace('{$path.' . $key . '}', $value, $buffer);

        return $buffer;
    }
}
