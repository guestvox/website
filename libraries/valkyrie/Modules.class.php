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

class Modules
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
    private $format;

    /**
	 * Constructor.
     *
     * @return  void
     */
    public function __construct()
    {
        $this->security = new Security();
        $this->format = new Format();
    }

    /**
	 * Pre-carga un modulo.
     *
     * @param   string    $module    Nombre del modulo.
     *
     * @return  mixed
     */
    public function load_module( $module = false )
    {
        $module = "mod_{$module}";

        $route = ( Format::check_path_admin() ) ? PATH_ADMINISTRATOR_MODULES : PATH_MODULES;
        $route = Security::DS("{$route}{$module}/handler.php");

        if ( !file_exists($route) )
            Errors::system('modules_not_valid', " - {$module}");
        else
            return $this->format->get_file( $route );
    }

}
