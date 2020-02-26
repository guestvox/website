<?php

defined('_EXEC') or die;

class Information_model extends Model
{
	public function __construct()
	{
		parent::__construct();
	}

	public function get_myvox_informations()
	{
		$query = Functions::get_json_decoded_query($this->database->select('myvox_information', [
			'id',
			'name',
			'description',
			'image',
		], [
			'account' => Session::get_value('account')['id'],
		]));

		return $query;
	}

	public function get_myvox_information($id)
	{
		$query = Functions::get_json_decoded_query($this->database->select('myvox_information', [
			'id',
			'name',
			'description',
			'image',
		], [
			'id' => $id
		]));

		return !empty($query) ? $query[0] : null;
	}

	public function new_myvox_information($data)
	{
		$query = $this->database->insert('myvox_information', [
			'account' => Session::get_value('account')['id'],
			'name' => json_encode([
				'es' => $data['name_es'],
				'en' => $data['name_en']
			]),
			'description' => $data['description']
		]);

		return $query;
	}

	public function edit_myvox_information($data)
	{
		$query = $this->database->update('myvox_information', [
			'name' => json_encode([
				'es' => $data['name_es'],
				'en' => $data['name_en']
			]),
			'description' => $data['description']
		], [
			'id' => $data['id']
		]);

		return $query;
	}

	public function delete_myvox_information($id)
	{
		$query = $this->database->delete('myvox_information', [
			'id' => $id
		]);

		return $query;
	}
}
