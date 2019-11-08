<?php

class Reservationstatus_api extends Model
{
    public function get($params)
    {
        if (Api_vkye::check_access($params[0], $params[1]) == true)
        {
            if (!empty($params[2]))
            {
                if (!empty($params[3]))
                {
                    $query = Functions::get_json_decoded_query($this->database->select('reservation_status', [
                        '[>]settings' => [
                            'account' => 'account'
                        ]
                    ], [
                        'reservation_status.id',
                        'reservation_status.name',
                    ], [
                        'AND' => [
                            'reservation_status.id' => $params[3],
                            'settings.zv' => true
                        ]
                    ]));

                    return !empty($query) ? $query[0] : 'No se encontraron registros';
                }
                else
                {
                    $query = Functions::get_json_decoded_query($this->database->select('reservation_status', [
                        '[>]settings' => [
                            'account' => 'account'
                        ]
                    ], [
                        'reservation_status.id',
                        'reservation_status.name',
                    ], [
                        'AND' => [
                            'reservation_status.account' => $params[2],
                            'settings.zv' => true
                        ]
                    ]));

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
