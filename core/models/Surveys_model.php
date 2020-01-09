<?php

defined('_EXEC') or die;

class Surveys_model extends Model
{
	public function __construct()
	{
		parent::__construct();
	}

	public function get_survey_questions()
	{
		$query = Functions::get_json_decoded_query($this->database->select('survey_questions', [
			'id',
			'name',
			'subquestions',
			'type',
			'status',
		], [
			'account' => Session::get_value('account')['id']
		]));

		return $query;
	}

	public function get_survey_question($id)
	{
		$query = Functions::get_json_decoded_query($this->database->select('survey_questions', [
			'name',
			'subquestions',
			'type',
		], [
			'id' => $id
		]));

		return !empty($query) ? $query[0] : null;
	}

    public function new_survey_question($data)
	{
		$query = $this->database->insert('survey_questions', [
			'account' => Session::get_value('account')['id'],
			'name' => json_encode([
				'es' => $data['name_es'],
				'en' => $data['name_en'],
			]),
			'subquestions' => json_encode([]),
			'type' => $data['type'],
			'status' => true,
		]);

		return $query;
	}

    public function edit_survey_question($data)
	{
		$query = $this->database->update('survey_questions', [
			'name' => json_encode([
				'es' => $data['name_es'],
				'en' => $data['name_en'],
			]),
			'type' => $data['type'],
		], [
			'id' => $data['id'],
		]);

		return $query;
	}

    public function edit_survey_subquestions($id, $data)
	{
		$query = $this->database->update('survey_questions', [
			'subquestions' => json_encode($data),
		], [
			'id' => $id,
		]);

		return $query;
	}

	public function deactivate_survey_question($id)
	{
		$query = $this->database->update('survey_questions', [
			'status' => false
		], [
			'id' => $id,
		]);

		return $query;
	}

	public function activate_survey_question($id)
	{
		$query = $this->database->update('survey_questions', [
			'status' => true
		], [
			'id' => $id,
		]);

		return $query;
	}

	public function delete_survey_question($id)
	{
		$query = $this->database->delete('survey_questions', [
			'id' => $id
		]);

		return $query;
	}

	public function get_survey_answers()
	{
		$query = Functions::get_json_decoded_query($this->database->select('survey_answers', [
			'[>]rooms' => [
				'room' => 'id'
			],
		], [
			'survey_answers.id',
			'rooms.name(room)',
			'survey_answers.answers',
			'survey_answers.comment',
			'survey_answers.guest',
			'survey_answers.date',
			'survey_answers.token',
		], [
			'survey_answers.account' => Session::get_value('account')['id']
		]));

		return $query;
	}

	public function get_survey_answer($id)
	{
		$query = Functions::get_json_decoded_query($this->database->select('survey_answers', [
			'[>]rooms' => [
				'room' => 'id'
			],
		], [
			'survey_answers.id',
			'rooms.name(room)',
			'survey_answers.answers',
			'survey_answers.comment',
			'survey_answers.guest',
			'survey_answers.date',
			'survey_answers.token',
		], [
			'survey_answers.id' => $id
		]));

		return !empty($query) ? $query[0] : null;
	}

	public function get_average($option, $params = null)
	{
		$query = Functions::get_json_decoded_query($this->database->select('survey_answers', [
			'answers',
		], [
			'account' => Session::get_value('account')['id']
		]));

		$suma = 0;

		foreach ($query as $value)
		{
			$count = 0;
			$answers = [];
			foreach ($value['answers'] as $subvalue)
			{
				if ($subvalue['type'] == 'rate')
				{
					$count = $count + $subvalue['answer'];
					array_push($answers, $subvalue);
				}
			}

			if (!empty($count))
				$count = $count / count($answers);
			else
				$count = 0;

			$suma = $suma += $count;

		}

		if (!empty($query))
			$suma = $suma / count($query);

		return (!empty($suma) ? round($suma, 1) : 0);

	}

	public function get_count($option, $params = null)
	{
		$count = 0;

		if ($option == 'received_today' OR $option == 'received_week' OR $option == 'received_month' OR $option == 'received_total')
		{
			$query = $this->database->select('survey_answers', [
				'id',
				'account',
				'date',
			], [
				'account' => Session::get_value('account')['id']
			]);

			foreach ($query as $value)
			{
				$break = false;

				if ($option == 'received_today' AND Functions::get_formatted_date($value['date']) != Functions::get_current_date())
					$break = true;

				if ($option == 'received_week' AND Functions::get_formatted_date($value['date']) < Functions::get_current_week()[0] OR Functions::get_formatted_date($value['date']) > Functions::get_current_week()[1])
					$break = true;

				if ($option == 'received_month' AND Functions::get_formatted_date($value['date']) < Functions::get_current_month()[0] OR Functions::get_formatted_date($value['date']) > Functions::get_current_month()[1])
					$break = true;

				if ($option == 'received_year' AND explode('-', Functions::get_formatted_date($value['date']))[0] != Functions::get_current_year())
					$break = true;

				if ($break == false)
					$count = $count + 1;
			}

		}

		return $count;
	}

	public function get_chart_data($option)
	{
		$data = null;

		if ($option == 's_r1_chart' and Session::get_value('account')['type'] == 'hotel')
		{
			$query1 = $this->database->select('survey_answers', [
				'room',
			], [
				'account' => Session::get_value('account')['id']
			]);

			$query2 = $this->database->select('rooms', [
				'id',
				'name'
			], [
				'account' => Session::get_value('account')['id'],
			]);

			$data = [
				'labels' => '',
				'datasets' => [
					'data' => '',
					'colors' => ''
				]
			];

			foreach ($query2 as $value)
			{
				$count = 0;

				foreach ($query1 as $subvalue)
				{
					if ($value['id'] == $subvalue['room'])
						$count = $count + 1;
				}

				if ($count > 0)
				{
					$data['labels'] .= "'" . $value['name'] . "',";
					$data['datasets']['data'] .= $count . ',';
					$data['datasets']['colors'] .= "'#" . str_pad( dechex( mt_rand( 0, 255 ) ), 2, '0', STR_PAD_LEFT) . str_pad( dechex( mt_rand( 0, 255 ) ), 2, '0', STR_PAD_LEFT) . str_pad( dechex( mt_rand( 0, 255 ) ), 2, '0', STR_PAD_LEFT) . "',";
				}
			}
		}
		else if ($option == 's_r1_chart' and Session::get_value('account')['type'] == 'restaurant')
		{
			$query1 = $this->database->select('survey_answers', [
				'table',
			], [
				'account' => Session::get_value('account')['id']
			]);

			$query2 = $this->database->select('table', [
				'id',
				'name'
			], [
				'account' => Session::get_value('account')['id'],
			]);

			$data = [
				'labels' => '',
				'datasets' => [
					'data' => '',
					'colors' => ''
				]
			];

			foreach ($query2 as $value)
			{
				$count = 0;

				foreach ($query1 as $subvalue)
				{
					if ($value['id'] == $subvalue['table'])
						$count = $count + 1;
				}

				if ($count > 0)
				{
					$data['labels'] .= "'" . $value['name'] . "',";
					$data['datasets']['data'] .= $count . ',';
					$data['datasets']['colors'] .= "'#" . str_pad( dechex( mt_rand( 0, 255 ) ), 2, '0', STR_PAD_LEFT) . str_pad( dechex( mt_rand( 0, 255 ) ), 2, '0', STR_PAD_LEFT) . str_pad( dechex( mt_rand( 0, 255 ) ), 2, '0', STR_PAD_LEFT) . "',";
				}
			}
		}
		else if ($option == 's_r2_chart')
		{
			$query1 = Functions::get_json_decoded_query($this->database->select('survey_questions', [
				'id',
				'name'
			], [
				'AND' => [
					'account' => Session::get_value('account')['id'],
					'type' => 'rate',
					'status' => true
				],
			]));

			$query2 = Functions::get_json_decoded_query($this->database->select('survey_answers', [
				'answers',
			], [
				'account' => Session::get_value('account')['id']
			]));

			$data = [
				'labels' => '',
				'datasets' => [
					'data' => '',
					'colors' => ''
				]
			];

			foreach ($query1 as $value)
			{
				$count = 0;

				foreach ($query2 as $subvalue)
				{
					foreach ($subvalue['answers'] as $childvalue)
					{
						if ($childvalue['type'] == 'rate' AND $value['id'] == $childvalue['id'])
							$count = $count + $childvalue['answer'];
					}
				}

				if ($count > 0)
				{
					$data['labels'] .= "'" . $value['name'][Session::get_value('account')['language']] . "',";
					$data['datasets']['data'] .= $count . ',';
					$data['datasets']['colors'] .= "'#" . str_pad( dechex( mt_rand( 0, 255 ) ), 2, '0', STR_PAD_LEFT) . str_pad( dechex( mt_rand( 0, 255 ) ), 2, '0', STR_PAD_LEFT) . str_pad( dechex( mt_rand( 0, 255 ) ), 2, '0', STR_PAD_LEFT) . "',";
				}
			}
		}
		else if ($option == 's_r3_chart')
		{
			$query1 = Functions::get_json_decoded_query($this->database->select('survey_answers', [
				'answers'
			], [
				'account' => Session::get_value('account')['id']
			]));

			$yes = 0;
			$no = 0;

			foreach ($query1 as $value)
			{
				foreach ($value['answers'] as $subvalue)
				{
					if ($subvalue['type'] == 'twin' AND $subvalue['answer'] == 'yes')
						$yes = $yes + 1;
					else if ($subvalue['type'] == 'twin' AND $subvalue['answer'] == 'no')
						$no = $no + 1;

					foreach ($subvalue['subanswers'] as $childvalue)
					{
						if(!empty($childvalue['answer']))
						{
							if ($childvalue['type'] == 'twin' AND $childvalue['answer'] == 'yes')
								$yes = $yes + 1;
							else if ($childvalue['type'] == 'twin' AND $childvalue['answer'] == 'no')
								$no = $no + 1;
						}

					}
				}
			}

			$data = [
				'labels' => '"Si","No"',
				'datasets' => [
					'data' => $yes . ',' . $no,
					'colors' => '"#4caf50","#3f51b5"'
				]
			];
		}
		else if ($option == 's_r4_chart')
		{
			$query = Functions::get_json_decoded_query($this->database->select('survey_answers', [
				'answers',
				'date',
			], [
				'account' => Session::get_value('account')['id']
			]));

			$rate_today = 0;
			$rate_lastday_1 = 0;
			$rate_lastday_2 = 0;
			$rate_lastday_3 = 0;
			$rate_lastday_4 = 0;
			$rate_lastday_5 = 0;
			$rate_lastday_6 = 0;
			$answers_today = 0;
			$answers_lastday_1 = 0;
			$answers_lastday_2 = 0;
			$answers_lastday_3 = 0;
			$answers_lastday_4 = 0;
			$answers_lastday_5 = 0;
			$answers_lastday_6 = 0;
			$prom_today = 0;
			$prom_lastday_1 = 0;
			$prom_lastday_2 = 0;
			$prom_lastday_3 = 0;
			$prom_lastday_4 = 0;
			$prom_lastday_5 = 0;
			$prom_lastday_6 = 0;

			foreach ($query as $key => $value)
			{
				foreach ($value['answers'] as $subvalue)
				{
					if ($subvalue['type'] == 'rate')
					{
						if ($value['date'] == Functions::get_current_date())
						{
							$rate_today = $rate_today + $subvalue['answer'];
							$answers_today = $answers_today + 1;
						}
						else if ($value['date'] == Functions::get_past_date(Functions::get_current_date(), '1', 'days'))
						{
							$rate_lastday_1 = $rate_lastday_1 + $subvalue['answer'];
							$answers_lastday_1 = $answers_lastday_1 + 1;
						}
						else if ($value['date'] == Functions::get_past_date(Functions::get_current_date(), '2', 'days'))
						{
							$rate_lastday_2 = $rate_lastday_2 + $subvalue['answer'];
							$answers_lastday_2 = $answers_lastday_2 + 1;
						}
						else if ($value['date'] == Functions::get_past_date(Functions::get_current_date(), '3', 'days'))
						{
							$rate_lastday_3 = $rate_lastday_3 + $subvalue['answer'];
							$answers_lastday_3 = $answers_lastday_3 + 1;
						}
						else if ($value['date'] == Functions::get_past_date(Functions::get_current_date(), '4', 'days'))
						{
							$rate_lastday_4 = $rate_lastday_4 + $subvalue['answer'];
							$answers_lastday_4 = $answers_lastday_4 + 1;
						}
						else if ($value['date'] == Functions::get_past_date(Functions::get_current_date(), '5', 'days'))
						{
							$rate_lastday_5 = $rate_lastday_5 + $subvalue['answer'];
							$answers_lastday_5 = $answers_lastday_5 + 1;
						}
						else if ($value['date'] == Functions::get_past_date(Functions::get_current_date(), '6', 'days'))
						{
							$rate_lastday_6 = $rate_lastday_6 + $subvalue['answer'];
							$answers_lastday_6 = $answers_lastday_6 + 1;
						}
					}

				}

			}

			if ($rate_today > 0)
				$prom_today = $rate_today / $answers_today;

			if ($rate_lastday_1 > 0)
				$prom_lastday_1 = $rate_lastday_1 / $answers_lastday_1;

			if ($rate_lastday_2 > 0)
				$prom_lastday_2 = $rate_lastday_2 / $answers_lastday_2;

			if ($rate_lastday_3 > 0)
				$prom_lastday_3 = $rate_lastday_3 / $answers_lastday_3;

		 	if ($rate_lastday_4 > 0)
				$prom_lastday_4 = $rate_lastday_4 / $answers_lastday_4;

			if ($rate_lastday_5 > 0)
				$prom_lastday_5 = $rate_lastday_5 / $answers_lastday_5;

			if ($rate_lastday_6 > 0)
				$prom_lastday_6 = $rate_lastday_6 / $answers_lastday_6;

			$data = [
				'labels' => '"Hoy", "1 día", "2 días", "3 días", "4 días", "5 días", "6 días"',
				'datasets' => [
					'labels' => '"Preguntas"',
					'data' => $prom_today . ',' . $prom_lastday_1 . ',' . $prom_lastday_2 . ',' . $prom_lastday_3 . ',' . $prom_lastday_4 . ',' . $prom_lastday_5 . ',' . $prom_lastday_6,
					'colors' => '"#4caf50", "#4caf50", "#4caf50" , "#4caf50" , "#4caf50" , "#4caf50" , "#4caf50"'
				]
			];
		}
		// else if ($option == 's_r5_chart')
		// {
		// 	$query = Functions::get_json_decoded_query($this->database->select('survey_answers', [
		// 		'answers',
		// 		'date',
		// 	], [
		// 		'account' => Session::get_value('account')['id']
		// 	]));
		//
		// 	$query2 = Functions::get_json_decoded_query($this->database->select('survey_questions', [
		// 		'id',
		// 		'name',
		// 		'subquestions',
		// 	], [
		// 		'account' => Session::get_value('account')['id']
		// 	]));
		//
		// 	$suma = 0;
		// 	$average_question = 0;
		//
		// 	foreach ($query as $value)
		// 	{
		// 		foreach ($value['answers'] as $subvalue)
		// 		{
		// 			foreach ($query2 as $value_question)
		// 			{
		// 				if ($subvalue['type'] == 'rate')
		// 				{
		// 					if ($subvalue['id'] == $value_question['id'])
		// 					{
		// 						$rate_question = 0;
		// 						$answers_question = 0;
		//
		// 						$rate_question = $rate_question + $subvalue['answer'];
		// 						$answers_question = $answers_question + 1;
		//
		//
		// 						$suma = $suma += $rate_question;
		// 					}
		// 				}
		// 			}
		// 		}
		//
		// 		print_r($rate_question);
		//
		// 		if ($suma > 0)
		// 			$average_question = $suma / $answers_question;
		//
		//
		//
		// 	}
		//
		// 	$data = [
		// 		'labels' => '"Hoy"',
		// 		'name' => 'Pregunta',
		// 		'datasets' => [
		// 			'labels' => '"Rate"',
		// 			'data' => $average_question ,
		// 			'colors' => '"#4caf50"'
		// 		]
		// 	];
		//
		// }

		return $data;
	}

	public function get_total_rate_avarage()
	{
		$count1 = 0;
		$count2 = 0;

		$query = Functions::get_json_decoded_query($this->database->select('survey_answers', [
			'answers',
		], [
			'account' => Session::get_value('account')['id']
		]));

		foreach ($query as $value)
		{
			foreach ($value['answers'] as $subvalue)
			{
				if ($subvalue['type'] == 'rate')
				{
					$count1 = $count1 + $subvalue['answer'];
					$count2 = $count2 + 1;
				}
			}
		}

		return ($count1 > 0 AND $count2 > 0) ? round(($count1 / $count2), 2) : 0;
	}
}
