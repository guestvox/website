<?php

defined('_EXEC') or die;

class Opportunitytypes_model extends Model
{
	public function __construct()
	{
		parent::__construct();
	}

    public function get_opportunity_types()
	{
		$query = Functions::get_json_decoded_query($this->database->select('opportunity_types', [
			'[>]opportunity_areas' => [
				'opportunity_area' => 'id'
			]
		], [
			'opportunity_types.id',
			'opportunity_types.name',
			'opportunity_areas.name(opportunity_area)',
			'opportunity_types.request',
			'opportunity_types.incident',
			'opportunity_types.workorder',
			'opportunity_types.public',
			'opportunity_types.status'
		], [
			'opportunity_types.account' => Session::get_value('account')['id'],
			'ORDER' => [
				'opportunity_types.opportunity_area' => 'ASC',
				'opportunity_types.name' => 'ASC'
			]
		]));

		return $query;
	}

	public function get_opportunity_type($id)
	{
		$query = Functions::get_json_decoded_query($this->database->select('opportunity_types', [
			'name',
			'opportunity_area',
			'request',
			'incident',
			'workorder',
			'public'
		], [
			'id' => $id
		]));

		return !empty($query) ? $query[0] : null;
	}

	public function get_opportunity_areas()
	{
		$query = Functions::get_json_decoded_query($this->database->select('opportunity_areas', [
			'id',
			'name'
		], [
			'AND' => [
				'account' => Session::get_value('account')['id'],
				'status' => true
			],
			'ORDER' => [
				'name' => 'ASC'
			]
		]));

		return $query;
	}

	public function new_opportunity_type($data)
	{
		$query = $this->database->insert('opportunity_types', [
			'account' => Session::get_value('account')['id'],
			'name' => json_encode([
				'es' => $data['name_es'],
				'en' => $data['name_en']
			]),
			'opportunity_area' => $data['opportunity_area'],
			'request' => !empty($data['request']) ? true : false,
			'incident' => !empty($data['incident']) ? true : false,
			'workorder' => !empty($data['workorder']) ? true : false,
			'public' => !empty($data['public']) ? true : false,
			'status' => true
		]);

		return $query;
	}

	public function edit_opportunity_type($data)
	{
		$query = $this->database->update('opportunity_types', [
			'name' => json_encode([
				'es' => $data['name_es'],
				'en' => $data['name_en']
			]),
			'opportunity_area' => $data['opportunity_area'],
			'request' => !empty($data['request']) ? true : false,
			'incident' => !empty($data['incident']) ? true : false,
			'workorder' => !empty($data['workorder']) ? true : false,
			'public' => !empty($data['public']) ? true : false
		], [
			'id' => $data['id']
		]);

		return $query;
	}

	public function deactivate_opportunity_type($id)
	{
		$query = $this->database->update('opportunity_types', [
			'status' => false
		], [
			'id' => $id
		]);

		return $query;
	}

	public function activate_opportunity_type($id)
	{
		$query = $this->database->update('opportunity_types', [
			'status' => true
		], [
			'id' => $id
		]);

		return $query;
	}

	public function delete_opportunity_type($id)
	{
		$query = $this->database->delete('opportunity_types', [
			'id' => $id
		]);

		return $query;
	}
}
