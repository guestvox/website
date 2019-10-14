<?php

defined('_EXEC') or die;

class Myvox_model extends Model
{
	public function __construct()
	{
		parent::__construct();
	}

    public function get_room($id)
	{
		$query = Functions::get_json_decoded_query($this->database->select('rooms', [
			'id',
			'account',
            'code',
			'name',
            'qr',
		], [
			'OR' => [
				'id' => $id,
				'code' => $id,
			]
		]));

		return !empty($query) ? $query[0] : null;
	}

    public function get_account($id)
	{
		$query = $this->database->select('accounts', [
			'id',
			'name',
		], [
			'id' => $id
		]);

		if (!empty($query))
		{
			$query[0]['settings'] = Functions::get_json_decoded_query($this->database->select('settings', [
				'logotype',
				'language',
				'survey_title'
			], [
				'account' => $id
			])[0]);

			return $query[0];
		}
		else
			return null;
	}

    public function get_opportunity_areas($option, $account)
	{
		$query = Functions::get_json_decoded_query($this->database->select('opportunity_areas', [
			'id',
			'name'
		], [
			'AND' => [
				'account' => $account,
				$option => true,
				'public' => true,
			],
			'ORDER' => [
				'name' => 'ASC'
			]
		]));

		return $query;
	}

    public function get_opportunity_area($id)
	{
		$query = Functions::get_json_decoded_query($this->database->select('opportunity_areas', [
			'id',
			'name'
		], [
			'id' => $id
		]));

		return !empty($query) ? $query[0] : null;
	}

    public function get_opportunity_types($opportunity_area, $option)
	{
		$query = Functions::get_json_decoded_query($this->database->select('opportunity_types', [
			'id',
			'name'
		], [
			'AND' => [
				'opportunity_area' => $opportunity_area,
				$option => true,
				'public' => true,
			],
			'ORDER' => [
				'name' => 'ASC'
			]
		]));

		return $query;
	}

    public function get_opportunity_type($id)
	{
		$query = Functions::get_json_decoded_query($this->database->select('opportunity_types', [
			'id',
			'name'
		], [
			'id' => $id,
		]));

		return !empty($query) ? $query[0] : null;
	}

    public function get_locations($option, $account)
	{
		$query = Functions::get_json_decoded_query($this->database->select('locations', [
			'id',
			'name'
		], [
			'AND' => [
				'account' => $account,
				$option => true,
				'public' => true,
			],
			'ORDER' => [
				'name' => 'ASC'
			]
		]));

		return $query;
	}

    public function get_location($id)
	{
		$query = Functions::get_json_decoded_query($this->database->select('locations', [
			'id',
			'name'
		], [
			'id' => $id
		]));

		return !empty($query) ? $query[0] : null;
	}

    public function get_users($option, $params, $account)
	{
        $query = Functions::get_json_decoded_query($this->database->select('users', [
            'name',
            'lastname',
            'email',
            'opportunity_areas',
        ], [
            'account' => $account
        ]));

        foreach ($query as $key => $value)
        {
            if (!in_array($params, $value['opportunity_areas']))
                unset($query[$key]);
        }

		return $query;
	}

    public function get_survey_questions($account)
    {
		$questions = [];

        $query = Functions::get_json_decoded_query($this->database->select('survey_questions', [
            'id',
            'question',
			'subquestions',
        ], [
            'account' => $account
        ]));

		foreach ($query as $key => $value)
		{
			array_push($questions, ['q1' => $value]);
		}

     	return $questions;
    }

    public function new_request($data, $room, $account)
	{
		$query = $this->database->insert('voxes', [
			'account' => $account,
			'type' => 'request',
			'data' => Functions::get_openssl('encrypt', json_encode([
				'token' => $this->security->random_string(8),
				'room' => $room,
				'opportunity_area' => $data['opportunity_area'],
				'opportunity_type' => $data['opportunity_type'],
				'started_date' => Functions::get_formatted_date($data['started_date']),
				'started_hour' => Functions::get_formatted_hour($data['started_hour']),
				'location' => $data['location'],
				'cost' => null,
				'urgency' => 'medium',
				'confidentiality' => null,
				'assigned_users' => [],
				'observations' => $data['observations'],
				'subject' => null,
				'description' => null,
				'action_taken' => null,
				'guest_treatment' => null,
				'name' => null,
				'lastname' => $data['lastname'],
				'guest_id' => null,
				'guest_type' => null,
				'reservation_number' => null,
				'reservation_status' => null,
				'check_in' => null,
				'check_out' => null,
				'attachments' => [],
				'viewed_by' => [],
				'comments' => [],
				'changes_history' => [
					[
						'type' => 'create',
						'user' => null,
						'date' => Functions::get_current_date(),
						'hour' => Functions::get_current_hour(),
					]
				],
				'created_user' => null,
				'edited_user' => null,
				'completed_user' => null,
				'reopened_user' => null,
				'created_date' => Functions::get_current_date(),
				'created_hour' => Functions::get_current_hour(),
				'edited_date' => null,
				'edited_hour' => null,
				'completed_date' => null,
				'completed_hour' => null,
				'reopened_date' => null,
				'reopened_hour' => null,
				'readed' => false,
				'status' => 'open',
				'origin' => 'external',
			])),
		]);

		return !empty($query) ? $this->database->id($query) : null;
	}

    public function new_incident($data, $room, $account)
	{
		$query = $this->database->insert('voxes', [
			'account' => $account,
			'type' => 'incident',
			'data' => Functions::get_openssl('encrypt', json_encode([
				'token' => $this->security->random_string(8),
				'room' => $room,
				'opportunity_area' => $data['opportunity_area'],
				'opportunity_type' => $data['opportunity_type'],
				'started_date' => Functions::get_formatted_date($data['started_date']),
				'started_hour' => Functions::get_formatted_hour($data['started_hour']),
				'location' => $data['location'],
				'cost' => null,
				'urgency' => 'medium',
				'confidentiality' => null,
				'assigned_users' => [],
				'observations' => null,
				'subject' => null,
				'description' => $data['description'],
				'action_taken' => null,
				'guest_treatment' => null,
				'name' => null,
				'lastname' => $data['lastname'],
				'guest_id' => null,
				'guest_type' => null,
				'reservation_number' => null,
				'reservation_status' => null,
				'check_in' => null,
				'check_out' => null,
				'attachments' => [],
				'viewed_by' => [],
				'comments' => [],
				'changes_history' => [
					[
						'type' => 'create',
						'user' => null,
						'date' => Functions::get_current_date(),
						'hour' => Functions::get_current_hour(),
					]
				],
				'created_user' => null,
				'edited_user' => null,
				'completed_user' => null,
				'reopened_user' => null,
				'created_date' => Functions::get_current_date(),
				'created_hour' => Functions::get_current_hour(),
				'edited_date' => null,
				'edited_hour' => null,
				'completed_date' => null,
				'completed_hour' => null,
				'reopened_date' => null,
				'reopened_hour' => null,
				'readed' => false,
				'status' => 'open',
				'origin' => 'external',
			])),
		]);

		return !empty($query) ? $this->database->id($query) : null;
	}

    public function new_survey_answers($data, $room, $account)
    {
        foreach ($data['answers'] as $value)
        {
			$ans = [];

			if ($value[0] == 'p')
			{
				print_r($value);

				array_push($ans, [
					'id' => $value[1],
					'rate' => $value[2],
				]);


				// $q1 = $this->database->insert('survey_answers', [
				// 	'account' => $account,
				// 	'room' => $room,
				// 	'answers' =>  json_encode($ans),
				// 	'comment' =>  $data['comment'],
				// 	'firstname' =>  $data['firstname'],
				// 	'lastname' =>  $data['lastname'],
				// 	'email' => $data['email'],
				// 	'date' => Functions::get_current_date(),
				// 	'token' => $data['token'],
				// ]);
			}
			else if ($value[0] == 's' AND !empty($value[2]))
			{
				// $select = Functions::get_json_decoded_query($this->database->select('survey_answers', [
				// 	'id',
				// 	'answers',
				// ], [
				// 	'token' => $data['token']
				// ]));


				// $q2 = $this->database->insert('survey_answers', [
				// 	'account' => $account,
				// 	'room' => $room,
				// 	'survey_subquestion' => $value[1],
				// 	'subanswer_open' =>  $value[2],
				// ]);
			}
			// else if ($value[0] == 'sr' AND !empty($value[2]))
			// {
			// 	$q2 = $this->database->insert('survey_answers', [
			// 		'account' => $account,
			// 		'room' => $room,
			// 		'survey_subquestion' => $value[1],
			// 		'subanswer_rate' =>  $value[2],
			// 	]);
			// }
        }

		if (!empty($data['comment']))
		{
			$q3 = $this->database->insert('survey_comments', [
				'account' => $account,
				'room' => $room,
				'comment' => $data['comment'],
				'firstname' => $data['firstname'],
				'lastname' => $data['lastname'],
				'email' => $data['email'],
				'date' => Functions::get_current_date(),
				'token' => $data['token'],
			]);
		}

		return true;
    }
}
