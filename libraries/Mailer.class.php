<?php

defined('_EXEC') or die;

require Security::DS(PATH_MY_LIBRARIES . 'PHPMailer/src/Exception.php');
require Security::DS(PATH_MY_LIBRARIES . 'PHPMailer/src/PHPMailer.php');
require Security::DS(PATH_MY_LIBRARIES . 'PHPMailer/src/SMTP.php');
require Security::DS(PATH_MY_LIBRARIES . 'PHPMailer/src/OAuth.php');

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

class Mailer extends PHPMailer
{
    public function __construct($exceptions = null)
    {
        parent::__construct($exceptions);

        $this->SMTPOptions = [
            'ssl' => [
                'verify_peer' => false,
                'verify_peer_name' => false,
                'allow_self_signed' => true
            ]
        ];

        $this->isSMTP();
        $this->isHTML(true);
        $this->Host = Configuration::$smtp_host;
        $this->SMTPAuth = true;
        $this->Username = Configuration::$smtp_user;
        $this->Password = Configuration::$smtp_pass;
        $this->SMTPSecure = Configuration::$smtp_secure;
        $this->Port = Configuration::$smtp_port;
        $this->AltBody = '';
        $this->CharSet = 'UTF-8';
    }
}
