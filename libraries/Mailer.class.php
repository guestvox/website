<?php

defined('_EXEC') or die;

require PATH_COMPONENTS . 'phpmailer/Exception.php';
require PATH_COMPONENTS . 'phpmailer/PHPMailer.php';
require PATH_COMPONENTS . 'phpmailer/SMTP.php';
require PATH_COMPONENTS . 'phpmailer/OAuth.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

class Mailer extends PHPMailer
{
    public function __construct($exceptions = null)
    {
        parent::__construct($exceptions);

        $this->isSMTP();
        $this->Host = Configuration::$smtp_host;
        $this->SMTPAuth = true;
        $this->Username = Configuration::$smtp_user;
        $this->Password = Configuration::$smtp_pass;
        $this->SMTPSecure = Configuration::$smtp_secure;
        $this->Port = Configuration::$smtp_port;
        $this->CharSet = 'UTF-8';
    }

    static public function lang($key, $subkey = null)
    {
        $langs = [
            'thanks_signup' => [
                'es' => 'Gracias por registrarte',
                'en' => 'Thanks for signup'
            ],
            'active_account' => [
                'es' => 'Activar mi cuenta',
                'en' => 'Active my account'
            ],
            'validate_email' => [
                'es' => 'Validar mi correo electrónico',
                'en' => 'Validate my email'
            ],
            'terms_and_conditions' => [
                'es' => 'Términos y condiciones',
                'en' => 'Terms and conditions'
            ],
            'activated_subject' => [
                'account' => [
                    'es' => 'Tu cuenta ha sido activada',
                    'en' => 'Your account has been activated'
                ],
                'user' => [
                    'es' => 'Tu usuario ha sido activado',
                    'en' => 'Your user has been activated'
                ]
            ],
            'activated_text' => [
                'account' => [
                    'es' => '¡Muchas gracias! Hemos activado tu cuenta correctamente. Ahora ya puedes iniciar sesión y empezar a configurar tu cuenta ¡Bienvenido a Guestvox!',
                    'en' => '¡Thank you! We have activated your account correctly. Now you can log in and start configuring your account ¡Welcome to Guestvox!'
                ],
                'user' => [
                    'es' => '¡Muchas gracias! Hemos activado tu usuario correctamente. Ahora ya puedes iniciar sesión y empezar a trabajar con tu equipo ¡Bienvenido a Guestvox!',
                    'en' => '¡Thank you! We have activated your user correctly. Now you can log in and start working with your team ¡Welcome to Guestvox!'
                ]
            ],
            'login' => [
                'es' => 'Iniciar sesión',
                'en' => 'Login'
            ],
            'download_file' => [
                'es' => 'Descargar archivo',
                'en' => 'Download file'
            ],
            'new' => [
                'request' => [
                    'es' => 'Nueva petición',
                    'en' => 'New request'
                ],
                'incident' => [
                    'es' => 'Nueva incidencia',
                    'en' => 'New incident'
                ],
                'workorder' => [
                    'es' => 'Nueva orden de trabajo',
                    'en' => 'New workorder'
                ]
            ],
            'commented_vox' => [
                'es' => 'Vox comentado',
                'en' => 'Commented vox'
            ],
            'completed_vox' => [
                'es' => 'Vox completado',
                'en' => 'Completed vox'
            ],
            'reopened_vox' => [
                'es' => 'Vox reabierto',
                'en' => 'Reopened vox'
            ],
            'edited_vox' => [
                'es' => 'Vox editado',
                'en' => 'Edited vox'
            ],
            'token' => [
                'es' => 'Token',
                'en' => 'Token'
            ],
            'owner' => [
                'es' => 'Propietario',
                'en' => 'Owner'
            ],
            'opportunity_area' => [
                'es' => 'Área de oportunidad',
                'en' => 'Opportunity area'
            ],
            'opportunity_type' => [
                'es' => 'Tipo de oportunidad',
                'en' => 'Opportunity type'
            ],
            'started_date' => [
                'es' => 'Fecha de inicio',
                'en' => 'Started date'
            ],
            'started_hour' => [
                'es' => 'Hora de inicio',
                'en' => 'Started hour'
            ],
            'location' => [
                'es' => 'Ubicación',
                'en' => 'Location'
            ],
            'urgency' => [
                'es' => 'Urgencia',
                'en' => 'Urgency'
            ],
            'low' => [
                'es' => 'Baja',
                'en' => 'Low'
            ],
            'medium' => [
                'es' => 'Media',
                'en' => 'Medium'
            ],
            'high' => [
                'es' => 'Alta',
                'en' => 'High'
            ],
            'observations' => [
                'es' => 'Observaciones',
                'en' => 'Observations'
            ],
            'confidentiality' => [
                'es' => 'Confidencialidad',
                'en' => 'Confidentiality'
            ],
            'yes' => [
                'es' => 'Si',
                'en' => 'Yes'
            ],
            'not' => [
                'es' => 'No',
                'en' => 'Not'
            ],
            'subject' => [
                'es' => 'Asunto',
                'en' => 'Subject'
            ],
            'empty' => [
                'es' => 'Vacío',
                'en' => 'Empty'
            ],
            'give_follow_up' => [
                'es' => 'Dar seguimiento',
                'en' => 'Give follow up'
            ],
            'view_details' => [
                'es' => 'Ver detalles',
                'en' => 'View details'
            ]
        ];

        return !empty($subkey) ? $langs[$key][$subkey] : $langs[$key];
    }
}
