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

		$art_voxes_to_resolve = '';
		$art_voxes = '';

		if (Functions::check_account_access(['operation']) == true)
		{
			$art_voxes_to_resolve .=
			'<article>
		        <header>
		            <h2><i class="fas fa-heart"></i>{$lang.voxes_to_solve}</h2>
		        </header>
		        <main>
		            <div class="voxes-counts-home">
		                <h2>' . $this->model->get_voxes('noreaded') . '<span>{$lang.noreaded}</span></h2>
		                <h2>' . $this->model->get_voxes('readed') . '<span>{$lang.readed}</span></h2>
		                <h2>' . $this->model->get_voxes('today') . '<span>{$lang.today}</span><strong>' . Functions::get_current_date('d F Y') . '</strong></h2>
		                <h2>' . $this->model->get_voxes('week') . '<span>{$lang.this_week}</span><strong>' . Functions::get_formatted_date(Functions::get_current_week()[0], 'd F') . ' - ' . Functions::get_formatted_date(Functions::get_current_week()[1], 'd F Y') . '</strong></h2>
		                <h2>' . $this->model->get_voxes('month') . '<span>{$lang.this_month}</span><strong>' . Functions::get_formatted_date(Functions::get_current_month()[0], 'F Y') . '</strong></h2>
		                <h2>' . $this->model->get_voxes('total') . '<span>{$lang.total}</span></h2>
		            </div>
		        </main>
		        <footer>
		            <a href="/voxes">{$lang.view_all}</a>
		        </footer>
		    </article>';

			$art_voxes .=
			'<article>
		        <header>
		            <h2><i class="fas fa-heart"></i>{$lang.last_voxes_active}</h2>
		        </header>
		        <main>
		            <div class="table">
						<aside>
		                    <label>
		                        <span><i class="fas fa-search"></i></span>
		                         <input name="tbl_voxes_search" type="text">
		                    </label>
		                </aside>
		                <table id="tbl_voxes">
		                    <thead>
		                        <tr>
		                            <th align="left">{$lang.abr_room}</th>
		                            <th align="left">{$lang.abr_guest}</th>
		                            <th align="left">{$lang.abr_subject}</th>
		                            <th align="left">{$lang.abr_opportunity_area}</th>
		                            <th align="left">{$lang.abr_opportunity_type}</th>
		                            <th align="left">{$lang.abr_location}</th>
		                            <th align="left">{$lang.abr_started_date}</th>
		                            <th align="left">{$lang.abr_elapsed_time}</th>
		                            <th align="right" class="icon"></th>
		                            <th align="right" class="icon"></th>
		                            <th align="right" class="icon"></th>
		                            <th align="right" class="icon"></th>
		                            <th align="right" class="icon"></th>
		                        </tr>
		                    </thead>
		                    <tbody>';

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

				$art_voxes .=
				'<tr class="' . $value['data']['status'] . ' ' . $value['data']['readed'] . '" data-id="' . $value['id'] . '">
					<td align="left" class="touchable">' . $value['data']['room'] . '</td>
					<td align="left" class="touchable">' . $value['data']['guest_treatment'] . ' ' . $value['data']['firstname'] . ' ' . $value['data']['lastname'] . '</td>
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

		    $art_voxes .=
			'                </tbody>
		                </table>
		            </div>
		        </main>
		        <footer>
		            <a href="/voxes">{$lang.view_all}</a>
		        </footer>
		    </article>';
		}

		$replace = [
			'{$art_voxes_to_resolve}' => $art_voxes_to_resolve,
			'{$art_voxes}' => $art_voxes,
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
