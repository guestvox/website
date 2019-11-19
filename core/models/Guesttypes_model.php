<?php

defined('_EXEC') or die;

class Guesttypes_model extends Model
{
	public function __construct()
	{
		parent::__construct();
	}

	public function get_guest_types()
	{
		$query = $this->database->select('guest_types', [
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

    public function get_guest_type($id)
	{
		$query = $this->database->select('guest_types', [
			'name',
		], [
			'id' => $id
		]);

		return !empty($query) ? $query[0] : null;
	}

	public function new_guest_type($data)
	{
		$query = null;

		$exist = $this->database->count('guest_types', [
			'AND' => [
				'account' => Session::get_value('account')['id'],
				'name' => $data['name'],
			]
		]);

		if ($exist <= 0)
		{
			$query = $this->database->insert('guest_types', [
				'account' => Session::get_value('account')['id'],
				'name' =>  $data['name'],
			]);
		}

		return $query;
	}

	public function edit_guest_type($data)
	{
		$query = null;

		$exist = $this->database->count('guest_types', [
			'AND' => [
				'id[!]' => $data['id'],
				'account' => Session::get_value('account')['id'],
				'name' => $data['name'],
			]
		]);

		if ($exist <= 0)
		{
			$query = $this->database->update('guest_types', [
				'name' => $data['name'],
			], [
				'id' => $data['id']
			]);
		}

		return $query;
	}

	public function delete_guest_type($id)
	{
		$query = $this->database->delete('guest_types', [
			'id' => $id
		]);

		return $query;
	}
}
