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
				$value['data']['readed'] = ($value['data']['readed'] == true) ? 'readed' : 'no-readed';
				$value['data']['confidentiality'] = ($value['data']['confidentiality'] == true) ? '<span><i class="fas fa-key"></i></span>' : '';
				$value['data']['assigned_users'] = (!empty($value['data']['assigned_users'])) ? '<span><i class="fas fa-users"></i></span>' : '';
				$value['data']['comments'] = (!empty($value['data']['comments'])) ? '<span><i class="fas fa-comment"></i></span>' : '';
				$value['data']['attachments'] = (!empty($value['data']['attachments'])) ? '<span><i class="fas fa-paperclip"></i></span>' : '';

				if (Functions::get_current_date_hour() < Functions::get_formatted_date_hour($value['data']['started_date'], $value['data']['started_hour']))
				{
					if ($value['data']['urgency'] == 'low')
						$value['data']['urgency'] = '<span style="background-color:#4caf50;color:#fff;"><i class="fas fa-clock"></i></span>';
					else if ($value['data']['urgency'] == 'medium')
						$value['data']['urgency'] = '<span style="background-color:#ffc107;color:#fff;"><i class="fas fa-clock"></i></span>';
					else if ($value['data']['urgency'] == 'high')
						$value['data']['urgency'] = '<span style="background-color:#f44336;color:#fff;"><i class="fas fa-clock"></i></span>';
				}
				else
				{
					if ($value['data']['urgency'] == 'low')
						$value['data']['urgency'] = '<span style="background-color:#4caf50;color:#fff;"><i class="fas fa-lock-open"></i></span>';
					else if ($value['data']['urgency'] == 'medium')
						$value['data']['urgency'] = '<span style="background-color:#ffc107;color:#fff;"><i class="fas fa-lock-open"></i></span>';
					else if ($value['data']['urgency'] == 'high')
						$value['data']['urgency'] = '<span style="background-color:#f44336;color:#fff;"><i class="fas fa-lock-open"></i></span>';
				}

				$tbl_voxes_unresolve .=
				'<tr class="' . $value['data']['readed'] . '" data-id="' . $value['id'] . '">';

				if (Session::get_value('account')['type'] == 'hotel')
					$tbl_voxes_unresolve .= '<td align="left" class="touchable">' . $value['data']['room'] . '</td>';
				else if (Session::get_value('account')['type'] == 'restaurant')
					$tbl_voxes_unresolve .= '<td align="left" class="touchable">' . $value['data']['table'] . '</td>';

				$tbl_voxes_unresolve.=
				'	<td align="left" class="touchable">' . $value['data']['guest_treatment'] . ' ' . $value['data']['firstname'] . ' ' . $value['data']['lastname'] . '</td>
					<td align="left" class="touchable">' . $value['data']['opportunity_area'] . '</td>
					<td align="left" class="touchable">' . $value['data']['opportunity_type'] . '</td>
					<td align="left" class="touchable">' . $value['data']['location'] . '</td>
					<td align="left" class="touchable">' . Functions::get_formatted_date($value['data']['started_date'], 'd M, y') . '</td>
					<td align="left" class="touchable" data-started-date="' . Functions::get_formatted_date_hour($value['data']['started_date'], $value['data']['started_hour']) . '" data-elapsed-time></td>
					<td align="right" class="touchable icon">' . $value['data']['confidentiality'] . '</td>
					<td align="right" class="touchable icon">' . $value['data']['assigned_users'] . '</td>
					<td align="right" class="touchable icon">' . $value['data']['comments'] . '</td>
					<td align="right" class="touchable icon">' . $value['data']['attachments'] . '</td>
					<td align="right" class="touchable icon">' . $value['data']['urgency'] . '</td>
				</tr>';
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
			'{$voxes_unresolve_total}' => $voxes_unresolve_total,
		];

		$template = $this->format->replace($replace, $template);

		echo $template;
	}

	public function logout()
	{
		Session::destroy();
		header("Location: /");
	}
}
