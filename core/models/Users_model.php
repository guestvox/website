<?php

defined('_EXEC') or die;

class Users_model extends Model
{
	public function __construct()
	{
		parent::__construct();
	}

    public function get_users()
	{
		$query = Functions::get_json_decoded_query($this->database->select('users', [
			'id',
			'firstname',
			'lastname',
			'email',
			'phone',
			'avatar',
			'status'
		], [
			'account' => Session::get_value('account')['id'],
			'ORDER' => [
				'firstname' => 'ASC',
				'lastname' => 'ASC'
			]
		]));

		return $query;
	}

	public function get_user($id)
	{
		$query = Functions::get_json_decoded_query($this->database->select('users', [
			'firstname',
			'lastname',
			'email',
			'phone',
			'username',
			'permissions',
			'opportunity_areas',
			'whatsapp',
			'status'
		], [
			'id' => $id
		]));

		return !empty($query) ? $query[0] : null;
	}

	public function get_users_levels()
	{
		$query = $this->database->select('users_levels', [
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

	public function get_user_level($id)
	{
		$query = Functions::get_json_decoded_query($this->database->select('users_levels', [
			'permissions'
		], [
			'id' => $id
		]));

		return !empty($query) ? $query[0] : null;
	}

	public function get_opportunity_areas()
    {
        $query = Functions::get_json_decoded_query($this->database->select('opportunity_areas', [
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
		]));

        return $query;
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

	public function check_exist_user($data, $field)
	{
		if ($data['action'] == 'new_user')
		{
			$where = [
				$field => $data[$field]
			];
		}
		else if ($data['action'] == 'edit_user')
		{
			$where = [
				'AND' => [
					'id[!]' => $data['id'],
					$field => $data[$field]
				]
			];
		}

		$count = $this->database->count('users', $where);

		return ($count > 0) ? true : false;
	}

	public function new_user($data)
	{
		$query = $this->database->insert('users', [
			'account' => Session::get_value('account')['id'],
			'firstname' => $data['firstname'],
			'lastname' => $data['lastname'],
			'email' => $data['email'],
			'phone' => json_encode([
				'lada' => $data['phone_lada'],
				'number' => $data['phone_number']
			]),
			'avatar' => null,
			'username' => $data['username'],
			'password' => $this->security->create_password($data['password']),
			'permissions' => json_encode($data['permissions']),
			'opportunity_areas' => json_encode((!empty($data['opportunity_areas']) ? $data['opportunity_areas'] : [])),
			'whatsapp' => !empty($data['whatsapp']) ? false : true,
			'status' => true
		]);

		return $query;
	}

	public function edit_user($data)
	{
		$query = $this->database->update('users', [
			'firstname' => $data['firstname'],
			'lastname' => $data['lastname'],
			'email' => $data['email'],
			'phone' => json_encode([
				'lada' => $data['phone_lada'],
				'number' => $data['phone_number']
			]),
			'username' => $data['username'],
			'permissions' => json_encode($data['permissions']),
			'opportunity_areas' => json_encode((!empty($data['opportunity_areas']) ? $data['opportunity_areas'] : [])),
			'whatsapp' => !empty($data['whatsapp']) ? false : true,
		], [
			'id' => $data['id']
		]);

		return $query;
	}

	public function restore_password_user($data)
	{
		$query = $this->database->update('users', [
			'password' => $this->security->create_password($data['password'])
		], [
			'id' => $data['id']
		]);

		return !empty($query) ? $this->get_user($data['id']) : null;
	}

	public function deactivate_user($id)
	{
		$query = $this->database->update('users', [
			'status' => false
		], [
			'id' => $id
		]);

		return $query;
	}

	public function activate_user($id)
	{
		$query = $this->database->update('users', [
			'status' => true
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
}
