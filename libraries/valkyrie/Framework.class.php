<?php
defined('_EXEC') or die;

/**
 *
 * @package Valkyrie.Libraries
 *
 * @since 1.0.0
 * @version 1.0.1
 * @license You can see LICENSE.txt
 *
 * @author David Miguel Gómez Macías < davidgomezmacias@gmail.com >
 * @copyright Copyright (C) CodeMonkey - Platform. All Rights Reserved.
 *
 * @todo Se actualizara el sistema para usar namespaces y permitir a las librerias ser independientes por clasificación.
 */

class Framework
{
	/**
	 * Framework.
	 *
     * @var const
     */
	const PRODUCT = 'Valkyrie Platform';

	/**
	 * Versión del release.
	 *
     * @var const
     */
	const RELEASE = '1.0.1';

	/**
	 * Estado del framework.
	 *
     * @var const
     */
	const STATUS = 'Development';

	/**
	 * Nombre de la versión.
	 *
     * @var const
     */
	const VERSION_NAME = 'Odín';

	/**
	 * Fecha del release.
	 *
     * @var const
     */
	const RELEASE_DATE = '23 Aug 18';

	/**
	 * Hora del release.
	 *
     * @var const
     */
	const RELEASE_TIME = '19:32';

	/**
	 * Zona horaria del release.
	 *
     * @var const
     */
	const RELEASE_TIME_ZONE = 'GMT';

	/**
	 * Copyright.
	 *
     * @var const
     */
	const COPYRIGHT = 'Copyright (C) CodeMonkey - Platform. All Rights Reserved.';

	/**
	 * Constructor.
     *
     * @return  void
     */
	public function __construct()
	{
		$this->file_configuration();
		$this->error_reporting(Configuration::$error_reporting);

		Session::name();
        Session::init();
		Format::set_time_zone();
	}

	/**
     * Importa el archivo de configuración.
     *
     * @return  void
     */
	private function file_configuration()
	{
		$path_configuration = Security::DS(PATH_CONFIGURATION);

		if ( !file_exists($path_configuration) || (filesize($path_configuration) < 10) )
			Errors::system('not_file_configuration');
		else
			require_once $path_configuration;
	}

	/**
     * Establece cuáles errores de PHP son notificados.
     *
	 * @param	string    $str    valor de configuración.
	 *
     * @return  integer
     */
	private function error_reporting( $str )
	{
		$case = [];

		switch ( $str )
		{
			case 'none':
			case '0':
				$case['error'] = '0';
				$case['ini'] = '0';
				break;

			case 'simple':
				$case['error'] = 'E_ERROR | E_WARNING | E_PARSE';
				$case['ini'] = '0';
				break;

			case 'maximum':
				$case['error'] = 'E_ALL';
				$case['ini'] = '1';
				break;

			case 'development':
				$case['error'] = '-1';
				$case['ini'] = '1';
				break;

			case 'default':
			case '-1':
			default:
				$case['error'] = '';
				$case['ini'] = '0';
				break;
		}

		return error_reporting($case['error']) . ini_set('display_errors', $case['ini']);
	}

}
