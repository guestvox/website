<?php

defined('_EXEC') or die;

include_once(PATH_MODELS . 'Voxes_model.php');
include_once(PATH_MODELS . 'Surveys_model.php');

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

			$voxes_model = new Voxes_model();
			$voxes_not_complete_all = $voxes_model->get_voxes('not_complete_all');
			$voxes_not_complete_request = $voxes_model->get_voxes('not_complete_request');
			$voxes_not_complete_incident = $voxes_model->get_voxes('not_complete_incident');
			$voxes_not_complete_workorder = $voxes_model->get_voxes('not_complete_workorder');
			$voxes_not_complete_high = $voxes_model->get_voxes('not_complete_high');
			$voxes_not_complete_medium = $voxes_model->get_voxes('not_complete_medium');
			$voxes_not_complete_low = $voxes_model->get_voxes('not_complete_low');

			$surveys_model = new Surveys_model();
			$surveys_average = $surveys_model->get_surveys_average('all');
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

			$replace = [
				'{$voxes_not_complete_all_count}' => count($voxes_not_complete_all),
				'{$voxes_not_complete_all_class}' => (!empty($voxes_not_complete_high) ? 'high' : (!empty($voxes_not_complete_medium) ? 'medium' : (!empty($voxes_not_complete_low) ? 'low' : ''))),
				'{$voxes_not_complete_request_count}' => count($voxes_not_complete_request),
				'{$voxes_not_complete_incident_count}' => count($voxes_not_complete_incident),
				'{$voxes_not_complete_workorder_count}' => count($voxes_not_complete_workorder),
				'{$voxes_not_complete_high_count}' => count($voxes_not_complete_high),
				'{$voxes_not_complete_medium_count}' => count($voxes_not_complete_medium),
				'{$voxes_not_complete_low_count}' => count($voxes_not_complete_low),
				'{$h2_surveys_average}' => $h2_surveys_average,
				'{$spn_surveys_average}' => $spn_surveys_average,
				'{$surveys_porcentage_one}' => $surveys_model->get_surveys_percentage('all', 'one'),
				'{$surveys_porcentage_two}' => $surveys_model->get_surveys_percentage('all', 'two'),
				'{$surveys_porcentage_tree}' => $surveys_model->get_surveys_percentage('all', 'tree'),
				'{$surveys_porcentage_four}' => $surveys_model->get_surveys_percentage('all', 'four'),
				'{$surveys_porcentage_five}' => $surveys_model->get_surveys_percentage('all', 'five')
			];

			$template = $this->format->replace($replace, $template);

			echo $template;
		}
	}

	public function charts()
	{
		header('Content-Type: application/javascript');

		$surveys_model = new Surveys_model();
		$s2_chart_data = $surveys_model->get_chart_data('all', 's2_chart');

		$js =
		"'use strict';

		var s2_chart = {
	        type: 'doughnut',
	        data: {
				labels: [
	                " . $s2_chart_data['labels'] . "
	            ],
				datasets: [{
					data: [
	                    " . $s2_chart_data['datasets']['data'] . "
	                ],
	                backgroundColor: [
	                    " . $s2_chart_data['datasets']['colors'] . "
	                ]
	            }]
	        },
	        options: {
				title: {
					display: true,
					text: '" . Languages::charts('s2_chart')[$this->lang] . "'
				},
				legend: {
					display: true,
					position: 'left'
				},
	            responsive: true
            }
        };

		document.getElementById('nps').innerHTML  = '" . $s2_chart_data['nps'] . "%';";

		$js .=
		"window.onload = function()
		{
			s2_chart = new Chart(document.getElementById('s2_chart').getContext('2d'), s2_chart);";

		$js .= "};";

		$js = trim(str_replace(array("\t\t\t"), '', $js));

		echo $js;
	}
}
