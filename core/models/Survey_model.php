<?php

defined('_EXEC') or die;

class Survey_model extends Model
{
	public function __construct()
	{
		parent::__construct();
	}

	public function get_survey_answers($id = null)
	{
		if (empty($id))
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
				'survey_answers.firstname',
				'survey_answers.lastname',
				'survey_answers.email',
				'survey_answers.date',
				'survey_answers.token',
			], [
				'survey_answers.account' => Session::get_value('account')['id']
			]));

			return $query;
		}
		else
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
				'survey_answers.firstname',
				'survey_answers.lastname',
				'survey_answers.email',
				'survey_answers.date',
				'survey_answers.token',
			], [
				'survey_answers.id' => $id
			]));

			return !empty($query) ? $query[0] : null;
		}
	}

	public function get_survey_questions()
	{
		$query = Functions::get_json_decoded_query($this->database->select('survey_questions', [
			'id',
			'question',
			'subquestions',
			'status',
		], [
			'account' => Session::get_value('account')['id']
		]));

		return $query;
	}

	public function get_survey_question($id)
	{
		$query = Functions::get_json_decoded_query($this->database->select('survey_questions', [
			'question',
			'subquestions',
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
			'subquestions' => json_encode([]),
			'status' => true,
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

	public function edit_survey_subquestion($id, $subquestions)
	{
		$query = $this->database->update('survey_questions', [
			'subquestions' => json_encode($subquestions),
		], [
			'id' => $id
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

		return !empty($query) ? $query[0]['survey_title'] : null;
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

	// public function get_total_rate_avarage()
	// {
	// 	$rate = 0;
	//
	// 	$query = $this->database->select('survey_answers', [
	// 		'rate',
	// 	], [
	// 		'account' => Session::get_value('account')['id']
	// 	]);
	//
	// 	if (!empty($query))
	// 	{
	// 		foreach ($query as $value)
	// 			$rate = $rate + $value['rate'];
	//
	// 		$rate = $rate / count($query);
	// 	}
	//
	// 	return $rate;
	// }
	//
	// public function get_chart_data($option)
	// {
	// 	$data = null;
	//
	// 	if ($option == 's_r1_chart')
	// 	{
	// 		$query1 = $this->database->select('survey_answers', [
	// 			'room',
	// 		], [
	// 			'account' => Session::get_value('account')['id']
	// 		]);
	//
	// 		$query2 = $this->database->select('rooms', [
	// 			'id',
	// 			'name'
	// 		], [
	// 			'account' => Session::get_value('account')['id'],
	// 		]);
	//
	// 		$data = [
	// 			'labels' => '',
	// 			'datasets' => [
	// 				'data' => '',
	// 				'colors' => ''
	// 			]
	// 		];
	//
	// 		foreach ($query2 as $value)
	// 		{
	// 			$count = 0;
	//
	// 			foreach ($query1 as $subvalue)
	// 			{
	// 				if ($value['id'] == $subvalue['room'])
	// 					$count = $count + 1;
	// 			}
	//
	// 			$data['labels'] .= "'" . $value['name'] . "',";
	// 			$data['datasets']['data'] .= $count . ',';
	// 			$data['datasets']['colors'] .= "'#" . str_pad( dechex( mt_rand( 0, 255 ) ), 2, '0', STR_PAD_LEFT) . str_pad( dechex( mt_rand( 0, 255 ) ), 2, '0', STR_PAD_LEFT) . str_pad( dechex( mt_rand( 0, 255 ) ), 2, '0', STR_PAD_LEFT) . "',";
	// 		}
	// 	}
	// 	else if ($option == 's_r2_chart')
	// 	{
	// 		$query1 = $this->database->select('survey_answers', [
	// 			'survey_question',
	// 			'rate'
	// 		], [
	// 			'account' => Session::get_value('account')['id']
	// 		]);
	//
	// 		$query2 = Functions::get_json_decoded_query($this->database->select('survey_questions', [
	// 			'id',
	// 			'question'
	// 		], [
	// 			'account' => Session::get_value('account')['id'],
	// 		]));
	//
	// 		$data = [
	// 			'labels' => '',
	// 			'datasets' => [
	// 				'data' => '',
	// 				'colors' => ''
	// 			]
	// 		];
	//
	// 		foreach ($query2 as $value)
	// 		{
	// 			$count = 0;
	//
	// 			foreach ($query1 as $subvalue)
	// 			{
	// 				if ($value['id'] == $subvalue['survey_question'])
	// 					$count = $count + $subvalue['rate'];
	// 			}
	//
	// 			$data['labels'] .= "'" . $value['question'][Session::get_value('settings')['language']] . "',";
	// 			$data['datasets']['data'] .= $count . ',';
	// 			$data['datasets']['colors'] .= "'#" . str_pad( dechex( mt_rand( 0, 255 ) ), 2, '0', STR_PAD_LEFT) . str_pad( dechex( mt_rand( 0, 255 ) ), 2, '0', STR_PAD_LEFT) . str_pad( dechex( mt_rand( 0, 255 ) ), 2, '0', STR_PAD_LEFT) . "',";
	// 		}
	// 	}
	//
	// 	return $data;
	// }
}
