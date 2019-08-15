<?php

defined('_EXEC') or die;

class Profile_model extends Model
{
	public function __construct()
	{
		parent::__construct();
	}

	public function get_user()
	{
		$query = Functions::get_json_decoded_query($this->database->select('users', [
			'[>]accounts' => [
				'account' => 'id'
			],
			'[>]user_levels' => [
				'user_level' => 'id'
			],
		], [
			'users.id',
			'accounts.name(account)',
			'users.name',
			'users.lastname',
			'users.email',
			'users.cellphone',
			'users.username',
			'users.temporal_password',
			'user_levels.name(user_level)',
			'users.user_permissions',
			'users.opportunity_areas',
			'users.status',
		], [
			'AND' => [
				'users.id' => Session::get_value('user')['id'],
			]
		]));

		if (!empty($query))
		{
			if (!empty($query[0]['temporal_password']))
				$query[0]['temporal_password'] = Functions::get_decrypt($query[0]['temporal_password']);

			if (!empty($query[0]['opportunity_areas']))
			{
				foreach ($query[0]['opportunity_areas'] as $key => $value)
				{
					$query[0]['opportunity_areas'][$key] = Functions::get_json_decoded_query($this->database->select('opportunity_areas', [
						'name'
					], [
						'id' => $value
					]))[0]['name'];
				}
			}

			if (!empty($query[0]['user_permissions']))
			{
				foreach ($query[0]['user_permissions'] as $key => $value)
				{
					$query[0]['user_permissions'][$key] = Functions::get_json_decoded_query($this->database->select('user_permissions', [
						'code'
					], [
						'id' => $value
					]))[0]['code'];
				}
			}

			return $query[0];
		}
		else
			return null;
	}

	public function edit_profile($data)
	{
		$query = $this->database->update('users', [
			'name' => $data['name'],
			'lastname' => $data['lastname'],
			'email' => $data['email'],
			'cellphone' => $data['cellphone'],
			'username' => $data['username'],
		], [
			'id' => Session::get_value('user')['id'],
		]);

		return $query;
	}

	public function reset_password($data)
	{
		$query = $this->database->update('users', [
			'password' => $this->security->create_password($data['password']),
			'temporal_password' => null,
		], [
			'id' => Session::get_value('user')['id'],
		]);

		return $query;
	}
}
