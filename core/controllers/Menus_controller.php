<?php
defined('_EXEC') or die;

class Menus_controller() extends Controller{

public function __construct(){


  parent::__construct();
}

public function index(){

if (Format::exist_ajax_request() == true){ //si existe una peticion ajax
  if ($_POST['action'] == 'get_menu') // es la consulta a la base de datos, se conecta con el modelo para que ueda hacer la consulta
  {
    $query = $this->model->get_menu($_POST['id']);

    if (!empty($query))
    {
      Functions::environment([
        'status' => 'success',
        'data' => $query
      ]);
    }
    else
    {
      Functions::environment([
        'status' => 'error',
        'message' => '{$lang.operation_error}'
      ]);
    }
  }
  if ($_POST['action'] == 'new_menus' OR $_POST['action'] == 'edit_menus')//actualiza o crea los datos en la base de datos
  {
    $labels = [];

    if (!isset($_POST['name_es']) OR empty($_POST['name_es']))
      array_push($labels, ['name_es', '']);

    if (!isset($_POST['name_en']) OR empty($_POST['name_en']))
      array_push($labels, ['name_en', '']);

    if (empty($labels))
    {
      if ($_POST['action'] == 'new_menus')//si selecciona crear nuevo
        $query = $this->model->new_menus($_POST);
      else if ($_POST['action'] == 'edit_opportunity_area')
        $query = $this->model->edit_menus($_POST);

      if (!empty($query))
      {
        Functions::environment([
          'status' => 'success',
          'message' => '{$lang.operation_success}'
        ]);
      }
      else
      {
        Functions::environment([
          'status' => 'error',
          'message' => '{$lang.operation_error}'
        ]);
      }
    }
    else
    {
      Functions::environment([
        'status' => 'error',
        'labels' => $labels
      ]);
    }
  }
  if ($_POST['action'] == 'delete_menus')
  {
    $query = $this->model->delete_menus($_POST['id']);

    if (!empty($query))
    {
      Functions::environment([
        'status' => 'success',
        'message' => '{$lang.operation_success}'
      ]);
    }
    else
    {
      Functions::environment([
        'status' => 'error',
        'message' => '{$lang.operation_error}'
      ]);
    }
  }

}
//si no existe peticion ajax
else
{
  define('_title', 'GuestVox');

  $template = $this->view->render($this, 'index');

  $tbl_menus = '';
//imprime la tabla de la base de datos
  foreach ($this->model->get_menus() as $value)
  {
    $tbl_menus .=
    '<tr>
      <td align="left">' . $value['name'][Session::get_value('account')['language']] . '</td>
      <td align="left" class="flag">' . (($value['name'] == true) ? '<span><i class="fas fa-check"></i></span>' : '<span><i class="fas fa-times"></i></span>') . '</td>
      <td align="left" class="flag">' . (($value['price'] == true) ? '<span><i class="fas fa-check"></i></span>' : '<span><i class="fas fa-times"></i></span>') . '</td>
      <td align="left" class="flag">' . (($value['description'] == true) ? '<span><i class="fas fa-check"></i></span>' : '<span><i class="fas fa-times"></i></span>') . '</td>
      <td align="left" class="flag">' . (($value['image'] == true) ? '<span><i class="fas fa-check"></i></span>' : '<span><i class="fas fa-times"></i></span>') . '</td>
      ' . ((Functions::check_user_access(['{opportunity_areas_delete}']) == true) ? '<td align="right" class="icon"><a data-action="delete_opportunity_area" data-id="' . $value['id'] . '" class="delete"><i class="fas fa-trash"></i></a></td>' : '') . '
      ' . ((Functions::check_user_access(['{opportunity_areas_update}']) == true) ? '<td align="right" class="icon"><a data-action="edit_opportunity_area" data-id="' . $value['id'] . '" class="edit"><i class="fas fa-pen"></i></a></td>' : '') . '
    </tr>';
  }

  $replace = [
    '{$tbl_menus}' => $tbl_menus
  ];

  $template = $this->format->replace($replace, $template);

  echo $template;
}


}

}
