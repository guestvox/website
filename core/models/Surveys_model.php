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
			'type',
			'values'
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
			'values' => $data['values'],
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
				'type' => $data['type'],
				'values' => $data['values']
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
			'client',
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

			if (Session::get_value('account')['type'] == 'others')
			{
				if (!empty($value['client']))
					$query[$key]['client'] = $this->get_client($value['client']);
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

	public function get_survey_answer($id)
	{
		$query = Functions::get_json_decoded_query($this->database->select('survey_answers', [
			'token',
			'room',
			'table',
			'client',
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

			if (Session::get_value('account')['type'] == 'others')
			{
				if (!empty($query[0]['client']))
					$query[0]['client'] = $this->get_client($query[0]['client']);
			}

			$query[0]['rate'] = 0;
			$count = 0;

			foreach ($query[0]['answers'] as $key => $value)
			{
				$value['question'] = $this->get_survey_question($query[0]['answers'][$key]['id']);

				if ($value['type'] == 'check')
				{
					foreach ($value['answer'] as $subkey => $subvalue)
					{
						foreach ($value['question']['values'] as $parentkey => $parentvalue)
						{
							if ($subvalue == $parentkey)
								$query[0]['answers'][$key]['answer'][$subkey] = $parentvalue;
						}
					}
				}
				else
				{
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
				}

				$query[0]['answers'][$key]['question'] = $value['question']['name'];

				if ($value['type'] == 'rate')
				{
					$query[0]['rate'] = $query[0]['rate'] + $value['answer'];
					$count = $count + 1;
				}

				foreach ($value['subanswers'] as $subvalue)
				{
					if ($subvalue['type'] == 'rate')
					{
						$query[0]['rate'] = $query[0]['rate'] + $subvalue['answer'];
						$count = $count + 1;
					}

					foreach ($subvalue['subanswers'] as $childvalue)
					{
						if ($childvalue['type'] == 'rate')
						{
							$query[0]['rate'] = $query[0]['rate'] + $childvalue['answer'];
							$count = $count + 1;
						}
					}
				}
			}

			if ($query[0]['rate'] > 0 AND $count > 0)
				$query[0]['rate'] = round(($query[0]['rate'] / $count), 1);

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

	public function get_client($id)
	{
		$query = $this->database->select('clients', [
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

	public function get_chart_data($option, $parameters = [])
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

			if (Session::get_value('account')['type'] == 'restaurant')
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

			if (Session::get_value('account')['type'] == 'others')
			{
				$query1 = $this->database->select('survey_answers', [
					'client'
				], [
					'account' => Session::get_value('account')['id']
				]);

				$query2 = $this->database->select('clients', [
					'id',
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

					if (Session::get_value('account')['type'] == 'restaurant')
					{
						if ($value['id'] == $subvalue['table'])
							$count = $count + 1;
					}

					if (Session::get_value('account')['type'] == 'others')
					{
						if ($value['id'] == $subvalue['client'])
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

					if (Session::get_value('account')['type'] == 'restaurant')
					{
						if (Session::get_value('account')['language'] == 'es')
							$data['labels'] .= "'Mesa #" . $value['number'] . ' ' . $value['name'] . "',";
						else if (Session::get_value('account')['language'] == 'en')
							$data['labels'] .= "'Table #" . $value['number'] . ' ' . $value['name'] . "',";
					}

					if (Session::get_value('account')['type'] == 'others')
					{
						if (Session::get_value('account')['language'] == 'es')
							$data['labels'] .= "'Cliente " . $value['name'] . "',";
						else if (Session::get_value('account')['language'] == 'en')
							$data['labels'] .= "'Client " . $value['name'] . "',";
					}

					$data['datasets']['data'] .= $count . ',';
					$data['datasets']['colors'] .= "'#" . str_pad(dechex(mt_rand(0, 255)), 2, '0', STR_PAD_LEFT) . str_pad(dechex(mt_rand(0, 255)), 2, '0', STR_PAD_LEFT) . str_pad(dechex(mt_rand(0, 255)), 2, '0', STR_PAD_LEFT) . "',";
				}
			}

			$empty = 0;

			foreach ($query1 as $value)
			{
				if (Session::get_value('account')['type'] == 'hotel')
				{
					if (!isset($value['room']) OR empty($value['room']))
						$empty = $empty + 1;
				}

				if (Session::get_value('account')['type'] == 'restaurant')
				{
					if (!isset($value['table']) OR empty($value['table']))
						$empty = $empty + 1;
				}

				if (Session::get_value('account')['type'] == 'others')
				{
					if (!isset($value['client']) OR empty($value['client']))
						$empty = $empty + 1;
				}
			}

			if ($empty > 0)
			{
				if (Session::get_value('account')['type'] == 'hotel')
				{
					if (Session::get_value('account')['language'] == 'es')
						$data['labels'] .= "'Sin habitación'";
					else if (Session::get_value('account')['language'] == 'en')
						$data['labels'] .= "'No room'";
				}

				if (Session::get_value('account')['type'] == 'restaurant')
				{
					if (Session::get_value('account')['language'] == 'es')
						$data['labels'] .= "'Sin mesa'";
					else if (Session::get_value('account')['language'] == 'en')
						$data['labels'] .= "'No table'";
				}

				if (Session::get_value('account')['type'] == 'others')
				{
					if (Session::get_value('account')['language'] == 'es')
						$data['labels'] .= "'Sin cliente'";
					else if (Session::get_value('account')['language'] == 'en')
						$data['labels'] .= "'No client'";
				}

				$data['datasets']['data'] .= $empty;
				$data['datasets']['colors'] .= "'#" . str_pad(dechex(mt_rand(0, 255)), 2, '0', STR_PAD_LEFT) . str_pad(dechex(mt_rand(0, 255)), 2, '0', STR_PAD_LEFT) . str_pad(dechex(mt_rand(0, 255)), 2, '0', STR_PAD_LEFT) . "',";
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

			$data = [
				'labels' => '',
				'datasets' => ''
			];

			$diff = Functions::get_diff_date($parameters[0], $parameters[1], 'days');

			for ($i = 0; $i < $diff; $i++)
			{
				$data['labels'] .= "'" . Functions::get_past_date(Functions::get_current_date(), $i, 'days') . "',";
			}

			foreach ($query1 as $value)
			{
				$data['datasets'] .= "{
					label: '" . $value['name'][Session::get_value('account')['language']] . "',
					data: [";

				for ($i = 0; $i < $diff; $i++)
				{
					$query2 = Functions::get_json_decoded_query($this->database->select('survey_answers', [
						'answers'
					], [
						'AND' => [
							'account' => Session::get_value('account')['id'],
							'date' => Functions::get_past_date(Functions::get_current_date(), $i, 'days')
						]
					]));

					$average = 0;
					$rate = 0;
					$count = 0;

					foreach ($query2 as $subvalue)
					{
						foreach ($subvalue['answers'] as $parentvalue)
						{
							if ($value['id'] == $parentvalue['id'])
							{
								if ($parentvalue['type'] == 'rate')
								{
									$rate = $rate + $parentvalue['answer'];
									$count = $count + 1;
								}

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

					$data['datasets'] .= $average . ",";
				}

				$color = str_pad(dechex(mt_rand(0, 255)), 2, '0', STR_PAD_LEFT) . str_pad(dechex(mt_rand(0, 255)), 2, '0', STR_PAD_LEFT) . str_pad(dechex(mt_rand(0, 255)), 2, '0', STR_PAD_LEFT);

				$data['datasets'] .= "],
					fill: false,
					backgroundColor: '#" . $color . "',
					borderColor: '#" . $color . "',
				},";
			}
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
