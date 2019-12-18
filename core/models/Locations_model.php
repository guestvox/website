<?php

defined('_EXEC') or die;

class Locations_model extends Model
{
	public function __construct()
	{
		parent::__construct();
	}

	public function get_locations()
	{
		$query = Functions::get_json_decoded_query($this->database->select('locations', [
			'id',
			'name',
			'request',
			'incident',
			'workorder',
			'public'
		], [
			'account' => Session::get_value('account')['id'],
			'ORDER' => [
				'name' => 'ASC'
			]
		]));

		return $query;
	}

	public function get_location($id)
	{
		$query = Functions::get_json_decoded_query($this->database->select('locations', [
			'name',
			'request',
			'incident',
			'workorder',
			'public'
		], [
			'id' => $id
		]));

		return !empty($query) ? $query[0] : null;
	}

	public function new_location($data)
	{
		$query = null;

		$exist = $this->database->count('locations', [
			'AND' => [
				'account' => Session::get_value('account')['id'],
				'name' => json_encode([
					'es' => $data['name_es'],
					'en' => $data['name_en']
				])
			]
		]);

		if ($exist <= 0)
		{
			$query = $this->database->insert('locations', [
				'account' => Session::get_value('account')['id'],
				'name' => json_encode([
					'es' => $data['name_es'],
					'en' => $data['name_en']
				]),
				'request' => !empty($data['request']) ? true : false,
				'incident' => !empty($data['incident']) ? true : false,
				'workorder' => !empty($data['workorder']) ? true : false,
				'public' => !empty($data['public']) ? true : false
			]);
		}

		return $query;
	}

	public function edit_location($data)
	{
		$query = null;

		$exist = $this->database->count('locations', [
			'AND' => [
				'id[!]' => $data['id'],
				'account' => Session::get_value('account')['id'],
				'name' => json_encode([
					'es' => $data['name_es'],
					'en' => $data['name_en']
				])
			]
		]);

		if ($exist <= 0)
		{
			$query = $this->database->update('locations', [
				'name' => json_encode([
					'es' => $data['name_es'],
					'en' => $data['name_en']
				]),
				'request' => !empty($data['request']) ? true : false,
				'incident' => !empty($data['incident']) ? true : false,
				'workorder' => !empty($data['workorder']) ? true : false,
				'public' => !empty($data['public']) ? true : false
			], [
				'id' => $data['id']
			]);
		}

		return $query;
	}

	public function delete_location($id)
	{
		$query = $this->database->delete('locations', [
			'id' => $id
		]);

		return $query;
	}
}
