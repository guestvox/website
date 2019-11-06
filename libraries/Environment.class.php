<?php

defined('_EXEC') or die;

class Environment
{
    static public function print_r($arr = false)
    {
        echo '<pre>'."\n";
        print_r($arr);
        echo '</pre>'."\n\n";
    }

    static public function return($arr = false)
    {
        echo json_encode($arr, JSON_PRETTY_PRINT);
    }
}
