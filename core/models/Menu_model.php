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
                'currency',
                'status'
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
                'image',
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
            'image' => !empty($data['image']['name']) ? Functions::uploader($data['image']) : null,
            'description' => json_encode([
                'es' => $data['description_es'],
                'en' => $data['description_en']
            ]),
            'status' => true
        ]);

        return $query;
    }

    public function edit_menu($data)
    {
        $query = null;

        $edited = $this->database->select('menu', [
            'image'
        ], [
            'id' => $data['id']
        ]);

        if (!empty($edited))
        {
            $query = $this->database->update('menu', [
                'name' => json_encode([
                    'es' => $data['name_es'],
                    'en' => $data['name_en']
                ]),
                'price' => $data['price'],
                'currency' => $data['currency'],
                'image' => !empty($data['image']['name']) ? Functions::uploader($data['image']) : $edited[0]['image'],
                'description' => json_encode([
                    'es' => $data['description_es'],
                    'en' => $data['description_en']
                ])
            ], [
                'id' => $data['id']
            ]);

            if (!empty($query) AND !empty($data['image']['name']) AND !empty($edited[0]['image']))
                Functions::undoloader($edited[0]['image']);
        }

        return $query;
    }

    public function deactive_menu($id)
    {
        $query = $this->database->update('menu', [
            'status' => false
        ], [
            'id' => $id
        ]);

        return $query;
    }

    public function active_menu($id)
    {
        $query = $this->database->update('menu', [
            'status' => true
        ], [
            'id' => $id
        ]);

        return $query;
    }

    public function delete_menu($id)
    {
        $query = null;

        $deleted = $this->database->select('menu', [
            'image'
        ], [
            'id' => $id
        ]);

        if (!empty($deleted))
        {
            $query = $this->database->delete('menu', [
                'id' => $id
            ]);

            if (!empty($query) AND !empty($deleted[0]['image']))
                Functions::undoloader($deleted[0]['image']);
        }

        return $query;
    }
}
