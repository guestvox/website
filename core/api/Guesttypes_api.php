<?php

class Guesttypes_api extends Model
{
    public function get($params)
    {
        if (Api_vkye::access_permission($params[0], $params[1]) == true)
        {
            if (!empty($params[2]))
            {
                if (!empty($params[3]))
                {
                    $query = Functions::get_json_decoded_query($this->database->select('guest_types', [
                        '[>]accounts' => [
                            'account' => 'id'
                        ]
                    ], [
                        'guest_types.id',
                        'guest_types.name',
                        'accounts.zaviapms'
                    ], [
                        'guest_types.id' => $params[3]
                    ]));

                    if (!empty($query) AND $query[0]['zaviapms']['status'] == true)
                    {
                        unset($query[0]['zaviapms']);

                        return $query[0];
                    }
                    else
                        return 'No se encontraron registros';
                }
                else
                {
                    $query = Functions::get_json_decoded_query($this->database->select('guest_types', [
                        '[>]accounts' => [
                            'account' => 'id'
                        ]
                    ], [
                        'guest_types.id',
                        'guest_types.name',
                        'accounts.zaviapms'
                    ], [
                        'guest_types.account' => $params[2]
                    ]));

                    if (!empty($query) AND $query[0]['zaviapms']['status'] == true)
                    {
                        foreach ($query as $key => $value)
                            unset($query[$key]['zaviapms']);

                        return $query;
                    }
                    else
                        return 'No se encontraron registros';
                }
            }
            else
                return 'Cuenta de uso no definida';
        }
        else
            return 'Credenciales de acceso no válidas';
    }

    public function post($params)
    {
        return 'Ok';
    }

    public function put($params)
    {
        return 'Ok';
    }

    public function delete($params)
    {
        return 'Ok';
    }
}
