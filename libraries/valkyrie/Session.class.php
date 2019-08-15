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

class Session
{
	/**
	 * Crean el nombre de la sesion.
     *
	 * @static
	 *
	 * @param	string    $str    Nombre de la sesion.
	 *
     * @return  void
     */
	static function name( $str = 'valkyrie' )
	{
		session_name($str);
	}

	/**
	 * Inicia la sesion.
     *
	 * @static
	 *
	 * @param	array    $array    Parametros de sesion.
	 *
     * @return  void
     */
	static function init( $array = false )
	{
		if ( $array == false )
			$array = ['cookie_lifetime' => Configuration::$cookie_lifetime];

		@session_start($array);
	}

	/**
	 * Destruye la sesion.
     *
	 * @static
	 *
     * @return  void
     */
	static function destroy()
	{
		@session_destroy();
	}

	/**
	 * Obtiene una variable de sesion.
     *
	 * @static
	 *
	 * @param	string    $str    Nombre de la variable.
	 *
     * @return  void
     */
	static function get_value( $str )
	{
		return $_SESSION[$str];
	}

	/**
	 * Agrega una variable de sesion.
     *
	 * @static
	 *
	 * @param	string    $str    Nombre de la variable.
	 * @param	string    $value  Valor de la variable.
	 *
     * @return  void
     */
	static function set_value( $str, $value )
	{
		$_SESSION[$str] = $value;
	}

	/**
	 * Destruye una variable de sesion.
     *
	 * @static
	 *
	 * @param	string    $str    Nombre de la variable.
	 *
     * @return  void
     */
	static function unset_value( $str )
	{
		if (isset($_SESSION[$str]))
			unset($_SESSION[$str]);
	}

	/**
	 * Verifica si existe una variable de sesion.
     *
	 * @static
	 *
	 * @param	string    $str    Nombre de la variable.
	 *
     * @return  void
     */
	static function exists_var( $str )
	{
		return ( isset($_SESSION[$str]) && !empty($_SESSION[$str]) ) ? true : false;
	}

	/**
	 * Verifica si existe una sesion.
     *
	 * @static
	 *
     * @return  void
     */
	static function exists()
	{
		return (sizeof($_SESSION) > 0) ? true : false;
	}

	/**
	 * Crea las variables de sesion
     *
	 * @static
	 *
	 * @param	array    $arr    Contenido de las variables.
	 *
     * @return  boolean
     */
	static function create_session_login( $arr = [] )
	{
		self::set_value('_vkye_token', $arr['token']);
		self::set_value('_vkye_id_user', $arr['id_user']);
		self::set_value('_vkye_user', $arr['user']);
		self::set_value('_vkye_last_access', Format::get_date_hour());
		self::set_value('_vkye_level', $arr['level']);

		return true;
	}

}
