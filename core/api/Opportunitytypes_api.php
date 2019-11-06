<?php

class Opportunitytypes_api extends Model
{
    private $table;

    public function __construct()
	{
		parent::__construct();

		$this->table = 'opportunity_types';
	}

    public function get($params)
    {
        if (Api_vkye::check_access($params[0], $params[1]) == true)
        {
            $fields = [
                'id',
                'account',
                'opportunity_area',
                'name'
            ];

            if (!empty($params[2]))
            {
                if (!empty($params[3]))
                {
                    $query = Functions::get_json_decoded_query($this->database->select($this->table, $fields, [
                        'AND' => [
                            'id' => $params[3],
                            'account' => $params[2]
                        ]
                    ]));
                }
                else
                {
                    $query = Functions::get_json_decoded_query($this->database->select($this->table, $fields, [
                        'account' => $params[2]
                    ]));
                }
            }
            else
                $query = Functions::get_json_decoded_query($this->database->select($this->table, $fields));

            return !empty($query) ? (!empty($params[3]) ? $query[0] : $query) : 'No se encontraron registros';
        }
        else
            return 'Usuario o contraseña no válido';
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