<?php

defined('_EXEC') or die;

class Reports_model extends Model
{
	private $crypted;

	public function __construct()
	{
		parent::__construct();

		$this->crypted = new Crypted();
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
			$value['data'] = json_decode($this->crypted->openssl('decrypt', $value['data']), true);

			$break = false;

			if (Functions::check_access(['{views_opportunity_areas}']) == true AND !in_array($value['data']['opportunity_area'], Session::get_value('user')['opportunity_areas']))
				$break = true;

			if (Functions::check_access(['{views_own}']) == true AND $value['data']['created_user'] != Session::get_value('user')['id'] AND !in_array(Session::get_value('user')['id'], $value['data']['assigned_users']))
				$break = true;

			if (Functions::check_access(['{views_confidentiality}']) == false && $value['data']['confidentiality'] == true)
				$break = true;

			if ($data['opportunity_area'] != 'all' AND $value['data']['opportunity_area'] != $data['opportunity_area'])
				$break = true;

			if ($data['opportunity_type'] != 'all' AND $value['data']['opportunity_type'] != $data['opportunity_type'])
				$break = true;

			if ($data['room'] != 'all' AND $value['data']['room'] != $data['room'])
				$break = true;

			if ($data['location'] != 'all' AND $value['data']['location'] != $data['location'])
				$break = true;

			if ($value['data']['started_date'] < $data['started_date'] OR $value['data']['started_date'] > $data['end_date'])
				$break = true;

			if ($break == false)
			{
				$value['data']['room'] = $this->get_room($value['data']['room'])['name'];
				$value['data']['opportunity_area'] = $this->get_opportunity_area($value['data']['opportunity_area'])['name'];
				$value['data']['opportunity_type'] = $this->get_opportunity_type($value['data']['opportunity_type'])['name'];
				$value['data']['location'] = $this->get_location($value['data']['location'])['name'];

				foreach ($value['data']['assigned_users'] as $key => $subvalue)
					$value['data']['assigned_users'][$key] = $this->get_user($subvalue)['username'];

				$value['data']['guest_treatment'] = $this->get_guest_treatment($value['data']['guest_treatment'])['name'];

				if ($data['type'] == 'all' OR $data['type'] == 'incident')
				{
					$value['data']['guest_type'] = $this->get_guest_type($value['data']['guest_type'])['name'];
					$value['data']['reservation_status'] = $this->get_reservation_status($value['data']['reservation_status'])['name'];
				}

				foreach ($value['data']['comments'] as $key => $subvalue)
					$value['data']['comments'][$key]['user'] = $this->get_user($subvalue['user'])['username'];

				$value['data']['created_user'] = $this->get_user($value['data']['created_user']);
				$value['data']['created_user'] = $value['data']['created_user']['name'] . ' ' . $value['data']['created_user']['lastname'];
				$value['data']['edited_user'] = $this->get_user($value['data']['edited_user']);
				$value['data']['edited_user'] = $value['data']['edited_user']['name'] . ' ' . $value['data']['edited_user']['lastname'];
				$value['data']['completed_user'] = $this->get_user($value['data']['completed_user']);
				$value['data']['completed_user'] = $value['data']['completed_user']['name'] . ' ' . $value['data']['completed_user']['lastname'];
				$value['data']['reopened_user'] = $this->get_user($value['data']['reopened_user']);
				$value['data']['reopened_user'] = $value['data']['reopened_user']['name'] . ' ' . $value['data']['reopened_user']['lastname'];

				foreach ($value['data']['viewed_by'] as $key => $subvalue)
					$value['data']['viewed_by'][$key] = $this->get_user($subvalue)['username'];

				array_push($voxes, $value);
			}
		}

		if (!empty($voxes))
		{
			foreach ($voxes as $key => $value)
			{
				if ($data['order'] == 'room')
					$aux[$key] = $value['data']['room'];
				else if ($data['order'] == 'guest')
					$aux[$key] = $value['data']['guest_treatment'] . ' ' . $value['data']['name'] . ' ' . $value['data']['lastname'];
			}

			array_multisort($aux, SORT_ASC, $voxes);
		}

		return $voxes;
	}

	// ---

	public function get_reports()
	{
		$reports = [];

		$query = Functions::get_json_decoded_query($this->database->select('reports', [
			'id',
			'name',
			'addressed_to',
			'addressed_to_opportunity_areas',
			'addressed_to_user',
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

	public function get_report($id)
	{
		$query = Functions::get_json_decoded_query($this->database->select('reports', [
			'id',
			'name',
			'type',
			'opportunity_area',
			'opportunity_type',
			'room',
			'location',
			'order',
			'time_period',
			'addressed_to',
			'addressed_to_opportunity_areas',
			'addressed_to_user',
			'fields',
		], [
			'id' => $id
		]));

		return !empty($query) ? $query[0] : null;
	}

	public function new_report($data)
	{
		$query = null;

		$exist = $this->database->count('reports', [
			'AND' => [
				'name' => $data['name'],
				'type' => $data['type'],
				'opportunity_area' => ($data['opportunity_area'] == 'all') ? null : $data['opportunity_area'],
				'opportunity_type' => ($data['opportunity_type'] == 'all') ? null : $data['opportunity_type'],
				'room' => ($data['room'] == 'all') ? null : $data['room'],
				'location' => ($data['location'] == 'all') ? null : $data['location'],
				'order' => $data['order'],
				'time_period' => $data['time_period'],
				'addressed_to' => $data['addressed_to'],
				'addressed_to_opportunity_areas' => ($data['addressed_to'] == 'opportunity_areas') ? json_encode($data['addressed_to_opportunity_areas']) : null,
				'addressed_to_user' => ($data['addressed_to'] == 'me') ? Session::get_value('user')['id'] : null,
				'fields' => json_encode($data['fields']),
			]
		]);

		if ($exist <= 0)
		{
			$query = $this->database->insert('reports', [
				'account' => Session::get_value('account')['id'],
				'name' => $data['name'],
				'type' => $data['type'],
				'opportunity_area' => ($data['opportunity_area'] == 'all') ? null : $data['opportunity_area'],
				'opportunity_type' => ($data['opportunity_type'] == 'all') ? null : $data['opportunity_type'],
				'room' => ($data['room'] == 'all') ? null : $data['room'],
				'location' => ($data['location'] == 'all') ? null : $data['location'],
				'order' => $data['order'],
				'time_period' => $data['time_period'],
				'addressed_to' => $data['addressed_to'],
				'addressed_to_opportunity_areas' => ($data['addressed_to'] == 'opportunity_areas') ? json_encode($data['addressed_to_opportunity_areas']) : null,
				'addressed_to_user' => ($data['addressed_to'] == 'me') ? Session::get_value('user')['id'] : null,
				'fields' => json_encode($data['fields']),
			]);
		}

		return $query;
	}

	public function delete_report($id)
	{
		$query = $this->database->delete('reports', [
			'id' => $id
		]);

		return $query;
	}

	// ---

	public function get_opportunity_areas($option)
	{
		$opportunity_areas = [];

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
					$option => true,
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

		foreach ($query as $key => $value)
		{
			$break = false;

			if (Functions::check_access(['{views_opportunity_areas}']) == true AND !in_array($value['id'], Session::get_value('user')['opportunity_areas']))
				$break = true;

			if (Functions::check_access(['{views_own}']) == true AND !in_array($value['id'], Session::get_value('user')['opportunity_areas']))
				$break = true;

			if ($break == false)
				array_push($opportunity_areas, $value);
		}

		return $opportunity_areas;
	}

	public function get_opportunity_area($id)
	{
		$query = Functions::get_json_decoded_query($this->database->select('opportunity_areas', [
			'name'
		], [
			'id' => $id
		]));

		return !empty($query) ? $query[0] : null;
	}

	public function get_opportunity_types($opportunity_area, $option)
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
					$option => true,
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
			'name'
		], [
			'id' => $id,
		]));

		return !empty($query) ? $query[0] : null;
	}

	public function get_rooms()
	{
		$query = $this->database->select('rooms', [
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

	public function get_room($id)
	{
		$query = $this->database->select('rooms', [
			'name'
		], [
			'id' => $id
		]);

		return !empty($query) ? $query[0] : null;
	}

	public function get_locations($option)
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
					$option => true,
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
			'name'
		], [
			'id' => $id
		]));

		return !empty($query) ? $query[0] : null;
	}

	public function get_guest_treatment($id)
	{
		$query = $this->database->select('guest_treatments', [
			'name'
		], [
			'id' => $id
		]);

		return !empty($query) ? $query[0] : null;
	}

	public function get_guest_type($id)
	{
		$query = $this->database->select('guest_types', [
			'name'
		], [
			'id' => $id
		]);

		return !empty($query) ? $query[0] : null;
	}

	public function get_reservation_status($id)
	{
		$query = $this->database->select('reservation_status', [
			'name'
		], [
			'id' => $id
		]);

		return !empty($query) ? $query[0] : null;
	}

	public function get_user($id)
	{
		$query = $this->database->select('users', [
			'name',
			'lastname',
			'username',
		], [
			'id' => $id
		]);

		return !empty($query) ? $query[0] : null;
	}

	public function get_fields($type)
	{
		if ($type == 'all')
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
				],
			];
		}
		else if ($type == 'request')
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
				],
			];
		}
		else if ($type == 'incident')
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
				],
			];
		}
	}
}
