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
		$query = Functions::get_json_decoded_query($this->database->select('time_zones', [
			'code'
		], [
			'ORDER' => [
				'zone' => 'ASC'
			]
		]));

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
		$query = [];

		$query['room_package'] = [];
		$query['user_package'] = [];

		$t1 = 0;
		$t2 = 0;

		$p1 = $this->database->select('room_packages', [
			'id',
			'quantity_end',
			'price',
		], [
			'AND' => [
				'quantity_start[<=]' => $data['rooms_number'],
				'quantity_end[>=]' => $data['rooms_number'],
			]
		]);

		if (!empty($p1))
		{
			$query['room_package'] = $p1[0];
			$t1 = $p1[0]['price'];
		}

		$p2 = $this->database->select('user_packages', [
			'id',
			'quantity_end',
			'price',
		], [
			'AND' => [
				'quantity_start[<=]' => $data['users_number'],
				'quantity_end[>=]' => $data['users_number'],
			]
		]);

		if (!empty($p2))
		{
			$query['user_package'] = $p2[0];
			$t2 = $p2[0]['price'];
		}

		$query['total'] = $t1 + $t2;

		return $query;
	}

	public function check_exist_account($parameter, $option)
	{
		if ($option == 'hotel')
		{
			$count = $this->database->count('accounts', [
				'name' => $parameter
			]);
		}
		else if ($option == 'fiscal_id')
		{
			$count = $this->database->count('settings', [
				'fiscal_id' => $parameter
			]);
		}
		else if ($option == 'fiscal_name')
		{
			$count = $this->database->count('settings', [
				'fiscal_name' => $parameter
			]);
		}

		return ($count > 0) ? true : false;
	}

	public function check_exist_user($parameter, $option)
	{
		if ($option == 'email')
		{
			$count = $this->database->count('users', [
				'email' => $parameter
			]);
		}
		else if ($option == 'username')
		{
			$count = $this->database->count('users', [
				'username' => $parameter
			]);
		}

		return ($count > 0) ? true : false;
	}

	public function new_signup($data)
	{
		$packages = $this->get_packages($data);

		if (!empty($packages))
		{
			$account = $this->database->id($this->database->insert('accounts', [
				'name' => $data['hotel'],
				'signup_date' => Functions::get_current_date(),
				'status' => false,
			]));

			$this->database->insert('settings', [
				'account' => $account,
				'private_key' => 'OvX7WsT*^Ji35si,rEnFi8jrn(x9tHN3?.e3}]q0u)!D<GG9d~B(@7N5LE<psQgs:Mz-WJbRgm4!)pYiHPBGjZ#tnEFiZ0Cd)rc:uJNj(]_rZtHY0<:XkacT/!p|oV[7',
				'room_package' => $packages['room_package']['id'],
				'user_package' => $packages['user_package']['id'],
				'country' => $data['country'],
				'cp' => $data['cp'],
				'city' => $data['city'],
				'address' => $data['address'],
				'time_zone' => $data['time_zone'],
				'language' => $data['language'],
				'currency' => $data['currency'],
				'logotype' => Functions::uploader($_POST['logotype']),
				'fiscal_id' => strtoupper($data['fiscal_id']),
				'fiscal_name' => $data['fiscal_name'],
				'fiscal_address' => $data['fiscal_address'],
				'contact' => json_encode([
					'name' => $data['contact_name'],
					'department' => $data['department'],
					'lada' => $data['contact_lada'],
					'phone' => $data['contact_phone'],
					'email' => strtolower($data['contact_email']),
				]),
				'payment' => $data['payment'],
				'promotional_code' => (!empty($data['promotional_code'])) ? $data['promotional_code'] : null,
				'sms' => 0,
				'survey_title' => json_encode([
					'es' => 'Responder encuesta',
					'en' => 'Answer survey',
				])
			]);

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

			$user_level = $this->database->id($this->database->insert('user_levels', [
				'account' => $account,
				'code' => '{administrator}',
				'name' => $administrator,
				'user_permissions' => '["1","2","3","38","39","4","5","6","7","8","9","10","11","12","13","14","15","29","30","31","32","33","34","35","36","37","16","17","19","20","21","18","22","23","24","26"]',
			]));

			$this->database->insert('user_levels', [
				'account' => $account,
				'code' => '{director}',
				'name' => $director,
				'user_permissions' => '["1","2","3","38","39","25","26"]',
			]);

			$this->database->insert('user_levels', [
				'account' => $account,
				'code' => '{manager}',
				'name' => $manager,
				'user_permissions' => '["1","2","3","38","39","25","27"]',
			]);

			$this->database->insert('user_levels', [
				'account' => $account,
				'code' => '{supervisor}',
				'name' => $supervisor,
				'user_permissions' => '["1","2","3","38","39","27"]',
			]);

			$this->database->insert('user_levels', [
				'account' => $account,
				'code' => '{operator}',
				'name' => $operator,
				'user_permissions' => '["1","2","28"]',
			]);

			$this->database->insert('users', [
				'account' => $account,
				'name' => $data['firstname'],
				'lastname' => $data['lastname'],
				'email' => strtolower($data['email']),
				'cellphone' => $data['phone'],
				'avatar' => null,
				'username' => strtolower($data['username']),
				'password' => $this->security->create_password($data['password']),
				'temporal_password' => null,
				'user_level' => $user_level,
				'user_permissions' => '["1","2","3","38","39","4","5","6","7","8","9","10","11","12","13","14","15","29","30","31","32","33","34","35","36","37","16","17","19","20","21","18","22","23","24","26"]',
				'opportunity_areas' => '[]',
				'status' => false,
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
				'account' => $account,
				'name' => $vacational_club,
			]);

			$this->database->insert('guest_types', [
				'account' => $account,
				'name' => $day_pass,
			]);

			$this->database->insert('guest_types', [
				'account' => $account,
				'name' => $external,
			]);

			$this->database->insert('guest_types', [
				'account' => $account,
				'name' => $gold,
			]);

			$this->database->insert('guest_types', [
				'account' => $account,
				'name' => $platinium,
			]);

			$this->database->insert('guest_types', [
				'account' => $account,
				'name' => $regular,
			]);

			$this->database->insert('guest_types', [
				'account' => $account,
				'name' => $vip,
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

			$this->database->insert('reservation_status', [
				'account' => $account,
				'name' => $in_house,
			]);

			$this->database->insert('reservation_status', [
				'account' => $account,
				'name' => $outside_house,
			]);

			$this->database->insert('reservation_status', [
				'account' => $account,
				'name' => $pre_arrival,
			]);

			$this->database->insert('reservation_status', [
				'account' => $account,
				'name' => $arrival,
			]);

			$this->database->insert('reservation_status', [
				'account' => $account,
				'name' => $pre_departure,
			]);

			$this->database->insert('reservation_status', [
				'account' => $account,
				'name' => $departure,
			]);

			$this->database->insert('guest_treatments', [
				'account' => $account,
				'name' => 'Sr.',
			]);

			$this->database->insert('guest_treatments', [
				'account' => $account,
				'name' => 'Sra.',
			]);

			$this->database->insert('guest_treatments', [
				'account' => $account,
				'name' => 'Srita.',
			]);

			$this->database->insert('guest_treatments', [
				'account' => $account,
				'name' => 'Mr.',
			]);

			$this->database->insert('guest_treatments', [
				'account' => $account,
				'name' => 'Miss.',
			]);

			$this->database->insert('guest_treatments', [
				'account' => $account,
				'name' => 'Mrs.',
			]);
		}

		return true;
	}

	public function get_login($data)
	{
		$login = null;

		$query = Functions::get_json_decoded_query($this->database->select('users', [
			'[>]accounts' => [
				'account' => 'id'
			],
			'[>]user_levels' => [
				'user_level' => 'id'
			],
			'[>]settings' => [
				'account' => 'account'
			],
		], [
			'accounts.id(account_id)',
			'accounts.name(account_name)',
			'accounts.status(account_status)',
			'users.id(user_id)',
			'users.name(user_name)',
			'users.lastname(user_lastname)',
			'users.avatar(user_avatar)',
			'users.username(user_username)',
			'users.password(user_password)',
			'users.user_permissions(user_permissions)',
			'users.opportunity_areas(user_opportunity_areas)',
			'users.status(user_status)',
			'user_levels.id(user_level_id)',
			'user_levels.name(user_level_name)',
			'settings.id(settings_id)',
			'settings.private_key(settings_private_key)',
			'settings.time_zone(settings_time_zone)',
			'settings.language(settings_language)',
			'settings.currency(settings_currency)',
			'settings.logotype(settings_logotype)',
			'settings.sms(settings_sms)',
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
			foreach ($query[0]['user_permissions'] as $key => $value)
			{
				$query[0]['user_permissions'][$key] = $this->database->select('user_permissions', 'code', [
					'id' => $value
				])[0];
			}

			$login = [
				'account' => [
					'id' => $query[0]['account_id'],
					'name' => $query[0]['account_name'],
					'status' => $query[0]['account_status'],
				],
				'user' => [
					'id' => $query[0]['user_id'],
					'name' => $query[0]['user_name'],
					'lastname' => $query[0]['user_lastname'],
					'avatar' => $query[0]['user_avatar'],
					'username' => $query[0]['user_username'],
					'password' => $query[0]['user_password'],
					'user_level' => [
						'id' => $query[0]['user_level_id'],
						'name' => $query[0]['user_level_name'],
					],
					'user_permissions' => $query[0]['user_permissions'],
					'opportunity_areas' => $query[0]['user_opportunity_areas'],
					'status' => $query[0]['user_status'],
				],
				'settings' => [
					'id' => $query[0]['settings_id'],
					'private_key' => $query[0]['settings_private_key'],
					'time_zone' => $query[0]['settings_time_zone'],
					'language' => $query[0]['settings_language'],
					'currency' => $query[0]['settings_currency'],
					'logotype' => $query[0]['settings_logotype'],
					'sms' => $query[0]['settings_sms'],
				],
			];
		}

		return $login;
	}

	// public function new_validation($email)
	// {
	// 	$validation = null;
	//
	// 	$query = $this->database->select('users', [
	// 		'[>]settings' => [
	// 			'account' => 'account'
	// 		]
	// 	'], [
	// 		'users.id',
	// 		'users.name',
	// 		'users.lastname',
	// 		'users.status',
	// 		'settings.language',
	// 	'], [
	// 		'users.email' => $email
	// 	]);
	//
	// 	if (!empty($query))
	// 	{
	// 		if ($query[0]['status'] == false)
	// 		{
	// 			$validation = $this->database->update('users', [
	// 				'status' => true
	// 			'], [
	// 				'id' => $query[0]['id']
	// 			]);
	//
	// 			if (!empty($validation))
	// 			{
	// 				$validation = [
	// 					'name' => $query[0]['name''],
	// 					'lastname' => $query[0]['lastname''],
	// 					'language' => $query[0]['language''],
	// 				];
	// 			}
	// 		}
	// 	}
	//
	// 	return $validation;
	// }
}
