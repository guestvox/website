<?php

defined('_EXEC') or die;

class Hi_model extends Model
{
	public function __construct()
	{
		parent::__construct();
	}

	public function get_webinar()
	{
		$query = $this->database->select('webinars', [
			'id',
			'image',
			'link',
			'date',
			'hour',
			'status'
		], [
			'active' => true
		]);

		return !empty($query) ? $query[0] : null;
	}

	public function new_webinar_signup($data)
	{
		$query = $this->database->insert('webinars_records', [
			'webinar' => $data['webinar'],
			'name' => $data['name'],
			'email' => $data['email'],
			'company' => $data['company'],
			'job' => $data['job'],
			'date' => Functions::get_current_date(),
			'hour' => Functions::get_current_hour()
		]);

		return $query;
	}
}
