<?php

defined('_EXEC') or die;

class Guesttreatments_model extends Model
{
	public function __construct()
	{
		parent::__construct();
	}

	public function get_guest_treatments()
	{
		$query = $this->database->select('guest_treatments', [
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

    public function get_guest_treatment($id)
	{
		$query = $this->database->select('guest_treatments', [
			'name',
		], [
			'id' => $id
		]);

		return !empty($query) ? $query[0] : null;
	}

	public function new_guest_treatment($data)
	{
		$query = null;

		$exist = $this->database->count('guest_treatments', [
			'AND' => [
				'account' => Session::get_value('account')['id'],
				'name' => $data['name'],
			]
		]);

		if ($exist <= 0)
		{
			$query = $this->database->insert('guest_treatments', [
				'account' => Session::get_value('account')['id'],
				'name' =>  $data['name'],
			]);
		}

		return $query;
	}

	public function edit_guest_treatment($data)
	{
		$query = null;

		$exist = $this->database->count('guest_treatments', [
			'AND' => [
				'id[!]' => $data['id'],
				'account' => Session::get_value('account')['id'],
				'name' => $data['name'],
			]
		]);

		if ($exist <= 0)
		{
			$query = $this->database->update('guest_treatments', [
				'name' => $data['name'],
			], [
				'id' => $data['id']
			]);
		}

		return $query;
	}

	public function delete_guest_treatment($id)
	{
		$query = $this->database->delete('guest_treatments', [
			'id' => $id
		]);

		return $query;
	}
}
