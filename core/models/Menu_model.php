<?php

defined('_EXEC') or die;

class Menu_model extends Model
{
    public function _construct()
    {
        parent::_construct();
    }

    public function get_menu($id = null)
    {
        if (!isset($id) OR empty($id))
        {
            $query = Functions::get_json_decoded_query($this->database->select('menu', [
                'id',
                'name',
                'price',
                'currency'
            ], [
                'account' => Session::get_value('account')['id'],
                'ORDER' => [
                    'name' => 'ASC'
                ]
            ]));

            return $query;
        }
        else
        {
            $query = Functions::get_json_decoded_query($this->database->select('menu', [
                'id',
                'name',
                'price',
                'currency',
                'description'
            ], [
                'id' => $id
            ]));

            return !empty($query) ? $query[0] : null;
        }
    }

    public function new_menu($data)
    {
        $query = $this->database->insert('menu', [
            'account' => Session::get_value('account')['id'],
            'name' => json_encode([
                'es' => $data['name_es'],
                'en' => $data['name_en']
            ]),
            'price' => $data['price'],
            'currency' => $data['currency'],
            'image' => null,
            'description' => json_encode([
                'es' => $data['description_es'],
                'en' => $data['description_en']
            ])
        ]);

        return $query;
    }

    public function edit_menu($data)
    {
        $query = $this->database->update('menu', [
            'name' => json_encode([
                'es' => $data['name_es'],
                'en' => $data['name_en']
            ]),
            'price' => $data['price'],
            'currency' => $data['currency'],
            'image' => null,
            'description' => json_encode([
                'es' => $data['description_es'],
                'en' => $data['description_en']
            ])
        ], [
            'id' => $data['id']
        ]);

        return $query;
    }

    public function delete_menu($id)
    {
        $query = $this->database->delete('menu', [
            'id' => $id
        ]);

        return $query;
    }
}
