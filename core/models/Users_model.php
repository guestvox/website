<?php

defined('_EXEC') or die;

class Users_model extends Model
{
	private $crypted;

	public function __construct()
	{
		parent::__construct();

		$this->crypted = new Crypted();
	}

	public function get_users($status, $relation = false)
	{
		$query = $this->database->select('users', [
			'[>]user_levels' => [
				'user_level' => 'id'
			]
		], [
			'users.id',
			'users.name',
			'users.lastname',
			'users.email',
			'users.cellphone',
			'users.username',
			'users.temporal_password',
			'user_levels.name(user_level)'
		], [
			'AND' => [
				'users.account' => Session::get_value('account')['id'],
				'users.status' => $status
			],
			'ORDER' => [
				'users.name' => 'ASC'
			]
		]);

		foreach ($query as $key => $value)
		{
			$query[$key]['temporal_password'] = $this->crypted->decrypt($value['temporal_password']);

			if ($relation == true)
			{
				$relation1 = $this->database->count('reports', ['addressed_to_user' => $value['id']]);
				$relation2 = false;

				// foreach ($this->database->select('voxes', ['data'], ['account' => Session::get_value('account')['id']]) as $subvalue)
				// {
				// 	$subvalue['data'] = json_decode($this->crypted->openssl('decrypt', $subvalue['data']), true);
				//
				// 	if (in_array($value['id'], $subvalue['data']['assigned_users']))
				// 		$relation2 = true;
				//
				// 	if ($value['id'] == $subvalue['data']['created_user'])
				// 		$relation2 == true;
				//
				// 	if ($value['id'] == $subvalue['data']['edited_user'])
				// 		$relation2 == true;
				//
				// 	if ($value['id'] == $subvalue['data']['completed_user'])
				// 		$relation2 == true;
				//
				// 	if ($value['id'] == $subvalue['data']['reopened_user'])
				// 		$relation2 == true;
				// }

				$query[$key]['relation'] = ($relation1 > 0 OR $relation2 == true) ? true : false;
			}
		}

		return $query;
	}

	public function get_user($id)
	{
		$query = Functions::get_json_decoded_query($this->database->select('users', [
			'id',
			'name',
			'lastname',
			'email',
			'cellphone',
			'username',
			'user_level',
			'user_permissions',
			'opportunity_areas',
		], [
			'id' => $id
		]));

		return !empty($query) ? $query[0] : null;
	}

	public function get_opportunity_areas()
	{
		$query = Functions::get_json_decoded_query($this->database->select('opportunity_areas', [
			'id',
			'name',
		], [
			'account' => Session::get_value('account')['id']
		]));

		return $query;
	}

	public function get_user_permissions($module)
	{
		$query = Functions::get_json_decoded_query($this->database->select('user_permissions', [
			'id',
			'code',
			'description',
			'unique',
		], [
			'ORDER' => [
				'priority' => 'ASC'
			]
		]));

		foreach ($query as $key => $value)
		{
			$value['code'] = str_replace('{', '', $value['code']);
			$value['code'] = str_replace('}', '', $value['code']);
			$value['code'] = explode('_', $value['code']);

			if ($value['code'][0] != $module)
				unset($query[$key]);
		}

		return $query;
	}

	public function new_user($data)
	{
		$query = null;

		$exist = $this->database->count('users', [
			'OR' => [
				'email' => $data['email'],
				'username' => $data['username'],
			]
		]);

		if ($exist <= 0)
		{
			$data['temporal_password'] = strtoupper($this->security->random_string(6));

			$query = $this->database->insert('users', [
				'account' => Session::get_value('account')['id'],
				'name' => $data['name'],
				'lastname' => $data['lastname'],
				'email' => $data['email'],
				'cellphone' => $data['cellphone'],
				'username' => $data['username'],
				'password' => $this->security->create_password($data['temporal_password']),
				'temporal_password' => $this->crypted->encrypt($data['temporal_password']),
				'user_level' => $data['user_level'],
				'user_permissions' => json_encode($data['user_permissions']),
				'opportunity_areas' => json_encode($data['opportunity_areas']),
				'status' => true,
			]);
		}

		return $query;
	}

	public function edit_user($data)
	{
		$query = null;

		$exist = $this->database->count('users', [
			'AND' => [
				'id[!]' => $data['id'],
				'OR' => [
					'email' => $data['email'],
					'username' => $data['username'],
				]
			]
		]);

		if ($exist <= 0)
		{
			$query = $this->database->update('users', [
				'name' => $data['name'],
				'lastname' => $data['lastname'],
				'email' => $data['email'],
				'cellphone' => $data['cellphone'],
				'username' => $data['username'],
				'user_level' => $data['user_level'],
				'user_permissions' => json_encode($data['user_permissions']),
				'opportunity_areas' => json_encode($data['opportunity_areas']),
			], [
				'id' => $data['id']
			]);
		}

		return $query;
	}

	public function restore_password_user($id)
	{
		$data['temporal_password'] = strtoupper($this->security->random_string(6));

		$query = $this->database->update('users', [
			'password' => $this->security->create_password($data['temporal_password']),
			'temporal_password' => $this->crypted->encrypt($data['temporal_password']),
		], [
			'id' => $id
		]);

		return $query;
	}

	public function deactivate_user($id)
	{
		$query = $this->database->update('users', [
			'status' => false,
		], [
			'id' => $id
		]);

		return $query;
	}

	public function activate_user($id)
	{
		$query = $this->database->update('users', [
			'status' => true,
		], [
			'id' => $id
		]);

		return $query;
	}

	public function delete_user($id)
	{
		$query = $this->database->delete('users', [
			'id' => $id
		]);

		return $query;
	}

	// ---

	public function get_user_levels($relation = false)
	{
		$query = $this->database->select('user_levels', [
			'id',
			'name',
		], [
			'account' => Session::get_value('account')['id']
		]);

		if ($relation == true)
		{
			foreach ($query as $key => $value)
			{
				$relation = $this->database->count('users', [
					'user_level' => $value['id']
				]);

				$query[$key]['relation'] = ($relation > 0) ? true : false;
			}
		}

		return $query;
	}

	public function get_user_level($id)
	{
		$query = Functions::get_json_decoded_query($this->database->select('user_levels', [
			'id',
			'name',
			'user_permissions',
		], [
			'id' => $id
		]));

		return !empty($query) ? $query[0] : null;
	}

	public function new_user_level($data)
	{
		$query = null;

		$exist = $this->database->count('user_levels', [
			'AND' => [
				'account' => Session::get_value('account')['id'],
				'name' => $data['name']
			]
		]);

		if ($exist <= 0)
		{
			$query = $this->database->insert('user_levels', [
				'account' => Session::get_value('account')['id'],
				'code' => null,
				'name' => $data['name'],
				'user_permissions' => json_encode($data['user_permissions'])
			]);
		}

		return $query;
	}

	public function edit_user_level($data)
	{
		$query = null;

		$exist = $this->database->count('user_levels', [
			'AND' => [
				'id[!]' => $data['id'],
				'account' => Session::get_value('account')['id'],
				'name' => $data['name']
			]
		]);

		if ($exist <= 0)
		{
			$query = $this->database->update('user_levels', [
				'name' => $data['name'],
				'user_permissions' => json_encode($data['user_permissions'])
			], [
				'id' => $data['id']
			]);
		}

		return $query;
	}

	public function delete_user_level($id)
	{
		$query = $this->database->delete('user_levels', [
			'id' => $id
		]);

		return $query;
	}
}
