<?php

defined('_EXEC') or die;

class Surveys_controller extends Controller
{
	private $lang;

	public function __construct()
	{
		parent::__construct();

		$this->lang = Session::get_value('account')['language'];
	}

	public function index()
	{
        if (Format::exist_ajax_request() == true)
		{
			if ($_POST['action'] == 'get_survey')
			{
				$query = $this->model->get_survey($_POST['id']);

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

			if ($_POST['action'] == 'new_survey' OR $_POST['action'] == 'edit_survey')
			{
				$labels = [];

				if (!isset($_POST['name_es']) OR empty($_POST['name_es']))
					array_push($labels, ['name_es','']);

				if (!isset($_POST['name_en']) OR empty($_POST['name_en']))
					array_push($labels, ['name_en','']);

				if (!empty($_POST['report_status']))
				{
					if (!isset($_POST['report_days']) OR empty($_POST['report_days']))
						array_push($labels, ['report_days','']);

					if (!isset($_POST['report_time']) OR empty($_POST['report_time']))
						array_push($labels, ['report_time','']);

					if (!isset($_POST['report_email']) OR empty($_POST['report_email']))
						array_push($labels, ['report_email','']);
				}

				if (empty($labels))
				{
					if ($_POST['action'] == 'new_survey')
						$query = $this->model->new_survey($_POST);
					else if ($_POST['action'] == 'edit_survey')
						$query = $this->model->edit_survey($_POST);

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

			if ($_POST['action'] == 'deactivate_survey' OR $_POST['action'] == 'activate_survey' OR $_POST['action'] == 'delete_survey')
			{
				if ($_POST['action'] == 'deactivate_survey')
					$query = $this->model->deactivate_survey($_POST['id']);
				else if ($_POST['action'] == 'activate_survey')
					$query = $this->model->activate_survey($_POST['id']);
				else if ($_POST['action'] == 'delete_survey')
					$query = $this->model->delete_survey($_POST['id']);

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
			$template = $this->view->render($this, 'index');

			define('_title', 'Guestvox | {$lang.surveys}');

			$tbl_surveys = '';

			foreach ($this->model->get_surveys() as $value)
			{
				$tbl_surveys .=
				'<div>
					<div class="datas">
						<div class="itm_1">
							' . (($value['main'] == true) ? '<h2>Encuesta predeterminada</h2>' : '') . '
							<h2>' . $value['token'] . ' | ' . $value['name'][$this->lang] . '</h2>
							<span>Solicitud de NPS: ' . (($value['nps'] == true) ? 'Si' : 'No') . '</span>
							<span>Solicitud de firma: ' . (($value['signature'] == true) ? 'Si' : 'No') . '</span>
							<span>Envío de reporte: ' . (($value['report']['status'] == true) ? 'Automático' : 'No') . '</span>
						</div>
						<div class="itm_2">
							<figure>
								<a href="{$path.uploads}' . $value['qr'] . '" download="' . $value['qr'] . '"><img src="{$path.uploads}' . $value['qr'] . '"></a>
							</figure>
						</div>
					</div>
					<div class="buttons">
						' . ((Functions::check_user_access(['{surveys_answers_view}']) == true) ? '<a class="big" href="/surveys/answers/raters/' . $value['id'] . '"><i class="fas fa-star"></i><span>{$lang.answers}</span></a>' : '') . '
						' . ((Functions::check_user_access(['{surveys_answers_view}']) == true) ? '<a class="big" href="/surveys/answers/comments/' . $value['id'] . '"><i class="fas fa-comment-alt"></i><span>{$lang.comments}</span></a>' : '') . '
						' . ((Functions::check_user_access(['{surveys_stats_view}']) == true) ? '<a class="big" href="/surveys/stats/' . $value['id'] . '"><i class="fas fa-chart-pie"></i><span>{$lang.stats}</span></a>' : '') . '
						' . ((Functions::check_user_access(['{surveys_questions_create}','{surveys_questions_update}','{surveys_questions_deactivate}','{surveys_questions_activate}','{surveys_questions_delete}']) == true) ? '<a class="big" href="/surveys/questions/' . $value['id'] . '"><i class="fas fa-ghost"></i><span>{$lang.questions}</span></a>' : '') . '
						' . ((Functions::check_user_access(['{surveys_questions_deactivate}','{surveys_questions_activate}']) == true) ? '<a class="big" data-action="' . (($value['status'] == true) ? 'deactivate_survey' : 'activate_survey') . '" data-id="' . $value['id'] . '">' . (($value['status'] == true) ? '<i class="fas fa-ban"></i><span>{$lang.deactivate}</span>' : '<i class="fas fa-check"></i><span>{$lang.activate}</span>') . '</a>' : '') . '
						' . ((Functions::check_user_access(['{surveys_questions_update}']) == true) ? '<a class="edit" data-action="edit_survey" data-id="' . $value['id'] . '"><i class="fas fa-pen"></i></a>' : '') . '
						' . ((Functions::check_user_access(['{surveys_questions_delete}']) == true) ? '<a class="delete" data-action="delete_survey" data-id="' . $value['id'] . '"><i class="fas fa-trash"></i></a>' : '') . '
					</div>
				</div>';
			}

			$replace = [
				'{$tbl_surveys}' => $tbl_surveys
			];

			$template = $this->format->replace($replace, $template);

			echo $template;
		}
	}

	public function questions($params)
	{
		$survey = $this->model->get_survey($params[0]);

		if (!empty($survey))
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

				if ($_POST['action'] == 'new_survey_question' OR $_POST['action'] == 'edit_survey_question')
				{
					$labels = [];

					if (!isset($_POST['name_es']) OR empty($_POST['name_es']))
						array_push($labels, ['name_es','']);

					if (!isset($_POST['name_en']) OR empty($_POST['name_en']))
						array_push($labels, ['name_en','']);

					if (!isset($_POST['type']) OR empty($_POST['type']))
						array_push($labels, ['type','']);

					if ($_POST['type'] == 'check')
					{
						$_POST['values'] = json_decode($_POST['values'], true);

						if (!isset($_POST['values']) OR empty($_POST['values']))
						{
							array_push($labels, ['value_es','']);
							array_push($labels, ['value_en','']);
						}
					}

					if (empty($labels))
					{
						if ($_POST['action'] == 'new_survey_question')
						{
							$_POST['survey'] = $params[0];

							$query = $this->model->new_survey_question($_POST);
						}
						else if ($_POST['action'] == 'edit_survey_question')
							$query = $this->model->edit_survey_question($_POST);

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

				if ($_POST['action'] == 'deactivate_survey_question' OR $_POST['action'] == 'activate_survey_question' OR $_POST['action'] == 'delete_survey_question')
				{
					if ($_POST['action'] == 'deactivate_survey_question')
						$query = $this->model->deactivate_survey_question($_POST['id']);
					else if ($_POST['action'] == 'activate_survey_question')
						$query = $this->model->activate_survey_question($_POST['id']);
					else if ($_POST['action'] == 'delete_survey_question')
						$query = $this->model->delete_survey_question($_POST['id']);

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
				$template = $this->view->render($this, 'questions');

				define('_title', 'Guestvox | {$lang.survey} | {$lang.questions}');

				$tbl_surveys_questions = '';

				foreach ($this->model->get_surveys_questions($params[0]) as $value)
				{
					$tbl_surveys_questions .=
					'<div>
						<div data-level="1">
							<h2>' . $value['name'][$this->lang] . '</h2>
							<div class="' . $value['type'] . '">';

					if ($value['type'] == 'nps')
					{
						$tbl_surveys_questions .=
						'<div>
							<label><i>1</i><input type="radio" disabled></label>
							<label><i>2</i><input type="radio" disabled></label>
							<label><i>3</i><input type="radio" disabled></label>
							<label><i>4</i><input type="radio" disabled></label>
							<label><i>5</i><input type="radio" disabled></label>
						</div>
						<div>
							<label><i>6</i><input type="radio" disabled></label>
							<label><i>7</i><input type="radio" disabled></label>
							<label><i>8</i><input type="radio" disabled></label>
							<label><i>9</i><input type="radio" disabled></label>
							<label><i>10</i><input type="radio" disabled></label>
						</div>';
					}
					else if ($value['type'] == 'open')
						$tbl_surveys_questions .= '<input type="text" disabled>';
					else if ($value['type'] == 'rate')
					{
						$tbl_surveys_questions .=
						'<label><i class="fas fa-sad-cry"></i><input type="radio" disabled></label>
						<label><i class="fas fa-frown"></i><input type="radio" disabled></label>
						<label><i class="fas fa-meh-rolling-eyes"></i><input type="radio" disabled></label>
						<label><i class="fas fa-smile"></i><input type="radio" disabled></label>
						<label><i class="fas fa-grin-stars"></i><input type="radio" disabled></label>';
					}
					else if ($value['type'] == 'twin')
					{
						$tbl_surveys_questions .=
						'<label><i class="fas fa-thumbs-up"></i><input type="radio" disabled></label>
						<label><i class="fas fa-thumbs-down"></i><input type="radio" disabled></label>';
					}
					else if ($value['type'] == 'check')
					{
						$tbl_surveys_questions .= '<div class="checkboxes stl_3">';

						foreach ($value['values'] as $subvalue)
						{
							$tbl_surveys_questions .=
							'<div>
								<input type="checkbox" disabled>
								<span>' . $subvalue[$this->lang] . '</span>
							</div>';
						}

						$tbl_surveys_questions .= '</div>';
					}

					$tbl_surveys_questions .= '</div>';

					if ($value['system'] == false)
					{
						$tbl_surveys_questions .=
						'<div class="buttons">
							' . ((Functions::check_user_access(['{surveys_questions_deactivate}','{surveys_questions_activate}']) == true) ? '<a class="big" data-action="' . (($value['status'] == true) ? 'deactivate_survey_question' : 'activate_survey_question') . '" data-id="' . $value['id'] . '">' . (($value['status'] == true) ? '<i class="fas fa-ban"></i><span>{$lang.deactivate}</span>' : '<i class="fas fa-check"></i><span>{$lang.activate}</span>') . '</a>' : '') . '
							' . ((Functions::check_user_access(['{surveys_questions_update}']) == true) ? '<a class="edit" data-action="edit_survey_question" data-id="' . $value['id'] . '"><i class="fas fa-pen"></i></a>' : '') . '
							' . ((Functions::check_user_access(['{surveys_questions_delete}']) == true) ? '<a class="delete" data-action="delete_survey_question" data-id="' . $value['id'] . '"><i class="fas fa-trash"></i></a>' : '') . '
						</div>';
					}

					$tbl_surveys_questions .= '</div>';

					foreach ($this->model->get_surveys_questions($params[0], 'all', $value['id']) as $subvalue)
					{
						$tbl_surveys_questions .=
						'<div data-level="2">
							<h2>' . $subvalue['name'][$this->lang] . '</h2>
							<div class="' . $subvalue['type'] . '">';

						if ($subvalue['type'] == 'open')
							$tbl_surveys_questions .= '<input type="text" disabled>';
						else if ($subvalue['type'] == 'rate')
						{
							$tbl_surveys_questions .=
							'<label><i class="fas fa-sad-cry"></i><input type="radio" disabled></label>
							<label><i class="fas fa-frown"></i><input type="radio" disabled></label>
							<label><i class="fas fa-meh-rolling-eyes"></i><input type="radio" disabled></label>
							<label><i class="fas fa-smile"></i><input type="radio" disabled></label>
							<label><i class="fas fa-grin-stars"></i><input type="radio" disabled></label>';
						}
						else if ($subvalue['type'] == 'twin')
						{
							$tbl_surveys_questions .=
							'<label><i class="fas fa-thumbs-up"></i><input type="radio" disabled></label>
							<label><i class="fas fa-thumbs-down"></i><input type="radio" disabled></label>';
						}
						else if ($subvalue['type'] == 'check')
						{
							$tbl_surveys_questions .= '<div class="checkboxes stl_3">';

							foreach ($subvalue['values'] as $parentvalue)
							{
								$tbl_surveys_questions .=
								'<div>
									<input type="checkbox" disabled>
									<span>' . $parentvalue[$this->lang] . '</span>
								</div>';
							}

							$tbl_surveys_questions .= '</div>';
						}

						$tbl_surveys_questions .= '</div>';

						if ($subvalue['system'] == false)
						{
							$tbl_surveys_questions .=
							'<div class="buttons">
								' . ((Functions::check_user_access(['{surveys_questions_deactivate}','{surveys_questions_activate}']) == true) ? '<a data-action="' . (($subvalue['status'] == true) ? 'deactivate_survey_question' : 'activate_survey_question') . '" data-id="' . $subvalue['id'] . '">' . (($subvalue['status'] == true) ? '<i class="fas fa-ban"></i>' : '<i class="fas fa-check"></i>') . '</a>' : '') . '
								' . ((Functions::check_user_access(['{surveys_questions_update}']) == true) ? '<a class="edit" data-action="edit_survey_question" data-id="' . $subvalue['id'] . '"><i class="fas fa-pen"></i></a>' : '') . '
								' . ((Functions::check_user_access(['{surveys_questions_delete}']) == true) ? '<a class="delete" data-action="delete_survey_question" data-id="' . $subvalue['id'] . '"><i class="fas fa-trash"></i></a>' : '') . '
							</div>';
						}

						$tbl_surveys_questions .= '</div>';

						foreach ($this->model->get_surveys_questions($params[0], 'all', $subvalue['id']) as $parentvalue)
						{
							$tbl_surveys_questions .=
							'<div data-level="3">
								<h2>' . $parentvalue['name'][$this->lang] . '</h2>
								<div class="' . $parentvalue['type'] . '">';

							if ($parentvalue['type'] == 'open')
								$tbl_surveys_questions .= '<input type="text" disabled>';
							else if ($parentvalue['type'] == 'rate')
							{
								$tbl_surveys_questions .=
								'<label><i class="fas fa-sad-cry"></i><input type="radio" disabled></label>
								<label><i class="fas fa-frown"></i><input type="radio" disabled></label>
								<label><i class="fas fa-meh-rolling-eyes"></i><input type="radio" disabled></label>
								<label><i class="fas fa-smile"></i><input type="radio" disabled></label>
								<label><i class="fas fa-grin-stars"></i><input type="radio" disabled></label>';
							}
							else if ($parentvalue['type'] == 'twin')
							{
								$tbl_surveys_questions .=
								'<label><i class="fas fa-thumbs-up"></i><input type="radio" disabled></label>
								<label><i class="fas fa-thumbs-down"></i><input type="radio" disabled></label>';
							}
							else if ($parentvalue['type'] == 'check')
							{
								$tbl_surveys_questions .= '<div class="checkboxes stl_3">';

								foreach ($parentvalue['values'] as $childvalue)
								{
									$tbl_surveys_questions .=
									'<div>
										<input type="checkbox" disabled>
										<span>' . $childvalue[$this->lang] . '</span>
									</div>';
								}

								$tbl_surveys_questions .= '</div>';
							}

							$tbl_surveys_questions .= '</div>';

							if ($parentvalue['system'] == false)
							{
								$tbl_surveys_questions .=
								'<div class="buttons">
									' . ((Functions::check_user_access(['{surveys_questions_deactivate}','{surveys_questions_activate}']) == true) ? '<a data-action="' . (($parentvalue['status'] == true) ? 'deactivate_survey_question' : 'activate_survey_question') . '" data-id="' . $parentvalue['id'] . '">' . (($parentvalue['status'] == true) ? '<i class="fas fa-ban"></i>' : '<i class="fas fa-check"></i>') . '</a>' : '') . '
									' . ((Functions::check_user_access(['{surveys_questions_update}']) == true) ? '<a class="edit" data-action="edit_survey_question" data-id="' . $parentvalue['id'] . '"><i class="fas fa-pen"></i></a>' : '') . '
									' . ((Functions::check_user_access(['{surveys_questions_delete}']) == true) ? '<a class="delete" data-action="delete_survey_question" data-id="' . $parentvalue['id'] . '"><i class="fas fa-trash"></i></a>' : '') . '
								</div>';
							}

							$tbl_surveys_questions .= '</div>';
						}
					}

					$tbl_surveys_questions .= '</div>';
				}

				$opt_surveys_questions = '';

				foreach ($this->model->get_surveys_questions($params[0], 'actives') as $value)
				{
					$opt_surveys_questions .= '<option value="' . $value['id'] . '">' . $value['name'][$this->lang] . '</option>';

					foreach ($this->model->get_surveys_questions($params[0], 'actives', $value['id']) as $subvalue)
						$opt_surveys_questions .= '<option value="' . $subvalue['id'] . '">- ' . $subvalue['name'][$this->lang] . '</option>';
				}

				$replace = [
					'{$tbl_surveys_questions}' => $tbl_surveys_questions,
					'{$opt_surveys_questions}' => $opt_surveys_questions
				];

				$template = $this->format->replace($replace, $template);

				echo $template;
			}
		}
		else
			header('Location: /surveys');
	}

	public function answers($params)
	{
		$survey = $this->model->get_survey($params[1]);

		if (!empty($survey))
		{
			if (Format::exist_ajax_request() == true)
			{
				if ($_POST['action'] == 'filter_surveys_answers')
				{
					$settings = Session::get_value('settings');

					$settings['surveys']['answers']['filter']['started_date'] = $_POST['started_date'];
					$settings['surveys']['answers']['filter']['end_date'] = $_POST['end_date'];
					$settings['surveys']['answers']['filter']['owner'] = $_POST['owner'];
					$settings['surveys']['answers']['filter']['rating'] = $_POST['rating'];

					Session::set_value('settings', $settings);

					Functions::environment([
						'status' => 'success'
					]);
				}

				if ($_POST['action'] == 'preview_survey_answer')
				{
					$query = $this->model->get_survey_answer($_POST['id']);

					if (!empty($query))
					{
						$html = '<div class="rating">';

						if ($query['average'] < 2)
							$html .= '<span class="bad"><i class="fas fa-star"></i>' . $query['average'] . '</span>';
						else if ($query['average'] >= 2 AND $query['average'] < 4)
							$html .= '<span class="medium"><i class="fas fa-star"></i>' . $query['average'] . '</span>';
						else if ($query['average'] >= 4)
							$html .= '<span class="good"><i class="fas fa-star"></i>' . $query['average'] . '</span>';

						$html .=
						'</div>
						<div class="datas">
							<span>' . $query['token'] . '</span>
							<h2>' . (!empty($query['owner']) ? ((Session::get_value('account')['type'] == 'hotel' AND !empty($query['reservation']['firstname']) AND !empty($query['reservation']['lastname'])) ? $query['reservation']['firstname'] . ' ' . $query['reservation']['lastname'] : '{$lang.not_name}') : $query['firstname'] . ' ' . $query['lastname']) . '</h2>
							<span><i class="fas fa-shapes"></i>' . (!empty($query['owner']) ? $query['owner_name'][$this->lang] . (!empty($query['owner_number']) ? ' #' . $query['owner_number'] : '') : 'Sin propietario') . '</span>
							<span><i class="fas fa-calendar-alt"></i>' . Functions::get_formatted_date($query['date'], 'd.m.Y') . ' ' . Functions::get_formatted_hour($query['hour'], '+ hrs') . '</span>
						</div>';

						if (Session::get_value('account')['type'] == 'hotel' AND !empty($query['owner']))
						{
							$html .=
							'<div class="reservation">
								<span><strong>{$lang.room}:</strong> ' . $query['owner_name'][$this->lang] . (!empty($query['owner_number']) ? ' #' . $query['owner_number'] : '') . '</span>
								<span><strong>{$lang.guest}:</strong> ' . ((!empty($query['reservation']['firstname']) AND !empty($query['reservation']['lastname'])) ? $query['reservation']['firstname'] . ' ' . $query['reservation']['lastname'] : '{$lang.not_name}') . '</span>
								<span><strong>{$lang.reservation_number}:</strong> ' . (!empty($query['reservation']['reservation_number']) ? $query['reservation']['reservation_number'] : '{$lang.not_reservation_number}') . '</span>
								<span><strong>{$lang.check_in}:</strong> ' . (!empty($query['reservation']['check_in']) ? $query['reservation']['check_in'] : '{$lang.not_check_in}') . '</span>
								<span><strong>{$lang.check_out}:</strong> ' . (!empty($query['reservation']['check_out']) ? $query['reservation']['check_out'] : '{$lang.not_check_out}') . '</span>
								<span><strong>{$lang.nationality}:</strong> ' . (!empty($query['reservation']['nationality']) ? $query['reservation']['nationality'] : '{$lang.not_nationality}') . '</span>
								<span><strong>{$lang.input_channel}:</strong> ' . (!empty($query['reservation']['input_channel']) ? $query['reservation']['input_channel'] : '{$lang.not_input_channel}') . '</span>
								<span><strong>{$lang.traveler_type}:</strong> ' . (!empty($query['reservation']['traveler_type']) ? $query['reservation']['traveler_type'] : '{$lang.not_traveler_type}') . '</span>
								<span><strong>{$lang.age_group}:</strong> ' . (!empty($query['reservation']['age_group']) ? $query['reservation']['age_group'] : '{$lang.not_age_group}') . '</span>
							</div>';
						}

						$html .=
						'<div class="comment">
							<p>' . (!empty($query['comment']) ? '<i class="fas fa-quote-left"></i>' . $query['comment'] . '<i class="fas fa-quote-right"></i>' : '{$lang.not_commentary}') . '</p>
						</div>
						<div class="tbl_stl_5">';

						foreach ($this->model->get_surveys_questions($params[1]) as $value)
						{
							$html .=
							'<div>
								<div data-level="1">
									<h2>' . $value['name'][$this->lang] . '</h2>
									<div class="' . $value['type'] . '">';

							if ($value['type'] == 'nps')
							{
								$html .=
								'<div>
									<label class="' . ((array_key_exists($value['id'], $query['values']) AND $query['values'][$value['id']] == '1') ? 'focus' : '') . '"><i>1</i><input type="radio" disabled></label>
									<label class="' . ((array_key_exists($value['id'], $query['values']) AND $query['values'][$value['id']] == '2') ? 'focus' : '') . '"><i>2</i><input type="radio" disabled></label>
									<label class="' . ((array_key_exists($value['id'], $query['values']) AND $query['values'][$value['id']] == '3') ? 'focus' : '') . '"><i>3</i><input type="radio" disabled></label>
									<label class="' . ((array_key_exists($value['id'], $query['values']) AND $query['values'][$value['id']] == '4') ? 'focus' : '') . '"><i>4</i><input type="radio" disabled></label>
									<label class="' . ((array_key_exists($value['id'], $query['values']) AND $query['values'][$value['id']] == '5') ? 'focus' : '') . '"><i>5</i><input type="radio" disabled></label>
								</div>
								<div>
									<label class="' . ((array_key_exists($value['id'], $query['values']) AND $query['values'][$value['id']] == '6') ? 'focus' : '') . '"><i>6</i><input type="radio" disabled></label>
									<label class="' . ((array_key_exists($value['id'], $query['values']) AND $query['values'][$value['id']] == '7') ? 'focus' : '') . '"><i>7</i><input type="radio" disabled></label>
									<label class="' . ((array_key_exists($value['id'], $query['values']) AND $query['values'][$value['id']] == '8') ? 'focus' : '') . '"><i>8</i><input type="radio" disabled></label>
									<label class="' . ((array_key_exists($value['id'], $query['values']) AND $query['values'][$value['id']] == '9') ? 'focus' : '') . '"><i>9</i><input type="radio" disabled></label>
									<label class="' . ((array_key_exists($value['id'], $query['values']) AND $query['values'][$value['id']] == '10') ? 'focus' : '') . '"><i>10</i><input type="radio" disabled></label>
								</div>';
							}
							else if ($value['type'] == 'open')
								$html .= '<input type="text" value="' . (array_key_exists($value['id'], $query['values']) ? $query['values'][$value['id']] : '') . '" disabled>';
							else if ($value['type'] == 'rate')
							{
								$html .=
								'<label class="' . ((array_key_exists($value['id'], $query['values']) AND $query['values'][$value['id']] == '1') ? 'focus' : '') . '"><i class="fas fa-sad-cry"></i><input type="radio" disabled></label>
								<label class="' . ((array_key_exists($value['id'], $query['values']) AND $query['values'][$value['id']] == '2') ? 'focus' : '') . '"><i class="fas fa-frown"></i><input type="radio" disabled></label>
								<label class="' . ((array_key_exists($value['id'], $query['values']) AND $query['values'][$value['id']] == '3') ? 'focus' : '') . '"><i class="fas fa-meh-rolling-eyes"></i><input type="radio" disabled></label>
								<label class="' . ((array_key_exists($value['id'], $query['values']) AND $query['values'][$value['id']] == '4') ? 'focus' : '') . '"><i class="fas fa-smile"></i><input type="radio" disabled></label>
								<label class="' . ((array_key_exists($value['id'], $query['values']) AND $query['values'][$value['id']] == '5') ? 'focus' : '') . '"><i class="fas fa-grin-stars"></i><input type="radio" disabled></label>';
							}
							else if ($value['type'] == 'twin')
							{
								$html .=
								'<label class="' . ((array_key_exists($value['id'], $query['values']) AND $query['values'][$value['id']] == 'yes') ? 'focus' : '') . '"><i class="fas fa-thumbs-up"></i><input type="radio" disabled></label>
								<label class="' . ((array_key_exists($value['id'], $query['values']) AND $query['values'][$value['id']] == 'not') ? 'focus' : '') . '"><i class="fas fa-thumbs-down"></i><input type="radio" disabled></label>';
							}
							else if ($value['type'] == 'check')
							{
								$html .= '<div class="checkboxes stl_3">';

								foreach ($value['values'] as $subvalue)
								{
									$html .=
									'<div>
										<input type="checkbox" ' . ((array_key_exists($value['id'], $query['values']) AND in_array($subvalue['token'], $query['values'][$value['id']])) ? 'checked' : '') . ' disabled>
										<span>' . $subvalue[$this->lang] . '</span>
									</div>';
								}

								$html .= '</div>';
							}

							$html .=
							'	</div>
							</div>';

							foreach ($this->model->get_surveys_questions($params[1], 'all', $value['id']) as $subvalue)
							{
								$html .=
								'<div data-level="2">
									<h2>' . $subvalue['name'][$this->lang] . '</h2>
									<div class="' . $subvalue['type'] . '">';

								if ($subvalue['type'] == 'open')
									$html .= '<input type="text" value="' . (array_key_exists($subvalue['id'], $query['values']) ? $query['values'][$subvalue['id']] : '') . '" disabled>';
								else if ($subvalue['type'] == 'rate')
								{
									$html .=
									'<label class="' . ((array_key_exists($subvalue['id'], $query['values']) AND $query['values'][$subvalue['id']] == '1') ? 'focus' : '') . '"><i class="fas fa-sad-cry"></i><input type="radio" disabled></label>
									<label class="' . ((array_key_exists($subvalue['id'], $query['values']) AND $query['values'][$subvalue['id']] == '2') ? 'focus' : '') . '"><i class="fas fa-frown"></i><input type="radio" disabled></label>
									<label class="' . ((array_key_exists($subvalue['id'], $query['values']) AND $query['values'][$subvalue['id']] == '3') ? 'focus' : '') . '"><i class="fas fa-meh-rolling-eyes"></i><input type="radio" disabled></label>
									<label class="' . ((array_key_exists($subvalue['id'], $query['values']) AND $query['values'][$subvalue['id']] == '4') ? 'focus' : '') . '"><i class="fas fa-smile"></i><input type="radio" disabled></label>
									<label class="' . ((array_key_exists($subvalue['id'], $query['values']) AND $query['values'][$subvalue['id']] == '5') ? 'focus' : '') . '"><i class="fas fa-grin-stars"></i><input type="radio" disabled></label>';
								}
								else if ($subvalue['type'] == 'twin')
								{
									$html .=
									'<label class="' . ((array_key_exists($subvalue['id'], $query['values']) AND $query['values'][$subvalue['id']] == 'yes') ? 'focus' : '') . '"><i class="fas fa-thumbs-up"></i><input type="radio" disabled></label>
									<label class="' . ((array_key_exists($subvalue['id'], $query['values']) AND $query['values'][$subvalue['id']] == 'not') ? 'focus' : '') . '"><i class="fas fa-thumbs-down"></i><input type="radio" disabled></label>';
								}
								else if ($subvalue['type'] == 'check')
								{
									$html .= '<div class="checkboxes stl_3">';

									foreach ($subvalue['values'] as $parentvalue)
									{
										$html .=
										'<div>
											<input type="checkbox" ' . ((array_key_exists($subvalue['id'], $query['values']) AND in_array($parentvalue['token'], $query['values'][$subvalue['id']])) ? 'checked' : '') . ' disabled>
											<span>' . $parentvalue[$this->lang] . '</span>
										</div>';
									}

									$html .= '</div>';
								}

								$html .=
								'	</div>
								</div>';

								foreach ($this->model->get_surveys_questions($params[1], 'all', $subvalue['id']) as $parentvalue)
								{
									$html .=
									'<div data-level="3">
										<h2>' . $parentvalue['name'][$this->lang] . '</h2>
										<div class="' . $parentvalue['type'] . '">';

									if ($parentvalue['type'] == 'open')
										$html .= '<input type="text" value="' . (array_key_exists($parentvalue['id'], $query['values']) ? $query['values'][$parentvalue['id']] : '') . '" disabled>';
									else if ($parentvalue['type'] == 'rate')
									{
										$html .=
										'<label class="' . ((array_key_exists($parentvalue['id'], $query['values']) AND $query['values'][$parentvalue['id']] == '1') ? 'focus' : '') . '"><i class="fas fa-sad-cry"></i><input type="radio" disabled></label>
										<label class="' . ((array_key_exists($parentvalue['id'], $query['values']) AND $query['values'][$parentvalue['id']] == '2') ? 'focus' : '') . '"><i class="fas fa-frown"></i><input type="radio" disabled></label>
										<label class="' . ((array_key_exists($parentvalue['id'], $query['values']) AND $query['values'][$parentvalue['id']] == '3') ? 'focus' : '') . '"><i class="fas fa-meh-rolling-eyes"></i><input type="radio" disabled></label>
										<label class="' . ((array_key_exists($parentvalue['id'], $query['values']) AND $query['values'][$parentvalue['id']] == '4') ? 'focus' : '') . '"><i class="fas fa-smile"></i><input type="radio" disabled></label>
										<label class="' . ((array_key_exists($parentvalue['id'], $query['values']) AND $query['values'][$parentvalue['id']] == '5') ? 'focus' : '') . '"><i class="fas fa-grin-stars"></i><input type="radio" disabled></label>';
									}
									else if ($parentvalue['type'] == 'twin')
									{
										$html .=
										'<label class="' . ((array_key_exists($parentvalue['id'], $query['values']) AND $query['values'][$parentvalue['id']] == 'yes') ? 'focus' : '') . '"><i class="fas fa-thumbs-up"></i><input type="radio" disabled></label>
										<label class="' . ((array_key_exists($parentvalue['id'], $query['values']) AND $query['values'][$parentvalue['id']] == 'not') ? 'focus' : '') . '"><i class="fas fa-thumbs-down"></i><input type="radio" disabled></label>';
									}
									else if ($parentvalue['type'] == 'check')
									{
										$html .= '<div class="checkboxes stl_3">';

										foreach ($parentvalue['values'] as $childvalue)
										{
											$html .=
											'<div>
												<input type="checkbox" ' . ((array_key_exists($parentvalue['id'], $query['values']) AND in_array($childvalue['token'], $query['values'][$parentvalue['id']])) ? 'checked' : '') . ' disabled>
												<span>' . $childvalue[$this->lang] . '</span>
											</div>';
										}

										$html .= '</div>';
									}

									$html .=
									'	</div>
									</div>';
								}
							}

							$html .= '</div>';
						}

						if (!empty($query['signature']))
						{
							$html .=
							'<figure style="width:100%;">
								<img src="{$path.uploads}' . $query['signature'] . '" style="width:100%;" />
							</figure>';
						}

						$html .= '</div>';

						Functions::environment([
							'status' => 'success',
							'html' => $html
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

				if ($_POST['action'] == 'get_survey_reservation')
				{
					$query = $this->model->get_survey_answer($_POST['id']);

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

				if ($_POST['action'] == 'edit_reservation')
				{
					$query = $this->model->edit_survey_reservation($_POST);

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

				if ($_POST['action'] == 'print_survey_answer')
				{
					$query = $this->model->get_survey_answer($_POST['id']);

					if (!empty($query))
					{
						$html = '<div>';

						foreach ($this->model->get_surveys_questions($params[1]) as $value)
						{
							$html .=
							'<div style="margin-bottom:20px;padding:20px;border: 1px dashed #000;box-sizing:border-box;">
								<div>
									<h2 style="font-family:arial;font-size:16px;font-weight;600;color:#000;">' . $value['name'][$this->lang] . '</h2>
									<div>';

							if ($value['type'] == 'nps')
							{
								$html .=
								'<div style="display:flex;align-items:center;justify-content:flex-start;">
									<h4 style="width:30px;height:30px;display:flex;align-items:center;justify-content:center;margin-right:5px;border-radius:50%;font-family:arial;font-size:14px;font-weight;400;color:#000;' . ((array_key_exists($value['id'], $query['values']) AND $query['values'][$value['id']] == '1') ? 'border:1px dashed #000;' : '') . '">1</h4>
									<h4 style="width:30px;height:30px;display:flex;align-items:center;justify-content:center;margin-right:5px;border-radius:50%;font-family:arial;font-size:14px;font-weight;400;color:#000;' . ((array_key_exists($value['id'], $query['values']) AND $query['values'][$value['id']] == '2') ? 'border:1px dashed #000;' : '') . '">2</h4>
									<h4 style="width:30px;height:30px;display:flex;align-items:center;justify-content:center;margin-right:5px;border-radius:50%;font-family:arial;font-size:14px;font-weight;400;color:#000;' . ((array_key_exists($value['id'], $query['values']) AND $query['values'][$value['id']] == '3') ? 'border:1px dashed #000;' : '') . '">3</h4>
									<h4 style="width:30px;height:30px;display:flex;align-items:center;justify-content:center;margin-right:5px;border-radius:50%;font-family:arial;font-size:14px;font-weight;400;color:#000;' . ((array_key_exists($value['id'], $query['values']) AND $query['values'][$value['id']] == '4') ? 'border:1px dashed #000;' : '') . '">4</h4>
									<h4 style="width:30px;height:30px;display:flex;align-items:center;justify-content:center;margin-right:5px;border-radius:50%;font-family:arial;font-size:14px;font-weight;400;color:#000;' . ((array_key_exists($value['id'], $query['values']) AND $query['values'][$value['id']] == '5') ? 'border:1px dashed #000;' : '') . '">5</h4>
									<h4 style="width:30px;height:30px;display:flex;align-items:center;justify-content:center;margin-right:5px;border-radius:50%;font-family:arial;font-size:14px;font-weight;400;color:#000;' . ((array_key_exists($value['id'], $query['values']) AND $query['values'][$value['id']] == '6') ? 'border:1px dashed #000;' : '') . '">6</h4>
									<h4 style="width:30px;height:30px;display:flex;align-items:center;justify-content:center;margin-right:5px;border-radius:50%;font-family:arial;font-size:14px;font-weight;400;color:#000;' . ((array_key_exists($value['id'], $query['values']) AND $query['values'][$value['id']] == '7') ? 'border:1px dashed #000;' : '') . '">7</h4>
									<h4 style="width:30px;height:30px;display:flex;align-items:center;justify-content:center;margin-right:5px;border-radius:50%;font-family:arial;font-size:14px;font-weight;400;color:#000;' . ((array_key_exists($value['id'], $query['values']) AND $query['values'][$value['id']] == '8') ? 'border:1px dashed #000;' : '') . '">8</h4>
									<h4 style="width:30px;height:30px;display:flex;align-items:center;justify-content:center;margin-right:5px;border-radius:50%;font-family:arial;font-size:14px;font-weight;400;color:#000;' . ((array_key_exists($value['id'], $query['values']) AND $query['values'][$value['id']] == '9') ? 'border:1px dashed #000;' : '') . '">9</h4>
									<h4 style="width:30px;height:30px;display:flex;align-items:center;justify-content:center;margin-right:5px;border-radius:50%;font-family:arial;font-size:14px;font-weight;400;color:#000;' . ((array_key_exists($value['id'], $query['values']) AND $query['values'][$value['id']] == '10') ? 'border:1px dashed #000;' : '') . '">10</h4>
								</div>';
							}
							else if ($value['type'] == 'open')
								$html .= '<h4 style="font-family:arial;font-size:14px;font-weight;400;color:#000;">' . (array_key_exists($value['id'], $query['values']) ? $query['values'][$value['id']] : '') . '</h4>';
							else if ($value['type'] == 'rate')
							{
								$html .=
								'<h4 style="width:30px;height:30px;display:flex;align-items:center;justify-content:center;margin-right:5px;border-radius:50%;font-family:arial;font-size:14px;font-weight;400;color:#000;' . ((array_key_exists($value['id'], $query['values']) AND $query['values'][$value['id']] == '1') ? 'border:1px dashed #000;' : '') . '">1</h4>
								<h4 style="width:30px;height:30px;display:flex;align-items:center;justify-content:center;margin-right:5px;border-radius:50%;font-family:arial;font-size:14px;font-weight;400;color:#000;' . ((array_key_exists($value['id'], $query['values']) AND $query['values'][$value['id']] == '2') ? 'border:1px dashed #000;' : '') . '">2</h4>
								<h4 style="width:30px;height:30px;display:flex;align-items:center;justify-content:center;margin-right:5px;border-radius:50%;font-family:arial;font-size:14px;font-weight;400;color:#000;' . ((array_key_exists($value['id'], $query['values']) AND $query['values'][$value['id']] == '3') ? 'border:1px dashed #000;' : '') . '">3</h4>
								<h4 style="width:30px;height:30px;display:flex;align-items:center;justify-content:center;margin-right:5px;border-radius:50%;font-family:arial;font-size:14px;font-weight;400;color:#000;' . ((array_key_exists($value['id'], $query['values']) AND $query['values'][$value['id']] == '4') ? 'border:1px dashed #000;' : '') . '">4</h4>
								<h4 style="width:30px;height:30px;display:flex;align-items:center;justify-content:center;margin-right:5px;border-radius:50%;font-family:arial;font-size:14px;font-weight;400;color:#000;' . ((array_key_exists($value['id'], $query['values']) AND $query['values'][$value['id']] == '5') ? 'border:1px dashed #000;' : '') . '">5</h4>';
							}
							else if ($value['type'] == 'twin')
							{
								$html .=
								'<h4 style="width:30px;height:30px;display:flex;align-items:center;justify-content:center;margin-right:5px;border-radius:50%;font-family:arial;font-size:14px;font-weight;400;color:#000;' . ((array_key_exists($value['id'], $query['values']) AND $query['values'][$value['id']] == 'yes') ? 'border:1px dashed #000;' : '') . '">Si</h4>
								<h4 style="width:30px;height:30px;display:flex;align-items:center;justify-content:center;margin-right:5px;border-radius:50%;font-family:arial;font-size:14px;font-weight;400;color:#000;' . ((array_key_exists($value['id'], $query['values']) AND $query['values'][$value['id']] == 'not') ? 'border:1px dashed #000;' : '') . '">No</h4>';
							}
							else if ($value['type'] == 'check')
							{
								$html .= '<div style="display:flex;align-items:center;justify-content:flex-start;">';

								foreach ($value['values'] as $subvalue)
									$html .= '<h4 style="width:auto;height:30px;display:flex;align-items:center;justify-content:center;margin-right:5px;padding:0px 10px;border-radius:30px;box-sizing:border-box;font-family:arial;font-size:14px;font-weight;400;color:#000;' . ((array_key_exists($value['id'], $query['values']) AND in_array($subvalue['token'], $query['values'][$value['id']])) ? 'border:1px dashed #000;' : '') . '">' . $subvalue[$this->lang] . '</h4>';

								$html .= '</div>';
							}

							$html .=
							'	</div>
							</div>';

							foreach ($this->model->get_surveys_questions($params[1], 'all', $value['id']) as $subvalue)
							{
								$html .=
								'<div style="margin-bottom:20px;padding:20px;border: 1px dashed #000;box-sizing:border-box;">
									<h2 style="font-family:arial;font-size:16px;font-weight;600;color:#000;">' . $subvalue['name'][$this->lang] . '</h2>
									<div>';

								if ($subvalue['type'] == 'open')
									$html .= '<h4 style="font-family:arial;font-size:14px;font-weight;400;color:#000;">' . (array_key_exists($subvalue['id'], $query['values']) ? $query['values'][$subvalue['id']] : '') . '</h4>';
								else if ($subvalue['type'] == 'rate')
								{
									$html .=
									'<h4 style="width:30px;height:30px;display:flex;align-items:center;justify-content:center;margin-right:5px;border-radius:50%;font-family:arial;font-size:14px;font-weight;400;color:#000;' . ((array_key_exists($subvalue['id'], $query['values']) AND $query['values'][$subvalue['id']] == '1') ? 'border:1px dashed #000;' : '') . '">1</h4>
									<h4 style="width:30px;height:30px;display:flex;align-items:center;justify-content:center;margin-right:5px;border-radius:50%;font-family:arial;font-size:14px;font-weight;400;color:#000;' . ((array_key_exists($subvalue['id'], $query['values']) AND $query['values'][$subvalue['id']] == '2') ? 'border:1px dashed #000;' : '') . '">2</h4>
									<h4 style="width:30px;height:30px;display:flex;align-items:center;justify-content:center;margin-right:5px;border-radius:50%;font-family:arial;font-size:14px;font-weight;400;color:#000;' . ((array_key_exists($subvalue['id'], $query['values']) AND $query['values'][$subvalue['id']] == '3') ? 'border:1px dashed #000;' : '') . '">3</h4>
									<h4 style="width:30px;height:30px;display:flex;align-items:center;justify-content:center;margin-right:5px;border-radius:50%;font-family:arial;font-size:14px;font-weight;400;color:#000;' . ((array_key_exists($subvalue['id'], $query['values']) AND $query['values'][$subvalue['id']] == '4') ? 'border:1px dashed #000;' : '') . '">4</h4>
									<h4 style="width:30px;height:30px;display:flex;align-items:center;justify-content:center;margin-right:5px;border-radius:50%;font-family:arial;font-size:14px;font-weight;400;color:#000;' . ((array_key_exists($subvalue['id'], $query['values']) AND $query['values'][$subvalue['id']] == '5') ? 'border:1px dashed #000;' : '') . '">5</h4>';
								}
								else if ($subvalue['type'] == 'twin')
								{
									$html .=
									'<h4 style="width:30px;height:30px;display:flex;align-items:center;justify-content:center;margin-right:5px;border-radius:50%;font-family:arial;font-size:14px;font-weight;400;color:#000;' . ((array_key_exists($subvalue['id'], $query['values']) AND $query['values'][$subvalue['id']] == 'yes') ? 'border:1px dashed #000;' : '') . '">Si</h4>
									<h4 style="width:30px;height:30px;display:flex;align-items:center;justify-content:center;margin-right:5px;border-radius:50%;font-family:arial;font-size:14px;font-weight;400;color:#000;' . ((array_key_exists($subvalue['id'], $query['values']) AND $query['values'][$subvalue['id']] == 'not') ? 'border:1px dashed #000;' : '') . '">No</h4>';
								}
								else if ($subvalue['type'] == 'check')
								{
									$html .= '<div style="display:flex;align-items:center;justify-content:flex-start;">';

									foreach ($subvalue['values'] as $parentvalue)
										$html .= '<h4 style="width:auto;height:30px;display:flex;align-items:center;justify-content:center;margin-right:5px;padding:0px 10px;border-radius:30px;box-sizing:border-box;font-family:arial;font-size:14px;font-weight;400;color:#000;' . ((array_key_exists($subvalue['id'], $query['values']) AND in_array($parentvalue['token'], $query['values'][$subvalue['id']])) ? 'border:1px dashed #000;' : '') . '">' . $parentvalue[$this->lang] . '</h4>';

									$html .= '</div>';
								}

								$html .=
								'	</div>
								</div>';

								foreach ($this->model->get_surveys_questions($params[1], 'all', $subvalue['id']) as $parentvalue)
								{
									$html .=
									'<div style="margin-bottom:20px;padding:20px;border: 1px dashed #000;box-sizing:border-box;">
										<h2 style="font-family:arial;font-size:16px;font-weight;600;color:#000;">' . $parentvalue['name'][$this->lang] . '</h2>
										<div>';

									if ($parentvalue['type'] == 'open')
										$html .= '<h4 style="font-family:arial;font-size:14px;font-weight;400;color:#000;">' . (array_key_exists($parentvalue['id'], $query['values']) ? $query['values'][$parentvalue['id']] : '') . '</h4>';
									else if ($parentvalue['type'] == 'rate')
									{
										$html .=
										'<h4 style="width:30px;height:30px;display:flex;align-items:center;justify-content:center;margin-right:5px;border-radius:50%;font-family:arial;font-size:14px;font-weight;400;color:#000;' . ((array_key_exists($parentvalue['id'], $query['values']) AND $query['values'][$parentvalue['id']] == '1') ? 'border:1px dashed #000;' : '') . '">1</h4>
										<h4 style="width:30px;height:30px;display:flex;align-items:center;justify-content:center;margin-right:5px;border-radius:50%;font-family:arial;font-size:14px;font-weight;400;color:#000;' . ((array_key_exists($parentvalue['id'], $query['values']) AND $query['values'][$parentvalue['id']] == '2') ? 'border:1px dashed #000;' : '') . '">2</h4>
										<h4 style="width:30px;height:30px;display:flex;align-items:center;justify-content:center;margin-right:5px;border-radius:50%;font-family:arial;font-size:14px;font-weight;400;color:#000;' . ((array_key_exists($parentvalue['id'], $query['values']) AND $query['values'][$parentvalue['id']] == '3') ? 'border:1px dashed #000;' : '') . '">3</h4>
										<h4 style="width:30px;height:30px;display:flex;align-items:center;justify-content:center;margin-right:5px;border-radius:50%;font-family:arial;font-size:14px;font-weight;400;color:#000;' . ((array_key_exists($parentvalue['id'], $query['values']) AND $query['values'][$parentvalue['id']] == '4') ? 'border:1px dashed #000;' : '') . '">4</h4>
										<h4 style="width:30px;height:30px;display:flex;align-items:center;justify-content:center;margin-right:5px;border-radius:50%;font-family:arial;font-size:14px;font-weight;400;color:#000;' . ((array_key_exists($parentvalue['id'], $query['values']) AND $query['values'][$parentvalue['id']] == '5') ? 'border:1px dashed #000;' : '') . '">5</h4>';
									}
									else if ($parentvalue['type'] == 'twin')
									{
										$html .=
										'<h4 style="width:30px;height:30px;display:flex;align-items:center;justify-content:center;margin-right:5px;border-radius:50%;font-family:arial;font-size:14px;font-weight;400;color:#000;' . ((array_key_exists($parentvalue['id'], $query['values']) AND $query['values'][$parentvalue['id']] == 'yes') ? 'border:1px dashed #000;' : '') . '">Si</h4>
										<h4 style="width:30px;height:30px;display:flex;align-items:center;justify-content:center;margin-right:5px;border-radius:50%;font-family:arial;font-size:14px;font-weight;400;color:#000;' . ((array_key_exists($parentvalue['id'], $query['values']) AND $query['values'][$parentvalue['id']] == 'not') ? 'border:1px dashed #000;' : '') . '">No</h4>';
									}
									else if ($parentvalue['type'] == 'check')
									{
										$html .= '<div style="display:flex;align-items:center;justify-content:flex-start;">';

										foreach ($parentvalue['values'] as $childvalue)
											$html .= '<h4 style="width:auto;height:30px;display:flex;align-items:center;justify-content:center;margin-right:5px;padding:0px 10px;border-radius:30px;box-sizing:border-box;font-family:arial;font-size:14px;font-weight;400;color:#000;' . ((array_key_exists($parentvalue['id'], $query['values']) AND in_array($childvalue['token'], $query['values'][$parentvalue['id']])) ? 'border:1px dashed #000;' : '') . '">' . $childvalue[$this->lang] . '</h4>';

										$html .= '</div>';
									}

									$html .=
									'	</div>
									</div>';
								}
							}

							$html .= '</div>';
						}

						$html .= '</div>';

						Functions::environment([
							'status' => 'success',
							'html' => $html
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

				if ($_POST['action'] == 'public_survey_comment' OR $_POST['action'] == 'unpublic_survey_comment')
				{
					if ($_POST['action'] == 'public_survey_comment')
						$query = $this->model->public_survey_comment($_POST['id']);
					else if ($_POST['action'] == 'unpublic_survey_comment')
						$query = $this->model->unpublic_survey_comment($_POST['id']);

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
				define('_title', 'Guestvox | {$lang.survey} | {$lang.answers}');

				$template = $this->view->render($this, 'answers');

				$tbl_surveys_raters = '';
				$tbl_surveys_comments = '';
				$mdl_public_survey_comment = '';
				$mdl_unpublic_survey_comment = '';

				if ($params[0] == 'raters')
				{
					$tbl_surveys_raters .= '<div class="tbl_stl_8" data-table>';

					foreach ($this->model->get_surveys_answers($params[1], 'raters') as $value)
					{
						$tbl_surveys_raters .=
						'<div>
							<div class="counter">
								<h6>' . $value['id'] . '</h6>
							</div>
							<div class="rating">';

						if ($value['average'] < 2)
							$tbl_surveys_raters .= '<span class="bad"><i class="fas fa-star"></i>' . $value['average'] . '</span>';
						else if ($value['average'] >= 2 AND $value['average'] < 4)
							$tbl_surveys_raters .= '<span class="medium"><i class="fas fa-star"></i>' . $value['average'] . '</span>';
						else if ($value['average'] >= 4)
							$tbl_surveys_raters .= '<span class="good"><i class="fas fa-star"></i>' . $value['average'] . '</span>';

						$tbl_surveys_raters .=
						'	</div>
							<div class="datas">
								<span>' . $value['token'] . '</span>
								<h2>' . (!empty($value['owner']) ? ((Session::get_value('account')['type'] == 'hotel' AND !empty($query['reservation']['firstname']) AND !empty($query['reservation']['lastname'])) ? $query['reservation']['firstname'] . ' ' . $query['reservation']['lastname'] : '{$lang.not_name}') : $value['firstname'] . ' ' . $value['lastname']) . '</h2>
								<span><i class="fas fa-calendar-alt"></i>' . Functions::get_formatted_date($value['date'], 'd.m.Y') . ' ' . Functions::get_formatted_hour($value['hour'], '+ hrs') . '</span>
								<span><i class="fas fa-shapes"></i>' . (!empty($value['owner']) ? $value['owner_name'][$this->lang] . (!empty($value['owner_number']) ? ' #' . $value['owner_number'] : '') : 'Sin propietario') . '</span>
							</div>
							<div class="buttons">
								<a class="big" data-action="preview_survey_answer" data-id="' . $value['id'] . '"><i class="fas fa-ghost"></i><span>{$lang.survey}</span></a>
								<a data-action="print_survey_answer" data-id="' . $value['id'] . '"><i class="fas fa-print"></i></a>
								<a class="edit" data-action="edit_reservation" data-id="' . $value['id'] . '"><i class="fas fa-pen"></i></a>
							</div>
						</div>';
					}

					$tbl_surveys_raters .= '</div>';
				}
				else if ($params[0] == 'comments')
				{
					$tbl_surveys_comments .= '<div class="tbl_stl_2" data-table>';

					foreach ($this->model->get_surveys_answers($params[1], 'comments') as $value)
					{
						if (!empty($value['comment']))
						{
							$tbl_surveys_comments .=
							'<div>
								<div class="datas">
									<h2>' . (!empty($value['owner']) ? ((Session::get_value('account')['type'] == 'hotel' AND !empty($value['reservation']['firstname']) AND !empty($value['reservation']['lastname'])) ? $value['reservation']['firstname'] . ' ' . $value['reservation']['lastname'] : '{$lang.not_name}') : $value['firstname'] . ' ' . $value['lastname']) . '</h2>
									<span><i class="fas fa-star"></i>' . $value['token'] . '</span>
									<span><i class="fas fa-calendar-alt"></i>' . Functions::get_formatted_date($value['date'], 'd.m.Y') . ' ' . Functions::get_formatted_hour($value['hour'], '+ hrs') . '</span>
									<span><i class="fas fa-shapes"></i>' . (!empty($value['owner']) ? $value['owner_name'][$this->lang] . (!empty($value['owner_number']) ? ' #' . $value['owner_number'] : '') : 'Sin propietario') . '</span>
									<p><i class="fas fa-comment-alt"></i>' . $value['comment'] . '</p>
								</div>
								<div class="buttons flex_right">
									<a class="' . (($value['public'] == true) ? 'delete' : 'new') . ' big" data-action="' . (($value['public'] == true) ? 'unpublic_survey_comment' : 'public_survey_comment') . '" data-id="' . $value['id'] . '">' . (($value['public'] == true) ? '{$lang.unpublic_survey_comment}' : '{$lang.public_survey_comment}') . '</a>
									<a class="big" data-action="preview_survey_answer" data-id="' . $value['id'] . '"><i class="fas fa-ghost"></i><span>{$lang.survey}</span></a>
								</div>
							</div>';
						}
					}

					$tbl_surveys_comments .= '</div>';

					$mdl_public_survey_comment .=
					'<section class="modal edit" data-modal="public_survey_comment">
						<div class="content">
							<footer>
								<a button-close><i class="fas fa-times"></i></a>
								<a button-success><i class="fas fa-check"></i></a>
							</footer>
						</div>
					</section>';

					$mdl_unpublic_survey_comment .=
					'<section class="modal edit" data-modal="unpublic_survey_comment">
						<div class="content">
							<footer>
								<a button-close><i class="fas fa-times"></i></a>
								<a button-success><i class="fas fa-check"></i></a>
							</footer>
						</div>
					</section>';
				}

				$opt_owners = '';

				foreach ($this->model->get_owners('survey') as $value)
					$opt_owners .= '<option value="' . $value['id'] . '" ' . ((Session::get_value('settings')['surveys']['answers']['filter']['owner'] == $value['id']) ? 'selected' : '') . '>' . $value['name'][$this->lang] . (!empty($value['number']) ? ' #' . $value['number'] : '') . '</option>';

				$opt_ladas = '';

				foreach ($this->model->get_countries() as $value)
					$opt_ladas .= '<option value="' . $value['lada'] . '">' . $value['name'][$this->lang] . ' (+' . $value['lada'] . ')</option>';

				$replace = [
					'{$menu_focus}' => $params[0],
					'{$tbl_surveys_raters}' => $tbl_surveys_raters,
					'{$tbl_surveys_comments}' => $tbl_surveys_comments,
					'{$mdl_public_survey_comment}' => $mdl_public_survey_comment,
					'{$mdl_unpublic_survey_comment}' => $mdl_unpublic_survey_comment,
					'{$opt_owners}' => $opt_owners,
					'{$opt_ladas}' => $opt_ladas
				];

				$template = $this->format->replace($replace, $template);

				echo $template;
			}
		}
		else
			header('Location: /surveys');
	}

	public function stats($params)
	{
		if (Format::exist_ajax_request() == true)
		{
			if ($_POST['action'] == 'filter_surveys_stats')
			{
				$settings = Session::get_value('settings');

				$settings['surveys']['stats']['filter']['started_date'] = $_POST['started_date'];
				$settings['surveys']['stats']['filter']['end_date'] = $_POST['end_date'];
				$settings['surveys']['stats']['filter']['owner'] = $_POST['owner'];

				Session::set_value('settings', $settings);

				Functions::environment([
					'status' => 'success'
				]);
			}
		}
		else
		{
			define('_title', 'Guestvox | {$lang.survey} | {$lang.stats}');

			$template = $this->view->render($this, 'stats');

			$surveys_average = $this->model->get_surveys_average((!empty($params) ? $params[0] : null));

			$h2_surveys_average = '';

			if ($surveys_average >= 0 AND $surveys_average < 1.8)
				$h2_surveys_average = '<h2 class="one">' . $surveys_average . '</h2>';
			else if ($surveys_average >= 1.8 AND $surveys_average < 2.8)
				$h2_surveys_average = '<h2 class="two">' . $surveys_average . '</h2>';
			else if ($surveys_average >= 2.8 AND $surveys_average < 3.8)
				$h2_surveys_average = '<h2 class="three">' . $surveys_average . '</h2>';
			else if ($surveys_average >= 3.8 AND $surveys_average < 4.8)
				$h2_surveys_average = '<h2 class="four">' . $surveys_average . '</h2>';
			else if ($surveys_average >= 4.8 AND $surveys_average <= 5)
				$h2_surveys_average = '<h2 class="five">' . $surveys_average . '</h2>';

			$spn_surveys_average =
			'<span>
				' . (($surveys_average >= 0 AND $surveys_average < 1.8) ? '<i class="fas fa-sad-cry one"></i>' : '<i class="far fa-sad-cry"></i>') . '
				' . (($surveys_average >= 1.8 AND $surveys_average < 2.8) ? '<i class="fas fa-frown two"></i>' : '<i class="far fa-frown"></i>') . '
				' . (($surveys_average >= 2.8 AND $surveys_average < 3.8) ? '<i class="fas fa-meh-rolling-eyes three"></i>' : '<i class="far fa-meh-rolling-eyes"></i>') . '
				' . (($surveys_average >= 3.8 AND $surveys_average < 4.8) ? '<i class="fas fa-smile four"></i>' : '<i class="far fa-smile"></i>') . '
				' . (($surveys_average >= 4.8 AND $surveys_average <= 5) ? '<i class="fas fa-grin-stars five"></i>' : '<i class="far fa-grin-stars"></i>') . '
			</span>';

			$opt_owners = '';

			foreach ($this->model->get_owners('survey') as $value)
				$opt_owners .= '<option value="' . $value['id'] . '" ' . ((Session::get_value('settings')['surveys']['stats']['filter']['owner'] == $value['id']) ? 'selected' : '') . '>' . $value['name'][$this->lang] . (!empty($value['number']) ? ' #' . $value['number'] : '') . '</option>';

			$replace = [
				'{$h2_surveys_average}' => $h2_surveys_average,
				'{$spn_surveys_average}' => $spn_surveys_average,
				'{$surveys_porcentage_one}' => $this->model->get_surveys_percentage((!empty($params) ? $params[0] : null), 'one'),
				'{$surveys_porcentage_two}' => $this->model->get_surveys_percentage((!empty($params) ? $params[0] : null), 'two'),
				'{$surveys_porcentage_tree}' => $this->model->get_surveys_percentage((!empty($params) ? $params[0] : null), 'tree'),
				'{$surveys_porcentage_four}' => $this->model->get_surveys_percentage((!empty($params) ? $params[0] : null), 'four'),
				'{$surveys_porcentage_five}' => $this->model->get_surveys_percentage((!empty($params) ? $params[0] : null), 'five'),
				'{$surveys_count_total}' => $this->model->get_surveys_count((!empty($params) ? $params[0] : null), 'total'),
				'{$surveys_count_today}' => $this->model->get_surveys_count((!empty($params) ? $params[0] : null), 'today'),
				'{$surveys_count_week}' => $this->model->get_surveys_count((!empty($params) ? $params[0] : null), 'week'),
				'{$surveys_count_month}' => $this->model->get_surveys_count((!empty($params) ? $params[0] : null), 'month'),
				'{$surveys_count_year}' => $this->model->get_surveys_count((!empty($params) ? $params[0] : null), 'year'),
				'{$opt_owners}' => $opt_owners,
				'{$return_btn}' => !empty($params) ? '<a href="/surveys" class="big delete"><i class="fas fa-times"></i></a>' : '',
				'{$chart_params}' => !empty($params) ? '/' . $params[0] : ''
			];

			$template = $this->format->replace($replace, $template);

			echo $template;
		}
	}

	public function charts($params)
	{
		header('Content-Type: application/javascript');

		$s1_chart_data = $this->model->get_chart_data((!empty($params) ? $params[0] : null), 's1_chart');
		$s2_chart_data = $this->model->get_chart_data((!empty($params) ? $params[0] : null), 's2_chart');

		if (Session::get_value('account')['type'] == 'hotel' AND Session::get_value('account')['zaviapms']['status'] == true)
		{
			$s4_chart_data = $this->model->get_chart_data((!empty($params) ? $params[0] : null), 's4_chart');
			$s5_chart_data = $this->model->get_chart_data((!empty($params) ? $params[0] : null), 's5_chart');
			$s6_chart_data = $this->model->get_chart_data((!empty($params) ? $params[0] : null), 's6_chart');
			$s7_chart_data = $this->model->get_chart_data((!empty($params) ? $params[0] : null), 's7_chart');
		}

		$js =
		"'use strict';

		var s1_chart = {
	        type: 'doughnut',
	        data: {
				labels: [
	                " . $s1_chart_data['labels'] . "
	            ],
				datasets: [{
					data: [
	                    " . $s1_chart_data['datasets']['data'] . "
	                ],
	                backgroundColor: [
	                    " . $s1_chart_data['datasets']['colors'] . "
	                ]
	            }]
	        },
	        options: {
				title: {
					display: true,
					text: '" . Languages::charts('s1_chart')[$this->lang] . "'
				},
				legend: {
					display: true,
					position: 'left'
				},
	            responsive: true
            }
        };

		var s2_chart = {
	        type: 'doughnut',
	        data: {
				labels: [
	                " . $s2_chart_data['labels'] . "
	            ],
				datasets: [{
					data: [
	                    " . $s2_chart_data['datasets']['data'] . "
	                ],
	                backgroundColor: [
	                    " . $s2_chart_data['datasets']['colors'] . "
	                ]
	            }]
	        },
	        options: {
				title: {
					display: true,
					text: '" . Languages::charts('s2_chart')[$this->lang] . "'
				},
				legend: {
					display: true,
					position: 'left'
				},
	            responsive: true
            }
        };";

		if (Session::get_value('account')['type'] == 'hotel' AND Session::get_value('account')['zaviapms']['status'] == true)
		{
			$js .=
			"var s4_chart = {
		        type: 'pie',
		        data: {
					labels: [
		                " . $s4_chart_data['labels'] . "
		            ],
					datasets: [{
						data: [
		                    " . $s4_chart_data['datasets']['data'] . "
		                ],
		                backgroundColor: [
		                    " . $s4_chart_data['datasets']['colors'] . "
		                ]
		            }]
		        },
		        options: {
					title: {
						display: true,
						text: '" . Languages::charts('s4_chart')[$this->lang] . "'
					},
					legend: {
						display: true,
						position: 'left'
					},
		            responsive: true
	            }
	        };

			var s5_chart = {
		        type: 'pie',
		        data: {
					labels: [
		                " . $s5_chart_data['labels'] . "
		            ],
					datasets: [{
						data: [
		                    " . $s5_chart_data['datasets']['data'] . "
		                ],
		                backgroundColor: [
		                    " . $s5_chart_data['datasets']['colors'] . "
		                ]
		            }]
		        },
		        options: {
					title: {
						display: true,
						text: '" . Languages::charts('s5_chart')[$this->lang] . "'
					},
					legend: {
						display: true,
						position: 'left'
					},
		            responsive: true
	            }
	        };

			var s6_chart = {
		        type: 'pie',
		        data: {
					labels: [
		                " . $s6_chart_data['labels'] . "
		            ],
					datasets: [{
						data: [
		                    " . $s6_chart_data['datasets']['data'] . "
		                ],
		                backgroundColor: [
		                    " . $s6_chart_data['datasets']['colors'] . "
		                ]
		            }]
		        },
		        options: {
					title: {
						display: true,
						text: '" . Languages::charts('s6_chart')[$this->lang] . "'
					},
					legend: {
						display: true,
						position: 'left'
					},
		            responsive: true
	            }
	        };

			var s7_chart = {
		        type: 'pie',
		        data: {
					labels: [
		                " . $s7_chart_data['labels'] . "
		            ],
					datasets: [{
						data: [
		                    " . $s7_chart_data['datasets']['data'] . "
		                ],
		                backgroundColor: [
		                    " . $s7_chart_data['datasets']['colors'] . "
		                ]
		            }]
		        },
		        options: {
					title: {
						display: true,
						text: '" . Languages::charts('s7_chart')[$this->lang] . "'
					},
					legend: {
						display: true,
						position: 'left'
					},
		            responsive: true
	            }
	        };";
		}

		$js .=
		"window.onload = function()
		{
			s1_chart = new Chart(document.getElementById('s1_chart').getContext('2d'), s1_chart);
			s2_chart = new Chart(document.getElementById('s2_chart').getContext('2d'), s2_chart);";

		if (Session::get_value('account')['type'] == 'hotel' AND Session::get_value('account')['zaviapms']['status'] == true)
		{
			$js .=
			"s4_chart = new Chart(document.getElementById('s4_chart').getContext('2d'), s4_chart);
			s5_chart = new Chart(document.getElementById('s5_chart').getContext('2d'), s5_chart);
			s6_chart = new Chart(document.getElementById('s6_chart').getContext('2d'), s6_chart);
			s7_chart = new Chart(document.getElementById('s7_chart').getContext('2d'), s7_chart);";
		}

		$js .= "};";

		$js = trim(str_replace(array("\t\t\t"), '', $js));

		echo $js;
	}
}
