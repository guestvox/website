<?php

defined('_EXEC') or die;

class Reservationsstatuses_model extends Model
{
	public function __construct()
	{
		parent::__construct();
	}

    public function get_reservations_statuses()
	{
		$query = $this->database->select('reservations_statuses', [
			'id',
			'name',
			'status'
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
		$query = $this->database->select('reservations_statuses', [
			'name'
		], [
			'id' => $id
		]);

		return !empty($query) ? $query[0] : null;
	}

	public function new_reservation_status($data)
	{
		$query = $this->database->insert('reservations_statuses', [
			'account' => Session::get_value('account')['id'],
			'name' => $data['name'],
			'status' => true
		]);

		return $query;
	}

	public function edit_reservation_status($data)
	{
		$query = $this->database->update('reservations_statuses', [
			'name' => $data['name']
		], [
			'id' => $data['id']
		]);

		return $query;
	}

	public function deactivate_reservation_status($id)
	{
		$query = $this->database->update('reservations_statuses', [
			'status' => false
		], [
			'id' => $id
		]);

		return $query;
	}

	public function activate_reservation_status($id)
	{
		$query = $this->database->update('reservations_statuses', [
			'status' => true
		], [
			'id' => $id
		]);

		return $query;
	}

	public function delete_reservation_status($id)
	{
		$query = $this->database->delete('reservations_statuses', [
			'id' => $id
		]);

		return $query;
	}
}
