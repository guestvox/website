<?php

defined('_EXEC') or die;

class Api_vkye
{
    public function __construct()
    {
        header('Content-type: application/json');
        header("Access-Control-Allow-Origin: *");
    }

    public function main( $params )
    {
        if ( isset($params[0]) )
        {
            $call_api = ucwords($params[0] . "_api");

            $path = Security::DS(PATH_CORE . "api/" . $call_api . ".php");

            if ( file_exists( $path ) )
            {
                require_once $path;

                $class = new $call_api();
                $_params = [];

                switch ( $_SERVER['REQUEST_METHOD'] )
                {
                    case "GET": // Consult
                        $method = "GET";
                        break;

                    case "POST": // Insert
                        $method = "INSERT";
                        $_POST = ( file_get_contents("php://input") ) ? json_decode(file_get_contents("php://input"), true) : $_POST;
                        break;

                    case "PUT": // Update
                        $method = "UPDATE";
                        $_REQUEST = [];
                        $this->parse_raw_http_request($_REQUEST);
                        break;

                    case "DELETE": // Delete
                        $method = "DELETE";
                        $_REQUEST = [];
                        $this->parse_raw_http_request($_REQUEST);
                        break;

                    default: // Unknown
                        $method = "UNKNOWN";
                        break;
                }

                unset($params[0]);
                foreach ( $params as $value )
                    $_params[] = $value;

                if ( isset($method) && method_exists($class, strtolower($method)) )
                {
                    $response = $class->{$method}( $_params );
                    $this->response($response);
                }
                else
                    $this->response(false, 405, "No se permite este metodo de consulta en esta api.");
            }
            else
                $this->response(false, 400, "Error, no se encuentra la api solicitada.");
        }
        else
            $this->response(false, 400, "Error, no se solicito ninguna api.");
    }

    private function response ( $data = "", $code = 200, $status = "OK", $message = "" )
    {
        http_response_code( $code );

        $argv = [
            "status" => $status
        ];

        if ( !empty( $data ) )
            $argv['data'] = $data;

        if ( !empty( $message ) )
            $argv['message'] = $message;

        echo json_encode($argv, JSON_PRETTY_PRINT);
    }

    private function parse_raw_http_request(array &$a_data)
    {
        // read incoming data
        $input = file_get_contents('php://input');

        // grab multipart boundary from content type header
        preg_match('/boundary=(.*)$/', $_SERVER['CONTENT_TYPE'], $matches);
        $boundary = $matches[1];

        // split content by boundary and get rid of last -- element
        $a_blocks = preg_split("/-+$boundary/", $input);
        array_pop($a_blocks);

        // loop data blocks
        foreach ($a_blocks as $id => $block)
        {
            if (empty($block))
                continue;

            // you'll have to var_dump $block to understand this and maybe replace \n or \r with a visibile char

            // parse uploaded files
            if (strpos($block, 'application/octet-stream') !== FALSE)
            {
                // match "name", then everything after "stream" (optional) except for prepending newlines
                preg_match("/name=\"([^\"]*)\".*stream[\n|\r]+([^\n\r].*)?$/s", $block, $matches);
            }

            // parse all other fields
            else
            {
                // match "name" and optional value in between newline sequences
                preg_match('/name=\"([^\"]*)\"[\n|\r]+([^\n\r].*)?\r$/s', $block, $matches);
            }

            $a_data[$matches[1]] = $matches[2];
        }
    }
}
