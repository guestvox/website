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
			'[>]room_packages' => [
				'room_package' => 'id'
			]
		], [
			'accounts.name',
			'accounts.country',
			'accounts.cp',
			'accounts.city',
			'accounts.address',
			'accounts.time_zone',
			'accounts.language',
			'accounts.currency',
			'accounts.logotype',
			'accounts.fiscal_id',
			'accounts.fiscal_name',
			'accounts.fiscal_address',
			'accounts.contact',
			'accounts.operation',
			'accounts.reputation',
			'accounts.myvox_request',
			'accounts.myvox_incident',
			'accounts.myvox_survey',
			'accounts.myvox_survey_title',
			'accounts.sms',
			'accounts.zaviapms',
			'room_packages.quantity_end(room_package_quantity_end)',
			'room_packages.price(room_package_price)',
		], [
			'accounts.id' => Session::get_value('account')['id']
		]));

		return !empty($query) ? $query[0] : null;
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

		$query = array_merge($query1, $query2);

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
			'id' => Session::get_value('account')['id'],
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
			'country' => $data['country'],
			'zip_code' => $data['zip_code'],
			'city' => $data['city'],
			'address' => $data['address'],
			'time_zone' => $data['time_zone'],
			'language' => $data['language'],
			'currency' => $data['currency']
		], [
			'id' => Session::get_value('account')['id']
		]);

		return $query;
	}

	public function edit_fiscal($data)
	{
		$query = $this->database->update('accounts', [
			'fiscal_id' => $data['fiscal_id'],
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
			])
		], [
			'id' => Session::get_value('account')['id']
		]);

		return $query;
	}

	public function edit_myvox($data)
	{
		$query = $this->database->update('accounts', [
			'myvox_request' => (Functions::check_account_access(['operation']) == true AND !empty($data['myvox_request'])) ? true : false,
			'myvox_incident' => (Functions::check_account_access(['operation']) == true AND !empty($data['myvox_incident'])) ? true : false,
			'myvox_survey' => (Functions::check_account_access(['reputation']) == true AND !empty($data['myvox_survey'])) ? true : false,
			'myvox_survey_title' => (Functions::check_account_access(['reputation']) == true) ? json_encode([
				'es' => $data['myvox_survey_title_es'],
				'en' => $data['myvox_survey_title_en'
			]]) : json_encode([
				'es' => 'Responde una encuesta',
				'en' => 'Answer a question'
			])
		], [
			'id' => Session::get_value('account')['id']
		]);

		return $query;
	}
}
