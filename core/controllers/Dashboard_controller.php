<?php

defined('_EXEC') or die;

class Dashboard_controller extends Controller
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

		}
		else
		{
			$template = $this->view->render($this, 'index');

			define('_title', 'Guestvox | {$lang.dashboard}');

			$tbl_voxes = '';
			$tbl_menu_orders = '';

			foreach ($this->model->get_voxes() as $value)
			{
				if (empty($value['menu_order']))
				{
					$tbl_voxes .=
					'<div>
						<div>
							<div class="itm_1">';

					if (!empty($value['assigned_users']))
					{
						foreach (array_reverse($value['assigned_users']) as $subvalue)
						{
							$tbl_voxes .=
							'<figure>
								<img src="' . (!empty($subvalue['avatar']) ? '{$path.uploads}' . $subvalue['avatar'] : '{$path.images}avatar.png') . '">
							</figure>';
						}
					}
					else
					{
						$tbl_voxes .=
						'<figure>
							<img src="{$path.images}avatar.png">
						</figure>';
					}

					$tbl_voxes .=
					'       </div>
							<div class="itm_2">
								<div>
									<span class="' . $value['urgency'] . '">';

					if ($value['type'] == 'request')
						$tbl_voxes .= '<i class="fas fa-rocket"></i>';
					else if ($value['type'] == 'incident')
						$tbl_voxes .= '<i class="fas fa-meteor"></i>';
					else if ($value['type'] == 'workorder')
						$tbl_voxes .= '<i class="fas fa-bomb"></i>';

					$tbl_voxes .=
					'	</span>
					</div>
					<div>
						<h2><i class="fas fa-user-circle"></i>' . (($value['type'] == 'request' OR $value['type'] == 'incident') ? (((Session::get_value('account')['type'] == 'hotel' AND !empty($value['menu_order'])) OR (Session::get_value('account')['type'] == 'restaurant' AND !empty($value['menu_order']) AND $value['menu_order']['type_service'] == 'restaurant')) ? '{$lang.not_apply}' : ((!empty($value['firstname']) AND !empty($value['lastname'])) ? ((Session::get_value('account')['type'] == 'hotel' AND !empty($value['guest_treatment'])) ? $value['guest_treatment']['name'] . ' ' : '') . $value['firstname'] . ' ' . $value['lastname'] :  '{$lang.not_name}')) : '{$lang.not_apply}') . '</h2>
						<span><i class="fas fa-shapes"></i>' . ((Session::get_value('account')['type'] == 'restaurant' AND !empty($value['menu_order']) AND $value['menu_order']['type_service'] == 'delivery') ? (($value['menu_order']['delivery'] == 'home') ? '{$lang.home_service}' : '{$lang.pick_up_restaurant}') : $value['owner']['name'][$this->lang] . (!empty($value['owner']['number']) ? ' #' . $value['owner']['number'] : '')) . '</span>';

					if ($value['type'] == 'request' OR $value['type'] == 'workorder')
						$tbl_voxes .= '<span><i class="fas fa-quote-right"></i>' . (!empty($value['observations']) ? $value['observations'] : '{$lang.not_observations}') . '</span>';
					else if ($value['type'] == 'incident')
						$tbl_voxes .= '<span><i class="fas fa-quote-right"></i>' . (!empty($value['subject']) ? $value['subject'] : '{$lang.not_subject}') . '</span>';

					if ($value['automatic_start'] == true)
					{
						$tbl_voxes .= '<span
						data-date-1="' . Functions::get_formatted_date_hour($value['started_date'], $value['started_hour']) . '"
						data-date-2="' . ((!empty($value['completed_date']) AND !empty($value['completed_hour'])) ? Functions::get_formatted_date_hour($value['completed_date'], $value['completed_hour']) : '') . '"
						data-time-zone="' . Session::get_value('account')['time_zone'] . '"
						data-status="' . $value['status'] . '"
						data-elapsed-time><i class="fas fa-play-circle""></i><strong></strong></span>';
					}
					else
					{
						$tbl_voxes .= '<span
						data-date-1="' . Functions::get_formatted_date_hour($value['started_date'], $value['started_hour']) . '"
						data-date-2="' . ((!empty($value['completed_date']) AND !empty($value['completed_hour'])) ? Functions::get_formatted_date_hour($value['completed_date'], $value['completed_hour']) : '') . '"
						data-time-zone="' . Session::get_value('account')['time_zone'] . '"
						data-status="' . $value['status'] . '"
						data-elapsed-time><i class="fas fa-clock"></i><strong></strong></span>';
					}

					$tbl_voxes .=
					'
								</div>
							</div>
							<div class="itm_3">
								<div>
									<i class="fas fa-key"></i>
									<p><strong>' . strtoupper($value['token']) . '</strong></p>
								</div>
								<div>
									<i class="fas fa-mask"></i>
									<p>' . $value['opportunity_area']['name'][$this->lang] . '</p>
								</div>
								<div>
									<i class="fas fa-feather-alt"></i>
									<p>' . $value['opportunity_type']['name'][$this->lang] . '</p>
								</div>
								<div>
									<i class="fas fa-map-marker-alt"></i>
									<p>' . ((Session::get_value('account')['type'] == 'restaurant' AND !empty($value['menu_order'])) ? (($value['menu_order']['type_service'] == 'delivery' AND $value['menu_order']['delivery'] == 'home') ? $value['address'] : '{$lang.not_apply}') : (!empty($value['location']) ? $value['location']['name'][$this->lang] : '{$lang.not_location}')) . '</p>
								</div>
							</div>
							<div class="itm_4">
								' . (($value['status'] == true AND !empty($value['started_date'])) ? '<a class="new" data-action="complete_vox" data-id="' . $value['id'] . '" data-token="' . $value['token'] . '"><span><i class="fas fa-stop-circle"></i></span></a>' : '') . '
								<a data-action="preview_vox" data-token="' . $value['token'] . '"><span><i class="fas fa-list"></i></span></a>
								' . (!empty($value['assigned_users']) ? '<span><i class="fas fa-users"></i></span>' : '') . '
								' . (!empty($value['comments']) ? '<span><i class="fas fa-comment"></i></span>' : '') . '
								' . (!empty($value['attachments']) ? '<span><i class="fas fa-paperclip"></i></span>' : '') . '
								' . (($value['confidentiality'] == true) ? '<span><i class="fas fa-lock"></i></span>' : '') . '
							</div>
							<a href="/voxes/details/' . $value['token'] . '"></a>
						</div>
					</div>';
				}
				else
				{
					$tbl_menu_orders .=
					'<div>
						<div>
							<div class="itm_1">';

					if (!empty($value['assigned_users']))
					{
						foreach (array_reverse($value['assigned_users']) as $subvalue)
						{
							$tbl_menu_orders .=
							'<figure>
								<img src="' . (!empty($subvalue['avatar']) ? '{$path.uploads}' . $subvalue['avatar'] : '{$path.images}avatar.png') . '">
							</figure>';
						}
					}
					else
					{
						$tbl_menu_orders .=
						'<figure>
							<img src="' . (($value['origin'] == 'myvox') ? '{$path.images}myvox.png' : (!empty($value['created_user']['avatar']) ? '{$path.uploads}' . $value['created_user']['avatar'] : '{$path.images}avatar.png')) . '">
						</figure>';
					}

					$tbl_menu_orders .=
					'       </div>
							<div class="itm_2">
								<div>
									<span class="' . $value['urgency'] . '">';

					if ($value['type'] == 'request')
						$tbl_menu_orders .= '<i class="fas fa-rocket"></i>';
					else if ($value['type'] == 'incident')
						$tbl_menu_orders .= '<i class="fas fa-meteor"></i>';
					else if ($value['type'] == 'workorder')
						$tbl_menu_orders .= '<i class="fas fa-bomb"></i>';

					$tbl_menu_orders .=
					'	</span>
					</div>
					<div>
						<h2><i class="fas fa-user-circle"></i>' . (($value['type'] == 'request' OR $value['type'] == 'incident') ? (((Session::get_value('account')['type'] == 'hotel' AND !empty($value['menu_order'])) OR (Session::get_value('account')['type'] == 'restaurant' AND !empty($value['menu_order']) AND $value['menu_order']['type_service'] == 'restaurant')) ? '{$lang.not_apply}' : ((!empty($value['firstname']) AND !empty($value['lastname'])) ? ((Session::get_value('account')['type'] == 'hotel' AND !empty($value['guest_treatment'])) ? $value['guest_treatment']['name'] . ' ' : '') . $value['firstname'] . ' ' . $value['lastname'] :  '{$lang.not_name}')) : '{$lang.not_apply}') . '</h2>
						<span><i class="fas fa-shapes"></i>' . ((Session::get_value('account')['type'] == 'restaurant' AND !empty($value['menu_order']) AND $value['menu_order']['type_service'] == 'delivery') ? (($value['menu_order']['delivery'] == 'home') ? '{$lang.home_service}' : '{$lang.pick_up_restaurant}') : $value['owner']['name'][$this->lang] . (!empty($value['owner']['number']) ? ' #' . $value['owner']['number'] : '')) . '</span>';

					if ($value['type'] == 'request' OR $value['type'] == 'workorder')
						$tbl_menu_orders .= '<span><i class="fas fa-quote-right"></i>' . (!empty($value['observations']) ? $value['observations'] : '{$lang.not_observations}') . '</span>';
					else if ($value['type'] == 'incident')
						$tbl_menu_orders .= '<span><i class="fas fa-quote-right"></i>' . (!empty($value['subject']) ? $value['subject'] : '{$lang.not_subject}') . '</span>';

					if ($value['automatic_start'] == true)
					{
						$tbl_menu_orders .= '<span
						data-date-1="' . Functions::get_formatted_date_hour($value['started_date'], $value['started_hour']) . '"
						data-date-2="' . ((!empty($value['completed_date']) AND !empty($value['completed_hour'])) ? Functions::get_formatted_date_hour($value['completed_date'], $value['completed_hour']) : '') . '"
						data-time-zone="' . Session::get_value('account')['time_zone'] . '"
						data-status="' . $value['status'] . '"
						data-elapsed-time><i class="fas fa-play-circle""></i><strong></strong></span>';
					}
					else
					{
						$tbl_menu_orders .= '<span
						data-date-1="' . Functions::get_formatted_date_hour($value['started_date'], $value['started_hour']) . '"
						data-date-2="' . ((!empty($value['completed_date']) AND !empty($value['completed_hour'])) ? Functions::get_formatted_date_hour($value['completed_date'], $value['completed_hour']) : '') . '"
						data-time-zone="' . Session::get_value('account')['time_zone'] . '"
						data-status="' . $value['status'] . '"
						data-elapsed-time><i class="fas fa-clock"></i><strong></strong></span>';
					}

					$tbl_menu_orders .=
					'
								</div>
							</div>
							<div class="itm_3">
								<div>
									<i class="fas fa-key"></i>
									<p><strong>' . strtoupper($value['token']) . '</strong></p>
								</div>
								<div>
									<i class="fas fa-mask"></i>
									<p>' . $value['opportunity_area']['name'][$this->lang] . '</p>
								</div>
								<div>
									<i class="fas fa-feather-alt"></i>
									<p>' . $value['opportunity_type']['name'][$this->lang] . '</p>
								</div>
								<div>
									<i class="fas fa-map-marker-alt"></i>
									<p>' . ((Session::get_value('account')['type'] == 'restaurant' AND !empty($value['menu_order'])) ? (($value['menu_order']['type_service'] == 'delivery' AND $value['menu_order']['delivery'] == 'home') ? $value['address'] : '{$lang.not_apply}') : (!empty($value['location']) ? $value['location']['name'][$this->lang] : '{$lang.not_location}')) . '</p>
								</div>
							</div>
							<div class="itm_4">
								' . (($value['status'] == true AND !empty($value['started_date'])) ? '<a class="new" data-action="complete_vox" data-id="' . $value['id'] . '" data-token="' . $value['token'] . '"><span><i class="fas fa-stop-circle"></i></span></a>' : '') . '
								<a data-action="preview_vox" data-token="' . $value['token'] . '"><span><i class="fas fa-list"></i></span></a>
								' . (!empty($value['assigned_users']) ? '<span><i class="fas fa-users"></i></span>' : '') . '
								' . (!empty($value['comments']) ? '<span><i class="fas fa-comment"></i></span>' : '') . '
								' . (!empty($value['attachments']) ? '<span><i class="fas fa-paperclip"></i></span>' : '') . '
								' . (($value['confidentiality'] == true) ? '<span><i class="fas fa-lock"></i></span>' : '') . '
							</div>
							<a href="/voxes/details/' . $value['token'] . '"></a>
						</div>
					</div>';
				}
			}

			$tbl_voxes .= '';

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

			$tbl_surveys_raters = '';

			$tbl_surveys_raters .= '<div class="tbl_stl_7 hidden" data-table>';

			foreach ($this->model->get_surveys_answers('raters') as $value)
			{
				$tbl_surveys_raters .=
				'<div>
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
						<h2>' . ((!empty($value['firstname']) AND !empty($value['lastname'])) ? $value['firstname'] . ' ' . $value['lastname'] : ((Session::get_value('account')['type'] == 'hotel') ? ((!empty($value['reservation']['firstname']) AND !empty($value['reservation']['lastname'])) ? $value['reservation']['firstname'] . ' ' . $value['reservation']['lastname'] : '{$lang.not_name}') : '{$lang.not_name}')) . '</h2>
						<span><i class="fas fa-calendar-alt"></i>' . Functions::get_formatted_date($value['date'], 'd.m.Y') . ' ' . Functions::get_formatted_hour($value['hour'], '+ hrs') . '</span>
						<span><i class="fas fa-shapes"></i>' . $value['owner_name'][$this->lang] . (!empty($value['owner_number']) ? ' #' . $value['owner_number'] : '') . '</span>
					</div>
					<div class="buttons">
						<a class="big" data-action="preview_survey_answer" data-id="' . $value['id'] . '"><i class="fas fa-ghost"></i><span>{$lang.survey}</span></a>
						<a data-action="print_survey_answer" data-id="' . $value['id'] . '"><i class="fas fa-print"></i></a>
						<a class="edit" data-action="edit_reservation" data-id="' . $value['id'] . '"><i class="fas fa-pen"></i></a>
					</div>
				</div>';
			}

			$tbl_surveys_raters .= '</div>';

			$replace = [
				'{$voxes_average}' => $this->model->get_voxes_average(),
				'{$voxes_count_open}' => $this->model->get_voxes_count('open'),
				'{$voxes_count_close}' => $this->model->get_voxes_count('close'),
				'{$voxes_count_total}' => $this->model->get_voxes_count('total'),
				'{$voxes_count_today}' => $this->model->get_voxes_count('today'),
				'{$voxes_count_week}' => $this->model->get_voxes_count('week'),
				'{$voxes_count_month}' => $this->model->get_voxes_count('month'),
				'{$voxes_count_year}' => $this->model->get_voxes_count('year'),
				'{$tbl_voxes}' => $tbl_voxes,
				'{$tbl_menu_orders}' => $tbl_menu_orders,
				'{$h2_surveys_average}' => $h2_surveys_average,
				'{$spn_surveys_average}' => $spn_surveys_average,
				'{$surveys_porcentage_one}' => $this->model->get_surveys_percentage('one'),
				'{$surveys_porcentage_two}' => $this->model->get_surveys_percentage('two'),
				'{$surveys_porcentage_tree}' => $this->model->get_surveys_percentage('tree'),
				'{$surveys_porcentage_four}' => $this->model->get_surveys_percentage('four'),
				'{$surveys_porcentage_five}' => $this->model->get_surveys_percentage('five'),
				'{$tbl_surveys_raters}' => $tbl_surveys_raters,
			];

			$template = $this->format->replace($replace, $template);

			echo $template;
		}
	}
}
