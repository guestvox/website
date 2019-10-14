<?php

defined('_EXEC') or die;

class Survey_model extends Model
{
	public function __construct()
	{
		parent::__construct();
	}

	public function get_survey_answers()
	{
		$query = Functions::get_json_decoded_query($this->database->select('survey_answers', [
			'[>]rooms' => [
				'room' => 'id'
			],
			'[>]survey_questions' => [
				'survey_question' => 'id'
			],
		], [
			'survey_answers.id',
			'rooms.name(room)',
			'survey_questions.question(survey_question)',
			'survey_answers.rate',
			'survey_answers.date',
			'survey_answers.token',
		], [
			'survey_answers.account' => Session::get_value('account')['id']
		]));

		return $query;
	}

	public function get_survey_subanswers()
	{
		$query = Functions::get_json_decoded_query($this->database->select('survey_subanswers', [
			'[>]rooms' => [
				'room' => 'id'
			],
			'[>]survey_subquestions' => [
				'survey_subquestion' => 'id'
			],
		], [
			'survey_subanswers.id',
			'rooms.name(room)',
			'survey_subquestions.subquestion(survey_subquestion)',
			'survey_subanswers.subanswer',
		], [
			'survey_subanswers.account' => Session::get_value('account')['id']
		]));

		return $query;
	}

	public function get_survey_comments()
	{
		$query = Functions::get_json_decoded_query($this->database->select('survey_comments', [
			'[>]rooms' => [
				'room' => 'id'
			]
		], [
			'survey_comments.id',
			'rooms.name(room)',
			'survey_comments.comment',
			'survey_comments.date',
			'survey_comments.token',
		], [
			'survey_comments.account' => Session::get_value('account')['id']
		]));

		return $query;
	}

	public function get_survey_questions()
	{
		$questions = [];

		$query = Functions::get_json_decoded_query($this->database->select('survey_questions', [
			'id',
			'question',
			'subquestions',
			'status',
		], [
			'account' => Session::get_value('account')['id']
		]));

		foreach ($query as $value)
		{
			$a1 = $this->database->select('survey_answers', [
				'rate'
			], [
				'survey_question' => $value['id']
			]);

			$value['fk'] = (!empty($a1)) ? true : false;

			array_push($questions, [
				'q1' => $value,
			]);
		}

		return $questions;
	}

	public function get_survey_question($id)
	{
		$query = Functions::get_json_decoded_query($this->database->select('survey_questions', [
			'id',
			'question',
		], [
			'id' => $id
		]));

		return !empty($query) ? $query[0] : null;
	}

    public function new_survey_question($data)
	{
		$query = $this->database->insert('survey_questions', [
			'account' => Session::get_value('account')['id'],
			'question' => json_encode([
				'es' => $data['survey_question_es'],
				'en' => $data['survey_question_en'],
			]),
			'status' => true
		]);

		return $query;
	}

    public function edit_survey_question($data)
	{
		$query = $this->database->update('survey_questions', [
			'question' => json_encode([
				'es' => $data['survey_question_es'],
				'en' => $data['survey_question_en'],
			]),
		], [
			'id' => $data['id'],
		]);

		return $query;
	}

	public function get_survey_title()
	{
		$query = Functions::get_json_decoded_query($this->database->select('settings', [
			'survey_title'
		], [
			'account' => Session::get_value('account')['id']
		]));

		return !empty($query) ? $query[0] : null;
	}

	public function edit_survey_title($data)
	{
		$query = $this->database->update('settings', [
			'survey_title' => json_encode([
				'es' => $data['survey_title_es'],
				'en' => $data['survey_title_en'],
			]),
		], [
			'account' => Session::get_value('account')['id']
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

	public function new_survey_subquestion($data)
	{
		$select = Functions::get_json_decoded_query($this->database->select('survey_questions', [
			'id',
			'question',
			'subquestions',
		], [
			'id' => $data['id']
		]));

		$select[0]['subquestions'] = !empty($select[0]['subquestions']) ? $select[0]['subquestions'] : [];

		array_push($select[0]['subquestions'], [
			'token' => $data['token'],
			'es' => $data['survey_subquestion_es'],
			'en' => $data['survey_subquestion_en'],
			'type' => $data['type'],
			'status' => true,
		]);

		$query = $this->database->update('survey_questions', [
			'account' => Session::get_value('account')['id'],
			'subquestions' => json_encode($select[0]['subquestions']),
		], [
			'id' => $data['id']
		]);

		return $query;
	}

	public function edit_survey_subquestion($data)
	{
		$select = Functions::get_json_decoded_query($this->database->select('survey_questions', [
			'id',
			'question',
			'subquestions',
		], [
			'id' => $data[0][0]
		]));

		foreach ($select[0]['subquestions'] as $key => $value)
		{
			if ($data[0][1] == $key)
			{
				$select[0]['subquestions'][$key]['es'] = $data[1]['survey_subquestion_es'];
				$select[0]['subquestions'][$key]['en'] = $data[1]['survey_subquestion_en'];
				$select[0]['subquestions'][$key]['type'] = $data[1]['type'];

			}
		}

		$query = $this->database->update('survey_questions', [
			'account' => Session::get_value('account')['id'],
			'subquestions' => json_encode($select[0]['subquestions']),
		], [
			'id' => $data[0][0]
		]);

		return $query;
	}

	public function delete_survey_subquestion($data)
	{
		$select = Functions::get_json_decoded_query($this->database->select('survey_questions', [
			'id',
			'question',
			'subquestions',
		], [
			'id' => $data[0][0]
		]));

		foreach ($select[0]['subquestions'] as $key => $value)
		{
			if ($data[0][1] == $key)
			{
				unset($select[0]['subquestions'][$key]);
			}
		}

		$query = $this->database->update('survey_questions', [
			'account' => Session::get_value('account')['id'],
			'subquestions' => json_encode($select[0]['subquestions']),
		], [
			'id' => $data[0][0]
		]);

		return $query;
	}

	public function get_survey_subquestion($data)
	{
		$select = Functions::get_json_decoded_query($this->database->select('survey_questions', [
			'id',
			'question',
			'subquestions',
		], [
			'id' => $data[0][0]
		]));

		$subquestion = [];

		foreach ($select[0]['subquestions'] as $key => $value)
		{
			if ($data[0][1] == $key)
			{
				array_push($subquestion, $value);
			}
		}

		return !empty($subquestion) ? $subquestion[0] : null;
	}

	public function get_total_rate_avarage()
	{
		$rate = 0;

		$query = $this->database->select('survey_answers', [
			'rate',
		], [
			'account' => Session::get_value('account')['id']
		]);

		if (!empty($query))
		{
			foreach ($query as $value)
				$rate = $rate + $value['rate'];

			$rate = $rate / count($query);
		}

		return $rate;
	}

	public function get_chart_data($option)
	{
		$data = null;

		if ($option == 's_r1_chart')
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

				$data['labels'] .= "'" . $value['name'] . "',";
				$data['datasets']['data'] .= $count . ',';
				$data['datasets']['colors'] .= "'#" . str_pad( dechex( mt_rand( 0, 255 ) ), 2, '0', STR_PAD_LEFT) . str_pad( dechex( mt_rand( 0, 255 ) ), 2, '0', STR_PAD_LEFT) . str_pad( dechex( mt_rand( 0, 255 ) ), 2, '0', STR_PAD_LEFT) . "',";
			}
		}
		else if ($option == 's_r2_chart')
		{
			$query1 = $this->database->select('survey_answers', [
				'survey_question',
				'rate'
			], [
				'account' => Session::get_value('account')['id']
			]);

			$query2 = Functions::get_json_decoded_query($this->database->select('survey_questions', [
				'id',
				'question'
			], [
				'account' => Session::get_value('account')['id'],
			]));

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
					if ($value['id'] == $subvalue['survey_question'])
						$count = $count + $subvalue['rate'];
				}

				$data['labels'] .= "'" . $value['question'][Session::get_value('settings')['language']] . "',";
				$data['datasets']['data'] .= $count . ',';
				$data['datasets']['colors'] .= "'#" . str_pad( dechex( mt_rand( 0, 255 ) ), 2, '0', STR_PAD_LEFT) . str_pad( dechex( mt_rand( 0, 255 ) ), 2, '0', STR_PAD_LEFT) . str_pad( dechex( mt_rand( 0, 255 ) ), 2, '0', STR_PAD_LEFT) . "',";
			}
		}

		return $data;
	}
}
