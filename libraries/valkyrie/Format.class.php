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

class Format
{
	/**
     *
     * @var object
     */
	private $security;

	/**
     * Constructor.
     *
     * @return  void
     */
	public function __construct()
	{
		$this->security = new Security();
	}

	/**
     * Establece la zona horaria.
     *
	 * @static
	 *
     * @return  void
     */
	public static function set_time_zone()
	{
		date_default_timezone_set(Configuration::$time_zone);
	}

	/**
     * Obtiene la fecha y hora del servidor.
     *
	 * @static
	 *
     * @return  string
     */
	public static function get_date_hour()
	{
		self::set_time_zone();
		return date('Y-m-d H:i:s', time());
	}

	/**
	 * Verifica si el path es del administrador.
	 *
	 * @static
	 *
	 * @return  boolean
	 */
	public static function check_path_admin()
	{
		$cwd = Security::DS(getcwd());
		$path_administrator = Security::DS(PATH_ADMINISTRATOR);

		return ( $cwd == $path_administrator ) ? true : false;
	}

	/**
	 * Obtiene la base de la URL.
	 *
	 * @return  string
	 */
	public function baseurl()
	{
		$uri = $_SERVER['HTTP_HOST'] . $_SERVER['SCRIPT_NAME'];
        $uri = str_replace('index.php', '', $uri);

        return Security::protocol() . $uri;
	}

	/**
	 * Verifica si existe una peticion AJAX.
	 *
	 * @return  boolean
	 */
	public static function exist_ajax_request()
	{
		return ( !empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest' ) ? true : false;
	}

	/**
	 * No permitir peticiones por AJAX.
	 *
	 * @return  void
	 */
	public static function no_ajax()
	{
		if ( self::exist_ajax_request() )
			die();
	}

	/**
	 * Remplaza en un string, los key por los valores de un array.
	 *
	 * @static
	 *
	 * @param	array    $arr    Arreglo a remplazar las llaves por los valores.
	 * @param	string   $string Cadena donde se remplazara.
	 *
	 * @return  string
	 */
	public static function replace( $arr, $string )
    {
        return str_replace(array_keys($arr), array_values($arr), $string);
    }

	/**
	 * Remplaza la llamada de un fichero, por el fichero.
	 *
	 * @param	string    $buffer    Buffer pre-cargado.
	 * @param	string	  $name_file Nombre del fichero solicitado.
	 * @param	string	  $path		 Ruta del fichero.
	 *
	 * @return  mixed
	 */
	public function include_file( $buffer = false, $name_file = false, $path = false )
	{
		if ( $buffer == false || $name_file == false )
			return null;

		if ( $path == false )
			$path = ( self::check_path_admin() ) ? PATH_ADMINISTRATOR_LAYOUTS : PATH_LAYOUTS;

		$route = Security::DS("{$path}{$name_file}.php");

		if ( file_exists($route) )
		{
			ob_start();

			require_once $route;

			$new_file = ob_get_contents();

			ob_end_clean();

			return str_replace('%{' . $name_file . '}%', $new_file, $buffer);
		}
	}

	/**
	 * Obtiene un fichero.
	 *
	 * @param	string    $file    Fichero
	 *
	 * @return  mixed
	 */
	public function get_file( $file = false )
	{
		if ( $file == false )
			return null;

		$file = Security::DS($file);

		if ( file_exists($file) )
		{
			ob_start();

			require_once $file;

			$buffer = ob_get_contents();

			ob_end_clean();

			return $buffer;
		}
	}

	/**
	 * Obtiene un fichero.
	 *
	 * @param	string    $path       Directorio del fichero.
	 * @param	string	  $file_name  Nombre del fichero.
	 * @param	string	  $file_type  Tipo de fichero.
	 *
	 * @return  mixed
	 */
	public function import_file( $path, $file_name, $file_type )
	{
		$supported_file_type = ['ini','php','html','json'];

		if (in_array($file_type, $supported_file_type))
		{
			$file = Security::DS("{$path}/{$file_name}.{$file_type}");

			if ( file_exists($file) )
			{
				switch ( $file_type )
				{
					case 'ini':
						return parse_ini_file($file, true);
						break;

					case 'php':
						require_once $file;
						break;

					case 'html':
						return $this->get_file($file);
						break;

					case 'json':
						return json_decode(file_get_contents($file), true);
						break;
				}
			}
		}
	}

}
