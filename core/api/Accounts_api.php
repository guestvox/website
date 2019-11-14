<?php

class Accounts_api extends Model
{
    public function get($params)
    {
        if (Api_vkye::check_access($params[0], $params[1]) == true)
        {
            if (!empty($params[2]))
            {
                $query = $this->database->select('accounts', [
                    'id',
                    'name'
                ], [
                    'AND' => [
                        'id' => $params[2],
                        'zav' => true,
                        'status' => true
                    ]
                ]);

                return !empty($query) ? $query[0] : 'No se encontraron registros';
            }
            else
            {
                $query = $this->database->select('accounts', [
                    'id',
                    'name'
                ], [
                    'AND' => [
                        'zav' => true,
                        'status' => true
                    ]
                ]);

                return !empty($query) ? $query : 'No se encontraron registros';
            }
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
