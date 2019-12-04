<?php

defined('_EXEC') or die;

class Myvox_model extends Model
{
	public function __construct()
	{
		parent::__construct();
	}

    public function get_room($token)
	{
		$query = $this->database->select('rooms', [
			'id',
			'account',
			'name',
			'folio'
		], [
			'token' => strtoupper($token)
		]);

		return !empty($query) ? $query[0] : null;
	}

    public function get_account($id)
	{
		$query = Functions::get_json_decoded_query($this->database->select('accounts', [
			'id',
			'language',
			'logotype',
			'operation',
			'reputation',
			'myvox_request',
			'myvox_incident',
			'myvox_survey',
			'myvox_survey_title',
			'sms',
			'zaviapms',
		], [
			'AND' => [
				'id' => $id,
				'status' => true
			]
		]));

		return !empty($query) ? $query[0] : null;
	}

	public function get_guest($zaviapms, $room)
	{
		$guest = [
			'status' => 'success',
			'firstname' => '',
			'lastname' => '',
			'reservation_number' => '',
			'check_in' => '',
			'check_out' => '',
		];

		if ($zaviapms['status'] == true)
		{
			$query = Functions::api('zaviapms', $zaviapms, 'get', 'room', $room);

			$guest['status'] = $query['Status'];

			if ($guest['status'] == 'success')
			{
				$guest['firstname'] = $query['Name'];
				$guest['lastname'] = $query['LastName'];
				$guest['reservation_number'] = $query['FolioRefID'];
				$guest['check_in'] = $query['StartDate'];
				$guest['check_out'] = $query['EndDate'];
			}
		}

		return $guest;
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

    public function get_assigned_users($opportunity_area, $account)
	{
        $query = Functions::get_json_decoded_query($this->database->select('users', [
            'firstname',
            'lastname',
            'email',
            'phone',
            'opportunity_areas',
        ], [
            'AND' => [
				'account' => $account,
				'status' => true
			]
        ]));

        foreach ($query as $key => $value)
        {
            if (!in_array($opportunity_area, $value['opportunity_areas']))
                unset($query[$key]);
        }

		return $query;
	}

	public function get_countries()
	{
		$query = Functions::get_json_decoded_query($this->database->select('countries', [
			'name',
			'lada'
		], [
			'ORDER' => [
				'priority' => 'ASC',
				'name' => 'ASC'
			]
		]));

		return $query;
	}

    public function get_survey_questions($account)
    {
        $query = Functions::get_json_decoded_query($this->database->select('survey_questions', [
            'id',
            'name',
			'subquestions',
			'type',
        ], [
            'AND' => [
				'account' => $account,
				'status' => true
			]
        ]));

     	return $query;
    }

    public function new_request($data)
	{
		$query = $this->database->insert('voxes', [
			'account' => $data['account'],
			'type' => 'request',
			'data' => Functions::get_openssl('encrypt', json_encode([
				'token' => $this->security->random_string(8),
				'room' => $data['room'],
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
				'firstname' => $data['firstname'],
				'lastname' => $data['lastname'],
				'guest_id' => null,
				'guest_type' => null,
				'reservation_number' => $data['reservation_number'],
				'reservation_status' => null,
				'check_in' => $data['check_in'],
				'check_out' => $data['check_out'],
				'attachments' => [],
				'viewed_by' => [],
				'comments' => [],
				'changes_history' => [
					[
						'type' => 'create',
						'user' => [
							'myvox',
							'guestvox'
						],
						'date' => Functions::get_current_date(),
						'hour' => Functions::get_current_hour(),
					]
				],
				'created_user' => [
					'myvox',
					'guestvox'
				],
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

		return !empty($query) ? $this->database->id() : null;
	}

    public function new_incident($data)
	{
		$query = $this->database->insert('voxes', [
			'account' => $data['account'],
			'type' => 'incident',
			'data' => Functions::get_openssl('encrypt', json_encode([
				'token' => $this->security->random_string(8),
				'room' => $data['room'],
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
				'subject' => $data['subject'],
				'description' => null,
				'action_taken' => null,
				'guest_treatment' => null,
				'firstname' => $data['firstname'],
				'lastname' => $data['lastname'],
				'guest_id' => null,
				'guest_type' => null,
				'reservation_number' => $data['reservation_number'],
				'reservation_status' => null,
				'check_in' => $data['check_in'],
				'check_out' => $data['check_out'],
				'attachments' => [],
				'viewed_by' => [],
				'comments' => [],
				'changes_history' => [
					[
						'type' => 'create',
						'user' => [
							'myvox',
							'guestvox'
						],
						'date' => Functions::get_current_date(),
						'hour' => Functions::get_current_hour(),
					]
				],
				'created_user' => [
					'myvox',
					'guestvox'
				],
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

		return !empty($query) ? $this->database->id() : null;
	}

    public function new_survey_answer($data)
    {
		$query = $this->database->insert('survey_answers', [
			'account' => $data['account'],
			'room' => $data['room'],
			'answers' => json_encode($data['answers']),
			'comment' => $data['comment'],
			'guest' => json_encode([
				'reservation_number' => $data['reservation_number'],
				'firstname' => $data['firstname'],
				'lastname' => $data['lastname'],
				'email' => $data['email'],
				'phone' => json_encode([
					'lada' => $data['phone_lada'],
					'number' => $data['phone_number'],
				])
			]),
			'date' => Functions::get_current_date(),
			'token' => $data['token'],
		]);

		return $query;
    }

	public function edit_sms($sms, $account)
	{
		$query = $this->database->update('account', [
			'sms' => $sms
		], [
			'account' => $account
		]);

		return $query;
	}
}
