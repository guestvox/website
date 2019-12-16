<?php

defined('_EXEC') or die;

class Voxes_model extends Model
{
	public function __construct()
	{
		parent::__construct();
	}

	public function get_voxes()
	{
		$voxes = [];

		$query = $this->database->select('voxes', [
			'id',
			'data'
		], [
			'account' => Session::get_value('account')['id']
		]);

		foreach ($query as $key => $value)
		{
			$value['data'] = json_decode(Functions::get_openssl('decrypt', $value['data']), true);

			$break = false;

			if (Functions::check_user_access(['{view_opportunity_areas}']) == true AND !in_array($value['data']['opportunity_area'], Session::get_value('user')['opportunity_areas']))
				$break = true;

			if (Functions::check_user_access(['{view_own}']) == true AND $value['data']['created_user'] != Session::get_value('user')['id'] AND !in_array(Session::get_value('user')['id'], $value['data']['assigned_users']))
				$break = true;

			if (Functions::check_user_access(['{view_confidentiality}']) == false && $value['data']['confidentiality'] == true)
				$break = true;

			if ($break == false)
			{
				if (Session::get_value('account')['type'] == 'hotel')
					$value['data']['room'] = $this->get_room($value['data']['room']);
				else if (Session::get_value('account')['type'] == 'restaurant')
					$value['data']['table'] = $this->get_table($value['data']['table']);

				$value['data']['opportunity_area'] = $this->get_opportunity_area($value['data']['opportunity_area']);
				$value['data']['opportunity_type'] = $this->get_opportunity_type($value['data']['opportunity_type']);
				$value['data']['location'] = $this->get_location($value['data']['location']);

				foreach ($value['data']['comments'] as $subvalue)
					$value['data']['attachments'] = array_merge($value['data']['attachments'], $subvalue['attachments']);

				$aux[$key] = Functions::get_formatted_date_hour($value['data']['started_date'], $value['data']['started_hour']);

				array_push($voxes, $value);
			}
		}

		if (!empty($voxes))
			array_multisort($aux, SORT_DESC, $voxes);

		return $voxes;
	}

	public function get_vox($id, $viewed = false)
	{
		$query = $this->database->select('voxes', [
			'id',
			'type',
			'data'
		], [
			'id' => $id
		]);

		if (!empty($query))
		{
			$query[0]['data'] = json_decode(Functions::get_openssl('decrypt', $query[0]['data']), true);

			if ($viewed == true)
			{
				$query[0]['data']['readed'] = true;

				if ($query[0]['data']['status'] == 'open')
				{
					if (!in_array(Session::get_value('user')['id'], $query[0]['data']['viewed_by']))
						array_push($query[0]['data']['viewed_by'], Session::get_value('user')['id']);

					array_push($query[0]['data']['changes_history'], [
						'type' => 'viewed',
						'user' => Session::get_value('user')['id'],
						'date' => Functions::get_current_date(),
						'hour' => Functions::get_current_hour()
					]);
				}

				$this->database->update('voxes', [
					'data' => Functions::get_openssl('encrypt', json_encode($query[0]['data']))
				], [
					'id' => $id
				]);
			}

			if (Session::get_value('account')['type'] == 'hotel')
			{
				$query[0]['data']['room'] = $this->get_room($query[0]['data']['room']);
				$query[0]['data']['guest_treatment'] = $this->get_guest_treatment($query[0]['data']['guest_treatment']);
				$query[0]['data']['guest_type'] = $this->get_guest_type($query[0]['data']['guest_type']);
				$query[0]['data']['reservation_status'] = $this->get_reservation_status($query[0]['data']['reservation_status']);
			}
			else if (Session::get_value('account')['type'] == 'restaurant')
				$query[0]['data']['table'] = $this->get_table($query[0]['data']['table']);

			$query[0]['data']['opportunity_area'] = $this->get_opportunity_area($query[0]['data']['opportunity_area']);
			$query[0]['data']['opportunity_type'] = $this->get_opportunity_type($query[0]['data']['opportunity_type']);
			$query[0]['data']['location'] = $this->get_location($query[0]['data']['location']);

			foreach ($query[0]['data']['assigned_users'] as $key => $value)
				$query[0]['data']['assigned_users'][$key] = $this->get_user($value);

			foreach ($query[0]['data']['comments'] as $key => $value)
				$query[0]['data']['comments'][$key]['user'] = $this->get_user($value['user']);

			$query[0]['data']['created_user'] = $this->get_user($query[0]['data']['created_user']);
			$query[0]['data']['edited_user'] = $this->get_user($query[0]['data']['edited_user']);
			$query[0]['data']['completed_user'] = $this->get_user($query[0]['data']['completed_user']);
			$query[0]['data']['reopened_user'] = $this->get_user($query[0]['data']['reopened_user']);

			foreach ($query[0]['data']['viewed_by'] as $key => $value)
				$query[0]['data']['viewed_by'][$key] = $this->get_user($value);

			foreach ($query[0]['data']['changes_history'] as $key => $value)
				$query[0]['data']['changes_history'][$key]['user'] = $this->get_user($value['user']);

			$query[0]['data']['changes_history'] = array_reverse($query[0]['data']['changes_history']);

			return $query[0];
		}
		else
			return null;
	}

	public function get_rooms()
	{
		$query = $this->database->select('rooms', [
			'id',
			'number',
			'name'
		], [
			'account' => Session::get_value('account')['id'],
			'ORDER' => [
				'number' => 'ASC'
			]
		]);

		return $query;
	}

	public function get_room($id)
	{
		$query = $this->database->select('rooms', [
			'id',
			'number',
			'name'
		], [
			'id' => $id
		]);

		return !empty($query) ? $query[0] : null;
	}

	public function get_tables()
	{
		$query = $this->database->select('tables', [
			'id',
			'number',
			'name'
		], [
			'account' => Session::get_value('account')['id'],
			'ORDER' => [
				'number' => 'ASC'
			]
		]);

		return $query;
	}

	public function get_table($id)
	{
		$query = $this->database->select('rooms', [
			'id',
			'number',
			'name'
		], [
			'id' => $id
		]);

		return !empty($query) ? $query[0] : null;
	}

	public function get_opportunity_areas($option = 'all')
	{
		if ($option == 'all')
		{
			$where = [
				'account' => Session::get_value('account')['id'],
				'ORDER' => [
					'name' => 'ASC'
				]
			];
		}
		else
		{
			$where = [
				'AND' => [
					'account' => Session::get_value('account')['id'],
					$option => true
				],
				'ORDER' => [
					'name' => 'ASC'
				]
			];
		}

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

	public function get_opportunity_types($opportunity_area, $option = 'all')
	{
		if ($option == 'all')
		{
			$where = [
				'opportunity_area' => $opportunity_area,
				'ORDER' => [
					'name' => 'ASC'
				]
			];
		}
		else
		{
			$where = [
				'AND' => [
					'opportunity_area' => $opportunity_area,
					$option => true
				],
				'ORDER' => [
					'name' => 'ASC'
				]
			];
		}

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
			'id' => $id,
		]));

		return !empty($query) ? $query[0] : null;
	}

	public function get_locations($option = 'all')
	{
		if ($option == 'all')
		{
			$where = [
				'account' => Session::get_value('account')['id'],
				'ORDER' => [
					'name' => 'ASC'
				]
			];
		}
		else
		{
			$where = [
				'AND' => [
					'account' => Session::get_value('account')['id'],
					$option => true
				],
				'ORDER' => [
					'name' => 'ASC'
				]
			];
		}

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

	public function get_users($option = null, $params = null)
	{
		$query = null;

		if ($option == 'assigned_users_by_ids')
		{
			$query = Functions::get_json_decoded_query($this->database->select('users', [
				'firstname',
				'lastname',
				'email',
				'phone'
			], [
				'AND' => [
					'id' => $params,
					'status' => true
				]
			]));
		}
		if ($option == 'assigned_users_by_opportunity_area')
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
				if (!in_array($params, $value['opportunity_areas']))
					unset($query[$key]);
			}
		}
		else
		{
			$query = $this->database->select('users', [
				'id',
				'username'
			], [
				'account' => Session::get_value('account')['id'],
				'ORDER' => [
					'username' => 'ASC'
				]
			]);
		}

		return $query;
	}

	public function get_user($id)
	{
		$query = $this->database->select('users', [
			'id',
			'firstname',
			'lastname',
			'avatar',
			'username'
		], [
			'id' => $id
		]);

		return !empty($query) ? $query[0] : null;
	}

	public function get_guest($room)
	{
		$guest = [
			'status' => 'success',
			'firstname' => '',
			'lastname' => '',
			'reservation_number' => '',
			'check_in' => '',
			'check_out' => ''
		];

		if (Session::get_value('account')['zaviapms']['status'] == true)
		{
			$query = Functions::api('zaviapms', Session::get_value('account')['zaviapms'], 'get', 'room', $room);

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

					if ($ext == 'doc' || $ext == 'docx' || $ext == 'xls' || $ext == 'xlsx')
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

			unset($data['attachments']['name'], $data['attachments']['type'], $data['attachments']['tmp_name'], $data['attachments']['error'], $data['attachments']['size']);
		}

		$query = $this->database->insert('voxes', [
			'account' => Session::get_value('account')['id'],
			'type' => $data['type'],
			'data' => Functions::get_openssl('encrypt', json_encode([
				'token' => Functions::get_random(8),
				'room' => ($data['type'] == 'request' OR $data['type'] == 'incident' AND Session::get_value('account')['type'] == 'hotel') ? $data['room'] : null,
				'table' => ($data['type'] == 'request' OR $data['type'] == 'incident' AND Session::get_value('account')['type'] == 'restaurant') ? $data['table'] : null,
				'opportunity_area' => $data['opportunity_area'],
				'opportunity_type' => $data['opportunity_type'],
				'started_date' => Functions::get_formatted_date($data['started_date']),
				'started_hour' => Functions::get_formatted_hour($data['started_hour']),
				'location' => $data['location'],
				'cost' => ($data['type'] == 'incident') ? $data['cost'] : null,
				'urgency' => $data['urgency'],
				'confidentiality' => ($data['type'] == 'incident') ? $data['confidentiality'] : null,
				'assigned_users' => !empty($data['assigned_users']) ? $data['assigned_users'] : [],
				'observations' => ($data['type'] == 'request' OR $data['type'] == 'workorder') ? $data['observations'] : null,
				'subject' => ($data['type'] == 'incident') ? $data['subject'] : null,
				'description' => ($data['type'] == 'incident') ? $data['description'] : null,
				'action_taken' => ($data['type'] == 'incident') ? $data['action_taken'] : null,
				'guest_treatment' => ($data['type'] == 'request' OR $data['type'] == 'incident' AND Session::get_value('account')['type'] == 'hotel') ? $data['guest_treatment'] : null,
				'firstname' => ($data['type'] == 'request' OR $data['type'] == 'incident') ? $data['firstname'] : null,
				'lastname' => ($data['type'] == 'request' OR $data['type'] == 'incident') ? $data['lastname'] : null,
				'guest_id' => ($data['type'] == 'incident' AND Session::get_value('account')['type'] == 'hotel') ? $data['guest_id'] : null,
				'guest_type' => ($data['type'] == 'incident' AND Session::get_value('account')['type'] == 'hotel') ? $data['guest_type'] : null,
				'reservation_number' => ($data['type'] == 'incident' AND Session::get_value('account')['type'] == 'hotel') ? $data['reservation_number'] : null,
				'reservation_status' => ($data['type'] == 'incident' AND Session::get_value('account')['type'] == 'hotel') ? $data['reservation_status'] : null,
				'check_in' => ($data['type'] == 'incident' AND Session::get_value('account')['type'] == 'hotel') ? $data['check_in'] : null,
				'check_out' => ($data['type'] == 'incident' AND Session::get_value('account')['type'] == 'hotel') ? $data['check_out'] : null,
				'attachments' => !empty($data['attachments']) ? $data['attachments'] : [],
				'viewed_by' => [],
				'comments' => [],
				'changes_history' => [
					[
						'type' => 'create',
						'user' => Session::get_value('user')['id'],
						'date' => Functions::get_current_date(),
						'hour' => Functions::get_current_hour()
					]
				],
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
				'readed' => false,
				'status' => 'open',
				'origin' => 'internal'
			]))
		]);

		return !empty($query) ? $this->database->id() : null;
	}

	public function edit_vox($data)
	{
		$query = null;

		$editer = $this->database->select('voxes', [
			'type',
			'data'
		], [
			'id' => $data['id']
		]);

		if (!empty($editer))
		{
			$editer[0]['data'] = json_decode(Functions::get_openssl('decrypt', $editer[0]['data']), true);

			if (!empty($data['assigned_users']))
			{
				$data['assigned_users'] = array_merge($editer[0]['data']['assigned_users'], $data['assigned_users']);
				$data['assigned_users'] = array_unique($data['assigned_users']);
				$data['assigned_users'] = array_values($data['assigned_users']);
			}
			else
				$data['assigned_users'] = $editer[0]['data']['assigned_users'];

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

						if ($ext == 'doc' || $ext == 'docx' || $ext == 'xls' || $ext == 'xlsx')
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

				unset($data['attachments']['name'], $data['attachments']['type'], $data['attachments']['tmp_name'], $data['attachments']['error'], $data['attachments']['size']);

				$data['attachments'] = array_merge($editer[0]['data']['attachments'], $data['attachments']);
			}
			else
				$data['attachments'] = $editer[0]['data']['attachments'];

			$data['changes_history'] = [
				[
					'type' => 'edit',
					'fields' => [],
					'user' => Session::get_value('user')['id'],
					'date' => Functions::get_current_date(),
					'hour' => Functions::get_current_hour()
				]
			];

			if ($editer[0]['type'] != $data['type'])
			{
				array_push($data['changes_history'][0]['fields'], [
					'field' => 'type',
					'before' => $editer[0]['type'],
					'after' => $data['type']
				]);
			}

			if ($data['type'] == 'request' OR $data['type'] == 'incident')
			{
				if (Session::get_value('account')['type'] == 'hotel')
				{
					if ($editer[0]['data']['room'] != $data['room'])
					{
						array_push($data['changes_history'][0]['fields'], [
							'field' => 'room',
							'before' => $editer[0]['data']['room'],
							'after' => $data['room']
						]);
					}
				}
				else if (Session::get_value('account')['type'] == 'restaurant')
				{
					if ($editer[0]['data']['table'] != $data['table'])
					{
						array_push($data['changes_history'][0]['fields'], [
							'field' => 'table',
							'before' => $editer[0]['data']['table'],
							'after' => $data['table']
						]);
					}
				}
			}

			if ($editer[0]['data']['opportunity_area'] != $data['opportunity_area'])
			{
				array_push($data['changes_history'][0]['fields'], [
					'field' => 'opportunity_area',
					'before' => $editer[0]['data']['opportunity_area'],
					'after' => $data['opportunity_area']
				]);
			}

			if ($editer[0]['data']['opportunity_type'] != $data['opportunity_type'])
			{
				array_push($data['changes_history'][0]['fields'], [
					'field' => 'opportunity_type',
					'before' => $editer[0]['data']['opportunity_type'],
					'after' => $data['opportunity_type']
				]);
			}

			if ($editer[0]['data']['started_date'] != Functions::get_formatted_date($data['started_date']))
			{
				array_push($data['changes_history'][0]['fields'], [
					'field' => 'started_date',
					'before' => $editer[0]['data']['started_date'],
					'after' => Functions::get_formatted_date($data['started_date'])
				]);
			}

			if ($editer[0]['data']['started_hour'] != Functions::get_formatted_hour($data['started_hour']))
			{
				array_push($data['changes_history'][0]['fields'], [
					'field' => 'started_hour',
					'before' => $editer[0]['data']['started_hour'],
					'after' => Functions::get_formatted_hour($data['started_hour'])
				]);
			}

			if ($editer[0]['data']['location'] != $data['location'])
			{
				array_push($data['changes_history'][0]['fields'], [
					'field' => 'location',
					'before' => $editer[0]['data']['location'],
					'after' => $data['location']
				]);
			}

			if ($data['type'] == 'incident')
			{
				if ($editer[0]['data']['cost'] != $data['cost'])
				{
					array_push($data['changes_history'][0]['fields'], [
						'field' => 'cost',
						'before' => $editer[0]['data']['cost'],
						'after' => $data['cost']
					]);
				}
			}

			if ($editer[0]['data']['urgency'] != $data['urgency'])
			{
				array_push($data['changes_history'][0]['fields'], [
					'field' => 'urgency',
					'before' => $editer[0]['data']['urgency'],
					'after' => $data['urgency']
				]);
			}

			if ($data['type'] == 'incident')
			{
				if ($editer[0]['data']['confidentiality'] != $data['confidentiality'])
				{
					array_push($data['changes_history'][0]['fields'], [
						'field' => 'confidentiality',
						'before' => $editer[0]['data']['confidentiality'],
						'after' => $data['confidentiality']
					]);
				}
			}

			if ($editer[0]['data']['assigned_users'] != $data['assigned_users'])
			{
				array_push($data['changes_history'][0]['fields'], [
					'field' => 'assigned_users',
					'before' => $editer[0]['data']['assigned_users'],
					'after' => $data['assigned_users']
				]);
			}

			if ($data['type'] == 'request' OR $data['type'] == 'workorder')
			{
				if ($editer[0]['data']['observations'] != $data['observations'])
				{
					array_push($data['changes_history'][0]['fields'], [
						'field' => 'observations',
						'before' => $editer[0]['data']['observations'],
						'after' => $data['observations']
					]);
				}
			}

			if ($data['type'] == 'incident')
			{
				if ($editer[0]['data']['subject'] != $data['subject'])
				{
					array_push($data['changes_history'][0]['fields'], [
						'field' => 'subject',
						'before' => $editer[0]['data']['subject'],
						'after' => $data['subject']
					]);
				}

				if ($editer[0]['data']['description'] != $data['description'])
				{
					array_push($data['changes_history'][0]['fields'], [
						'field' => 'description',
						'before' => $editer[0]['data']['description'],
						'after' => $data['description']
					]);
				}

				if ($editer[0]['data']['action_taken'] != $data['action_taken'])
				{
					array_push($data['changes_history'][0]['fields'], [
						'field' => 'action_taken',
						'before' => $editer[0]['data']['action_taken'],
						'after' => $data['action_taken']
					]);
				}
			}

			if ($data['type'] == 'request' OR $data['type'] == 'incident')
			{
				if (Session::get_value('account')['type'] == 'hotel')
				{
					if ($editer[0]['data']['guest_treatment'] != $data['guest_treatment'])
					{
						array_push($data['changes_history'][0]['fields'], [
							'field' => 'guest_treatment',
							'before' => $editer[0]['data']['guest_treatment'],
							'after' => $data['guest_treatment']
						]);
					}
				}

				if ($editer[0]['data']['firstname'] != $data['firstname'])
				{
					array_push($data['changes_history'][0]['fields'], [
						'field' => 'firstname',
						'before' => $editer[0]['data']['firstname'],
						'after' => $data['firstname']
					]);
				}

				if ($editer[0]['data']['lastname'] != $data['lastname'])
				{
					array_push($data['changes_history'][0]['fields'], [
						'field' => 'lastname',
						'before' => $editer[0]['data']['lastname'],
						'after' => $data['lastname']
					]);
				}
			}

			if ($data['type'] == 'incident')
			{
				if (Session::get_value('account')['type'] == 'hotel')
				{
					if ($editer[0]['data']['guest_id'] != $data['guest_id'])
					{
						array_push($data['changes_history'][0]['fields'], [
							'field' => 'guest_id',
							'before' => $editer[0]['data']['guest_id'],
							'after' => $data['guest_id']
						]);
					}

					if ($editer[0]['data']['guest_type'] != $data['guest_type'])
					{
						array_push($data['changes_history'][0]['fields'], [
							'field' => 'guest_type',
							'before' => $editer[0]['data']['guest_type'],
							'after' => $data['guest_type']
						]);
					}

					if ($editer[0]['data']['reservation_number'] != $data['reservation_number'])
					{
						array_push($data['changes_history'][0]['fields'], [
							'field' => 'reservation_number',
							'before' => $editer[0]['data']['reservation_number'],
							'after' => $data['reservation_number']
						]);
					}

					if ($editer[0]['data']['reservation_status'] != $data['reservation_status'])
					{
						array_push($data['changes_history'][0]['fields'], [
							'field' => 'reservation_status',
							'before' => $editer[0]['data']['reservation_status'],
							'after' => $data['reservation_status']
						]);
					}

					if ($editer[0]['data']['check_in'] != $data['check_in'])
					{
						array_push($data['changes_history'][0]['fields'], [
							'field' => 'check_in',
							'before' => $editer[0]['data']['check_in'],
							'after' => $data['check_in']
						]);
					}

					if ($editer[0]['data']['check_out'] != $data['check_out'])
					{
						array_push($data['changes_history'][0]['fields'], [
							'field' => 'check_out',
							'before' => $editer[0]['data']['check_out'],
							'after' => $data['check_out']
						]);
					}
				}
			}

			if ($editer[0]['data']['attachments'] != $data['attachments'])
			{
				array_push($data['changes_history'][0]['fields'], [
					'field' => 'attachments',
					'before' => $editer[0]['data']['attachments'],
					'after' => $data['attachments']
				]);
			}

			if (!empty($data['changes_history'][0]['fields']))
				$data['changes_history'] = array_merge($editer[0]['data']['changes_history'], $data['changes_history']);
			else
				$data['changes_history'] = $editer[0]['data']['changes_history'];

			$query = $this->database->update('voxes', [
				'type' => $data['type'],
				'data' => Functions::get_openssl('encrypt', json_encode([
					'token' => $editer[0]['data']['token'],
					'room' => ($data['type'] == 'request' OR $data['type'] == 'incident' AND Session::get_value('account')['type'] == 'hotel') ? $data['room'] : null,
					'table' => ($data['type'] == 'request' OR $data['type'] == 'incident' AND Session::get_value('account')['type'] == 'restaurant') ? $data['table'] : null,
					'opportunity_area' => $data['opportunity_area'],
					'opportunity_type' => $data['opportunity_type'],
					'started_date' => Functions::get_formatted_date($data['started_date']),
					'started_hour' => Functions::get_formatted_hour($data['started_hour']),
					'location' => $data['location'],
					'cost' => ($data['type'] == 'incident') ? $data['cost'] : null,
					'urgency' => $data['urgency'],
					'confidentiality' => ($data['type'] == 'incident') ? $data['confidentiality'] : null,
					'assigned_users' => !empty($data['assigned_users']) ? $data['assigned_users'] : [],
					'observations' => ($data['type'] == 'request' OR $data['type'] == 'workorder') ? $data['observations'] : null,
					'subject' => ($data['type'] == 'incident') ? $data['subject'] : null,
					'description' => ($data['type'] == 'incident') ? $data['description'] : null,
					'action_taken' => ($data['type'] == 'incident') ? $data['action_taken'] : null,
					'guest_treatment' => ($data['type'] == 'request' OR $data['type'] == 'incident' AND Session::get_value('account')['type'] == 'hotel') ? $data['guest_treatment'] : null,
					'firstname' => ($data['type'] == 'request' OR $data['type'] == 'incident') ? $data['firstname'] : null,,
					'lastname' => ($data['type'] == 'request' OR $data['type'] == 'incident') ? $data['lastname'] : null,
					'guest_id' => ($data['type'] == 'incident' AND Session::get_value('account')['type'] == 'hotel') ? $data['guest_id'] : null,
					'guest_type' => ($data['type'] == 'incident' AND Session::get_value('account')['type'] == 'hotel') ? $data['guest_type'] : null,
					'reservation_number' => ($data['type'] == 'incident' AND Session::get_value('account')['type'] == 'hotel') ? $data['reservation_number'] : null,
					'reservation_status' => ($data['type'] == 'incident' AND Session::get_value('account')['type'] == 'hotel') ? $data['reservation_status'] : null,
					'check_in' => ($data['type'] == 'incident' AND Session::get_value('account')['type'] == 'hotel') ? $data['check_in'] : null,
					'check_out' => ($data['type'] == 'incident' AND Session::get_value('account')['type'] == 'hotel') ? $data['check_out'] : null,
					'attachments' => !empty($data['attachments']) ? $data['attachments'] : [],
					'viewed_by' => $editer[0]['data']['viewed_by'],
					'comments' => $editer[0]['data']['comments'],
					'changes_history' => $data['changes_history'],
					'created_user' => $editer[0]['data']['created_user'],
					'edited_user' => Session::get_value('user')['id'],
					'completed_user' => $editer[0]['data']['completed_user'],
					'reopened_user' => $editer[0]['data']['reopened_user'],
					'created_date' => $editer[0]['data']['created_date'],
					'created_hour' => $editer[0]['data']['created_hour'],
					'edited_date' => Functions::get_current_date(),
					'edited_hour' => Functions::get_current_hour(),
					'completed_date' => $editer[0]['data']['completed_date'],
					'completed_hour' => $editer[0]['data']['completed_hour'],
					'reopened_date' => $editer[0]['data']['reopened_date'],
					'reopened_hour' => $editer[0]['data']['reopened_hour'],
					'readed' => $editer[0]['data']['readed'],
					'status' => $editer[0]['data']['status'],
					'origin' => $editer[0]['data']['origin']
				]))
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
			'data'
		], [
			'id' => $id
		]);

		if (!empty($editer))
		{
			$editer[0]['data'] = json_decode(Functions::get_openssl('decrypt', $editer[0]['data']), true);

			$editer[0]['data']['completed_user'] = Session::get_value('user')['id'];
			$editer[0]['data']['completed_date'] = Functions::get_current_date();
			$editer[0]['data']['completed_hour'] = Functions::get_current_hour();
			$editer[0]['data']['status'] = 'close';

			array_push($editer[0]['data']['changes_history'], [
				'type' => 'complete',
				'user' => Session::get_value('user')['id'],
				'date' => Functions::get_current_date(),
				'hour' => Functions::get_current_hour()
			]);

			$query = $this->database->update('voxes', [
				'data' => Functions::get_openssl('encrypt', json_encode($editer[0]['data']))
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
			'data'
		], [
			'id' => $id
		]);

		if (!empty($editer))
		{
			$editer[0]['data'] = json_decode(Functions::get_openssl('decrypt', $editer[0]['data']), true);

			$editer[0]['data']['reopened_user'] = Session::get_value('user')['id'];
			$editer[0]['data']['reopened_date'] = Functions::get_current_date();
			$editer[0]['data']['reopened_hour'] = Functions::get_current_hour();
			$editer[0]['data']['status'] = 'open';

			array_push($editer[0]['data']['changes_history'], [
				'type' => 'reopen',
				'user' => Session::get_value('user')['id'],
				'date' => Functions::get_current_date(),
				'hour' => Functions::get_current_hour()
			]);

			$query = $this->database->update('voxes', [
				'data' => Functions::get_openssl('encrypt', json_encode($editer[0]['data']))
			], [
				'id' => $id
			]);
		}

		return $query;
	}

	public function new_vox_comment($id, $data)
	{
		$query = null;

		$editer = $this->database->select('voxes', [
			'data'
		], [
			'id' => $id
		]);

		if (!empty($editer))
		{
			$editer[0]['data'] = json_decode(Functions::get_openssl('decrypt', $editer[0]['data']), true);

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

						if ($ext == 'doc' || $ext == 'docx' || $ext == 'xls' || $ext == 'xlsx')
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

				unset($data['attachments']['name'], $data['attachments']['type'], $data['attachments']['tmp_name'], $data['attachments']['error'], $data['attachments']['size']);
			}

			array_push($editer[0]['data']['comments'], [
				'user' => Session::get_value('user')['id'],
				'date' => Functions::get_current_date(),
				'hour' => Functions::get_current_hour(),
				'message' => $data['response_to'] . ' ' . $data['message'],
				'attachments' => !empty($data['attachments']) ? $data['attachments'] : []
			]);

			array_push($editer[0]['data']['changes_history'], [
				'type' => 'new_comment',
				'user' => Session::get_value('user')['id'],
				'date' => Functions::get_current_date(),
				'hour' => Functions::get_current_hour()
			]);

			$query = $this->database->update('voxes', [
				'data' => Functions::get_openssl('encrypt', json_encode($editer[0]['data']))
			], [
				'id' => $id
			]);
		}

		return $query;
	}

	public function edit_sms()
	{
		$query = $this->database->update('account', [
			'sms' => Session::get_value('account')['sms']
		], [
			'id' => Session::get_value('account')['id']
		]);

		return $query;
	}

	public function get_vox_report_fields($type)
	{
		if ($type == 'all')
		{
			if (Session::get_value('account')['type'] == 'hotel')
			{
				return [
					[
						'id' => 'type',
						'name' => 'vox_type'
					],
					[
						'id' => 'room',
						'name' => 'room'
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
						'id' => 'started_date_hour',
						'name' => 'started_date_hour'
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
						'id' => 'observations',
						'name' => 'observations'
					],
					[
						'id' => 'subject',
						'name' => 'subject'
					],
					[
						'id' => 'assigned_users',
						'name' => 'assigned_users'
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
						'id' => 'guest_treatment_name_lastname',
						'name' => 'guest_name'
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
						'id' => 'check_in_check_out',
						'name' => 'staying'
					],
					[
						'id' => 'attachments',
						'name' => 'attachments'
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
						'id' => 'created_user_date_hour',
						'name' => 'created_by'
					],
					[
						'id' => 'edited_user_date_hour',
						'name' => 'edited_by'
					],
					[
						'id' => 'completed_user_date_hour',
						'name' => 'completed_by'
					],
					[
						'id' => 'reopened_user_date_hour',
						'name' => 'reopened_by'
					],
					[
						'id' => 'comments',
						'name' => 'comments'
					],
					[
						'id' => 'viewed_by',
						'name' => 'viewed_by'
					],
					[
						'id' => 'average_resolution',
						'name' => 'average_resolution'
					]
				];
			}
			else if (Session::get_value('account')['type'] == 'restaurant')
			{
				return [
					[
						'id' => 'type',
						'name' => 'vox_type'
					],
					[
						'id' => 'table',
						'name' => 'table'
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
						'id' => 'started_date_hour',
						'name' => 'started_date_hour'
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
						'id' => 'observations',
						'name' => 'observations'
					],
					[
						'id' => 'subject',
						'name' => 'subject'
					],
					[
						'id' => 'assigned_users',
						'name' => 'assigned_users'
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
						'id' => 'guest_treatment_name_lastname',
						'name' => 'guest_name'
					],
					[
						'id' => 'attachments',
						'name' => 'attachments'
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
						'id' => 'created_user_date_hour',
						'name' => 'created_by'
					],
					[
						'id' => 'edited_user_date_hour',
						'name' => 'edited_by'
					],
					[
						'id' => 'completed_user_date_hour',
						'name' => 'completed_by'
					],
					[
						'id' => 'reopened_user_date_hour',
						'name' => 'reopened_by'
					],
					[
						'id' => 'comments',
						'name' => 'comments'
					],
					[
						'id' => 'viewed_by',
						'name' => 'viewed_by'
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
						'id' => 'room',
						'name' => 'room'
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
						'id' => 'started_date_hour',
						'name' => 'started_date_hour'
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
						'id' => 'observations',
						'name' => 'observations'
					],
					[
						'id' => 'assigned_users',
						'name' => 'assigned_users'
					],
					[
						'id' => 'guest_treatment_name_lastname',
						'name' => 'guest_name'
					],
					[
						'id' => 'attachments',
						'name' => 'attachments'
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
						'id' => 'created_user_date_hour',
						'name' => 'created_by'
					],
					[
						'id' => 'edited_user_date_hour',
						'name' => 'edited_by'
					],
					[
						'id' => 'completed_user_date_hour',
						'name' => 'completed_by'
					],
					[
						'id' => 'reopened_user_date_hour',
						'name' => 'reopened_by'
					],
					[
						'id' => 'comments',
						'name' => 'comments'
					],
					[
						'id' => 'viewed_by',
						'name' => 'viewed_by'
					],
					[
						'id' => 'average_resolution',
						'name' => 'average_resolution'
					]
				];
			}
			else if (Session::get_value('account')['type'] == 'restaurant')
			{
				return [
					[
						'id' => 'table',
						'name' => 'table'
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
						'id' => 'started_date_hour',
						'name' => 'started_date_hour'
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
						'id' => 'observations',
						'name' => 'observations'
					],
					[
						'id' => 'assigned_users',
						'name' => 'assigned_users'
					],
					[
						'id' => 'guest_treatment_name_lastname',
						'name' => 'guest_name'
					],
					[
						'id' => 'attachments',
						'name' => 'attachments'
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
						'id' => 'created_user_date_hour',
						'name' => 'created_by'
					],
					[
						'id' => 'edited_user_date_hour',
						'name' => 'edited_by'
					],
					[
						'id' => 'completed_user_date_hour',
						'name' => 'completed_by'
					],
					[
						'id' => 'reopened_user_date_hour',
						'name' => 'reopened_by'
					],
					[
						'id' => 'comments',
						'name' => 'comments'
					],
					[
						'id' => 'viewed_by',
						'name' => 'viewed_by'
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
						'id' => 'room',
						'name' => 'room'
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
						'id' => 'started_date_hour',
						'name' => 'started_date_hour'
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
						'id' => 'subject',
						'name' => 'subject'
					],
					[
						'id' => 'assigned_users',
						'name' => 'assigned_users'
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
						'id' => 'guest_treatment_name_lastname',
						'name' => 'guest_name'
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
						'id' => 'check_in_check_out',
						'name' => 'staying'
					],
					[
						'id' => 'attachments',
						'name' => 'attachments'
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
						'id' => 'created_user_date_hour',
						'name' => 'created_by'
					],
					[
						'id' => 'edited_user_date_hour',
						'name' => 'edited_by'
					],
					[
						'id' => 'completed_user_date_hour',
						'name' => 'completed_by'
					],
					[
						'id' => 'reopened_user_date_hour',
						'name' => 'reopened_by'
					],
					[
						'id' => 'comments',
						'name' => 'comments'
					],
					[
						'id' => 'viewed_by',
						'name' => 'viewed_by'
					],
					[
						'id' => 'average_resolution',
						'name' => 'average_resolution'
					]
				];
			}
			else if (Session::get_value('account')['type'] == 'restaurant')
			{
				return [
					[
						'id' => 'table',
						'name' => 'table'
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
						'id' => 'started_date_hour',
						'name' => 'started_date_hour'
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
						'id' => 'subject',
						'name' => 'subject'
					],
					[
						'id' => 'assigned_users',
						'name' => 'assigned_users'
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
						'id' => 'guest_treatment_name_lastname',
						'name' => 'guest_name'
					],
					[
						'id' => 'attachments',
						'name' => 'attachments'
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
						'id' => 'created_user_date_hour',
						'name' => 'created_by'
					],
					[
						'id' => 'edited_user_date_hour',
						'name' => 'edited_by'
					],
					[
						'id' => 'completed_user_date_hour',
						'name' => 'completed_by'
					],
					[
						'id' => 'reopened_user_date_hour',
						'name' => 'reopened_by'
					],
					[
						'id' => 'comments',
						'name' => 'comments'
					],
					[
						'id' => 'viewed_by',
						'name' => 'viewed_by'
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
					'id' => 'opportunity_area',
					'name' => 'opportunity_area'
				],
				[
					'id' => 'opportunity_type',
					'name' => 'opportunity_type'
				],
				[
					'id' => 'started_date_hour',
					'name' => 'started_date_hour'
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
					'id' => 'observations',
					'name' => 'observations'
				],
				[
					'id' => 'assigned_users',
					'name' => 'assigned_users'
				],
				[
					'id' => 'attachments',
					'name' => 'attachments'
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
					'id' => 'created_user_date_hour',
					'name' => 'created_by'
				],
				[
					'id' => 'edited_user_date_hour',
					'name' => 'edited_by'
				],
				[
					'id' => 'completed_user_date_hour',
					'name' => 'completed_by'
				],
				[
					'id' => 'reopened_user_date_hour',
					'name' => 'reopened_by'
				],
				[
					'id' => 'comments',
					'name' => 'comments'
				],
				[
					'id' => 'viewed_by',
					'name' => 'viewed_by'
				],
				[
					'id' => 'average_resolution',
					'name' => 'average_resolution'
				]
			];
		}
	}

	public function get_vox_reports()
	{
		$reports = [];

		$query = Functions::get_json_decoded_query($this->database->select('vox_reports', [
			'id',
			'name',
			'addressed_to',
			'addressed_to_opportunity_areas',
			'addressed_to_user'
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
					if (!in_array($subvalue, $value['addressed_to_opportunity_areas']))
						$break = true;
					else
						$count = $count + 1;
				}

				if ($count > 0)
					$break = false;
			}

			if ($value['addressed_to'] == 'me' AND Session::get_value('user')['id'] != $value['addressed_to_user'])
				$break = true;

			if ($break == false)
				array_push($reports, $value);
		}

		return $reports;
	}

	public function get_vox_report($id)
	{
		$query = Functions::get_json_decoded_query($this->database->select('vox_reports', [
			'id',
			'name',
			'type',
			'opportunity_area',
			'opportunity_type',
			'room',
			'table',
			'location',
			'order',
			'time_period',
			'addressed_to',
			'addressed_to_opportunity_areas',
			'addressed_to_user',
			'fields'
		], [
			'id' => $id
		]));

		return !empty($query) ? $query[0] : null;
	}

	public function new_vox_report($data)
	{
		$query = null;

		$exist = $this->database->count('vox_reports', [
			'name' => $data['name']
		]);

		if ($exist <= 0)
		{
			$query = $this->database->insert('vox_reports', [
				'account' => Session::get_value('account')['id'],
				'name' => $data['name'],
				'type' => $data['type'],
				'opportunity_area' => ($data['opportunity_area'] != 'all') ? $data['opportunity_area'] : null,
				'opportunity_type' => ($data['opportunity_type'] != 'all') ? $data['opportunity_type'] : null,
				'room' => (Session::get_value('account')['type'] == 'hotel' AND $data['room'] != 'all') ? $data['room'] : null,
				'table' => (Session::get_value('account')['type'] == 'restaurant' AND $data['table'] != 'all') ? $data['table'] : null,
				'location' => ($data['location'] != 'all') ? $data['location'] : null,
				'order' => $data['order'],
				'time_period' => $data['time_period'],
				'addressed_to' => $data['addressed_to'],
				'addressed_to_opportunity_areas' => ($data['addressed_to'] == 'opportunity_areas') ? json_encode($data['addressed_to_opportunity_areas']) : null,
				'addressed_to_user' => ($data['addressed_to'] == 'me') ? Session::get_value('user')['id'] : null,
				'fields' => json_encode($data['fields'])
			]);
		}

		return $query;
	}

	public function edit_vox_report($data)
	{
		$query = null;

		$exist = $this->database->count('vox_reports', [
			'AND' => [
				'id[!]' => $data['id'],
				'name' => $data['name']
			]
		]);

		if ($exist <= 0)
		{
			$query = $this->database->update('vox_reports', [
				'name' => $data['name'],
				'type' => $data['type'],
				'opportunity_area' => ($data['opportunity_area'] != 'all') ? $data['opportunity_area'] : null,
				'opportunity_type' => ($data['opportunity_type'] != 'all') ? $data['opportunity_type'] : null,
				'room' => (Session::get_value('account')['type'] == 'hotel' AND $data['room'] != 'all') ? $data['room'] : null,
				'table' => (Session::get_value('account')['type'] == 'restaurant' AND $data['table'] != 'all') ? $data['table'] : null,
				'location' => ($data['location'] != 'all') ? $data['location'] : null,
				'order' => $data['order'],
				'time_period' => $data['time_period'],
				'addressed_to' => $data['addressed_to'],
				'addressed_to_opportunity_areas' => ($data['addressed_to'] == 'opportunity_areas') ? json_encode($data['addressed_to_opportunity_areas']) : null,
				'addressed_to_user' => ($data['addressed_to'] == 'me') ? Session::get_value('user')['id'] : null,
				'fields' => json_encode($data['fields'])
			], [
				'id' => $data['id']
			]);
		}

		return $query;
	}

	public function delete_vox_report($id)
	{
		$query = $this->database->delete('vox_reports', [
			'id' => $id
		]);

		return $query;
	}

	public function generate_report($data)
	{
		if ($data['type'] == 'all')
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
					'type' => $data['type']
				]
			];
		}

		$query = $this->database->select('voxes', [
			'type',
			'data'
		], $where);

		$voxes = [];

		foreach ($query as $key => $value)
		{
			$value['data'] = json_decode(Functions::get_openssl('decrypt', $value['data']), true);

			$break = false;

			if (Functions::check_user_access(['{view_opportunity_areas}']) == true AND !in_array($value['data']['opportunity_area'], Session::get_value('user')['opportunity_areas']))
				$break = true;

			if (Functions::check_user_access(['{view_own}']) == true AND $value['data']['created_user'] != Session::get_value('user')['id'] AND !in_array(Session::get_value('user')['id'], $value['data']['assigned_users']))
				$break = true;

			if (Functions::check_user_access(['{view_confidentiality}']) == false && $value['data']['confidentiality'] == true)
				$break = true;

			if ($data['opportunity_area'] != 'all' AND $value['data']['opportunity_area'] != $data['opportunity_area'])
				$break = true;

			if ($data['opportunity_type'] != 'all' AND $value['data']['opportunity_type'] != $data['opportunity_type'])
				$break = true;

			if (Session::get_value('account')['type'] == 'hotel')
			{
				if ($data['room'] != 'all' AND $value['data']['room'] != $data['room'])
					$break = true;
			}
			else if (Session::get_value('account')['type'] == 'restaurant')
			{
				if ($data['table'] != 'all' AND $value['data']['table'] != $data['table'])
					$break = true;
			}

			if ($data['location'] != 'all' AND $value['data']['location'] != $data['location'])
				$break = true;

			if ($value['data']['started_date'] < $data['started_date'] OR $value['data']['started_date'] > $data['end_date'])
				$break = true;

			if ($break == false)
			{
				if (Session::get_value('account')['type'] == 'hotel')
				{
					$value['data']['room'] = $this->get_room($value['data']['room']);
					$value['data']['guest_treatment'] = $this->get_guest_treatment($value['data']['guest_treatment']);
					$value['data']['guest_type'] = $this->get_guest_type($value['data']['guest_type']);
					$value['data']['reservation_status'] = $this->get_reservation_status($value['data']['reservation_status']);
				}
				else if (Session::get_value('account')['type'] == 'restaurant')
					$value['data']['table'] = $this->get_table($value['data']['table']);

				$value['data']['opportunity_area'] = $this->get_opportunity_area($value['data']['opportunity_area']);
				$value['data']['opportunity_type'] = $this->get_opportunity_type($value['data']['opportunity_type']);
				$value['data']['location'] = $this->get_location($value['data']['location']);

				foreach ($value['data']['assigned_users'] as $key => $subvalue)
					$value['data']['assigned_users'][$key] = $this->get_user($subvalue);

				foreach ($value['data']['comments'] as $key => $subvalue)
					$value['data']['comments'][$key]['user'] = $this->get_user($subvalue['user']);

				$value['data']['created_user'] = $this->get_user($value['data']['created_user']);
				$value['data']['edited_user'] = $this->get_user($value['data']['edited_user']);
				$value['data']['completed_user'] = $this->get_user($value['data']['completed_user']);
				$value['data']['reopened_user'] = $this->get_user($value['data']['reopened_user']);

				foreach ($value['data']['viewed_by'] as $key => $subvalue)
					$value['data']['viewed_by'][$key] = $this->get_user($subvalue);

				array_push($voxes, $value);
			}
		}

		if (!empty($voxes))
		{
			foreach ($voxes as $key => $value)
			{
				if ($data['order'] == 'room')
					$aux[$key] = $value['data']['room'];
				else if ($data['order'] == 'table')
					$aux[$key] = $value['data']['table'];
				else if ($data['order'] == 'guest')
					$aux[$key] = $value['data']['firstname'] . ' ' . $value['data']['lastname'];
			}

			array_multisort($aux, SORT_ASC, $voxes);
		}

		return $voxes;
	}

	public function get_chart_data($chart, $params, $edit = false)
	{
		$query = $this->database->select('voxes', [
			'type',
			'data'
		], [
			'account' => Session::get_value('account')['id']
		]);

		$voxes = [];

		foreach ($query as $key => $value)
		{
			$value['data'] = json_decode(Functions::get_openssl('decrypt', $value['data']), true);

			$break = false;

			if (Functions::get_formatted_date($value['data']['started_date']) < $params['started_date'] OR Functions::get_formatted_date($value['data']['started_date']) > $params['date_end'])
				$break = true;

			if ($chart == 'v_oa_chart' OR $chart == 'v_r_chart' OR $chart == 'v_t_chart' OR $chart == 'v_l_chart' OR $chart == 'ar_oa_chart' OR $chart == 'ar_r_chart' OR $chart == 'ar_t_chart' OR $chart == 'ar_l_chart')
			{
				if ($params['type'] != 'all' AND $value['type'] != $params['type'])
					$break = true;
			}
			else if ($chart == 'c_oa_chart' OR $chart == 'c_r_chart' OR $chart == 'c_t_chart' OR $chart == 'c_l_chart')
			{
				if ($value['type'] != 'incident')
					$break = true;
			}

			if ($break == false)
				array_push($voxes, $value);
		}

		if ($chart == 'v_oa_chart' OR $chart == 'ar_oa_chart' OR $chart == 'c_oa_chart')
		{
			$query = Functions::get_json_decoded_query($this->database->select('opportunity_areas', [
				'id',
				'name'
			], [
				'account' => Session::get_value('account')['id']
			]));
		}
		else if ($chart == 'v_r_chart' OR $chart == 'ar_r_chart' OR $chart == 'c_r_chart')
		{
			$query = $this->database->select('rooms', [
				'id',
				'number',
				'name'
			], [
				'account' => Session::get_value('account')['id']
			]);
		}
		else if ($chart == 'v_t_chart' OR $chart == 'ar_t_chart' OR $chart == 'c_t_chart')
		{
			$query = $this->database->select('tables', [
				'id',
				'number',
				'name'
			], [
				'account' => Session::get_value('account')['id']
			]);
		}
		else if ($chart == 'v_l_chart' OR $chart == 'ar_l_chart' OR $chart == 'c_l_chart')
		{
			$query = Functions::get_json_decoded_query($this->database->select('locations', [
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

		foreach ($query as $value)
		{
			if ($chart == 'v_oa_chart' OR $chart == 'v_r_chart' OR $chart == 'v_t_chart' OR $chart == 'v_l_chart')
			{
				$count = 0;

				foreach ($voxes as $subvalue)
				{
					if ($chart == 'v_oa_chart')
					{
						if ($value['id'] == $subvalue['data']['opportunity_area'])
							$count = $count + 1;
					}
					else if ($chart == 'v_r_chart')
					{
						if ($value['id'] == $subvalue['data']['room'])
							$count = $count + 1;
					}
					else if ($chart == 'v_t_chart')
					{
						if ($value['id'] == $subvalue['data']['table'])
							$count = $count + 1;
					}
					else if ($chart == 'v_l_chart')
					{
						if ($value['id'] == $subvalue['data']['location'])
							$count = $count + 1;
					}
				}

				if ($edit == true)
				{
					if ($chart == 'v_oa_chart')
						array_push($data['labels'], $value['name'][Session::get_value('account')['language']]);
					else if ($chart == 'v_r_chart')
						array_push($data['labels'], '#' . $value['number'] . " " . $value['name']);
					else if ($chart == 'v_t_chart')
						array_push($data['labels'], '#' . $value['number'] . " " . $value['name']);
					else if ($chart == 'v_l_chart')
						array_push($data['labels'], $value['name'][Session::get_value('account')['language']]);

					array_push($data['datasets']['data'], $count);
					array_push($data['datasets']['colors'], "'#" . str_pad(dechex(mt_rand(0,255)), 2, '0', STR_PAD_LEFT) . str_pad(dechex(mt_rand(0,255)), 2, '0', STR_PAD_LEFT) . str_pad(dechex(mt_rand(0,255)), 2, '0', STR_PAD_LEFT) . "',";
				}
				else
				{
					if ($chart == 'v_oa_chart')
						$data['labels'] .= "'" . $value['name'][Session::get_value('account')['language']] . "',";
					else if ($chart == 'v_r_chart')
						$data['labels'] .= "'#" . $value['number'] . " " . $value['name'] . "',";
					else if ($chart == 'v_t_chart')
						$data['labels'] .= "'#" . $value['number'] . " " . $value['name'] . "',";
					else if ($chart == 'v_l_chart')
						$data['labels'] .= "'" . $value['name'][Session::get_value('account')['language']] . "',";

					$data['datasets']['data'] .= $count . ',';
					$data['datasets']['colors'] .= "'#" . str_pad(dechex(mt_rand(0,255)), 2, '0', STR_PAD_LEFT) . str_pad(dechex(mt_rand(0,255)), 2, '0', STR_PAD_LEFT) . str_pad(dechex(mt_rand(0,255)), 2, '0', STR_PAD_LEFT) . "',";
				}
			}
			else if ($chart == 'ar_oa_chart' OR $chart == 'ar_r_chart' OR $chart == 'ar_t_chart' OR $chart == 'ar_l_chart')
			{
				$average = 0;
				$hours = 0;
				$count = 0;

				foreach ($voxes as $subvalue)
				{
					if ($chart == 'ar_oa_chart')
					{
						if ($value['id'] == $subvalue['data']['opportunity_area'])
						{
							$date1 = new DateTime($subvalue['data']['started_date'] . ' ' . $subvalue['data']['started_hour']);
							$date2 = new DateTime($subvalue['data']['completed_date'] . ' ' . $subvalue['data']['completed_hour']);
							$date3 = $date1->diff($date2);
							$hours = $hours + ((24 * $date3->d) + (($date3->i / 60) + $date3->h));
							$count = $count + 1;
						}
					}
					else if ($chart == 'ar_r_chart')
					{
						if ($value['id'] == $subvalue['data']['room'])
						{
							$date1 = new DateTime($subvalue['data']['started_date'] . ' ' . $subvalue['data']['started_hour']);
							$date2 = new DateTime($subvalue['data']['completed_date'] . ' ' . $subvalue['data']['completed_hour']);
							$date3 = $date1->diff($date2);
							$hours = $hours + ((24 * $date3->d) + (($date3->i / 60) + $date3->h));
							$count = $count + 1;
						}
					}
					else if ($chart == 'ar_t_chart')
					{
						if ($value['id'] == $subvalue['data']['table'])
						{
							$date1 = new DateTime($subvalue['data']['started_date'] . ' ' . $subvalue['data']['started_hour']);
							$date2 = new DateTime($subvalue['data']['completed_date'] . ' ' . $subvalue['data']['completed_hour']);
							$date3 = $date1->diff($date2);
							$hours = $hours + ((24 * $date3->d) + (($date3->i / 60) + $date3->h));
							$count = $count + 1;
						}
					}
					else if ($chart == 'ar_l_chart')
					{
						if ($value['id'] == $subvalue['data']['location'])
						{
							$date1 = new DateTime($subvalue['data']['started_date'] . ' ' . $subvalue['data']['started_hour']);
							$date2 = new DateTime($subvalue['data']['completed_date'] . ' ' . $subvalue['data']['completed_hour']);
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
					else if ($chart == 'ar_r_chart')
						array_push($data['labels'], '#' . $value['number'] . " " . $value['name']);
					else if ($chart == 'ar_t_chart')
						array_push($data['labels'], '#' . $value['number'] . " " . $value['name']);
					else if ($chart == 'ar_l_chart')
						array_push($data['labels'], $value['name'][Session::get_value('account')['language']]);

					array_push($data['datasets']['data'], $average);
					array_push($data['datasets']['colors'], "#" . str_pad(dechex(mt_rand(0,255)), 2, '0', STR_PAD_LEFT) . str_pad( dechex(mt_rand(0,255)), 2, '0', STR_PAD_LEFT) . str_pad(dechex(mt_rand(0,255)), 2, '0', STR_PAD_LEFT));
				}
				else
				{
					if ($chart == 'ar_oa_chart')
						$data['labels'] .= "'" . $value['name'][Session::get_value('account')['language']] . "',";
					else if ($chart == 'ar_r_chart')
						$data['labels'] .= "'#" . $value['number'] . " " . $value['name'] . "',";
					else if ($chart == 'ar_t_chart')
						$data['labels'] .= "'#" . $value['number'] . " " . $value['name'] . "',";
					else if ($chart == 'ar_l_chart')
						$data['labels'] .= "'" . $value['name'][Session::get_value('account')['language']] . "',";

					$data['datasets']['data'] .= $average . ',';
					$data['datasets']['colors'] .= "'#" . str_pad(dechex(mt_rand(0,255)), 2, '0', STR_PAD_LEFT) . str_pad(dechex(mt_rand(0,255)), 2, '0', STR_PAD_LEFT) . str_pad(dechex(mt_rand(0,255)), 2, '0', STR_PAD_LEFT) . "',";
				}
			}
			else if ($chart == 'c_oa_chart' OR $chart == 'c_r_chart' OR $chart == 'c_t_chart' OR $chart == 'c_l_chart')
			{
				$cost = 0;

				foreach ($voxes as $subvalue)
				{
					if ($chart == 'c_oa_chart')
					{
						if ($value['id'] == $subvalue['data']['opportunity_area'])
							$cost = !empty($subvalue['data']['cost']) ? $cost + $subvalue['data']['cost'] : $cost;
					}
					else if ($chart == 'c_r_chart')
					{
						if ($value['id'] == $subvalue['data']['room'])
							$cost = !empty($subvalue['data']['cost']) ? $cost + $subvalue['data']['cost'] : $cost;
					}
					else if ($chart == 'c_t_chart')
					{
						if ($value['id'] == $subvalue['data']['table'])
							$cost = !empty($subvalue['data']['cost']) ? $cost + $subvalue['data']['cost'] : $cost;
					}
					else if ($chart == 'c_l_chart')
					{
						if ($value['id'] == $subvalue['data']['location'])
							$cost = !empty($subvalue['data']['cost']) ? $cost + $subvalue['data']['cost'] : $cost;
					}
				}

				if ($edit == true)
				{
					if ($chart == 'c_oa_chart')
						array_push($data['labels'], $value['name'][Session::get_value('account')['language']]);
					else if ($chart == 'c_r_chart')
						array_push($data['labels'], '#' . $value['number'] . " " . $value['name']);
					else if ($chart == 'c_t_chart')
						array_push($data['labels'], '#' . $value['number'] . " " . $value['name']);
					else if ($chart == 'c_l_chart')
						array_push($data['labels'], $value['name'][Session::get_value('account')['language']]);

					array_push($data['datasets']['data'], $cost);
					array_push($data['datasets']['colors'], "#" . str_pad(dechex(mt_rand(0,255)), 2, '0', STR_PAD_LEFT) . str_pad(dechex(mt_rand(0,255)), 2, '0', STR_PAD_LEFT) . str_pad(dechex(mt_rand(0,255)), 2, '0', STR_PAD_LEFT));
				}
				else
				{
					if ($chart == 'c_oa_chart')
						$data['labels'] .= "'" . $value['name'][Session::get_value('account')['language']] . "',";
					else if ($chart == 'c_r_chart')
						$data['labels'] .= "'#" . $value['number'] . " " . $value['name'] . "',";
					else if ($chart == 'c_t_chart')
						$data['labels'] .= "'#" . $value['number'] . " " . $value['name'] . "',";
					else if ($chart == 'c_l_chart')
						$data['labels'] .= "'" . $value['name'][Session::get_value('account')['language']] . "',";

					$data['datasets']['data'] .= $cost . ',';
					$data['datasets']['colors'] .= "'#" . str_pad(dechex(mt_rand(0,255)), 2, '0', STR_PAD_LEFT) . str_pad(dechex(mt_rand(0,255)), 2, '0', STR_PAD_LEFT) . str_pad(dechex(mt_rand(0,255)), 2, '0', STR_PAD_LEFT) . "',";
				}
			}
		}

		return $data;
	}

	public function get_count($option)
	{
		$query = $this->database->select('voxes', [
			'data'
		], [
			'account' => Session::get_value('account')['id']
		]);

		$count = 0;

		foreach ($query as $key => $value)
		{
			$value['data'] = json_decode(Functions::get_openssl('decrypt', $value['data']), true);

			$break = false;

			if ($option == 'created_today' AND Functions::get_formatted_date($value['data']['started_date']) != Functions::get_current_date())
				$break = true;

			if ($option == 'created_week' AND Functions::get_formatted_date($value['data']['started_date']) < Functions::get_current_week()[0] OR Functions::get_formatted_date($value['data']['started_date']) > Functions::get_current_week()[1])
				$break = true;

			if ($option == 'created_month' AND Functions::get_formatted_date($value['data']['started_date']) < Functions::get_current_month()[0] OR Functions::get_formatted_date($value['data']['started_date']) > Functions::get_current_month()[1])
				$break = true;

			if ($option == 'created_year' AND explode('-', Functions::get_formatted_date($value['data']['started_date']))[0] != Functions::get_current_year())
				$break = true;

			if ($break == false)
				$count = $count + 1;
		}

		return $count;
	}

	public function get_general_resolution_average()
	{
		$query = $this->database->select('voxes', [
			'data'
		], [
			'account' => Session::get_value('account')['id']
		]);

		$hours = 0;
		$count = 0;

		foreach ($query as $key => $value)
		{
			$value['data'] = json_decode(Functions::get_openssl('decrypt', $value['data']), true);

			if (Functions::get_current_date_hour() >= Functions::get_formatted_date_hour($value['data']['started_date'], $value['data']['started_hour']))
			{
				$date1 = new DateTime($value['data']['started_date'] . ' ' . $value['data']['started_hour']);
				$date2 = new DateTime($value['data']['completed_date'] . ' ' . $value['data']['completed_hour']);
				$date3 = $date1->diff($date2);
				$hours = $hours + ((24 * $date3->d) + (($date3->i / 60) + $date3->h));
				$count = $count + 1;
			}
		}

		$average = $hours / $count;

		if ($average < 1)
			$average = round(($average * 60), 2) . ' Min';
		else
			$average = round($average, 2) . ' Hrs';

		return $average;
	}
}
