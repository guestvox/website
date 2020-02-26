<?php

defined('_EXEC') or die;

class Information_controller extends Controller
{
	public function __construct()
	{
		parent::__construct();
	}

	public function index()
	{
        if (Format::exist_ajax_request() == true)
		{
			if ($_POST['action'] == 'get_myvox_information')
			{
				$query = $this->model->get_myvox_information($_POST['id']);

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

			if ($_POST['action'] == 'new_myvox_information' OR $_POST['action'] == 'edit_myvox_information')
			{
				$labels = [];

				if (!isset($_POST['name_es']) OR empty($_POST['name_es']))
					array_push($labels, ['name_es', '']);

				if (!isset($_POST['name_en']) OR empty($_POST['name_en']))
					array_push($labels, ['name_en', '']);

				if (!isset($_POST['description']) OR empty($_POST['description']))
					array_push($labels, ['description', '']);

				if (empty($labels))
				{
					if ($_POST['action'] == 'new_myvox_information')
						$query = $this->model->new_myvox_information($_POST);
					else if ($_POST['action'] == 'edit_myvox_information')
						$query = $this->model->edit_myvox_information($_POST);

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

			if ($_POST['action'] == 'delete_myvox_information')
			{
				$query = $this->model->delete_myvox_information($_POST['id']);

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

			$tbl_myvox_information = '';

			foreach ($this->model->get_myvox_informations() as $value)
			{
				$tbl_myvox_information .=
				'<tr>
					<td align="left">' . $value['name'][Session::get_value('account')['language']] . '</td>
					<td align="left">' . $value['description'] . '</td>
					<td align="right" class="icon"><a data-action="delete_myvox_information" data-id="' . $value['id'] . '" class="delete"><i class="fas fa-trash"></i></a></td>
					<td align="right" class="icon"><a data-action="edit_myvox_information" data-id="' . $value['id'] . '" class="edit"><i class="fas fa-pen"></i></a></td>
				</tr>';
			}

			$replace = [
				'{$tbl_myvox_information}' => $tbl_myvox_information
			];

			$template = $this->format->replace($replace, $template);

			echo $template;
		}
	}
}
