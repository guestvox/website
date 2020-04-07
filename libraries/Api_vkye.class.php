<?php

defined('_EXEC') or die;

class Api_vkye
{
    public function __construct()
    {
        header('Content-type: application/json');
        header('Access-Control-Allow-Origin: *');
    }

    public function main($params)
    {
        if (isset($params[0]))
        {
            $call_api = ucwords($params[0] . '_api');
            $path = Security::DS(PATH_CORE . 'api/' . $call_api . '.php');

            if (file_exists($path))
            {
                require_once $path;

                $class = new $call_api();
                $_params = [];

                $headers = Self::all_headers();
                $user = ( isset($headers['user']) ) ? $headers['user'] : null;
                $password = ( isset($headers['password']) ) ? $headers['password'] : null;

                if ( true )
                {
                    switch ($_SERVER['REQUEST_METHOD'])
                    {
                        case 'GET':
                            // $xml = simplexml_load_string($string, null, null, "http://schemas.xmlsoap.org/soap/envelope/");
                            $xml = simplexml_load_file('http://local.guestvox.com/soap_test.xml', null, null, "http://schemas.xmlsoap.org/soap/envelope/");
                            $xml->registerXPathNamespace('soap-env', 'http://schemas.xmlsoap.org/soap/envelope/');
                            $xml->registerXPathNamespace('wsse', 'http://docs.oasis-open.org/wss/2004/01/oasis-200401-wss-wssecurity-secext-1.0.xsd');

                            $username = $xml->xpath('/soap-env:Envelope/soap-env:Header/wsse:Security/wsse:UsernameToken/wsse:Username');
                            $password = $xml->xpath('/soap-env:Envelope/soap-env:Header/wsse:Security/wsse:UsernameToken/wsse:Password');
                            $body = $xml->xpath('/soap-env:Envelope/soap-env:Body');
                            print_R((string) $username[0]);
                            echo "\n";
                            print_R((string) $password[0]);
                            echo "\n";
                            print_R($body[0]);

                            $method = 'GET';
                            break;

                        case 'POST':
                            $method = 'POST';
                            $_POST = (file_get_contents("php://input")) ? json_decode(file_get_contents("php://input"), true) : $_POST;
                            break;

                        case 'PUT':
                            $method = 'PUT';
                            $_REQUEST = [];
                            $this->parse_raw_http_request($_REQUEST);
                            break;

                        case 'DELETE':
                            $method = 'DELETE';
                            $_REQUEST = [];
                            $this->parse_raw_http_request($_REQUEST);
                            break;

                        default:
                            $method = 'UNKNOWN';
                            break;
                    }

                    unset($params[0]);

                    foreach ($params as $value)
                        $_params[] = $value;

                    if (isset($method) && method_exists($class, strtolower($method)))
                    {
                        $response = $class->{$method}($_params);
                        $this->response($response);
                    }
                    else
                        $this->response(false, 405, 'Método de consulta no permitido');
                }
                else
                    $this->response(false, 405, 'USUARIO O CONTRASEÑA NO EXISTE');
            }
            else
                $this->response(false, 400, 'API solicitada no disponible');
        }
        else
            $this->response(false, 400, 'No se solicitó ninguna API');
    }

    private function response($data = '', $code = 200, $status = 'OK', $message = '')
    {
        http_response_code($code);

        $argv = [
            'status' => $status
        ];

        if (!empty($data))
            $argv['data'] = $data;

        if (!empty($message))
            $argv['message'] = $message;

        echo json_encode($argv, JSON_PRETTY_PRINT);
    }

    private function parse_raw_http_request(array &$a_data)
    {
        $input = file_get_contents('php://input');

        preg_match('/boundary=(.*)$/', $_SERVER['CONTENT_TYPE'], $matches);

        $boundary = $matches[1];

        $a_blocks = preg_split("/-+$boundary/", $input);

        array_pop($a_blocks);

        foreach ($a_blocks as $id => $block)
        {
            if (empty($block))
                continue;

            if (strpos($block, 'application/octet-stream') !== FALSE)
                preg_match("/name=\"([^\"]*)\".*stream[\n|\r]+([^\n\r].*)?$/s", $block, $matches);
            else
                preg_match('/name=\"([^\"]*)\"[\n|\r]+([^\n\r].*)?\r$/s', $block, $matches);

            $a_data[$matches[1]] = $matches[2];
        }
    }

    static public function all_headers() : array
    {
        $headers = [];

        foreach (getallheaders() as $name => $value) $headers[$name] = $value;

        return $headers;
    }

    static public function access_credentials($user = null)
    {
        $users = [
            'zaviapms' => 'y329-gfc=7mq}qy(',
            'siteminder' => 'V97+pf=:z4?Hm|0i'
        ];

        if (!empty($user))
        {
            if (array_key_exists($user, $users))
                return $users[$user];
            else
                return 'Error';
        }
        else
            return $users;
    }

    static public function access_permission($user, $password)
    {
        if (array_key_exists($user, Api_vkye::access_credentials()))
        {
            if (Api_vkye::access_credentials($user) == $password)
                return true;
            else
                return false;
        }
        else
            return false;
    }
}
