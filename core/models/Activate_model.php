<?php

defined('_EXEC') or die;

class Activate_model extends Model
{
	public function __construct()
	{
		parent::__construct();
	}

	public function activate_user($username)
	{
		$query = $this->database->select('users', [
			'[>]accounts' => [
				'account' => 'id'
			]
		], [
			'users.id',
			'users.firstname',
			'users.lastname',
			'users.email',
			'users.status',
			'accounts.language'
		], [
			'users.username' => $username
		]);

		if (!empty($query))
		{
			if ($query[0]['status'] == false)
			{
				$this->database->update('users', [
					'status' => true
				], [
					'id' => $query[0]['id']
				]);
			}
		}

		return !empty($query) ? $query[0] : null;
	}
}
