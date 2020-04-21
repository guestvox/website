<?php

defined('_EXEC') or die;

require 'plugins/php-qr-code/qrlib.php';

class Signup_model extends Model
{
	public function __construct()
	{
		parent::__construct();
	}

	public function get_countries()
	{
		$query1 = Functions::get_json_decoded_query($this->database->select('countries', [
			'name',
			'code',
			'lada'
		], [
			'priority[>=]' => 1,
			'ORDER' => [
				'priority' => 'ASC'
			]
		]));

		$query2 = Functions::get_json_decoded_query($this->database->select('countries', [
			'name',
			'code',
			'lada'
		], [
			'priority[=]' => null,
			'ORDER' => [
				'name' => 'ASC'
			]
		]));

		return array_merge($query1, $query2);
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

	public function get_currencies()
	{
		$query1 = Functions::get_json_decoded_query($this->database->select('currencies', [
			'name',
			'code'
		], [
			'priority[>=]' => 1,
			'ORDER' => [
				'priority' => 'ASC'
			]
		]));

		$query2 = Functions::get_json_decoded_query($this->database->select('currencies', [
			'name',
			'code'
		], [
			'priority[=]' => null,
			'ORDER' => [
				'name' => 'ASC'
			]
		]));

		return array_merge($query1, $query2);
	}

	public function get_languages()
	{
		$query1 = $this->database->select('languages', [
			'name',
			'code'
		], [
			'priority[>=]' => 1,
			'ORDER' => [
				'priority' => 'ASC'
			]
		]);

		$query2 = $this->database->select('languages', [
			'name',
			'code'
		], [
			'priority[=]' => null,
			'ORDER' => [
				'name' => 'ASC'
			]
		]);

		return array_merge($query1, $query2);
	}

	public function get_package($type, $number)
	{
		$query = Functions::get_json_decoded_query($this->database->select('packages', [
			'id',
			'quantity_end',
			'price'
		], [
			'AND' => [
				'quantity_start[<=]' => $number,
				'quantity_end[>=]' => $number,
				'type' => $type
			]
		]));

		return !empty($query) ? $query[0] : null;
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
		$data['path'] = str_replace(' ', '', strtolower($data['path']));
		$data['token'] = Functions::get_random(8);
		$data['qr']['filename'] = 'qr_' . $data['path'] . '_' . $data['token'] . '.png';
		$data['qr']['content'] = 'https://' . Configuration::$domain . '/' . $data['path'] . '/myvox';
		$data['qr']['dir'] = PATH_UPLOADS . $data['qr']['filename'];
		$data['qr']['level'] = 'H';
		$data['qr']['size'] = 5;
		$data['qr']['frame'] = 3;

		$this->database->insert('accounts', [
			'token' => strtoupper($data['token']),
			'name' => $data['name'],
			'path' => $data['path'],
			'type' => $data['type'],
			'zip_code' => $data['zip_code'],
			'country' => $data['country'],
			'city' => $data['city'],
			'address' => $data['address'],
			'time_zone' => $data['time_zone'],
			'currency' => $data['currency'],
			'language' => $data['language'],
			'package' => $this->get_package($data['type'], $data['owners_number'])['id'],
			'logotype' => Functions::uploader($data['logotype']),
			'fiscal' => json_encode([
				'id' => strtoupper($data['fiscal_id']),
				'name' => $data['fiscal_name'],
				'address' => $data['fiscal_address']
			]),
			'contact' => json_encode([
				'firstname' => $data['contact_firstname'],
				'lastname' => $data['contact_lastname'],
				'department' => $data['contact_department'],
				'email' => $data['contact_email'],
				'phone' => [
					'lada' => $data['contact_phone_lada'],
					'number' => $data['contact_phone_number']
				]
			]),
			'payment' => json_encode([
				'type' => 'demo'
			]),
			'qr' => $data['qr']['filename'],
			'operation' => !empty($data['operation']) ? true : false,
			'reputation' => !empty($data['reputation']) ? true : false,
			'zaviapms' => json_encode([
				'status' => false,
				'username' => '',
				'password' => '',
			]),
			'sms' => 0,
			'settings' => json_encode([
				'myvox' => [
					'request' => false,
					'incident' => false,
					'survey' => false,
					'survey_title' => [
						'es' => '',
						'en' => ''
					],
					'survey_widget' => ''
				],
				'review' => [
					'online' => false,
					'email' => '',
					'phone' => [
						'lada' => '',
						'number' => ''
					],
					'description' => [
						'es' => '',
						'en' => ''
					],
					'seo' => [
						'keywords' => [
							'es' => '',
							'en' => ''
						],
						'meta_description' => [
							'es' => '',
							'en' => ''
						]
					],
					'social_media' => [
						'facebook' => '',
						'instagram' => '',
						'twitter' => '',
						'linkedin' => '',
						'youtube' => '',
						'google' => '',
						'tripadvisor' => ''
					]
				]
			]),
			'signup_date' => Functions::get_current_date(),
			'status' => false
		]);

		QRcode::png($data['qr']['content'], $data['qr']['dir'], $data['qr']['level'], $data['qr']['size'], $data['qr']['frame']);

		$account = $this->database->id();

		if ($data['type'] == 'hotel')
		{
			$data['guest_treatments'] = [
				'es' => [
					'Sr.',
					'Sra.',
					'Srita.'
				],
				'en' => [
					'Mr.',
					'Miss.',
					'Mrs.'
				]
			];

			$this->database->insert('guest_treatments', [
				[
					'account' => $account,
					'name' => $data['guest_treatments'][$data['language']][0]
				],
				[
					'account' => $account,
					'name' => $data['guest_treatments'][$data['language']][1]
				],
				[
					'account' => $account,
					'name' => $data['guest_treatments'][$data['language']][2]
				]
			]);

			$data['guest_types'] = [
				'es' => [
					'Club vacacional',
					'Day pass',
					'Externo',
					'Gold',
					'Platinium',
					'Regular',
					'VIP'
				],
				'en' => [
					'Vacational club',
					'Day pass',
					'External',
					'Gold',
					'Platinium',
					'Regular',
					'VIP'
				]
			];

			$this->database->insert('guest_types', [
				[
					'account' => $account,
					'name' => $data['guest_types'][$data['language']][0]
				],
				[
					'account' => $account,
					'name' => $data['guest_types'][$data['language']][1]
				],
				[
					'account' => $account,
					'name' => $data['guest_types'][$data['language']][2]
				],
				[
					'account' => $account,
					'name' => $data['guest_types'][$data['language']][3]
				],
				[
					'account' => $account,
					'name' => $data['guest_types'][$data['language']][4]
				],
				[
					'account' => $account,
					'name' => $data['guest_types'][$data['language']][5]
				],
				[
					'account' => $account,
					'name' => $data['guest_types'][$data['language']][6]
				]
			]);

			$data['reservation_statuses'] = [
				'es' => [
					'En casa',
					'Fuera de casa',
					'Pre llegada',
					'Llegada',
					'Pre salida',
					'Salida'
				],
				'en' => [
					'In house',
					'Outside of house',
					'Pre arrival',
					'Arrival',
					'Pre departure',
					'Departure'
				]
			];

			$this->database->insert('reservation_statuses', [
				[
					'account' => $account,
					'name' => $data['reservation_statuses'][$data['language']][0]
				],
				[
					'account' => $account,
					'name' => $data['reservation_statuses'][$data['language']][1]
				],
				[
					'account' => $account,
					'name' => $data['reservation_statuses'][$data['language']][2]
				],
				[
					'account' => $account,
					'name' => $data['reservation_statuses'][$data['language']][3]
				],
				[
					'account' => $account,
					'name' => $data['reservation_statuses'][$data['language']][4]
				],
				[
					'account' => $account,
					'name' => $data['reservation_statuses'][$data['language']][5]
				]
			]);
		}

		$data['user_permissions'] = [
			'es' => [
				'Administrador',
				'Director',
				'Gerente',
				'Supervisor',
				'Operador'
			],
			'en' => [
				'Administrator',
				'Director',
				'Manager',
				'Supervisor',
				'Operator'
			],
			'ids' => []
		];

		$data['user_permissions']['ids'] = [
			'["46","47","25","39","38","40","29","30","31","32","33","34","10","11","12","4","5","6","7","8","9","35","36","37","13","14","15","42","43","44","45","48","16","17","19","20","21","18","22","23","24","41","49","50","26","1","2","3"]',
			'["46","47","25","39","41","38","26","1","2","3"]',
			'["46","47","25","39","41","38","28","1","2","3"]',
			'["46","47","39","41","38","28","1","2","3"]',
			'["27","1","2","3"]'
		];

		$this->database->insert('user_levels', [
			[
				'account' => $account,
				'name' => $data['user_permissions'][$data['language']][0],
				'user_permissions' => $data['user_permissions']['ids'][0]
			],
			[
				'account' => $account,
				'name' => $data['user_permissions'][$data['language']][1],
				'user_permissions' => $data['user_permissions']['ids'][1]
			],
			[
				'account' => $account,
				'name' => $data['user_permissions'][$data['language']][2],
				'user_permissions' => $data['user_permissions']['ids'][2]
			],
			[
				'account' => $account,
				'name' => $data['user_permissions'][$data['language']][3],
				'user_permissions' => $data['user_permissions']['ids'][3]
			],
			[
				'account' => $account,
				'name' => $data['user_permissions'][$data['language']][4],
				'user_permissions' => $data['user_permissions']['ids'][4]
			]
		]);

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
			'user_permissions' => $data['user_permissions']['ids'][0],
			'opportunity_areas' => json_encode([]),
			'status' => false
		]);

		return true;
	}

	public function new_activation($data)
	{
		if ($data[0] == 'account')
		{
			$query = Functions::get_json_decoded_query($this->database->select('accounts', [
				'id',
				'language',
				'contact',
				'status'
			], [
				'path' => $data[1]
			]));

			if (!empty($query))
			{
				if ($query[0]['status'] == false)
				{
					$this->database->update('accounts', [
						'status' => true
					], [
						'id' => $query[0]['id']
					]);
				}
			}
		}
		else if ($data[0] == 'user')
		{
			$query = $this->database->select('users', [
				'[>]accounts' => [
					'account' => 'id'
				]
			], [
				'users.id',
				'users.firstname',
				'users.lastname',
				'users.email',
				'users.status',
				'accounts.language'
			], [
				'users.email' => $data[1]
			]);

			if (!empty($query))
			{
				if ($query[0]['status'] == false)
				{
					$this->database->update('users', [
						'status' => true
					], [
						'id' => $query[0]['id']
					]);
				}
			}
		}

		return !empty($query) ? $query[0] : null;
	}
}
