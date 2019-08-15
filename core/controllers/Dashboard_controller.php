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
		if (Format::exist_ajax_request() == true)
		{
			if ($_POST['action'] == 'support')
			{
				$labels = [];

				if (!isset($_POST['message']) OR empty($_POST['message']))
					array_push($labels, ['message','']);

				if (empty($labels))
				{
					// $this->component->load_component('uploader');
					//
					// $_com_uploader = new Upload;
					//
					// foreach ($_FILES['attachments']['name'] as $key => $value)
					// {
					// 	if (!empty($_FILES['attachments']['name'][$key]))
					// 	{
					// 		$_com_uploader->SetFileName($_FILES['attachments']['name'][$key]);
					// 		$_com_uploader->SetTempName($_FILES['attachments']['tmp_name'][$key]);
					// 		$_com_uploader->SetFileType($_FILES['attachments']['type'][$key]);
					// 		$_com_uploader->SetFileSize($_FILES['attachments']['size'][$key]);
					// 		$_com_uploader->SetUploadDirectory(PATH_UPLOADS);
					// 		$_com_uploader->SetValidExtensions(['jpg','jpeg','png','pdf','doc','docx','xls','xlsx']);
					// 		$_com_uploader->SetMaximumFileSize('unlimited');
					//
					// 		$_FILES['attachments'][$key] = $_com_uploader->UploadFile();
					// 	}
					// }
					//
					// unset($_FILES['attachments']['name'], $_FILES['attachments']['type'], $_FILES['attachments']['tmp_name'], $_FILES['attachments']['error'], $_FILES['attachments']['size']);

					$mail = new Mailer(true);

					try
					{
						$mail->isSMTP();
						$mail->setFrom('noreply@guestvox.com', 'GuestVox');
						$mail->addAddress('daniel@guestvox.com', 'Daniel Basurto');
						$mail->addAddress('gerson@guestvox.com', 'Gersón Gómez');

						// if (!empty($_FILES['attachments']))
						// {
						// 	foreach ($_FILES['attachments'] as $value)
						// 	{
						// 		if ($value['status'] == 'success')
						// 			$mail->addAttachment(PATH_UPLOADS . $value['file']);
						// 	}
						// }

						$mail->isHTML(true);
						$mail->Subject = 'Soporte Técnico';
						$mail->Body = 'Nombre: ' . Session::get_value('user')['name'] . ' ' . Session::get_value('user')['lastname'] . ', Cuenta: ' . Session::get_value('account')['name'] . ', Fecha y hora: ' . Functions::get_formatted_date_hour(Functions::get_current_date(), Functions::get_current_hour(), '+ hrs') . ', Mensaje: ' . $_POST['message'];
						$mail->AltBody = '';
						$mail->send();
					}
					catch (Exception $e) { }

					Functions::environment([
						'status' => 'success',
						'message' => '{$lang.request_send_correctly}',
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
		}
		else
		{
			define('_title', 'GuestVox | {$lang.dashboard}');

			$template = $this->view->render($this, 'index');

			$tbl_voxes = '';

			foreach ($this->model->get_voxes() as $value)
			{
				$value['data']['readed'] = ($value['data']['readed'] == true) ? 'readed' : 'no-readed';
				$value['data']['confidentiality'] = ($value['data']['confidentiality'] == true) ? '<span><i class="fas fa-key"></i></span>' : '';
				$value['data']['assigned_users'] = (!empty($value['data']['assigned_users'])) ? '<span><i class="fas fa-users"></i></span>' : '';
				$value['data']['comments'] = (!empty($value['data']['comments'])) ? '<span><i class="fas fa-comment"></i></span>' : '';
				$value['data']['attachments'] = (!empty($value['data']['attachments'])) ? '<span><i class="fas fa-paperclip"></i></span>' : '';

				if ($value['data']['status'] == 'open' AND Functions::get_current_date_hour() < Functions::get_formatted_date_hour($value['data']['started_date'], $value['data']['started_hour']))
				{
					if ($value['data']['urgency'] == 'low')
						$value['data']['urgency'] = '<span style="background-color:#4caf50;color:#fff;"><i class="fas fa-clock"></i></span>';
					else if ($value['data']['urgency'] == 'medium')
						$value['data']['urgency'] = '<span style="background-color:#ffc107;color:#fff;"><i class="fas fa-clock"></i></span>';
					else if ($value['data']['urgency'] == 'high')
						$value['data']['urgency'] = '<span style="background-color:#f44336;color:#fff;"><i class="fas fa-clock"></i></span>';
				}
				else if ($value['data']['status'] == 'open')
				{
					if ($value['data']['urgency'] == 'low')
						$value['data']['urgency'] = '<span style="background-color:#4caf50;color:#fff;"><i class="fas fa-lock-open"></i></span>';
					else if ($value['data']['urgency'] == 'medium')
						$value['data']['urgency'] = '<span style="background-color:#ffc107;color:#fff;"><i class="fas fa-lock-open"></i></span>';
					else if ($value['data']['urgency'] == 'high')
						$value['data']['urgency'] = '<span style="background-color:#f44336;color:#fff;"><i class="fas fa-lock-open"></i></span>';
				}
				else if ($value['data']['status'] == 'close')
				{
					if ($value['data']['urgency'] == 'low')
						$value['data']['urgency'] = '<span style="background-color:#4caf50;color:#fff;"><i class="fas fa-lock"></i></span>';
					else if ($value['data']['urgency'] == 'medium')
						$value['data']['urgency'] = '<span style="background-color:#ffc107;color:#fff;"><i class="fas fa-lock"></i></span>';
					else if ($value['data']['urgency'] == 'high')
						$value['data']['urgency'] = '<span style="background-color:#f44336;color:#fff;"><i class="fas fa-lock"></i></span>';
				}

				$tbl_voxes .=
				'<tr class="' . $value['data']['status'] . ' ' . $value['data']['readed'] . '" data-id="' . $value['id'] . '">
					<td align="left" class="touchable">' . $value['data']['room'] . '</td>
					<td align="left" class="touchable">' . $value['data']['guest_treatment'] . ' ' . $value['data']['name'] . ' ' . $value['data']['lastname'] . '</td>
					<td align="left" class="touchable">' . $value['data']['observations'] . ' ' . $value['data']['subject'] . '</td>
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

			$replace = [
				'{$tbl_voxes}' => $tbl_voxes,
				'{$cnt_voxes_noreaded}' => $this->model->get_voxes('noreaded'),
				'{$cnt_voxes_readed}' => $this->model->get_voxes('readed'),
				'{$cnt_voxes_today}' => $this->model->get_voxes('today'),
				'{$cnt_voxes_week}' => $this->model->get_voxes('week'),
				'{$cnt_voxes_month}' => $this->model->get_voxes('month'),
				'{$cnt_voxes_total}' => $this->model->get_voxes('total'),
			];

			$template = $this->format->replace($replace, $template);

			echo $template;
		}
	}

	public function charts()
	{
		header('Content-Type: application/javascript');

		$g_chart_data = $this->model->get_chart(Functions::get_past_date(Functions::get_current_date(), '7', 'days'), Functions::get_current_date());

		if (Session::get_value('settings')['language'] == 'es')
			$g_chart_title = 'Voxes creados en los últimos 7 días';
		else if (Session::get_value('settings')['language'] == 'en')
			$g_chart_title = 'Voxes created in the last 7 days';

		$js =
		"'use strict';

		var g_chart = {
			type: 'line',
			data: {
				labels: [
					" . $g_chart_data['labels'] . "
				],
				datasets: [
					" . $g_chart_data['datasets'] . "
				]
			},
			options: {
				title: {
					display: true,
					text: '" . $g_chart_title . "'
				},
				legend: {
					display: true
				},
				responsive: true,
				maintainAspectRatio: false,
				scales: {
					yAxes: [{
						ticks: {
							suggestedMin: 0,
							suggestedMax: " . $g_chart_data['suggested_max'] . "
						}
					}]
				}
			}
		};

		window.onload = function()
		{
			g_chart = new Chart(document.getElementById('g_chart').getContext('2d'), g_chart);
		};";

		$js = trim(str_replace(array('\t\t\t'), '', $js));

		echo $js;
	}
}
