<?php

defined('_EXEC') or die;

class Surveys_model extends Model
{
	public function __construct()
	{
		parent::__construct();
	}

    public function new_question($data)
	{
		$query = $this->database->insert('survey_questions', [
			'account' => Session::get_value('account')['id'],
			'question' => json_encode([
				'es' => $data['question_es'],
				'en' => $data['question_en'],
			]),
		]);

		return $query;
	}

	public function get_questions()
	{
		$query = Functions::get_json_decoded_query($this->database->select('survey_questions', [
			'id',
			'account',
			'question',
		], [
			'account' => Session::get_value('account')['id']
		]));

		return $query;

	}

	public function get_question($id)
	{
		$query = Functions::get_json_decoded_query($this->database->select('survey_questions', [
			'id',
			'question',
		], [
			'id' => $id
		]));

		return !empty($query) ? $query[0] : null;
	}

	public function edit_question($data)
	{
		$query = $this->database->update('survey_questions', [
			'question' => json_encode([
				'es' => $data['question_es'],
				'en' => $data['question_en'],
			]),
		], [
			'id' => $data['id'],
			'account' =>Session::get_value('account')['id']
		]);

		return $query;
	}

	public function delete_question($id)
	{
		$query = $this->database->delete('survey_questions', [
			'id' => $id
		]);

		return $query;
	}
}
