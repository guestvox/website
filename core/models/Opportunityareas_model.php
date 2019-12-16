<?php

defined('_EXEC') or die;

class Opportunityareas_model extends Model
{
	public function __construct()
	{
		parent::__construct();
	}

	public function get_opportunity_areas()
	{
		$query = Functions::get_json_decoded_query($this->database->select('opportunity_areas', [
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

	public function get_opportunity_area($id)
	{
		$query = Functions::get_json_decoded_query($this->database->select('opportunity_areas', [
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

	public function new_opportunity_area($data)
	{
		$query = null;

		$exist = $this->database->count('opportunity_areas', [
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
			$query = $this->database->insert('opportunity_areas', [
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

	public function edit_opportunity_area($data)
	{
		$query = null;

		$exist = $this->database->count('opportunity_areas', [
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
			$query = $this->database->update('opportunity_areas', [
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

	public function delete_opportunity_area($id)
	{
		$query = $this->database->delete('opportunity_areas', [
			'id' => $id
		]);

		return $query;
	}
}
