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

class Model
{
	/**
     *
     * @var object
     */
	public $database;

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
		$this->database  = new Medoo;
		$this->security  = new Security;
		$this->format  	 = new Format;
		$this->module 	 = new Modules;
		$this->component = new Components;

		$this->_lang = Session::get_value('lang');

		if ( Format::check_path_admin() )
            $this->system = new System();
	}

}
