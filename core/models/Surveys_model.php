<?php

defined('_EXEC') or die;

class Surveys_model extends Model
{
	public function __construct()
	{
		parent::__construct();
	}

	public function get_surveys_questions($option = 'all', $parent = false)
	{
		$query1 = [];

		if ($option == 'all' AND $parent == false)
		{
			$query1 = Functions::get_json_decoded_query($this->database->select('surveys_questions', [
				'id',
				'name',
				'type',
				'values',
				'parent',
				'system',
				'status'
			], [
				'system' => true
			]));
		}

		$and = [
			'account' => Session::get_value('account')['id']
		];

		if ($option == 'actives')
		{
			$and['type'] = ['rate','twin'];
			$and['status'] = true;
		}

		if ($parent == false)
			$and['parent[=]'] = null;
		else
			$and['parent'] = $parent;

		$query2 = Functions::get_json_decoded_query($this->database->select('surveys_questions', [
			'id',
			'name',
			'type',
			'values',
			'parent',
			'system',
			'status'
		], [
			'AND' => $and,
			'ORDER' => [
				'id' => 'ASC'
			]
		]));

		return array_merge($query1, $query2);
	}

	public function get_survey_question($id)
	{
		$query = Functions::get_json_decoded_query($this->database->select('surveys_questions', [
			'id',
			'name',
			'type',
			'values',
			'parent'
		], [
			'id' => $id
		]));

		return !empty($query) ? $query[0] : null;
	}

	public function new_survey_question($data)
	{
		$query = $this->database->insert('surveys_questions', [
			'account' => Session::get_value('account')['id'],
			'name' => json_encode([
				'es' => $data['name_es'],
				'en' => $data['name_en']
			]),
			'type' => $data['type'],
			'values' => ($data['type'] == 'check') ? json_encode($data['values']) : null,
			'parent' => !empty($data['parent']) ? $data['parent'] : null,
			'system' => false,
			'status' => true
		]);

		return $query;
	}

	public function edit_survey_question($data)
	{
		$query = $this->database->update('surveys_questions', [
			'name' => json_encode([
				'es' => $data['name_es'],
				'en' => $data['name_en']
			]),
			'type' => $data['type'],
			'values' => ($data['type'] == 'check') ? json_encode($data['values']) : null,
			'parent' => !empty($data['parent']) ? $data['parent'] : null
		], [
			'id' => $data['id']
		]);

		return $query;
	}

	public function deactivate_survey_question($id)
	{
		$ids = [];

		array_push($ids, $id);

		$childs1 = $this->database->select('surveys_questions', [
			'id'
		], [
			'parent' => $id
		]);

		foreach ($childs1 as $value)
		{
			array_push($ids, $value['id']);

			$childs2 = $this->database->select('surveys_questions', [
				'id'
			], [
				'parent' => $value['id']
			]);

			foreach ($childs2 as $subvalue)
				array_push($ids, $subvalue['id']);
		}

		$query = $this->database->update('surveys_questions', [
			'status' => false
		], [
			'id' => $ids
		]);

		return $query;
	}

	public function activate_survey_question($id)
	{
		$ids = [];

		array_push($ids, $id);

		$childs1 = $this->database->select('surveys_questions', [
			'id'
		], [
			'parent' => $id
		]);

		foreach ($childs1 as $value)
		{
			array_push($ids, $value['id']);

			$childs2 = $this->database->select('surveys_questions', [
				'id'
			], [
				'parent' => $value['id']
			]);

			foreach ($childs2 as $subvalue)
				array_push($ids, $subvalue['id']);
		}

		$query = $this->database->update('surveys_questions', [
			'status' => true
		], [
			'id' => $ids
		]);

		return $query;
	}

	public function delete_survey_question($id)
	{
		$ids = [];

		array_push($ids, $id);

		$childs1 = $this->database->select('surveys_questions', [
			'id'
		], [
			'parent' => $id
		]);

		foreach ($childs1 as $value)
		{
			array_push($ids, $value['id']);

			$childs2 = $this->database->select('surveys_questions', [
				'id'
			], [
				'parent' => $value['id']
			]);

			foreach ($childs2 as $subvalue)
				array_push($ids, $subvalue['id']);
		}

		$query = $this->database->delete('surveys_questions', [
			'id' => $ids
		]);

		return $query;
	}

	public function get_surveys_answers()
	{
		$and = [
			'surveys_answers.account' => Session::get_value('account')['id'],
			'surveys_answers.date[<>]' => [Session::get_value('settings')['surveys']['answers']['filter']['started_date'],Session::get_value('settings')['surveys']['answers']['filter']['end_date']]
		];

		if (Session::get_value('settings')['surveys']['answers']['filter']['owner'] != 'all')
			$and['owners.id'] = Session::get_value('settings')['surveys']['answers']['filter']['owner'];

		$query = Functions::get_json_decoded_query($this->database->select('surveys_answers', [
			'[>]owners' => [
				'owner' => 'id'
			]
		], [
			'surveys_answers.id',
			'surveys_answers.token',
			'owners.name(owner_name)',
			'owners.number(owner_number)',
			'surveys_answers.values',
			'surveys_answers.firstname',
			'surveys_answers.lastname',
			'surveys_answers.reservation',
			'surveys_answers.date',
			'surveys_answers.hour'
		], [
			'AND' => $and,
			'ORDER' => [
				'surveys_answers.date' => 'DESC',
				'surveys_answers.hour' => 'ASC'
			]
		]));

		foreach ($query as $key => $value)
		{
			$average = 0;
			$count = 0;

			foreach ($value['values'] as $subkey => $subvalue)
			{
				$subvalue = $this->database->select('surveys_questions', [
					'type'
				], [
					'id' => $subkey
				]);

				$subvalue = [
					'question' => $subvalue[0]['type'],
					'answer' => $value['values'][$subkey]
				];

				if ($subvalue['question'] == 'rate')
				{
					$average = $average + $subvalue['answer'];
					$count = $count + 1;
				}
			}

			if ($average > 0 AND $count > 0)
				$average = round(($average / $count), 1);

			$query[$key]['average'] = $average;

			if (Session::get_value('settings')['surveys']['answers']['filter']['rating'] == '1' AND $average >= 2)
				unset($query[$key]);
			else if (Session::get_value('settings')['surveys']['answers']['filter']['rating'] == '2' AND ($average < 2 OR $average >= 3))
				unset($query[$key]);
			else if (Session::get_value('settings')['surveys']['answers']['filter']['rating'] == '3' AND ($average < 3 OR $average >= 4))
				unset($query[$key]);
			else if (Session::get_value('settings')['surveys']['answers']['filter']['rating'] == '4' AND ($average < 4 OR $average >= 5))
				unset($query[$key]);
			else if (Session::get_value('settings')['surveys']['answers']['filter']['rating'] == '5' AND $average < 5)
				unset($query[$key]);
		}

		return $query;
	}

	public function get_survey_answer($id)
	{
		$query = Functions::get_json_decoded_query($this->database->select('surveys_answers', [
			'[>]owners' => [
				'owner' => 'id'
			]
		], [
			'surveys_answers.token',
			'owners.name(owner_name)',
			'owners.number(owner_number)',
			'surveys_answers.values',
			'surveys_answers.comment',
			'surveys_answers.firstname',
			'surveys_answers.lastname',
			'surveys_answers.email',
			'surveys_answers.phone',
			'surveys_answers.reservation',
			'surveys_answers.date',
			'surveys_answers.hour'
		], [
			'surveys_answers.id' => $id
		]));

		if (!empty($query))
		{
			$average = 0;
			$count = 0;

			foreach ($query[0]['values'] as $key => $value)
			{
				$value = $this->database->select('surveys_questions', [
					'type'
				], [
					'id' => $key
				]);

				$value = [
					'question' => $value[0]['type'],
					'answer' => $query[0]['values'][$key]
				];

				if ($value['question'] == 'rate')
				{
					$average = $average + $value['answer'];
					$count = $count + 1;
				}
			}

			if ($average > 0 AND $count > 0)
				$average = round(($average / $count), 1);

			$query[0]['average'] = $average;

			return $query[0];
		}
		else
			return null;
	}

	public function get_owners($type = 'all')
	{
		$and['account'] = Session::get_value('account')['id'];

		if ($type != 'all')
			$and[$type] = true;

		$and['status'] = true;

		$query = Functions::get_json_decoded_query($this->database->select('owners', [
			'id',
			'name',
			'number'
		], [
			'AND' => $and,
			'ORDER' => [
				'number' => 'ASC',
				'name' => 'ASC'
			]
		]));

		return $query;
	}
}
