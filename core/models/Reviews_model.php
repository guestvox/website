<?php

defined('_EXEC') or die;

class Reviews_model extends Model
{
	public function __construct()
	{
		parent::__construct();
	}

	// public function sql ()
	// {
	// 	$query = Functions::get_json_decoded_query($this->database->select('accounts', [
	// 		'id',
	// 		'name',
	// 		'type',
	// 		'city',
	// 		'address',
	// 		'language',
	// 		'logotype',
	// 		'contact',
	// 		'operation',
	// 		'reputation',
	// 		'zaviapms',
	// 		'sms',
	// 		'settings'
	// 	], [
	// 		'AND' => [
	// 			'status' => true
	// 		]
	// 	]));
	//
	// 	foreach ($query as $key => $value)
	// 	{
	// 		if ($value['type'] == 'hotel')
	// 		{
	// 			$value['settings'] = [
	// 				'myvox' => [
	// 					'request' => $value['settings']['myvox']['request'],
	// 					'incident' => $value['settings']['myvox']['incident'],
	// 					'survey' => $value['settings']['myvox']['survey'],
	// 					'survey_title' => [
	// 						'es' => $value['settings']['myvox']['survey_title']['es'],
	// 						'en' => $value['settings']['myvox']['survey_title']['en']
	// 					],
	// 					'survey_tripadvisor' => $value['settings']['myvox']['survey_tripadvisor'],
	// 					'survey_tripadvisor_url' => $value['settings']['myvox']['survey_tripadvisor_url']
	// 				],
	// 				'reviews' => [
	// 					'page' => false
	// 				]
	// 			];
	//
	// 			$sql = $this->database->update('accounts', [
	// 				'settings' => json_encode($value['settings'])
	// 			], [
	// 				'id' => $value['id']
	// 			]);
	// 		}
	// 	 	if ($value['type'] == 'others')
	// 		{
	// 			$value['settings'] = [
	// 				'myvox' => [
	// 					'request' => $value['settings']['myvox']['request'],
	// 					'incident' => $value['settings']['myvox']['incident'],
	// 					'survey' => $value['settings']['myvox']['survey'],
	// 					'survey_title' => [
	// 						'es' => $value['settings']['myvox']['survey_title']['es'],
	// 						'en' => $value['settings']['myvox']['survey_title']['en']
	// 					]
	// 				],
	// 				'reviews' => [
	// 					'page' => false
	// 				]
	// 			];
	//
	// 			$sql = $this->database->update('accounts', [
	// 				'settings' => json_encode($value['settings'])
	// 			], [
	// 				'id' => $value['id']
	// 			]);
	// 		}
	//
	// 	}
	// }

	public function get_account($path)
	{
		$query = Functions::get_json_decoded_query($this->database->select('accounts', [
			'id',
			'name',
			'type',
			'city',
			'address',
			'language',
			'logotype',
			'contact',
			'review_contact',
			'operation',
			'reputation',
			'zaviapms',
			'sms',
			'settings'
		], [
			'AND' => [
				'path' => $path,
				'status' => true
			]
		]));

		return !empty($query) ? $query[0] : null;
	}

    public function get_general_average_rate()
	{
		$query = Functions::get_json_decoded_query($this->database->select('survey_answers', [
			'answers'
		], [
			'account' =>  Session::get_value('account')['id']
		]));

		$average = 0;
		$rate = 0;
		$questions = 0;

		foreach ($query as $value)
		{
			foreach ($value['answers'] as $subvalue)
			{
				if ($subvalue['type'] == 'rate')
				{
					$rate = $rate + $subvalue['answer'];
					$questions = $questions + 1;
				}

				foreach ($subvalue['subanswers'] as $parentvalue)
				{
					if ($parentvalue['type'] == 'rate')
					{
						$rate = $rate + $parentvalue['answer'];
						$questions = $questions + 1;
					}

					foreach ($parentvalue['subanswers'] as $childvalue)
					{
						if ($childvalue['type'] == 'rate')
						{
							$rate = $rate + $childvalue['answer'];
							$questions = $questions + 1;
						}
					}
				}
			}
		}

		if ($rate > 0 AND $questions > 0)
			$average = round(($rate / $questions), 1);

		return $average;
	}

    public function get_percentage_rate($option)
	{
		$query = Functions::get_json_decoded_query($this->database->select('survey_answers', [
			'answers'
		], [
			'account' => Session::get_value('account')['id']
		]));

		$percentage = 0;
		$option_answers = 0;
		$total_answers = 0;

		foreach ($query as $value)
		{
			$average = 0;
			$rate = 0;
			$answers = 0;

			foreach ($value['answers'] as $subvalue)
			{
				if ($subvalue['type'] == 'rate')
				{
					$rate = $rate + $subvalue['answer'];
					$answers = $answers + 1;
				}

				foreach ($subvalue['subanswers'] as $parentvalue)
				{
					if ($parentvalue['type'] == 'rate')
					{
						$rate = $rate + $parentvalue['answer'];
						$answers = $answers + 1;
					}

					foreach ($parentvalue['subanswers'] as $childvalue)
					{
						if ($childvalue['type'] == 'rate')
						{
							$rate = $rate + $childvalue['answer'];
							$answers = $answers + 1;
						}
					}
				}
			}

			if ($rate > 0 AND $answers > 0)
				$average = round(($rate / $answers), 2);

			if ($option == 'five' AND $average > 4.8 AND $average <= 5)
				$option_answers = $option_answers + 1;
			else if ($option == 'four' AND $average >= 3.8 AND $average < 4.8)
				$option_answers = $option_answers + 1;
			else if ($option == 'tree' AND $average >= 2.8 AND $average < 3.8)
				$option_answers = $option_answers + 1;
			else if ($option == 'two' AND $average >= 1.8 AND $average < 2.8)
				$option_answers = $option_answers + 1;
			else if ($option == 'one' AND $average >= 1 AND $average < 1.8)
				$option_answers = $option_answers + 1;

			$total_answers = $total_answers + 1;
		}

		if ($option_answers > 0 AND $total_answers > 0)
			$percentage = round((($option_answers / $total_answers) * 100), 2);

		return $percentage;
	}

    public function get_count($option)
	{
		$query = $this->database->select('survey_answers', [
			'id',
			'account',
			'date'
		], [
			'account' => Session::get_value('account')['id']
		]);

		$count = 0;

		foreach ($query as $value)
		{
			$break = false;

			if ($option == 'answered_today' AND Functions::get_formatted_date($value['date']) != Functions::get_current_date())
				$break = true;

			if ($option == 'answered_week' AND Functions::get_formatted_date($value['date']) < Functions::get_current_week()[0] OR Functions::get_formatted_date($value['date']) > Functions::get_current_week()[1])
				$break = true;

			if ($option == 'answered_month' AND Functions::get_formatted_date($value['date']) < Functions::get_current_month()[0] OR Functions::get_formatted_date($value['date']) > Functions::get_current_month()[1])
				$break = true;

			if ($option == 'answered_year' AND explode('-', Functions::get_formatted_date($value['date']))[0] != Functions::get_current_year())
				$break = true;

			if ($break == false)
				$count = $count + 1;
		}

		return $count;
	}

	public function get_survey_answers()
	{
		$query = Functions::get_json_decoded_query($this->database->select('survey_answers', [
			'id',
			'token',
			'room',
			'table',
			'client',
			'answers',
			'comment',
			'guest',
			'date',
			'status'
		], [
			'account' => Session::get_value('account')['id'],
			'ORDER' => [
				'id' => 'DESC'
			]
		]));

		foreach ($query as $key => $value)
		{
			$query[$key]['rate'] = 0;
			$count = 0;

			foreach ($value['answers'] as $subvalue)
			{
				if ($subvalue['type'] == 'rate')
				{
					$query[$key]['rate'] = $query[$key]['rate'] + $subvalue['answer'];
					$count = $count + 1;
				}

				foreach ($subvalue['subanswers'] as $parentvalue)
				{
					if ($parentvalue['type'] == 'rate')
					{
						$query[$key]['rate'] = $query[$key]['rate'] + $parentvalue['answer'];
						$count = $count + 1;
					}

					foreach ($parentvalue['subanswers'] as $childvalue)
					{
						if ($childvalue['type'] == 'rate')
						{
							$query[$key]['rate'] = $query[$key]['rate'] + $childvalue['answer'];
							$count = $count + 1;
						}
					}
				}
			}

			if ($query[$key]['rate'] > 0 AND $count > 0)
				$query[$key]['rate'] = round(($query[$key]['rate'] / $count), 1);

			$query[$key]['count'] = count($query);
		}

		return $query;
	}
}
