<?php

defined('_EXEC') or die;

class Voxes_model extends Model
{
	public function __construct()
	{
		parent::__construct();
	}

	public function get_voxes($option = 'all', $data = null)
	{
		$where = [
			'AND' => [
				'account' => Session::get_value('account')['id']
			]
		];

		if (Functions::check_user_access(['{view_confidentiality}']) == false)
			$where['AND']['confidentiality'] = false;

		if ($option == 'all')
		{
			if (Session::get_value('settings')['voxes']['voxes']['filter']['type'] != 'all')
				$where['AND']['type'] = Session::get_value('settings')['voxes']['voxes']['filter']['type'];

			if (Session::get_value('settings')['voxes']['voxes']['filter']['owner'] != 'all')
				$where['AND']['owner'] = Session::get_value('settings')['voxes']['voxes']['filter']['owner'];

			if (Session::get_value('settings')['voxes']['voxes']['filter']['opportunity_area'] != 'all')
				$where['AND']['opportunity_area'] = Session::get_value('settings')['voxes']['voxes']['filter']['opportunity_area'];

			if (Session::get_value('settings')['voxes']['voxes']['filter']['opportunity_type'] != 'all')
				$where['AND']['opportunity_type'] = Session::get_value('settings')['voxes']['voxes']['filter']['opportunity_type'];

			if (Session::get_value('settings')['voxes']['voxes']['filter']['location'] != 'all')
				$where['AND']['location'] = Session::get_value('settings')['voxes']['voxes']['filter']['location'];

			if (Session::get_value('settings')['voxes']['voxes']['filter']['urgency'] != 'all')
				$where['AND']['urgency'] = Session::get_value('settings')['voxes']['voxes']['filter']['urgency'];

			if (Session::get_value('settings')['voxes']['voxes']['filter']['order'] == 'date_old')
			{
				$where['ORDER'] = [
					'started_date' => 'ASC',
					'started_hour' => 'ASC'
				];
			}
			else if (Session::get_value('settings')['voxes']['voxes']['filter']['order'] == 'date_down')
			{
				$where['ORDER'] = [
					'started_date' => 'DESC',
					'started_hour' => 'DESC'
				];
			}

			if (Session::get_value('settings')['voxes']['voxes']['filter']['status'] == 'open')
				$where['AND']['status'] = true;
			else if (Session::get_value('settings')['voxes']['voxes']['filter']['status'] == 'close')
				$where['AND']['status'] = false;
		}
		else if ($option == 'report')
		{
			if ($data['type'] != 'all')
				$where['AND']['type'] = $data['type'];

			if (!empty($data['owner']))
				$where['AND']['owner'] = $data['owner'];

			if (!empty($data['opportunity_area']))
				$where['AND']['opportunity_area'] = $data['opportunity_area'];

			if (!empty($data['opportunity_type']))
				$where['AND']['opportunity_type'] = $data['opportunity_type'];

			if (!empty($data['location']))
				$where['AND']['location'] = $data['location'];

			$where['AND']['started_date[<>]'] = [$data['started_date'],$data['end_date']];

			if ($data['type'] == 'all' OR $data['type'] == 'workorder')
			{
				$where['ORDER']['started_date'] = 'DESC';
				$where['ORDER']['started_hour'] = 'DESC';
			}
			else if ($data['type'] == 'request' OR $data['type'] == 'incident')
			{
				if ($data['order'] == 'owner')
					$where['ORDER']['owner'] = 'ASC';
				else if ($data['order'] == 'name')
				{
					$where['ORDER']['firstname'] = 'ASC';
					$where['ORDER']['lastname'] = 'ASC';
				}
			}
		}

		$query = Functions::get_json_decoded_query($this->database->select('voxes', [
			'type',
			'token',
			'owner',
			'opportunity_area',
			'opportunity_type',
			'started_date',
			'started_hour',
			'location',
			'address',
			'cost',
			'urgency',
			'confidentiality',
			'assigned_users',
			'observations',
			'subject',
			'description',
			'action_taken',
			'guest_treatment',
			'firstname',
			'lastname',
			'guest_id',
			'guest_type',
			'reservation_number',
			'reservation_status',
			'check_in',
			'check_out',
			'attachments',
			'viewed_by',
			'comments',
			'created_user',
			'created_date',
			'created_hour',
			'edited_user',
			'edited_date',
			'edited_hour',
			'completed_user',
			'completed_date',
			'completed_hour',
			'reopened_user',
			'reopened_date',
			'reopened_hour',
			'menu_order',
			'status',
			'origin'
		], $where));

		foreach ($query as $key => $value)
		{
			$break = true;

			if (Session::get_value('settings')['voxes']['voxes']['filter']['assigned'] == 'all')
				$break = false;
			else if (Session::get_value('settings')['voxes']['voxes']['filter']['assigned'] == 'opportunity_areas' AND in_array($value['opportunity_area'], Session::get_value('user')['opportunity_areas']))
				$break = false;
			else if (Session::get_value('settings')['voxes']['voxes']['filter']['assigned'] == 'me')
			{
				if (!empty($value['assigned_users']) AND in_array(Session::get_value('user')['id'], $value['assigned_users']))
					$break = false;
				else if (empty($value['assigned_users']) AND $value['created_user'] == Session::get_value('user')['id'])
					$break = false;
			}
			else
			{
				if (!empty($value['assigned_users']) AND in_array(Session::get_value('settings')['voxes']['voxes']['filter']['assigned'], $value['assigned_users']))
					$break = false;
				else if (empty($value['assigned_users']) AND $value['created_user'] == Session::get_value('settings')['voxes']['voxes']['filter']['assigned'])
					$break = false;
			}

			if ($break == false)
			{
				$query[$key]['owner'] = $this->get_owner($value['owner']);
				$query[$key]['opportunity_area'] = $this->get_opportunity_area($value['opportunity_area']);
				$query[$key]['opportunity_type'] = $this->get_opportunity_type($value['opportunity_type']);
				$query[$key]['location'] = $this->get_location($value['location']);

				if (Session::get_value('account')['type'] == 'hotel')
				{
					if ($value['type'] == 'request' OR $value['type'] == 'incident')
						$query[$key]['guest_treatment'] = $this->get_guest_treatment($value['guest_treatment']);
				}

				foreach ($value['assigned_users'] as $subkey => $subvalue)
					$query[$key]['assigned_users'][$subkey] = $this->get_user($subvalue);

				foreach ($value['comments'] as $subkey => $subvalue)
				{
					$query[$key]['attachments'] = array_merge($value['attachments'], $subvalue['attachments']);

					if ($option == 'report')
					{
						$query[$key]['cost'] = (!empty($value['cost']) ? $value['cost'] : 0) + (!empty($subvalue['cost']) ? $subvalue['cost'] : 0);
						$query[$key]['comments'][$subkey]['user'] = $this->get_user($subvalue['user']);
					}
				}

				if ($option == 'report')
				{
					if (Session::get_value('account')['type'] == 'hotel')
					{
						if ($value['type'] == 'incident')
						{
							$query[$key]['guest_type'] = $this->get_guest_type($value['guest_type']);
							$query[$key]['reservation_status'] = $this->get_reservation_status($value['reservation_status']);
						}
					}

					foreach ($value['viewed_by'] as $subkey => $subvalue)
						$query[$key]['viewed_by'][$subkey] = $this->get_user($subvalue);

					$query[$key]['edited_user'] = $this->get_user($value['edited_user']);
					$query[$key]['completed_user'] = $this->get_user($value['completed_user']);
					$query[$key]['reopened_user'] = $this->get_user($value['reopened_user']);
				}

				$query[$key]['created_user'] = $this->get_user($value['created_user']);

				if (Session::get_value('account')['type'] == 'hotel' OR Session::get_value('account')['type'] == 'restaurant')
					$query[$key]['menu_order'] = $this->get_menu_order($query[$key]['menu_order']);
			}
			else
				unset($query[$key]);
		}

		return $query;
	}

	public function get_vox($token, $edit = false)
	{
		$query = Functions::get_json_decoded_query($this->database->select('voxes', [
			'id',
			'type',
			'token',
			'owner',
			'opportunity_area',
			'opportunity_type',
			'started_date',
			'started_hour',
			'location',
			'address',
			'cost',
			'urgency',
			'confidentiality',
			'assigned_users',
			'observations',
			'subject',
			'description',
			'action_taken',
			'guest_treatment',
			'firstname',
			'lastname',
			'email',
			'phone',
			'guest_id',
			'guest_type',
			'reservation_number',
			'reservation_status',
			'check_in',
			'check_out',
			'attachments',
			'viewed_by',
			'comments',
			'changes_history',
			'created_user',
			'created_date',
			'created_hour',
			'edited_user',
			'edited_date',
			'edited_hour',
			'completed_user',
			'completed_date',
			'completed_hour',
			'reopened_user',
			'reopened_date',
			'reopened_hour',
			'menu_order',
			'status',
			'origin'
		], [
			'token' => $token
		]));

		if (!empty($query))
		{
			if ($edit == false)
			{
				if ($query[0]['status'] == true)
				{
					if (in_array(Session::get_value('user')['id'], $query[0]['viewed_by']))
					{
						foreach ($query[0]['viewed_by'] as $key => $value)
						{
							if ($value == Session::get_value('user')['id'])
								unset($query[0]['viewed_by'][$key]);
						}

						foreach ($query[0]['changes_history'] as $key => $value)
						{
							if ($value['type'] == 'viewed' AND $value['user'] == Session::get_value('user')['id'])
								unset($query[0]['changes_history'][$key]);
						}

						$query[0]['viewed_by'] = array_values($query[0]['viewed_by']);
						$query[0]['changes_history'] = array_values($query[0]['changes_history']);
					}

					array_push($query[0]['viewed_by'], Session::get_value('user')['id']);

					array_push($query[0]['changes_history'], [
						'type' => 'viewed',
						'user' => Session::get_value('user')['id'],
						'date' => Functions::get_current_date(),
						'hour' => Functions::get_current_hour()
					]);

					foreach ($query[0]['viewed_by'] as $key => $value)
					{
						if (!isset($value) OR empty($value))
							unset($query[0]['viewed_by'][$key]);
					}

					foreach ($query[0]['changes_history'] as $key => $value)
					{
						if ($value['type'] == 'viewed')
						{
							if (!isset($value['user']) OR empty($value['user']))
								unset($query[0]['changes_history'][$key]);
						}
					}

					$query[0]['viewed_by'] = array_values($query[0]['viewed_by']);
					$query[0]['changes_history'] = array_values($query[0]['changes_history']);

					$this->database->update('voxes', [
						'viewed_by' => json_encode($query[0]['viewed_by']),
						'changes_history' => json_encode($query[0]['changes_history'])
					], [
						'token' => $token
					]);
				}

				$query[0]['owner'] = $this->get_owner($query[0]['owner']);
				$query[0]['opportunity_area'] = $this->get_opportunity_area($query[0]['opportunity_area']);
				$query[0]['opportunity_type'] = $this->get_opportunity_type($query[0]['opportunity_type']);
				$query[0]['location'] = $this->get_location($query[0]['location']);

				foreach ($query[0]['assigned_users'] as $key => $value)
					$query[0]['assigned_users'][$key] = $this->get_user($value);

				if (Session::get_value('account')['type'] == 'hotel')
				{
					if ($query[0]['type'] == 'request' OR $query[0]['type'] == 'incident')
						$query[0]['guest_treatment'] = $this->get_guest_treatment($query[0]['guest_treatment']);

					if ($query[0]['type'] == 'incident')
					{
						$query[0]['guest_type'] = $this->get_guest_type($query[0]['guest_type']);
						$query[0]['reservation_status'] = $this->get_reservation_status($query[0]['reservation_status']);
					}
				}

				foreach ($query[0]['viewed_by'] as $key => $value)
					$query[0]['viewed_by'][$key] = $this->get_user($value);

				$query[0]['viewed_by'] = array_reverse($query[0]['viewed_by']);

				foreach ($query[0]['comments'] as $key => $value)
				{
					$query[0]['cost'] = (!empty($query[0]['cost']) ? $query[0]['cost'] : 0) + (!empty($value['cost']) ? $value['cost'] : 0);
					$query[0]['attachments'] = array_merge($query[0]['attachments'], $value['attachments']);
					$query[0]['comments'][$key]['user'] = $this->get_user($value['user']);
				}

				$query[0]['attachments'] = array_reverse($query[0]['attachments']);
				$query[0]['comments'] = array_reverse($query[0]['comments']);

				foreach ($query[0]['changes_history'] as $key => $value)
					$query[0]['changes_history'][$key]['user'] = $this->get_user($value['user']);

				$query[0]['changes_history'] = array_reverse($query[0]['changes_history']);
				$query[0]['created_user'] = $this->get_user($query[0]['created_user']);
				$query[0]['edited_user'] = $this->get_user($query[0]['edited_user']);
				$query[0]['completed_user'] = $this->get_user($query[0]['completed_user']);
				$query[0]['reopened_user'] = $this->get_user($query[0]['reopened_user']);

				if (Session::get_value('account')['type'] == 'hotel' OR Session::get_value('account')['type'] == 'restaurant')
					$query[0]['menu_order'] = $this->get_menu_order($query[0]['menu_order']);
			}

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

	public function get_owner($id)
	{
		$query = Functions::get_json_decoded_query($this->database->select('owners', [
			'id',
			'name',
			'number'
		], [
			'id' => $id
		]));

		return !empty($query) ? $query[0] : null;
	}

	public function get_reservation($number)
	{
		$reservation = [
			'status' => 'success',
			'firstname' => '',
			'lastname' => '',
			'guest_id' => '',
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
				$reservation['guest_id'] = $query['FolioID'];
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

	public function get_opportunity_areas($type = 'all')
	{
		$and['account'] = Session::get_value('account')['id'];

		if ($type != 'all')
			$and[$type] = true;

		$and['status'] = true;

		$query = Functions::get_json_decoded_query($this->database->select('opportunity_areas', [
			'id',
			'name'
		], [
			'AND' => $and,
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
		$and['opportunity_area'] = $opportunity_area;

		if ($type != 'all')
			$and[$type] = true;

		$and['status'] = true;

		$query = Functions::get_json_decoded_query($this->database->select('opportunity_types', [
			'id',
			'name'
		], [
			'AND' => $and,
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

	public function get_locations($type = 'all')
	{
		$and['account'] = Session::get_value('account')['id'];

		if ($type != 'all')
			$and[$type] = true;

		$and['status'] = true;

		$query = Functions::get_json_decoded_query($this->database->select('locations', [
			'id',
			'name'
		], [
			'AND' => $and,
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

	public function get_guests_treatments()
	{
		$query = $this->database->select('guests_treatments', [
			'id',
			'name'
		], [
			'AND' => [
				'account' => Session::get_value('account')['id'],
				'status' => true
			],
			'ORDER' => [
				'name' => 'ASC'
			]
		]);

		return $query;
	}

	public function get_guest_treatment($id)
	{
		$query = $this->database->select('guests_treatments', [
			'id',
			'name'
		], [
			'id' => $id
		]);

		return !empty($query) ? $query[0] : null;
	}

	public function get_guests_types()
	{
		$query = $this->database->select('guests_types', [
			'id',
			'name'
		], [
			'AND' => [
				'account' => Session::get_value('account')['id'],
				'status' => true
			],
			'ORDER' => [
				'name' => 'ASC'
			]
		]);

		return $query;
	}

	public function get_guest_type($id)
	{
		$query = $this->database->select('guests_types', [
			'id',
			'name'
		], [
			'id' => $id
		]);

		return !empty($query) ? $query[0] : null;
	}

	public function get_reservations_statuses()
	{
		$query = $this->database->select('reservations_statuses', [
			'id',
			'name'
		], [
			'AND' => [
				'account' => Session::get_value('account')['id'],
				'status' => true
			],
			'ORDER' => [
				'name' => 'ASC'
			]
		]);

		return $query;
	}

	public function get_reservation_status($id)
	{
		$query = $this->database->select('reservations_statuses', [
			'id',
			'name'
		], [
			'id' => $id
		]);

		return !empty($query) ? $query[0] : null;
	}

	public function get_users()
	{
		$query = $this->database->select('users', [
			'id',
			'firstname',
			'lastname',
			'avatar'
		], [
			'AND' => [
				'account' => Session::get_value('account')['id'],
				'status' => true
			],
			'ORDER' => [
				'firstname' => 'ASC',
				'lastname' => 'ASC'
			]
		]);

		return $query;
	}

	public function get_user($id)
	{
		$query = Functions::get_json_decoded_query($this->database->select('users', [
			'id',
			'firstname',
			'lastname',
			'avatar',
			'username'
		], [
			'id' => $id
		]));

		return !empty($query) ? $query[0] : null;
	}

	public function get_assigned_users($assigned_users, $opportunity_area)
	{
        $query = Functions::get_json_decoded_query($this->database->select('users', [
			'id',
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
            if (!in_array($value['id'], $assigned_users) AND !in_array($opportunity_area, $value['opportunity_areas']))
				unset($query[$key]);
        }

		return $query;
	}

	public function get_menu_order($id)
	{
		$query = Functions::get_json_decoded_query($this->database->select('menu_orders', [
			'type_service',
			'delivery',
			'total',
			'currency',
			'shopping_cart'
		], [
			'id' => $id
		]));

		return !empty($query) ? $query[0] : null;
	}

	public function new_vox($data)
	{
		if (!empty($data['attachments']))
		{
			$this->component->load_component('uploader');

			$_com_uploader = new Upload;

			foreach ($data['attachments']['name'] as $key => $value)
			{
				if (!empty($data['attachments']['name'][$key]))
				{
					$ext = explode('.', $data['attachments']['name'][$key]);
					$ext = end($ext);

					if ($ext == 'doc' OR $ext == 'docx' OR $ext == 'xls' OR $ext == 'xlsx')
						$data['attachments']['type'][$key] = 'application/' . $ext;

					$_com_uploader->SetFileName(Session::get_value('account')['path'] . '_vox_attachment_');
					$_com_uploader->SetTempName($data['attachments']['tmp_name'][$key]);
					$_com_uploader->SetFileType($data['attachments']['type'][$key]);
					$_com_uploader->SetFileSize($data['attachments']['size'][$key]);
					$_com_uploader->SetUploadDirectory(PATH_UPLOADS);
					$_com_uploader->SetValidExtensions(['jpg','jpeg','png','pdf','doc','docx','xls','xlsx']);
					$_com_uploader->SetMaximumFileSize('unlimited');

					$data['attachments'][$key] = $_com_uploader->UploadFile();
				}
			}

			unset($data['attachments']['name']);
			unset($data['attachments']['type']);
			unset($data['attachments']['tmp_name']);
			unset($data['attachments']['error']);
			unset($data['attachments']['size']);
		}

		$query = $this->database->insert('voxes', [
			'account' => Session::get_value('account')['id'],
			'type' => $data['type'],
			'token' => $data['token'],
			'owner' => $data['owner'],
			'opportunity_area' => $data['opportunity_area'],
			'opportunity_type' => $data['opportunity_type'],
			'started_date' => Functions::get_formatted_date($data['started_date']),
			'started_hour' => Functions::get_formatted_hour($data['started_hour']),
			'location' => $data['location'],
			'address' => null,
			'cost' => (($data['type'] == 'incident' OR $data['type'] == 'workorder') AND !empty($data['cost'])) ? $data['cost'] : null,
			'urgency' => $data['urgency'],
			'confidentiality' => ($data['type'] == 'incident' AND !empty($data['confidentiality'])) ? true : false,
			'assigned_users' => json_encode($data['assigned_users']),
			'observations' => (($data['type'] == 'request' OR $data['type'] == 'workorder') AND !empty($data['observations'])) ? $data['observations'] : null,
			'subject' => ($data['type'] == 'incident' AND !empty($data['subject'])) ? $data['subject'] : null,
			'description' => ($data['type'] == 'incident' AND !empty($data['description'])) ? $data['description'] : null,
			'action_taken' => ($data['type'] == 'incident' AND !empty($data['action_taken'])) ? $data['action_taken'] : null,
			'guest_treatment' => (Session::get_value('account')['type'] == 'hotel' AND ($data['type'] == 'request' OR $data['type'] == 'incident') AND !empty($data['guest_treatment'])) ? $data['guest_treatment'] : null,
			'firstname' => (($data['type'] == 'request' OR $data['type'] == 'incident') AND !empty($data['firstname'])) ? $data['firstname'] : null,
			'lastname' => (($data['type'] == 'request' OR $data['type'] == 'incident') AND !empty($data['lastname'])) ? $data['lastname'] : null,
			'email' => null,
			'phone' => json_encode([
				'lada' => '',
				'number' => ''
			]),
			'guest_id' => (Session::get_value('account')['type'] == 'hotel' AND $data['type'] == 'incident' AND !empty($data['guest_id'])) ? $data['guest_id'] : null,
			'guest_type' => (Session::get_value('account')['type'] == 'hotel' AND $data['type'] == 'incident' AND !empty($data['guest_type'])) ? $data['guest_type'] : null,
			'reservation_number' => (Session::get_value('account')['type'] == 'hotel' AND $data['type'] == 'incident' AND !empty($data['reservation_number'])) ? $data['reservation_number'] : null,
			'reservation_status' => (Session::get_value('account')['type'] == 'hotel' AND $data['type'] == 'incident' AND !empty($data['reservation_status'])) ? $data['reservation_status'] : null,
			'check_in' => (Session::get_value('account')['type'] == 'hotel' AND $data['type'] == 'incident' AND !empty($data['check_in'])) ? $data['check_in'] : null,
			'check_out' => (Session::get_value('account')['type'] == 'hotel' AND $data['type'] == 'incident' AND !empty($data['check_out'])) ? $data['check_out'] : null,
			'attachments' => json_encode((!empty($data['attachments']) ? $data['attachments'] : [])),
			'viewed_by' => json_encode([]),
			'comments' => json_encode([]),
			'changes_history' => json_encode([
				[
					'type' => 'created',
					'user' => Session::get_value('user')['id'],
					'date' => Functions::get_current_date(),
					'hour' => Functions::get_current_hour()
				]
			]),
			'created_user' => Session::get_value('user')['id'],
			'created_date' => Functions::get_current_date(),
			'created_hour' => Functions::get_current_hour(),
			'edited_user' => null,
			'edited_date' => null,
			'edited_hour' => null,
			'completed_user' => null,
			'completed_date' => null,
			'completed_hour' => null,
			'reopened_user' => null,
			'reopened_date' => null,
			'reopened_hour' => null,
			'menu_order' => null,
			'status' => true,
			'origin' => 'internal'
		]);

		return $query;
	}

	public function edit_vox($data)
	{
		$query = null;
		$editer = $this->get_vox($data['token'], true);

		if (!empty($editer))
		{
			if (!empty($data['assigned_users']))
			{
				$data['assigned_users'] = array_unique($data['assigned_users']);
				$data['assigned_users'] = array_values($data['assigned_users']);
			}
			else
				$data['assigned_users'] = $data['assigned_users'];

			if (!empty($data['attachments']))
			{
				$this->component->load_component('uploader');

				$_com_uploader = new Upload;

				foreach ($data['attachments']['name'] as $key => $value)
				{
					if (!empty($data['attachments']['name'][$key]))
					{
						$ext = explode('.', $data['attachments']['name'][$key]);
						$ext = end($ext);

						if ($ext == 'doc' OR $ext == 'docx' OR $ext == 'xls' OR $ext == 'xlsx')
							$data['attachments']['type'][$key] = 'application/' . $ext;

						$_com_uploader->SetFileName(Session::get_value('account')['path'] . '_vox_attachment_');
						$_com_uploader->SetTempName($data['attachments']['tmp_name'][$key]);
						$_com_uploader->SetFileType($data['attachments']['type'][$key]);
						$_com_uploader->SetFileSize($data['attachments']['size'][$key]);
						$_com_uploader->SetUploadDirectory(PATH_UPLOADS);
						$_com_uploader->SetValidExtensions(['jpg','jpeg','png','pdf','doc','docx','xls','xlsx']);
						$_com_uploader->SetMaximumFileSize('unlimited');

						$data['attachments'][$key] = $_com_uploader->UploadFile();
					}
				}

				unset($data['attachments']['name']);
				unset($data['attachments']['type']);
				unset($data['attachments']['tmp_name']);
				unset($data['attachments']['error']);
				unset($data['attachments']['size']);

				$data['attachments'] = array_merge($editer['attachments'], $data['attachments']);
			}
			else
				$data['attachments'] = $editer['attachments'];

			$data['changes_history'] = [
				[
					'type' => 'edited',
					'fields' => [],
					'user' => Session::get_value('user')['id'],
					'date' => Functions::get_current_date(),
					'hour' => Functions::get_current_hour()
				]
			];

			if ($editer['type'] != $data['type'])
			{
				array_push($data['changes_history'][0]['fields'], [
					'field' => 'type',
					'before' => $editer['type'],
					'after' => $data['type']
				]);
			}

			if ($editer['owner'] != $data['owner'])
			{
				array_push($data['changes_history'][0]['fields'], [
					'field' => 'owner',
					'before' => $editer['owner'],
					'after' => $data['owner']
				]);
			}

			if ($editer['opportunity_area'] != $data['opportunity_area'])
			{
				array_push($data['changes_history'][0]['fields'], [
					'field' => 'opportunity_area',
					'before' => $editer['opportunity_area'],
					'after' => $data['opportunity_area']
				]);
			}

			if ($editer['opportunity_type'] != $data['opportunity_type'])
			{
				array_push($data['changes_history'][0]['fields'], [
					'field' => 'opportunity_type',
					'before' => $editer['opportunity_type'],
					'after' => $data['opportunity_type']
				]);
			}

			if ($editer['started_date'] != Functions::get_formatted_date($data['started_date']))
			{
				array_push($data['changes_history'][0]['fields'], [
					'field' => 'started_date',
					'before' => $editer['started_date'],
					'after' => Functions::get_formatted_date($data['started_date'])
				]);
			}

			if ($editer['started_hour'] != Functions::get_formatted_hour($data['started_hour']))
			{
				array_push($data['changes_history'][0]['fields'], [
					'field' => 'started_hour',
					'before' => $editer['started_hour'],
					'after' => Functions::get_formatted_hour($data['started_hour'])
				]);
			}

			if ($editer['location'] != $data['location'])
			{
				array_push($data['changes_history'][0]['fields'], [
					'field' => 'location',
					'before' => $editer['location'],
					'after' => $data['location']
				]);
			}

			if ($data['type'] == 'incident' OR $data['type'] == 'workorder')
			{
				if ($editer['cost'] != $data['cost'])
				{
					array_push($data['changes_history'][0]['fields'], [
						'field' => 'cost',
						'before' => $editer['cost'],
						'after' => $data['cost']
					]);
				}
			}

			if ($editer['urgency'] != $data['urgency'])
			{
				array_push($data['changes_history'][0]['fields'], [
					'field' => 'urgency',
					'before' => $editer['urgency'],
					'after' => $data['urgency']
				]);
			}

			if ($data['type'] == 'incident')
			{
				if ($editer['confidentiality'] != (!empty($data['confidentiality']) ? true : false))
				{
					array_push($data['changes_history'][0]['fields'], [
						'field' => 'confidentiality',
						'before' => $editer['confidentiality'],
						'after' => !empty($data['confidentiality']) ? true : false
					]);
				}
			}

			if ($editer['assigned_users'] != $data['assigned_users'])
			{
				array_push($data['changes_history'][0]['fields'], [
					'field' => 'assigned_users',
					'before' => $editer['assigned_users'],
					'after' => $data['assigned_users']
				]);
			}

			if ($data['type'] == 'request' OR $data['type'] == 'workorder')
			{
				if ($editer['observations'] != $data['observations'])
				{
					array_push($data['changes_history'][0]['fields'], [
						'field' => 'observations',
						'before' => $editer['observations'],
						'after' => $data['observations']
					]);
				}
			}

			if ($data['type'] == 'incident')
			{
				if ($editer['subject'] != $data['subject'])
				{
					array_push($data['changes_history'][0]['fields'], [
						'field' => 'subject',
						'before' => $editer['subject'],
						'after' => $data['subject']
					]);
				}

				if ($editer['description'] != $data['description'])
				{
					array_push($data['changes_history'][0]['fields'], [
						'field' => 'description',
						'before' => $editer['description'],
						'after' => $data['description']
					]);
				}

				if ($editer['action_taken'] != $data['action_taken'])
				{
					array_push($data['changes_history'][0]['fields'], [
						'field' => 'action_taken',
						'before' => $editer['action_taken'],
						'after' => $data['action_taken']
					]);
				}
			}

			if (Session::get_value('account')['type'] == 'hotel')
			{
				if ($data['type'] == 'request' OR $data['type'] == 'incident')
				{
					if ($editer['guest_treatment'] != $data['guest_treatment'])
					{
						array_push($data['changes_history'][0]['fields'], [
							'field' => 'guest_treatment',
							'before' => $editer['guest_treatment'],
							'after' => $data['guest_treatment']
						]);
					}
				}
			}

			if ($data['type'] == 'request' OR $data['type'] == 'incident')
			{
				if ($editer['firstname'] != $data['firstname'])
				{
					array_push($data['changes_history'][0]['fields'], [
						'field' => 'firstname',
						'before' => $editer['firstname'],
						'after' => $data['firstname']
					]);
				}

				if ($editer['lastname'] != $data['lastname'])
				{
					array_push($data['changes_history'][0]['fields'], [
						'field' => 'lastname',
						'before' => $editer['lastname'],
						'after' => $data['lastname']
					]);
				}
			}

			if (Session::get_value('account')['type'] == 'hotel')
			{
				if ($data['type'] == 'incident')
				{
					if ($editer['guest_id'] != $data['guest_id'])
					{
						array_push($data['changes_history'][0]['fields'], [
							'field' => 'guest_id',
							'before' => $editer['guest_id'],
							'after' => $data['guest_id']
						]);
					}

					if ($editer['guest_type'] != $data['guest_type'])
					{
						array_push($data['changes_history'][0]['fields'], [
							'field' => 'guest_type',
							'before' => $editer['guest_type'],
							'after' => $data['guest_type']
						]);
					}

					if ($editer['reservation_number'] != $data['reservation_number'])
					{
						array_push($data['changes_history'][0]['fields'], [
							'field' => 'reservation_number',
							'before' => $editer['reservation_number'],
							'after' => $data['reservation_number']
						]);
					}

					if ($editer['reservation_status'] != $data['reservation_status'])
					{
						array_push($data['changes_history'][0]['fields'], [
							'field' => 'reservation_status',
							'before' => $editer['reservation_status'],
							'after' => $data['reservation_status']
						]);
					}

					if ($editer['check_in'] != $data['check_in'])
					{
						array_push($data['changes_history'][0]['fields'], [
							'field' => 'check_in',
							'before' => $editer['check_in'],
							'after' => $data['check_in']
						]);
					}

					if ($editer['check_out'] != $data['check_out'])
					{
						array_push($data['changes_history'][0]['fields'], [
							'field' => 'check_out',
							'before' => $editer['check_out'],
							'after' => $data['check_out']
						]);
					}
				}
			}

			if ($editer['attachments'] != $data['attachments'])
			{
				array_push($data['changes_history'][0]['fields'], [
					'field' => 'attachments',
					'before' => $editer['attachments'],
					'after' => $data['attachments']
				]);
			}

			if (!empty($data['changes_history'][0]['fields']))
				$data['changes_history'] = array_merge($editer['changes_history'], $data['changes_history']);
			else
				$data['changes_history'] = $editer['changes_history'];

			$query = $this->database->update('voxes', [
				'type' => $data['type'],
				'owner' => $data['owner'],
				'opportunity_area' => $data['opportunity_area'],
				'opportunity_type' => $data['opportunity_type'],
				'started_date' => Functions::get_formatted_date($data['started_date']),
				'started_hour' => Functions::get_formatted_hour($data['started_hour']),
				'location' => $data['location'],
				'cost' => (($data['type'] == 'incident' OR $data['type'] == 'workorder') AND !empty($data['cost'])) ? $data['cost'] : null,
				'urgency' => $data['urgency'],
				'confidentiality' => ($data['type'] == 'incident' AND !empty($data['confidentiality'])) ? true : false,
				'assigned_users' => json_encode($data['assigned_users']),
				'observations' => (($data['type'] == 'request' OR $data['type'] == 'workorder') AND !empty($data['observations'])) ? $data['observations'] : null,
				'subject' => ($data['type'] == 'incident' AND !empty($data['subject'])) ? $data['subject'] : null,
				'description' => ($data['type'] == 'incident' AND !empty($data['description'])) ? $data['description'] : null,
				'action_taken' => ($data['type'] == 'incident' AND !empty($data['action_taken'])) ? $data['action_taken'] : null,
				'guest_treatment' => (Session::get_value('account')['type'] == 'hotel' AND ($data['type'] == 'request' OR $data['type'] == 'incident') AND !empty($data['guest_treatment'])) ? $data['guest_treatment'] : null,
				'firstname' => (($data['type'] == 'request' OR $data['type'] == 'incident') AND !empty($data['firstname'])) ? $data['firstname'] : null,
				'lastname' => (($data['type'] == 'request' OR $data['type'] == 'incident') AND !empty($data['lastname'])) ? $data['lastname'] : null,
				'guest_id' => (Session::get_value('account')['type'] == 'hotel' AND $data['type'] == 'incident' AND !empty($data['guest_id'])) ? $data['guest_id'] : null,
				'guest_type' => (Session::get_value('account')['type'] == 'hotel' AND $data['type'] == 'incident' AND !empty($data['guest_type'])) ? $data['guest_type'] : null,
				'reservation_number' => (Session::get_value('account')['type'] == 'hotel' AND $data['type'] == 'incident' AND !empty($data['reservation_number'])) ? $data['reservation_number'] : null,
				'reservation_status' => (Session::get_value('account')['type'] == 'hotel' AND $data['type'] == 'incident' AND !empty($data['reservation_status'])) ? $data['reservation_status'] : null,
				'check_in' => (Session::get_value('account')['type'] == 'hotel' AND $data['type'] == 'incident' AND !empty($data['check_in'])) ? $data['check_in'] : null,
				'check_out' => (Session::get_value('account')['type'] == 'hotel' AND $data['type'] == 'incident' AND !empty($data['check_out'])) ? $data['check_out'] : null,
				'attachments' => json_encode((!empty($data['attachments']) ? $data['attachments'] : [])),
				'changes_history' => json_encode($data['changes_history']),
				'edited_user' => Session::get_value('user')['id'],
				'edited_date' => Functions::get_current_date(),
				'edited_hour' => Functions::get_current_hour()
			], [
				'id' => $data['id']
			]);
		}

		return $query;
	}

	public function comment_vox($data)
	{
		$query = null;

		$editer = Functions::get_json_decoded_query($this->database->select('voxes', [
			'comments',
			'changes_history'
		], [
			'id' => $data['id']
		]));

		if (!empty($editer))
		{
			if (!empty($data['attachments']))
			{
				$this->component->load_component('uploader');

				$_com_uploader = new Upload;

				foreach ($data['attachments']['name'] as $key => $value)
				{
					if (!empty($data['attachments']['name'][$key]))
					{
						$ext = explode('.', $data['attachments']['name'][$key]);
						$ext = end($ext);

						if ($ext == 'doc' OR $ext == 'docx' OR $ext == 'xls' OR $ext == 'xlsx')
							$data['attachments']['type'][$key] = 'application/' . $ext;

						$_com_uploader->SetFileName(Session::get_value('account')['path'] . '_vox_attachment_');
						$_com_uploader->SetTempName($data['attachments']['tmp_name'][$key]);
						$_com_uploader->SetFileType($data['attachments']['type'][$key]);
						$_com_uploader->SetFileSize($data['attachments']['size'][$key]);
						$_com_uploader->SetUploadDirectory(PATH_UPLOADS);
						$_com_uploader->SetValidExtensions(['jpg','jpeg','png','pdf','doc','docx','xls','xlsx']);
						$_com_uploader->SetMaximumFileSize('unlimited');

						$data['attachments'][$key] = $_com_uploader->UploadFile();
					}
				}

				unset($data['attachments']['name']);
				unset($data['attachments']['type']);
				unset($data['attachments']['tmp_name']);
				unset($data['attachments']['error']);
				unset($data['attachments']['size']);
			}

			array_push($editer[0]['comments'], [
				'user' => Session::get_value('user')['id'],
				'date' => Functions::get_current_date(),
				'hour' => Functions::get_current_hour(),
				'cost' => $data['cost'],
				'comment' => $data['comment'],
				'attachments' => !empty($data['attachments']) ? $data['attachments'] : []
			]);

			array_push($editer[0]['changes_history'], [
				'type' => 'commented',
				'user' => Session::get_value('user')['id'],
				'date' => Functions::get_current_date(),
				'hour' => Functions::get_current_hour()
			]);

			$query = $this->database->update('voxes', [
				'comments' => json_encode($editer[0]['comments']),
				'changes_history' => json_encode($editer[0]['changes_history'])
			], [
				'id' => $data['id']
			]);
		}

		return $query;
	}

	public function complete_vox($id)
	{
		$query = null;

		$editer = Functions::get_json_decoded_query($this->database->select('voxes', [
			'changes_history'
		], [
			'id' => $id
		]));

		if (!empty($editer))
		{
			array_push($editer[0]['changes_history'], [
				'type' => 'completed',
				'user' => Session::get_value('user')['id'],
				'date' => Functions::get_current_date(),
				'hour' => Functions::get_current_hour()
			]);

			$query = $this->database->update('voxes', [
				'changes_history' => json_encode($editer[0]['changes_history']),
				'completed_user' => Session::get_value('user')['id'],
				'completed_date' => Functions::get_current_date(),
				'completed_hour' => Functions::get_current_hour(),
				'status' => false
			], [
				'id' => $id
			]);
		}

		return $query;
	}

	public function reopen_vox($id)
	{
		$query = null;

		$editer = Functions::get_json_decoded_query($this->database->select('voxes', [
			'changes_history'
		], [
			'id' => $id
		]));

		if (!empty($editer))
		{
			array_push($editer[0]['changes_history'], [
				'type' => 'reopened',
				'user' => Session::get_value('user')['id'],
				'date' => Functions::get_current_date(),
				'hour' => Functions::get_current_hour()
			]);

			$query = $this->database->update('voxes', [
				'changes_history' => json_encode($editer[0]['changes_history']),
				'reopened_user' => Session::get_value('user')['id'],
				'reopened_date' => Functions::get_current_date(),
				'reopened_hour' => Functions::get_current_hour(),
				'status' => true
			], [
				'id' => $id
			]);
		}

		return $query;
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

	public function get_voxes_average()
	{
		$query = $this->database->select('voxes', [
			'started_date',
			'started_hour',
			'completed_date',
			'completed_hour'
		], [
			'AND' => [
				'account' => Session::get_value('account')['id'],
				'started_date[<>]' => [Session::get_value('settings')['voxes']['stats']['filter']['started_date'],Session::get_value('settings')['voxes']['stats']['filter']['end_date']]
			]
		]);

		$hours = 0;
		$count = 0;
		$average = 0;

		foreach ($query as $value)
		{
			$date1 = new DateTime($value['started_date'] . ' ' . $value['started_hour']);
			$date2 = new DateTime($value['completed_date'] . ' ' . $value['completed_hour']);
			$date3 = $date1->diff($date2);
			$hours = $hours + ((24 * $date3->d) + (($date3->i / 60) + $date3->h));
			$count = $count + 1;
		}

		if ($hours > 0 AND $count > 0)
		{
			$average = $hours / $count;

			if ($average < 1)
				$average = round(($average * 60), 2) . '<span>{$lang.minutes}</span>';
			else
				$average = round($average, 2) . '<span>{$lang.hours}</span>';
		}

		return $average;
	}

	public function get_voxes_count($option)
	{
		$where = [];

		if ($option == 'open' OR $option == 'close' OR $option == 'today' OR $option == 'week' OR $option == 'month' OR $option == 'year')
		{
			$where = [
				'AND' => [
					'account' => Session::get_value('account')['id'],
				]
			];

			if ($option == 'open' OR $option == 'close')
			{
				$where['AND']['started_date[<>]'] = [Session::get_value('settings')['voxes']['stats']['filter']['started_date'],Session::get_value('settings')['voxes']['stats']['filter']['end_date']];

				if ($option == 'open')
					$where['AND']['status'] = true;
				else if ($option == 'close')
					$where['AND']['status'] = false;
			}
			else if ($option == 'today')
				$where['AND']['started_date'] = Functions::get_current_date();
			else if ($option == 'week')
				$where['AND']['started_date[<>]'] = [Functions::get_current_week()[0],Functions::get_current_week()[1]];
			else if ($option == 'month')
				$where['AND']['started_date[<>]'] = [Functions::get_current_month()[0],Functions::get_current_month()[1]];
			else if ($option == 'year')
				$where['AND']['started_date[<>]'] = [Functions::get_current_year()[0],Functions::get_current_year()[1]];
		}
		else if ($option == 'total')
			$where['account'] = Session::get_value('account')['id'];

		$query = $this->database->count('voxes', $where);

		return $query;
	}

	public function get_chart_data($chart)
	{
		$where = [
			'AND' => [
				'account' => Session::get_value('account')['id'],
				'started_date[<>]' => [Session::get_value('settings')['voxes']['stats']['filter']['started_date'],Session::get_value('settings')['voxes']['stats']['filter']['end_date']]
			]
		];

		if ($chart == 'c_oa_chart' OR $chart == 'c_o_chart' OR $chart == 'c_l_chart')
			$where['AND']['type'] = 'incident';
		else if (Session::get_value('settings')['voxes']['stats']['filter']['type'] != 'all')
			$where['AND']['type'] = Session::get_value('settings')['voxes']['stats']['filter']['type'];

		$query1 = $this->database->select('voxes', [
			'owner',
			'opportunity_area',
			'location',
			'cost',
			'started_date',
			'started_hour',
			'completed_date',
			'completed_hour'
		], $where);

		if ($chart == 'v_oa_chart' OR $chart == 'ar_oa_chart' OR $chart == 'c_oa_chart')
		{
			$query2 = Functions::get_json_decoded_query($this->database->select('opportunity_areas', [
				'id',
				'name'
			], [
				'account' => Session::get_value('account')['id']
			]));
		}
		else if ($chart == 'v_o_chart' OR $chart == 'ar_o_chart' OR $chart == 'c_o_chart')
		{
			$query2 = Functions::get_json_decoded_query($this->database->select('owners', [
				'id',
				'name',
				'number'
			], [
				'account' => Session::get_value('account')['id']
			]));
		}
		else if ($chart == 'v_l_chart' OR $chart == 'ar_l_chart' OR $chart == 'c_l_chart')
		{
			$query2 = Functions::get_json_decoded_query($this->database->select('locations', [
				'id',
				'name'
			], [
				'account' => Session::get_value('account')['id']
			]));
		}

		$data = [
			'labels' => '',
			'datasets' => [
				'data' => '',
				'colors' => ''
			]
		];

		if ($chart == 'v_oa_chart' OR $chart == 'v_o_chart' OR $chart == 'v_l_chart')
		{
			if (!empty($query1) AND !empty($query2))
			{
				foreach ($query2 as $value)
				{
					$count = 0;
					$break = true;

					foreach ($query1 as $subvalue)
					{
						if ($chart == 'v_oa_chart')
						{
							if ($value['id'] == $subvalue['opportunity_area'])
							{
								$count = $count + 1;
								$break = false;
							}
						}
						else if ($chart == 'v_o_chart')
						{
							if ($value['id'] == $subvalue['owner'])
							{
								$count = $count + 1;
								$break = false;
							}
						}
						else if ($chart == 'v_l_chart')
						{
							if ($value['id'] == $subvalue['location'])
							{
								$count = $count + 1;
								$break = false;
							}
						}
					}

					if ($break == false)
					{
						if ($chart == 'v_oa_chart')
							$data['labels'] .= "'" . $value['name'][Session::get_value('account')['language']] . "',";
						else if ($chart == 'v_o_chart')
							$data['labels'] .= "'" . $value['name'][Session::get_value('account')['language']] . (!empty($value['number']) ? " #" . $value['number'] : '') . "',";
						else if ($chart == 'v_l_chart')
							$data['labels'] .= "'" . $value['name'][Session::get_value('account')['language']] . "',";

						$data['datasets']['data'] .= $count . ',';
						$data['datasets']['colors'] .= "'#" . str_pad(dechex(mt_rand(0, 255)), 2, '0', STR_PAD_LEFT) . str_pad(dechex(mt_rand(0, 255)), 2, '0', STR_PAD_LEFT) . str_pad(dechex(mt_rand(0, 255)), 2, '0', STR_PAD_LEFT) . "',";
					}
				}
			}
			else
			{
				$data['labels'] .= "'" . Languages::charts('empty')[Session::get_value('account')['language']] . "'";
				$data['datasets']['data'] .= '1';
				$data['datasets']['colors'] .= "'#eee'";
			}
		}

		if ($chart == 'ar_oa_chart' OR $chart == 'ar_o_chart' OR $chart == 'ar_l_chart')
		{
			if (!empty($query1) AND !empty($query2))
			{
				foreach ($query2 as $value)
				{
					$average = 0;
					$hours = 0;
					$count = 0;
					$break = true;

					foreach ($query1 as $subvalue)
					{
						if ($chart == 'ar_oa_chart')
						{
							if ($value['id'] == $subvalue['opportunity_area'])
							{
								$date1 = new DateTime($subvalue['started_date'] . ' ' . $subvalue['started_hour']);
								$date2 = new DateTime($subvalue['completed_date'] . ' ' . $subvalue['completed_hour']);
								$date3 = $date1->diff($date2);
								$hours = $hours + ((24 * $date3->d) + (($date3->i / 60) + $date3->h));
								$count = $count + 1;
								$break = false;
							}
						}
						else if ($chart == 'ar_o_chart')
						{
							if ($value['id'] == $subvalue['owner'])
							{
								$date1 = new DateTime($subvalue['started_date'] . ' ' . $subvalue['started_hour']);
								$date2 = new DateTime($subvalue['completed_date'] . ' ' . $subvalue['completed_hour']);
								$date3 = $date1->diff($date2);
								$hours = $hours + ((24 * $date3->d) + (($date3->i / 60) + $date3->h));
								$count = $count + 1;
								$break = false;
							}
						}
						else if ($chart == 'ar_l_chart')
						{
							if ($value['id'] == $subvalue['location'])
							{
								$date1 = new DateTime($subvalue['started_date'] . ' ' . $subvalue['started_hour']);
								$date2 = new DateTime($subvalue['completed_date'] . ' ' . $subvalue['completed_hour']);
								$date3 = $date1->diff($date2);
								$hours = $hours + ((24 * $date3->d) + (($date3->i / 60) + $date3->h));
								$count = $count + 1;
								$break = false;
							}
						}
					}

					$average = ($count > 0) ? $hours / $count : $average;

					if ($average < 1)
						$average = round(($average * 60), 2);
					else
						$average = round($average, 2);

					if ($break == false)
					{
						if ($chart == 'ar_oa_chart')
							$data['labels'] .= "'" . $value['name'][Session::get_value('account')['language']] . "',";
						else if ($chart == 'ar_o_chart')
							$data['labels'] .= "'" . $value['name'][Session::get_value('account')['language']] . (!empty($value['number']) ? " #" . $value['number'] : '') . "',";
						else if ($chart == 'ar_l_chart')
							$data['labels'] .= "'" . $value['name'][Session::get_value('account')['language']] . "',";

						$data['datasets']['data'] .= $average . ',';
						$data['datasets']['colors'] .= "'#" . str_pad(dechex(mt_rand(0, 255)), 2, '0', STR_PAD_LEFT) . str_pad(dechex(mt_rand(0, 255)), 2, '0', STR_PAD_LEFT) . str_pad(dechex(mt_rand(0, 255)), 2, '0', STR_PAD_LEFT) . "',";
					}
				}
			}
			else
			{
				$data['labels'] .= "'" . Languages::charts('empty')[Session::get_value('account')['language']] . "'";
				$data['datasets']['data'] .= '1';
				$data['datasets']['colors'] .= "'#eee'";
			}
		}

		if ($chart == 'c_oa_chart' OR $chart == 'c_o_chart' OR $chart == 'c_l_chart')
		{
			if (!empty($query1) AND !empty($query2))
			{
				foreach ($query2 as $value)
				{
					$cost = 0;
					$break = true;

					foreach ($query1 as $subvalue)
					{
						if ($chart == 'c_oa_chart')
						{
							if ($value['id'] == $subvalue['opportunity_area'])
							{
								$cost = !empty($subvalue['cost']) ? $cost + $subvalue['cost'] : $cost;
								$break = false;
							}
						}
						else if ($chart == 'c_o_chart')
						{
							if ($value['id'] == $subvalue['owner'])
							{
								$cost = !empty($subvalue['cost']) ? $cost + $subvalue['cost'] : $cost;
								$break = false;
							}
						}
						else if ($chart == 'c_l_chart')
						{
							if ($value['id'] == $subvalue['location'])
							{
								$cost = !empty($subvalue['cost']) ? $cost + $subvalue['cost'] : $cost;
								$break = false;
							}
						}
					}

					if ($break == false)
					{
						if ($chart == 'c_oa_chart')
							$data['labels'] .= "'" . $value['name'][Session::get_value('account')['language']] . "',";
						else if ($chart == 'c_o_chart')
							$data['labels'] .= "'" . $value['name'][Session::get_value('account')['language']] . (!empty($value['number']) ? " #" . $value['number'] : '') . "',";
						else if ($chart == 'c_l_chart')
							$data['labels'] .= "'" . $value['name'][Session::get_value('account')['language']] . "',";

						$data['datasets']['data'] .= $cost . ',';
						$data['datasets']['colors'] .= "'#" . str_pad(dechex(mt_rand(0, 255)), 2, '0', STR_PAD_LEFT) . str_pad(dechex(mt_rand(0, 255)), 2, '0', STR_PAD_LEFT) . str_pad(dechex(mt_rand(0, 255)), 2, '0', STR_PAD_LEFT) . "',";
					}
				}
			}
			else
			{
				$data['labels'] .= "'" . Languages::charts('empty')[Session::get_value('account')['language']] . "'";
				$data['datasets']['data'] .= '1';
				$data['datasets']['colors'] .= "'#eee'";
			}
		}

		return $data;
	}

	public function get_voxes_reports($option = 'all')
	{
		$reports = [];
		$where = [];

		if ($option == 'all')
			$where['account'] = Session::get_value('account')['id'];
		else if ($option == 'actives')
		{
			$where['AND'] = [
				'account' => Session::get_value('account')['id'],
				'status' => true
			];
		}

		$where['ORDER'] = [
			'name' => 'ASC'
		];

		$query = Functions::get_json_decoded_query($this->database->select('voxes_reports', [
			'id',
			'name',
			'type',
			'time_period',
			'addressed_to',
			'opportunity_areas',
			'user',
			'status'
		], $where));

		foreach ($query as $value)
		{
			$break = false;

			if ($value['addressed_to'] == 'opportunity_areas')
			{
				$count = 0;

				foreach (Session::get_value('user')['opportunity_areas'] as $subvalue)
				{
					if (in_array($subvalue, $value['opportunity_areas']))
						$count = $count + 1;
					else
						$break = true;
				}

				if ($count > 0)
					$break = false;
			}
			else if ($value['addressed_to'] == 'me' AND Session::get_value('user')['id'] != $value['user'])
				$break = true;

			if ($break == false)
				array_push($reports, $value);
		}

		return $reports;
	}

	public function get_vox_report($id)
	{
		$query = Functions::get_json_decoded_query($this->database->select('voxes_reports', [
			'name',
			'type',
			'opportunity_area',
			'opportunity_type',
			'owner',
			'location',
			'order',
			'time_period',
			'addressed_to',
			'opportunity_areas',
			'user',
			'fields'
		], [
			'id' => $id
		]));

		return !empty($query) ? $query[0] : null;
	}

	public function get_vox_report_fields($type = 'all')
	{
		if ($type == 'all')
		{
			if (Session::get_value('account')['type'] == 'hotel')
			{
				return [
					[
						'id' => 'type',
						'name' => 'type'
					],
					[
						'id' => 'owner',
						'name' => 'owner'
					],
					[
						'id' => 'opportunity_area',
						'name' => 'opportunity_area'
					],
					[
						'id' => 'opportunity_type',
						'name' => 'opportunity_type'
					],
					[
						'id' => 'date',
						'name' => 'date'
					],
					[
						'id' => 'location',
						'name' => 'location'
					],
					[
						'id' => 'cost',
						'name' => 'cost'
					],
					[
						'id' => 'urgency',
						'name' => 'urgency'
					],
					[
						'id' => 'confidentiality',
						'name' => 'confidentiality'
					],
					[
						'id' => 'assigned_users',
						'name' => 'assigned_users'
					],
					[
						'id' => 'observations',
						'name' => 'observations'
					],
					[
						'id' => 'subject',
						'name' => 'subject'
					],
					[
						'id' => 'description',
						'name' => 'description'
					],
					[
						'id' => 'action_taken',
						'name' => 'action_taken'
					],
					[
						'id' => 'name',
						'name' => 'name'
					],
					[
						'id' => 'guest_id',
						'name' => 'guest_id'
					],
					[
						'id' => 'guest_type',
						'name' => 'guest_type'
					],
					[
						'id' => 'reservation_number',
						'name' => 'reservation_number'
					],
					[
						'id' => 'reservation_status',
						'name' => 'reservation_status'
					],
					[
						'id' => 'staying',
						'name' => 'staying'
					],
					[
						'id' => 'attachments',
						'name' => 'attachments'
					],
					[
						'id' => 'viewed_by',
						'name' => 'viewed_by'
					],
					[
						'id' => 'comments',
						'name' => 'comments'
					],
					[
						'id' => 'created',
						'name' => 'created'
					],
					[
						'id' => 'edited',
						'name' => 'edited'
					],
					[
						'id' => 'completed',
						'name' => 'completed'
					],
					[
						'id' => 'reopened',
						'name' => 'reopened'
					],
					[
						'id' => 'status',
						'name' => 'status'
					],
					[
						'id' => 'origin',
						'name' => 'origin'
					],
					[
						'id' => 'average_resolution',
						'name' => 'average_resolution'
					]
				];
			}
			else
			{
				return [
					[
						'id' => 'type',
						'name' => 'type'
					],
					[
						'id' => 'owner',
						'name' => 'owner'
					],
					[
						'id' => 'opportunity_area',
						'name' => 'opportunity_area'
					],
					[
						'id' => 'opportunity_type',
						'name' => 'opportunity_type'
					],
					[
						'id' => 'date',
						'name' => 'date'
					],
					[
						'id' => 'location',
						'name' => 'location'
					],
					[
						'id' => 'cost',
						'name' => 'cost'
					],
					[
						'id' => 'urgency',
						'name' => 'urgency'
					],
					[
						'id' => 'confidentiality',
						'name' => 'confidentiality'
					],
					[
						'id' => 'assigned_users',
						'name' => 'assigned_users'
					],
					[
						'id' => 'observations',
						'name' => 'observations'
					],
					[
						'id' => 'subject',
						'name' => 'subject'
					],
					[
						'id' => 'description',
						'name' => 'description'
					],
					[
						'id' => 'action_taken',
						'name' => 'action_taken'
					],
					[
						'id' => 'name',
						'name' => 'name'
					],
					[
						'id' => 'attachments',
						'name' => 'attachments'
					],
					[
						'id' => 'viewed_by',
						'name' => 'viewed_by'
					],
					[
						'id' => 'comments',
						'name' => 'comments'
					],
					[
						'id' => 'created',
						'name' => 'created'
					],
					[
						'id' => 'edited',
						'name' => 'edited'
					],
					[
						'id' => 'completed',
						'name' => 'completed'
					],
					[
						'id' => 'reopened',
						'name' => 'reopened'
					],
					[
						'id' => 'status',
						'name' => 'status'
					],
					[
						'id' => 'origin',
						'name' => 'origin'
					],
					[
						'id' => 'average_resolution',
						'name' => 'average_resolution'
					]
				];
			}
		}
		else if ($type == 'request')
		{
			if (Session::get_value('account')['type'] == 'hotel')
			{
				return [
					[
						'id' => 'owner',
						'name' => 'owner'
					],
					[
						'id' => 'opportunity_area',
						'name' => 'opportunity_area'
					],
					[
						'id' => 'opportunity_type',
						'name' => 'opportunity_type'
					],
					[
						'id' => 'date',
						'name' => 'date'
					],
					[
						'id' => 'location',
						'name' => 'location'
					],
					[
						'id' => 'urgency',
						'name' => 'urgency'
					],
					[
						'id' => 'assigned_users',
						'name' => 'assigned_users'
					],
					[
						'id' => 'observations',
						'name' => 'observations'
					],
					[
						'id' => 'name',
						'name' => 'name'
					],
					[
						'id' => 'attachments',
						'name' => 'attachments'
					],
					[
						'id' => 'viewed_by',
						'name' => 'viewed_by'
					],
					[
						'id' => 'comments',
						'name' => 'comments'
					],
					[
						'id' => 'created',
						'name' => 'created'
					],
					[
						'id' => 'edited',
						'name' => 'edited'
					],
					[
						'id' => 'completed',
						'name' => 'completed'
					],
					[
						'id' => 'reopened',
						'name' => 'reopened'
					],
					[
						'id' => 'status',
						'name' => 'status'
					],
					[
						'id' => 'origin',
						'name' => 'origin'
					],
					[
						'id' => 'average_resolution',
						'name' => 'average_resolution'
					]
				];
			}
			else
			{
				return [
					[
						'id' => 'owner',
						'name' => 'owner'
					],
					[
						'id' => 'opportunity_area',
						'name' => 'opportunity_area'
					],
					[
						'id' => 'opportunity_type',
						'name' => 'opportunity_type'
					],
					[
						'id' => 'date',
						'name' => 'date'
					],
					[
						'id' => 'location',
						'name' => 'location'
					],
					[
						'id' => 'urgency',
						'name' => 'urgency'
					],
					[
						'id' => 'assigned_users',
						'name' => 'assigned_users'
					],
					[
						'id' => 'observations',
						'name' => 'observations'
					],
					[
						'id' => 'name',
						'name' => 'name'
					],
					[
						'id' => 'attachments',
						'name' => 'attachments'
					],
					[
						'id' => 'viewed_by',
						'name' => 'viewed_by'
					],
					[
						'id' => 'comments',
						'name' => 'comments'
					],
					[
						'id' => 'created',
						'name' => 'created'
					],
					[
						'id' => 'edited',
						'name' => 'edited'
					],
					[
						'id' => 'completed',
						'name' => 'completed'
					],
					[
						'id' => 'reopened',
						'name' => 'reopened'
					],
					[
						'id' => 'status',
						'name' => 'status'
					],
					[
						'id' => 'origin',
						'name' => 'origin'
					],
					[
						'id' => 'average_resolution',
						'name' => 'average_resolution'
					]
				];
			}
		}
		else if ($type == 'incident')
		{
			if (Session::get_value('account')['type'] == 'hotel')
			{
				return [
					[
						'id' => 'owner',
						'name' => 'owner'
					],
					[
						'id' => 'opportunity_area',
						'name' => 'opportunity_area'
					],
					[
						'id' => 'opportunity_type',
						'name' => 'opportunity_type'
					],
					[
						'id' => 'date',
						'name' => 'date'
					],
					[
						'id' => 'location',
						'name' => 'location'
					],
					[
						'id' => 'cost',
						'name' => 'cost'
					],
					[
						'id' => 'urgency',
						'name' => 'urgency'
					],
					[
						'id' => 'confidentiality',
						'name' => 'confidentiality'
					],
					[
						'id' => 'assigned_users',
						'name' => 'assigned_users'
					],
					[
						'id' => 'subject',
						'name' => 'subject'
					],
					[
						'id' => 'description',
						'name' => 'description'
					],
					[
						'id' => 'action_taken',
						'name' => 'action_taken'
					],
					[
						'id' => 'name',
						'name' => 'name'
					],
					[
						'id' => 'guest_id',
						'name' => 'guest_id'
					],
					[
						'id' => 'guest_type',
						'name' => 'guest_type'
					],
					[
						'id' => 'reservation_number',
						'name' => 'reservation_number'
					],
					[
						'id' => 'reservation_status',
						'name' => 'reservation_status'
					],
					[
						'id' => 'staying',
						'name' => 'staying'
					],
					[
						'id' => 'attachments',
						'name' => 'attachments'
					],
					[
						'id' => 'viewed_by',
						'name' => 'viewed_by'
					],
					[
						'id' => 'comments',
						'name' => 'comments'
					],
					[
						'id' => 'created',
						'name' => 'created'
					],
					[
						'id' => 'edited',
						'name' => 'edited'
					],
					[
						'id' => 'completed',
						'name' => 'completed'
					],
					[
						'id' => 'reopened',
						'name' => 'reopened'
					],
					[
						'id' => 'status',
						'name' => 'status'
					],
					[
						'id' => 'origin',
						'name' => 'origin'
					],
					[
						'id' => 'average_resolution',
						'name' => 'average_resolution'
					]
				];
			}
			else
			{
				return [
					[
						'id' => 'owner',
						'name' => 'owner'
					],
					[
						'id' => 'opportunity_area',
						'name' => 'opportunity_area'
					],
					[
						'id' => 'opportunity_type',
						'name' => 'opportunity_type'
					],
					[
						'id' => 'date',
						'name' => 'date'
					],
					[
						'id' => 'location',
						'name' => 'location'
					],
					[
						'id' => 'cost',
						'name' => 'cost'
					],
					[
						'id' => 'urgency',
						'name' => 'urgency'
					],
					[
						'id' => 'confidentiality',
						'name' => 'confidentiality'
					],
					[
						'id' => 'assigned_users',
						'name' => 'assigned_users'
					],
					[
						'id' => 'subject',
						'name' => 'subject'
					],
					[
						'id' => 'description',
						'name' => 'description'
					],
					[
						'id' => 'action_taken',
						'name' => 'action_taken'
					],
					[
						'id' => 'name',
						'name' => 'name'
					],
					[
						'id' => 'attachments',
						'name' => 'attachments'
					],
					[
						'id' => 'viewed_by',
						'name' => 'viewed_by'
					],
					[
						'id' => 'comments',
						'name' => 'comments'
					],
					[
						'id' => 'created',
						'name' => 'created'
					],
					[
						'id' => 'edited',
						'name' => 'edited'
					],
					[
						'id' => 'completed',
						'name' => 'completed'
					],
					[
						'id' => 'reopened',
						'name' => 'reopened'
					],
					[
						'id' => 'status',
						'name' => 'status'
					],
					[
						'id' => 'origin',
						'name' => 'origin'
					],
					[
						'id' => 'average_resolution',
						'name' => 'average_resolution'
					]
				];
			}
		}
		else if ($type == 'workorder')
		{
			return [
				[
					'id' => 'owner',
					'name' => 'owner'
				],
				[
					'id' => 'opportunity_area',
					'name' => 'opportunity_area'
				],
				[
					'id' => 'opportunity_type',
					'name' => 'opportunity_type'
				],
				[
					'id' => 'date',
					'name' => 'date'
				],
				[
					'id' => 'location',
					'name' => 'location'
				],
				[
					'id' => 'urgency',
					'name' => 'urgency'
				],
				[
					'id' => 'assigned_users',
					'name' => 'assigned_users'
				],
				[
					'id' => 'observations',
					'name' => 'observations'
				],
				[
					'id' => 'attachments',
					'name' => 'attachments'
				],
				[
					'id' => 'viewed_by',
					'name' => 'viewed_by'
				],
				[
					'id' => 'comments',
					'name' => 'comments'
				],
				[
					'id' => 'created',
					'name' => 'created'
				],
				[
					'id' => 'edited',
					'name' => 'edited'
				],
				[
					'id' => 'completed',
					'name' => 'completed'
				],
				[
					'id' => 'reopened',
					'name' => 'reopened'
				],
				[
					'id' => 'status',
					'name' => 'status'
				],
				[
					'id' => 'origin',
					'name' => 'origin'
				],
				[
					'id' => 'average_resolution',
					'name' => 'average_resolution'
				]
			];
		}
	}

	public function new_vox_report($data)
	{
		$query = $this->database->insert('voxes_reports', [
			'account' => Session::get_value('account')['id'],
			'name' => $data['name'],
			'type' => $data['type'],
			'opportunity_area' => !empty($data['opportunity_area']) ? $data['opportunity_area'] : null,
			'opportunity_type' => !empty($data['opportunity_type']) ? $data['opportunity_type'] : null,
			'owner' => !empty($data['owner']) ? $data['owner'] : null,
			'location' => !empty($data['location']) ? $data['location'] : null,
			'order' => $data['order'],
			'time_period' => json_encode([
				'type' => $data['time_period_type'],
				'number' => $data['time_period_number']
			]),
			'addressed_to' => $data['addressed_to'],
			'opportunity_areas' => json_encode(($data['addressed_to'] == 'opportunity_areas') ? $data['opportunity_areas'] : []),
			'user' => ($data['addressed_to'] == 'me') ? Session::get_value('user')['id'] : null,
			'fields' => json_encode($data['fields']),
			'status' => true
		]);

		return $query;
	}

	public function edit_vox_report($data)
	{
		$query = $this->database->update('voxes_reports', [
			'name' => $data['name'],
			'type' => $data['type'],
			'opportunity_area' => !empty($data['opportunity_area']) ? $data['opportunity_area'] : null,
			'opportunity_type' => !empty($data['opportunity_type']) ? $data['opportunity_type'] : null,
			'owner' => !empty($data['owner']) ? $data['owner'] : null,
			'location' => !empty($data['location']) ? $data['location'] : null,
			'order' => $data['order'],
			'time_period' => json_encode([
				'type' => $data['time_period_type'],
				'number' => $data['time_period_number']
			]),
			'addressed_to' => $data['addressed_to'],
			'opportunity_areas' => json_encode(($data['addressed_to'] == 'opportunity_areas') ? $data['opportunity_areas'] : []),
			'user' => ($data['addressed_to'] == 'me') ? Session::get_value('user')['id'] : null,
			'fields' => json_encode($data['fields'])
		], [
			'id' => $data['id']
		]);

		return $query;
	}

	public function deactivate_vox_report($id)
	{
		$query = $this->database->update('voxes_reports', [
			'status' => false
		], [
			'id' => $id
		]);

		return $query;
	}

	public function activate_vox_report($id)
	{
		$query = $this->database->update('voxes_reports', [
			'status' => true
		], [
			'id' => $id
		]);

		return $query;
	}

	public function delete_vox_report($id)
	{
		$query = $this->database->delete('voxes_reports', [
			'id' => $id
		]);

		return $query;
	}
}
