<?php

defined('_EXEC') or die;

require PATH_MY_LIBRARIES . 'phpmailer/Exception.php';
require PATH_MY_LIBRARIES . 'phpmailer/PHPMailer.php';
require PATH_MY_LIBRARIES . 'phpmailer/SMTP.php';
require PATH_MY_LIBRARIES . 'phpmailer/OAuth.php';

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
}
