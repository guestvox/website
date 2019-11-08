<?php

defined('_EXEC') or die;

class Survey_controller extends Controller
{
	public function __construct()
	{
		parent::__construct();
	}

	public function index()
	{
		if (Format::exist_ajax_request() == true)
		{
			if ($_POST['action'] == 'get_survey_answers')
			{
				$query = $this->model->get_survey_answers($_POST['id']);

				if (!empty($query))
				{
					$data = '';

					$data .= '
					<div><strong>Token:</strong> ' . $query['token']  . '</div>
					<div><strong>{$lang.room}:</strong> ' . $query['room']  . '</div>
					<div><strong>{$lang.guest}:</strong> ' . $query['firstname']  . ' ' . $query['lastname'] . '</div>
					<div><strong>{$lang.email}:</strong> ' . $query['email']  . '</div>
					<div><strong>{$lang.date}:</strong> ' . Functions::get_formatted_date($query['date'], 'd M, y')  . '</div><br><br>';

					foreach ($query['answers'] as $value)
	                {
						$value['fk'] = $this->model->get_survey_question($value['id']);

	                    if ($value['type'] == 'rate')
						{
							$data .=
		                    '<article>
		                        <h6>' . $value['fk']['question'][Session::get_value('settings')['language']] . '</h6>
		                        <div>
		                            <label>{$lang.appalling}</label>
		                            <label><input type="radio" ' . (($value['answer'] == 1) ? 'checked' : '') . ' disabled></label>
		                            <label><input type="radio" ' . (($value['answer'] == 2) ? 'checked' : '') . ' disabled></label>
		                            <label><input type="radio" ' . (($value['answer'] == 3) ? 'checked' : '') . ' disabled></label>
		                            <label><input type="radio" ' . (($value['answer'] == 4) ? 'checked' : '') . ' disabled></label>
		                            <label><input type="radio" ' . (($value['answer'] == 5) ? 'checked' : '') . ' disabled></label>
		                            <label>{$lang.excellent}</label>
		                        </div>
		                    </article>';
						}
						else if ($value['type'] == 'twin')
						{
							$data .=
							'<article>
								<h6>' . $value['fk']['question'][Session::get_value('settings')['language']] . '</h6>
								<div>
									<label>{$lang.to_yes}</label>
									<label><input type="radio" ' . (($value['answer'] == 'yes') ? 'checked' : '') . ' disabled></label>
									<label><input type="radio" ' . (($value['answer'] == 'no') ? 'checked' : '') . ' disabled></label>
									<label>{$lang.to_not}</label>
								</div>
							</article>';
						}
						else if ($value['type'] == 'open')
						{
							$data .=
							'<article>
		                        <h6>' . $value['fk']['question'][Session::get_value('settings')['language']] . '</h6>
		                        <div>
		                            <input type="text" value="' . $value['answer'] . '" value="">
		                        </div>
		                    </article>';
						}

						if (!empty($value['subanswers']))
						{
							$data .= '<article class="subquestions">';

							foreach ($value['subanswers'] as $subkey => $subvalue)
							{
								$data .=
								'<h6>' . $value['fk']['subquestions'][$subkey]['subquestion'][Session::get_value('settings')['language']] . '</h6>
								<div>';

								if ($subvalue['type'] == 'open')
									$data .= '<input type="text" value="' . $subvalue['answer'] . '" disabled>';
								else if ($subvalue['type'] == 'twin')
								{
									$data .=
									'<label>{$lang.to_yes}</label>
									<label><input type="radio" ' . (($subvalue['answer'] == 'yes') ? 'checked' : '') . ' disabled></label>
									<label><input type="radio" ' . (($subvalue['answer'] == 'no') ? 'checked' : '') . ' disabled></label>
									<label>{$lang.to_not}</label>';
								}
								else if ($subvalue['type'] == 'rate')
								{
									$data .=
									'<label>{$lang.appalling}</label>
									<label><input type="radio" ' . (($subvalue['answer'] == 1) ? 'checked' : '') . ' disabled></label>
									<label><input type="radio" ' . (($subvalue['answer'] == 2) ? 'checked' : '') . ' disabled></label>
									<label><input type="radio" ' . (($subvalue['answer'] == 3) ? 'checked' : '') . ' disabled></label>
									<label><input type="radio" ' . (($subvalue['answer'] == 4) ? 'checked' : '') . ' disabled></label>
									<label><input type="radio" ' . (($subvalue['answer'] == 5) ? 'checked' : '') . ' disabled></label>
									<label>{$lang.excellent}</label>';
								}

								$data .= '</div>';
							}

							$data .= '</article>';
						}
	                }

					$data .=
					'<div class="row">
	                    <div class="span12">
	                        <div class="label">
	                            <label class="success">
	                                <p>{$lang.comments}</p>
	                                <textarea disabled>' . $query['comment'] . '</textarea>
	                            </label>
	                        </div>
	                    </div>
	                </div>';

					Functions::environment([
						'status' => 'success',
						'data' => $data,
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

			if ($_POST['action'] == 'new_survey_question' OR $_POST['action'] == 'edit_survey_question')
			{
				$labels = [];

				if (!isset($_POST['survey_question_es']) OR empty($_POST['survey_question_es']))
					array_push($labels, ['survey_question_es', '']);

				if (!isset($_POST['survey_question_en']) OR empty($_POST['survey_question_en']))
					array_push($labels, ['survey_question_en', '']);

				if (!isset($_POST['type']) OR empty($_POST['type']))
					array_push($labels, ['type', '']);

				if (empty($labels))
				{
					if ($_POST['action'] == 'new_survey_question')
						$query = $this->model->new_survey_question($_POST);
					else if ($_POST['action'] == 'edit_survey_question')
						$query = $this->model->edit_survey_question($_POST);

					if (!empty($query))
					{
						Functions::environment([
							'status' => 'success',
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

			if ($_POST['action'] == 'get_survey_question')
			{
				$query = $this->model->get_survey_question($_POST['id']);

				if (!empty($query))
				{
					Functions::environment([
						'status' => 'success',
						'data' => $query,
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

			if ($_POST['action'] == 'deactivate_survey_question' OR $_POST['action'] == 'activate_survey_question')
			{
				if ($_POST['action'] == 'deactivate_survey_question')
					$query = $this->model->deactivate_survey_question($_POST['id']);
				else if ($_POST['action'] == 'activate_survey_question')
					$query = $this->model->activate_survey_question($_POST['id']);

				if (!empty($query))
				{
					Functions::environment([
						'status' => 'success',
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

			if ($_POST['action'] == 'new_survey_subquestion' OR $_POST['action'] == 'edit_survey_subquestion')
			{
				$labels = [];

				if (!isset($_POST['survey_subquestion_es']) OR empty($_POST['survey_subquestion_es']))
					array_push($labels, ['survey_subquestion_es', '']);

				if (!isset($_POST['survey_subquestion_en']) OR empty($_POST['survey_subquestion_en']))
					array_push($labels, ['survey_subquestion_en', '']);

				if (!isset($_POST['type']) OR empty($_POST['type']))
					array_push($labels, ['type', '']);

				if (empty($labels))
				{
					$question = $this->model->get_survey_question($_POST['id']);

					if ($_POST['action'] == 'new_survey_subquestion')
					{
						array_push($question['subquestions'], [
							'id' => Functions::get_random(6),
							'subquestion' => [
								'es' => $_POST['survey_subquestion_es'],
								'en' => $_POST['survey_subquestion_en'],
							],
							'type' => $_POST['type'],
							'status' => true,
						]);
					}
					else if ($_POST['action'] == 'edit_survey_subquestion')
					{
						$question['subquestions'][$_POST['key']]['subquestion'] = [
							'es' => $_POST['survey_subquestion_es'],
							'en' => $_POST['survey_subquestion_en'],
						];

						$question['subquestions'][$_POST['key']]['type'] = $_POST['type'];
					}

					$query = $this->model->edit_survey_subquestion($_POST['id'], $question['subquestions']);

					if (!empty($query))
					{
						Functions::environment([
							'status' => 'success',
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

			if ($_POST['action'] == 'get_survey_subquestion')
			{
				$query = $this->model->get_survey_question($_POST['id']);

				if (!empty($query))
				{
					Functions::environment([
						'status' => 'success',
						'data' => $query['subquestions'][$_POST['key']],
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

			if ($_POST['action'] == 'deactivate_survey_subquestion' OR $_POST['action'] == 'activate_survey_subquestion')
			{
				$question = $this->model->get_survey_question($_POST['id']);

				if ($_POST['action'] == 'deactivate_survey_subquestion')
					$question['subquestions'][$_POST['key']]['status'] = false;
				else if ($_POST['action'] == 'activate_survey_subquestion')
					$question['subquestions'][$_POST['key']]['status'] = true;

				$query = $this->model->edit_survey_subquestion($_POST['id'], $question['subquestions']);

				if (!empty($query))
				{
					Functions::environment([
						'status' => 'success',
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

			if ($_POST['action'] == 'edit_survey_title')
			{
				$labels = [];

				if (!isset($_POST['survey_title_es']) OR empty($_POST['survey_title_es']))
					array_push($labels, ['survey_title_es', '']);

				if (!isset($_POST['survey_title_en']) OR empty($_POST['survey_title_en']))
					array_push($labels, ['survey_title_en', '']);

				if (empty($labels))
				{
					$query = $this->model->edit_survey_title($_POST);

					if (!empty($query))
					{
						Functions::environment([
							'status' => 'success',
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
		}
		else
		{
			define('_title', 'GuestVox | Encuesta');

			$template = $this->view->render($this, 'index');

			$tbl_survey_answers = '';

			foreach ($this->model->get_survey_answers() as $value)
			{
				$value['rate'] = 0;
				$questions = [];

				foreach ($value['answers'] as $key => $subvalue)
				{
					if ($subvalue['type'] == 'rate')
					{
						$value['rate'] = $value['rate'] + $subvalue['answer'];
						array_push($questions, $subvalue);
					}
				}

				$value['rate'] = $value['rate'] / count($questions);

				$tbl_survey_answers .=
				'<tr>
					<td align="left">' . $value['token'] . '</td>
					<td align="left">' . $value['room'] . '</td>
					<td align="left">' . $value['firstname'] . ' ' . $value['lastname'] . '</td>
					<td align="left">' . $value['email'] . '</td>
					<td align="left">' . Functions::get_formatted_date($value['date'], 'd M, y') . '</td>
					<td align="left">' . round($value['rate'], 2) . ' Pts</td>
					<td align="right" class="icon"><a data-action="get_survey_answers" data-id="' . $value['id'] . '"><i class="fas fa-eye"></i></a></td>
				</tr>';
			}

			$tbl_survey_questions = '';

			foreach ($this->model->get_survey_questions() as $value)
			{
				$tbl_survey_questions .=
				'<tr class="question">
					<td align="left">' . $value['question'][Session::get_value('settings')['language']] . '</td>
					<td align="left">' . (($value['type'] == 'rate') ? 'Rate' : (($value['type'] == 'twin') ? 'Twin' : 'Abierta'))  . '</td>
					<td align="left">' . (($value['status'] == true) ? 'Activada' : 'Desactivada') . '</td>
					<td align="right" class="icon">' . (($value['status'] == true AND $value['type'] != 'open') ? '<a data-action="new_survey_subquestion" data-id="' . $value['id'] . '"><i class="fas fa-plus"></i></a>' : '') . '</td>
					<td align="right" class="icon">' . (($value['status'] == true) ? '<a data-action="deactivate_survey_question" data-id="' . $value['id'] . '"><i class="fas fa-ban"></i></a>' : '<a data-action="activate_survey_question" data-id="' . $value['id'] . '"><i class="fas fa-check"></i></a>') . '</td>
					<td align="right" class="icon">' . (($value['status'] == true) ? '<a data-action="edit_survey_question" data-id="' . $value['id'] . '"><i class="fas fa-pencil-alt"></i></a>' : '') . '</td>
				</tr>';

				foreach ($value['subquestions'] as $subkey => $subvalue)
				{
					$tbl_survey_questions .=
					'<tr>
						<td align="left" class="sub">' . $subvalue['subquestion'][Session::get_value('settings')['language']] . '</td>
						<td align="left">' . (($subvalue['type'] == 'rate') ? 'Rate' : (($subvalue['type'] == 'twin') ? 'Twin' : 'Abierta'))  . '</td>
						<td align="left">' . (($subvalue['status'] == true) ? 'Activada' : 'Desactivada') . '</td>
						<td align="right" class="icon"></td>
						<td align="right" class="icon">' . (($subvalue['status'] == true) ? '<a data-action="deactivate_survey_subquestion" data-id="' . $value['id'] . '" data-key="' . $subkey . '"><i class="fas fa-ban"></i></a>' : '<a data-action="activate_survey_subquestion" data-id="' . $value['id'] . '" data-key="' . $subkey . '"><i class="fas fa-check"></i></a>') . '</td>
						<td align="right" class="icon">' . (($subvalue['status'] == true) ? '<a data-action="edit_survey_subquestion" data-id="' . $value['id'] . '" data-key="' . $subkey . '"><i class="fas fa-pencil-alt"></i></a>' : '') . '</td>
					</tr>';
				}
			}

			$replace = [
				'{$tbl_survey_answers}' => $tbl_survey_answers,
				'{$tbl_survey_questions}' => $tbl_survey_questions,
				'{$survey_title_es}' => $this->model->get_survey_title()['es'],
				'{$survey_title_en}' => $this->model->get_survey_title()['en'],
				// '{$total_rate_avarage}' => $this->model->get_total_rate_avarage(),
			];

			$template = $this->format->replace($replace, $template);

			echo $template;
		}
	}

	public function charts()
	{
		// header('Content-Type: application/javascript');
		//
		// $s_r1_chart_data = $this->model->get_chart_data('s_r1_chart');
		// $s_r2_chart_data = $this->model->get_chart_data('s_r2_chart');
		//
		// if (Session::get_value('lang') == 'es')
		// {
		// 	$chart_rooms = 'Habitaciones';
		// 	$rate_average = 'Promedio de puntuación';
		// }
		// else if (Session::get_value('lang') == 'en')
		// {
		// 	$chart_rooms = 'Rooms';
		// 	$rate_average = 'Rate average';
		// }
		//
		// $js =
		// "'use strict';
		//
		// var s_r1_chart = {
	    //     type: 'pie',
	    //     data: {
		// 		labels: [
	    //             " . $s_r1_chart_data['labels'] . "
	    //         ],
		// 		datasets: [{
	    //             data: [
	    //                 " . $s_r1_chart_data['datasets']['data'] . "
	    //             ],
	    //             backgroundColor: [
	    //                 " . $s_r1_chart_data['datasets']['colors'] . "
	    //             ],
	    //         }],
	    //     },
	    //     options: {
		// 		title: {
		// 			display: true,
		// 			text: '" . $chart_rooms . "'
		// 		},
		// 		legend: {
		// 			display: false
		// 		},
	    //         responsive: true
        //     }
        // };
		//
		// var s_r2_chart = {
	    //     type: 'pie',
	    //     data: {
		// 		labels: [
	    //             " . $s_r2_chart_data['labels'] . "
	    //         ],
		// 		datasets: [{
	    //             data: [
	    //                 " . $s_r2_chart_data['datasets']['data'] . "
	    //             ],
	    //             backgroundColor: [
	    //                 " . $s_r2_chart_data['datasets']['colors'] . "
	    //             ],
	    //         }],
	    //     },
	    //     options: {
		// 		title: {
		// 			display: true,
		// 			text: '" . $rate_average . "'
		// 		},
		// 		legend: {
		// 			display: false
		// 		},
	    //         responsive: true
        //     }
        // };
		//
		// window.onload = function()
		// {
		// 	s_r1_chart = new Chart(document.getElementById('s_r1_chart').getContext('2d'), s_r1_chart);
		// 	s_r2_chart = new Chart(document.getElementById('s_r2_chart').getContext('2d'), s_r2_chart);
		// };";
		//
		// $js = trim(str_replace(array("\t\t\t"), '', $js));
		//
		// echo $js;
	}
}
