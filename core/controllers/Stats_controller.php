<?php

defined('_EXEC') or die;

class Stats_controller extends Controller
{
	public function __construct()
	{
		parent::__construct();
	}

	public function index()
	{
		if (Format::exist_ajax_request() == true)
		{
			if ($_POST['action'] == 'get_v_chart_data')
			{
				Environment::return([
					'status' => 'success',
					'data' => [
						'oa' => $this->model->get_chart_data('v_oa_chart', $_POST, true),
						'r' => $this->model->get_chart_data('v_r_chart', $_POST, true),
						'l' => $this->model->get_chart_data('v_l_chart', $_POST, true),
					],
				]);
			}

			if ($_POST['action'] == 'get_ar_chart_data')
			{
				Environment::return([
					'status' => 'success',
					'data' => [
						'oa' => $this->model->get_chart_data('ar_oa_chart', $_POST, true),
						'r' => $this->model->get_chart_data('ar_r_chart', $_POST, true),
						'l' => $this->model->get_chart_data('ar_l_chart', $_POST, true),
					],
				]);
			}

			if ($_POST['action'] == 'get_c_chart_data')
			{
				Environment::return([
					'status' => 'success',
					'data' => [
						'oa' => $this->model->get_chart_data('c_oa_chart', $_POST, true),
						'r' => $this->model->get_chart_data('c_r_chart', $_POST, true),
						'l' => $this->model->get_chart_data('c_l_chart', $_POST, true),
					],
				]);
			}
		}
		else
		{
			define('_title', 'GuestVox | {$lang.stats}');

			$template = $this->view->render($this, 'index');

			$replace = [
				'{$average_resolution}' => $this->model->get_average('general_resolution'),
				'{$count_created_today}' => $this->model->get_count('created_today'),
				'{$count_created_week}' => $this->model->get_count('created_week'),
				'{$count_created_month}' => $this->model->get_count('created_month'),
				'{$count_created_year}' => $this->model->get_count('created_year'),
				'{$count_created_total}' => $this->model->get_count('created_total'),
			];

			$template = $this->format->replace($replace, $template);

			echo $template;
		}
	}

	public function charts()
	{
		header('Content-Type: application/javascript');

		$v_oa_chart_data = $this->model->get_chart_data('v_oa_chart', [
			'started_date' => Dates::get_past_date(Dates::get_current_date(), '7', 'days'),
			'date_end' => Dates::get_current_date(),
			'type' => 'all'
		]);

		$v_r_chart_data = $this->model->get_chart_data('v_r_chart', [
			'started_date' => Dates::get_past_date(Dates::get_current_date(), '7', 'days'),
			'date_end' => Dates::get_current_date(),
			'type' => 'all'
		]);

		$v_l_chart_data = $this->model->get_chart_data('v_l_chart', [
			'started_date' => Dates::get_past_date(Dates::get_current_date(), '7', 'days'),
			'date_end' => Dates::get_current_date(),
			'type' => 'all'
		]);

		$ar_oa_chart_data = $this->model->get_chart_data('ar_oa_chart', [
			'started_date' => Dates::get_past_date(Dates::get_current_date(), '7', 'days'),
			'date_end' => Dates::get_current_date(),
			'type' => 'all'
		]);

		$ar_r_chart_data = $this->model->get_chart_data('ar_r_chart', [
			'started_date' => Dates::get_past_date(Dates::get_current_date(), '7', 'days'),
			'date_end' => Dates::get_current_date(),
			'type' => 'all'
		]);

		$ar_l_chart_data = $this->model->get_chart_data('ar_l_chart', [
			'started_date' => Dates::get_past_date(Dates::get_current_date(), '7', 'days'),
			'date_end' => Dates::get_current_date(),
			'type' => 'all'
		]);

		$c_oa_chart_data = $this->model->get_chart_data('c_oa_chart', [
			'started_date' => Dates::get_past_date(Dates::get_current_date(), '7', 'days'),
			'date_end' => Dates::get_current_date(),
		]);

		$c_r_chart_data = $this->model->get_chart_data('c_r_chart', [
			'started_date' => Dates::get_past_date(Dates::get_current_date(), '7', 'days'),
			'date_end' => Dates::get_current_date(),
		]);

		$c_l_chart_data = $this->model->get_chart_data('c_l_chart', [
			'started_date' => Dates::get_past_date(Dates::get_current_date(), '7', 'days'),
			'date_end' => Dates::get_current_date(),
		]);

		if (Session::get_value('lang') == 'es')
		{
			$chart_opportunity_areas = 'Áreas de oportunidad';
			$chart_rooms = 'Habitaciones';
			$chart_locations = 'Ubicaciones';
		}
		else if (Session::get_value('lang') == 'en')
		{
			$chart_opportunity_areas = 'Opportunity areas';
			$chart_rooms = 'Rooms';
			$chart_locations = 'Locations';
		}

		$js =
		"'use strict';

		var v_oa_chart = {
	        type: 'pie',
	        data: {
				labels: [
	                " . $v_oa_chart_data['labels'] . "
	            ],
				datasets: [{
	                data: [
	                    " . $v_oa_chart_data['datasets']['data'] . "
	                ],
	                backgroundColor: [
	                    " . $v_oa_chart_data['datasets']['colors'] . "
	                ],
	            }],
	        },
	        options: {
				title: {
					display: true,
					text: '" . $chart_opportunity_areas . "'
				},
				legend: {
					display: false
				},
	            responsive: true
            }
        };

		var v_r_chart = {
	        type: 'pie',
	        data: {
				labels: [
	                " . $v_r_chart_data['labels'] . "
	            ],
				datasets: [{
	                data: [
	                    " . $v_r_chart_data['datasets']['data'] . "
	                ],
	                backgroundColor: [
	                    " . $v_r_chart_data['datasets']['colors'] . "
	                ],
	            }],
	        },
	        options: {
				title: {
					display: true,
					text: '" . $chart_rooms . "'
				},
				legend: {
					display: false
				},
	            responsive: true
            }
        };

		var v_l_chart = {
	        type: 'pie',
	        data: {
				labels: [
	                " . $v_l_chart_data['labels'] . "
	            ],
				datasets: [{
	                data: [
	                    " . $v_l_chart_data['datasets']['data'] . "
	                ],
	                backgroundColor: [
	                    " . $v_l_chart_data['datasets']['colors'] . "
	                ],
	            }],
	        },
	        options: {
				title: {
					display: true,
					text: '" . $chart_locations . "'
				},
				legend: {
					display: false
				},
	            responsive: true
            }
        };

		var ar_oa_chart = {
	        type: 'horizontalBar',
	        data: {
				labels: [
	                " . $ar_oa_chart_data['labels'] . "
	            ],
				datasets: [{
	                data: [
	                    " . $ar_oa_chart_data['datasets']['data'] . "
	                ],
	                backgroundColor: [
	                    " . $ar_oa_chart_data['datasets']['colors'] . "
	                ],
	            }],
	        },
	        options: {
				title: {
					display: true,
					text: '" . $chart_opportunity_areas . "'
				},
				legend: {
					display: false
				},
	            responsive: true
            }
        };

		var ar_r_chart = {
	        type: 'pie',
	        data: {
				labels: [
	                " . $ar_r_chart_data['labels'] . "
	            ],
				datasets: [{
	                data: [
	                    " . $ar_r_chart_data['datasets']['data'] . "
	                ],
	                backgroundColor: [
	                    " . $ar_r_chart_data['datasets']['colors'] . "
	                ],
	            }],
	        },
	        options: {
				title: {
					display: true,
					text: '" . $chart_rooms . "'
				},
				legend: {
					display: false
				},
	            responsive: true
            }
        };

		var ar_l_chart = {
	        type: 'pie',
	        data: {
				labels: [
	                " . $ar_l_chart_data['labels'] . "
	            ],
				datasets: [{
	                data: [
	                    " . $ar_l_chart_data['datasets']['data'] . "
	                ],
	                backgroundColor: [
	                    " . $ar_l_chart_data['datasets']['colors'] . "
	                ],
	            }],
	        },
	        options: {
				title: {
					display: true,
					text: '" . $chart_locations . "'
				},
				legend: {
					display: false
				},
	            responsive: true
            }
        };

		var c_oa_chart = {
	        type: 'pie',
	        data: {
				labels: [
	                " . $c_oa_chart_data['labels'] . "
	            ],
				datasets: [{
	                data: [
	                    " . $c_oa_chart_data['datasets']['data'] . "
	                ],
	                backgroundColor: [
	                    " . $c_oa_chart_data['datasets']['colors'] . "
	                ],
	            }],
	        },
	        options: {
				title: {
					display: true,
					text: '" . $chart_opportunity_areas . "'
				},
				legend: {
					display: false
				},
	            responsive: true
            }
        };

		var c_r_chart = {
	        type: 'pie',
	        data: {
				labels: [
	                " . $c_r_chart_data['labels'] . "
	            ],
				datasets: [{
	                data: [
	                    " . $c_r_chart_data['datasets']['data'] . "
	                ],
	                backgroundColor: [
	                    " . $c_r_chart_data['datasets']['colors'] . "
	                ],
	            }],
	        },
	        options: {
				title: {
					display: true,
					text: '" . $chart_rooms . "'
				},
				legend: {
					display: false
				},
	            responsive: true
            }
        };

		var c_l_chart = {
	        type: 'pie',
	        data: {
				labels: [
	                " . $c_l_chart_data['labels'] . "
	            ],
				datasets: [{
	                data: [
	                    " . $c_l_chart_data['datasets']['data'] . "
	                ],
	                backgroundColor: [
	                    " . $c_l_chart_data['datasets']['colors'] . "
	                ],
	            }],
	        },
	        options: {
				title: {
					display: true,
					text: '" . $chart_locations . "'
				},
				legend: {
					display: false
				},
	            responsive: true
            }
        };

		window.onload = function()
		{
			v_oa_chart = new Chart(document.getElementById('v_oa_chart').getContext('2d'), v_oa_chart);
			v_r_chart = new Chart(document.getElementById('v_r_chart').getContext('2d'), v_r_chart);
			v_l_chart = new Chart(document.getElementById('v_l_chart').getContext('2d'), v_l_chart);
			ar_oa_chart = new Chart(document.getElementById('ar_oa_chart').getContext('2d'), ar_oa_chart);
			ar_r_chart = new Chart(document.getElementById('ar_r_chart').getContext('2d'), ar_r_chart);
			ar_l_chart = new Chart(document.getElementById('ar_l_chart').getContext('2d'), ar_l_chart);
			c_oa_chart = new Chart(document.getElementById('c_oa_chart').getContext('2d'), c_oa_chart);
			c_r_chart = new Chart(document.getElementById('c_r_chart').getContext('2d'), c_r_chart);
			c_l_chart = new Chart(document.getElementById('c_l_chart').getContext('2d'), c_l_chart);
		};";

		$js = trim(str_replace(array("\t\t\t"), '', $js));

		echo $js;
	}
}
