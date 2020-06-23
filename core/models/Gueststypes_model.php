<?php

defined('_EXEC') or die;

class Gueststypes_model extends Model
{
	public function __construct()
	{
		parent::__construct();
	}

    public function get_guests_types()
	{
		$query = $this->database->select('guests_types', [
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

	public function get_guest_type($id)
	{
		$query = $this->database->select('guests_types', [
			'name'
		], [
			'id' => $id
		]);

		return !empty($query) ? $query[0] : null;
	}

	public function new_guest_type($data)
	{
		$query = $this->database->insert('guests_types', [
			'account' => Session::get_value('account')['id'],
			'name' => $data['name'],
			'status' => true
		]);

		return $query;
	}

	public function edit_guest_type($data)
	{
		$query = $this->database->update('guests_types', [
			'name' => $data['name']
		], [
			'id' => $data['id']
		]);

		return $query;
	}

	public function deactivate_guest_type($id)
	{
		$query = $this->database->update('guests_types', [
			'status' => false
		], [
			'id' => $id
		]);

		return $query;
	}

	public function activate_guest_type($id)
	{
		$query = $this->database->update('guests_types', [
			'status' => true
		], [
			'id' => $id
		]);

		return $query;
	}

	public function delete_guest_type($id)
	{
		$query = $this->database->delete('guests_types', [
			'id' => $id
		]);

		return $query;
	}
}
