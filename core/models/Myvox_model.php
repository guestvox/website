<?php

defined('_EXEC') or die;

class Myvox_model extends Model
{
	public function __construct()
	{
		parent::__construct();
	}

	public function get_account($path)
	{
		$query = Functions::get_json_decoded_query($this->database->select('accounts', [
			'id',
			'type',
			'city',
			'language',
			'logotype',
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

	public function get_rooms($account)
	{
		$query = $this->database->select('rooms', [
			'id',
			'number',
			'name'
		], [
			'account' => $account,
			'ORDER' => [
				'number' => 'ASC'
			]
		]);

		return $query;
	}

    public function get_room($token)
	{
		if (!empty($token))
		{
			$query = $this->database->select('rooms', [
				'id',
				'account',
				'number',
				'name'
			], [
				'OR' => [
					'id' => $token,
					'token' => strtoupper($token)
				]
			]);
		}
		else
		{
			$query[0] = [
				'id' => '',
				'account' => '',
				'number' => '',
				'name' => ''
			];
		}

		return !empty($query) ? $query[0] : null;
	}

	public function get_tables($account)
	{
		$query = $this->database->select('tables', [
			'id',
			'number',
			'name'
		], [
			'account' => $account,
			'ORDER' => [
				'number' => 'ASC'
			]
		]);

		return $query;
	}

    public function get_table($token)
	{
		if (!empty($token))
		{
			$query = $this->database->select('tables', [
				'id',
				'account',
				'number',
				'name'
			], [
				'OR' => [
					'id' => $token,
					'token' => strtoupper($token)
				]
			]);
		}
		else
		{
			$query[0] = [
				'id' => '',
				'account' => '',
				'number' => '',
				'name' => ''
			];
		}

		return !empty($query) ? $query[0] : null;
	}

	public function get_clients($account)
	{
		$query = $this->database->select('clients', [
			'id',
			'name'
		], [
			'account' => $account,
			'ORDER' => [
				'name' => 'ASC'
			]
		]);

		return $query;
	}

    public function get_client($token)
	{
		if (!empty($token))
		{
			$query = $this->database->select('clients', [
				'id',
				'account',
				'name'
			], [
				'OR' => [
					'id' => $token,
					'token' => strtoupper($token)
				]
			]);
		}
		else
		{
			$query[0] = [
				'id' => '',
				'account' => '',
				'name' => ''
			];
		}

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
			'nationality' => '',
			'input_channel' => '',
			'traveler_type' => '',
			'age_group' => ''
		];

		if ($zaviapms['status'] == true AND !empty($room))
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
				$guest['nationality'] = $query['Country'];
				$guest['input_channel'] = $query['Channel'];
				$guest['traveler_type'] = $query['TravelerType'];
				$guest['age_group'] = $query['AgeGroup'];
			}
		}

		return $guest;
	}

    public function get_opportunity_areas($type, $account)
	{
		$query = Functions::get_json_decoded_query($this->database->select('opportunity_areas', [
			'id',
			'name'
		], [
			'AND' => [
				'account' => $account,
				$type => true,
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

    public function get_opportunity_types($opportunity_area, $type)
	{
		$query = Functions::get_json_decoded_query($this->database->select('opportunity_types', [
			'id',
			'name'
		], [
			'AND' => [
				'opportunity_area' => $opportunity_area,
				$type => true,
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

    public function get_locations($type, $account)
	{
		$query = Functions::get_json_decoded_query($this->database->select('locations', [
			'id',
			'name'
		], [
			'AND' => [
				'account' => $account,
				$type => true,
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
            'opportunity_areas'
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
		$query1 = Functions::get_json_decoded_query($this->database->select('countries', [
			'name',
			'lada'
		], [
			'priority[>=]' => 1,
			'ORDER' => [
				'priority' => 'ASC'
			]
		]));

		$query2 = Functions::get_json_decoded_query($this->database->select('countries', [
			'name',
			'lada'
		], [
			'priority[=]' => null,
			'ORDER' => [
				'name' => 'ASC'
			]
		]));

		$query = array_merge($query1, $query2);

		return $query;
	}

    public function get_survey_questions($account)
    {
        $query = Functions::get_json_decoded_query($this->database->select('survey_questions', [
            'id',
            'name',
			'subquestions',
			'type',
			'values'
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
			'account' => $data['account']['id'],
			'type' => 'request',
			'data' => Functions::get_openssl('encrypt', json_encode([
				'token' => Functions::get_random(8),
				'room' => ($data['account']['type'] == 'hotel') ? $data['room'] : null,
				'table' => ($data['account']['type'] == 'restaurant') ? $data['table'] : null,
				'client' => ($data['account']['type'] == 'others') ? $data['client'] : null,
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
				'reservation_number' => ($data['account']['type'] == 'hotel') ? $data['reservation_number'] : null,
				'reservation_status' => null,
				'check_in' => ($data['account']['type'] == 'hotel') ? $data['check_in'] : null,
				'check_out' => ($data['account']['type'] == 'hotel') ? $data['check_out'] : null,
				'attachments' => [],
				'viewed_by' => [],
				'comments' => [],
				'changes_history' => [
					[
						'type' => 'create',
						'user' => [
							'myvox',
							'guest'
						],
						'date' => Functions::get_current_date(),
						'hour' => Functions::get_current_hour(),
					]
				],
				'created_user' => [
					'myvox',
					'guest'
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
				'origin' => 'external'
			])),
		]);

		return !empty($query) ? $this->database->id() : null;
	}

    public function new_incident($data)
	{
		$query = $this->database->insert('voxes', [
			'account' => $data['account']['id'],
			'type' => 'incident',
			'data' => Functions::get_openssl('encrypt', json_encode([
				'token' => Functions::get_random(8),
				'room' => ($data['account']['type'] == 'hotel') ? $data['room'] : null,
				'table' => ($data['account']['type'] == 'restaurant') ? $data['table'] : null,
				'client' => ($data['account']['type'] == 'others') ? $data['client'] : null,
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
				'reservation_number' => ($data['account']['type'] == 'hotel') ? $data['reservation_number'] : null,
				'reservation_status' => null,
				'check_in' => ($data['account']['type'] == 'hotel') ? $data['check_in'] : null,
				'check_out' => ($data['account']['type'] == 'hotel') ? $data['check_out'] : null,
				'attachments' => [],
				'viewed_by' => [],
				'comments' => [],
				'changes_history' => [
					[
						'type' => 'create',
						'user' => [
							'myvox',
							'guest'
						],
						'date' => Functions::get_current_date(),
						'hour' => Functions::get_current_hour(),
					]
				],
				'created_user' => [
					'myvox',
					'guest'
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
				'origin' => 'external'
			])),
		]);

		return !empty($query) ? $this->database->id() : null;
	}

    public function new_survey_answer($data)
    {
		if ($data['account']['type'] == 'hotel')
		{
			$data['guest'] = [
				'guestvox' => [
					'firstname' => $data['firstname'],
					'lastname' => $data['lastname'],
					'email' => $data['email'],
					'phone' => [
						'lada' => $data['phone_lada'],
						'number' => $data['phone_number']
					]
				],
				'zaviapms' => [
					'firstname' => Session::get_value('room')['guest']['firstname'],
					'lastname' => Session::get_value('room')['guest']['lastname'],
					'reservation_number' => Session::get_value('room')['guest']['reservation_number'],
					'check_in' => Session::get_value('room')['guest']['check_in'],
					'check_out' => Session::get_value('room')['guest']['check_out'],
					'nationality' => Session::get_value('room')['guest']['nationality'],
					'input_channel' => Session::get_value('room')['guest']['input_channel'],
					'traveler_type' => Session::get_value('room')['guest']['traveler_type'],
					'age_group' => Session::get_value('room')['guest']['age_group']
				]
			];
		}

		if ($data['account']['type'] == 'restaurant')
		{
			$data['guest'] = [
				'guestvox' => [
					'firstname' => $data['firstname'],
					'lastname' => $data['lastname'],
					'email' => $data['email'],
					'phone' => [
						'lada' => $data['phone_lada'],
						'number' => $data['phone_number']
					]
				]
			];
		}

		if ($data['account']['type'] == 'others')
		{
			$data['guest'] = [
				'guestvox' => [
					'firstname' => $data['firstname'],
					'lastname' => $data['lastname'],
					'email' => $data['email'],
					'phone' => [
						'lada' => $data['phone_lada'],
						'number' => $data['phone_number']
					]
				]
			];
		}

		$query = $this->database->insert('survey_answers', [
			'account' => $data['account']['id'],
			'token' => $data['token'],
			'room' => ($data['account']['type'] == 'hotel' AND !empty($data['room'])) ? $data['room'] : null,
			'table' => ($data['account']['type'] == 'restaurant' AND !empty($data['table'])) ? $data['table'] : null,
			'client' => ($data['account']['type'] == 'others' AND !empty($data['client'])) ? $data['client'] : null,
			'answers' => json_encode($data['answers']),
			'comment' => $data['comment'],
			'guest' => json_encode($data['guest']),
			'date' => Functions::get_current_date(),
			'status' => false
		]);

		return !empty($query) ? $this->database->id() : null;
    }

	public function get_average($id)
	{
		$query = Functions::get_json_decoded_query($this->database->select('survey_answers', [
			'id',
			'answers',
		], [
			'id' => $id
		]));

		if (!empty($query))
		{
			$average = 0;
			$count = 0;

			foreach ($query[0]['answers'] as $key => $value)
			{
				if ($value['type'] == 'rate')
				{
					$average = $average + $value['answer'];
					$count = $count + 1;
				}

				foreach ($value['subanswers'] as $subvalue)
				{
					if ($subvalue['type'] == 'rate')
					{
						$average = $average + $subvalue['answer'];
						$count = $count + 1;
					}

					foreach ($subvalue['subanswers'] as $childvalue)
					{
						if ($childvalue['type'] == 'rate')
						{
							$average = $average + $childvalue['answer'];
							$count = $count + 1;
						}
					}
				}
			}

			if ($average > 0 AND $count > 0)
				$average = round(($average / $count), 1);

			return $average;
		}
		else
			return null;
	}

	public function edit_sms($id, $sms)
	{
		$query = $this->database->update('accounts', [
			'sms' => $sms
		], [
			'id' => $id
		]);

		return $query;
	}
}
