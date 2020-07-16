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

	public function questions()
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
						$query = $this->model->new_survey_question($_POST);
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

			foreach ($this->model->get_surveys_questions() as $value)
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
						' . ((Functions::check_user_access(['{surveys_questions_deactivate}','{surveys_questions_activate}']) == true) ? '<a data-action="' . (($value['status'] == true) ? 'deactivate_survey_question' : 'activate_survey_question') . '" data-id="' . $value['id'] . '">' . (($value['status'] == true) ? '<i class="fas fa-ban"></i>' : '<i class="fas fa-check"></i>') . '</a>' : '') . '
						' . ((Functions::check_user_access(['{surveys_questions_update}']) == true) ? '<a class="edit" data-action="edit_survey_question" data-id="' . $value['id'] . '"><i class="fas fa-pen"></i></a>' : '') . '
						' . ((Functions::check_user_access(['{surveys_questions_delete}']) == true) ? '<a class="delete" data-action="delete_survey_question" data-id="' . $value['id'] . '"><i class="fas fa-trash"></i></a>' : '') . '
					</div>';
				}

				$tbl_surveys_questions .= '</div>';

				foreach ($this->model->get_surveys_questions('all', $value['id']) as $subvalue)
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

					foreach ($this->model->get_surveys_questions('all', $subvalue['id']) as $parentvalue)
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

			foreach ($this->model->get_surveys_questions('actives') as $value)
			{
				$opt_surveys_questions .= '<option value="' . $value['id'] . '">' . $value['name'][$this->lang] . '</option>';

				foreach ($this->model->get_surveys_questions('actives', $value['id']) as $subvalue)
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

	public function answers($params)
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
						<h2>' . ((!empty($query['firstname']) AND !empty($query['lastname'])) ? $query['firstname'] . ' ' . $query['lastname'] : '{$lang.not_name}') . '</h2>
						<span><i class="fas fa-envelope"></i>' . $query['email'] . '</span>
						<span><i class="fas fa-phone-alt"></i>' . ((!empty($query['phone']['lada']) AND !empty($query['phone']['number'])) ? '+ (' . $query['phone']['lada'] . ') ' . $query['phone']['number'] : '{$lang.not_phone}') . '</span>
						<span><i class="fas fa-shapes"></i>' . $query['owner_name'][$this->lang] . (!empty($query['owner_number']) ? ' #' . $query['owner_number'] : '') . '</span>
						<span><i class="fas fa-calendar-alt"></i>' . Functions::get_formatted_date($query['date'], 'd.m.Y') . ' ' . Functions::get_formatted_hour($query['hour'], '+ hrs') . '</span>
					</div>';

					if (Session::get_value('account')['type'] == 'hotel')
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
						<p>' . (!empty($query['comment']) ? '<i class="fas fa-quote-left"></i>' . $query['comment'] . '<i class="fas fa-quote-right"></i>' : '{$lang.not_comment}') . '</p>
					</div>
					<div class="tbl_stl_5">';

					foreach ($this->model->get_surveys_questions() as $value)
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

						foreach ($this->model->get_surveys_questions('all', $value['id']) as $subvalue)
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

								foreach ($subvalue['values'] as $subvalue)
								{
									$html .=
									'<div>
										<input type="checkbox" ' . ((array_key_exists($subvalue['id'], $query['values']) AND in_array($subvalue['token'], $query['values'][$subvalue['id']])) ? 'checked' : '') . ' disabled>
										<span>' . $subvalue[$this->lang] . '</span>
									</div>';
								}

								$html .= '</div>';
							}

							$html .=
							'	</div>
							</div>';

							foreach ($this->model->get_surveys_questions('all', $subvalue['id']) as $parentvalue)
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

									foreach ($parentvalue['values'] as $parentvalue)
									{
										$html .=
										'<div>
											<input type="checkbox" ' . ((array_key_exists($parentvalue['id'], $query['values']) AND in_array($parentvalue['token'], $query['values'][$parentvalue['id']])) ? 'checked' : '') . ' disabled>
											<span>' . $parentvalue[$this->lang] . '</span>
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

			if ($_POST['action'] == 'public_survey_answer' OR $_POST['action'] == 'unpublic_survey_answer')
			{
				if ($_POST['action'] == 'public_survey_answer')
					$query = $this->model->public_survey_answer($_POST['id']);
				else if ($_POST['action'] == 'unpublic_survey_answer')
					$query = $this->model->unpublic_survey_answer($_POST['id']);

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

			$html =
			'<div class="tabers">
				<div>
					<input id="rtsw" type="radio" value="raters" ' . (($params[0] == 'raters') ? 'checked' : '') . '>
					<label for="rtsw"><i class="fas fa-star"></i></label>
				</div>
				<div>
	                <input id="cmsw" type="radio" value="comments" ' . (($params[0] == 'comments') ? 'checked' : '') . '>
	                <label for="cmsw"><i class="fas fa-comment-alt"></i></label>
	            </div>
				<div>
	                <input id="ctsw" type="radio" value="contacts" ' . (($params[0] == 'contacts') ? 'checked' : '') . '>
	                <label for="ctsw"><i class="fas fa-address-book"></i></label>
	            </div>
			</div>';

			if ($params[0] == 'raters')
			{
				$html .= '<div class="tbl_stl_7">';

				foreach ($this->model->get_surveys_answers('raters') as $value)
				{
					$html .=
					'<div>
						<div class="rating">';

					if ($value['average'] < 2)
						$html .= '<span class="bad"><i class="fas fa-star"></i>' . $value['average'] . '</span>';
					else if ($value['average'] >= 2 AND $value['average'] < 4)
						$html .= '<span class="medium"><i class="fas fa-star"></i>' . $value['average'] . '</span>';
					else if ($value['average'] >= 4)
						$html .= '<span class="good"><i class="fas fa-star"></i>' . $value['average'] . '</span>';

					$html.=
					'	</div>
						<div class="datas">
							<span>' . $value['token'] . '</span>
							<h2>' . ((!empty($value['firstname']) AND !empty($value['lastname'])) ? $value['firstname'] . ' ' . $value['lastname'] : ((Session::get_value('account')['type'] == 'hotel') ? ((!empty($value['reservation']['firstname']) AND !empty($value['reservation']['lastname'])) ? $value['reservation']['firstname'] . ' ' . $value['reservation']['lastname'] : '{$lang.not_name}') : '{$lang.not_name}')) . '</h2>
							<span><i class="fas fa-calendar-alt"></i>' . Functions::get_formatted_date($value['date'], 'd.m.Y') . ' ' . Functions::get_formatted_hour($value['hour'], '+ hrs') . '</span>
							<span><i class="fas fa-shapes"></i>' . $value['owner_name'][$this->lang] . (!empty($value['owner_number']) ? ' #' . $value['owner_number'] : '') . '</span>
						</div>
						<div class="buttons">
							<a data-action="preview_survey_answer" data-id="' . $value['id'] . '"><i class="fas fa-eye"></i></a>
						</div>
					</div>';
				}

				$html .= '</div>';
			}
			else if ($params[0] == 'comments')
			{
				$html .= '<div class="tbl_stl_2">';

				foreach ($this->model->get_surveys_answers('comments') as $value)
				{
					if (!empty($value['comment']))
					{
						$html .=
						'<div>
							<div class="datas">
								<h2>' . ((!empty($value['firstname']) AND !empty($value['lastname'])) ? $value['firstname'] . ' ' . $value['lastname'] : ((Session::get_value('account')['type'] == 'hotel') ? ((!empty($value['reservation']['firstname']) AND !empty($value['reservation']['lastname'])) ? $value['reservation']['firstname'] . ' ' . $value['reservation']['lastname'] : '{$lang.not_name}') : '{$lang.not_name}')) . '</h2>
								<span><i class="fas fa-star"></i>' . $value['token'] . '</span>
								<span><i class="fas fa-calendar-alt"></i>' . Functions::get_formatted_date($value['date'], 'd.m.Y') . ' ' . Functions::get_formatted_hour($value['hour'], '+ hrs') . '</span>
								<span><i class="fas fa-shapes"></i>' . $value['owner_name'][$this->lang] . (!empty($value['owner_number']) ? ' #' . $value['owner_number'] : '') . '</span>
								<p><i class="fas fa-comment-alt"></i>' . $value['comment'] . '</p>
							</div>
							<div class="buttons flex_right">
								<a class="' . (($value['public'] == true) ? 'delete' : 'new') . ' big" data-action="' . (($value['public'] == true) ? 'unpublic_survey_answer' : 'public_survey_answer') . '" data-id="' . $value['id'] . '">' . (($value['public'] == true) ? '{$lang.unpublic_survey_answer}' : '{$lang.public_survey_answer}') . '</a>
								<a data-action="preview_survey_answer" data-id="' . $value['id'] . '"><i class="fas fa-star"></i></a>
							</div>
						</div>';
					}
				}

				$html .= '</div>';
			}
			else if ($params[0] == 'contacts')
			{
				$html .= '<div class="tbl_stl_2">';

				foreach ($this->model->get_surveys_answers('contacts') as $value)
				{
					if (!empty($value['email']) OR (!empty($value['phone']['lada']) AND !empty($value['phone']['number'])))
					{
						$html .=
						'<div>
							<div class="datas">
								<h2>' . ((!empty($value['firstname']) AND !empty($value['lastname'])) ? $value['firstname'] . ' ' . $value['lastname'] : ((Session::get_value('account')['type'] == 'hotel') ? ((!empty($value['reservation']['firstname']) AND !empty($value['reservation']['lastname'])) ? $value['reservation']['firstname'] . ' ' . $value['reservation']['lastname'] : '{$lang.not_name}') : '{$lang.not_name}')) . '</h2>
								<span><i class="fas fa-star"></i>' . $value['token'] . '</span>
								<span><i class="fas fa-calendar-alt"></i>' . Functions::get_formatted_date($value['date'], 'd.m.Y') . ' ' . Functions::get_formatted_hour($value['hour'], '+ hrs') . '</span>
								<span><i class="fas fa-shapes"></i>' . $value['owner_name'][$this->lang] . (!empty($value['owner_number']) ? ' #' . $value['owner_number'] : '') . '</span>
								<span><i class="fas fa-envelope"></i>' . (!empty($value['email']) ? $value['email'] : '{$lang.not_email}') . '</span>
								<span><i class="fas fa-phone"></i>' . ((!empty($value['phone']['lada']) AND !empty($value['phone']['number'])) ? '+ (' . $value['phone']['lada'] . ') ' . $value['phone']['number'] : '{$lang.not_phone}') . '</span>
							</div>
							<div class="buttons flex_right">
								<a data-action="preview_survey_answer" data-id="' . $value['id'] . '"><i class="fas fa-star"></i></a>
							</div>
						</div>';
					}
				}

				$html .= '</div>';
			}

			$opt_owners = '';

			foreach ($this->model->get_owners('survey') as $value)
				$opt_owners .= '<option value="' . $value['id'] . '" ' . ((Session::get_value('settings')['surveys']['answers']['filter']['owner'] == $value['id']) ? 'selected' : '') . '>' . $value['name'][$this->lang] . (!empty($value['number']) ? ' #' . $value['number'] : '') . '</option>';

			$replace = [
				'{$html}' => $html,
				'{$opt_owners}' => $opt_owners
			];

			$template = $this->format->replace($replace, $template);

			echo $template;
		}
	}

	public function stats()
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

			$surveys_average = $this->model->get_surveys_average();

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
				$opt_owners .= '<option value="' . $value['id'] . '" ' . ((Session::get_value('settings')['surveys']['answers']['filter']['owner'] == $value['id']) ? 'selected' : '') . '>' . $value['name'][$this->lang] . (!empty($value['number']) ? ' #' . $value['number'] : '') . '</option>';

			$replace = [
				'{$h2_surveys_average}' => $h2_surveys_average,
				'{$spn_surveys_average}' => $spn_surveys_average,
				'{$surveys_porcentage_one}' => $this->model->get_surveys_percentage('one'),
				'{$surveys_porcentage_two}' => $this->model->get_surveys_percentage('two'),
				'{$surveys_porcentage_tree}' => $this->model->get_surveys_percentage('tree'),
				'{$surveys_porcentage_four}' => $this->model->get_surveys_percentage('four'),
				'{$surveys_porcentage_five}' => $this->model->get_surveys_percentage('five'),
				'{$surveys_count_total}' => $this->model->get_surveys_count('total'),
				'{$surveys_count_today}' => $this->model->get_surveys_count('today'),
				'{$surveys_count_week}' => $this->model->get_surveys_count('week'),
				'{$surveys_count_month}' => $this->model->get_surveys_count('month'),
				'{$surveys_count_year}' => $this->model->get_surveys_count('year'),
				'{$opt_owners}' => $opt_owners
			];

			$template = $this->format->replace($replace, $template);

			echo $template;
		}
	}

	public function charts()
	{
		header('Content-Type: application/javascript');

		$s1_chart_data = $this->model->get_chart_data('s1_chart');
		$s2_chart_data = $this->model->get_chart_data('s2_chart');

		if (Session::get_value('account')['type'] == 'hotel' AND Session::get_value('account')['zaviapms']['status'] == true)
		{
			$s4_chart_data = $this->model->get_chart_data('s4_chart');
			$s5_chart_data = $this->model->get_chart_data('s5_chart');
			$s6_chart_data = $this->model->get_chart_data('s6_chart');
			$s7_chart_data = $this->model->get_chart_data('s7_chart');
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
