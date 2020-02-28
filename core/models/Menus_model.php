<?php

defined('_EXEC') or die;

class Menus_model extends Model
{
    public function _construct()
    {
        parent::_construct();
    }

    // public function get_menus()
    // {
    //     $query = Functions::get_json_decoded_query($this->database->select('menus', [
    //         'id',
    //         'name',
    //         'price',
    //         'image',
    //         'description'
    //     ], [
    //         'account' => Session::get_value('account')['id'],
    //         'ORDER' => [
    //             'name' => 'ASC'
    //         ]
    //     ]));
    //
    //     return $query;
    // }
    //
    // public function get_menu($id)
    // {
    //     $query = Functions::get_json_decoded_query($this->database->select('menus', [
    //         'name',
    //         'price',
    //         'image',
    //         'description'
    //     ], [
    //         'id' => $id
    //     ]));
    //
    //     return !empty($query) ? $query[0] : null;
    // }

    public function new_menu($data)
    {
        $query = $this->database->insert('menus', [
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

    // public function edit_menu($data)
    // {
    //     $query = $this->database->update('menus', [
    //         'name' => json_encode([
    //             'es' => $data['name_es'],
    //             'en' => $data['name_en']
    //         ]),
    //         'price' => $data['price'],
    //         'image' => null,
    //         'description' => $data['description']
    //     ], [
    //         'id' => $data['id']
    //     ]);
    //
    //     return $query;
    // }
    //
    // public function delete_menu($id)
    // {
    //     $query = $this->database->delete('menus', [
    //         'id' => $id
    //     ]);
    //
    //     return $query;
    // }
}
