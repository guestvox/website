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
			if (Format::exist_ajax_request() == true)
			{

			}
			else
			{
				define('_title', 'GuestVox');

				$template = $this->view->render($this, 'index');

                $general_average_rate = $this->model->get_general_average_rate($account['id']);

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

				$tbl_comments = '';

				foreach ($this->model->get_comments($account['id']) as $value)
				{
					if (!empty($value['comment']))
					{
						$substr_firstname = strlen($value['guest']['guestvox']['firstname']);
						$substr_lastname = strlen($value['guest']['guestvox']['lastname']);

						$tbl_comments .=
						'<div>
							<span><i class="fas fa-user-circle"></i>' . ((!empty($value['guest']['guestvox']['firstname']) AND !empty($value['guest']['guestvox']['lastname'])) ? substr($value['guest']['guestvox']['firstname'], -$substr_firstname, 1) . '. ' . substr($value['guest']['guestvox']['lastname'], -$substr_lastname, 1) . '.' : '{$lang.anonimous}')  . '</span>
							<span><i class="fas fa-quote-left"></i>' . $value['comment'] . '<i class="fas fa-quote-right"></i></span>
						</div>';
					}
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
                    '{$h4_general_average_rate}' => $h4_general_average_rate,
    				'{$spn_general_avarage_rate}' => $spn_general_avarage_rate,
    				'{$five_percentage_rate}' => $this->model->get_percentage_rate('five', $account['id']),
    				'{$four_percentage_rate}' => $this->model->get_percentage_rate('four', $account['id']),
    				'{$tree_percentage_rate}' => $this->model->get_percentage_rate('tree', $account['id']),
    				'{$two_percentage_rate}' => $this->model->get_percentage_rate('two', $account['id']),
    				'{$one_percentage_rate}' => $this->model->get_percentage_rate('one', $account['id']),
					'{$description}' => $account['settings']['review']['description'][Session::get_value('lang')],
					'{$tbl_comments}' => $tbl_comments,
					'{$facebook}' => !empty($account['settings']['review']['social_media']['facebook']) ? '<li><a href="' . $account['settings']['review']['social_media']['facebook'] . '" class="btn" target="_blank"><i class="fab fa-facebook-square"></i></a></li>' : '',
					'{$instagram}' => !empty($account['settings']['review']['social_media']['instagram']) ? '<li><a href="' . $account['settings']['review']['social_media']['instagram'] . '" class="btn" target="_blank"><i class="fab fa-instagram"></i></a></li>' : '',
					'{$twitter}' => !empty($account['settings']['review']['social_media']['twitter']) ? '<li><a href="' . $account['settings']['review']['social_media']['twitter'] . '" class="btn" target="_blank"><i class="fab fa-twitter"></i></a></li>' : '',
					'{$linkedin}' => !empty($account['settings']['review']['social_media']['linkedin']) ? '<li><a href="' . $account['settings']['review']['social_media']['linkedin'] . '" class="btn" target="_blank"><i class="fab fa-linkedin"></i></a></li>' : '',
					'{$youtube}' => !empty($account['settings']['review']['social_media']['youtube']) ? '<li><a href="' . $account['settings']['review']['social_media']['youtube'] . '" class="btn" target="_blank"><i class="fab fa-youtube"></i></a></li>' : '',
					'{$google}' => !empty($account['settings']['review']['social_media']['google']) ? '<li><a href="' . $account['settings']['review']['social_media']['google'] . '" class="btn" target="_blank"><i class="fab fa-google"></i></a></li>' : '',
					'{$tripadvisor}' => ($account['type'] == 'hotel' OR $account['type'] == 'restaurant') ? (!empty($account['settings']['review']['social_media']['tripadvisor']) ? '<li><a href="' . $account['settings']['review']['social_media']['tripadvisor'] . '" class="btn" target="_blank"><i class="fab fa-tripadvisor"></i></a></li>' : '') : ''
				];

				$template = $this->format->replace($replace, $template);

				echo $template;
			}
		}
		else
			header('Location: /');
    }
}
