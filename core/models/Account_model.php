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
		$query = Functions::get_json_decoded_query($this->database->select('settings', [
			'[>]accounts' => [
				'account' => 'id'
			],
		], [
			'accounts.name',
			'accounts.signup_date',
			'settings.private_key',
			'settings.country',
			'settings.cp',
			'settings.city',
			'settings.address',
			'settings.time_zone',
			'settings.language',
			'settings.currency',
			'settings.logotype',
			'settings.currency',
			'settings.fiscal_id',
			'settings.fiscal_name',
			'settings.fiscal_address',
			'settings.contact',
			'settings.sms',
		], [
			'AND' => [
				'settings.account' => Session::get_value('account')['id'],
			]
		]));

		return !empty($query) ? $query[0] : null;
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

	public function get_sms_packages()
	{
		$query = $this->database->select('sms_packages', [
			'id',
			'quantity',
			'price'
		], [
			'ORDER' => [
				'quantity' => 'ASC'
			]
		]);

		return $query;
	}

	public function get_sms_package($id)
	{
		$query = $this->database->select('sms_packages', [
			'quantity',
			'price'
		], [
			'id' => $id
		]);

		return !empty($query) ? $query[0] : null;
	}

	public function check_exist_account($parameter, $option)
	{
		if ($option == 'account')
		{
			$count = $this->database->count('accounts', [
				'id[!]' => Session::get_value('account')['id'],
				'name' => $parameter
			]);
		}
		else if ($option == 'fiscal_id')
		{
			$count = $this->database->count('settings', [
				'account[!]' => Session::get_value('account')['id'],
				'fiscal_id' => $parameter
			]);
		}
		else if ($option == 'fiscal_name')
		{
			$count = $this->database->count('settings', [
				'account[!]' => Session::get_value('account')['id'],
				'fiscal_name' => $parameter
			]);
		}

		return ($count > 0) ? true : false;
	}

	public function edit_logotype($data)
	{
		$query = $this->database->update('settings', [
			'logotype' => Functions::uploader($data['logotype']),
		], [
			'account' => Session::get_value('account')['id'],
		]);

		return $query;
	}

	public function edit_account($data)
	{
		$query1 = $this->database->update('accounts', [
			'name' => $data['account'],
		], [
			'id' => Session::get_value('account')['id'],
		]);

		$query2 = $this->database->update('settings', [
			'country' => $data['country'],
			'cp' => $data['cp'],
			'city' => $data['city'],
			'address' => $data['address'],
			'time_zone' => $data['time_zone'],
			'language' => $data['language'],
			'currency' => $data['currency'],
			'fiscal_id' => $data['fiscal_id'],
			'fiscal_name' => $data['fiscal_name'],
			'fiscal_address' => $data['fiscal_address'],
			'contact' => json_encode([
				'name' => $data['contact_name'],
				'department' => $data['contact_department'],
				'lada' => $data['contact_lada'],
				'phone' => $data['contact_phone'],
				'email' => $data['contact_email'],
			]),
		], [
			'account' => Session::get_value('account')['id'],
		]);

		if (!empty($query1) AND !empty($query2))
			return true;
		else
			return null;
	}
}
