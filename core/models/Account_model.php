<?php

defined('_EXEC') or die;

class Account_model extends Model
{
	public function __construct()
	{
		parent::__construct();
	}

	public function get_account()
	{
		$query = Functions::get_json_decoded_query($this->database->select('accounts', [
			'token',
			'name',
			'type',
			'zip_code',
			'country',
			'city',
			'address',
			'time_zone',
			'currency',
			'language',
			'room_package',
			'table_package',
			'logotype',
			'fiscal',
			'contact',
			'payment',
			'qr',
			'operation',
			'reputation',
			'zaviapms',
			'sms',
			'settings'
		], [
			'id' => Session::get_value('account')['id']
		]));

		if (!empty($query))
		{
			if (Session::get_value('account')['type'] == 'hotel')
			{
				$query[0]['room_package'] = $this->database->select('room_packages', '*', [
					'id' => $query[0]['room_package']
				])[0];
			}

			if (Session::get_value('account')['type'] == 'restaurant')
			{
				$query[0]['table_package'] = $this->database->select('table_packages', '*', [
					'id' => $query[0]['table_package']
				])[0];
			}

			return $query[0];
		}
		else
			return null;
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
		$query = Functions::get_json_decoded_query($this->database->select('time_zones', [
			'code'
		], [
			'ORDER' => [
				'zone' => 'ASC'
			]
		]));

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

	public function check_exist_account($field, $value)
	{
		$count = $this->database->count('accounts', [
			'id[!]' => Session::get_value('account')['id'],
			$field => $value
		]);

		return ($count > 0) ? true : false;
	}

	public function edit_logotype($data)
	{
		$data['logotype'] = Functions::uploader($data['logotype']);

		$query = $this->database->update('accounts', [
			'logotype' => $data['logotype']
		], [
			'id' => Session::get_value('account')['id']
		]);

		if (!empty($query))
		{
			Functions::undoloader(Session::get_value('account')['logotype']);

			return $data['logotype'];
		}
		else
			return null;
	}

	public function edit_profile($data)
	{
		$query = $this->database->update('accounts', [
			'name' => $data['name'],
			'zip_code' => $data['zip_code'],
			'country' => $data['country'],
			'city' => $data['city'],
			'address' => $data['address'],
			'time_zone' => $data['time_zone'],
			'currency' => $data['currency'],
			'language' => $data['language']
		], [
			'id' => Session::get_value('account')['id']
		]);

		return $query;
	}

	public function edit_billing($data)
	{
		$query = $this->database->update('accounts', [
			'fiscal' => json_encode([
				'id' => $data['fiscal_id'],
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
			])
		], [
			'id' => Session::get_value('account')['id']
		]);

		return $query;
	}

	public function edit_settings($data)
	{
		$query = $this->database->update('accounts', [
			'settings' => json_encode([
				'myvox' => [
					'request' => (Functions::check_account_access(['operation']) == true AND !empty($data['settings_myvox_request'])) ? true : false,
					'incident' => (Functions::check_account_access(['operation']) == true AND !empty($data['settings_myvox_incident'])) ? true : false,
					'survey' => (Functions::check_account_access(['reputation']) == true AND !empty($data['settings_myvox_survey'])) ? true : false,
					'survey_title' => (Functions::check_account_access(['reputation']) == true) ? [
						'es' => $data['settings_myvox_survey_title_es'],
						'en' => $data['settings_myvox_survey_title_en']
					] : [
						'es' => 'Responde una encuesta',
						'en' => 'Answer a question'
					]
				]
			])
		], [
			'id' => Session::get_value('account')['id']
		]);

		return $query;
	}
}
