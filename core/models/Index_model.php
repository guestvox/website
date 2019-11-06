<?php

defined('_EXEC') or die;

class Index_model extends Model
{
	public function __construct()
	{
		parent::__construct();
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
			'users.id',
			'users.account(account_id)',
			'accounts.name(account_name)',
			'users.name',
			'users.lastname',
			'users.username',
			'users.password',
			'users.user_level(user_level_id)',
			'user_levels.name(user_level_name)',
			'users.user_permissions',
			'users.opportunity_areas',
			'settings.id(settings_id)',
			'settings.time_zone(settings_time_zone)',
			'settings.language(settings_language)',
		], [
			'AND' => [
				'OR' => [
					'users.email' => $data['username'],
					'users.username' => $data['username'],
				],
				'users.status' => true,
				'accounts.status' => true,
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
				],
				'user' => [
					'id' => $query[0]['id'],
					'name' => $query[0]['name'],
					'lastname' => $query[0]['lastname'],
					'username' => $query[0]['username'],
					'password' => $query[0]['password'],
					'user_level' => [
						'id' => $query[0]['user_level_id'],
						'name' => $query[0]['user_level_name'],
					],
					'user_permissions' => $query[0]['user_permissions'],
					'opportunity_areas' => $query[0]['opportunity_areas'],
				],
				'settings' => [
					'id' => $query[0]['settings_id'],
					'time_zone' => $query[0]['settings_time_zone'],
					'language' => $query[0]['settings_language'],
				],
			];
		}

		return $login;
	}

	public function new_signup($data)
	{
		$exist1 = $this->database->count('accounts', [
			'name' => $data['account']
		]);

		$exist2 = $this->database->count('users', [
			'email' => $data['email']
		]);

		$exist3 = $this->database->count('users', [
			'username' => $data['username']
		]);

		if (!empty($data['promotional_code']))
		{
			$exist4 = $this->database->count('promotional_codes', [
				'code' => $data['promotional_code']
			]);
		}
		else
			$exist4 = 1;

		if ($exist1 > 0 OR $exist2 > 0 OR $exist3 > 0 OR $exist4 <= 0)
		{
			return [
				'status' => false,
				'exist' => [
					'account' => ($exist1 > 0) ? true : false,
					'email' => ($exist2 > 0) ? true : false,
					'username' => ($exist3 > 0) ? true : false,
					'promotional_code' => ($exist4 <= 0) ? false : true,
				]
			];
		}
		else
		{
			$account = $this->database->id($this->database->insert('accounts', [
				'name' => $data['account'],
				'signup_date' => Dates::get_current_date(),
				'status' => true,
			]));

			if (!empty($data['promotional_code']))
			{
				$data['promotional_code'] = $this->database->select('promotional_codes', 'code', [
					'code' => $data['promotional_code']
				])[0];
			}
			else
				$data['promotional_code'] = null;

			$this->database->insert('settings', [
				'account' => $account,
				'private_key' => 'OvX7WsT*^Ji35si,rEnFi8jrn(x9tHN3?.e3}]q0u)!D<GG9d~B(@7N5LE<psQgs:Mz-WJbRgm4!)pYiHPBGjZ#tnEFiZ0Cd)rc:uJNj(]_rZtHY0<:XkacT/!p|oV[7',
				'time_zone' => $data['time_zone'],
				'language' => $data['language'],
				'sms' => 0,
				'promotional_code' => $data['promotional_code'],
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
				'user_permissions' => json_encode([
					'1',
					'2',
					'3',
					'38',
					'39',
					'4',
					'5',
					'6',
					'7',
					'8',
					'9',
					'10',
					'11',
					'12',
					'13',
					'14',
					'15',
					'29',
					'30',
					'31',
					'32',
					'33',
					'34',
					'35',
					'36',
					'37',
					'16',
					'17',
					'19',
					'20',
					'21',
					'18',
					'22',
					'23',
					'24',
					'26',
				]),
			]));

			$this->database->insert('user_levels', [
				'account' => $account,
				'code' => '{director}',
				'name' => $director,
				'user_permissions' => json_encode([
					'1',
					'2',
					'3',
					'38',
					'39',
					'16',
					'17',
					'19',
					'20',
					'21',
					'18',
					'22',
					'23',
					'24',
					'25',
					'26',
				]),
			]);

			$this->database->insert('user_levels', [
				'account' => $account,
				'code' => '{manager}',
				'name' => $manager,
				'user_permissions' => json_encode([
					'1',
					'2',
					'3',
					'38',
					'39',
					'27',
				]),
			]);

			$this->database->insert('user_levels', [
				'account' => $account,
				'code' => '{supervisor}',
				'name' => $supervisor,
				'user_permissions' => json_encode([
					'1',
					'2',
					'3',
					'39',
					'27',
				]),
			]);

			$this->database->insert('user_levels', [
				'account' => $account,
				'code' => '{operator}',
				'name' => $operator,
				'user_permissions' => json_encode([
					'1',
					'28',
				]),
			]);

			$this->database->insert('users', [
				'account' => $account,
				'name' => $data['name'],
				'lastname' => $data['lastname'],
				'email' => $data['email'],
				'cellphone' => $data['cellphone'],
				'username' => $data['username'],
				'password' => $this->security->create_password($data['password']),
				'temporal_password' => null,
				'user_level' => $user_level,
				'user_permissions' => json_encode([
					'1',
					'2',
					'3',
					'38',
					'39',
					'4',
					'5',
					'6',
					'7',
					'8',
					'9',
					'10',
					'11',
					'12',
					'13',
					'14',
					'15',
					'29',
					'30',
					'31',
					'32',
					'33',
					'34',
					'35',
					'36',
					'37',
					'16',
					'17',
					'19',
					'20',
					'21',
					'18',
					'22',
					'23',
					'24',
					'26',
				]),
				'opportunity_areas' => json_encode([]),
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

			return [
				'status' => true
			];
		}
	}

	public function new_validation($email)
	{
		$validation = null;

		$query = $this->database->select('users', [
			'[>]settings' => [
				'account' => 'account'
			]
		], [
			'users.id',
			'users.name',
			'users.lastname',
			'users.status',
			'settings.language',
		], [
			'users.email' => $email
		]);

		if (!empty($query))
		{
			if ($query[0]['status'] == false)
			{
				$validation = $this->database->update('users', [
					'status' => true
				], [
					'id' => $query[0]['id']
				]);

				if (!empty($validation))
				{
					$validation = [
						'name' => $query[0]['name'],
						'lastname' => $query[0]['lastname'],
						'language' => $query[0]['language'],
					];
				}
			}
		}

		return $validation;
	}
}
