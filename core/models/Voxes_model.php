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

		if (Functions::check_user_access(['{view_opportunity_areas}']) == true)
			$where['AND']['opportunity_area'] = Session::get_value('user')['opportunity_areas'];
		else if (Functions::check_user_access(['{view_own}']) == true)
			$where['AND']['created_user'] = Session::get_value('user')['id'];

		if (Functions::check_user_access(['{view_confidentiality}']) == false)
			$where['AND']['confidentiality'] = false;

		// - Condición para cargar un vox si el usuario está asignado a el.

		if ($option == 'all')
		{
			$fields = [
				'id',
				'type',
				'owner',
				'opportunity_area',
				'opportunity_type',
				'started_date',
				'started_hour',
				'location',
				'urgency',
				'confidentiality',
				'assigned_users',
				'firstname',
				'lastname',
				'attachments',
				'comments',
				'created_user',
				'status',
				'origin'
			];

			$where['ORDER'] = [
				'id' => 'DESC'
			];
		}
		else if ($option == 'report')
		{
			$fields = [
				'type',
				'token',
				'owner',
				'opportunity_area',
				'opportunity_type',
				'started_date',
				'started_hour',
				'location',
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
				'edited_user',
				'completed_user',
				'reopened_user',
				'created_date',
				'created_hour',
				'edited_date',
				'edited_hour',
				'completed_date',
				'completed_hour',
				'reopened_date',
				'reopened_hour',
				'status',
				'origin'
			];

			if ($data['type'] != 'all')
				$where['AND']['type'] = $data['type'];

			if ($data['owner'] != 'all')
				$where['AND']['owner'] = $data['owner'];

			if ($data['opportunity_area'] != 'all')
				$where['AND']['opportunity_area'] = $data['opportunity_area'];

			if ($data['opportunity_type'] != 'all')
				$where['AND']['opportunity_type'] = $data['opportunity_type'];

			if ($data['location'] != 'all')
				$where['AND']['location'] = $data['location'];

			$where['AND']['OR']['started_date[<]'] = $data['started_date']; // - Revisar formatos de fecha
			$where['AND']['OR']['started_date[>]'] = $data['end_date']; // - Revisar formatos de fecha

			if ($data['type'] == 'all' OR $data['type'] == 'workorder')
			{
				$where['ORDER']['started_date'] = 'DESC';
				$where['ORDER']['started_hour'] = 'DESC';
			}
			else if ($data['type'] == 'request' OR $data['type'] == 'incident')
			{
				if ($data['order'] == 'owner')
					$where['ORDER']['owner'] => 'ASC';
				else if ($data['order'] == 'guest')
				{
					$where['ORDER']['firstname'] => 'ASC';
					$where['ORDER']['lastname'] => 'ASC';
				}
			}
		}

		$query = Functions::get_json_decoded_query($this->database->select('voxes', $fields, $where));

		foreach ($query as $key => $value)
		{
			$query[$key]['owner'] = $this->get_owner($value['owner']);
			$query[$key]['opportunity_area'] = $this->get_opportunity_area($value['opportunity_area']);
			$query[$key]['opportunity_type'] = $this->get_opportunity_type($value['opportunity_type']);
			$query[$key]['location'] = $this->get_location($value['location']);
			$query[$key]['created_user'] = $this->get_user($value['created_user']);

			if ($option == 'all')
			{
				foreach ($value['comments'] as $subvalue)
					$query[$key]['attachments'] = array_merge($value['attachments'], $subvalue['attachments']);
			}
			else if ($option == 'report')
			{
				foreach ($value['assigned_users'] as $subkey => $subvalue)
					$query[$key]['assigned_users'][$subkey] = $this->get_user($subvalue);

				if (Session::get_value('account')['type'] == 'hotel')
				{
					if ($value['type'] == 'request' OR $value['type'] == 'incident')
						$query[$key]['guest_treatment'] = $this->get_guest_treatment($value['guest_treatment']);

					if ($value['type'] == 'incident')
					{
						$query[$key]['guest_type'] = $this->get_guest_type($value['guest_type']);
						$query[$key]['reservation_status'] = $this->get_reservation_status($value['reservation_status']);
					}
				}

				foreach ($value['viewed_by'] as $subkey => $subvalue)
					$query[$key]['viewed_by'][$subkey] = $this->get_user($subvalue);

				foreach ($value['comments'] as $subkey => $subvalue)
					$query[$key]['comments'][$subkey]['user'] = $this->get_user($subvalue['user']);

				$query[$key]['edited_user'] = $this->get_user($value['edited_user']);
				$query[$key]['completed_user'] = $this->get_user($value['completed_user']);
				$query[$key]['reopened_user'] = $this->get_user($value['reopened_user']);
			}
		}

		return $query;
	}

	public function get_vox($id, $fks = false)
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
			'changes_history',
			'created_user',
			'edited_user',
			'completed_user',
			'reopened_user',
			'created_date',
			'created_hour',
			'edited_date',
			'edited_hour',
			'completed_date',
			'completed_hour',
			'reopened_date',
			'reopened_hour',
			'status',
			'origin'
		], [
			'id' => $id
		]));

		if (!empty($query))
		{
			if ($query[0]['status'] == 'open')
			{
				if (in_array(Session::get_value('user')['id'], $query[0]['viewed_by']))
				{
					foreach ($query[0]['changes_history'] as $key => $value)
					{
						if ($value['type'] == 'viewed' AND $value['user'] == Session::get_value('user')['id'])
						{
							$query[0]['changes_history'][$key]['date'] = Functions::get_current_date();
							$query[0]['changes_history'][$key]['hour'] = Functions::get_current_hour();
						}
					}
				}
				else
				{
					array_push($query[0]['viewed_by'], Session::get_value('user')['id']);

					array_push($query[0]['changes_history'], [
						'type' => 'viewed',
						'user' => Session::get_value('user')['id'],
						'date' => Functions::get_current_date(),
						'hour' => Functions::get_current_hour()
					]);
				}

				$this->database->update('voxes', [
					'viewed_by' => json_encode($query[0]['viewed_by']),
					'changes_history' => json_encode($query[0]['changes_history'])
				], [
					'id' => $id
				]);
			}

			if ($fks == true)
			{
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

				foreach ($query[0]['comments'] as $key => $value)
					$query[0]['comments'][$key]['user'] = $this->get_user($value['user']);

				foreach ($query[0]['data']['changes_history'] as $key => $value)
					$query[0]['changes_history'][$key]['user'] = $this->get_user($value['user']);

				$query[0]['created_user'] = $this->get_user($query[0]['created_user']); // - En changes_history (create) y created_user está el problema de que cuando el vox se creó desde myvox, no se guardá ningún id.
				$query[0]['edited_user'] = $this->get_user($query[0]['edited_user']);
				$query[0]['completed_user'] = $this->get_user($query[0]['completed_user']);
				$query[0]['reopened_user'] = $this->get_user($query[0]['reopened_user']);
			}

			return $query[0];
		}
		else
			return null;
	}

	public function get_owners($type = 'all')
	{
		if ($type == 'all')
		{
			$where = [
				'account' => Session::get_value('account')['id']
			];
		}
		else
		{
			$where = [
				'AND' => [
					'account' => Session::get_value('account')['id'],
					$type => true
				]
			];
		}

		$where['ORDER'] = [
			'number' => 'ASC',
			'name' => 'ASC'
		];

		$query = Functions::get_json_decoded_query($this->database->select('owners', [
			'id',
			'name',
			'number'
		], $where));

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

	public function get_reservation($number = null)
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

			if ($guest['status'] == 'success')
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

	public function get_opportunity_areas($type = 'all')
	{
		if ($type == 'all')
		{
			$where = [
				'account' => Session::get_value('account')['id']
			];
		}
		else
		{
			$where = [
				'AND' => [
					'account' => Session::get_value('account')['id'],
					$type => true
				]
			];
		}

		$where['ORDER'] = [
			'name' => 'ASC'
		];

		$query = Functions::get_json_decoded_query($this->database->select('opportunity_areas', [
			'id',
			'name'
		], $where));

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

	public function get_opportunity_types($opportunity_area, $type = 'all')
	{
		if ($type == 'all')
		{
			$where = [
				'opportunity_area' => $opportunity_area
			];
		}
		else
		{
			$where = [
				'AND' => [
					'opportunity_area' => $opportunity_area,
					$type => true
				]
			];
		}

		$where['ORDER'] = [
			'name' => 'ASC'
		];

		$query = Functions::get_json_decoded_query($this->database->select('opportunity_types', [
			'id',
			'name'
		], $where));

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
		if ($type == 'all')
		{
			$where = [
				'account' => Session::get_value('account')['id']
			];
		}
		else
		{
			$where = [
				'AND' => [
					'account' => Session::get_value('account')['id'],
					$type => true
				]
			];
		}

		$where['ORDER'] = [
			'name' => 'ASC'
		];

		$query = Functions::get_json_decoded_query($this->database->select('locations', [
			'id',
			'name'
		], $where));

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

	public function get_guest_treatments()
	{
		$query = $this->database->select('guest_treatments', [
			'id',
			'name'
		], [
			'account' => Session::get_value('account')['id'],
			'ORDER' => [
				'name' => 'ASC'
			]
		]);

		return $query;
	}

	public function get_guest_treatment($id)
	{
		$query = $this->database->select('guest_treatments', [
			'id',
			'name'
		], [
			'id' => $id
		]);

		return !empty($query) ? $query[0] : null;
	}

	public function get_guest_types()
	{
		$query = $this->database->select('guest_types', [
			'id',
			'name'
		], [
			'account' => Session::get_value('account')['id'],
			'ORDER' => [
				'name' => 'ASC'
			]
		]);

		return $query;
	}

	public function get_guest_type($id)
	{
		$query = $this->database->select('guest_types', [
			'id',
			'name'
		], [
			'id' => $id
		]);

		return !empty($query) ? $query[0] : null;
	}

	public function get_reservation_statuses()
	{
		$query = $this->database->select('reservation_statuses', [
			'id',
			'name'
		], [
			'account' => Session::get_value('account')['id'],
			'ORDER' => [
				'name' => 'ASC'
			]
		]);

		return $query;
	}

	public function get_reservation_status($id)
	{
		$query = $this->database->select('reservation_statuses', [
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
			'account' => Session::get_value('account')['id'],
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
			'avatar'
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

					$_com_uploader->SetFileName($data['attachments']['name'][$key]);
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
			'cost' => ($data['type'] == 'incident' OR $data['type'] == 'workorder') ? $data['cost'] : null,
			'urgency' => $data['urgency'],
			'confidentiality' => ($data['type'] == 'incident' AND !empty($data['confidentiality'])) ? true : false,
			'assigned_users' => json_encode((!empty($data['assigned_users']) ? $data['assigned_users'] : [])),
			'observations' => ($data['type'] == 'request' OR $data['type'] == 'workorder') ? $data['observations'] : null,
			'subject' => ($data['type'] == 'incident') ? $data['subject'] : null,
			'description' => ($data['type'] == 'incident') ? $data['description'] : null,
			'action_taken' => ($data['type'] == 'incident') ? $data['action_taken'] : null,
			'guest_treatment' => (($data['type'] == 'request' OR $data['type'] == 'incident') AND Session::get_value('account')['type'] == 'hotel') ? null : null,
			'firstname' => ($data['type'] == 'request' OR $data['type'] == 'incident') ? $data['firstname'] : null,
			'lastname' => ($data['type'] == 'request' OR $data['type'] == 'incident') ? $data['lastname'] : null,
			'guest_id' => ($data['type'] == 'incident' AND Session::get_value('account')['type'] == 'hotel') ? $data['guest_id'] : null,
			'guest_type' => ($data['type'] == 'incident' AND Session::get_value('account')['type'] == 'hotel') ? $data['guest_type'] : null,
			'reservation_number' => ($data['type'] == 'incident' AND Session::get_value('account')['type'] == 'hotel') ? $data['reservation_number'] : null,
			'reservation_status' => ($data['type'] == 'incident' AND Session::get_value('account')['type'] == 'hotel') ? $data['reservation_status'] : null,
			'check_in' => ($data['type'] == 'incident' AND Session::get_value('account')['type'] == 'hotel') ? $data['check_in'] : null,
			'check_out' => ($data['type'] == 'incident' AND Session::get_value('account')['type'] == 'hotel') ? $data['check_out'] : null,
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
			'origin' => 'internal'
		]);

		return !empty($query) ? $this->database->id() : null;
	}

	public function edit_vox($data)
	{
		$query = null;
		$editer = $this->get_vox($data['id']);

		if (!empty($editer))
		{
			if (!empty($data['assigned_users']))
			{
				$data['assigned_users'] = array_merge($editer['assigned_users'], $data['assigned_users']);
				$data['assigned_users'] = array_unique($data['assigned_users']);
				$data['assigned_users'] = array_values($data['assigned_users']);
			}
			else
				$data['assigned_users'] = $editer['assigned_users'];

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

						$_com_uploader->SetFileName($data['attachments']['name'][$key]);
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
				if ($editer['confidentiality'] != $data['confidentiality'])
				{
					array_push($data['changes_history'][0]['fields'], [
						'field' => 'confidentiality',
						'before' => $editer['confidentiality'],
						'after' => $data['confidentiality']
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

			if ($data['type'] == 'request' OR $data['type'] == 'incident')
			{
				if (Session::get_value('account')['type'] == 'hotel')
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

			if ($data['type'] == 'incident')
			{
				if (Session::get_value('account')['type'] == 'hotel')
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
				'cost' => ($data['type'] == 'incident' OR $data['type'] == 'workorder') ? $data['cost'] : null,
				'urgency' => $data['urgency'],
				'confidentiality' => ($data['type'] == 'incident' AND !empty($data['confidentiality'])) ? true : false,
				'assigned_users' => json_encode((!empty($data['assigned_users']) ? $data['assigned_users'] : [])),
				'observations' => ($data['type'] == 'request' OR $data['type'] == 'workorder') ? $data['observations'] : null,
				'subject' => ($data['type'] == 'incident') ? $data['subject'] : null,
				'description' => ($data['type'] == 'incident') ? $data['description'] : null,
				'action_taken' => ($data['type'] == 'incident') ? $data['action_taken'] : null,
				'guest_treatment' => (($data['type'] == 'request' OR $data['type'] == 'incident') AND Session::get_value('account')['type'] == 'hotel') ? $data['guest_treatment'] : null,
				'firstname' => ($data['type'] == 'request' OR $data['type'] == 'incident') ? $data['firstname'] : null,
				'lastname' => ($data['type'] == 'request' OR $data['type'] == 'incident') ? $data['lastname'] : null,
				'guest_id' => ($data['type'] == 'incident' AND Session::get_value('account')['type'] == 'hotel') ? $data['guest_id'] : null,
				'guest_type' => ($data['type'] == 'incident' AND Session::get_value('account')['type'] == 'hotel') ? $data['guest_type'] : null,
				'reservation_number' => ($data['type'] == 'incident' AND Session::get_value('account')['type'] == 'hotel') ? $data['reservation_number'] : null,
				'reservation_status' => ($data['type'] == 'incident' AND Session::get_value('account')['type'] == 'hotel') ? $data['reservation_status'] : null,
				'check_in' => ($data['type'] == 'incident' AND Session::get_value('account')['type'] == 'hotel') ? $data['check_in'] : null,
				'check_out' => ($data['type'] == 'incident' AND Session::get_value('account')['type'] == 'hotel') ? $data['check_out'] : null,
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

		$editer = $this->database->select('voxes', [
			'type',
			'cost',
			'comments',
			'changes_history'
		], [
			'id' => $id
		]);

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

						$_com_uploader->SetFileName($data['attachments']['name'][$key]);
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

			if ($editer[0]['type'] == 'incident' OR $editer[0]['type'] == 'workorder')
				$editer[0]['cost'] = (!empty($editer[0]['cost']) ? $editer[0]['cost'] : 0) + (!empty($data['cost']) ? $data['cost'] : 0);

			array_push($editer[0]['comments'], [
				'user' => Session::get_value('user')['id'],
				'date' => Functions::get_current_date(),
				'hour' => Functions::get_current_hour(),
				'cost' => $data['cost'],
				'message' => $data['response_to'] . ' ' . $data['message'],
				'attachments' => !empty($data['attachments']) ? $data['attachments'] : []
			]);

			array_push($editer[0]['changes_history'], [
				'type' => 'commented',
				'user' => Session::get_value('user')['id'],
				'date' => Functions::get_current_date(),
				'hour' => Functions::get_current_hour()
			]);

			$query = $this->database->update('voxes', [
				'cost' => $editer[0]['cost'],
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

		$editer = $this->database->select('voxes', [
			'changes_history'
		], [
			'id' => $id
		]);

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
				'status' => 'close'
			], [
				'id' => $id
			]);
		}

		return $query;
	}

	public function reopen_vox($id)
	{
		$query = null;

		$editer = $this->database->select('voxes', [
			'changes_history'
		], [
			'id' => $id
		]);

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
				'status' => 'open'
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

	public function get_voxes_reports()
	{
		$reports = [];

		$query = Functions::get_json_decoded_query($this->database->select('voxes_reports', [
			'id',
			'name',
			'addressed_to',
			'opportunity_areas',
			'user'
		], [
			'account' => Session::get_value('account')['id'],
			'ORDER' => [
				'name' => 'ASC'
			]
		]));

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

	public function get_vox_report($option, $id)
	{
		$query = Functions::get_json_decoded_query($this->database->select('voxes_reports', [
			'id',
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
						'id' => 'guest_treatment',
						'name' => 'guest_treatment'
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
						'id' => 'guest_treatment',
						'name' => 'guest_treatment'
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
						'id' => 'guest_treatment',
						'name' => 'guest_treatment'
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
			'opportunity_area' => $data['opportunity_area'],
			'opportunity_type' => $data['opportunity_type'],
			'owner' => $data['owner'],
			'location' => $data['location'],
			'order' => $data['order'],
			'time_period' => $data['time_period'],
			'addressed_to' => $data['addressed_to'],
			'opportunity_areas' => json_encode(($data['addressed_to'] == 'opportunity_areas') ? $data['opportunity_areas'] : []),
			'user' => ($data['addressed_to'] == 'me') ? Session::get_value('user')['id'] : null,
			'fields' => json_encode($data['fields'])
		]);

		return $query;
	}

	public function edit_vox_report($data)
	{
		$query = $this->database->update('voxes_reports', [
			'name' => $data['name'],
			'type' => $data['type'],
			'opportunity_area' => $data['opportunity_area'],
			'opportunity_type' => $data['opportunity_type'],
			'owner' => $data['owner'],
			'location' => $data['location'],
			'order' => $data['order'],
			'time_period' => $data['time_period'],
			'addressed_to' => $data['addressed_to'],
			'opportunity_areas' => json_encode(($data['addressed_to'] == 'opportunity_areas') ? $data['opportunity_areas'] : []),
			'user' => ($data['addressed_to'] == 'me') ? Session::get_value('user')['id'] : null,
			'fields' => json_encode($data['fields'])
		], [
			'id' => $data['id']
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

	public function get_voxes_average_resolution()
	{
		$query = $this->database->select('voxes', [
			'started_date',
			'started_hour',
			'completed_date',
			'completed_hour'
		], [
			'AND' => [
				'account' => Session::get_value('account')['id'],
				'started_date[>=]' => Functions::get_current_date(),
				'started_hour[>=]' => Functions::get_current_hour()
			]
		]);

		$hours = 0;
		$count = 0;
		$average = 0;

		foreach ($query as $key => $value)
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
				$average = round(($average * 60), 2) . ' Min';
			else
				$average = round($average, 2) . ' Hrs';
		}

		return $average;
	}

	public function get_voxes_count($option)
	{
		$where = [
			'AND' => [
				'account' => Session::get_value('account')['id']
			]
		];

		if ($option == 'today')
			$where['AND']['started_date'] = Functions::get_current_date(); // - Revisar formatos de fecha
		else if ($option == 'week')
			$where['AND']['started_date[<>]'] = [Functions::get_current_week()[0],Functions::get_current_week()[1]]; // - Revisar formatos de fecha
		else if ($option == 'month')
			$where['AND']['started_date[<>]'] = [Functions::get_current_month()[0],Functions::get_current_month()[1]]; // - Revisar formatos de fecha
		else if ($option == 'year')
			$where['AND']['started_date[<>]'] = [Functions::get_current_year()[0],Functions::get_current_year()[1]]; // - Revisar formatos de fecha

		$query = $this->database->count('voxes', $where);

		return $query;
	}

	public function get_chart_data($chart, $params, $edit = false)
	{
		$where = [
			'AND' => [
				'account' => Session::get_value('account')['id'],
				'started_date[<>]' => [$params['started_date'],$params['date_end']] // - Revisar formatos de fecha
			]
		];

		if ($chart == 'c_oa_chart' OR $chart == 'c_o_chart' OR $chart == 'c_l_chart')
			$where['AND']['type'] = 'incident';
		else if ($params['type'] != 'all')
			$where['AND']['type'] = $params['type'];

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

		if ($edit == true)
		{
			$data = [
				'labels' => [],
				'datasets' => [
					'data' => [],
					'colors' => []
				]
			];
		}
		else
		{
			$data = [
				'labels' => '',
				'datasets' => [
					'data' => '',
					'colors' => ''
				]
			];
		}

		foreach ($query2 as $value)
		{
			if ($chart == 'v_oa_chart' OR $chart == 'v_o_chart' OR $chart == 'v_l_chart')
			{
				$count = 0;

				foreach ($query1 as $subvalue)
				{
					if ($chart == 'v_oa_chart')
					{
						if ($value['id'] == $subvalue['opportunity_area'])
							$count = $count + 1;
					}
					else if ($chart == 'v_o_chart')
					{
						if ($value['id'] == $subvalue['owner'])
							$count = $count + 1;
					}
					else if ($chart == 'v_l_chart')
					{
						if ($value['id'] == $subvalue['location'])
							$count = $count + 1;
					}
				}

				if ($edit == true)
				{
					if ($chart == 'v_oa_chart')
						array_push($data['labels'], $value['name'][Session::get_value('account')['language']]);
					else if ($chart == 'v_o_chart')
						array_push($data['labels'], $value['name'] . (!empty($value['number']) ? ' #' . $value['number'] : ''));
					else if ($chart == 'v_l_chart')
						array_push($data['labels'], $value['name'][Session::get_value('account')['language']]);

					array_push($data['datasets']['data'], $count);
					array_push($data['datasets']['colors'], "#" . str_pad(dechex(mt_rand(0, 255)), 2, '0', STR_PAD_LEFT) . str_pad(dechex(mt_rand(0, 255)), 2, '0', STR_PAD_LEFT) . str_pad(dechex(mt_rand(0, 255)), 2, '0', STR_PAD_LEFT));
				}
				else
				{
					if ($chart == 'v_oa_chart')
						$data['labels'] .= "'" . $value['name'][Session::get_value('account')['language']] . "',";
					else if ($chart == 'v_o_chart')
						$data['labels'] .= "'" . $value['name'] . (!empty($value['number']) ? " #" . $value['number'] : '') . "',";
					else if ($chart == 'v_l_chart')
						$data['labels'] .= "'" . $value['name'][Session::get_value('account')['language']] . "',";

					$data['datasets']['data'] .= $count . ',';
					$data['datasets']['colors'] .= "'#" . str_pad(dechex(mt_rand(0, 255)), 2, '0', STR_PAD_LEFT) . str_pad(dechex(mt_rand(0, 255)), 2, '0', STR_PAD_LEFT) . str_pad(dechex(mt_rand(0, 255)), 2, '0', STR_PAD_LEFT) . "',";
				}
			}
			else if ($chart == 'ar_oa_chart' OR $chart == 'ar_o_chart' OR $chart == 'ar_l_chart')
			{
				$average = 0;
				$hours = 0;
				$count = 0;

				foreach ($query2 as $subvalue)
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
						}
					}
				}

				$average = ($count > 0) ? $hours / $count : $average;

				if ($average < 1)
					$average = round(($average * 60), 2);
				else
					$average = round($average, 2);

				if ($edit == true)
				{
					if ($chart == 'ar_oa_chart')
						array_push($data['labels'], $value['name'][Session::get_value('account')['language']]);
					else if ($chart == 'ar_o_chart')
						array_push($data['labels'], $value['name'] . (!empty($value['number']) ? ' #' . $value['number'] : ''));
					else if ($chart == 'ar_l_chart')
						array_push($data['labels'], $value['name'][Session::get_value('account')['language']]);

					array_push($data['datasets']['data'], $average);
					array_push($data['datasets']['colors'], "#" . str_pad(dechex(mt_rand(0, 255)), 2, '0', STR_PAD_LEFT) . str_pad( dechex(mt_rand(0, 255)), 2, '0', STR_PAD_LEFT) . str_pad(dechex(mt_rand(0, 255)), 2, '0', STR_PAD_LEFT));
				}
				else
				{
					if ($chart == 'ar_oa_chart')
						$data['labels'] .= "'" . $value['name'][Session::get_value('account')['language']] . "',";
					else if ($chart == 'ar_o_chart')
						$data['labels'] .= "'" . $value['name'] . (!empty($value['number']) ? " #" . $value['number'] : '') . "',";
					else if ($chart == 'ar_l_chart')
						$data['labels'] .= "'" . $value['name'][Session::get_value('account')['language']] . "',";

					$data['datasets']['data'] .= $average . ',';
					$data['datasets']['colors'] .= "'#" . str_pad(dechex(mt_rand(0, 255)), 2, '0', STR_PAD_LEFT) . str_pad(dechex(mt_rand(0, 255)), 2, '0', STR_PAD_LEFT) . str_pad(dechex(mt_rand(0, 255)), 2, '0', STR_PAD_LEFT) . "',";
				}
			}
			else if ($chart == 'c_oa_chart' OR $chart == 'c_o_chart' OR $chart == 'c_l_chart')
			{
				$cost = 0;

				foreach ($query2 as $subvalue)
				{
					if ($chart == 'c_oa_chart')
					{
						if ($value['id'] == $subvalue['opportunity_area'])
							$cost = !empty($subvalue['cost']) ? $cost + $subvalue['cost'] : $cost;
					}
					else if ($chart == 'c_o_chart')
					{
						if ($value['id'] == $subvalue['owner'])
							$cost = !empty($subvalue['cost']) ? $cost + $subvalue['cost'] : $cost;
					}
					else if ($chart == 'c_l_chart')
					{
						if ($value['id'] == $subvalue['location'])
							$cost = !empty($subvalue['cost']) ? $cost + $subvalue['cost'] : $cost;
					}
				}

				if ($edit == true)
				{
					if ($chart == 'c_oa_chart')
						array_push($data['labels'], $value['name'][Session::get_value('account')['language']]);
					else if ($chart == 'c_o_chart')
						array_push($data['labels'], $value['name'] . (!empty($value['number']) ? ' #' . $value['number'] : ''));
					else if ($chart == 'c_l_chart')
						array_push($data['labels'], $value['name'][Session::get_value('account')['language']]);

					array_push($data['datasets']['data'], $cost);
					array_push($data['datasets']['colors'], "#" . str_pad(dechex(mt_rand(0, 255)), 2, '0', STR_PAD_LEFT) . str_pad(dechex(mt_rand(0, 255)), 2, '0', STR_PAD_LEFT) . str_pad(dechex(mt_rand(0, 255)), 2, '0', STR_PAD_LEFT));
				}
				else
				{
					if ($chart == 'c_oa_chart')
						$data['labels'] .= "'" . $value['name'][Session::get_value('account')['language']] . "',";
					else if ($chart == 'c_o_chart')
						$data['labels'] .= "'" . $value['name'] . (!empty($value['number']) ? " #" . $value['number'] : '') . "',";
					else if ($chart == 'c_l_chart')
						$data['labels'] .= "'" . $value['name'][Session::get_value('account')['language']] . "',";

					$data['datasets']['data'] .= $cost . ',';
					$data['datasets']['colors'] .= "'#" . str_pad(dechex(mt_rand(0, 255)), 2, '0', STR_PAD_LEFT) . str_pad(dechex(mt_rand(0, 255)), 2, '0', STR_PAD_LEFT) . str_pad(dechex(mt_rand(0, 255)), 2, '0', STR_PAD_LEFT) . "',";
				}
			}
		}

		return $data;
	}
}
