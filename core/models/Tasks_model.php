<?php

defined('_EXEC') or die;

class Tasks_model extends Model
{
	public function __construct()
	{
		parent::__construct();
	}

	public function new_task($data)
	{
		$query = $this->database->insert('tasks', [
			'account' => Session::get_value('account')['id'],
			'description' => $data['description'],
			'assigned_users' => (!empty($data['assigned_users'])) ? json_encode($data['assigned_users']) : null,
			'assigned_areas' => (!empty($data['assigned_areas'])) ? json_encode($data['assigned_areas']) : null,
			'expiration_date' => Functions::get_formatted_date($data['expiration_date']),
			'expiration_hour' => Functions::get_formatted_hour($data['expiration_hour']),
			'creation_date' => Functions::get_formatted_date($data['creation_date']),
			'repetition' => $data['repetition'],
		]);

		return $query;
	}

	public function get_users($option = null, $params = null, $public = false, $account = null)
	{
		$query = null;

		if ($public == false)
			$account = Session::get_value('account')['id'];

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

	public function get_tasks()
	{
		$query = Functions::get_json_decoded_query($this->database->select('tasks', [
			'id',
			'description',
			// 'assigned_users',
			'expiration_date',
			'expiration_hour',
			'creation_date',
			'repetition'
		], [
			'account' => Session::get_value('account')['id']
		]));

		return $query;
	}

	public function get_task($id)
	{
		$query = Functions::get_json_decoded_query($this->database->select('tasks', [
			'id',
			'account',
			'description',
			'assigned_users',
			'expiration_date',
			'expiration_hour',
			'creation_date',
			'repetition'
		], [
			'id' => $id,
		]));

		foreach ($query[0]['assigned_users'] as $key => $value)
		{
			$query[0]['assigned_users'][$key] = $this->database->select('users',[
				'id',
				'username',
			], [
				'id' => $value
			])[0]['username'];
		}

		return !empty($query) ? $query[0] : null;
	}

	public function delete_task($id)
	{
		$query = $this->database->delete('tasks', [
			'id' => $id
		]);

		return $query;
	}

	public function edit_task($data)
	{
		$query = $this->database->update('tasks', [
			'account' => Session::get_value('account')['id'],
			'description' => $data['description'],
			'assigned_users' => (!empty($data['assigned_users'])) ? json_encode($data['assigned_users']) : json_encode([]),
			'expiration_date' => Functions::get_formatted_date($data['expiration_date']),
			'expiration_hour' => Functions::get_formatted_hour($data['expiration_hour']),
			'creation_date' => Functions::get_formatted_date($data['creation_date']),
			'repetition' => $data['repetition'],
		], [
			'id' => $data['id']
		]);

		return $query;
	}

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

}
