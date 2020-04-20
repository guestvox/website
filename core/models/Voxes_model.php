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

		$where['ORDER'] = [
			'id' => 'DESC'
		];

		$query = Functions::get_json_decoded_query($this->database->select('voxes', [
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
			'guest_treatment',
			'firstname',
			'lastname',
			'attachments',
			'comments',
			'created_user'
		], $where));

		foreach ($query as $key => $value)
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

			foreach ($value['comments'] as $subvalue)
				$query[$key]['attachments'] = array_merge($value['attachments'], $subvalue['attachments']);
		}

		return $query;
	}

	public function get_vox($id, $fks = true)
	{
		$query = Functions::get_json_decoded_query($this->database->select('voxes', [
			'id',
			'type',
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
						if (Session::get_value('user')['id'] == $value['user'])
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
				{
					if (($query[0]['changes_history'][$key]['type'] == 'create' OR $query[0]['changes_history'][$key]['type'] == 'edit' OR $query[0]['changes_history'][$key]['type'] == 'complete' OR $query[0]['changes_history'][$key]['type'] == 'reopen') AND $query[0]['changes_history'][$key]['user'][0] == 'guestvox')
						$query[0]['changes_history'][$key]['user'][1] = $this->get_user($value['user'][1]);
					else if ($query[0]['changes_history'][$key]['type'] == 'viewed' OR $query[0]['changes_history'][$key]['type'] == 'new_comment')
						$query[0]['changes_history'][$key]['user'] = $this->get_user($value['user']);
				}

				if ($query[0]['created_user'][0] == 'guestvox')
					$query[0]['created_user'][1] = $this->get_user($query[0]['created_user'][1]);

				if ($query[0]['edited_user'][0] == 'guestvox')
					$query[0]['edited_user'][1] = $this->get_user($query[0]['edited_user'][1]);

				if ($query[0]['completed_user'][0] == 'guestvox')
					$query[0]['completed_user'][1] = $this->get_user($query[0]['completed_user'][1]);

				if ($query[0]['reopened_user'][0] == 'guestvox')
					$query[0]['reopened_user'][1] = $this->get_user($query[0]['reopened_user'][1]);
			}

			return $query[0];
		}
		else
			return null;
	}

	public function get_owners()
	{
		$query = $this->database->select('owners', [
			'id',
			'number',
			'name',
			'status'
		], [
			'account' => Session::get_value('account')['id'],
			'ORDER' => [
				'number' => 'ASC',
				'name' => 'ASC'
			]
		]);

		return $query;
	}

	public function get_owner($id)
	{
		$query = $this->database->select('owners', [
			'id',
			'number',
			'name',
			'status'
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
				'account' => Session::get_value('account')['id']
			];
		}
		else
		{
			$where = [
				'AND' => [
					'account' => Session::get_value('account')['id'],
					$option => true
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

	public function get_opportunity_types($opportunity_area, $option = 'all')
	{
		if ($option == 'all')
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
					$option => true
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

	public function get_locations($option = 'all')
	{
		if ($option == 'all')
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
					$option => true
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

	public function get_guest($parameter)
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
			$query = Functions::api('zaviapms', Session::get_value('account')['zaviapms'], 'get', 'room', $parameter);

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
			'username'
		], [
			'account' => Session::get_value('account')['id'],
			'ORDER' => [
				'username' => 'ASC'
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
			'email',
			'phone',
			'avatar',
			'username'
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
			'token' => Functions::get_random(8),
			'owner' => $data['owner'],
			'opportunity_area' => $data['opportunity_area'],
			'opportunity_type' => $data['opportunity_type'],
			'started_date' => Functions::get_formatted_date($data['started_date']),
			'started_hour' => Functions::get_formatted_hour($data['started_hour']),
			'location' => $data['location'],
			'cost' => ($data['type'] == 'incident' OR $data['type'] == 'workorder') ? $data['cost'] : null,
			'urgency' => $data['urgency'],
			'confidentiality' => ($data['type'] == 'incident') ? (!empty($data['confidentiality']) ? true : false) : false,
			'assigned_users' => json_encode((!empty($data['assigned_users']) ? $data['assigned_users'] : [])),
			'observations' => ($data['type'] == 'request' OR $data['type'] == 'workorder') ? $data['observations'] : null,
			'subject' => ($data['type'] == 'incident') ? $data['subject'] : null,
			'description' => ($data['type'] == 'incident') ? $data['description'] : null,
			'action_taken' => ($data['type'] == 'incident') ? $data['action_taken'] : null,
			'guest_treatment' => ($data['type'] == 'request' OR $data['type'] == 'incident') ? ((Session::get_value('account')['type'] == 'hotel') ? $data['guest_treatment'] : null) : null,
			'firstname' => ($data['type'] == 'request' OR $data['type'] == 'incident') ? $data['firstname'] : null,
			'lastname' => ($data['type'] == 'request' OR $data['type'] == 'incident') ? $data['lastname'] : null,
			'guest_id' => ($data['type'] == 'incident') ? ((Session::get_value('account')['type'] == 'hotel') ? $data['guest_id'] : null) : null,
			'guest_type' => ($data['type'] == 'incident') ? ((Session::get_value('account')['type'] == 'hotel') ? $data['guest_type'] : null) : null,
			'reservation_number' => ($data['type'] == 'incident') ? ((Session::get_value('account')['type'] == 'hotel') ? $data['reservation_number'] : null) : null,
			'reservation_status' => ($data['type'] == 'incident') ? ((Session::get_value('account')['type'] == 'hotel') ? $data['reservation_status'] : null) : null,
			'check_in' => ($data['type'] == 'incident') ? ((Session::get_value('account')['type'] == 'hotel') ? $data['check_in'] : null) : null,
			'check_out' => ($data['type'] == 'incident') ? ((Session::get_value('account')['type'] == 'hotel') ? $data['check_out'] : null) : null,
			'attachments' => json_encode((!empty($data['attachments']) ? $data['attachments'] : [])),
			'viewed_by' => json_encode([]),
			'comments' => json_encode([]),
			'changes_history' => json_encode([
				[
					'type' => 'create',
					'user' => [
						'guestvox',
						Session::get_value('user')['id']
					],
					'date' => Functions::get_current_date(),
					'hour' => Functions::get_current_hour()
				]
			]),
			'created_user' => json_encode([
				'guestvox',
				Session::get_value('user')['id']
			]),
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
		$editer = $this->get_vox($data['id'], false);

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
					'type' => 'edit',
					'fields' => [],
					'user' => [
						'guestvox',
						Session::get_value('user')['id']
					],
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
				'confidentiality' => ($data['type'] == 'incident') ? (!empty($data['confidentiality']) ? true : false) : false,
				'assigned_users' => json_encode((!empty($data['assigned_users']) ? $data['assigned_users'] : [])),
				'observations' => ($data['type'] == 'request' OR $data['type'] == 'workorder') ? $data['observations'] : null,
				'subject' => ($data['type'] == 'incident') ? $data['subject'] : null,
				'description' => ($data['type'] == 'incident') ? $data['description'] : null,
				'action_taken' => ($data['type'] == 'incident') ? $data['action_taken'] : null,
				'guest_treatment' => ($data['type'] == 'request' OR $data['type'] == 'incident') ? ((Session::get_value('account')['type'] == 'hotel') ? $data['guest_treatment'] : null) : null,
				'firstname' => ($data['type'] == 'request' OR $data['type'] == 'incident') ? $data['firstname'] : null,
				'lastname' => ($data['type'] == 'request' OR $data['type'] == 'incident') ? $data['lastname'] : null,
				'guest_id' => ($data['type'] == 'incident') ? ((Session::get_value('account')['type'] == 'hotel') ? $data['guest_id'] : null) : null,
				'guest_type' => ($data['type'] == 'incident') ? ((Session::get_value('account')['type'] == 'hotel') ? $data['guest_type'] : null) : null,
				'reservation_number' => ($data['type'] == 'incident') ? ((Session::get_value('account')['type'] == 'hotel') ? $data['reservation_number'] : null) : null,
				'reservation_status' => ($data['type'] == 'incident') ? ((Session::get_value('account')['type'] == 'hotel') ? $data['reservation_status'] : null) : null,
				'check_in' => ($data['type'] == 'incident') ? ((Session::get_value('account')['type'] == 'hotel') ? $data['check_in'] : null) : null,
				'check_out' => ($data['type'] == 'incident') ? ((Session::get_value('account')['type'] == 'hotel') ? $data['check_out'] : null) : null,
				'attachments' => json_encode((!empty($data['attachments']) ? $data['attachments'] : [])),
				'changes_history' => json_encode($data['changes_history']),
				'edited_user' => json_encode([
					'guestvox',
					Session::get_value('user')['id']
				]),
				'edited_date' => Functions::get_current_date(),
				'edited_hour' => Functions::get_current_hour()
			], [
				'id' => $data['id']
			]);
		}

		return $query;
	}

	public function complete_vox($id)
	{
		$query = null;
		$editer = $this->get_vox($id, false);

		if (!empty($editer))
		{
			array_push($editer['changes_history'], [
				'type' => 'complete',
				'user' => [
					'guestvox',
					Session::get_value('user')['id']
				],
				'date' => Functions::get_current_date(),
				'hour' => Functions::get_current_hour()
			]);

			$query = $this->database->update('voxes', [
				'changes_history' => json_encode($editer['changes_history']),
				'completed_user' => json_encode([
					'guestvox',
					Session::get_value('user')['id']
				]),
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
		$editer = $this->get_vox($id, false);

		if (!empty($editer))
		{
			array_push($editer['changes_history'], [
				'type' => 'reopen',
				'user' => [
					'guestvox',
					Session::get_value('user')['id']
				],
				'date' => Functions::get_current_date(),
				'hour' => Functions::get_current_hour()
			]);

			$query = $this->database->update('voxes', [
				'changes_history' => json_encode($editer['changes_history']),
				'reopened_user' => json_encode([
					'guestvox',
					Session::get_value('user')['id']
				]),
				'reopened_date' => Functions::get_current_date(),
				'reopened_hour' => Functions::get_current_hour(),
				'status' => 'open'
			], [
				'id' => $id
			]);
		}

		return $query;
	}

	public function new_vox_comment($data)
	{
		$query = null;
		$editer = $this->get_vox($id, false);

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

			if ($editer['type'] == 'incident' OR $editer['type'] == 'workorder')
				$editer['cost'] = (!empty($editer['cost']) ? $editer['cost'] : 0) + (!empty($data['cost']) ? $data['cost'] : 0);

			array_push($editer['comments'], [
				'user' => Session::get_value('user')['id'],
				'date' => Functions::get_current_date(),
				'hour' => Functions::get_current_hour(),
				'cost' => $data['cost'],
				'message' => $data['response_to'] . ' ' . $data['message'],
				'attachments' => !empty($data['attachments']) ? $data['attachments'] : []
			]);

			array_push($editer['changes_history'], [
				'type' => 'new_comment',
				'user' => Session::get_value('user')['id'],
				'date' => Functions::get_current_date(),
				'hour' => Functions::get_current_hour()
			]);

			$query = $this->database->update('voxes', [
				'cost' => $editer['cost'],
				'comments' => json_encode($editer['comments']),
				'changes_history' => json_encode($editer['changes_history'])
			], [
				'id' => $data['id']
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

	public function get_vox_report_fields($type = 'all')
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
						'id' => 'confidentiality',
						'name' => 'confidentiality'
					],
					[
						'id' => 'cost',
						'name' => 'cost'
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
						'id' => 'guest_treatment_name_lastname',
						'name' => 'guest_name'
					],
					[
						'id' => 'guest_type',
						'name' => 'guest_type'
					],
					[
						'id' => 'guest_id',
						'name' => 'guest_id'
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
						'id' => 'assigned_users',
						'name' => 'assigned_users'
					],
					[
						'id' => 'viewed_by',
						'name' => 'viewed_by'
					],
					[
						'id' => 'attachments',
						'name' => 'attachments'
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
					],
					[
						'id' => 'comments',
						'name' => 'comments'
					]
				];
			}

			if (Session::get_value('account')['type'] == 'restaurant')
			{
				return [
					[
						'id' => 'type',
						'name' => 'vox_type'
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
						'id' => 'confidentiality',
						'name' => 'confidentiality'
					],
					[
						'id' => 'cost',
						'name' => 'cost'
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
						'id' => 'guest_treatment_name_lastname',
						'name' => 'guest_name'
					],
					[
						'id' => 'assigned_users',
						'name' => 'assigned_users'
					],
					[
						'id' => 'viewed_by',
						'name' => 'viewed_by'
					],
					[
						'id' => 'attachments',
						'name' => 'attachments'
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
					],
					[
						'id' => 'comments',
						'name' => 'comments'
					]
				];
			}

			if (Session::get_value('account')['type'] == 'others')
			{
				return [
					[
						'id' => 'type',
						'name' => 'vox_type'
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
						'id' => 'confidentiality',
						'name' => 'confidentiality'
					],
					[
						'id' => 'cost',
						'name' => 'cost'
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
						'id' => 'guest_treatment_name_lastname',
						'name' => 'guest_name'
					],
					[
						'id' => 'assigned_users',
						'name' => 'assigned_users'
					],
					[
						'id' => 'viewed_by',
						'name' => 'viewed_by'
					],
					[
						'id' => 'attachments',
						'name' => 'attachments'
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
					],
					[
						'id' => 'comments',
						'name' => 'comments'
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
						'id' => 'guest_treatment_name_lastname',
						'name' => 'guest_name'
					],
					[
						'id' => 'assigned_users',
						'name' => 'assigned_users'
					],
					[
						'id' => 'viewed_by',
						'name' => 'viewed_by'
					],
					[
						'id' => 'attachments',
						'name' => 'attachments'
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
					],
					[
						'id' => 'comments',
						'name' => 'comments'
					]
				];
			}

			if (Session::get_value('account')['type'] == 'restaurant')
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
						'id' => 'guest_treatment_name_lastname',
						'name' => 'guest_name'
					],
					[
						'id' => 'assigned_users',
						'name' => 'assigned_users'
					],
					[
						'id' => 'viewed_by',
						'name' => 'viewed_by'
					],
					[
						'id' => 'attachments',
						'name' => 'attachments'
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
					],
					[
						'id' => 'comments',
						'name' => 'comments'
					]
				];
			}

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
						'id' => 'guest_treatment_name_lastname',
						'name' => 'guest_name'
					],
					[
						'id' => 'assigned_users',
						'name' => 'assigned_users'
					],
					[
						'id' => 'viewed_by',
						'name' => 'viewed_by'
					],
					[
						'id' => 'attachments',
						'name' => 'attachments'
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
					],
					[
						'id' => 'comments',
						'name' => 'comments'
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
						'id' => 'confidentiality',
						'name' => 'confidentiality'
					],
					[
						'id' => 'cost',
						'name' => 'cost'
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
						'id' => 'guest_treatment_name_lastname',
						'name' => 'guest_name'
					],
					[
						'id' => 'guest_type',
						'name' => 'guest_type'
					],
					[
						'id' => 'guest_id',
						'name' => 'guest_id'
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
						'id' => 'assigned_users',
						'name' => 'assigned_users'
					],
					[
						'id' => 'viewed_by',
						'name' => 'viewed_by'
					],
					[
						'id' => 'attachments',
						'name' => 'attachments'
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
					],
					[
						'id' => 'comments',
						'name' => 'comments'
					]
				];
			}

			if (Session::get_value('account')['type'] == 'restaurant')
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
						'id' => 'confidentiality',
						'name' => 'confidentiality'
					],
					[
						'id' => 'cost',
						'name' => 'cost'
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
						'id' => 'guest_treatment_name_lastname',
						'name' => 'guest_name'
					],
					[
						'id' => 'assigned_users',
						'name' => 'assigned_users'
					],
					[
						'id' => 'viewed_by',
						'name' => 'viewed_by'
					],
					[
						'id' => 'attachments',
						'name' => 'attachments'
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
					],
					[
						'id' => 'comments',
						'name' => 'comments'
					]
				];
			}

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
						'id' => 'confidentiality',
						'name' => 'confidentiality'
					],
					[
						'id' => 'cost',
						'name' => 'cost'
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
						'id' => 'guest_treatment_name_lastname',
						'name' => 'guest_name'
					],
					[
						'id' => 'assigned_users',
						'name' => 'assigned_users'
					],
					[
						'id' => 'viewed_by',
						'name' => 'viewed_by'
					],
					[
						'id' => 'attachments',
						'name' => 'attachments'
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
					],
					[
						'id' => 'comments',
						'name' => 'comments'
					]
				];
			}
		}
		else if ($type == 'workorder')
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
						'id' => 'viewed_by',
						'name' => 'viewed_by'
					],
					[
						'id' => 'attachments',
						'name' => 'attachments'
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
					],
					[
						'id' => 'comments',
						'name' => 'comments'
					]
				];
			}

			if (Session::get_value('account')['type'] == 'restaurant')
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
						'id' => 'viewed_by',
						'name' => 'viewed_by'
					],
					[
						'id' => 'attachments',
						'name' => 'attachments'
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
					],
					[
						'id' => 'comments',
						'name' => 'comments'
					]
				];
			}

			if (Session::get_value('account')['type'] == 'others')
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
						'id' => 'viewed_by',
						'name' => 'viewed_by'
					],
					[
						'id' => 'attachments',
						'name' => 'attachments'
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
					],
					[
						'id' => 'comments',
						'name' => 'comments'
					]
				];
			}
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
			else if ($value['addressed_to'] == 'me' AND Session::get_value('user')['id'] != $value['addressed_to_user'])
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
			'owner',
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
		$query = $this->database->insert('vox_reports', [
			'account' => Session::get_value('account')['id'],
			'name' => $data['name'],
			'type' => $data['type'],
			'opportunity_area' => !empty($data['opportunity_area']) ? $data['opportunity_area'] : null,
			'opportunity_type' => !empty($data['opportunity_type']) ? $data['opportunity_type'] : null,
			'owner' => $data['owner'],
			'location' => !empty($data['location']) ? $data['location'] : null,
			'order' => $data['order'],
			'time_period' => $data['time_period'],
			'addressed_to' => $data['addressed_to'],
			'addressed_to_opportunity_areas' => ($data['addressed_to'] == 'opportunity_areas') ? json_encode($data['addressed_to_opportunity_areas']) : null,
			'addressed_to_user' => ($data['addressed_to'] == 'me') ? Session::get_value('user')['id'] : null,
			'fields' => json_encode($data['fields'])
		]);

		return $query;
	}

	public function edit_vox_report($data)
	{
		$query = $this->database->update('vox_reports', [
			'name' => $data['name'],
			'type' => $data['type'],
			'opportunity_area' => !empty($data['opportunity_area']) ? $data['opportunity_area'] : null,
			'opportunity_type' => !empty($data['opportunity_type']) ? $data['opportunity_type'] : null,
			'owner' => $data['owner'],
			'location' => !empty($data['location']) ? $data['location'] : null,
			'order' => $data['order'],
			'time_period' => $data['time_period'],
			'addressed_to' => $data['addressed_to'],
			'addressed_to_opportunity_areas' => ($data['addressed_to'] == 'opportunity_areas') ? json_encode($data['addressed_to_opportunity_areas']) : null,
			'addressed_to_user' => ($data['addressed_to'] == 'me') ? Session::get_value('user')['id'] : null,
			'fields' => json_encode($data['fields'])
		], [
			'id' => $data['id']
		]);

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

		$where['AND']['OR']['started_date[<]'] = $data['started_date'];
		$where['AND']['OR']['started_date[>]'] = $data['end_date'];

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

		$query = $this->get_voxes('all', $where);

		return $query;
	}

	public function get_general_average_resolution()
	{
		$query = $this->database->select('voxes', [
			'data'
		], [
			'account' => Session::get_value('account')['id']
		]);

		$hours = 0;
		$count = 0;
		$average = 0;

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

			if ($chart == 'v_oa_chart' OR $chart == 'v_r_chart' OR $chart == 'v_l_chart' OR $chart == 'ar_oa_chart' OR $chart == 'ar_r_chart' OR $chart == 'ar_l_chart')
			{
				if ($params['type'] != 'all' AND $value['type'] != $params['type'])
					$break = true;
			}
			else if ($chart == 'c_oa_chart' OR $chart == 'c_r_chart' OR $chart == 'c_l_chart')
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
			if (Session::get_value('account')['type'] == 'hotel')
			{
				$query = $this->database->select('rooms', [
					'id',
					'number',
					'name'
				], [
					'account' => Session::get_value('account')['id']
				]);
			}

			if (Session::get_value('account')['type'] == 'restaurant')
			{
				$query = $this->database->select('tables', [
					'id',
					'number',
					'name'
				], [
					'account' => Session::get_value('account')['id']
				]);
			}

			if (Session::get_value('account')['type'] == 'others')
			{
				$query = $this->database->select('clients', [
					'id',
					'name'
				], [
					'account' => Session::get_value('account')['id']
				]);
			}
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
			if ($chart == 'v_oa_chart' OR $chart == 'v_r_chart' OR $chart == 'v_l_chart')
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
						if (Session::get_value('account')['type'] == 'hotel')
						{
							if ($value['id'] == $subvalue['data']['room'])
								$count = $count + 1;
						}

						if (Session::get_value('account')['type'] == 'restaurant')
						{
							if ($value['id'] == $subvalue['data']['table'])
								$count = $count + 1;
						}

						if (Session::get_value('account')['type'] == 'others')
						{
							if ($value['id'] == $subvalue['data']['client'])
								$count = $count + 1;
						}
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
					{
						if (Session::get_value('account')['type'] == 'hotel')
							array_push($data['labels'], '#' . $value['number'] . " " . $value['name']);

						if (Session::get_value('account')['type'] == 'restaurant')
							array_push($data['labels'], '#' . $value['number'] . " " . $value['name']);

						if (Session::get_value('account')['type'] == 'others')
							array_push($data['labels'], $value['name']);
					}
					else if ($chart == 'v_l_chart')
						array_push($data['labels'], $value['name'][Session::get_value('account')['language']]);

					array_push($data['datasets']['data'], $count);
					array_push($data['datasets']['colors'], "#" . str_pad(dechex(mt_rand(0, 255)), 2, '0', STR_PAD_LEFT) . str_pad(dechex(mt_rand(0, 255)), 2, '0', STR_PAD_LEFT) . str_pad(dechex(mt_rand(0, 255)), 2, '0', STR_PAD_LEFT));
				}
				else
				{
					if ($chart == 'v_oa_chart')
						$data['labels'] .= "'" . $value['name'][Session::get_value('account')['language']] . "',";
					else if ($chart == 'v_r_chart')
					{
						if (Session::get_value('account')['type'] == 'hotel')
							$data['labels'] .= "'#" . $value['number'] . " " . $value['name'] . "',";

						if (Session::get_value('account')['type'] == 'restaurant')
							$data['labels'] .= "'#" . $value['number'] . " " . $value['name'] . "',";

						if (Session::get_value('account')['type'] == 'others')
							$data['labels'] .= $value['name'] . "',";
					}
					else if ($chart == 'v_l_chart')
						$data['labels'] .= "'" . $value['name'][Session::get_value('account')['language']] . "',";

					$data['datasets']['data'] .= $count . ',';
					$data['datasets']['colors'] .= "'#" . str_pad(dechex(mt_rand(0, 255)), 2, '0', STR_PAD_LEFT) . str_pad(dechex(mt_rand(0, 255)), 2, '0', STR_PAD_LEFT) . str_pad(dechex(mt_rand(0, 255)), 2, '0', STR_PAD_LEFT) . "',";
				}
			}
			else if ($chart == 'ar_oa_chart' OR $chart == 'ar_r_chart' OR $chart == 'ar_l_chart')
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
						if (Session::get_value('account')['type'] == 'hotel')
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

						if (Session::get_value('account')['type'] == 'restaurant')
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

						if (Session::get_value('account')['type'] == 'others')
						{
							if ($value['id'] == $subvalue['data']['client'])
							{
								$date1 = new DateTime($subvalue['data']['started_date'] . ' ' . $subvalue['data']['started_hour']);
								$date2 = new DateTime($subvalue['data']['completed_date'] . ' ' . $subvalue['data']['completed_hour']);
								$date3 = $date1->diff($date2);
								$hours = $hours + ((24 * $date3->d) + (($date3->i / 60) + $date3->h));
								$count = $count + 1;
							}
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
					{
						if (Session::get_value('account')['type'] == 'hotel')
							array_push($data['labels'], '#' . $value['number'] . " " . $value['name']);

						if (Session::get_value('account')['type'] == 'restaurant')
							array_push($data['labels'], '#' . $value['number'] . " " . $value['name']);

						if (Session::get_value('account')['type'] == 'others')
							array_push($data['labels'], $value['name']);
					}
					else if ($chart == 'ar_l_chart')
						array_push($data['labels'], $value['name'][Session::get_value('account')['language']]);

					array_push($data['datasets']['data'], $average);
					array_push($data['datasets']['colors'], "#" . str_pad(dechex(mt_rand(0, 255)), 2, '0', STR_PAD_LEFT) . str_pad( dechex(mt_rand(0, 255)), 2, '0', STR_PAD_LEFT) . str_pad(dechex(mt_rand(0, 255)), 2, '0', STR_PAD_LEFT));
				}
				else
				{
					if ($chart == 'ar_oa_chart')
						$data['labels'] .= "'" . $value['name'][Session::get_value('account')['language']] . "',";
					else if ($chart == 'ar_r_chart')
					{
						if (Session::get_value('account')['type'] == 'hotel')
							$data['labels'] .= "'#" . $value['number'] . " " . $value['name'] . "',";

						if (Session::get_value('account')['type'] == 'restaurant')
							$data['labels'] .= "'#" . $value['number'] . " " . $value['name'] . "',";

						if (Session::get_value('account')['type'] == 'others')
							$data['labels'] .= $value['name'] . "',";
					}
					else if ($chart == 'ar_l_chart')
						$data['labels'] .= "'" . $value['name'][Session::get_value('account')['language']] . "',";

					$data['datasets']['data'] .= $average . ',';
					$data['datasets']['colors'] .= "'#" . str_pad(dechex(mt_rand(0, 255)), 2, '0', STR_PAD_LEFT) . str_pad(dechex(mt_rand(0, 255)), 2, '0', STR_PAD_LEFT) . str_pad(dechex(mt_rand(0, 255)), 2, '0', STR_PAD_LEFT) . "',";
				}
			}
			else if ($chart == 'c_oa_chart' OR $chart == 'c_r_chart' OR $chart == 'c_l_chart')
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
						if (Session::get_value('account')['type'] == 'hotel')
						{
							if ($value['id'] == $subvalue['data']['room'])
								$cost = !empty($subvalue['data']['cost']) ? $cost + $subvalue['data']['cost'] : $cost;
						}

						if (Session::get_value('account')['type'] == 'restaurant')
						{
							if ($value['id'] == $subvalue['data']['table'])
								$cost = !empty($subvalue['data']['cost']) ? $cost + $subvalue['data']['cost'] : $cost;
						}

						if (Session::get_value('account')['type'] == 'others')
						{
							if ($value['id'] == $subvalue['data']['client'])
								$cost = !empty($subvalue['data']['cost']) ? $cost + $subvalue['data']['cost'] : $cost;
						}
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
					{
						if (Session::get_value('account')['type'] == 'hotel')
							array_push($data['labels'], '#' . $value['number'] . " " . $value['name']);

						if (Session::get_value('account')['type'] == 'restaurant')
							array_push($data['labels'], '#' . $value['number'] . " " . $value['name']);

						if (Session::get_value('account')['type'] == 'others')
							array_push($data['labels'], $value['name']);
					}
					else if ($chart == 'c_l_chart')
						array_push($data['labels'], $value['name'][Session::get_value('account')['language']]);

					array_push($data['datasets']['data'], $cost);
					array_push($data['datasets']['colors'], "#" . str_pad(dechex(mt_rand(0, 255)), 2, '0', STR_PAD_LEFT) . str_pad(dechex(mt_rand(0, 255)), 2, '0', STR_PAD_LEFT) . str_pad(dechex(mt_rand(0, 255)), 2, '0', STR_PAD_LEFT));
				}
				else
				{
					if ($chart == 'c_oa_chart')
						$data['labels'] .= "'" . $value['name'][Session::get_value('account')['language']] . "',";
					else if ($chart == 'c_r_chart')
					{
						if (Session::get_value('account')['type'] == 'hotek')
							$data['labels'] .= "'#" . $value['number'] . " " . $value['name'] . "',";

						if (Session::get_value('account')['type'] == 'restaurant')
							$data['labels'] .= "'#" . $value['number'] . " " . $value['name'] . "',";

						if (Session::get_value('account')['type'] == 'others')
							$data['labels'] .= $value['name'] . "',";
					}
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
