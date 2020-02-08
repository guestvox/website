<?php
defined('_EXEC') or die;
class Menus_model extends Model{
public function _construct(){


  parent::_construct();
}

public function get_menus()
{//trae todods los menus de la base de datos
  $query = Functions::get_json_decoded_query($this->database->select('menus', [
    'id',
    'name',
    'price',
    'image',
    'description',

  ], [
    'account' => Session::get_value('account')['id'],
    'ORDER' => [
      'name' => 'ASC'
    ]
  ]));

  return $query;
}
//solo trae un dato
public function get_menu($id)
{
  $query = Functions::get_json_decoded_query($this->database->select('menus', [
    'name',
    'price',
    'image',
    'description'

  ], [
    'id' => $id
  ]));

  return !empty($query) ? $query[0] : null;
}
public function new_menus($data)
{
  $query = null;

  $exist = $this->database->count('menus', [
    'AND' => [
      'account' => Session::get_value('account')['id'],
      'name' => json_encode([
        'es' => $data['name_es'],
        'en' => $data['name_en']
      ])
    ]
  ]);

  if ($exist <= 0)
  {
    $query = $this->database->insert('menus', [
      'account' => Session::get_value('account')['id'],
      'name' => json_encode([
        'es' => $data['name_es'],
        'en' => $data['name_en']
      ]),
      'name' => !empty($data['name']) ? true : false,
      'price' => !empty($data['price']) ? true : false,
      'image' => !empty($data['image']) ? true : false,
      'description ' => !empty($data['description']) ? true : false
    ]);
  }

  return $query;
}

public function edit_menus($data)
{
  $query = null;

  $exist = $this->database->count('menus', [
    'AND' => [
      'id[!]' => $data['id'],
      'account' => Session::get_value('account')['id'],
      'name' => json_encode([
        'es' => $data['name_es'],
        'en' => $data['name_en']
      ])
    ]
  ]);

  if ($exist <= 0)
  {
    $query = $this->database->update('menus', [
      'name' => json_encode([
        'es' => $data['name_es'],
        'en' => $data['name_en']
      ]),
      'name' => !empty($data['name']) ? true : false,
      'price' => !empty($data['price']) ? true : false,
      'image' => !empty($data['image']) ? true : false,
      'description' => !empty($data['description']) ? true : false
    ], [
      'id' => $data['id']
    ]);
  }

  return $query;
}

public function delete_menus($id)
{
  $query = $this->database->delete('menus', [
    'id' => $id
  ]);

  return $query;
}
}
}
