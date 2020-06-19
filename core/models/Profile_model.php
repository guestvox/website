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
			'username'
		], [
			'id' => Session::get_value('user')['id']
		]));

		return !empty($query) ? $query[0] : null;
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

		return array_merge($query1, $query2);
	}

	public function check_exist_user($field, $value)
	{
		$count = $this->database->count('users', [
			'id[!]' => Session::get_value('user')['id'],
			$field => $value
		]);

		return ($count > 0) ? true : false;
	}

	public function edit_avatar($data)
	{
		$data['avatar'] = Functions::uploader($data['avatar'], Session::get_value('account')['path'] . '_user_avatar_');

		$query = $this->database->update('users', [
			'avatar' => $data['avatar']
		], [
			'id' => Session::get_value('user')['id']
		]);

		if (!empty($query))
		{
			Functions::undoloader(Session::get_value('user')['avatar']);

			return $data['avatar'];
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
			'username' => $data['username']
		], [
			'id' => Session::get_value('user')['id']
		]);

		return $query;
	}

	public function restore_password($data)
	{
		$query = $this->database->update('users', [
			'password' => $this->security->create_password($data['password'])
		], [
			'id' => Session::get_value('user')['id']
		]);

		return $query;
	}
}
