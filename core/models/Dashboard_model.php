<?php

defined('_EXEC') or die;

class Dashboard_model extends Model
{
	public function __construct()
	{
		parent::__construct();
	}

	public function get_voxes($option = 'all', $data = null)
	{
		$where = [
			'AND' => [
				'account' => Session::get_value('account')['id']
			],
			'LIMIT' => 6
		];

		if (Functions::check_user_access(['{view_confidentiality}']) == false)
			$where['AND']['confidentiality'] = false;

		if ($option == 'all')
		{
			if (Session::get_value('settings')['voxes']['voxes']['filter']['type'] != 'all')
				$where['AND']['type'] = Session::get_value('settings')['voxes']['voxes']['filter']['type'];

			if (Session::get_value('settings')['voxes']['voxes']['filter']['owner'] != 'all')
				$where['AND']['owner'] = Session::get_value('settings')['voxes']['voxes']['filter']['owner'];

			if (Session::get_value('settings')['voxes']['voxes']['filter']['opportunity_area'] != 'all')
				$where['AND']['opportunity_area'] = Session::get_value('settings')['voxes']['voxes']['filter']['opportunity_area'];

			if (Session::get_value('settings')['voxes']['voxes']['filter']['opportunity_type'] != 'all')
				$where['AND']['opportunity_type'] = Session::get_value('settings')['voxes']['voxes']['filter']['opportunity_type'];

			if (Session::get_value('settings')['voxes']['voxes']['filter']['location'] != 'all')
				$where['AND']['location'] = Session::get_value('settings')['voxes']['voxes']['filter']['location'];

			if (Session::get_value('settings')['voxes']['voxes']['filter']['urgency'] != 'all')
				$where['AND']['urgency'] = Session::get_value('settings')['voxes']['voxes']['filter']['urgency'];

			if (Session::get_value('settings')['voxes']['voxes']['filter']['order'] == 'date_old')
			{
				$where['ORDER'] = [
					'started_date' => 'ASC',
					'started_hour' => 'ASC'
				];
			}
			else if (Session::get_value('settings')['voxes']['voxes']['filter']['order'] == 'date_down')
			{
				$where['ORDER'] = [
					'started_date' => 'DESC',
					'started_hour' => 'DESC'
				];
			}

			if (Session::get_value('settings')['voxes']['voxes']['filter']['status'] == 'open')
				$where['AND']['status'] = true;
			else if (Session::get_value('settings')['voxes']['voxes']['filter']['status'] == 'close')
				$where['AND']['status'] = false;
		}

		$query = Functions::get_json_decoded_query($this->database->select('voxes', [
			'id',
			'type',
			'token',
			'owner',
			'opportunity_area',
			'opportunity_type',
			'started_date',
			'started_hour',
			'location',
			'address',
			'cost',
			'urgency',
			'confidentiality',
			'assigned_users',
			'observations',
			'subject',
			'description',
			'action_taken',
			'guest_treatment',
			'firstname',
			'lastname',
			'guest_id',
			'guest_type',
			'reservation_number',
			'reservation_status',
			'check_in',
			'check_out',
			'attachments',
			'viewed_by',
			'comments',
			'created_user',
			'created_date',
			'created_hour',
			'edited_user',
			'edited_date',
			'edited_hour',
			'completed_user',
			'completed_date',
			'completed_hour',
			'reopened_user',
			'reopened_date',
			'reopened_hour',
			'menu_order',
			'automatic_start',
			'status',
			'origin'
		], $where));

		foreach ($query as $key => $value)
		{
			$break = true;

			if (Session::get_value('settings')['voxes']['voxes']['filter']['assigned'] == 'all')
				$break = false;
			else if (Session::get_value('settings')['voxes']['voxes']['filter']['assigned'] == 'opportunity_areas' AND in_array($value['opportunity_area'], Session::get_value('user')['opportunity_areas']))
				$break = false;
			else if (Session::get_value('settings')['voxes']['voxes']['filter']['assigned'] == 'me')
			{
				if (!empty($value['assigned_users']) AND in_array(Session::get_value('user')['id'], $value['assigned_users']))
					$break = false;
				else if (empty($value['assigned_users']) AND $value['created_user'] == Session::get_value('user')['id'])
					$break = false;
			}
			else
			{
				if (!empty($value['assigned_users']) AND in_array(Session::get_value('settings')['voxes']['voxes']['filter']['assigned'], $value['assigned_users']))
					$break = false;
				else if (empty($value['assigned_users']) AND $value['created_user'] == Session::get_value('settings')['voxes']['voxes']['filter']['assigned'])
					$break = false;
			}

			if ($break == false)
			{
				$query[$key]['owner'] = $this->get_owner($value['owner']);
				$query[$key]['opportunity_area'] = $this->get_opportunity_area($value['opportunity_area']);
				$query[$key]['opportunity_type'] = $this->get_opportunity_type($value['opportunity_type']);
				$query[$key]['location'] = $this->get_location($value['location']);

				if (Session::get_value('account')['type'] == 'hotel')
				{
					if ($value['type'] == 'request' OR $value['type'] == 'incident')
						$query[$key]['guest_treatment'] = $this->get_guest_treatment($value['guest_treatment']);
				}

				foreach ($value['assigned_users'] as $subkey => $subvalue)
					$query[$key]['assigned_users'][$subkey] = $this->get_user($subvalue);

				foreach ($value['comments'] as $subkey => $subvalue)
				{
					$query[$key]['attachments'] = array_merge($value['attachments'], $subvalue['attachments']);

					if ($option == 'report')
					{
						$query[$key]['cost'] = (!empty($value['cost']) ? $value['cost'] : 0) + (!empty($subvalue['cost']) ? $subvalue['cost'] : 0);
						$query[$key]['comments'][$subkey]['user'] = $this->get_user($subvalue['user']);
					}
				}

				if ($option == 'report')
				{
					if (Session::get_value('account')['type'] == 'hotel')
					{
						if ($value['type'] == 'incident')
						{
							$query[$key]['guest_type'] = $this->get_guest_type($value['guest_type']);
							$query[$key]['reservation_status'] = $this->get_reservation_status($value['reservation_status']);
						}
					}

					foreach ($value['viewed_by'] as $subkey => $subvalue)
						$query[$key]['viewed_by'][$subkey] = $this->get_user($subvalue);

					$query[$key]['edited_user'] = $this->get_user($value['edited_user']);
					$query[$key]['completed_user'] = $this->get_user($value['completed_user']);
					$query[$key]['reopened_user'] = $this->get_user($value['reopened_user']);
				}

				$query[$key]['created_user'] = $this->get_user($value['created_user']);

				if (Session::get_value('account')['type'] == 'hotel' OR Session::get_value('account')['type'] == 'restaurant')
					$query[$key]['menu_order'] = $this->get_menu_order($query[$key]['menu_order']);
			}
			else
				unset($query[$key]);
		}

		return $query;
	}

	public function get_voxes_average()
	{
		$query = $this->database->select('voxes', [
			'started_date',
			'started_hour',
			'completed_date',
			'completed_hour'
		], [
			'AND' => [
				'account' => Session::get_value('account')['id'],
				'started_date[<>]' => [Session::get_value('settings')['voxes']['stats']['filter']['started_date'],Session::get_value('settings')['voxes']['stats']['filter']['end_date']]
			]
		]);

		$hours = 0;
		$count = 0;
		$average = 0;

		foreach ($query as $value)
		{
			$date1 = new DateTime($value['started_date'] . ' ' . $value['started_hour']);
			$date2 = new DateTime($value['completed_date'] . ' ' . $value['completed_hour']);
			$date3 = $date1->diff($date2);
			$hours = $hours + ((24 * $date3->d) + (($date3->i / 60) + $date3->h));
			$count = $count + 1;
		}

		if ($hours > 0 AND $count > 0)
		{
			$average = $hours / $count;

			if ($average < 1)
				$average = round(($average * 60), 2) . '<span>{$lang.minutes}</span>';
			else
				$average = round($average, 2) . '<span>{$lang.hours}</span>';
		}

		return $average;
	}

	public function get_voxes_count($option)
	{
		$where = [];

		if ($option == 'open' OR $option == 'close' OR $option == 'today' OR $option == 'week' OR $option == 'month' OR $option == 'year')
		{
			$where = [
				'AND' => [
					'account' => Session::get_value('account')['id'],
				]
			];

			if ($option == 'open' OR $option == 'close')
			{
				$where['AND']['started_date[<>]'] = [Session::get_value('settings')['voxes']['stats']['filter']['started_date'],Session::get_value('settings')['voxes']['stats']['filter']['end_date']];

				if ($option == 'open')
					$where['AND']['status'] = true;
				else if ($option == 'close')
					$where['AND']['status'] = false;
			}
			else if ($option == 'today')
				$where['AND']['started_date'] = Functions::get_current_date();
			else if ($option == 'week')
				$where['AND']['started_date[<>]'] = [Functions::get_current_week()[0],Functions::get_current_week()[1]];
			else if ($option == 'month')
				$where['AND']['started_date[<>]'] = [Functions::get_current_month()[0],Functions::get_current_month()[1]];
			else if ($option == 'year')
				$where['AND']['started_date[<>]'] = [Functions::get_current_year()[0],Functions::get_current_year()[1]];
		}
		else if ($option == 'total')
			$where['account'] = Session::get_value('account')['id'];

		$query = $this->database->count('voxes', $where);

		return $query;
	}

	public function get_owner($id)
	{
		$query = Functions::get_json_decoded_query($this->database->select('owners', [
			'id',
			'name',
			'number'
		], [
			'id' => $id
		]));

		return !empty($query) ? $query[0] : null;
	}

	public function get_opportunity_area($id)
	{
		$query = Functions::get_json_decoded_query($this->database->select('opportunity_areas', [
			'id',
			'name'
		], [
			'id' => $id
		]));

		return !empty($query) ? $query[0] : null;
	}

	public function get_opportunity_type($id)
	{
		$query = Functions::get_json_decoded_query($this->database->select('opportunity_types', [
			'id',
			'name'
		], [
			'id' => $id
		]));

		return !empty($query) ? $query[0] : null;
	}

	public function get_location($id)
	{
		$query = Functions::get_json_decoded_query($this->database->select('locations', [
			'id',
			'name'
		], [
			'id' => $id
		]));

		return !empty($query) ? $query[0] : null;
	}

	public function get_guest_treatment($id)
	{
		$query = $this->database->select('guests_treatments', [
			'id',
			'name'
		], [
			'id' => $id
		]);

		return !empty($query) ? $query[0] : null;
	}

	public function get_user($id)
	{
		$query = Functions::get_json_decoded_query($this->database->select('users', [
			'id',
			'firstname',
			'lastname',
			'avatar',
			'username'
		], [
			'id' => $id
		]));

		return !empty($query) ? $query[0] : null;
	}

	public function get_guest_type($id)
	{
		$query = $this->database->select('guests_types', [
			'id',
			'name'
		], [
			'id' => $id
		]);

		return !empty($query) ? $query[0] : null;
	}

	public function get_reservation_status($id)
	{
		$query = $this->database->select('reservations_statuses', [
			'id',
			'name'
		], [
			'id' => $id
		]);

		return !empty($query) ? $query[0] : null;
	}

	public function get_menu_order($id)
	{
		$query = Functions::get_json_decoded_query($this->database->select('menu_orders', [
			'type_service',
			'delivery',
			'total',
			'currency',
			'shopping_cart'
		], [
			'id' => $id
		]));

		return !empty($query) ? $query[0] : null;
	}

	public function get_surveys_percentage($option)
	{
		$AND = [
			'account' => Session::get_value('account')['id'],
			'date[<>]' => [Session::get_value('settings')['surveys']['stats']['filter']['started_date'],Session::get_value('settings')['surveys']['stats']['filter']['end_date']]
		];

		if (Session::get_value('settings')['surveys']['stats']['filter']['owner'] != 'all')
			$AND['id'] = Session::get_value('settings')['surveys']['stats']['filter']['owner'];

		$query = Functions::get_json_decoded_query($this->database->select('surveys_answers', [
			'values'
		], [
			'AND' => $AND
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

	public function get_surveys_average()
	{
		$AND = [
			'account' => Session::get_value('account')['id'],
			'date[<>]' => [Session::get_value('settings')['surveys']['stats']['filter']['started_date'],Session::get_value('settings')['surveys']['stats']['filter']['end_date']]
		];

		if (Session::get_value('settings')['surveys']['stats']['filter']['owner'] != 'all')
			$AND['id'] = Session::get_value('settings')['surveys']['stats']['filter']['owner'];

		$query = Functions::get_json_decoded_query($this->database->select('surveys_answers', [
			'values'
		], [
			'AND' => $AND
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

	public function get_surveys_answers($option)
	{
		$AND = [
			'surveys_answers.account' => Session::get_value('account')['id'],
			'surveys_answers.date[<>]' => [Session::get_value('settings')['surveys']['answers']['filter']['started_date'],Session::get_value('settings')['surveys']['answers']['filter']['end_date']]
		];

		if (Session::get_value('settings')['surveys']['answers']['filter']['owner'] != 'all')
			$AND['owners.id'] = Session::get_value('settings')['surveys']['answers']['filter']['owner'];

		$query = Functions::get_json_decoded_query($this->database->select('surveys_answers', [
			'[>]owners' => [
				'owner' => 'id'
			]
		], [
			'surveys_answers.id',
			'surveys_answers.token',
			'owners.name(owner_name)',
			'owners.number(owner_number)',
			'surveys_answers.values',
			'surveys_answers.comment',
			'surveys_answers.firstname',
			'surveys_answers.lastname',
			'surveys_answers.email',
			'surveys_answers.phone',
			'surveys_answers.reservation',
			'surveys_answers.date',
			'surveys_answers.hour',
			'surveys_answers.public'
		], [
			'AND' => $AND,
			'ORDER' => [
				'surveys_answers.date' => 'DESC',
				'surveys_answers.hour' => 'ASC'
			],
			'LIMIT' => 6
		]));

		foreach ($query as $key => $value)
		{
			if ($option == 'raters')
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

				$query[$key]['average'] = $average;

				if (Session::get_value('settings')['surveys']['answers']['filter']['rating'] == '1' AND $average >= 2)
					unset($query[$key]);
				else if (Session::get_value('settings')['surveys']['answers']['filter']['rating'] == '2' AND ($average < 2 OR $average >= 3))
					unset($query[$key]);
				else if (Session::get_value('settings')['surveys']['answers']['filter']['rating'] == '3' AND ($average < 3 OR $average >= 4))
					unset($query[$key]);
				else if (Session::get_value('settings')['surveys']['answers']['filter']['rating'] == '4' AND ($average < 4 OR $average >= 5))
					unset($query[$key]);
				else if (Session::get_value('settings')['surveys']['answers']['filter']['rating'] == '5' AND $average < 5)
					unset($query[$key]);
			}
		}

		return $query;
	}
}
