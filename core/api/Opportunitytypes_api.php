<?php

class Opportunitytypes_api extends Model
{
    public function get($params)
    {
        if (!empty($params[0]))
        {
            if (!empty($params[1]))
            {
                if (!empty($params[2]))
                {
                    $query = Functions::get_json_decoded_query($this->database->select('opportunity_types', [
                        '[>]accounts' => [
                            'account' => 'id'
                        ]
                    ], [
                        'opportunity_types.id',
                        'opportunity_types.name',
                        'accounts.zaviapms'
                    ], [
                        'opportunity_types.id' => $params[2]
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
                    $query = Functions::get_json_decoded_query($this->database->select('opportunity_types', [
                        '[>]accounts' => [
                            'account' => 'id'
                        ]
                    ], [
                        'opportunity_types.id',
                        'opportunity_types.name',
                        'accounts.zaviapms'
                    ], [
                        'AND' => [
                            'opportunity_types.account' => $params[0],
                            'opportunity_types.opportunity_area' => $params[1]
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
                return 'Área de oportunidad no establecida';
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
