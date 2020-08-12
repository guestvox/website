<?php

defined('_EXEC') or die;

class Myvox_model extends Model
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
			'language',
			'logotype',
			'operation',
			'reputation',
			'zaviapms',
			'settings'
		], [
			'AND' => [
				'path' => $path,
				'status' => true
			]
		]));

		return !empty($query) ? $query[0] : null;
	}

	public function get_owners($type)
	{
		$query = Functions::get_json_decoded_query($this->database->select('owners', [
			'id',
			'name',
			'number'
		], [
			'AND' => [
				'account' => Session::get_value('myvox')['account']['id'],
				$type => true,
				'public' => true,
				'status' => true
			],
			'ORDER' => [
				'number' => 'ASC',
				'name' => 'ASC'
			]
		]));

		return $query;
	}

    public function get_owner($id, $token = false)
	{
		$where = [];

		if ($token == true)
			$where['token'] = $id;
		else if ($token == false)
			$where['id'] = $id;

		$query = Functions::get_json_decoded_query($this->database->select('owners', [
			'id',
			'token',
			'name',
			'number'
		], $where));

		return !empty($query) ? $query[0] : null;
	}

	public function get_reservation($number)
	{
		$reservation = [
			'status' => 'success',
			'firstname' => '',
			'lastname' => '',
			'guest_id' => '',
			'reservation_number' => '',
			'check_in' => '',
			'check_out' => '',
			'nationality' => '',
			'input_channel' => '',
			'traveler_type' => '',
			'age_group' => ''
		];

		if (!empty($number) AND Session::get_value('myvox')['account']['zaviapms']['status'] == true)
		{
			$query = Functions::api('zaviapms', Session::get_value('myvox')['account']['zaviapms'], 'get', 'room', $number);

			$reservation['status'] = $query['Status'];

			if ($reservation['status'] == 'success')
			{
				$reservation['firstname'] = $query['Name'];
				$reservation['lastname'] = $query['LastName'];
				$reservation['guest_id'] = $query['FolioID'];
				$reservation['reservation_number'] = $query['FolioRefID'];
				$reservation['check_in'] = $query['StartDate'];
				$reservation['check_out'] = $query['EndDate'];
				$reservation['nationality'] = $query['Country'];
				$reservation['input_channel'] = $query['Channel'];
				$reservation['traveler_type'] = $query['TravelerType'];
				$reservation['age_group'] = $query['AgeGroup'];
			}
		}

		return $reservation;
	}

    public function get_opportunity_areas($type)
	{
		$query = Functions::get_json_decoded_query($this->database->select('opportunity_areas', [
			'id',
			'name'
		], [
			'AND' => [
				'account' => Session::get_value('myvox')['account']['id'],
				$type => true,
				'public' => true,
				'status' => true
			],
			'ORDER' => [
				'name' => 'ASC'
			]
		]));

		return $query;
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

    public function get_opportunity_types($opportunity_area, $type)
	{
		$query = Functions::get_json_decoded_query($this->database->select('opportunity_types', [
			'id',
			'name'
		], [
			'AND' => [
				'opportunity_area' => $opportunity_area,
				$type => true,
				'public' => true,
				'status' => true
			],
			'ORDER' => [
				'name' => 'ASC'
			]
		]));

		return $query;
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

    public function get_locations($type)
	{
		$query = Functions::get_json_decoded_query($this->database->select('locations', [
			'id',
			'name'
		], [
			'AND' => [
				'account' => Session::get_value('myvox')['account']['id'],
				$type => true,
				'public' => true,
				'status' => true
			],
			'ORDER' => [
				'name' => 'ASC'
			]
		]));

		return $query;
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

	public function get_assigned_users($opportunity_area)
	{
        $query = Functions::get_json_decoded_query($this->database->select('users', [
            'firstname',
            'lastname',
            'email',
            'phone',
            'opportunity_areas'
        ], [
            'AND' => [
				'account' => Session::get_value('myvox')['account']['id'],
				'status' => true
			]
        ]));

        foreach ($query as $key => $value)
        {
            if (!in_array($opportunity_area, $value['opportunity_areas']))
				unset($query[$key]);
        }

		return $query;
	}

	public function get_countries()
	{
		$query1 = Functions::get_json_decoded_query($this->database->select('countries', [
			'name',
			'lada'
		], [
			'priority[>=]' => 1,
			'ORDER' => [
				'priority' => 'ASC'
			]
		]));

		$query2 = Functions::get_json_decoded_query($this->database->select('countries', [
			'name',
			'lada'
		], [
			'priority[=]' => null,
			'ORDER' => [
				'name' => 'ASC'
			]
		]));

		$query = array_merge($query1, $query2);

		return $query;
	}

	public function get_menu_categories()
	{
		$categories = [];

		$query1 = Functions::get_json_decoded_query($this->database->select('menu_products', [
			'categories'
		], [
			'AND' => [
				'account' => Session::get_value('myvox')['account']['id'],
				'status' => true
			]
		]));

		foreach ($query1 as $value)
		{
			foreach ($value['categories'] as $subvalue)
			{
				if (!in_array($subvalue, $categories))
					array_push($categories, $subvalue);
			}
		}

		$query2 = Functions::get_json_decoded_query($this->database->select('menu_categories', [
			'[>]icons' => [
				'icon' => 'id'
			]
		], [
			'menu_categories.id',
			'menu_categories.name',
			'icons.url(icon_url)',
			'icons.type(icon_type)'
		], [
			'AND' => [
				'menu_categories.account' => Session::get_value('myvox')['account']['id'],
				'menu_categories.status' => true
			],
			'ORDER' => [
				'menu_categories.name' => 'ASC'
			]
		]));

		foreach ($query2 as $key => $value)
		{
			if (!in_array($value['id'], $categories))
				unset($query2[$key]);
		}

		return $query2;
	}

	public function get_menu_products()
	{
		$join = [
			'[>]icons' => [
				'icon' => 'id'
			]
		];

		$fields = [
			'menu_products.id',
			'menu_products.name',
			'menu_products.topics',
			'menu_products.price',
			'menu_products.avatar',
			'menu_products.image',
			'icons.url(icon_url)',
			'icons.type(icon_type)',
			'icons.color(icon_color)',
			'menu_products.categories'
		];

		$query1 = Functions::get_json_decoded_query($this->database->select('menu_products', $join, $fields, [
			'AND' => [
				'menu_products.account' => Session::get_value('myvox')['account']['id'],
				'menu_products.outstanding[>=]' => 1,
				'menu_products.status' => true
			],
			'ORDER' => [
				'menu_products.outstanding' => 'ASC'
			]
		]));

		$query2 = Functions::get_json_decoded_query($this->database->select('menu_products', $join, $fields, [
			'AND' => [
				'menu_products.account' => Session::get_value('myvox')['account']['id'],
				'menu_products.outstanding[=]' => null,
				'menu_products.status' => true
			],
			'ORDER' => [
				'menu_products.name' => 'ASC'
			]
		]));

		$query = array_merge($query1, $query2);

		if (!empty(Session::get_value('myvox')['menu_categories']))
		{
			foreach ($query as $key => $value)
			{
				$go = false;

				foreach ($value['categories'] as $subkey => $subvalue)
				{
					if (in_array($subvalue, Session::get_value('myvox')['menu_categories']))
						$go = true;
				}

				if ($go == false)
					unset($query[$key]);
			}
		}

		return $query;
	}

	public function get_menu_product($id)
	{
		$query = Functions::get_json_decoded_query($this->database->select('menu_products', [
			'[>]icons' => [
				'icon' => 'id'
			]
		], [
			'menu_products.name',
			'menu_products.description',
			'menu_products.topics',
			'menu_products.price',
			'menu_products.avatar',
			'menu_products.image',
			'icons.type(icon_type)',
			'icons.url(icon_url)',
			'icons.color(icon_color)'
		], [
			'menu_products.id' => $id
		]));

		if (!empty($query))
		{
			foreach ($query[0]['topics'] as $key => $value)
			{
				foreach ($value as $subkey => $subvalue)
				{
					$subvalue['topic'] = Functions::get_json_decoded_query($this->database->select('menu_topics', [
						'name'
					], [
						'id' => $subvalue['id']
					]));

					if (!empty($subvalue['topic']))
						$query[0]['topics'][$key][$subkey]['name'] = $subvalue['topic'][0]['name'];
					else
						unset($query[0]['topics'][$key][$subkey]);
				}

				if (empty($query[0]['topics'][$key]))
					unset($query[0]['topics'][$key]);
			}

			return $query[0];
		}
		else
			return null;
	}

	public function get_menu_order_total($data = null, $topics = null, $quantity = null)
	{
		$total = 0;

		if (isset($topics))
		{
			foreach ($topics as $value)
				$total = $total + $value['price'];

			$total = ($total + $data) * $quantity;
		}
		else
		{
			foreach ($data as $value)
			{
				foreach ($value as $subvalue)
					$total = $total + $subvalue['total'];
			}
		}

		return $total;
	}

	public function new_menu_order($data)
	{
		$query = $this->database->insert('menu_orders', [
			'account' => Session::get_value('myvox')['account']['id'],
			'token' => $data['token'],
			'type_service' => (Session::get_value('myvox')['account']['type'] == 'restaurant') ? ((Session::get_value('myvox')['url'] == 'delivery') ? 'delivery' : 'restaurant') : null,
			'delivery' => (Session::get_value('myvox')['account']['type'] == 'restaurant' AND Session::get_value('myvox')['url'] == 'delivery') ? $data['delivery'] : null,
			'date' => Functions::get_formatted_date($data['started_date']),
			'hour' => Functions::get_formatted_hour($data['started_hour']),
			'total' => Session::get_value('myvox')['menu_order']['total'],
			'currency' => Session::get_value('myvox')['account']['settings']['myvox']['menu']['currency'],
			'shopping_cart' => json_encode(Session::get_value('myvox')['menu_order']['shopping_cart'])
		]);

		return !empty($query) ? $this->database->id() : null;
	}

    public function new_vox($data, $from_menu_order = false)
	{
		$query = $this->database->insert('voxes', [
			'account' => Session::get_value('myvox')['account']['id'],
			'type' => $data['type'],
			'token' => $data['token'],
			'owner' => ($from_menu_order == true) ? ((Session::get_value('myvox')['account']['type'] == 'hotel' OR (Session::get_value('myvox')['account']['type'] == 'restaurant' AND (Session::get_value('myvox')['url'] == 'account' OR Session::get_value('myvox')['url'] == 'owner'))) ? Session::get_value('myvox')['owner']['id'] : null) : Session::get_value('myvox')['owner']['id'],
			'opportunity_area' => ($from_menu_order == true) ? Session::get_value('myvox')['account']['settings']['myvox']['menu']['opportunity_area'] : $data['opportunity_area'],
			'opportunity_type' => ($from_menu_order == true) ? Session::get_value('myvox')['account']['settings']['myvox']['menu']['opportunity_type'] : $data['opportunity_type'],
			'started_date' => Functions::get_formatted_date($data['started_date']),
			'started_hour' => Functions::get_formatted_hour($data['started_hour']),
			'location' => ($from_menu_order == true) ? ((Session::get_value('myvox')['account']['type'] == 'hotel') ? $data['location'] : null) : $data['location'],
			'address' => ($from_menu_order == true) ? ((Session::get_value('myvox')['account']['type'] == 'restaurant' AND Session::get_value('myvox')['url'] == 'delivery' AND $data['delivery'] == 'home') ? $data['address'] : null) : null,
			'cost' => null,
			'urgency' => 'medium',
			'confidentiality' => false,
			'assigned_users' => json_encode([]),
			'observations' => ($from_menu_order == true) ? null : (($data['type'] == 'request' AND !empty($data['observations'])) ? $data['observations'] : null),
			'subject' => null,
			'description' => ($from_menu_order == true) ? null : (($data['type'] == 'incident' AND !empty($data['description'])) ? $data['description'] : null),
			'action_taken' => null,
			'guest_treatment' => null,
			'firstname' => ($from_menu_order == true) ? ((Session::get_value('myvox')['account']['type'] == 'restaurant' AND Session::get_value('myvox')['url'] == 'delivery') ? $data['firstname'] : null) : (!empty($data['firstname']) ? $data['firstname'] : ((Session::get_value('myvox')['account']['type'] == 'hotel' AND !empty(Session::get_value('myvox')['owner']['reservation']['firstname'])) ? Session::get_value('myvox')['owner']['reservation']['firstname'] : null)),
			'lastname' => ($from_menu_order == true) ? ((Session::get_value('myvox')['account']['type'] == 'restaurant' AND Session::get_value('myvox')['url'] == 'delivery') ? $data['lastname'] : null) : (!empty($data['lastname']) ? $data['lastname'] : ((Session::get_value('myvox')['account']['type'] == 'hotel' AND !empty(Session::get_value('myvox')['owner']['reservation']['lastname'])) ? Session::get_value('myvox')['owner']['reservation']['lastname'] : null)),
			'email' => ($from_menu_order == true) ? ((Session::get_value('myvox')['account']['type'] == 'restaurant' AND Session::get_value('myvox')['url'] == 'delivery') ? (!empty($data['email']) ? $data['email'] : null) : null) : (!empty($data['email']) ? $data['email'] : null),
			'phone' => json_encode([
				'lada' => ($from_menu_order == true) ? ((Session::get_value('myvox')['account']['type'] == 'restaurant' AND Session::get_value('myvox')['url'] == 'delivery') ? $data['phone_lada'] : '') : (!empty($data['phone_lada']) ? $data['phone_lada'] : ''),
				'number' => ($from_menu_order == true) ? ((Session::get_value('myvox')['account']['type'] == 'restaurant' AND Session::get_value('myvox')['url'] == 'delivery') ? $data['phone_number'] : '') : (!empty($data['phone_number']) ? $data['phone_number'] : '')
			]),
			'guest_id' => null,
			'guest_type' => null,
			'reservation_number' => ($from_menu_order == true) ? null : ((Session::get_value('myvox')['account']['type'] == 'hotel' AND $data['type'] == 'incident' AND !empty(Session::get_value('myvox')['owner']['reservation']['reservation_number'])) ? Session::get_value('myvox')['owner']['reservation']['reservation_number'] : null),
			'reservation_status' => null,
			'check_in' => ($from_menu_order == true) ? null : ((Session::get_value('myvox')['account']['type'] == 'hotel' AND $data['type'] == 'incident' AND !empty(Session::get_value('myvox')['owner']['reservation']['check_in'])) ? Session::get_value('myvox')['owner']['reservation']['check_in'] : null),
			'check_out' => ($from_menu_order == true) ? null : ((Session::get_value('myvox')['account']['type'] == 'hotel' AND $data['type'] == 'incident' AND !empty(Session::get_value('myvox')['owner']['reservation']['check_out'])) ? Session::get_value('myvox')['owner']['reservation']['check_out'] : null),
			'attachments' => json_encode([]),
			'viewed_by' => json_encode([]),
			'comments' => json_encode([]),
			'changes_history' => json_encode([
				[
					'type' => 'created',
					'user' => null,
					'date' => Functions::get_current_date(),
					'hour' => Functions::get_current_hour()
				]
			]),
			'created_user' => null,
			'edited_user' => null,
			'completed_user' => null,
			'reopened_user' => null,
			'created_date' => Functions::get_current_date(),
			'created_hour' => Functions::get_current_hour(),
			'edited_date' => null,
			'edited_hour' => null,
			'completed_date' => null,
			'completed_hour' => null,
			'reopened_date' => null,
			'reopened_hour' => null,
			'menu_order' => ($from_menu_order == true) ? $data['menu_order'] : null,
			'status' => true,
			'origin' => 'myvox'
		]);

		return $query;
	}

	public function get_surveys_questions($parent = null)
	{
		$query1 = [];

		if (!isset($parent) OR empty($parent))
		{
			$query1 = Functions::get_json_decoded_query($this->database->select('surveys_questions', [
				'id',
				'name',
				'type',
				'values'
			], [
				'system' => true
			]));
		}

		$and = [
			'account' => Session::get_value('myvox')['account']['id'],
			'status' => true
		];

		if (!isset($parent) OR empty($parent))
			$and['parent[=]'] = null;
		else
			$and['parent'] = $parent;

		$query2 = Functions::get_json_decoded_query($this->database->select('surveys_questions', [
			'id',
			'name',
			'type',
			'values'
		], [
			'AND' => $and,
			'ORDER' => [
				'id' => 'ASC'
			]
		]));

		return array_merge($query1, $query2);
	}

	public function new_survey_answer($data)
	{
		$data['values'] = $data;

		unset($data['values']['owner']);
		unset($data['values']['comment']);
		unset($data['values']['firstname']);
		unset($data['values']['lastname']);
		unset($data['values']['email']);
		unset($data['values']['phone_lada']);
		unset($data['values']['phone_number']);
		unset($data['values']['action']);
		unset($data['values']['token']);

		foreach($data['values'] as $key => $value)
		{
			if (!isset($value) OR empty($value))
				unset($data['values'][$key]);
		}

		$query = $this->database->insert('surveys_answers', [
			'account' => Session::get_value('myvox')['account']['id'],
			'token' => $data['token'],
			'owner' => Session::get_value('myvox')['owner']['id'],
			'values' => json_encode($data['values']),
			'comment' => !empty($data['comment']) ? $data['comment'] : null,
			'firstname' => !empty($data['firstname']) ? $data['firstname'] : null,
			'lastname' => !empty($data['lastname']) ? $data['lastname'] : null,
			'email' => !empty($data['email']) ? $data['email'] : null,
			'phone' => json_encode([
				'lada' => !empty($data['phone_lada']) ? $data['phone_lada'] : '',
				'number' => !empty($data['phone_number']) ? $data['phone_number'] : ''
			]),
			'reservation' => (Session::get_value('myvox')['account']['type'] == 'hotel') ? json_encode(Session::get_value('myvox')['owner']['reservation']) : null,
			'date' => Functions::get_current_date(),
			'hour' => Functions::get_current_hour(),
			'public' => false
		]);

		return !empty($query) ? $this->database->id() : null;
	}

	public function get_survey_average($id)
	{
		$average = 0;

		$query = Functions::get_json_decoded_query($this->database->select('surveys_answers', [
			'values'
		], [
			'id' => $id
		]));

		if (!empty($query))
		{
			$count = 0;

			foreach ($query[0]['values'] as $key => $value)
			{
				$value = $this->database->select('surveys_questions', [
					'type'
				], [
					'id' => $key
				]);

				$value = [
					'question' => $value[0]['type'],
					'answer' => $query[0]['values'][$key]
				];

				if ($value['question'] == 'rate')
				{
					$average = $average + $value['answer'];
					$count = $count + 1;
				}
			}

			if ($average > 0 AND $count > 0)
				$average = round(($average / $count), 1);
		}

		return $average;
	}

	public function get_sms()
	{
		$query = $this->database->select('accounts', [
			'sms'
		], [
			'id' => Session::get_value('myvox')['account']['id']
		]);

		return !empty($query) ? $query[0]['sms'] : null;
	}

	public function edit_sms($sms)
	{
		$query = $this->database->update('accounts', [
			'sms' => $sms
		], [
			'id' => Session::get_value('myvox')['account']['id']
		]);

		return $query;
	}
}
