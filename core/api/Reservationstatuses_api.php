<?php

class Reservationstatuses_api extends Model
{
    public function get($params)
    {
        if (!empty($params[0]))
        {
            if (!empty($params[1]))
            {
                $query = Functions::get_json_decoded_query($this->database->select('reservation_statuses', [
                    '[>]accounts' => [
                        'account' => 'id'
                    ]
                ], [
                    'reservation_statuses.id',
                    'reservation_statuses.name',
                    'accounts.zaviapms'
                ], [
                    'reservation_statuses.id' => $params[1]
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
                $query = Functions::get_json_decoded_query($this->database->select('reservation_statuses', [
                    '[>]accounts' => [
                        'account' => 'id'
                    ]
                ], [
                    'reservation_statuses.id',
                    'reservation_statuses.name',
                    'accounts.zaviapms'
                ], [
                    'reservation_statuses.account' => $params[0]
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
