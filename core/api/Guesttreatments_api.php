<?php

class Guesttreatments_api extends Model
{
    public function get($params)
    {
        if (Api_vkye::check_access($params[0], $params[1]) == true)
        {
            if (!empty($params[2]))
            {
                if (!empty($params[3]))
                {
                    $query = $this->database->select('guest_treatments', [
                        '[>]accounts' => [
                            'account' => 'id'
                        ]
                    ], [
                        'guest_treatments.id',
                        'guest_treatments.name'
                    ], [
                        'AND' => [
                            'guest_treatments.id' => $params[3],
                            'accounts.zav' => true
                        ]
                    ]);

                    return !empty($query) ? $query[0] : 'No se encontraron registros';
                }
                else
                {
                    $query = $this->database->select('guest_treatments', [
                        '[>]accounts' => [
                            'account' => 'id'
                        ]
                    ], [
                        'guest_treatments.id',
                        'guest_treatments.name'
                    ], [
                        'AND' => [
                            'guest_treatments.account' => $params[2],
                            'accounts.zav' => true
                        ]
                    ]);

                    return !empty($query) ? $query : 'No se encontraron registros';
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
