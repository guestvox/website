<?php

defined('_EXEC') or die;

class Menu_controller extends Controller
{
    public function __construct()
    {
        parent::__construct();
    }

    public function index()
    {
        if (Format::exist_ajax_request() == true)
        {
            if ($_POST['action'] == 'get_menu')
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

            if ($_POST['action'] == 'new_menu' OR $_POST['action'] == 'edit_menu')
            {
                $labels = [];

                if (!isset($_POST['name_es']) OR empty($_POST['name_es']))
                    array_push($labels, ['name_es','']);

                if (!isset($_POST['name_en']) OR empty($_POST['name_en']))
                    array_push($labels, ['name_en','']);

                if (!isset($_POST['price']) OR empty($_POST['price']) OR $_POST['price'] <= 0)
                    array_push($labels, ['price','']);

                if (!isset($_POST['currency']) OR empty($_POST['currency']))
                    array_push($labels, ['currency','']);

                if (!isset($_POST['description_es']) OR empty($_POST['description_es']))
                    array_push($labels, ['description_es','']);

                if (!isset($_POST['description_en']) OR empty($_POST['description_en']))
                    array_push($labels, ['description_en','']);

                if (empty($labels))
                {
                    if ($_POST['action'] == 'new_menu')
                        $query = $this->model->new_menu($_POST);
                    else if ($_POST['action'] == 'edit_menu')
                        $query = $this->model->edit_menu($_POST);

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

            if ($_POST['action'] == 'delete_menu')
            {
                $query = $this->model->delete_menu($_POST['id']);

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
        else
        {
            define('_title', 'GuestVox');

            $template = $this->view->render($this, 'index');

            $tbl_menu = '';

            foreach ($this->model->get_menu() as $value)
            {
                $tbl_menu .=
                '<tr>
                    <td align="left">' . $value['name'][Session::get_value('account')['language']] . '</td>
                    <td align="left">$ ' . $value['price'] . ' ' . $value['currency'] . '</td>
                    ' . ((Functions::check_user_access(['{menu_delete}']) == true) ? '<td align="right" class="icon"><a data-action="delete_menu" data-id="' . $value['id'] . '" class="delete"><i class="fas fa-trash"></i></a></td>' : '') . '
                    ' . ((Functions::check_user_access(['{menu_update}']) == true) ? '<td align="right" class="icon"><a data-action="edit_menu" data-id="' . $value['id'] . '" class="edit"><i class="fas fa-pen"></i></a></td>' : '') . '
                </tr>';
            }

            $replace = [
                '{$tbl_menu}' => $tbl_menu
            ];

            $template = $this->format->replace($replace, $template);

            echo $template;
        }
    }
}
