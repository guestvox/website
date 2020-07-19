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

class View
{
	/**
     *
     * @var object
     */
	private $dependencies;

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
		$this->dependencies = new Dependencies();
		$this->security = new Security();
		$this->format = new Format();
	}

	/**
	 * Renderiza el html
     *
	 * @param	object    $controller    Controlador principal.
	 * @param	mixed     $layouts		 Informacion de los layouts a mostrar.
	 *
     * @return  string
     */
	public function render( $controller, $layouts )
	{
		$path_layouts = ( Format::check_path_admin() ) ? PATH_ADMINISTRATOR_LAYOUTS : PATH_LAYOUTS;

		ob_start();

		if ( is_array($layouts) )
		{
			// Load Header
			if ( isset($layouts['head']['path']) && !empty($layouts['head']['path']) )
			{
				$file = Security::DS("{$layouts['head']['path']}/{$layouts['head']['file']}.php");

				if ( file_exists($file) )
					require_once $file;
				else
					require_once Security::DS("{$path_layouts}/head.php");
			}
			else
				require_once Security::DS("{$path_layouts}/head.php");

			// Load Main
			if ( isset($layouts['main']['path']) && !empty($layouts['main']['path']) )
			{
				$file = Security::DS("{$layouts['main']['path']}/{$layouts['main']['file']}.php");

				if ( file_exists($file) )
					require_once $file;
			}
			else
			{
				$controller = str_replace(CONTROLLER_PHP, '', get_class($controller));
				require_once Security::DS("{$path_layouts}/{$controller}/{$layouts['main']['file']}.php");
			}

			// Load Footer
			if ( isset($layouts['footer']['path']) && !empty($layouts['footer']['path']) )
			{
				$file = Security::DS("{$layouts['footer']['path']}/{$layouts['footer']['file']}.php");

				if ( file_exists($file) )
					require_once $file;
				else
					require_once Security::DS("{$path_layouts}/footer.php");
			}
			else
				require_once Security::DS("{$path_layouts}/footer.php");
		}
		else
		{
			require_once Security::DS("{$path_layouts}/head.php");

			if ( is_object($controller) )
				$controller = str_replace(CONTROLLER_PHP, '', get_class($controller));

			require_once Security::DS("{$path_layouts}/{$controller}/{$layouts}.php");
			require_once Security::DS("{$path_layouts}/footer.php");
		}

        $buffer = ob_get_contents();

		// Code render
		$buffer = $this->dependencies->run($buffer);

        ob_end_clean();

        return $buffer;
	}

}
