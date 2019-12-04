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
			'username',
			'user_permissions',
			'status',
		], [
			'account' => Session::get_value('account')['id'],
			'ORDER' => [
				'firstname' => 'ASC'
			]
		]));

        foreach ($query as $key => $value)
        {
            $query[$key]['user_permissions'] = [
                'supervision' => false,
                'operational' => false,
                'administrative' => false,
            ];

            $value['user_permissions'] = $this->database->select('user_permissions', [
                'type'
            ], [
                'id' => $value['user_permissions']
            ]);

            foreach ($value['user_permissions'] as $subvalue)
            {
                if ($subvalue['type'] == 'supervision')
                    $query[$key]['user_permissions']['supervision'] = true;

                if ($subvalue['type'] == 'operational')
                    $query[$key]['user_permissions']['operational'] = true;

                if ($subvalue['type'] == 'administrative')
                    $query[$key]['user_permissions']['administrative'] = true;
            }
        }

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
			'user_permissions',
			'opportunity_areas',
		], [
			'id' => $id
		]));

		return !empty($query) ? $query[0] : null;
	}

	public function get_ladas()
	{
		$query1 = Functions::get_json_decoded_query($this->database->select('countries', [
			'name',
			'lada'
		], [
			'priority[!]' => null,
			'ORDER' => [
				'priority' => 'ASC'
			]
		]));

		$query2 = Functions::get_json_decoded_query($this->database->select('countries', [
			'name',
			'lada'
		], [
			'priority' => null,
			'ORDER' => [
				'name' => 'ASC'
			]
		]));

		$query = array_merge($query1, $query2);

		return $query;
	}

	public function get_user_levels()
	{
		$query = $this->database->select('user_levels', [
			'id',
			'name',
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
		$query = Functions::get_json_decoded_query($this->database->select('user_levels', [
			'user_permissions',
		], [
			'id' => $id
		]));

		return !empty($query) ? $query[0] : null;
	}

    public function get_user_permissions($type)
    {
        $query = Functions::get_json_decoded_query($this->database->select('user_permissions', [
			'id',
			'name',
            'group',
            'code',
            'unique',
		], [
			'type' => $type,
			'ORDER' => [
				'group' => 'ASC',
                'priority' => 'ASC'
			]
		]));

        $user_permissions = [];

        foreach ($query as $key => $value)
        {
            if (Functions::check_account_access([$value['group'], $value['code']], true) == true)
            {
                if (array_key_exists($value['group'], $user_permissions))
                    array_push($user_permissions[$value['group']], $value);
                else
                    $user_permissions[$value['group']] = [$value];
            }
        }

        return $user_permissions;
    }

	public function get_opportunity_areas()
    {
        $query = Functions::get_json_decoded_query($this->database->select('opportunity_areas', [
			'id',
			'name',
		], [
			'account' => Session::get_value('account')['id'],
			'ORDER' => [
				'name' => 'ASC',
			]
		]));

        return $query;
    }

	public function new_user($data)
	{
		$query = null;

		$exist = $this->database->count('users', [
			'AND' => [
				'account' => Session::get_value('account')['id'],
				'email' => $data['email'],
				'username' => $data['username'],
			]
		]);

		if ($exist <= 0)
		{
			$query = $this->database->insert('users', [
				'account' => Session::get_value('account')['id'],
				'firstname' => $data['firstname'],
				'lastname' => $data['lastname'],
				'email' => $data['email'],
				'phone' => json_encode([
					'lada' => $data['phone_lada'],
					'number' => $data['phone_number'],
				]),
				'avatar' => null,
				'username' => $data['username'],
				'password' => $this->security->create_password($data['password']),
				'user_permissions' => !empty($data['user_permissions']) ? json_encode($data['user_permissions']) : json_encode([]),
				'opportunity_areas' => !empty($data['opportunity_areas']) ? json_encode($data['opportunity_areas']) : json_encode([]),
				'status' => true
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
				'account' => Session::get_value('account')['id'],
				'email' => $data['email'],
				'username' => $data['username'],
			]
		]);

		if ($exist <= 0)
		{
			$query = $this->database->update('users', [
				'firstname' => $data['firstname'],
				'lastname' => $data['lastname'],
				'email' => $data['email'],
				'phone' => json_encode([
					'lada' => $data['phone_lada'],
					'number' => $data['phone_number'],
				]),
				'username' => $data['username'],
				'user_permissions' => !empty($data['user_permissions']) ? json_encode($data['user_permissions']) : json_encode([]),
				'opportunity_areas' => !empty($data['opportunity_areas']) ? json_encode($data['opportunity_areas']) : json_encode([]),
			], [
				'id' => $data['id']
			]);
		}

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
