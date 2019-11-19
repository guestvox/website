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
                    if (!empty($params[4]))
                    {
                        $query = Functions::get_json_decoded_query($this->database->select('opportunity_types', [
                            '[>]accounts' => [
                                'account' => 'id'
                            ]
                        ], [
                            'opportunity_types.id',
                            'opportunity_types.name'
                        ], [
                            'AND' => [
                                'opportunity_types.id' => $params[4],
                                'accounts.zav' => true
                            ]
                        ]));

                        return !empty($query) ? $query[0] : 'No se encontraron registros';
                    }
                    else
                    {
                        $query = Functions::get_json_decoded_query($this->database->select('opportunity_types', [
                            '[>]accounts' => [
                                'account' => 'id'
                            ]
                        ], [
                            'opportunity_types.id',
                            'opportunity_types.name'
                        ], [
                            'AND' => [
                                'opportunity_types.opportunity_area' => $params[3],
                                'accounts.zav' => true
                            ]
                        ]));

                        return !empty($query) ? $query : 'No se encontraron registros';
                    }
                }
                else
                    return 'Área de oportunidad relacionada no definida';
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
