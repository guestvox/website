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

    public function get_general_average_rate($account)
	{
		$query = Functions::get_json_decoded_query($this->database->select('survey_answers', [
			'answers'
		], [
			'account' =>  $account
		]));

		$average = 0;
		$rate = 0;
		$questions = 0;

		foreach ($query as $value)
		{
			foreach ($value['answers'] as $subvalue)
			{
				if ($subvalue['type'] == 'rate')
				{
					$rate = $rate + $subvalue['answer'];
					$questions = $questions + 1;
				}

				foreach ($subvalue['subanswers'] as $parentvalue)
				{
					if ($parentvalue['type'] == 'rate')
					{
						$rate = $rate + $parentvalue['answer'];
						$questions = $questions + 1;
					}

					foreach ($parentvalue['subanswers'] as $childvalue)
					{
						if ($childvalue['type'] == 'rate')
						{
							$rate = $rate + $childvalue['answer'];
							$questions = $questions + 1;
						}
					}
				}
			}
		}

		if ($rate > 0 AND $questions > 0)
			$average = round(($rate / $questions), 1);

		return $average;
	}

	public function get_comments($account)
	{
		$query = Functions::get_json_decoded_query($this->database->select('survey_answers', [
			'comment',
			'guest'
		], [
			'AND' => [
				'account' => $account,
				'status' => true
			],
			'ORDER' => [
				'date' => 'DESC'
			]
		]));

		return $query;
	}

    public function get_percentage_rate($option, $account)
	{
		$query = Functions::get_json_decoded_query($this->database->select('survey_answers', [
			'answers'
		], [
			'account' => $account
		]));

		$percentage = 0;
		$option_answers = 0;
		$total_answers = 0;

		foreach ($query as $value)
		{
			$average = 0;
			$rate = 0;
			$answers = 0;

			foreach ($value['answers'] as $subvalue)
			{
				if ($subvalue['type'] == 'rate')
				{
					$rate = $rate + $subvalue['answer'];
					$answers = $answers + 1;
				}

				foreach ($subvalue['subanswers'] as $parentvalue)
				{
					if ($parentvalue['type'] == 'rate')
					{
						$rate = $rate + $parentvalue['answer'];
						$answers = $answers + 1;
					}

					foreach ($parentvalue['subanswers'] as $childvalue)
					{
						if ($childvalue['type'] == 'rate')
						{
							$rate = $rate + $childvalue['answer'];
							$answers = $answers + 1;
						}
					}
				}
			}

			if ($rate > 0 AND $answers > 0)
				$average = round(($rate / $answers), 2);

			if ($option == 'five' AND $average > 4.8 AND $average <= 5)
				$option_answers = $option_answers + 1;
			else if ($option == 'four' AND $average >= 3.8 AND $average < 4.8)
				$option_answers = $option_answers + 1;
			else if ($option == 'tree' AND $average >= 2.8 AND $average < 3.8)
				$option_answers = $option_answers + 1;
			else if ($option == 'two' AND $average >= 1.8 AND $average < 2.8)
				$option_answers = $option_answers + 1;
			else if ($option == 'one' AND $average >= 1 AND $average < 1.8)
				$option_answers = $option_answers + 1;

			$total_answers = $total_answers + 1;
		}

		if ($option_answers > 0 AND $total_answers > 0)
			$percentage = round((($option_answers / $total_answers) * 100), 2);

		return $percentage;
	}
}
