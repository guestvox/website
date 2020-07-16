<?php

defined('_EXEC') or die;

class Reviews_model extends Model
{
	public function __construct()
	{
		parent::__construct();
	}

	public function get_account($path)
	{
		$query = Functions::get_json_decoded_query($this->database->select('accounts', [
			'id',
			'name',
			'type',
			'address',
			'logotype',
			'settings'
		], [
			'AND' => [
				'path' => $path,
				'status' => true
			]
		]));

		return !empty($query) ? $query[0] : null;
	}

    public function get_surveys_average($account)
	{
		$query = Functions::get_json_decoded_query($this->database->select('surveys_answers', [
			'values'
		], [
			'account' =>  $account
		]));

		$average = 0;
		$count = 0;

		foreach ($query as $value)
		{
			foreach ($value['values'] as $subkey => $subvalue)
			{
				$subvalue = $this->database->select('surveys_questions', [
					'type'
				], [
					'id' => $subkey
				]);

				$subvalue = [
					'question' => $subvalue[0]['type'],
					'answer' => $value['values'][$subkey]
				];

				if ($subvalue['question'] == 'rate')
				{
					$average = $average + $subvalue['answer'];
					$count = $count + 1;
				}
			}
		}

		if ($average > 0 AND $count > 0)
			$average = round(($average / $count), 1);

		return $average;
	}

    public function get_surveys_percentage($option, $account)
	{
		$query = Functions::get_json_decoded_query($this->database->select('surveys_answers', [
			'values'
		], [
			'account' => $account
		]));

		$percentage = 0;
		$total = 0;

		foreach ($query as $value)
		{
			$average = 0;
			$count = 0;

			foreach ($value['values'] as $subkey => $subvalue)
			{
				$subvalue = $this->database->select('surveys_questions', [
					'type'
				], [
					'id' => $subkey
				]);

				$subvalue = [
					'question' => $subvalue[0]['type'],
					'answer' => $value['values'][$subkey]
				];

				if ($subvalue['question'] == 'rate')
				{
					$average = $average + $subvalue['answer'];
					$count = $count + 1;
				}
			}

			if ($average > 0 AND $count > 0)
				$average = round(($average / $count), 1);

			if ($option == 'one' AND $average >= 1 AND $average < 1.8)
				$percentage = $percentage + 1;
			else if ($option == 'two' AND $average >= 1.8 AND $average < 2.8)
				$percentage = $percentage + 1;
			else if ($option == 'tree' AND $average >= 2.8 AND $average < 3.8)
				$percentage = $percentage + 1;
			else if ($option == 'four' AND $average >= 3.8 AND $average < 4.8)
				$percentage = $percentage + 1;
			else if ($option == 'five' AND $average > 4.8 AND $average <= 5)
				$percentage = $percentage + 1;

			$total = $total + 1;
		}

		if ($percentage > 0 AND $total > 0)
			$percentage = round((($percentage / $total) * 100), 2);

		return $percentage;
	}

	public function get_surveys_comments($account)
	{
		$query = Functions::get_json_decoded_query($this->database->select('surveys_answers', [
			'comment',
			'firstname',
			'lastname'
		], [
			'AND' => [
				'account' => $account,
				'public' => true
			],
			'ORDER' => [
				'date' => 'DESC',
				'hour' => 'DESC'
			]
		]));

		return $query;
	}
}
