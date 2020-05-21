<?php

defined('_EXEC') or die;

class Reviews_controller extends Controller
{
	public function __construct()
	{
		parent::__construct();
	}

    public function index($params)
    {
		$account = $this->model->get_account($params[0]);

		if (!empty($account) AND $account['settings']['review']['online'] == true)
		{
			$template = $this->view->render($this, 'index');

			define('_title', $account['name'] . ' | Guestvox');

			$surveys_average = $this->model->get_surveys_average($account['id']);

			$h2_surveys_average = '';

			if ($surveys_average >= 0 AND $surveys_average < 1.8)
				$h2_surveys_average = '<h2 style="color:#f44336;">' . $surveys_average . '</h2>';
			else if ($surveys_average >= 1.8 AND $surveys_average < 2.8)
				$h2_surveys_average = '<h2 style="color:#ffc107;">' . $surveys_average . '</h2>';
			else if ($surveys_average >= 2.8 AND $surveys_average < 3.8)
				$h2_surveys_average = '<h2 style="color:#ffeb3b;">' . $surveys_average . '</h2>';
			else if ($surveys_average >= 3.8 AND $surveys_average < 4.8)
				$h2_surveys_average = '<h2 style="color:#4caf50;">' . $surveys_average . '</h2>';
			else if ($surveys_average >= 4.8 AND $surveys_average <= 5)
				$h2_surveys_average = '<h2 style="color:#00a5ab;">' . $surveys_average . '</h2>';

			$spn_surveys_average =
			'<span>
				' . (($surveys_average >= 0 AND $surveys_average < 1.8) ? '<i class="fas fa-sad-cry" style="font-size:50px;color:#f44336;"></i>' : '<i class="far fa-sad-cry"></i>') . '
				' . (($surveys_average >= 1.8 AND $surveys_average < 2.8) ? '<i class="fas fa-frown" style="font-size:50px;color:#ffc107;"></i>' : '<i class="far fa-frown"></i>') . '
				' . (($surveys_average >= 2.8 AND $surveys_average < 3.8) ? '<i class="fas fa-meh-rolling-eyes" style="font-size:50px;color:#ffeb3b;"></i>' : '<i class="far fa-meh-rolling-eyes"></i>') . '
				' . (($surveys_average >= 3.8 AND $surveys_average < 4.8) ? '<i class="fas fa-smile" style="font-size:50px;color:#4caf50;"></i>' : '<i class="far fa-smile"></i>') . '
				' . (($surveys_average >= 4.8 AND $surveys_average <= 5) ? '<i class="fas fa-grin-stars" style="font-size:50px;color:#00a5ab;"></i>' : '<i class="far fa-grin-stars"></i>') . '
			</span>';

			$surveys_comments = $this->model->get_surveys_comments($account['id']);

			$tbl_surveys_comments = '';

			if (!empty($surveys_comments))
			{
				$tbl_surveys_comments .= '<div class="comments">';

				foreach ($surveys_comments as $value)
				{
					if (!empty($value['comment']))
					{
						$substr_firstname = strlen($value['contact']['firstname']);
						$substr_lastname = strlen($value['contact']['lastname']);

						$tbl_surveys_comments .=
						'<div>
							<span><i class="fas fa-user-circle"></i>' . ((!empty($value['contact']['firstname']) AND !empty($value['contact']['lastname'])) ? substr($value['contact']['firstname'], -$substr_firstname, 1) . '. ' . substr($value['contact']['lastname'], -$substr_lastname, 1) . '.' : '{$lang.anonimous}')  . '</span>
							<span><i class="fas fa-quote-left"></i>' . $value['comment'] . '<i class="fas fa-quote-right"></i></span>
						</div>';
					}
				}

				$tbl_surveys_comments .= '</div>';
			}

			$replace = [
				'{$seo_keywords}' => $account['settings']['review']['seo']['keywords'][Session::get_value('lang')],
				'{$seo_meta_description}' => $account['settings']['review']['seo']['meta_description'][Session::get_value('lang')],
				'{$logotype}' => '{$path.uploads}' . $account['logotype'],
				'{$name}' => $account['name'],
				'{$address}' => $account['address'],
				'{$email}' => $account['settings']['review']['email'],
				'{$phone}' => '+' . $account['settings']['review']['phone']['lada'] . ' ' . $account['settings']['review']['phone']['number'],
				'{$website}' => $account['settings']['review']['website'],
				'{$h2_surveys_average}' => $h2_surveys_average,
				'{$spn_surveys_average}' => $spn_surveys_average,
				'{$five_surveys_porcentage}' => $this->model->get_surveys_percentage('five', $account['id']),
				'{$four_surveys_porcentage}' => $this->model->get_surveys_percentage('four', $account['id']),
				'{$tree_surveys_porcentage}' => $this->model->get_surveys_percentage('tree', $account['id']),
				'{$two_surveys_porcentage}' => $this->model->get_surveys_percentage('two', $account['id']),
				'{$one_surveys_porcentage}' => $this->model->get_surveys_percentage('one', $account['id']),
				'{$description}' => $account['settings']['review']['description'][Session::get_value('lang')],
				'{$tbl_surveys_comments}' => $tbl_surveys_comments,
				'{$facebook}' => !empty($account['settings']['review']['social_media']['facebook']) ? '<a href="' . $account['settings']['review']['social_media']['facebook'] . '" target="_blank"><i class="fab fa-facebook-square"></i></a>' : '',
				'{$instagram}' => !empty($account['settings']['review']['social_media']['instagram']) ? '<a href="' . $account['settings']['review']['social_media']['instagram'] . '" target="_blank"><i class="fab fa-instagram"></i></a>' : '',
				'{$twitter}' => !empty($account['settings']['review']['social_media']['twitter']) ? '<a href="' . $account['settings']['review']['social_media']['twitter'] . '" target="_blank"><i class="fab fa-twitter"></i></a>' : '',
				'{$linkedin}' => !empty($account['settings']['review']['social_media']['linkedin']) ? '<a href="' . $account['settings']['review']['social_media']['linkedin'] . '" target="_blank"><i class="fab fa-linkedin"></i></a>' : '',
				'{$youtube}' => !empty($account['settings']['review']['social_media']['youtube']) ? '<a href="' . $account['settings']['review']['social_media']['youtube'] . '" target="_blank"><i class="fab fa-youtube"></i></a>' : '',
				'{$google}' => !empty($account['settings']['review']['social_media']['google']) ? '<a href="' . $account['settings']['review']['social_media']['google'] . '" target="_blank"><i class="fab fa-google"></i></a>' : '',
				'{$tripadvisor}' => ($account['type'] == 'hotel' OR $account['type'] == 'restaurant') ? (!empty($account['settings']['review']['social_media']['tripadvisor']) ? '<a href="' . $account['settings']['review']['social_media']['tripadvisor'] . '" target="_blank"><i class="fab fa-tripadvisor"></i></a>' : '') : ''
			];

			$template = $this->format->replace($replace, $template);

			echo $template;
		}
		else
			header('Location: /');
    }
}
