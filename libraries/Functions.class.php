<?php

defined('_EXEC') or die;

class Functions
{
    public function __construct()
    {
        date_default_timezone_set(Configuration::$time_zone);
    }

    // ---
    // Dates
    // ---

    static public function get_current_date($format = 'Y-m-d')
    {
		return date($format);
    }

    static public function get_past_date($date, $number, $lapse, $format = 'Y-m-d')
    {
        if (!empty($date) AND !empty($number) AND !empty($lapse))
            return date($format, strtotime($date . ' - ' . $number . ' ' . $lapse));
        else
            return null;
    }

    static public function get_formatted_date($date, $format = 'Y-m-d')
    {
        if (!empty($date))
            return date($format, strtotime($date));
        else
            return null;
    }

    static public function get_current_hour($format = 'H:i:s')
    {
		return date($format, time());
    }

    static public function get_formatted_hour($hour, $format = 'H:i:s')
    {
        if (!empty($hour))
        {
            if ($format == '+ hrs')
                return $hour . ' Hrs';
            else
        	    return date($format, strtotime($hour));
        }
        else
            return null;
    }

    static public function get_current_date_hour($format = 'Y-m-d H:i:s')
    {
		return date($format, time());
    }

    static public function get_formatted_date_hour($date, $hour, $format = 'Y-m-d H:i:s')
    {
        if (!empty($date) AND !empty($hour))
        {
            if ($format == '+ hrs')
                return $date . ' ' . $hour . ' Hrs';
            else
                return date($format, strtotime($date . ' ' . $hour));
        }
        else
            return null;
    }

    static public function get_current_week()
    {
        return [date('Y-m-d', strtotime('monday this week')), date('Y-m-d', strtotime('sunday this week'))];
    }

    static public function get_current_month()
    {
        return [date('Y-m-d', strtotime('first day of this month')), date('Y-m-d', strtotime('last day of this month'))];
    }

    static public function get_current_year()
    {
		return explode('-', date('Y-m-d'))[0];
    }

    // ---
    // Currency
    // ---

    static public function get_formatted_currency($number = 0)
    {
        if (!empty($number))
            return '$ ' . number_format($number, 2, '.', ',') . ' ' . 'MXN';
        else
            return '$ 0.00 MXN';
    }

    static public function get_currency_exchange($number = 0, $currency = 'MXN')
    {
        // $api = curl_init();
        //
        // curl_setopt($api, CURLOPT_URL, 'https://xecdapi.xe.com/v1/convert_to.json/?to=USD&from=MXN&amount=2');
        // curl_setopt($api, CURLOPT_RETURNTRANSFER, true);
        // curl_setopt($api, CURLOPT_USERPWD, 'guestvox404943424:u0ebiuaaq1dd7naas6o7p3de0h');
        // curl_setopt($api, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);
        //
        // $data = Functions::get_json_decoded_query(curl_exec($api));
        //
        // curl_close($api);
        //
        // print_r($data);
        // print_r('lol');

        // $api = curl_init();
        //
        // curl_setopt($api, CURLOPT_URL, 'https://www1.oanda.com/rates/api/v2/rates/candle.json?api_key=pwHcBy1kWF7WGTRUghovx3mC&data_set=ecb&date_time=2019-07-26&base=USD&quote=MXN&fields=all');
        // curl_setopt($api, CURLOPT_RETURNTRANSFER, true);
        //
        // $data = Functions::get_json_decoded_query(curl_exec($api));
        //
        // curl_close($api);
        //
        // print_r($data);
        // print_r('lol');

        // $client =  new SoapClient(null, array(
        //     'location' => 'http://www.banxico.org.mx:80/DgieWSWeb/DgieWS?WSDL',
        //     'uri'      => 'http://DgieWSWeb/DgieWS?WSDL',
        //     'encoding' => 'ISO-8859-1',
        //     'trace'    => false
        // ));
        //
        // try
        // {
        //     $result = $client->tiposDeCambioBanxico();
        // }
        // catch (SoapFault $e)
        // {
        //     return $e->getMessage();
        // }
        //
        // if (!empty($result))
        // {
        //     $dom = new DOMDocument();
        //     $dom->loadXML($result);
        //     $xpath = new DOMXPath($dom);
        //     $xpath->registerNamespace('bm', 'http://ws.dgie.banxico.org.mx');
        //     $val = $xpath->evaluate("//*[@IDSERIE='SF60653']/*/@OBS_VALUE");
        //     // return ($val->item(0)->value);
        //     print_r($val->item(0)->value);
        // }
    }

    // ---
    // Encrypts
    // ---

    static public function get_openssl($action = 'encrypt', $string = false)
    {
        $openssl = false;
        $action = trim($action);
        $encrypt_method = 'AES-256-CBC';
        $secret_key = hash('sha256', Configuration::$secret);
        $encrypt_private_key = substr(hash('sha256', Configuration::$encrypt_private_key), 0, 16);

        if ($action && ($action == 'encrypt' || $action == 'decrypt') && $string)
        {
            $string = trim(strval($string));

            if ($action == 'encrypt')
                $openssl = openssl_encrypt($string, $encrypt_method, $secret_key, 0, $encrypt_private_key);

            if ($action == 'decrypt')
                $openssl = openssl_decrypt($string, $encrypt_method, $secret_key, 0, $encrypt_private_key);
        };

        return $openssl;
    }

    static public function get_encrypt($string)
    {
        $encrypt = '';

        for ($i = 0; $i < strlen($string); $i++)
        {
            $char = substr($string, $i, 1);
            $keychar = substr(Configuration::$secret, ($i % strlen(Configuration::$secret)) -1, 1);
            $char = chr(ord($char) + ord($keychar));
            $encrypt .= $char;
        }

        return base64_encode($encrypt);
    }

    static public function get_decrypt($string)
    {
        $decrypt = '';
        $string = base64_decode($string);

        for ($i = 0; $i < strlen($string); $i++)
        {
            $char = substr($string, $i, 1);
            $keychar = substr(Configuration::$secret, ($i % strlen(Configuration::$secret)) -1, 1);
            $char = chr(ord($char) - ord($keychar));
            $decrypt .= $char;
        }

        return $decrypt;
    }

    // ---
    // Queries
    // ---

    static public function get_json_decoded_query($query)
    {
        if (is_array($query))
        {
            foreach ($query as $key => $value)
            {
                if (is_array($query[$key]))
                {
                    foreach ($query[$key] as $subkey => $subvalue)
                        $query[$key][$subkey] = (is_array(json_decode($query[$key][$subkey], true)) AND (json_last_error() == JSON_ERROR_NONE)) ? json_decode($query[$key][$subkey], true) : $query[$key][$subkey];
                }
                else
                    $query[$key] = (is_array(json_decode($query[$key], true)) AND (json_last_error() == JSON_ERROR_NONE)) ? json_decode($query[$key], true) : $query[$key];
            }
        }
        else
            $query = (is_array(json_decode($query, true)) AND (json_last_error() == JSON_ERROR_NONE)) ? json_decode($query, true) : $query;

        return $query;
    }

    // ---
    // Checks
    // ---

    static public function check_access($user_permissions)
    {
        $access = false;

        foreach ($user_permissions as $value)
        {
            if (in_array($value, Session::get_value('user')['user_permissions']))
                $access = true;
        }

        return $access;
    }

    static public function check_email($email)
    {
        return (filter_var($email, FILTER_VALIDATE_EMAIL)) ? true : false;
    }

    // ---
    // Others
    // ---

    static public function environment($return)
    {
        echo json_encode($return, JSON_PRETTY_PRINT);
    }
}
