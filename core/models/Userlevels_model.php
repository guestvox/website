<?php

defined('_EXEC') or die;

class Userlevels_model extends Model
{
	public function __construct()
	{
		parent::__construct();
	}

	public function get_user_levels()
	{
		$query = Functions::get_json_decoded_query($this->database->select('user_levels', [
			'id',
			'name',
            'user_permissions'
		], [
			'account' => Session::get_value('account')['id'],
			'ORDER' => [
				'name' => 'ASC'
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

    public function get_user_level($id)
	{
		$query = Functions::get_json_decoded_query($this->database->select('user_levels', [
			'name',
            'user_permissions'
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

	public function new_user_level($data)
	{
		$query = null;

		$exist = $this->database->count('user_levels', [
			'AND' => [
				'account' => Session::get_value('account')['id'],
				'name' => $data['name'],
			]
		]);

		if ($exist <= 0)
		{
			$query = $this->database->insert('user_levels', [
				'account' => Session::get_value('account')['id'],
				'name' => $data['name'],
				'user_permissions' => !empty($data['user_permissions']) ? json_encode($data['user_permissions']) : json_encode([])
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
				'name' => $data['name'],
			]
		]);

		if ($exist <= 0)
		{
			$query = $this->database->update('user_levels', [
				'name' => $data['name'],
                'user_permissions' => !empty($data['user_permissions']) ? json_encode($data['user_permissions']) : json_encode([])
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
