<?php

defined('_EXEC') or die;

class Surveys_controller extends Controller
{
	public function __construct()
	{
		parent::__construct();
	}

	public function index()
	{
		if (Format::exist_ajax_request() == true)
		{
			if ($_POST['action'] == 'new_question' OR $_POST['action'] == 'edit_question')
			{
				$labels = [];

				if (!isset($_POST['question_es']) OR empty($_POST['question_es']))
					array_push($labels, ['question_es', '']);

				if (!isset($_POST['question_en']) OR empty($_POST['question_en']))
					array_push($labels, ['question_en', '']);

				if (empty($labels))
				{
					if ($_POST['action'] == 'new_question')
						$query = $this->model->new_question($_POST);
					else if ($_POST['action'] == 'edit_question')
						$query = $this->model->edit_question($_POST);

					if (!empty($query))
					{
						$data = '';

						foreach ($this->model->get_questions() as $value)
						{
							$data .=
							'<tr>
								<td align="left">' . $value['question'][Session::get_value('settings')['language']] . '</td>
								<td align="right" class="icon"><a data-action="delete_question" data-id="' . $value['id'] . '"><i class="fas fa-trash"></i></a></td>
								<td align="right" class="icon"><a data-action="edit_question" data-id="' . $value['id'] . '"><i class="fas fa-pencil-alt"></i></a></td>
							</tr>';
						}

						Functions::environment([
							'status' => 'success',
							'data' => $data,
							'message' => '{$lang.success_operation_database}',
						]);
					}
					else
					{
						Functions::environment([
							'status' => 'error',
							'message' => '{$lang.error_operation_database}',
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

			if ($_POST['action'] == 'get_question')
			{
				$query = $this->model->get_question($_POST['id']);

				Functions::environment([
					'status' => (!empty($query)) ? 'success' : 'error',
					'data' => (!empty($query)) ? $query : null,
					'message' => (!empty($query)) ? null : '{$lang.error_operation_database}',
				]);
			}

			if ($_POST['action'] == 'delete_question')
			{
				$query = $this->model->delete_question($_POST['id']);

				if (!empty($query))
				{
					$data = '';

					foreach ($this->model->get_questions() as $value)
					{
						$data .=
						'<tr>
							<td align="left">' . $value['question'][Session::get_value('settings')['language']] . '</td>
							<td align="right" class="icon"><a data-action="delete_question" data-id="' . $value['id'] . '"><i class="fas fa-trash"></i></a></td>
							<td align="right" class="icon"><a data-action="edit_question" data-id="' . $value['id'] . '"><i class="fas fa-pencil-alt"></i></a></td>
						</tr>';
					}

					Functions::environment([
						'status' => 'success',
						'data' => $data,
						'message' => '{$lang.success_operation_database}',
					]);
				}
				else
				{
					Functions::environment([
						'status' => 'error',
						'message' => '{$lang.error_operation_database}',
					]);
				}
			}
		}
		else
		{
			define('_title', 'GuestVox | Encuestas');

			$template = $this->view->render($this, 'index');

			$tbl_questions = '';

			foreach ($this->model->get_questions() as $value)
			{
				$tbl_questions .=
				'<tr>
					<td align="left">' . $value['question'][Session::get_value('settings')['language']] . '</td>
					<td align="right" class="icon"><a data-action="delete_question" data-id="' . $value['id'] . '"><i class="fas fa-trash"></i></a></td>
					<td align="right" class="icon"><a data-action="edit_question" data-id="' . $value['id'] . '"><i class="fas fa-pencil-alt"></i></a></td>
				</tr>';
			}

			$replace = [
				'{$tbl_questions}' => $tbl_questions,
			];

			$template = $this->format->replace($replace, $template);

			echo $template;
		}
	}
}
