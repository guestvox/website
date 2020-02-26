<?php

defined('_EXEC') or die;

require_once 'plugins/nexmo/vendor/autoload.php';

class Reviews_controller extends Controller
{
	public function __construct()
	{
		parent::__construct();
	}

    public function index($params)
    {
		$data['account'] = $this->model->get_account($params[0]);

		if ($data['account']['settings']['reviews']['page'] == true AND !empty($data['account']))
		{
				Session::set_value('account', $data['account']);

				if (Format::exist_ajax_request() == true)
				{

				}
				else
				{
					define('_title', 'GuestVox');

					$template = $this->view->render($this, 'index');

	                $general_average_rate = $this->model->get_general_average_rate();

	    			$h4_general_average_rate = '';

	    			if ($general_average_rate >= 0 AND $general_average_rate < 1.8)
	    				$h4_general_average_rate = '<h4 style="color:#f44336;">' . $general_average_rate . '</h4>';
	    			else if ($general_average_rate >= 1.8 AND $general_average_rate < 2.8)
	    				$h4_general_average_rate = '<h4 style="color:#ffc107;">' . $general_average_rate . '</h4>';
	    			else if ($general_average_rate >= 2.8 AND $general_average_rate < 3.8)
	    				$h4_general_average_rate = '<h4 style="color:#ffeb3b;">' . $general_average_rate . '</h4>';
	    			else if ($general_average_rate >= 3.8 AND $general_average_rate < 4.8)
	    				$h4_general_average_rate = '<h4 style="color:#4caf50;">' . $general_average_rate . '</h4>';
	    			else if ($general_average_rate >= 4.8 AND $general_average_rate <= 5)
	    				$h4_general_average_rate = '<h4 style="color:#00a5ab;">' . $general_average_rate . '</h4>';

	    			$spn_general_avarage_rate =
	    			'<span>
	    				' . (($general_average_rate >= 0 AND $general_average_rate < 1.8) ? '<i class="fas fa-sad-cry" style="font-size:50px;color:#f44336;"></i>' : '<i class="far fa-sad-cry"></i>') . '
	    				' . (($general_average_rate >= 1.8 AND $general_average_rate < 2.8) ? '<i class="fas fa-frown" style="font-size:50px;color:#ffc107;"></i>' : '<i class="far fa-frown"></i>') . '
	    				' . (($general_average_rate >= 2.8 AND $general_average_rate < 3.8) ? '<i class="fas fa-meh-rolling-eyes" style="font-size:50px;color:#ffeb3b;"></i>' : '<i class="far fa-meh-rolling-eyes"></i>') . '
	    				' . (($general_average_rate >= 3.8 AND $general_average_rate < 4.8) ? '<i class="fas fa-smile" style="font-size:50px;color:#4caf50;"></i>' : '<i class="far fa-smile"></i>') . '
	    				' . (($general_average_rate >= 4.8 AND $general_average_rate <= 5) ? '<i class="fas fa-grin-stars" style="font-size:50px;color:#00a5ab;"></i>' : '<i class="far fa-grin-stars"></i>') . '
	    			</span>';

					$tbl_reviews_comments = '';

					foreach ($this->model->get_survey_answers() as $value)
					{
						if (!empty($value['comment']) AND $value['guest']['guestvox']['firstname'])
						{
							if ($value['status'] == true)
							{
								$tbl_reviews_comments .=
								'<tr>
									<td align="left">' . $value['guest']['guestvox']['firstname'] . ' ' . $value['guest']['guestvox']['lastname'] . '</td>
									<td align="left"> ' . $value['comment'] . '</td>
								</tr>';
							}
						}
						$tbl_reviews_comments .= '';
					}

					$replace = [
						'{$seo_description}' => $data['account']['review_contact']['metadescription'],
						'{$seo_keywords}' => $data['account']['review_contact']['keywords'],
						'{$logotype}' => '{$path.uploads}' . $data['account']['logotype'],
	                    '{$name}' => $data['account']['name'],
	                    '{$address}' => $data['account']['address'],
	                    '{$contact_email}' => $data['account']['review_contact']['email'],
	                    '{$contact_number}' => $data['account']['review_contact']['phone']['lada'] . $data['account']['contact']['phone']['number'],
	                    '{$h4_general_average_rate}' => $h4_general_average_rate,
	    				'{$spn_general_avarage_rate}' => $spn_general_avarage_rate,
	    				'{$five_percentage_rate}' => $this->model->get_percentage_rate('five'),
	    				'{$four_percentage_rate}' => $this->model->get_percentage_rate('four'),
	    				'{$tree_percentage_rate}' => $this->model->get_percentage_rate('tree'),
	    				'{$two_percentage_rate}' => $this->model->get_percentage_rate('two'),
	    				'{$one_percentage_rate}' => $this->model->get_percentage_rate('one'),
	    				'{$count_answered_total}' => $this->model->get_count('answered_total'),
	    				'{$count_answered_today}' => $this->model->get_count('answered_today'),
	    				'{$count_answered_week}' => $this->model->get_count('answered_week'),
	    				'{$count_answered_month}' => $this->model->get_count('answered_month'),
	    				'{$count_answered_year}' => $this->model->get_count('answered_year'),
						'{$descriptive_information}' => (!empty($data['account']['review_contact']['description']) ? $data['account']['review_contact']['description'] : ''),
						'{$tbl_reviews_comments}' => $tbl_reviews_comments,
						'{$contact_facebook}' => (!empty($data['account']['review_contact']['facebook']) ? '<li><a href="' . $data['account']['review_contact']['facebook'] . '" class="btn" target="_blank"><i class="fab fa-facebook-square"></i></a></li>' : ''),
						'{$contact_instagram}' => (!empty($data['account']['review_contact']['instagram']) ? '<li><a href="' . $data['account']['review_contact']['instagram'] . '" class="btn" target="_blank"><i class="fab fa-instagram"></i></a></li>' : ''),
						'{$contact_twitter}' => (!empty($data['account']['review_contact']['twitter']) ? '<li><a href="' . $data['account']['review_contact']['twitter'] . '" class="btn" target="_blank"><i class="fab fa-twitter"></i></a></li>' : ''),
						'{$contact_youtube}' => (!empty($data['account']['review_contact']['youtube']) ? '<li><a href="' . $data['account']['review_contact']['youtube'] . '" class="btn" target="_blank"><i class="fab fa-youtube"></i></a></li>' : ''),
						'{$contact_linkedin}' => (!empty($data['account']['review_contact']['linkedin']) ? '<li><a href="' . $data['account']['review_contact']['linkedin'] . '" class="btn" target="_blank"><i class="fab fa-linkedin"></i></a></li>' : ''),
						'{$contact_tripadvisor}' => (!empty($data['account']['review_contact']['tripadvisor']) ? '<li><a href="' . $data['account']['review_contact']['tripadvisor'] . '" class="btn" target="_blank"><i class="fab fa-tripadvisor"></i></a></li>' : '')
					];

					$template = $this->format->replace($replace, $template);

					echo $template;
				}
		}
		else
			header('Location: /');
    }
}
