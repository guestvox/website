<?php

class Users_api extends Model
{
    public function get($params)
    {
        if (Api_vkye::check_access($params[0], $params[1]) == true)
        {
            if (!empty($params[2]))
            {
                if (!empty($params[3]))
                {
                    $query = Functions::get_json_decoded_query($this->database->select('users', [
                        '[>]accounts' => [
                            'account' => 'id'
                        ]
                    ], [
                        'users.id',
                        'users.firstname',
                        'users.lastname',
                        'users.email',
                        'users.phone',
                        'users.avatar',
                        'users.username',
                        'accounts.zaviapms'
                    ], [
                        'AND' => [
                            'users.id' => $params[3],
                            'users.status' => true
                        ]
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
                    $query = Functions::get_json_decoded_query($this->database->select('users', [
                        '[>]accounts' => [
                            'account' => 'id'
                        ]
                    ], [
                        'users.id',
                        'users.firstname',
                        'users.lastname',
                        'users.email',
                        'users.phone',
                        'users.avatar',
                        'users.username',
                        'accounts.zaviapms'
                    ], [
                        'AND' => [
                            'users.account' => $params[2],
                            'users.status' => true
                        ]
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
