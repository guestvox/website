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

			if ($_POST['action'] == 'new_survey_question' OR $_POST['action'] == 'edit_survey_question')
			{
				$labels = [];

				if (!isset($_POST['survey_question_es']) OR empty($_POST['survey_question_es']))
					array_push($labels, ['survey_question_es', '']);

				if (!isset($_POST['survey_question_en']) OR empty($_POST['survey_question_en']))
					array_push($labels, ['survey_question_en', '']);

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

			// if ($_POST['action'] == 'get_survey_subquestion')
			// {
			// 	$post = [];
			//
			// 	foreach ($_POST as $key => $value)
			// 	{
			// 		$ex = explode('-', $value);
			// 		array_push($post, $ex);
			// 	}
			//
			// 	$query = $this->model->get_survey_subquestion($post);
			//
			// 	Functions::environment([
			// 		'status' => (!empty($query)) ? 'success' : 'error',
			// 		'data' => (!empty($query)) ? $query : null,
			// 		'message' => (!empty($query)) ? null : '{$lang.error_operation_database}',
			// 	]);
			// }

			if ($_POST['action'] == 'new_survey_subquestion' OR $_POST['action'] == 'edit_survey_subquestion')
			{
				print_r($_POST);
				
				$labels = [];

				if (!isset($_POST['survey_subquestion_es']) OR empty($_POST['survey_subquestion_es']))
					array_push($labels, ['survey_subquestion_es', '']);

				if (!isset($_POST['survey_subquestion_en']) OR empty($_POST['survey_subquestion_en']))
					array_push($labels, ['survey_subquestion_en', '']);

				if (!isset($_POST['type']) OR empty($_POST['type']))
					array_push($labels, ['type', '']);

				if (empty($labels))
				{
					// $_POST['id'] = Functions::get_random(6);

					// if ($_POST['action'] == 'new_survey_subquestion')
					// 	$query = $this->model->new_survey_subquestion($_POST);
					// else if ($_POST['action'] == 'edit_survey_subquestion')
					// {
					// 	$post = [];
					//
					// 	$ex = explode('-', $_POST['id']);
					// 	array_push($post, $ex, $_POST);
					//
					// 	$query = $this->model->edit_survey_subquestion($post);
					// }
					//
					// if (!empty($query))
					// {
					// 	$data = '';
					//
					// 	foreach ($this->model->get_survey_questions() as $value)
					// 	{
					// 		$data .=
					// 		'<tr>
					// 			<td align="left"><i class="far fa-dot-circle"></i> ' . $value['q1']['question'][Session::get_value('settings')['language']] . '</td>
					// 			<td align="left">' . (($value['q1']['status'] == true) ? 'Activada' : 'Desactivada') . '</td>
					// 			<td align="right" class="icon"><a data-action="add_survey_subquestion" data-id="' . $value['q1']['id'] . '"><i class="fas fa-plus-square"></i></a></td>
					// 			<td align="right" class="icon">' . (($value['q1']['fk'] == false) ? '<a data-action="delete_survey_question" data-id="' . $value['q1']['id'] . '"><i class="fas fa-trash"></i></a>' : (($value['q1']['status'] == true) ? '<a data-action="deactivate_survey_question" data-id="' . $value['q1']['id'] . '"><i class="fas fa-ban"></i></a>' : '<a data-action="activate_survey_question" data-id="' . $value['q1']['id'] . '"><i class="fas fa-check"></i></a>'))
					// 			 . '</td>
					// 			<td align="right" class="icon"><a data-action="edit_survey_question" data-id="' . $value['q1']['id'] . '"><i class="fas fa-pencil-alt"></i></a></td>
					// 		</tr>';
					//
					// 		if (!empty($value['q1']['subquestions']))
					// 		{
					// 			foreach ($value['q1']['subquestions'] as $key => $subvalue)
					// 			{
					// 				$data .=
					// 				'<tr>
					// 					<td align="left">' . $subvalue[Session::get_value('settings')['language']] . '</td>
					// 					<td align="left"></td>
					// 					<td align="right" class="icon"></td>
					// 					<td align="right" class="icon"><a data-action="delete_survey_subquestion" data-id=" ' . $key . '"><i class="fas fa-trash"></i></a>'
					// 					 . '</td>
					// 					<td align="right" class="icon"><a data-action="edit_survey_subquestion" data-id=""><i class="fas fa-pencil-alt"></i></a></td>
					// 				</tr>';
					// 			}
					// 		}
					//
					// 	}
					//
					// 	Functions::environment([
					// 		'status' => 'success',
					// 		'data' => $data,
					// 		'message' => '{$lang.success_operation_database}',
					// 	]);
					// }
					// else
					// {
					// 	Functions::environment([
					// 		'status' => 'error',
					// 		'message' => '{$lang.error_operation_database}',
					// 	]);
					// }
				}
				else
				{
					Functions::environment([
						'status' => 'error',
						'labels' => $labels
					]);
				}
			}

			// if ($_POST['action'] == 'delete_survey_subquestion')
			// {
			// 	$array = [];
			// 	foreach ($_POST as $key => $value)
			// 	{
			// 		$ex = explode('-', $value);
			// 		array_push($array, $ex);
			// 	}
			//
			// 		$query = $this->model->delete_survey_subquestion($array);
			//
			// 	if (!empty($query))
			// 	{
			// 		$data = '';
			//
			// 		foreach ($this->model->get_survey_questions() as $value)
			// 		{
			// 			$data .=
			// 			'<tr>
			// 				<td align="left"><i class="far fa-dot-circle"></i> ' . $value['q1']['question'][Session::get_value('settings')['language']] . '</td>
			// 				<td align="left">' . (($value['q1']['status'] == true) ? 'Activada' : 'Desactivada') . '</td>
			// 				<td align="right" class="icon"><a data-action="add_survey_subquestion" data-id="' . $value['q1']['id'] . '"><i class="fas fa-plus-square"></i></a></td>
			// 				<td align="right" class="icon">' . (($value['q1']['fk'] == false) ? '<a data-action="delete_survey_question" data-id="' . $value['q1']['id'] . '"><i class="fas fa-trash"></i></a>' : (($value['q1']['status'] == true) ? '<a data-action="deactivate_survey_question" data-id="' . $value['q1']['id'] . '"><i class="fas fa-ban"></i></a>' : '<a data-action="activate_survey_question" data-id="' . $value['q1']['id'] . '"><i class="fas fa-check"></i></a>'))
			// 				 . '</td>
			// 				<td align="right" class="icon"><a data-action="edit_survey_question" data-id="' . $value['q1']['id'] . '"><i class="fas fa-pencil-alt"></i></a></td>
			// 			</tr>';
			//
			// 			if (!empty($value['q1']['subquestions']))
			// 			{
			// 				foreach ($value['q1']['subquestions'] as $key => $subvalue)
			// 				{
			// 					$data .=
			// 					'<tr>
			// 						<td align="left">' . $subvalue[Session::get_value('settings')['language']] . '</td>
			// 						<td align="left"></td>
			// 						<td align="right" class="icon"></td>
			// 						<td align="right" class="icon"><a data-action="delete_survey_subquestion" data-id=" ' . $value['q1']['id'] . '-' . $key . '"><i class="fas fa-trash"></i></a>'
			// 						 . '</td>
			// 						<td align="right" class="icon"><a data-action="edit_survey_subquestion" data-id="' . $value['q1']['id'] . '-' . $key . '"><i class="fas fa-pencil-alt"></i></a></td>
			// 					</tr>';
			// 				}
			// 			}
			// 		}
			//
			// 		Functions::environment([
			// 			'status' => 'success',
			// 			'data' => $data,
			// 			'message' => '{$lang.success_operation_database}',
			// 		]);
			// 	}
			// 	else
			// 	{
			// 		Functions::environment([
			// 			'status' => 'error',
			// 			'message' => '{$lang.error_operation_database}',
			// 		]);
			// 	}
			// }

			// if ($_POST['action'] == 'edit_survey_title')
			// {
			// 	$labels = [];
			//
			// 	if (!isset($_POST['survey_title_es']) OR empty($_POST['survey_title_es']))
			// 		array_push($labels, ['survey_title_es', '']);
			//
			// 	if (!isset($_POST['survey_title_en']) OR empty($_POST['survey_title_en']))
			// 		array_push($labels, ['survey_title_en', '']);
			//
			// 	if (empty($labels))
			// 	{
			// 		$query = $this->model->edit_survey_title($_POST);
			//
			// 		if (!empty($query))
			// 		{
			// 			Functions::environment([
			// 				'status' => 'success',
			// 				'title' => [
			// 					'es' => $_POST['survey_title_es'],
			// 					'en' => $_POST['survey_title_en'],
			// 				],
			// 				'message' => '{$lang.success_operation_database}',
			// 			]);
			// 		}
			// 		else
			// 		{
			// 			Functions::environment([
			// 				'status' => 'error',
			// 				'message' => '{$lang.error_operation_database}',
			// 			]);
			// 		}
			// 	}
			// 	else
			// 	{
			// 		Functions::environment([
			// 			'status' => 'error',
			// 			'labels' => $labels
			// 		]);
			// 	}
			// }
		}
		else
		{
			define('_title', 'GuestVox | Encuesta');

			$template = $this->view->render($this, 'index');

			// $tbl_survey_answers = '';
			//
			// foreach ($this->model->get_survey_answers() as $value)
			// {
			// 	$tbl_survey_answers .=
			// 	'<tr>
			// 		<td align="left">' . $value['survey_question'][Session::get_value('settings')['language']] . '</td>
			// 		<td align="left">' . $value['room'] . '</td>
			// 		<td align="left">' . $value['rate'] . ' Pts</td>
			// 		<td align="left">' . Functions::get_formatted_date($value['date'], 'd M, y') . '</td>
			// 		<td align="left">' . $value['token'] . '</td>
			// 	</tr>';
			// }
			//
			// $tbl_survey_subanswers = '';
			//
			// foreach ($this->model->get_survey_subanswers() as $value)
			// {
			// 	$tbl_survey_subanswers .=
			// 	'<tr>
			// 		<td align="left">' . $value['survey_subquestion'][Session::get_value('settings')['language']] . '</td>
			// 		<td align="left">' . $value['room'] . '</td>
			// 		<td align="left">' . $value['subanswer'] . '</td>
			// 	</tr>';
			// }
			//
			// $tbl_survey_comments = '';
			//
			// foreach ($this->model->get_survey_comments() as $value)
			// {
			// 	$tbl_survey_comments .=
			// 	'<tr name="' . $value['id'] . '">
			// 		<td align="left">' . $value['comment'] . '</td>
			// 		<td align="left">' . $value['room'] . '</td>
			// 		<td align="left">' . Functions::get_formatted_date($value['date'], 'd M, y') . '</td>
			// 		<td align="left">' . $value['token'] . '</td>
			// 	</tr>';
			// }

			$tbl_survey_questions = '';

			foreach ($this->model->get_survey_questions() as $value)
			{
				$tbl_survey_questions .=
				'<tr>
					<td align="left">' . $value['question'][Session::get_value('settings')['language']] . '</td>
					<td align="left">' . (($value['status'] == true) ? 'Activada' : 'Desactivada') . '</td>
					<td align="right" class="icon">' . (($value['status'] == true) ? '<a data-action="new_survey_subquestion" data-id="' . $value['id'] . '"><i class="fas fa-plus"></i></a>' : '') . '</td>
					<td align="right" class="icon">' . (($value['status'] == true) ? '<a data-action="deactivate_survey_question" data-id="' . $value['id'] . '"><i class="fas fa-ban"></i></a>' : '<a data-action="activate_survey_question" data-id="' . $value['id'] . '"><i class="fas fa-check"></i></a>') . '</td>
					<td align="right" class="icon">' . (($value['status'] == true) ? '<a data-action="edit_survey_question" data-id="' . $value['id'] . '"><i class="fas fa-pencil-alt"></i></a>' : '') . '</td>
				</tr>';

				// if (!empty($value['q1']['subquestions']))
				// {
				// 	foreach ($value['q1']['subquestions'] as $key => $subvalue)
				// 	{
				// 		$tbl_survey_questions .=
				// 		'<tr>
				// 			<td align="left">' . $subvalue[Session::get_value('settings')['language']] . '</td>
				// 			<td align="left"></td>
				// 			<td align="right" class="icon"></td>
				// 			<td align="right" class="icon"><a data-action="delete_survey_subquestion" data-id=" ' . $value['q1']['id'] . '-' . $key . '"><i class="fas fa-trash"></i></a>'
				// 			 . '</td>
				// 			<td align="right" class="icon"><a data-action="edit_survey_subquestion" data-id="' . $value['q1']['id'] . '-' . $key . '"><i class="fas fa-pencil-alt"></i></a></td>
				// 		</tr>';
				// 	}
				// }
			}

			$replace = [
				// '{$tbl_survey_answers}' => $tbl_survey_answers,
				// '{$tbl_survey_subanswers}' => $tbl_survey_subanswers,
				// '{$tbl_survey_comments}' => $tbl_survey_comments,
				'{$tbl_survey_questions}' => $tbl_survey_questions,
				// '{$total_rate_avarage}' => $this->model->get_total_rate_avarage(),
				// '{$survey_title_es}' => $this->model->get_survey_title()['survey_title']['es'],
				// '{$survey_title_en}' => $this->model->get_survey_title()['survey_title']['en'],
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
