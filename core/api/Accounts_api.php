<?php

class Accounts_api extends Model
{
    public function get($params)
    {
        if (Api_vkye::access_permission($params[0], $params[1]) == true)
        {
            if (!empty($params[2]))
            {
                $query = Functions::get_json_decoded_query($this->database->select('accounts', [
                    'id',
                    'name',
                    'zaviapms'
                ], [
                    'AND' => [
                        'id' => $params[2],
                        'status' => true
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
                $query = Functions::get_json_decoded_query($this->database->select('accounts', [
                    'id',
                    'name',
                    'zaviapms'
                ], [
                    'status' => true
                ]));

                if (!empty($query))
                {
                    foreach ($query as $key => $value)
                    {
                        if ($value['zaviapms']['status'] == false)
                            unset($query[$key]);
                        else
                            unset($query[$key]['zaviapms']);
                    }

                    return $query;
                }
                else
                    return 'No se encontraron registros';
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
