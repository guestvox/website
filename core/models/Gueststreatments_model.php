<?php

defined('_EXEC') or die;

class Gueststreatments_model extends Model
{
	public function __construct()
	{
		parent::__construct();
	}

    public function get_guests_treatments()
	{
		$query = $this->database->select('guests_treatments', [
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

	public function get_guest_treatment($id)
	{
		$query = $this->database->select('guests_treatments', [
			'name'
		], [
			'id' => $id
		]);

		return !empty($query) ? $query[0] : null;
	}

	public function new_guest_treatment($data)
	{
		$query = $this->database->insert('guests_treatments', [
			'account' => Session::get_value('account')['id'],
			'name' => $data['name'],
			'status' => true
		]);

		return $query;
	}

	public function edit_guest_treatment($data)
	{
		$query = $this->database->update('guests_treatments', [
			'name' => $data['name']
		], [
			'id' => $data['id']
		]);

		return $query;
	}

	public function deactivate_guest_treatment($id)
	{
		$query = $this->database->update('guests_treatments', [
			'status' => false
		], [
			'id' => $id
		]);

		return $query;
	}

	public function activate_guest_treatment($id)
	{
		$query = $this->database->update('guests_treatments', [
			'status' => true
		], [
			'id' => $id
		]);

		return $query;
	}

	public function delete_guest_treatment($id)
	{
		$query = $this->database->delete('guests_treatments', [
			'id' => $id
		]);

		return $query;
	}
}
