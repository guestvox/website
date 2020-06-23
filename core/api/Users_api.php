<?php

class Users_api extends Model
{
    public function get($params)
    {
        if (!empty($params[0]))
        {
            if (!empty($params[1]))
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
                        'users.id' => $params[1],
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
                        'users.account' => $params[0],
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
            return 'Cuenta no establecida';
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
