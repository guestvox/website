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
			'language',
			'logotype',
			'operation',
			'reputation',
			'zaviapms',
			'settings'
		], [
			'AND' => [
				'path' => $path,
				'status' => true
			]
		]));

		return !empty($query) ? $query[0] : null;
	}

	public function get_owners($type)
	{
		$query = $this->database->select('owners', [
			'id',
			'name',
			'number'
		], [
			'AND' => [
				'account' => Session::get_value('account')['id'],
				$type => true,
				'public' => true
			],
			'ORDER' => [
				'number' => 'ASC',
				'name' => 'ASC'
			]
		]);

		return $query;
	}

    public function get_owner($token = null)
	{
		if (!empty($token))
		{
			$query = $this->database->select('owners', [
				'id',
				'name',
				'number'
			], [
				'OR' => [
					'id' => $token,
					'token' => strtoupper($token)
				]
			]);

			return !empty($query) ? $query[0] : null;
		}
		else
		{
			return [
				'id' => '',
				'name' => '',
				'number' => ''
			];
		}
	}

	public function get_reservation($number)
	{
		$reservation = [
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

		if (!empty($number) AND Session::get_value('account')['zaviapms']['status'] == true)
		{
			$query = Functions::api('zaviapms', Session::get_value('account')['zaviapms'], 'get', 'room', $number);

			$reservation['status'] = $query['Status'];

			if ($reservation['status'] == 'success')
			{
				$reservation['firstname'] = $query['Name'];
				$reservation['lastname'] = $query['LastName'];
				$reservation['reservation_number'] = $query['FolioRefID'];
				$reservation['check_in'] = $query['StartDate'];
				$reservation['check_out'] = $query['EndDate'];
				$reservation['nationality'] = $query['Country'];
				$reservation['input_channel'] = $query['Channel'];
				$reservation['traveler_type'] = $query['TravelerType'];
				$reservation['age_group'] = $query['AgeGroup'];
			}
		}

		return $reservation;
	}

    public function get_opportunity_areas($type)
	{
		$query = Functions::get_json_decoded_query($this->database->select('opportunity_areas', [
			'id',
			'name'
		], [
			'AND' => [
				'account' => Session::get_value('account')['id'],
				$type => true,
				'public' => true
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
				'public' => true
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
			'id' => $id
		]));

		return !empty($query) ? $query[0] : null;
	}

    public function get_locations($type)
	{
		$query = Functions::get_json_decoded_query($this->database->select('locations', [
			'id',
			'name'
		], [
			'AND' => [
				'account' => Session::get_value('account')['id'],
				$type => true,
				'public' => true
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

	public function get_assigned_users($opportunity_area)
	{
        $query = Functions::get_json_decoded_query($this->database->select('users', [
            'firstname',
            'lastname',
            'email',
            'phone',
            'opportunity_areas'
        ], [
            'AND' => [
				'account' => Session::get_value('account')['id'],
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

    public function new_vox($data)
	{
		$query = $this->database->insert('voxes', [
			'account' => Session::get_value('account')['id'],
			'type' => $data['type'],
			'token' => $data['token'],
			'owner' => Session::get_value('owner')['id'],
			'opportunity_area' => $data['opportunity_area'],
			'opportunity_type' => $data['opportunity_type'],
			'started_date' => Functions::get_formatted_date($data['started_date']),
			'started_hour' => Functions::get_formatted_hour($data['started_hour']),
			'location' => $data['location'],
			'cost' => null,
			'urgency' => 'medium',
			'confidentiality' => false,
			'assigned_users' => json_encode([]),
			'observations' => ($data['type'] == 'request') ? $data['observations'] : null,
			'subject' => ($data['type'] == 'incident') ? $data['subject'] : null,
			'description' => null,
			'action_taken' => null,
			'guest_treatment' => null,
			'firstname' => (Session::get_value('account')['type'] == 'hotel' AND (!isset($data['firstname']) OR empty($data['firstname']))) ? Session::get_value('owner')['reservation']['firstname'] : $data['firstname'],
			'lastname' => (Session::get_value('account')['type'] == 'hotel' AND (!isset($data['lastname']) OR empty($data['lastname']))) ? Session::get_value('owner')['reservation']['lastname'] : $data['lastname'],
			'guest_id' => null,
			'guest_type' => null,
			'reservation_number' => ($data['type'] == 'incident' AND Session::get_value('account')['type'] == 'hotel') ? Session::get_value('owner')['reservation']['reservation_number'] : null,
			'reservation_status' => null,
			'check_in' => ($data['type'] == 'incident' AND Session::get_value('account')['type'] == 'hotel') ? Session::get_value('owner')['reservation']['check_in'] : null,
			'check_out' => ($data['type'] == 'incident' AND Session::get_value('account')['type'] == 'hotel') ? Session::get_value('owner')['reservation']['check_out'] : null,
			'attachments' => json_encode([]),
			'viewed_by' => json_encode([]),
			'comments' => json_encode([]),
			'changes_history' => json_encode([
				[
					'type' => 'create',
					'user' => null,
					'date' => Functions::get_current_date(),
					'hour' => Functions::get_current_hour()
				]
			]),
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
			'status' => 'open',
			'origin' => 'myvox'
		]);

		return !empty($query) ? $this->database->id() : null;
	}

	public function get_surveys_questions()
    {
		$query1 = Functions::get_json_decoded_query($this->database->select('surveys_questions', [
            'id',
            'name',
			'subquestions',
			'type',
			'values'
        ], [
            'AND' => [
				'system' => true,
				'status' => true
			]
        ]));

        $query2 = Functions::get_json_decoded_query($this->database->select('surveys_questions', [
            'id',
            'name',
			'subquestions',
			'type',
			'values'
        ], [
            'AND' => [
				'account' => Session::get_value('account')['id'],
				'status' => true
			]
        ]));

		$query = array_merge($query1, $query2);

     	return $query;
    }

	public function get_survey_average($id)
	{
		$query = Functions::get_json_decoded_query($this->database->select('surveys_answers', [
			'id',
			'answers'
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

    public function new_survey_answer($data)
    {
		$data['contact'] = [
			'firstname' => $data['firstname'],
			'lastname' => $data['lastname'],
			'email' => $data['email'],
			'phone' => [
				'lada' => $data['phone_lada'],
				'number' => $data['phone_number']
			]
		];

		if (Session::get_value('account')['type'] == 'hotel')
		{
			$data['contact']['reservation'] = [
				'firstname' => Session::get_value('owner')['reservation']['firstname'],
				'lastname' => Session::get_value('owner')['reservation']['lastname'],
				'reservation_number' => Session::get_value('owner')['reservation']['reservation_number'],
				'check_in' => Session::get_value('owner')['reservation']['check_in'],
				'check_out' => Session::get_value('owner')['reservation']['check_out'],
				'nationality' => Session::get_value('owner')['reservation']['nationality'],
				'input_channel' => Session::get_value('owner')['reservation']['input_channel'],
				'traveler_type' => Session::get_value('owner')['reservation']['traveler_type'],
				'age_group' => Session::get_value('owner')['reservation']['age_group']
			];
		}

		$query = $this->database->insert('surveys_answers', [
			'account' => Session::get_value('account')['id'],
			'token' => $data['token'],
			'owner' => $data['owner'],
			'answers' => json_encode($data['answers']),
			'comment' => $data['comment'],
			'contact' => json_encode($data['contact']),
			'date' => Functions::get_current_date(),
			'status' => false
		]);

		return !empty($query) ? $this->database->id() : null;
    }

	public function get_sms()
	{
		$query = $this->database->select('accounts', [
			'sms'
		], [
			'id' => Session::get_value('account')['id']
		]);

		return !empty($query) ? $query[0]['sms'] : null;
	}

	public function edit_sms($sms)
	{
		$query = $this->database->update('accounts', [
			'sms' => $sms
		], [
			'id' => Session::get_value('account')['id']
		]);

		return $query;
	}
}
