<?php

defined('_EXEC') or die;

class Crypted
{
    private $key;
    private $iv;
    private $database;

    public function __construct()
    {
        $this->database = new Medoo;

        // $iv = $this->database->select('settings', 'private_key', [
        //     'account' => Session::get_value('account')['id']
        // ]);
        //
        // if (isset($iv[0]) && !empty($iv[0])) :
        //     $this->iv = $iv[0];
        // else :
            $this->iv = 'OvX7WsT*^Ji35si,rEnFi8jrn(x9tHN3?.e3}]q0u)!D<GG9d~B(@7N5LE<psQgs:Mz-WJbRgm4!)pYiHPBGjZ#tnEFiZ0Cd)rc:uJNj(]_rZtHY0<:XkacT/!p|oV[7';
        // endif;

        $this->key = Configuration::$secret;
    }

    public function encrypt($string)
    {
        $result = "";

        for ($i = 0; $i < strlen($string); $i++)
        {
            $char       = substr($string, $i, 1);
            $keychar    = substr($this->key, ($i % strlen($this->key))-1, 1);
            $char       = chr(ord($char)+ord($keychar));
            $result    .= $char;
        }

        return base64_encode($result);
    }

    public function decrypt($string)
    {
        $result = '';
        $string = base64_decode($string);

        for ($i = 0; $i < strlen($string); $i++)
        {
            $char       = substr($string, $i, 1);
            $keychar    = substr($this->key, ($i % strlen($this->key))-1, 1);
            $char       = chr(ord($char)-ord($keychar));
            $result    .= $char;
        }

        return $result;
    }

    public function openssl($action = 'encrypt', $string = false)
    {
        $action = trim($action);
        $output = false;

        $encrypt_method = 'AES-256-CBC';

        $secret_key = hash('sha256', $this->key);
        $secret_iv = substr(hash('sha256', $this->iv), 0, 16);

        if ($action && ($action == 'encrypt' || $action == 'decrypt') && $string)
        {
            $string = trim(strval($string));

            if ($action == 'encrypt')
                $output = openssl_encrypt($string, $encrypt_method, $secret_key, 0, $secret_iv);

            if ($action == 'decrypt')
                $output = openssl_decrypt($string, $encrypt_method, $secret_key, 0, $secret_iv);
        };

        return $output;
    }
}
