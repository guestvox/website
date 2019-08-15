<?php
/**
 *
 * @package Valkyrie.Platform
 *
 * @since 1.0.0
 * @version 1.0.0
 * @license    You can see LICENSE.txt
 *
 * @author     David Miguel Gómez Macías < davidgomezmacias@gmail.com >
 * @copyright  Copyright (C) CodeMonkey - Platform. All Rights Reserved.
 */

define('_EXEC', 1);

if ( version_compare(PHP_VERSION, '5.4', '<') )
    die('Your host needs to use PHP 5.4 or higher to run this version of Valkyrie Platform.');

if ( !defined('_DEFINES') )
{
    define('PATH_ROOT', __DIR__);
    require_once PATH_ROOT . DIRECTORY_SEPARATOR . 'includes' . DIRECTORY_SEPARATOR . 'defines.php';
}

spl_autoload_register(function($class)
{
    if ( file_exists(PATH_LIBRARIES . $class . CLASS_PHP) )
	    require PATH_LIBRARIES . $class . CLASS_PHP;

    if ( file_exists(PATH_MY_LIBRARIES . $class . CLASS_PHP) )
	    require PATH_MY_LIBRARIES . $class . CLASS_PHP;
});

$layout = new Layout();
echo $layout->execute();
