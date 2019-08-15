<?php

defined('_EXEC') or die;

class Tasks_controller extends Controller
{
	public function __construct()
	{
		parent::__construct();
	}

	public function index()
	{
		if (Format::exist_ajax_request() == true)
		{
            if ($_POST['action'] == 'new_task')
            {
                $labels = [];

				if (!isset($_POST['description']) OR empty($_POST['description']))
					array_push($labels, ['description','']);

				if (!isset($_POST['creation_date']) OR empty($_POST['creation_date']))
					array_push($labels, ['creation_date','']);

				if (!isset($_POST['expiration_date']) OR empty($_POST['expiration_date']))
					array_push($labels, ['expiration_date','']);

				if (!isset($_POST['expiration_hour']) OR empty($_POST['expiration_hour']))
					array_push($labels, ['expiration_hour','']);

				if (!isset($_POST['repetition']) OR empty($_POST['repetition']))
					array_push($labels, ['repetition','']);

                    if (empty($labels))
                    {
                        $query = $this->model->new_task($_POST);

                        Functions::environment([
    						'status' => !empty($query) ? 'success' : 'error',
    						'message' => !empty($query) ? '{$lang.success_operation_database}' : '{$lang.error_operation_database}',
    						'path' => '/tasks',
    					]);
                    }
					else
					{
						Functions::environment([
							'status' => 'error',
							'labels' => $labels
						]);
					}
            }

			if ($_POST['action'] == 'delete_task')
			{
				$query = $this->model->delete_task($_POST['id']);

				Functions::environment([
					'status' => !empty($query) ? 'success' : 'error',
					'message' => !empty($query) ? '{$lang.success_operation_database}' : '{$lang.error_operation_database}',
					'path' => '/tasks',
				]);
			}

			if ($_POST['action'] == 'get_task')
			{
				$query = $this->model->get_task($_POST['id']);

				Functions::environment([
					'status' => (!empty($query)) ? 'success' : 'error',
					'data' => (!empty($query)) ? $query : null,
					'message' => (!empty($query)) ? null : '{$lang.error_operation_database}',
				]);
			}

			if ($_POST['action'] == 'edit_task')
			{
				$labels = [];

				if (!isset($_POST['description']) OR empty($_POST['description']))
					array_push($labels, ['description','']);

				if (!isset($_POST['creation_date']) OR empty($_POST['creation_date']))
					array_push($labels, ['creation_date','']);

				if (!isset($_POST['expiration_date']) OR empty($_POST['expiration_date']))
					array_push($labels, ['expiration_date','']);

				if (!isset($_POST['expiration_hour']) OR empty($_POST['expiration_hour']))
					array_push($labels, ['expiration_hour','']);

				if (!isset($_POST['repetition']) OR empty($_POST['repetition']))
					array_push($labels, ['repetition','']);

                if (empty($labels))
                {
                    $query = $this->model->edit_task($_POST);

                    Functions::environment([
						'status' => !empty($query) ? 'success' : 'error',
						'message' => !empty($query) ? '{$lang.success_operation_database}' : '{$lang.error_operation_database}',
						'path' => '/tasks',
					]);
                }
				else
				{
					Functions::environment([
						'status' => 'error',
						'labels' => $labels
					]);
				}
			}

		}
		else
		{
			define('_title', 'GuestVox | Mis tareas');

			$template = $this->view->render($this, 'index');

			$tbl_tasks = '';

			foreach ($this->model->get_tasks() as $value)
			{
				if ($value['repetition'] == 'dayli')
					$value['repetition'] = 'Diaria';

				else if ($value['repetition'] == 'weekly')
					$value['repetition'] = 'Semanal';

				else if ($value['repetition'] == 'monthly')
					$value['repetition'] = 'Mensual';

				else if ($value['repetition'] == 'annual')
					$value['repetition'] = 'Anual';

				$tbl_tasks .=
				'<tr>
					<td align="left">' . $value['description'] . '</td>
					<td align="left">' . $value['creation_date']. '</td>
					<td align="left">' . $value['expiration_date']. '</td>
					<td align="left">' . $value['expiration_hour']. '</td>
					<td align="left">' . $value['repetition'] . '</td>
					<td align="right" class="icon"><a data-action="delete_task" data-id="' . $value['id'] . '"><i class="fas fa-trash"></i></a></td>
					<td align="right" class="icon"><a data-action="edit_task" data-id="' . $value['id'] . '"><i class="fas fa-pencil-alt"></i></a></td>
				</tr>';
			}

            $opt_users = '';

			foreach ($this->model->get_users() as $value)
				$opt_users .= '<option value="' . $value['id'] . '">' . $value['username'] . '</option>';

			$opt_opportunity_areas = '';
			
			foreach ($this->model->get_opportunity_areas('all') as $value)
				$opt_opportunity_areas .= '<option value="' . $value['id'] . '">' . $value['name'][Session::get_value('settings')['language']] . '</option>';

			$replace = [
                '{$tbl_tasks}' => $tbl_tasks,
                '{$opt_users}' => $opt_users,
                '{$opt_opportunity_areas}' => $opt_opportunity_areas,
			];

			$template = $this->format->replace($replace, $template);

			echo $template;
		}
	}
}
