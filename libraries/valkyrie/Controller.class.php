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

class Controller
{
    /**
     *
     * @var object
     */
    public $view;

    /**
     *
     * @var object
     */
    public $security;

    /**
     *
     * @var object
     */
	public $format;

    /**
     *
     * @var object
     */
	public $module;

    /**
     *
     * @var object
     */
	public $component;

    /**
     *
     * @var object
     */
    public $system;

    /**
     *
     * @var object
     */
    public $model;

    /**
     * Guarda el lenguaje establecido.
     *
     * @var string
     */
    public $_lang;

    /**
     * Constructor.
     *
     * @return  void
     */
    public function __construct()
	{
        $this->view      = new View();
        $this->security  = new Security();
		$this->format  	 = new Format();
		$this->module 	 = new Modules();
		$this->component = new Components();

        $this->_lang = Session::get_value('lang');

        if ( Format::check_path_admin() )
            $this->system = new System();

        $this->load_model();
	}

    /**
     * Importa el modelo de un controlador, componente o modulo.
     *
     * @param    object    $class    Clase del controlador principal.
     * @param    string    $type     Tipo de modelo, componente, modulo o general.
     * @param    string    $name     Nombre del componente o modulo.
     *
     * @return   void
     */
    public function load_model( $class = false, $type = false, $name = false )
	{
        $class = ( $class === false ) ? $this : $class;

		$model = str_replace(CONTROLLER_PHP, '', get_class($class)) . MODEL_PHP;

        $paths['components'] = ( Format::check_path_admin() ) ? PATH_ADMINISTRATOR_COMPONENTS : PATH_COMPONENTS ;
        $paths['modules'] = ( Format::check_path_admin() ) ? PATH_ADMINISTRATOR_MODULES : PATH_MODULES ;
        $paths['models'] = ( Format::check_path_admin() ) ? PATH_ADMINISTRATOR_MODELS : PATH_MODELS ;

        switch ( $type )
        {
            case 'component':
                $path = "{$paths['components']}com_{$name}/models/{$model}.php";
                break;

            case 'module':
                $path = "{$paths['modules']}mod_{$name}/models/{$model}.php";
                break;

            default:
                $path = "{$paths['models']}{$model}.php";
                break;
        }

        $path = Security::DS($path);

		if ( file_exists($path) )
		{
			require_once $path;

			$this->model = new $model();
		}
        else
        {
            if ( Configuration::$debug === true && $type === 'component' || $type === 'module' )
                Errors::system('model_does_exists', $path);
        }
	}
}
