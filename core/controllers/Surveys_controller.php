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
		define('_title', 'GuestVox');

		$template = $this->view->render($this, 'index');

		if (Functions::check_user_access(['{survey_answers_view}']) == true)
			header('Location: /surveys/answers');
		else if (Functions::check_user_access(['{survey_stats_view}']) == true)
			header('Location: /surveys/stats');
		else if (Functions::check_user_access(['{survey_questions_create}','{survey_questions_update}','{survey_questions_deactivate}','{survey_questions_activate}','{survey_questions_delete}']) == true)
			header('Location: /surveys/questions');

		$replace = [

		];

		$template = $this->format->replace($replace, $template);

		echo $template;
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
						'data' => $query,
					]);
				}
				else
				{
					Functions::environment([
						'status' => 'error',
						'message' => '{$lang.operation_error}',
					]);
				}
			}

			if ($_POST['action'] == 'preview_survey_question')
			{
				$query = $this->model->get_survey_questions();

				$data = '';

				if (!empty($query))
				{
					foreach ($query as $value)
					{
						$data .=
						'<article>
						   <h6>' . $value['name'][Session::get_value('account')['language']] . '</h6>';

						if ($value['type'] == 'rate')
						{
							$data .=
							'<div>
							   <label><i class="far fa-thumbs-down"></i></label>
							   <label><input type="radio"></label>
							   <label><input type="radio"></label>
							   <label><input type="radio"></label>
							   <label><input type="radio"></label>
							   <label><input type="radio"></label>
							   <label><i class="far fa-thumbs-up"></i></label>
							</div>';
						}
						else if ($value['type'] == 'twin')
						{
							$data .=
							'<div>
							   <label>{$lang.to_yes}</label>
							   <label><input type="radio"></label>
							   <label><input type="radio"></label>
							   <label>{$lang.to_not}</label>
							</div>';
						}
						else if ($value['type'] == 'open')
						{
							$data .=
							'<div>
							   <input type="text">
							</div>';
						}

						$data .=
						'</article>';

						if (!empty($value['subquestions']))
						{
						   $data .=
						   '<article class="subquestions">';

							foreach ($value['subquestions'] as $key => $subvalue)
							{
							   $data .=
							   '<h6>' . $subvalue['name'][Session::get_value('lang')] . '</h6>';

							   if ($subvalue['type'] == 'rate')
							   {
								   $data .=
								   '<div>
									   <label><i class="far fa-thumbs-down"></i></label>
									   <label><input type="radio"></label>
									   <label><input type="radio"></label>
									   <label><input type="radio"></label>
									   <label><input type="radio"></label>
									   <label><input type="radio"></label>
									   <label><i class="far fa-thumbs-up"></i></label>
								   </div>';
							   }
							   else if ($subvalue['type'] == 'twin')
							   {
								   $data .=
								   '<div>
									   <label>{$lang.to_yes}</label>
									   <label><input type="radio"></label>
									   <label><input type="radio"></label>
									   <label>{$lang.to_not}</label>
								  </div>';
							   }
							   else if ($subvalue['type'] == 'open')
							   {
								   $data .=
								   '<div>
									   <input type="text"">
								   </div>';
							   }

							   if (!empty($subvalue['subquestions']))
							   {
								   $data .=
 	   						   	'<article class="subquestions-sub">';

								   foreach ($subvalue['subquestions'] as $childvalue)
								   {
									   $data .=
									   '<h6>' . $childvalue['name'][Session::get_value('lang')] . '</h6>';

									   if ($childvalue['type'] == 'rate')
									   {
										   $data .=
										   '<div>
											   <label><i class="far fa-thumbs-down"></i></label>
											   <label><input type="radio"></label>
											   <label><input type="radio"></label>
											   <label><input type="radio"></label>
											   <label><input type="radio"></label>
											   <label><input type="radio"></label>
											   <label><i class="far fa-thumbs-up"></i></label>
										   </div>';
									   }
									   else if ($childvalue['type'] == 'twin')
									   {
										   $data .=
										   '<div>
											   <label>{$lang.to_yes}</label>
											   <label><input type="radio"></label>
											   <label><input type="radio"></label>
											   <label>{$lang.to_not}</label>
										  </div>';
									   }
									   else if ($childvalue['type'] == 'open')
									   {
										   $data .=
										   '<div>
											   <input type="text"">
										   </div>';
									   }

								   }
								   $data .=
	   							'</article>';
							   }
							}

							$data .=
							'</article>';
						}

					}

					Functions::environment([
						'status' => 'success',
						'data' => $data,
					]);
				}
				else
				{
					Functions::environment([
						'status' => 'error',
						'message' => '{$lang.operation_error}',
					]);
				}

			}

			if ($_POST['action'] == 'new_survey_question' OR $_POST['action'] == 'edit_survey_question' OR $_POST['action'] == 'new_survey_subquestion' OR $_POST['action'] == 'edit_survey_subquestion' OR $_POST['action'] == 'new_survey_subquestion_sub' OR $_POST['action'] == 'edit_survey_subquestion_sub' OR $_POST['action'] == 'deactivate_survey_subquestion' OR $_POST['action'] == 'activate_survey_subquestion' OR $_POST['action'] == 'delete_survey_subquestion' OR $_POST['action'] == 'deactivate_survey_subquestion_sub' OR $_POST['action'] == 'activate_survey_subquestion_sub' OR $_POST['action'] == 'delete_survey_subquestion_sub')
			{
				$labels = [];

				if ($_POST['action'] == 'new_survey_question' OR $_POST['action'] == 'edit_survey_question' OR $_POST['action'] == 'new_survey_subquestion' OR $_POST['action'] == 'edit_survey_subquestion' OR $_POST['action'] == 'new_survey_subquestion_sub' OR $_POST['action'] == 'edit_survey_subquestion_sub')
				{
					if (!isset($_POST['name_es']) OR empty($_POST['name_es']))
						array_push($labels, ['name_es', '']);

					if (!isset($_POST['name_en']) OR empty($_POST['name_en']))
						array_push($labels, ['name_en', '']);

					if (!isset($_POST['type']) OR empty($_POST['type']))
						array_push($labels, ['type', '']);
				}

				if (empty($labels))
				{
					if ($_POST['action'] == 'new_survey_question')
						$query = $this->model->new_survey_question($_POST);
					else if ($_POST['action'] == 'edit_survey_question')
						$query = $this->model->edit_survey_question($_POST);
					else if ($_POST['action'] == 'new_survey_subquestion' OR $_POST['action'] == 'edit_survey_subquestion' OR $_POST['action'] == 'new_survey_subquestion_sub' OR $_POST['action'] == 'edit_survey_subquestion_sub' OR $_POST['action'] == 'deactivate_survey_subquestion' OR $_POST['action'] == 'activate_survey_subquestion' OR $_POST['action'] == 'delete_survey_subquestion' OR $_POST['action'] == 'deactivate_survey_subquestion_sub' OR $_POST['action'] == 'activate_survey_subquestion_sub' OR $_POST['action'] == 'delete_survey_subquestion_sub')
					{
						$tmp = $this->model->get_survey_question($_POST['id']);

						if ($_POST['action'] == 'new_survey_subquestion')
						{
							array_push($tmp['subquestions'], [
								'id' => Functions::get_random(8),
								'name' => [
									'es' => $_POST['name_es'],
									'en' => $_POST['name_en'],
								],
								'subquestions' => [],
								'type' => $_POST['type'],
								'status' => true,
							]);
						}
						else if ($_POST['action'] == 'new_survey_subquestion_sub')
						{
							foreach ($tmp['subquestions'] as $key => $value)
							{
								if ($_POST['key'] == $key)
								{
									array_push($tmp['subquestions'][$key]['subquestions'], [
										'id' => Functions::get_random(8),
										'name' => [
											'es' => $_POST['name_es'],
											'en' => $_POST['name_en'],
										],
										'type' => $_POST['type'],
										'status' => true,
									]);

								}
							}

						}
						else if ($_POST['action'] == 'edit_survey_subquestion')
						{
							$tmp['subquestions'][$_POST['key']]['name'] = [
								'es' => $_POST['name_es'],
								'en' => $_POST['name_en'],
							];

							$tmp['subquestions'][$_POST['key']]['type'] = $_POST['type'];
						}
						else if ($_POST['action'] == 'edit_survey_subquestion_sub')
						{
							foreach ($tmp['subquestions'] as $key => $value)
							{
								if ($_POST['key'] == $key)
								{
									$tmp['subquestions'][$_POST['key']]['subquestions'][$_POST['childkey']]['name'] = [
										'es' => $_POST['name_es'],
										'en' => $_POST['name_en'],
									];

									$tmp['subquestions'][$_POST['key']]['subquestions'][$_POST['childkey']]['type'] = $_POST['type'];
								}
							}

						}
						else if ($_POST['action'] == 'deactivate_survey_subquestion')
							$tmp['subquestions'][$_POST['key']]['status'] = false;
						else if ($_POST['action'] == 'activate_survey_subquestion')
							$tmp['subquestions'][$_POST['key']]['status'] = true;
						else if ($_POST['action'] == 'delete_survey_subquestion')
							unset($tmp['subquestions'][$_POST['key']]);
						else if ($_POST['action'] == 'delete_survey_subquestion_sub')
						{
							foreach ($tmp['subquestions'] as $key => $value)
							{
								if ($_POST['key'] == $key)
								{
									unset($tmp['subquestions'][$_POST['key']]['subquestions'][$_POST['childkey']]);
								}
							}

						}
						else if ($_POST['action'] == 'deactivate_survey_subquestion_sub')
						{
							foreach ($tmp['subquestions'] as $key => $value)
							{
								if ($_POST['key'] == $key)
								{
									$tmp['subquestions'][$_POST['key']]['subquestions'][$_POST['childkey']]['status'] = false;
								}
							}

						}
						else if ($_POST['action'] == 'activate_survey_subquestion_sub')
						{
							foreach ($tmp['subquestions'] as $key => $value)
							{
								if ($_POST['key'] == $key)
								{
									$tmp['subquestions'][$_POST['key']]['subquestions'][$_POST['childkey']]['status'] = true;
								}
							}

						}
						$query = $this->model->edit_survey_subquestions($_POST['id'], $tmp['subquestions']);
					}

					if (!empty($query))
					{
						Functions::environment([
							'status' => 'success',
							'message' => '{$lang.operation_success}',
						]);
					}
					else
					{
						Functions::environment([
							'status' => 'error',
							'message' => '{$lang.operation_error}',
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

			if ($_POST['action'] == 'deactivate_survey_question')
			{
				$query = $this->model->deactivate_survey_question($_POST['id']);

				if (!empty($query))
				{
					Functions::environment([
						'status' => 'success',
						'message' => '{$lang.operation_success}',
					]);
				}
				else
				{
					Functions::environment([
						'status' => 'error',
						'message' => '{$lang.operation_error}',
					]);
				}
			}

			if ($_POST['action'] == 'activate_survey_question')
			{
				$query = $this->model->activate_survey_question($_POST['id']);

				if (!empty($query))
				{
					Functions::environment([
						'status' => 'success',
						'message' => '{$lang.operation_success}',
					]);
				}
				else
				{
					Functions::environment([
						'status' => 'error',
						'message' => '{$lang.operation_error}',
					]);
				}
			}

			if ($_POST['action'] == 'delete_survey_question')
			{
				$query = $this->model->delete_survey_question($_POST['id']);

				if (!empty($query))
				{
					Functions::environment([
						'status' => 'success',
						'message' => '{$lang.operation_success}',
					]);
				}
				else
				{
					Functions::environment([
						'status' => 'error',
						'message' => '{$lang.operation_error}',
					]);
				}
			}
		}
		else
		{
			define('_title', 'GuestVox');

			$template = $this->view->render($this, 'questions');

			$tbl_survey_questions = '';

			foreach ($this->model->get_survey_questions() as $value)
			{
				$tbl_survey_questions .=
				'<tr class="marked">
					<td align="left">' . $value['name'][Session::get_value('account')['language']] . '</td>
					<td align="left">{$lang.' . $value['type'] . '}</td>
					<td align="left">' . (($value['status'] == true) ? '{$lang.active}' : '{$lang.deactive}') . '</td>
					' . ((Functions::check_user_access(['{survey_questions_create}']) == true) ? '<td align="right" class="icon">' . (($value['status'] == true AND $value['type'] != 'open') ? '<a data-action="new_survey_subquestion" data-id="' . $value['id'] . '"><i class="fas fa-plus"></i></a>' : '') . '</td>' : '') . '
					' . ((Functions::check_user_access(['{survey_questions_delete}']) == true) ? '<td align="right" class="icon">' . (($value['status'] == true) ? '<a data-action="delete_survey_question" data-id="' . $value['id'] . '" class="delete"><i class="fas fa-trash"></i></a>' : '') . '</td>' : '') . '
					' . ((Functions::check_user_access(['{survey_questions_deactivate}','{survey_questions_activate}']) == true) ? '<td align="right" class="icon">' . (($value['status'] == true) ? '<a data-action="deactivate_survey_question" data-id="' . $value['id'] . '"><i class="fas fa-ban"></i></a>' : '<a data-action="activate_survey_question" data-id="' . $value['id'] . '"><i class="fas fa-check"></i></a>') . '</td>' : '') . '
					' . ((Functions::check_user_access(['{survey_questions_update}']) == true) ? '<td align="right" class="icon">' . (($value['status'] == true) ? '<a data-action="edit_survey_question" data-id="' . $value['id'] . '" class="edit"><i class="fas fa-pen"></i></a>' : '') . '</td>' : '') . '
				</tr>';

				foreach ($value['subquestions'] as $subkey => $subvalue)
				{
					$tbl_survey_questions .=
					'<tr class="sub-40">
						<td align="left">' . $subvalue['name'][Session::get_value('account')['language']] . '</td>
						<td align="left">{$lang.' . $subvalue['type'] . '}</td>
						<td align="left">' . (($subvalue['status'] == true) ? '{$lang.active}' : '{$lang.deactive}') . '</td>
						' . ((Functions::check_user_access(['{survey_questions_create}']) == true) ? '<td align="right" class="icon">' . (($subvalue['status'] == true AND $subvalue['type'] != 'open') ? '<a data-action="new_survey_subquestion_sub" data-id="' . $value['id'] . '" data-key="' . $subkey . '"><i class="fas fa-plus"></i></a>' : '') . '</td>' : '') . '
						' . ((Functions::check_user_access(['{survey_questions_delete}']) == true) ? '<td align="right" class="icon">' . (($subvalue['status'] == true) ? '<a data-action="delete_survey_subquestion" data-id="' . $value['id'] . '" data-key="' . $subkey . '" class="delete"><i class="fas fa-trash"></i></a>' : '') . '</td>' : '') . '
						' . ((Functions::check_user_access(['{survey_questions_deactivate}','{survey_questions_activate}']) == true) ? '<td align="right" class="icon">' . (($subvalue['status'] == true) ? '<a data-action="deactivate_survey_subquestion" data-id="' . $value['id'] . '" data-key="' . $subkey . '"><i class="fas fa-ban"></i></a>' : '<a data-action="activate_survey_subquestion" data-id="' . $value['id'] . '" data-key="' . $subkey . '"><i class="fas fa-check"></i></a>') . '</td>' : '') . '
						' . ((Functions::check_user_access(['{survey_questions_update}']) == true) ? '<td align="right" class="icon">' . (($subvalue['status'] == true) ? '<a data-action="edit_survey_subquestion" data-id="' . $value['id'] . '" data-key="' . $subkey . '" class="edit"><i class="fas fa-pen"></i></a>' : '') . '</td>' : '') . '
					</tr>';

					foreach ($subvalue['subquestions'] as $childkey => $childvalue)
					{
						$tbl_survey_questions .=
						'<tr class="sub-80">
							<td align="left">' . $childvalue['name'][Session::get_value('account')['language']] . '</td>
							<td align="left">{$lang.' . $childvalue['type'] . '}</td>
							<td align="left">' . (($childvalue['status'] == true) ? '{$lang.active}' : '{$lang.deactive}') . '</td>
							' . ((Functions::check_user_access(['{survey_questions_create}']) == true) ? '<td align="right" class="icon"></td>' : '') . '
							' . ((Functions::check_user_access(['{survey_questions_delete}']) == true) ? '<td align="right" class="icon">' . (($childvalue['status'] == true) ? '<a data-action="delete_survey_subquestion_sub" data-id="' . $value['id'] . '" data-key="' . $subkey . '" data-childkey="' . $childkey . '" class="delete"><i class="fas fa-trash"></i></a>' : '') . '</td>' : '') . '
							' . ((Functions::check_user_access(['{survey_questions_deactivate}','{survey_questions_activate}']) == true) ? '<td align="right" class="icon">' . (($childvalue['status'] == true) ? '<a data-action="deactivate_survey_subquestion_sub" data-id="' . $value['id'] . '" data-key="' . $subkey . '" data-childkey="' . $childkey . '"><i class="fas fa-ban"></i></a>' : '<a data-action="activate_survey_subquestion_sub" data-id="' . $value['id'] . '" data-key="' . $subkey . '" data-childkey="' . $childkey . '"><i class="fas fa-check"></i></a>') . '</td>' : '') . '
							' . ((Functions::check_user_access(['{survey_questions_update}']) == true) ? '<td align="right" class="icon">' . (($childvalue['status'] == true) ? '<a data-action="edit_survey_subquestion_sub" data-id="' . $value['id'] . '" data-key="' . $subkey . '" data-childkey="' . $childkey . '" class="edit"><i class="fas fa-pen"></i></a>' : '') . '</td>' : '') . '
						</tr>';
					}
				}
			}

			$replace = [
				'{$tbl_survey_questions}' => $tbl_survey_questions,
			];

			$template = $this->format->replace($replace, $template);

			echo $template;
		}
	}

	public function answers()
	{
		if (Format::exist_ajax_request() == true)
		{
			if ($_POST['action'] == 'get_survey_answer')
			{
				$query = $this->model->get_survey_answer($_POST['id']);

				if (!empty($query))
				{
					$data = '
					<div><strong>{$lang.token}:</strong> ' . $query['token']  . '</div>
					<div><strong>{$lang.room}:</strong> ' . $query['room']  . '</div>
					<div><strong>{$lang.date}:</strong> ' . Functions::get_formatted_date($query['date'], 'd M, y')  . '</div><br>';

					foreach ($query['answers'] as $value)
	                {
						$value['fk'] = $this->model->get_survey_question($value['id']);

						$data .=
						'<article>
							<h6>' . $value['fk']['name'][Session::get_value('account')['language']] . '</h6>
							<div>';

	                    if ($value['type'] == 'rate')
						{
							$data .=
		                    '<label><i class="far fa-thumbs-down"></i></label>
                            <label><input type="radio" ' . (($value['answer'] == 1) ? 'checked' : '') . ' disabled></label>
                            <label><input type="radio" ' . (($value['answer'] == 2) ? 'checked' : '') . ' disabled></label>
                            <label><input type="radio" ' . (($value['answer'] == 3) ? 'checked' : '') . ' disabled></label>
                            <label><input type="radio" ' . (($value['answer'] == 4) ? 'checked' : '') . ' disabled></label>
                            <label><input type="radio" ' . (($value['answer'] == 5) ? 'checked' : '') . ' disabled></label>
                            <label><i class="far fa-thumbs-up"></i></label>';
						}
						else if ($value['type'] == 'twin')
						{
							$data .=
							'<label>{$lang.to_yes}</label>
							<label><input type="radio" ' . (($value['answer'] == 'yes') ? 'checked' : '') . ' disabled></label>
							<label><input type="radio" ' . (($value['answer'] == 'no') ? 'checked' : '') . ' disabled></label>
							<label>{$lang.to_not}</label>';
						}
						else if ($value['type'] == 'open')
						{
							$data .=
							'<p>' . $value['answer'] . '</p>';
						}

						$data .=
						'</div>';

						if (!empty($value['subanswers']))
						{
							$data .=
							'<article>';

							foreach ($value['subanswers'] as $subkey => $subvalue)
							{
								$data .=
								'<h6>' . $value['fk']['subquestions'][$subkey]['name'][Session::get_value('account')['language']] . '</h6>
								<div>';

								if ($subvalue['type'] == 'rate')
								{
									$data .=
									'<label><i class="far fa-thumbs-down"></i></label>
									<label><input type="radio" ' . (($subvalue['answer'] == 1) ? 'checked' : '') . ' disabled></label>
									<label><input type="radio" ' . (($subvalue['answer'] == 2) ? 'checked' : '') . ' disabled></label>
									<label><input type="radio" ' . (($subvalue['answer'] == 3) ? 'checked' : '') . ' disabled></label>
									<label><input type="radio" ' . (($subvalue['answer'] == 4) ? 'checked' : '') . ' disabled></label>
									<label><input type="radio" ' . (($subvalue['answer'] == 5) ? 'checked' : '') . ' disabled></label>
									<label><i class="far fa-thumbs-up"></i></label>';
								}
								else if ($subvalue['type'] == 'twin')
								{
									$data .=
									'<label>{$lang.to_yes}</label>
									<label><input type="radio" ' . (($subvalue['answer'] == 'yes') ? 'checked' : '') . ' disabled></label>
									<label><input type="radio" ' . (($subvalue['answer'] == 'no') ? 'checked' : '') . ' disabled></label>
									<label>{$lang.to_not}</label>';
								}
								else if ($subvalue['type'] == 'open')
								{
									$data .=
									'<p>' . $subvalue['answer'] . '</p>';
								}

								$data .=
								'</div>';

								if (!empty($subvalue['subanswers']))
								{
									$data .=
									'<article class="sub">';

									foreach ($subvalue['subanswers'] as $childkey => $childvalue)
									{
										$data .=
										'<h6>' . $value['fk']['subquestions'][$subkey]['subquestions'][$childkey]['name'][Session::get_value('account')['language']] . '</h6>
										<div>';

										if ($childvalue['type'] == 'rate')
										{
											$data .=
											'<label><i class="far fa-thumbs-down"></i></label>
											<label><input type="radio" ' . (($childvalue['answer'] == 1) ? 'checked' : '') . ' disabled></label>
											<label><input type="radio" ' . (($childvalue['answer'] == 2) ? 'checked' : '') . ' disabled></label>
											<label><input type="radio" ' . (($childvalue['answer'] == 3) ? 'checked' : '') . ' disabled></label>
											<label><input type="radio" ' . (($childvalue['answer'] == 4) ? 'checked' : '') . ' disabled></label>
											<label><input type="radio" ' . (($childvalue['answer'] == 5) ? 'checked' : '') . ' disabled></label>
											<label><i class="far fa-thumbs-up"></i></label>';
										}
										else if ($childvalue['type'] == 'twin')
										{
											$data .=
											'<label>{$lang.to_yes}</label>
											<label><input type="radio" ' . (($childvalue['answer'] == 'yes') ? 'checked' : '') . ' disabled></label>
											<label><input type="radio" ' . (($childvalue['answer'] == 'no') ? 'checked' : '') . ' disabled></label>
											<label>{$lang.to_not}</label>';
										}
										else if ($childvalue['type'] == 'open')
										{
											$data .=
											'<p>' . $childvalue['answer'] . '</p>';
										}

										$data .=
										'</div>';

									}

									$data .=
									'</article>';
								}

							}

							$data .=
							'</article>';
						}

						$data .=
						'</article>';
	                }

					$data .=
					'<div class="row">
	                    <div class="span12">
	                        <div class="label">
	                            <label>
	                                <p>{$lang.comments}</p>
	                                <textarea disabled>' . $query['comment'] . '</textarea>
	                            </label>
	                        </div>
	                    </div>
						<div class="span12">
	                        <div class="label">
	                            <label>
	                                <p>{$lang.firstname}</p>
									<input type="text" value="' . $query['guest']['firstname'] . '" disabled />
	                            </label>
	                        </div>
	                    </div>
						<div class="span12">
	                        <div class="label">
	                            <label>
	                                <p>{$lang.lastname}</p>
									<input type="text" value="' . $query['guest']['lastname'] . '" disabled />
	                            </label>
	                        </div>
	                    </div>
						<div class="span12">
	                        <div class="label">
	                            <label>
	                                <p>{$lang.email}</p>
									<input type="text" value="' . $query['guest']['email'] . '" disabled />
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
						'message' => '{$lang.operation_error}',
					]);
				}
			}
		}
		else
		{
			define('_title', 'GuestVox');

			$template = $this->view->render($this, 'answers');

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

				if (!empty($value['rate']))
					$value['rate'] = $value['rate'] / count($questions);
				else
					$value['rate'] = 0;

				$tbl_survey_answers .=
				'<tr>
					<td align="left">' . $value['token'] . '</td>
					<td align="left">' . $value['room'] . '</td>
					<td align="left">' . $value['guest']['firstname'] . ' ' . $value['guest']['lastname'] . '</td>
					<td align="left">' . Functions::get_formatted_date($value['date'], 'd M, y') . '</td>
					<td align="left">' . round($value['rate'], 2) . ' Pts</td>
					<td align="right" class="icon"><a data-action="view_survey_answer" data-id="' . $value['id'] . '"><i class="fas fa-bars"></i></a></td>
				</tr>';
			}

			$replace = [
				'{$tbl_survey_answers}' => $tbl_survey_answers,
			];

			$template = $this->format->replace($replace, $template);

			echo $template;
		}
	}

	public function stats()
	{
		if (Format::exist_ajax_request() == true)
		{

		}
		else
		{
			define('_title', 'GuestVox');

			$template = $this->view->render($this, 'stats');

			$replace = [
				'{$total_rate_avarage}' => $this->model->get_total_rate_avarage(),
				'{$average_surveys}' => $this->model->get_average('general_surveys'),
				'{$count_received_today}' => $this->model->get_count('received_today'),
				'{$count_received_week}' => $this->model->get_count('received_week'),
				'{$count_received_month}' => $this->model->get_count('received_month'),
				'{$count_received_total}' => $this->model->get_count('received_total'),
			];

			$template = $this->format->replace($replace, $template);

			echo $template;
		}
	}

	public function charts()
	{
		header('Content-Type: application/javascript');

		$s_r1_chart_data = $this->model->get_chart_data('s_r1_chart');
		$s_r2_chart_data = $this->model->get_chart_data('s_r2_chart');
		$s_r3_chart_data = $this->model->get_chart_data('s_r3_chart');
		$s_r4_chart_data = $this->model->get_chart_data('s_r4_chart');

		if (Session::get_value('lang') == 'es')
		{
			$s_r1_chart_title = 'Balance de respuestas por habitación';
			$s_r2_chart_title = 'Balance de encuestas de valoración';
			$s_r3_chart_title = 'Balance de encuestas de si y no';
			$s_r4_chart_title = 'Promedio de preguntas';
		}
		else if (Session::get_value('lang') == 'en')
		{
			$s_r1_chart_title = 'Balance of responses per room';
			$s_r2_chart_title = 'Assessment survey balance';
			$s_r3_chart_title = 'Yes and no survey balance ';
			$s_r4_chart_title = 'Average questions and subquestions';
		}

		$js =
		"'use strict';

		var s_r1_chart = {
	        type: 'pie',
	        data: {
				labels: [
	                " . $s_r1_chart_data['labels'] . "
	            ],
				datasets: [{
	                data: [
	                    " . $s_r1_chart_data['datasets']['data'] . "
	                ],
	                backgroundColor: [
	                    " . $s_r1_chart_data['datasets']['colors'] . "
	                ],
	            }],
	        },
	        options: {
				title: {
					display: true,
					text: '" . $s_r1_chart_title . "'
				},
				legend: {
					display: true
				},
	            responsive: true
            }
        };

		var s_r2_chart = {
	        type: 'pie',
	        data: {
				labels: [
	                " . $s_r2_chart_data['labels'] . "
	            ],
				datasets: [{
	                data: [
	                    " . $s_r2_chart_data['datasets']['data'] . "
	                ],
	                backgroundColor: [
	                    " . $s_r2_chart_data['datasets']['colors'] . "
	                ],
	            }],
	        },
	        options: {
				title: {
					display: true,
					text: '" . $s_r2_chart_title . "'
				},
				legend: {
					display: true
				},
	            responsive: true
            }
        };

		var s_r3_chart = {
	        type: 'pie',
	        data: {
				labels: [
	                " . $s_r3_chart_data['labels'] . "
	            ],
				datasets: [{
	                data: [
	                    " . $s_r3_chart_data['datasets']['data'] . "
	                ],
	                backgroundColor: [
	                    " . $s_r3_chart_data['datasets']['colors'] . "
	                ],
	            }],
	        },
	        options: {
				title: {
					display: true,
					text: '" . $s_r3_chart_title . "'
				},
				legend: {
					display: true
				},
	            responsive: true
            }
        };

		var s_r4_chart = {
		    type: 'line',
			data: {
				labels: [
	                " . $s_r4_chart_data['labels'] . "
	            ],
				datasets: [{
					label: [
						" . $s_r4_chart_data['datasets']['labels'] . "
					],
	                data: [
	                    " . $s_r4_chart_data['datasets']['data'] . "
	                ],
	                backgroundColor: [
	                    " . $s_r4_chart_data['datasets']['colors'] . "
	                ],
	            }],
	        },
			options: {
				title: {
					display: true,
					text: '" . $s_r4_chart_title . "'
				},
				legend: {
					display: true
				},
	            responsive: true
            }
		};

		window.onload = function()
		{
			s_r1_chart = new Chart(document.getElementById('s_r1_chart').getContext('2d'), s_r1_chart);
			s_r2_chart = new Chart(document.getElementById('s_r2_chart').getContext('2d'), s_r2_chart);
			s_r3_chart = new Chart(document.getElementById('s_r3_chart').getContext('2d'), s_r3_chart);
			s_r4_chart = new Chart(document.getElementById('s_r4_chart').getContext('2d'), s_r4_chart);
		};";

		$js = trim(str_replace(array("\t\t\t"), '', $js));

		echo $js;
	}
}
