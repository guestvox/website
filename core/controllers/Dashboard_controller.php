<?php

defined('_EXEC') or die;

class Dashboard_controller extends Controller
{
	public function __construct()
	{
		parent::__construct();
	}

	public function index()
	{
		define('_title', 'GuestVox');

		$template = $this->view->render($this, 'index');

		$tbl_voxes_unresolve = '';
		$voxes_unresolve_noreaded = '';
		$voxes_unresolve_readed = '';
		$voxes_unresolve_today = '';
		$voxes_unresolve_week = '';
		$voxes_unresolve_month = '';
		$voxes_unresolve_total = '';

		if (Functions::check_account_access(['operation']) == true)
		{
			foreach ($this->model->get_voxes_unresolve() as $value)
			{
				$tbl_voxes_unresolve .=
				'<tr class="' . (($value['data']['readed'] == true) ? 'readed' : 'no-readed') . '" data-id="' . $value['id'] . '">';

				if ($value['type'] == 'request')
					$tbl_voxes_unresolve .= '<td align="left" class="touchable icon"><span><i class="fas fa-spa"></i></span></td>';
				else if ($value['type'] == 'incident')
					$tbl_voxes_unresolve .= '<td align="left" class="touchable icon"><span><i class="fas fa-exclamation-triangle"></i></span></td>';
				else if ($value['type'] == 'workorder')
					$tbl_voxes_unresolve .= '<td align="left" class="touchable icon"><span><i class="fas fa-id-card-alt"></i></span></td>';

				if (Session::get_value('account')['type'] == 'hotel')
					$tbl_voxes_unresolve .= '<td align="left" class="touchable">' . (($value['type'] == 'request' OR $value['type'] == 'incident') ? '#' . $value['data']['room']['number'] . ' ' . $value['data']['room']['name'] : '') . '</td>';

				if (Session::get_value('account')['type'] == 'restaurant')
					$tbl_voxes_unresolve .= '<td align="left" class="touchable">' . (($value['type'] == 'request' OR $value['type'] == 'incident') ? '#' . $value['data']['table']['number'] . ' ' . $value['data']['table']['name'] : '') . '</td>';

				if (Session::get_value('account')['type'] == 'others')
					$tbl_voxes_unresolve .= '<td align="left" class="touchable">' . (($value['type'] == 'request' OR $value['type'] == 'incident') ? $value['data']['client']['name'] : '') . '</td>';

				$tbl_voxes_unresolve .=
				'	<td align="left" class="touchable">' . (($value['type'] == 'request' OR $value['type'] == 'incident') ? $value['data']['firstname'] . ' ' . $value['data']['lastname'] : '') . '</td>
					<td align="left" class="touchable">' . $value['data']['opportunity_area']['name'][Session::get_value('account')['language']] . '</td>
					<td align="left" class="touchable">' . $value['data']['opportunity_type']['name'][Session::get_value('account')['language']] . '</td>
					<td align="left" class="touchable">' . $value['data']['location']['name'][Session::get_value('account')['language']] . '</td>
					<td align="left" class="touchable">' . Functions::get_formatted_date($value['data']['started_date'], 'd M, y') . '</td>
					<td align="left" class="touchable"
						data-date-1="' . Functions::get_formatted_date_hour($value['data']['started_date'], $value['data']['started_hour']) . '"
						data-time-zone="' . Session::get_value('account')['time_zone'] . '"
						data-elapsed-time></td>
					<td align="right" class="touchable icon">' . (($value['type'] == 'incident' AND $value['data']['confidentiality'] == true) ? '<span><i class="fas fa-key"></i></span>' : '') . '</td>
					<td align="right" class="touchable icon">' . ((!empty($value['data']['assigned_users'])) ? '<span><i class="fas fa-users"></i></span>' : '') . '</td>
					<td align="right" class="touchable icon">' . ((!empty($value['data']['comments'])) ? '<span><i class="fas fa-comment"></i></span>' : '') . '</td>
					<td align="right" class="touchable icon">' . ((!empty($value['data']['attachments'])) ? '<span><i class="fas fa-paperclip"></i></span>' : '') . '</td>';

				if (Functions::get_current_date_hour() < Functions::get_formatted_date_hour($value['data']['started_date'], $value['data']['started_hour']))
				{
					if ($value['data']['urgency'] == 'low')
						$tbl_voxes_unresolve .= '<td align="right" class="touchable icon"><span style="background-color:#4caf50;color:#fff;"><i class="fas fa-clock"></i></span></td>';
					else if ($value['data']['urgency'] == 'medium')
						$tbl_voxes_unresolve .= '<td align="right" class="touchable icon"><span style="background-color:#ffc107;color:#fff;"><i class="fas fa-clock"></i></span></td>';
					else if ($value['data']['urgency'] == 'high')
						$tbl_voxes_unresolve .= '<td align="right" class="touchable icon"><span style="background-color:#f44336;color:#fff;"><i class="fas fa-clock"></i></span></td>';
				}
				else
				{
					if ($value['data']['urgency'] == 'low')
						$tbl_voxes_unresolve .= '<td align="right" class="touchable icon"><span style="background-color:#4caf50;color:#fff;"><i class="fas fa-lock-open"></i></span></td>';
					else if ($value['data']['urgency'] == 'medium')
						$tbl_voxes_unresolve .= '<td align="right" class="touchable icon"><span style="background-color:#ffc107;color:#fff;"><i class="fas fa-lock-open"></i></span></td>';
					else if ($value['data']['urgency'] == 'high')
						$tbl_voxes_unresolve .= '<td align="right" class="touchable icon"><span style="background-color:#f44336;color:#fff;"><i class="fas fa-lock-open"></i></span></td>';
				}

				$tbl_voxes_unresolve .=
				'</tr>';
			}

			$voxes_unresolve_noreaded = $this->model->get_voxes_unresolve('noreaded');
			$voxes_unresolve_readed = $this->model->get_voxes_unresolve('readed');
			$voxes_unresolve_today = $this->model->get_voxes_unresolve('today');
			$voxes_unresolve_week = $this->model->get_voxes_unresolve('week');
			$voxes_unresolve_month = $this->model->get_voxes_unresolve('month');
			$voxes_unresolve_total = $this->model->get_voxes_unresolve('total');
		}

		$replace = [
			'{$tbl_voxes_unresolve}' => $tbl_voxes_unresolve,
			'{$voxes_unresolve_noreaded}' => $voxes_unresolve_noreaded,
			'{$voxes_unresolve_readed}' => $voxes_unresolve_readed,
			'{$voxes_unresolve_today}' => $voxes_unresolve_today,
			'{$voxes_unresolve_week}' => $voxes_unresolve_week,
			'{$voxes_unresolve_month}' => $voxes_unresolve_month,
			'{$voxes_unresolve_total}' => $voxes_unresolve_total
		];

		$template = $this->format->replace($replace, $template);

		echo $template;
	}

	public function logout()
	{
		Session::destroy();

		header("Location: /login");
	}
}
