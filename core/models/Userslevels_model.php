<?php

defined('_EXEC') or die;

class Userslevels_model extends Model
{
	public function __construct()
	{
		parent::__construct();
	}

    public function get_users_levels()
	{
		$query = $this->database->select('users_levels', [
			'id',
			'name',
			'status'
		], [
			'account' => Session::get_value('account')['id'],
			'ORDER' => [
				'name' => 'ASC'
			]
		]);

		return $query;
	}

	public function get_user_level($id)
	{
		$query = Functions::get_json_decoded_query($this->database->select('users_levels', [
			'name',
			'permissions'
		], [
			'id' => $id
		]));

		return !empty($query) ? $query[0] : null;
	}

	public function get_permissions($type)
    {
		$permissions = [];

		$and = [
			'type' => $type,
			'OR' => [
				'digital_menu' => Functions::check_account_access(['digital_menu']),
				'operation' => Functions::check_account_access(['operation']),
				'surveys' => Functions::check_account_access(['surveys'])
			],
			Session::get_value('account')['type'] => true
		];

		$query = Functions::get_json_decoded_query($this->database->select('permissions', [
			'id',
			'name',
            'code',
            'group',
            'unique'
		], [
			'AND' => $and,
			'ORDER' => [
				'group' => 'ASC',
				'priority' => 'ASC'
			]
		]));

        foreach ($query as $key => $value)
        {
            if (array_key_exists($value['group'], $permissions))
                array_push($permissions[$value['group']], $value);
            else
                $permissions[$value['group']] = [$value];
        }

        return $permissions;
    }

	public function new_user_level($data)
	{
		$query = $this->database->insert('users_levels', [
			'account' => Session::get_value('account')['id'],
			'name' => $data['name'],
			'permissions' => json_encode($data['permissions']),
			'status' => true
		]);

		return $query;
	}

	public function edit_user_level($data)
	{
		$query = $this->database->update('users_levels', [
			'name' => $data['name'],
			'permissions' => json_encode($data['permissions'])
		], [
			'id' => $data['id']
		]);

		return $query;
	}

	public function deactivate_user_level($id)
	{
		$query = $this->database->update('users_levels', [
			'status' => false
		], [
			'id' => $id
		]);

		return $query;
	}

	public function activate_user_level($id)
	{
		$query = $this->database->update('users_levels', [
			'status' => true
		], [
			'id' => $id
		]);

		return $query;
	}

	public function delete_user_level($id)
	{
		$query = $this->database->delete('users_levels', [
			'id' => $id
		]);

		return $query;
	}
}
