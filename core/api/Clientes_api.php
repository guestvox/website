<?php

class Clientes_api extends Model
{
    public function get( $params )
    {
        if ( isset($params[0]) )
        {
            return [
                'cliente' => 'John Smith',
                'Edad' => '20 años'
            ];
        }
        else
        {
            return [
                [
                    'cliente' => 'John Smith',
                    'Edad' => '20 años'
                ],
                [
                    'cliente' => 'Alberto Rojas',
                    'Edad' => '30 años'
                ],
                [
                    'cliente' => 'Perez Jurado',
                    'Edad' => '55 años'
                ]
            ];
        }
    }

    public function insert( $params )
    {
        print_r($_POST);
        return "Se inserto el cliente {$params[0]} correctamente";
    }

    public function update( $params )
    {
        print_r($_REQUEST);
        return "Se actualizo el cliente {$params[0]} correctamente";
    }

    public function delete( $params )
    {
        print_r($_REQUEST);
        return "Se elimino el cliente {$params[0]} correctamente";
    }
}
