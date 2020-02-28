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
			'client_package',
			'logotype',
			'fiscal',
			'contact',
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

			if (Session::get_value('account')['type'] == 'others')
			{
				$query[0]['client_package'] = $this->database->select('client_packages', '*', [
					'id' => $query[0]['client_package']
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
			'name' => $data['profile_name'],
			'zip_code' => $data['profile_zip_code'],
			'country' => $data['profile_country'],
			'city' => $data['profile_city'],
			'address' => $data['profile_address'],
			'time_zone' => $data['profile_time_zone'],
			'currency' => $data['profile_currency'],
			'language' => $data['profile_language']
		], [
			'id' => Session::get_value('account')['id']
		]);

		return $query;
	}

	public function edit_billing($data)
	{
		$query = $this->database->update('accounts', [
			'fiscal' => json_encode([
				'id' => $data['billing_fiscal_id'],
				'name' => $data['billing_fiscal_name'],
				'address' => $data['billing_fiscal_address']
			]),
			'contact' => json_encode([
				'firstname' => $data['billing_contact_firstname'],
				'lastname' => $data['billing_contact_lastname'],
				'department' => $data['billing_contact_department'],
				'email' => $data['billing_contact_email'],
				'phone' => [
					'lada' => $data['billing_contact_phone_lada'],
					'number' => $data['billing_contact_phone_number']
				]
			])
		], [
			'id' => Session::get_value('account')['id']
		]);

		return $query;
	}

	public function edit_settings($data)
	{
		if ($data['action'] == 'edit_myvox_settings')
		{
			$data['settings']['myvox']['request'] = (Functions::check_account_access(['operation']) == true AND !empty($data['myvox_settings_request'])) ? true : false;
			$data['settings']['myvox']['incident'] = (Functions::check_account_access(['operation']) == true AND !empty($data['myvox_settings_incident'])) ? true : false;
			$data['settings']['myvox']['survey'] = (Functions::check_account_access(['reputation']) == true AND !empty($data['myvox_settings_survey'])) ? true : false;

			$data['settings']['myvox']['survey_title'] = (Functions::check_account_access(['reputation']) == true) ? [
				'es' => $data['myvox_settings_survey_title_es'],
				'en' => $data['myvox_settings_survey_title_en']
			] : [
				'es' => '',
				'en' => ''
			];

			$data['settings']['myvox']['survey_widget'] = (Functions::check_account_access(['reputation']) == true) ? $data['myvox_settings_survey_widget'] : '';
		}
		else if ($data['action'] == 'edit_review_settings')
		{
			$data['settings']['review']['online'] = (Functions::check_account_access(['reputation']) == true AND !empty($data['review_settings_online'])) ? true : false;
			$data['settings']['review']['email'] = (Functions::check_account_access(['reputation']) == true) ? $data['review_settings_email'] : '';

			$data['settings']['review']['phone'] = (Functions::check_account_access(['reputation']) == true) ? [
				'lada' => $data['review_settings_phone_lada'],
				'number' => $data['review_settings_phone_number']
			] : [
				'lada' => '',
				'number' => ''
			];

			$data['settings']['review']['description'] = (Functions::check_account_access(['reputation']) == true) ? [
				'es' => $data['review_settings_description_es'],
				'en' => $data['review_settings_description_en']
			] : [
				'es' => '',
				'en' => ''
			];

			$data['settings']['review']['seo']['keywords'] = (Functions::check_account_access(['reputation']) == true) ? [
				'es' => $data['review_settings_seo_keywords_es'],
				'en' => $data['review_settings_seo_keywords_en']
			] : [
				'es' => '',
				'en' => ''
			];

			$data['settings']['review']['seo']['meta_description'] = (Functions::check_account_access(['reputation']) == true) ? [
				'es' => $data['review_settings_seo_meta_description_es'],
				'en' => $data['review_settings_seo_meta_description_en']
			] : [
				'es' => '',
				'en' => ''
			];

			$data['settings']['review']['social_media']['facebook'] = (Functions::check_account_access(['reputation']) == true) ? $data['review_settings_social_media_facebook'] : '';
			$data['settings']['review']['social_media']['instagram'] = (Functions::check_account_access(['reputation']) == true) ? $data['review_settings_social_media_instagram'] : '';
			$data['settings']['review']['social_media']['twitter'] = (Functions::check_account_access(['reputation']) == true) ? $data['review_settings_social_media_twitter'] : '';
			$data['settings']['review']['social_media']['linkedin'] = (Functions::check_account_access(['reputation']) == true) ? $data['review_settings_social_media_linkedin'] : '';
			$data['settings']['review']['social_media']['youtube'] = (Functions::check_account_access(['reputation']) == true) ? $data['review_settings_social_media_youtube'] : '';
			$data['settings']['review']['social_media']['google'] = (Functions::check_account_access(['reputation']) == true) ? $data['review_settings_social_media_google'] : '';
			$data['settings']['review']['social_media']['tripadvisor'] = (Functions::check_account_access(['reputation']) == true) ? ((Session::get_value('account')['type'] == 'hotel' OR Session::get_value('account')['type'] == 'restaurant') ? $data['review_settings_social_media_tripadvisor'] : '') : '';
		}

		$query = $this->database->update('accounts', [
			'settings' => json_encode($data['settings'])
		], [
			'id' => Session::get_value('account')['id']
		]);

		return $query;
	}
}
