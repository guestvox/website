<?php

defined('_EXEC') or die;

class Reservationstatuses_model extends Model
{
	public function __construct()
	{
		parent::__construct();
	}

	public function get_reservation_statuses()
	{
		$query = $this->database->select('reservation_statuses', [
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

	public function get_reservation_status($id)
	{
		$query = $this->database->select('reservation_statuses', [
			'id',
			'name',
		], [
			'id' => $id
		]);

		return !empty($query) ? $query[0] : null;
	}

	public function new_reservation_status($data)
	{
		$query = null;

		$exist = $this->database->count('reservation_statuses', [
			'AND' => [
				'account' => Session::get_value('account')['id'],
				'name' => $data['name'],
			]
		]);

		if ($exist <= 0)
		{
			$query = $this->database->insert('reservation_statuses', [
				'account' => Session::get_value('account')['id'],
				'name' =>  $data['name'],
			]);
		}

		return $query;
	}

	public function edit_reservation_status($data)
	{
		$query = null;

		$exist = $this->database->count('reservation_statuses', [
			'AND' => [
				'id[!]' => $data['id'],
				'account' => Session::get_value('account')['id'],
				'name' => $data['name'],
			]
		]);

		if ($exist <= 0)
		{
			$query = $this->database->update('reservation_statuses', [
				'name' => $data['name'],
			], [
				'id' => $data['id']
			]);
		}

		return $query;
	}

	public function delete_reservation_status($id)
	{
		$query = $this->database->delete('reservation_statuses', [
			'id' => $id
		]);

		return $query;
	}
}
