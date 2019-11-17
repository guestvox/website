<?php

defined('_EXEC') or die;

class Profile_model extends Model
{
	public function __construct()
	{
		parent::__construct();
	}

	public function get_profile()
	{
		$query = Functions::get_json_decoded_query($this->database->select('users', [
			'firstname',
			'lastname',
			'email',
			'phone',
			'avatar',
			'username',
			'user_permissions'
		], [
			'id' => Session::get_value('user')['id']
		]));

		if (!empty($query))
		{
            $a = [
                'supervision' => false,
                'operational' => false,
                'administrative' => false,
            ];

            $query[0]['user_permissions'] = $this->database->select('user_permissions', [
                'type'
            ], [
                'id' => $query[0]['user_permissions']
            ]);

            foreach ($query[0]['user_permissions'] as $value)
            {
                if ($value['type'] == 'supervision')
                    $a['supervision'] = true;

                if ($value['type'] == 'operational')
                    $a['operational'] = true;

                if ($value['type'] == 'administrative')
                    $a['administrative'] = true;
            }

			$query[0]['user_permissions'] = $a;

			return $query[0];
		}
		else
			return null;
	}

	public function get_ladas()
	{
		$query = Functions::get_json_decoded_query($this->database->select('countries', [
			'name',
			'lada',
		], [
			'ORDER' => [
				'name' => 'ASC'
			]
		]));

		return $query;
	}

	public function edit_avatar($data)
	{
		$data['avatar'] = Functions::uploader($data['avatar']);

		if (!empty($data['avatar']))
		{
			$query = $this->database->update('users', [
				'avatar' => $data['avatar'],
			], [
				'id' => Session::get_value('user')['id'],
			]);

			if (!empty($query))
				return $data['avatar'];
			else
				return null;
		}
		else
			return null;
	}

	public function edit_profile($data)
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
		], [
			'id' => Session::get_value('user')['id'],
		]);

		return $query;
	}

	public function restore_password($data)
	{
		$query = $this->database->update('users', [
			'password' => $this->security->create_password($data['password']),
		], [
			'id' => Session::get_value('user')['id'],
		]);

		return $query;
	}
}
