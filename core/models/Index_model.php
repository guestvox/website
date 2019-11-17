<?php

defined('_EXEC') or die;

class Index_model extends Model
{
	public function __construct()
	{
		parent::__construct();
	}

	public function get_countries()
	{
		$query = Functions::get_json_decoded_query($this->database->select('countries', [
			'name',
			'code',
			'lada'
		], [
			'ORDER' => [
				'name' => 'ASC'
			]
		]));

		return $query;
	}

	public function get_time_zones()
	{
		$query = $this->database->select('time_zones', [
			'code'
		], [
			'ORDER' => [
				'zone' => 'ASC'
			]
		]);

		return $query;
	}

	public function get_languages()
	{
		$query = $this->database->select('languages', [
			'name',
			'code'
		], [
			'ORDER' => [
				'name' => 'ASC'
			]
		]);

		return $query;
	}

	public function get_currencies()
	{
		$query = Functions::get_json_decoded_query($this->database->select('currencies', [
			'name',
			'code'
		], [
			'ORDER' => [
				'name' => 'ASC'
			]
		]));

		return $query;
	}

	public function get_packages($data)
	{
		$query1 = $this->database->select('room_packages', [
			'id',
			'quantity_end',
			'price',
		], [
			'AND' => [
				'quantity_start[<=]' => $data['rooms_number'],
				'quantity_end[>=]' => $data['rooms_number'],
			]
		]);

		$query2 = $this->database->select('user_packages', [
			'id',
			'quantity_end',
			'price',
		], [
			'AND' => [
				'quantity_start[<=]' => $data['users_number'],
				'quantity_end[>=]' => $data['users_number'],
			]
		]);

		$packages = [];

		$packages['room_package'] = [];
		$p1 = 0;

		if (!empty($query1))
		{
			$packages['room_package'] = $query1[0];
			$p1 = $query1[0]['price'];
		}

		$packages['user_package'] = [];
		$p2 = 0;

		if (!empty($query2))
		{
			$packages['user_package'] = $query2[0];
			$p2 = $query2[0]['price'];
		}

		$packages['total'] = $p1 + $p2;

		return $packages;
	}

	public function check_exist_account($field, $value)
	{
		$count = $this->database->count('accounts', [
			$field => $value
		]);

		return ($count > 0) ? true : false;
	}

	public function check_exist_user($field, $value)
	{
		$count = $this->database->count('users', [
			$field => $value
		]);

		return ($count > 0) ? true : false;
	}

	public function new_signup($data)
	{
		$this->database->insert('accounts', [
			'name' => $data['name'],
			'country' => $data['country'],
			'cp' => $data['cp'],
			'city' => $data['city'],
			'address' => $data['address'],
			'time_zone' => $data['time_zone'],
			'language' => $data['language'],
			'currency' => $data['currency'],
			'room_package' => $this->get_packages($data)['room_package']['id'],
			'user_package' => $this->get_packages($data)['user_package']['id'],
			'logotype' => Functions::uploader($data['logotype']),
			'fiscal_id' => strtoupper($data['fiscal_id']),
			'fiscal_name' => $data['fiscal_name'],
			'fiscal_address' => $data['fiscal_address'],
			'contact' => json_encode([
				'name' => $data['contact_name'],
				'department' => $data['contact_department'],
				'email' => $data['contact_email'],
				'phone' => [
					'lada' => $data['contact_phone_lada'],
					'number' => $data['contact_phone_number'],
				],
			]),
			'payment' => json_encode([
				'type' => 'demo'
			]),
			'operation' => true,
			'reputation' => true,
			'myvox_request' => true,
			'myvox_incident' => true,
			'myvox_survey' => true,
			'myvox_survey_title' => json_encode([
				'es' => 'Responder encuesta',
				'en' => 'Answer survey',
			]),
			'sms' => 0,
			'zav' => false,
			'signup_date' => Functions::get_current_date(),
			'status' => false,
		]);

		$account = $this->database->id();

		$this->database->insert('users', [
			'account' => $account,
			'firstname' => $data['firstname'],
			'lastname' => $data['lastname'],
			'email' => $data['email'],
			'phone' => json_encode([
				'lada' => $data['phone_lada'],
				'number' => $data['phone_number'],
			]),
			'avatar' => null,
			'username' => $data['username'],
			'password' => $this->security->create_password($data['password']),
			'user_permissions' => '["39","41","38","40","29","30","31","32","33","34","10","11","12","4","5","6","7","8","9","35","36","37","13","14","15","16","17","19","20","21","18","22","23","24","26","1","2","3"]',
			'opportunity_areas' => '[]',
			'status' => false,
		]);

		$user = $this->database->id();

		if ($data['language'] == 'es')
		{
			$administrator = 'Administrador';
			$director = 'Director';
			$manager = 'Gerente';
			$supervisor = 'Supervisor';
			$operator = 'Operador';
		}
		else if ($data['language'] == 'en')
		{
			$administrator = 'Administrator';
			$director = 'Director';
			$manager = 'Manager';
			$supervisor = 'Supervisor';
			$operator = 'Operator';
		}

		$this->database->insert('user_levels', [
			[
				'account' => $account,
				'name' => $administrator,
				'user_permissions' => '["39","41","38","40","29","30","31","32","33","34","10","11","12","4","5","6","7","8","9","35","36","37","13","14","15","16","17","19","20","21","18","22","23","24","26","1","2","3"]',
			],
			[
				'account' => $account,
				'name' => $director,
				'user_permissions' => '["25","39","41","38","26","1","2","3"]',
			],
			[
				'account' => $account,
				'name' => $manager,
				'user_permissions' => '["25","39","41","38","28","1","2","3"]',
			],
			[
				'account' => $account,
				'name' => $supervisor,
				'user_permissions' => '["39","41","38","28","1","2","3"]',
			],
			[
				'account' => $account,
				'name' => $operator,
				'user_permissions' => '["27","1","2","3"]',
			]
		]);

		if ($data['language'] == 'es')
		{
			$vacational_club = 'Club vacacional';
			$day_pass = 'Day pass';
			$external = 'Externo';
			$gold = 'Gold';
			$platinium = 'Platinium';
			$regular = 'Regular';
			$vip = 'V.I.P.';
		}
		else if ($data['language'] == 'en')
		{
			$vacational_club = 'Vacational club';
			$day_pass = 'Day pass';
			$external = 'External';
			$gold = 'Gold';
			$platinium = 'Platinium';
			$regular = 'Regular';
			$vip = 'V.I.P.';
		}

		$this->database->insert('guest_types', [
			[
				'account' => $account,
				'name' => $vacational_club,
			],
			[
				'account' => $account,
				'name' => $day_pass,
			],
			[
				'account' => $account,
				'name' => $external,
			],
			[
				'account' => $account,
				'name' => $gold,
			],
			[
				'account' => $account,
				'name' => $platinium,
			],
			[
				'account' => $account,
				'name' => $regular,
			],
			[
				'account' => $account,
				'name' => $vip,
			]
		]);

		if ($data['language'] == 'es')
		{
			$in_house = 'En casa';
			$outside_house = 'Fuera de casa';
			$pre_arrival = 'Pre llegada';
			$arrival = 'Llegada';
			$pre_departure = 'Pre salida';
			$departure = 'Salida';
		}
		else if ($data['language'] == 'en')
		{
			$in_house = 'In house';
			$outside_house = 'Outside of house';
			$pre_arrival = 'Pre arrival';
			$arrival = 'Arrival';
			$pre_departure = 'Pre departure';
			$departure = 'Departure';
		}

		$this->database->insert('reservation_statuses', [
			[
				'account' => $account,
				'name' => $in_house,
			],
			[
				'account' => $account,
				'name' => $outside_house,
			],
			[
				'account' => $account,
				'name' => $pre_arrival,
			],
			[
				'account' => $account,
				'name' => $arrival,
			],
			[
				'account' => $account,
				'name' => $departure,
			],
			[
				'account' => $account,
				'name' => $pre_departure,
			]
		]);

		if ($data['language'] == 'es')
		{
			$mr = 'Sr.';
			$miss = 'Sra.';
			$mrs = 'Srita.';
		}
		else if ($data['language'] == 'en')
		{
			$mr = 'Mr.';
			$miss = 'Miss.';
			$mrs = 'Mrs.';
		}

		$this->database->insert('guest_treatments', [
			[
				'account' => $account,
				'name' => $mr,
			],
			[
				'account' => $account,
				'name' => $miss,
			],
			[
				'account' => $account,
				'name' => $mrs,
			]
		]);

		return [
			'account' => $account,
			'user' => $user,
		];
	}

	public function get_login($data)
	{
		$query = Functions::get_json_decoded_query($this->database->select('users', [
			'[>]accounts' => [
				'account' => 'id'
			],
		], [
			'accounts.id(account_id)',
			'accounts.name(account_name)',
			'accounts.time_zone(account_time_zone)',
			'accounts.language(account_language)',
			'accounts.currency(account_currency)',
			'accounts.logotype(account_logotype)',
			'accounts.operation(account_operation)',
			'accounts.reputation(account_reputation)',
			'accounts.sms(account_sms)',
			'accounts.zav(account_zav)',
			'accounts.status(account_status)',
			'users.id(user_id)',
			'users.firstname(user_firstname)',
			'users.lastname(user_lastname)',
			'users.avatar(user_avatar)',
			'users.username(user_username)',
			'users.password(user_password)',
			'users.user_permissions(user_user_permissions)',
			'users.opportunity_areas(user_opportunity_areas)',
			'users.status(user_status)',
		], [
			'AND' => [
				'OR' => [
					'users.email' => $data['username'],
					'users.username' => $data['username'],
				]
			]
		]));

		if (!empty($query))
		{
			foreach ($query[0]['user_user_permissions'] as $key => $value)
			{
				$value = $this->database->select('user_permissions', [
					'code'
				], [
					'id' => $value
				]);

				if (!empty($value))
					$query[0]['user_user_permissions'][$key] = $value[0]['code'];
				else
					unset($query[0]['user_user_permissions'][$key]);
			}

			return [
				'account' => [
					'id' => $query[0]['account_id'],
					'name' => $query[0]['account_name'],
					'time_zone' => $query[0]['account_time_zone'],
					'language' => $query[0]['account_language'],
					'currency' => $query[0]['account_currency'],
					'logotype' => $query[0]['account_logotype'],
					'operation' => $query[0]['account_operation'],
					'reputation' => $query[0]['account_reputation'],
					'sms' => $query[0]['account_sms'],
					'zav' => $query[0]['account_zav'],
					'status' => $query[0]['account_status'],
				],
				'user' => [
					'id' => $query[0]['user_id'],
					'firstname' => $query[0]['user_firstname'],
					'lastname' => $query[0]['user_lastname'],
					'avatar' => $query[0]['user_avatar'],
					'username' => $query[0]['user_username'],
					'password' => $query[0]['user_password'],
					'user_permissions' => $query[0]['user_user_permissions'],
					'opportunity_areas' => $query[0]['user_opportunity_areas'],
					'status' => $query[0]['user_status'],
				],
			];
		}
		else
			return null;
	}

	public function new_validation($data)
	{
		if ($data[0] == 'account')
		{
			$query = Functions::get_json_decoded_query($this->database->select('accounts', [
				'name',
				'language',
				'contact'
			], [
				'AND' => [
					'id' => $data[1],
					'status' => false
				]
			]));

			if (!empty($query))
			{
				$this->database->update('accounts', [
					'status' => true
				], [
					'id' => $data[1]
				]);
			}
		}
		else if ($data[0] == 'user')
		{
			$query = $this->database->select('users', [
				'[>]accounts' => [
					'account' => 'id'
				]
			], [
				'users.firstname',
				'users.lastname',
				'users.email',
				'users.username',
				'accounts.language',
			], [
				'AND' => [
					'users.id' => $data[1],
					'users.status' => false
				]
			]);

			if (!empty($query))
			{
				$this->database->update('users', [
					'status' => true
				], [
					'id' => $data[1]
				]);
			}
		}

		return !empty($query) ? $query[0] : null;
	}
}
