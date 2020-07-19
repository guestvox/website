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

class Components
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
     * Pre-carga un componente.
     *
     * @param   string    $component    Nombre del componente.
     *
     * @return  mixed
     */
    public function load_component( $component = false )
    {
        $component = 'com_' . $component;

        $route = ( Format::check_path_admin() ) ? PATH_ADMINISTRATOR_COMPONENTS : PATH_COMPONENTS;
        $route = Security::DS("{$route}{$component}/handler.php");

        if ( !file_exists($route) )
            Errors::system('component_not_valid', " - {$component}");
        else
            return $this->format->get_file( $route );
    }
}
