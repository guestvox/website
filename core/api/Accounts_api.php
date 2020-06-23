<?php

class Accounts_api extends Model
{
    public function get($params)
    {
        if (!empty($params[0]))
        {
            $query = Functions::get_json_decoded_query($this->database->select('accounts', [
                'id',
                'name',
                'zaviapms'
            ], [
                'AND' => [
                    'id' => $params[0],
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

            foreach ($query as $key => $value)
            {
                if ($value['zaviapms']['status'] == false)
                    unset($query[$key]);
                else
                    unset($query[$key]['zaviapms']);
            }

            return !empty($query) ? $query : 'No se encontraron registros';
        }
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
