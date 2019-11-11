<?php

defined('_EXEC') or die;

class Reports_controller extends Controller
{
	public function __construct()
	{
		parent::__construct();
	}

	public function index()
	{
		if (Format::exist_ajax_request() == true)
		{
			if ($_POST['action'] == 'get_filter')
			{
				$query = $this->model->get_report($_POST['report']);

				$data['type'] = $query['type'];
				$data['opportunity_area'] = (!empty($query['opportunity_area'])) ? $query['opportunity_area'] : 'all';
				$data['opt_opportunity_areas'] = '<option value="all">{$lang.all}</option>';

				foreach ($this->model->get_opportunity_areas($data['type']) as $value)
					$data['opt_opportunity_areas'] .= '<option value="' . $value['id'] . '">' . $value['name'][Session::get_value('settings')['language']] . '</option>';

				$data['opportunity_type'] = (!empty($query['opportunity_type'])) ? $query['opportunity_type'] : 'all';
				$data['opt_opportunity_types'] = '<option value="all">{$lang.all}</option>';

				foreach ($this->model->get_opportunity_types($data['opportunity_area'], $data['type']) as $value)
					$data['opt_opportunity_types'] .= '<option value="' . $value['id'] . '">' . $value['name'][Session::get_value('settings')['language']] . '</option>';

				$data['room'] = (!empty($query['room'])) ? $query['room'] : 'all';
				$data['location'] = (!empty($query['location'])) ? $query['location'] : 'all';
				$data['opt_locations'] = '<option value="all">{$lang.all}</option>';

				foreach ($this->model->get_locations($data['type']) as $value)
					$data['opt_locations'] .= '<option value="' . $value['id'] . '">' . $value['name'][Session::get_value('settings')['language']] . '</option>';

				$data['order'] = $query['order'];
				$data['started_date'] = Functions::get_past_date(Functions::get_current_date(), $query['time_period'], 'days');
				$data['end_date'] = Functions::get_current_date();
				$data['fields'] = $query['fields'];
				$data['cbx_fields'] =
				'<div class="checkbox">
					<input type="checkbox" name="checked_all">
					<span>{$lang.all}</span>
				</div>';

				foreach ($this->model->get_fields($data['type']) as $value)
				{
					$data['cbx_fields'] .=
					'<div class="checkbox">
						<input type="checkbox" name="fields[]" value="' . $value['id'] . '">
						<span>{$lang.' . $value['name'] . '}</span>
					</div>';
				}

				Functions::environment([
					'status' => 'success',
					'data' => $data
				]);
			}

			if ($_POST['action'] == 'get_opt_opportunity_areas')
			{
				$data = '<option value="all">{$lang.all}</option>';

				foreach ($this->model->get_opportunity_areas($_POST['option']) as $value)
					$data .= '<option value="' . $value['id'] . '">' . $value['name'][Session::get_value('settings')['language']] . '</option>';

				Functions::environment([
					'status' => 'success',
					'data' => $data
				]);
			}

			if ($_POST['action'] == 'get_opt_opportunity_types')
			{
				$data = '<option value="all">{$lang.all}</option>';

				foreach ($this->model->get_opportunity_types($_POST['opportunity_area'], $_POST['option']) as $value)
					$data .= '<option value="' . $value['id'] . '">' . $value['name'][Session::get_value('settings')['language']] . '</option>';

				Functions::environment([
					'status' => 'success',
					'data' => $data
				]);
			}

			if ($_POST['action'] == 'get_opt_locations')
			{
				$data = '<option value="all">{$lang.all}</option>';

				foreach ($this->model->get_locations($_POST['option']) as $value)
					$data .= '<option value="' . $value['id'] . '">' . $value['name'][Session::get_value('settings')['language']] . '</option>';

				Functions::environment([
					'status' => 'success',
					'data' => $data
				]);
			}

			if ($_POST['action'] == 'get_cbx_addressed_to_opportunity_areas')
			{
				$data =
				'<div class="checkbox">
					<input type="checkbox" name="checked_all">
					<span>{$lang.all}</span>
				</div>';

				foreach ($this->model->get_opportunity_areas($_POST['option']) as $value)
				{
					$data .=
					'<div class="checkbox">
						<input type="checkbox" name="addressed_to_opportunity_areas[]" value="' . $value['id'] . '">
						<span>' . $value['name'][Session::get_value('settings')['language']] . '</span>
					</div>';
				}

				Functions::environment([
					'status' => 'success',
					'data' => $data
				]);
			}

			if ($_POST['action'] == 'get_cbx_fields')
			{
				$data =
				'<div class="checkbox">
					<input type="checkbox" name="checked_all">
					<span>{$lang.all}</span>
				</div>';

				foreach ($this->model->get_fields($_POST['option']) as $value)
				{
					$data .=
					'<div class="checkbox">
						<input type="checkbox" name="fields[]" value="' . $value['id'] . '">
						<span>{$lang.' . $value['name'] . '}</span>
					</div>';
				}

				Functions::environment([
					'status' => 'success',
					'data' => $data
				]);
			}

			if ($_POST['action'] == 'generate_report')
			{
				$labels = [];

				if (!isset($_POST['type']) OR empty($_POST['type']))
					array_push($labels, ['type', '']);

				if (!isset($_POST['opportunity_area']) OR empty($_POST['opportunity_area']))
					array_push($labels, ['opportunity_area', '']);

				if (!isset($_POST['opportunity_type']) OR empty($_POST['opportunity_type']))
					array_push($labels, ['opportunity_type', '']);

				if (!isset($_POST['room']) OR empty($_POST['room']))
					array_push($labels, ['room', '']);

				if (!isset($_POST['location']) OR empty($_POST['location']))
					array_push($labels, ['location', '']);

				if (!isset($_POST['order']) OR empty($_POST['order']))
					array_push($labels, ['order', '']);

				if (!isset($_POST['started_date']) OR empty($_POST['started_date']))
					array_push($labels, ['started_date', '']);

				if (!isset($_POST['end_date']) OR empty($_POST['end_date']))
					array_push($labels, ['end_date', '']);

				if (!isset($_POST['fields']) OR empty($_POST['fields']))
					array_push($labels, ['fields[]', '']);

				if (empty($labels))
				{
					$query = $this->model->generate_report($_POST);

					$data = '';

					foreach ($query as $value)
					{
						$data .=
						'<div class="detail">
							<p><strong>Token:</strong> ' . $value['data']['token'] . '</p><br><br>';

						if (in_array('type', $_POST['fields']))
							$data .= '<p><strong>{$lang.type}:</strong> {$lang.' . $value['type'] . '}</p>';

						if (in_array('room', $_POST['fields']))
							$data .= '<p><strong>{$lang.room}:</strong> ' . $value['data']['room'] . '</p>';

						if (in_array('opportunity_area', $_POST['fields']))
							$data .= '<p><strong>{$lang.opportunity_area}:</strong> ' . $value['data']['opportunity_area'][Session::get_value('settings')['language']] . '</p>';

						if (in_array('opportunity_type', $_POST['fields']))
							$data .= '<p><strong>{$lang.opportunity_type}:</strong> ' . $value['data']['opportunity_type'][Session::get_value('settings')['language']] . '</p>';

						if (in_array('started_date_hour', $_POST['fields']))
							$data .= '<p><strong>{$lang.started_date_hour}:</strong> ' . Functions::get_formatted_date($value['data']['started_date'], 'd F, Y') . ' ' . Functions::get_formatted_hour($value['data']['started_hour'], '+ hrs') . '</p>';

						if (in_array('location', $_POST['fields']))
							$data .= '<p><strong>{$lang.location}:</strong> ' . $value['data']['location'][Session::get_value('settings')['language']] . '</p>';

						if (in_array('cost', $_POST['fields']) AND $value['type'] == 'incident')
							$data .= '<p><strong>{$lang.cost}:</strong> ' . Functions::get_formatted_currency($value['data']['cost']) . '</p>';

						if (in_array('urgency', $_POST['fields']))
						{
							if ($value['data']['status'] == 'open' AND Functions::get_current_date_hour() < Functions::get_formatted_date_hour($value['data']['started_date'], $value['data']['started_hour']))
								$value['data']['urgency'] = '{$lang.programmed}';
							else if ($value['data']['urgency'] == 'low')
								$value['data']['urgency'] = '{$lang.low}';
							else if ($value['data']['urgency'] == 'medium')
								$value['data']['urgency'] = '{$lang.medium}';
							else if ($value['data']['urgency'] == 'high')
								$value['data']['urgency'] = '{$lang.high}';

							$data .= '<p><strong>{$lang.urgency}:</strong> ' . $value['data']['urgency'] . '</p>';
						}

						if (in_array('confidentiality', $_POST['fields']) AND $value['type'] == 'incident')
						{
							if ($value['data']['confidentiality'] == true)
								$value['data']['confidentiality'] = '{$lang.to_yes}';
							else if ($value['data']['confidentiality'] == false)
								$value['data']['confidentiality'] = '{$lang.to_not}';

							$data .= '<p><strong>{$lang.confidentiality}:</strong> ' . $value['data']['confidentiality'] . '</p>';
						}

						if (in_array('observations', $_POST['fields']) AND $value['type'] == 'request')
							$data .= '<p><strong>{$lang.observations}:</strong> ' . $value['data']['observations'] . '</p>';

						if (in_array('subject', $_POST['fields']) AND $value['type'] == 'incident')
							$data .= '<p><strong>{$lang.subject}:</strong> ' . $value['data']['subject'] . '</p>';

						if (in_array('assigned_users', $_POST['fields']))
						{
							$str_assigned_users = '';

							foreach ($value['data']['assigned_users'] as $subvalue)
								$str_assigned_users .= $subvalue . ', ';

							$data .= '<p><strong>{$lang.assigned_users}:</strong> ' . $str_assigned_users . '</p>';
						}

						if (in_array('description', $_POST['fields']) AND $value['type'] == 'incident')
							$data .= '<p><strong>{$lang.description}:</strong> ' . $value['data']['description'] . '</p>';

						if (in_array('action_taken', $_POST['fields']) AND $value['type'] == 'incident')
							$data .= '<p><strong>{$lang.action_taken}:</strong> ' . $value['data']['action_taken'] . '</p>';

						if (in_array('guest_treatment_name_lastname', $_POST['fields']))
							$data .= '<p><strong>{$lang.guest}:</strong> ' . $value['data']['guest_treatment'] . ' ' . $value['data']['name'] . ' ' . $value['data']['lastname'] . '</p>';

						if (in_array('guest_id', $_POST['fields']) AND $value['type'] == 'incident')
							$data .= '<p><strong>{$lang.guest_id}:</strong> ' . $value['data']['guest_id'] . '</p>';

						if (in_array('guest_type', $_POST['fields']) AND $value['type'] == 'incident')
							$data .= '<p><strong>{$lang.guest_type}:</strong> ' . $value['data']['guest_type'] . '</p>';

						if (in_array('reservation_status', $_POST['fields']) AND $value['type'] == 'incident')
							$data .= '<p><strong>{$lang.reservation_status}:</strong> ' . $value['data']['reservation_status'] . '</p>';

						if (in_array('check_in_check_out', $_POST['fields']) AND $value['type'] == 'incident')
							$data .= '<p><strong>{$lang.staying}:</strong> ' . Functions::get_formatted_date($value['data']['check_in'], 'd F, Y') . ' - ' . Functions::get_formatted_date($value['data']['check_out'], 'd F, Y') . '</p>';

						if (in_array('attachments', $_POST['fields']))
						{
							$str_attachments = '';

							$attimg = 0;
							$attpdf = 0;
							$attwrd = 0;
							$attexl = 0;

							foreach ($value['data']['attachments'] as $key => $subvalue)
							{
								if ($subvalue['status'] == 'success')
								{
									$ext = strtoupper(explode('.', $subvalue['file'])[1]);

									if ($ext == 'JPG' OR $ext == 'JPEG' OR $ext == 'PNG')
										$attimg = $attimg + 1;
									else if ($ext == 'PDF')
										$attpdf = $attpdf + 1;
									else if ($ext == 'DOC' OR $ext == 'DOCX')
										$attwrd = $attwrd + 1;
									else if ($ext == 'XLS' OR $ext == 'XLSX')
										$attexl = $attexl + 1;
								}
							}

							if ($attimg > 0)
								$str_attachments .= '<img src="{$path.images}empty.png">' . $attimg . ' {$lang.files} ';

							if ($attpdf > 0)
								$str_attachments .= '<img src="{$path.images}pdf.png">' . $attpdf . ' {$lang.files} ';

							if ($attwrd > 0)
								$str_attachments .= '<img src="{$path.images}word.png">' . $attwrd . ' {$lang.files} ';

							if ($attexl > 0)
								$str_attachments .= '<img src="{$path.images}excel.png">' . $attexl . ' {$lang.files} ';

							$data .= '<p><strong>{$lang.attachments}:</strong> ' . $str_attachments . '</p>';
						}

						if (in_array('status', $_POST['fields']))
						{
							if ($value['data']['status'] == 'open')
								$value['data']['status'] = '{$lang.opened}';
							else if ($value['data']['status'] == 'close')
								$value['data']['status'] = '{$lang.closed}';

							$data .= '<p><strong>{$lang.status}:</strong> ' . $value['data']['status'] . '</p>';
						}

						if (in_array('origin', $_POST['fields']))
							$data .= '<p><strong>{$lang.origin}:</strong> {$lang.' . $value['data']['origin'] . '}</p>';

						if (in_array('created_by', $_POST['fields']))
							$data .= '<p><strong>{$lang.created_by}:</strong> ' . ((!empty($value['data']['created_user'])) ? $value['data']['created_user'] . ' ' . Functions::get_formatted_date_hour($value['data']['created_date'], $value['data']['created_hour']) : '') . '</p>';

						if (in_array('edited_by', $_POST['fields']))
							$data .= '<p><strong>{$lang.edited_by}:</strong> ' . ((!empty($value['data']['edited_user'])) ? $value['data']['edited_user'] . ' ' . Functions::get_formatted_date_hour($value['data']['edited_date'], $value['data']['edited_hour']) : '') . '</p>';

						if (in_array('completed_by', $_POST['fields']))
							$data .= '<p><strong>{$lang.completed_by}:</strong> ' . ((!empty($value['data']['completed_user'])) ? $value['data']['completed_user'] . ' ' . Functions::get_formatted_date_hour($value['data']['completed_date'], $value['data']['completed_hour']) : '') . '</p>';

						if (in_array('reopened_by', $_POST['fields']))
							$data .= '<p><strong>{$lang.reopened_by}:</strong> ' . ((!empty($value['data']['reopened_user'])) ? $value['data']['reopened_user'] . ' ' . Functions::get_formatted_date_hour($value['data']['reopened_date'], $value['data']['reopened_hour']) : '') . '</p>';

						if (in_array('viewed_by', $_POST['fields']))
						{
							$str_viewed_by = '';

							foreach ($value['data']['viewed_by'] as $subvalue)
								$str_viewed_by .= $subvalue . ', ';

							$data .= '<p><strong>{$lang.viewed_by}:</strong> ' . $str_viewed_by . '</p>';
						}

						if (in_array('average_resolution', $_POST['fields']))
						{
							if (!empty($value['data']['completed_date']) AND !empty($value['data']['completed_hour']))
							{
								$date1 = new DateTime($value['data']['started_date'] . ' ' . $value['data']['started_hour']);
								$date2 = new DateTime($value['data']['completed_date'] . ' ' . $value['data']['completed_hour']);
								$date3 = $date1->diff($date2);

								if ($date3->h == 0 AND $date3->i == 0)
									$str_average_resolution = $date3->s . ' Seg';
								else if ($date3->h == 0 AND $date3->i > 0)
									$str_average_resolution = $date3->i . ' Min';
								else if ($date3->h > 0 AND $date3->i == 0)
									$str_average_resolution = $date3->h . ' Hrs';
								else if ($date3->h > 0 AND $date3->i > 0)
									$str_average_resolution = $date3->h . ' Hrs ' . $date3->i . ' Min';
							}
							else
								$str_average_resolution = '{$lang.opened}';

							$data .= '<p><strong>{$lang.average_resolution}:</strong> ' . $str_average_resolution . '</p>';
						}

						if (in_array('comments', $_POST['fields']))
						{
							$str_comments = '';

							foreach ($value['data']['comments'] as $subvalue)
							{
								$str_comments_attachments = '';

								$attimg = 0;
								$attpdf = 0;
								$attwrd = 0;
								$attexl = 0;

								foreach ($subvalue['attachments'] as $key => $intvalue)
								{
									if ($intvalue['status'] == 'success')
									{
										$ext = strtoupper(explode('.', $intvalue['file'])[1]);

										if ($ext == 'JPG' OR $ext == 'JPEG' OR $ext == 'PNG')
											$attimg = $attimg + 1;
										else if ($ext == 'PDF')
											$attpdf = $attpdf + 1;
										else if ($ext == 'DOC' OR $ext == 'DOCX')
											$attwrd = $attwrd + 1;
										else if ($ext == 'XLS' OR $ext == 'XLSX')
											$attexl = $attexl + 1;
									}
								}

								if ($attimg > 0 OR $attpdf > 0 OR $attwrd > 0 OR $attexl > 0)
									$str_comments_attachments .= '<strong>{$lang.attachments}:</strong> ';

								if ($attimg > 0)
									$str_comments_attachments .= '<img src="{$path.images}empty.png">' . $attimg . ' {$lang.files} ';

								if ($attpdf > 0)
									$str_comments_attachments .= '<img src="{$path.images}pdf.png">' . $attpdf . ' {$lang.files} ';

								if ($attwrd > 0)
									$str_comments_attachments .= '<img src="{$path.images}word.png">' . $attwrd . ' {$lang.files} ';

								if ($attexl > 0)
									$str_comments_attachments .= '<img src="{$path.images}excel.png">' . $attexl . ' {$lang.files} ';

								$str_comments .= '<br><p><strong>' . $subvalue['user'] . ':</strong> ' . $subvalue['message'] . ' ' . $str_comments_attachments . '</p>';
							}

							$data .= '<br><br><p><strong>{$lang.comments}:</strong></p>' . $str_comments . '';
						}

						$data .= '</div>';
					}

					Functions::environment([
						'status' => 'success',
						'data' => $data
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

			// ---

			if ($_POST['action'] == 'new_report')
			{
				$labels = [];

				if (!isset($_POST['name']) OR empty($_POST['name']))
					array_push($labels, ['name', '']);

				if (!isset($_POST['type']) OR empty($_POST['type']))
					array_push($labels, ['type', '']);

				if (!isset($_POST['opportunity_area']) OR empty($_POST['opportunity_area']))
					array_push($labels, ['opportunity_area', '']);

				if (!isset($_POST['opportunity_type']) OR empty($_POST['opportunity_type']))
					array_push($labels, ['opportunity_type', '']);

				if (!isset($_POST['room']) OR empty($_POST['room']))
					array_push($labels, ['room', '']);

				if (!isset($_POST['location']) OR empty($_POST['location']))
					array_push($labels, ['location', '']);

				if (!isset($_POST['order']) OR empty($_POST['order']))
					array_push($labels, ['order', '']);

				if (!isset($_POST['time_period']) OR empty($_POST['time_period']) OR !is_numeric($_POST['time_period']) OR $_POST['time_period'] < 1)
					array_push($labels, ['time_period', '']);

				if (!isset($_POST['addressed_to']) OR empty($_POST['addressed_to']))
					array_push($labels, ['addressed_to', '']);

				if ($_POST['addressed_to'] == 'opportunity_areas' AND !isset($_POST['addressed_to_opportunity_areas']) OR $_POST['addressed_to'] == 'opportunity_areas' AND empty($_POST['addressed_to_opportunity_areas']))
					array_push($labels, ['addressed_to_opportunity_areas[]', '']);

				if (!isset($_POST['fields']) OR empty($_POST['fields']))
					array_push($labels, ['fields[]', '']);

				if (empty($labels))
				{
					$query = $this->model->new_report($_POST);

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

			if ($_POST['action'] == 'delete_report')
			{
				$query = $this->model->delete_report($_POST['id']);

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
		}
		else
		{
			define('_title', 'GuestVox | {$lang.reports}');

			$template = $this->view->render($this, 'index');

			$opt_reports = '';

			foreach ($this->model->get_reports() as $value)
				$opt_reports .= '<option value="' . $value['id'] . '">' . $value['name'] . '</option>';

			$opt_opportunity_areas = '';

			foreach ($this->model->get_opportunity_areas('all') as $value)
				$opt_opportunity_areas .= '<option value="' . $value['id'] . '">' . $value['name'][Session::get_value('settings')['language']] . '</option>';

			$opt_rooms = '';

			foreach ($this->model->get_rooms() as $value)
				$opt_rooms .= '<option value="' . $value['id'] . '">' . $value['name'] . '</option>';

			$opt_locations = '';

			foreach ($this->model->get_locations('all') as $value)
				$opt_locations .= '<option value="' . $value['id'] . '">' . $value['name'][Session::get_value('settings')['language']] . '</option>';

			$cbx_addressed_to_opportunity_areas = '';

			foreach ($this->model->get_opportunity_areas('all') as $value)
			{
				$cbx_addressed_to_opportunity_areas .=
				'<div class="checkbox">
					<input type="checkbox" name="addressed_to_opportunity_areas[]" value="' . $value['id'] . '">
					<span>' . $value['name'][Session::get_value('settings')['language']] . '</span>
				</div>';
			}

			$cbx_fields = '';

			foreach ($this->model->get_fields('all') as $value)
			{
				$cbx_fields .=
				'<div class="checkbox">
					<input type="checkbox" name="fields[]" value="' . $value['id'] . '">
					<span>{$lang.' . $value['name'] . '}</span>
				</div>';
			}

			$tbl_reports = '';

			foreach ($this->model->get_reports() as $value)
			{
				$tbl_reports .=
				'<tr>
					<td align="left">' . $value['name'] . '</td>
					<td align="right" class="icon"><a data-action="delete_report" data-id="' . $value['id'] . '"><i class="fas fa-trash"></i></a></td>
				</tr>';
			}

			$replace = [
				'{$opt_reports}' => $opt_reports,
				'{$opt_opportunity_areas}' => $opt_opportunity_areas,
				'{$opt_rooms}' => $opt_rooms,
				'{$opt_locations}' => $opt_locations,
				'{$cbx_addressed_to_opportunity_areas}' => $cbx_addressed_to_opportunity_areas,
				'{$cbx_fields}' => $cbx_fields,
				'{$tbl_reports}' => $tbl_reports,
			];

			$template = $this->format->replace($replace, $template);

			echo $template;
		}
	}
}
