<?php

class Opportunitytypes_api extends Model
{
    public function get($params)
    {
        if (Api_vkye::check_access($params[0], $params[1]) == true)
        {
            if (!empty($params[2]))
            {
                if (!empty($params[3]))
                {
                    $query = Functions::get_json_decoded_query($this->database->select('opportunity_types', [
                        '[>]settings' => [
                            'account' => 'account'
                        ]
                    ], [
                        'opportunity_types.id',
                        'opportunity_types.account',
                        'opportunity_types.opportunity_area',
                        'opportunity_types.name',
                    ], [
                        'AND' => [
                            'opportunity_types.id' => $params[3],
                            'opportunity_types.account' => $params[2],
                            'settings.zv' => true
                        ]
                    ]));

                    return !empty($query) ? $query[0] : 'No se encontraron registros';
                }
                else
                {
                    $query = Functions::get_json_decoded_query($this->database->select('opportunity_types', [
                        '[>]settings' => [
                            'account' => 'account'
                        ]
                    ], [
                        'opportunity_types.id',
                        'opportunity_types.account',
                        'opportunity_types.opportunity_area',
                        'opportunity_types.name',
                    ], [
                        'AND' => [
                            'opportunity_types.account' => $params[2],
                            'settings.zv' => true
                        ]
                    ]));

                    return !empty($query) ? $query : 'No se encontraron registros';
                }
            }
            else
                return 'Cuenta no definida';
        }
        else
            return 'Usuario o contraseña no válidos';
    }

    public function insert($params)
    {
        return 'Ok';
    }

    public function update($params)
    {
        return 'Ok';
    }

    public function delete($params)
    {
        return 'Ok';
    }
}
