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
			'status'
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
			'type'
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
				'en' => $data['name_en']
			]),
			'subquestions' => json_encode([]),
			'type' => $data['type'],
			'status' => true
		]);

		return $query;
	}

    public function edit_survey_question($data)
	{
		if ($data['action'] == 'edit_survey_question')
		{
			$fields = [
				'name' => json_encode([
					'es' => $data['name_es'],
					'en' => $data['name_en']
				]),
				'type' => $data['type']
			];
		}
		else if ($data['action'] == 'new_survey_subquestion' OR $data['action'] == 'edit_survey_subquestion' OR $data['action'] == 'deactivate_survey_subquestion' OR $data['action'] == 'activate_survey_subquestion' OR $data['action'] == 'delete_survey_subquestion')
		{
			$fields = [
				'subquestions' => json_encode($data['question']['subquestions'])
			];
		}

		$query = $this->database->update('survey_questions', $fields, [
			'id' => $data['id']
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
			'id',
			'token',
			'room',
			'table',
			'answers',
			'comment',
			'guest',
			'date'
		], [
			'account' => Session::get_value('account')['id'],
			'ORDER' => [
				'id' => 'DESC'
			]
		]));

		foreach ($query as $key => $value)
		{
			if (Session::get_value('account')['type'] == 'hotel')
			{
				if (!empty($value['room']))
					$query[$key]['room'] = $this->get_room($value['room']);
			}

			if (Session::get_value('account')['type'] == 'restaurant')
			{
				if (!empty($value['table']))
					$query[$key]['table'] = $this->get_table($value['table']);
			}

			$query[$key]['rate'] = 0;
			$count = 0;

			foreach ($value['answers'] as $subvalue)
			{
				if ($subvalue['type'] == 'rate')
				{
					$query[$key]['rate'] = $query[$key]['rate'] + $subvalue['answer'];
					$count = $count + 1;
				}
			}

			if ($query[$key]['rate'] > 0 AND $count > 0)
			{
				$query[$key]['rate'] = $query[$key]['rate'] / $count;
				$query[$key]['rate'] = round($query[$key]['rate'], 2);
			}

			$query[$key]['count'] = count($query);
		}

		return $query;
	}

	public function get_survey_answer($id)
	{
		$query = Functions::get_json_decoded_query($this->database->select('survey_answers', [
			'token',
			'room',
			'table',
			'answers',
			'comment',
			'guest',
			'date'
		], [
			'id' => $id
		]));

		if (!empty($query))
		{
			if (Session::get_value('account')['type'] == 'hotel')
			{
				if (!empty($query[0]['room']))
					$query[0]['room'] = $this->get_room($query[0]['room']);
			}

			if (Session::get_value('account')['type'] == 'restaurant')
			{
				if (!empty($query[0]['table']))
					$query[0]['table'] = $this->get_table($query[0]['table']);
			}

			$query[0]['rate'] = 0;
			$count = 0;

			foreach ($query[0]['answers'] as $key => $value)
			{
				$value['question'] = $this->get_survey_question($query[0]['answers'][$key]['id']);

				foreach ($value['subanswers'] as $subkey => $subvalue)
				{
					foreach ($value['question']['subquestions'] as $parentkey => $parentvalue)
					{
						if ($subvalue['id'] == $parentvalue['id'])
							$query[0]['answers'][$key]['subanswers'][$subkey]['question'] = $parentvalue['name'];
					}

					foreach ($subvalue['subanswers'] as $parentkey => $parentvalue)
					{
						foreach ($value['question']['subquestions'] as $childkey => $childvalue)
						{
							foreach ($childvalue['subquestions'] as $slavekey => $slavevalue)
							{
								if ($parentvalue['id'] == $slavevalue['id'])
									$query[0]['answers'][$key]['subanswers'][$subkey]['subanswers'][$parentkey]['question'] = $slavevalue['name'];
							}
						}
					}
				}

				$query[0]['answers'][$key]['question'] = $value['question']['name'];

				if ($value['type'] == 'rate')
				{
					$query[0]['rate'] = $query[0]['rate'] + $value['answer'];
					$count = $count + 1;
				}
			}

			if ($query[0]['rate'] > 0 AND $count > 0)
			{
				$query[0]['rate'] = $query[0]['rate'] / $count;
				$query[0]['rate'] = round($query[0]['rate'], 2);
			}

			return $query[0];
		}
		else
			return null;
	}

	public function get_room($id)
	{
		$query = $this->database->select('rooms', [
			'number',
			'name'
		], [
			'id' => $id
		]);

		return !empty($query) ? $query[0] : null;
	}

	public function get_table($id)
	{
		$query = $this->database->select('tables', [
			'number',
			'name'
		], [
			'id' => $id
		]);

		return !empty($query) ? $query[0] : null;
	}

	public function get_general_average_rate()
	{
		$query = Functions::get_json_decoded_query($this->database->select('survey_answers', [
			'answers'
		], [
			'account' => Session::get_value('account')['id']
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
			$average = round(($rate / $questions), 2);

		return $average;
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

	public function get_percentage_rate($option)
	{
		$query = Functions::get_json_decoded_query($this->database->select('survey_answers', [
			'answers'
		], [
			'account' => Session::get_value('account')['id']
		]));

		if ($option == 'five')
			$option = 5;
		else if ($option == 'four')
			$option = 4;
		else if ($option == 'tree')
			$option = 3;
		else if ($option == 'two')
			$option = 2;
		else if ($option == 'one')
			$option = 1;

		$percentage = 0;
		$general_rate = 0;
		$value_rate = 0;

		foreach ($query as $value)
		{
			foreach ($value['answers'] as $subvalue)
			{
				if ($subvalue['type'] == 'rate')
				{
					$general_rate = $general_rate + $subvalue['answer'];

					if ($subvalue['answer'] == $option)
						$value_rate = $value_rate + $subvalue['answer'];
				}

				foreach ($subvalue['subanswers'] as $parentvalue)
				{
					if ($parentvalue['type'] == 'rate')
					{
						$general_rate = $general_rate + $parentvalue['answer'];

						if ($parentvalue['answer'] == $option)
							$value_rate = $value_rate + $parentvalue['answer'];
					}

					foreach ($parentvalue['subanswers'] as $childvalue)
					{
						if ($childvalue['type'] == 'rate')
						{
							$general_rate = $general_rate + $childvalue['answer'];

							if ($childvalue['answer'] == $option)
								$value_rate = $value_rate + $childvalue['answer'];
						}
					}
				}
			}
		}

		if ($value_rate > 0 AND $general_rate > 0)
			$percentage = round((($value_rate / $general_rate) * 100), 2);

		return $percentage;
	}

	public function get_chart_data($option)
	{
		$data = null;

		if ($option == 's1_chart')
		{
			if (Session::get_value('account')['type'] == 'hotel')
			{
				$query1 = $this->database->select('survey_answers', [
					'room'
				], [
					'account' => Session::get_value('account')['id']
				]);

				$query2 = $this->database->select('rooms', [
					'id',
					'number',
					'name'
				], [
					'account' => Session::get_value('account')['id']
				]);
			}
			else if (Session::get_value('account')['type'] == 'restaurant')
			{
				$query1 = $this->database->select('survey_answers', [
					'table'
				], [
					'account' => Session::get_value('account')['id']
				]);

				$query2 = $this->database->select('table', [
					'id',
					'number',
					'name'
				], [
					'account' => Session::get_value('account')['id']
				]);
			}

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
					if (Session::get_value('account')['type'] == 'hotel')
					{
						if ($value['id'] == $subvalue['room'])
							$count = $count + 1;
					}
					else if (Session::get_value('account')['type'] == 'restaurant')
					{
						if ($value['id'] == $subvalue['table'])
							$count = $count + 1;
					}
				}

				if ($count > 0)
				{
					if (Session::get_value('account')['type'] == 'hotel')
					{
						if (Session::get_value('account')['language'] == 'es')
							$data['labels'] .= "'Habitación #" . $value['number'] . ' ' . $value['name'] . "',";
						else if (Session::get_value('account')['language'] == 'en')
							$data['labels'] .= "'Room #" . $value['number'] . ' ' . $value['name'] . "',";
					}
					else if (Session::get_value('account')['type'] == 'restaurant')
					{
						if (Session::get_value('account')['language'] == 'es')
							$data['labels'] .= "'Mesa #" . $value['number'] . ' ' . $value['name'] . "',";
						else if (Session::get_value('account')['language'] == 'en')
							$data['labels'] .= "'Table #" . $value['number'] . ' ' . $value['name'] . "',";
					}

					$data['datasets']['data'] .= $count . ',';
					$data['datasets']['colors'] .= "'#" . str_pad(dechex(mt_rand(0, 255)), 2, '0', STR_PAD_LEFT) . str_pad(dechex(mt_rand(0, 255)), 2, '0', STR_PAD_LEFT) . str_pad(dechex(mt_rand(0, 255)), 2, '0', STR_PAD_LEFT) . "',";
				}
			}
		}
		else if ($option == 's2_chart')
		{
			$query1 = Functions::get_json_decoded_query($this->database->select('survey_questions', [
				'id',
				'name',
				'type'
			], [
				'account' => Session::get_value('account')['id']
			]));

			$query2 = Functions::get_json_decoded_query($this->database->select('survey_answers', [
				'answers'
			], [
				'account' => Session::get_value('account')['id']
			]));

			$data = [
				'labels' => '',
				'datasets' => [
					'data' => ''
				]
			];

			foreach ($query1 as $value)
			{
				if ($value['type'] == 'rate')
				{
					$average = 0;
					$rate = 0;
					$count = 0;

					foreach ($query2 as $subvalue)
					{
						foreach ($subvalue['answers'] as $parentvalue)
						{
							if ($value['id'] == $parentvalue['id'])
							{
								$rate = $rate + $parentvalue['answer'];
								$count = $count + 1;

								foreach ($parentvalue['subanswers'] as $childvalue)
								{
									if ($childvalue['type'] == 'rate')
									{
										$rate = $rate + $childvalue['answer'];
										$count = $count + 1;
									}

									foreach ($childvalue['subanswers'] as $slavevalue)
									{
										if ($slavevalue['type'] == 'rate')
										{
											$rate = $rate + $slavevalue['answer'];
											$count = $count + 1;
										}
									}
								}
							}
						}
					}

					if ($rate > 0 AND $count > 0)
						$average = round(($rate / $count), 2);

					$data['labels'] .= "'" . $value['name'][Session::get_value('account')['language']] . "',";
					$data['datasets']['data'] .= $average . ",";
				}
			}
		}
		else if ($option == 's4_chart')
		{
			$query = Functions::get_json_decoded_query($this->database->select('survey_answers', [
				'answers',
				'date'
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
					'data' => $prom_today . ',' . $prom_lastday_1 . ',' . $prom_lastday_2 . ',' . $prom_lastday_3 . ',' . $prom_lastday_4 . ',' . $prom_lastday_5 . ',' . $prom_lastday_6
				]
			];
		}
		else if ($option == 's5_chart' OR $option == 's6_chart' OR $option == 's7_chart' OR $option == 's8_chart')
		{
			$query = Functions::get_json_decoded_query($this->database->select('survey_answers', [
				'guest'
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

			$tmp = [];

			foreach ($query as $value)
			{
				if ($option == 's5_chart')
				{
					if (!empty($value['guest']['zaviapms']['nationality']))
					{
						if (array_key_exists($value['guest']['zaviapms']['nationality'], $tmp))
							$tmp[$value['guest']['zaviapms']['nationality']] += 1;
						else
							$tmp[$value['guest']['zaviapms']['nationality']] = 1;
					}
				}
				else if ($option == 's6_chart')
				{
					if (!empty($value['guest']['zaviapms']['input_channel']))
					{
						if (array_key_exists($value['guest']['zaviapms']['input_channel'], $tmp))
							$tmp[$value['guest']['zaviapms']['input_channel']] += 1;
						else
							$tmp[$value['guest']['zaviapms']['input_channel']] = 1;
					}
				}
				else if ($option == 's7_chart')
				{
					if (!empty($value['guest']['zaviapms']['traveler_type']))
					{
						if (array_key_exists($value['guest']['zaviapms']['traveler_type'], $tmp))
							$tmp[$value['guest']['zaviapms']['traveler_type']] += 1;
						else
							$tmp[$value['guest']['zaviapms']['traveler_type']] = 1;
					}
				}
				else if ($option == 's8_chart')
				{
					if (!empty($value['guest']['zaviapms']['age_group']))
					{
						if (array_key_exists($value['guest']['zaviapms']['age_group'], $tmp))
							$tmp[$value['guest']['zaviapms']['age_group']] += 1;
						else
							$tmp[$value['guest']['zaviapms']['age_group']] = 1;
					}
				}
			}

			foreach ($tmp as $key => $value)
			{
				$data['labels'] .= "'" . $key . "',";
				$data['datasets']['data'] .= $value . ",";
				$data['datasets']['colors'] .= "'#" . str_pad(dechex(mt_rand(0, 255)), 2, '0', STR_PAD_LEFT) . str_pad(dechex(mt_rand(0, 255)), 2, '0', STR_PAD_LEFT) . str_pad(dechex(mt_rand(0, 255)), 2, '0', STR_PAD_LEFT) . "',";
			}
		}

		return $data;
	}
}
