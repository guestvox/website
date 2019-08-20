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
		$query = $this->database->select('rooms', [
			'id',
			'account',
			'name'
		], [
			'OR' => [
				'id' => $id,
				'code' => $id,
			]
		]);

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
			$query[0]['settings'] = $this->database->select('settings', [
				'language'
			], [
				'account' => $id
			])[0];

			return $query[0];
		}
		else
			return null;
	}

    public function get_opportunity_areas($option, $account = null)
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

    public function get_locations($option, $account = null)
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

    public function new_vox($data)
	{
		$query = $this->database->insert('voxes', [
			'account' => $data['account'],
			'type' => $data['type'],
			'data' => Functions::get_openssl('encrypt', json_encode([
				'token' => $this->security->random_string(8),
				'room' => (!empty($data['room'])) ? $data['room'] : null,
				'opportunity_area' => $data['opportunity_area'],
				'opportunity_type' => $data['opportunity_type'],
				'started_date' => Functions::get_formatted_date($data['started_date']),
				'started_hour' => Functions::get_formatted_hour($data['started_hour']),
				'location' => $data['location'],
				'cost' => null,
				'urgency' => 'medium',
				'confidentiality' => null,
				'assigned_users' => [],
				'observations' => ($data['type'] == 'request') ? $data['observations'] : null,
				'subject' => null,
				'description' => ($data['type'] == 'incident') ? $data['description'] : null,
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

    public function get_users($option = null, $params = null, $account = null)
	{
		$query = null;

		if ($option == 'ids')
		{
			$query = $this->database->select('users', [
				'name',
				'lastname',
				'email',
				'cellphone',
			], [
				'id' => $params
			]);
		}
		else if ($option == 'opportunity_area')
		{
			$query = Functions::get_json_decoded_query($this->database->select('users', [
				'name',
				'lastname',
				'email',
				'cellphone',
				'opportunity_areas',
			], [
				'account' => $account
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
				'username',
			], [
				'account' => $account,
				'ORDER' => [
					'username' => 'ASC'
				]
			]);
		}

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

    public function get_guest_treatments($account = null)
	{
		$query = $this->database->select('guest_treatments', [
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
}
