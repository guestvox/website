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

class Errors
{
    /**
     * Muestra los errores del framework.
     *
     * @static
     *
     * @param   string    $error    Tipo de error solicitado.
     * @param   string    $message  Mensaje personalizado.
     *
     * @return  void
     */
    public static function system( $error = false, $message = "" )
    {
        switch( $error )
        {
            case 'not_file_configuration':
                exit('{not_file_configuration}');
                break;

            case 'model_does_exists':
                echo ( Configuration::$debug ) ? "{model_does_exists} - {$message}" : "";
                break;

            case 'language_default_not_found':
                echo ( Configuration::$debug ) ? "{language_default_not_found} - {$message}" : "";
                break;

            case 'component_not_valid':
                echo ( Configuration::$debug ) ? "{component_not_valid} - {$message}" : "";
                break;

            case 'modules_not_valid':
                echo ( Configuration::$debug ) ? "{modules_not_valid} - {$message}" : "";
                break;

            default:
                echo ( Configuration::$debug ) ? "{system_error}" : "";
                break;
        }
    }

    /**
     * Crea un codigo http.
     *
     * @static
     *
     * @param   string    $error    Tipo de error http para mostrar.
     * @param   string    $message  Mensaje personalizado.
     *
     * @return  void
     */
    public static function http( $error = false, $message = "" )
    {
        $view = new View();

        switch( $error )
        {
            case '404':
                header("HTTP/1.0 404 Not Found");
                echo ( Configuration::$debug ) ? $message : $view->render('Errors','404');
                break;

            default:
                exit('Unknown http status code "' . htmlentities($error) . '"');
                break;
        }
    }
}
