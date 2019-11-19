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
						if ($childvalue['type'] == 'twin' AND $childvalue['answer'] == 'yes')
							$yes = $yes + 1;
						else if ($childvalue['type'] == 'twin' AND $childvalue['answer'] == 'no')
							$no = $no + 1;
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
