<?php

class Guesttreatments_api extends Model
{
    public function get($params)
    {
        if (!empty($params[0]))
        {
            if (!empty($params[1]))
            {
                $query = Functions::get_json_decoded_query($this->database->select('guest_treatments', [
                    '[>]accounts' => [
                        'account' => 'id'
                    ]
                ], [
                    'guest_treatments.id',
                    'guest_treatments.name',
                    'accounts.zaviapms'
                ], [
                    'guest_treatments.id' => $params[1]
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
                $query = Functions::get_json_decoded_query($this->database->select('guest_treatments', [
                    '[>]accounts' => [
                        'account' => 'id'
                    ]
                ], [
                    'guest_treatments.id',
                    'guest_treatments.name',
                    'accounts.zaviapms'
                ], [
                    'guest_treatments.account' => $params[0]
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
