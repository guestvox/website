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
			'[>]packages' => [
				'package' => 'id'
			]
		], [
			'accounts.token',
			'accounts.name',
			'accounts.path',
			'accounts.type',
			'accounts.country',
			'accounts.city',
			'accounts.zip_code',
			'accounts.address',
			'accounts.time_zone',
			'accounts.currency',
			'accounts.language',
			'accounts.fiscal',
			'accounts.contact',
			'accounts.logotype',
			'packages.quantity_end(package)',
			'accounts.operation',
			'accounts.reputation',
			'accounts.siteminder',
			'accounts.zaviapms',
			'accounts.ambit',
			'accounts.sms',
			'accounts.settings'
		], [
			'accounts.id' => Session::get_value('account')['id']
		]));

		return !empty($query) ? $query[0] : null;
	}

	public function get_opportunity_areas($type)
	{
		$query = Functions::get_json_decoded_query($this->database->select('opportunity_areas', [
			'id',
			'name'
		], [
			'AND' => [
				'account' => Session::get_value('account')['id'],
				$type => true,
				'status' => true
			],
			'ORDER' => [
				'name' => 'ASC'
			]
		]));

		return $query;
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
				'status' => true
			],
			'ORDER' => [
				'name' => 'ASC'
			]
		]));

		return $query;
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

	public function get_times_zones()
	{
		$query1 = $this->database->select('times_zones', [
			'code'
		], [
			'priority[>=]' => 1,
			'ORDER' => [
				'priority' => 'ASC'
			]
		]);

		$query2 = $this->database->select('times_zones', [
			'code'
		], [
			'priority[=]' => null,
			'ORDER' => [
				'zone' => 'ASC'
			]
		]);

		return array_merge($query1, $query2);
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
		$data['logotype'] = Functions::uploader($data['logotype'], Session::get_value('account')['path'] . '_account_logotype_');

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

	public function edit_account($data)
	{
		$query = $this->database->update('accounts', [
			'name' => $data['name'],
			'country' => $data['country'],
			'city' => $data['city'],
			'zip_code' => $data['zip_code'],
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

	public function edit_settings($field, $data)
	{
		$edited1 = Functions::get_json_decoded_query($this->database->select('accounts', [
			'settings'
		], [
			'id' => Session::get_value('account')['id']
		]));

		$edited2 = $edited1[0]['settings'];

		if ($field == 'myvox_request')
		{
			if (!empty($data['status']))
			{
				$edited1[0]['settings']['myvox']['request']['status'] = true;
				$edited1[0]['settings']['myvox']['request']['title']['es'] = $data['title_es'];
				$edited1[0]['settings']['myvox']['request']['title']['en'] = $data['title_en'];
			}
			else
				$edited1[0]['settings']['myvox']['request']['status'] = false;
		}
		else if ($field == 'myvox_incident')
		{
			if (!empty($data['status']))
			{
				$edited1[0]['settings']['myvox']['incident']['status'] = true;
				$edited1[0]['settings']['myvox']['incident']['title']['es'] = $data['title_es'];
				$edited1[0]['settings']['myvox']['incident']['title']['en'] = $data['title_en'];
			}
			else
				$edited1[0]['settings']['myvox']['incident']['status'] = false;
		}
		else if ($field == 'myvox_menu')
		{
			if (!empty($data['status']))
			{
				$edited1[0]['settings']['myvox']['menu']['status'] = true;
				$edited1[0]['settings']['myvox']['menu']['title']['es'] = $data['title_es'];
				$edited1[0]['settings']['myvox']['menu']['title']['en'] = $data['title_en'];
				$edited1[0]['settings']['myvox']['menu']['currency'] = $data['currency'];
				$edited1[0]['settings']['myvox']['menu']['opportunity_area'] = $data['opportunity_area'];
				$edited1[0]['settings']['myvox']['menu']['opportunity_type'] = $data['opportunity_type'];
				$edited1[0]['settings']['myvox']['menu']['schedule']['monday']['status'] = $data['schedule_monday_status'];
				$edited1[0]['settings']['myvox']['menu']['schedule']['monday']['opening'] = ($data['schedule_monday_status'] == 'open') ? $data['schedule_monday_opening'] : '';
				$edited1[0]['settings']['myvox']['menu']['schedule']['monday']['closing'] = ($data['schedule_monday_status'] == 'open') ? $data['schedule_monday_closing'] : '';
				$edited1[0]['settings']['myvox']['menu']['schedule']['tuesday']['status'] = $data['schedule_tuesday_status'];
				$edited1[0]['settings']['myvox']['menu']['schedule']['tuesday']['opening'] = ($data['schedule_tuesday_status'] == 'open') ? $data['schedule_tuesday_opening'] : '';
				$edited1[0]['settings']['myvox']['menu']['schedule']['tuesday']['closing'] = ($data['schedule_tuesday_status'] == 'open') ? $data['schedule_tuesday_closing'] : '';
				$edited1[0]['settings']['myvox']['menu']['schedule']['wednesday']['status'] = $data['schedule_wednesday_status'];
				$edited1[0]['settings']['myvox']['menu']['schedule']['wednesday']['opening'] = ($data['schedule_wednesday_status'] == 'open') ? $data['schedule_wednesday_opening'] : '';
				$edited1[0]['settings']['myvox']['menu']['schedule']['wednesday']['closing'] = ($data['schedule_wednesday_status'] == 'open') ? $data['schedule_wednesday_closing'] : '';
				$edited1[0]['settings']['myvox']['menu']['schedule']['thursday']['status'] = $data['schedule_thursday_status'];
				$edited1[0]['settings']['myvox']['menu']['schedule']['thursday']['opening'] = ($data['schedule_thursday_status'] == 'open') ? $data['schedule_thursday_opening'] : '';
				$edited1[0]['settings']['myvox']['menu']['schedule']['thursday']['closing'] = ($data['schedule_thursday_status'] == 'open') ? $data['schedule_thursday_closing'] : '';
				$edited1[0]['settings']['myvox']['menu']['schedule']['friday']['status'] = $data['schedule_friday_status'];
				$edited1[0]['settings']['myvox']['menu']['schedule']['friday']['opening'] = ($data['schedule_friday_status'] == 'open') ? $data['schedule_friday_opening'] : '';
				$edited1[0]['settings']['myvox']['menu']['schedule']['friday']['closing'] = ($data['schedule_friday_status'] == 'open') ? $data['schedule_friday_closing'] : '';
				$edited1[0]['settings']['myvox']['menu']['schedule']['saturday']['status'] = $data['schedule_saturday_status'];
				$edited1[0]['settings']['myvox']['menu']['schedule']['saturday']['opening'] = ($data['schedule_saturday_status'] == 'open') ? $data['schedule_saturday_opening'] : '';
				$edited1[0]['settings']['myvox']['menu']['schedule']['saturday']['closing'] = ($data['schedule_saturday_status'] == 'open') ? $data['schedule_saturday_closing'] : '';
				$edited1[0]['settings']['myvox']['menu']['schedule']['sunday']['status'] = $data['schedule_sunday_status'];
				$edited1[0]['settings']['myvox']['menu']['schedule']['sunday']['opening'] = ($data['schedule_sunday_status'] == 'open') ? $data['schedule_sunday_opening'] : '';
				$edited1[0]['settings']['myvox']['menu']['schedule']['sunday']['closing'] = ($data['schedule_sunday_status'] == 'open') ? $data['schedule_sunday_closing'] : '';
				$edited1[0]['settings']['myvox']['menu']['delivery'] = (Session::get_value('account')['type'] == 'restaurant' AND !empty($data['delivery'])) ? true : false;
				$edited1[0]['settings']['myvox']['menu']['requests'] = !empty($data['requests']) ? true : false;
				$edited1[0]['settings']['myvox']['menu']['payment']['status'] = !empty($data['payment_status']) ? true : false;

				if ($data['payment_contract_status'] == 'deactivated')
				{
					$edited1[0]['settings']['myvox']['menu']['payment']['contract']['status'] = 'pending';
					$edited1[0]['settings']['myvox']['menu']['payment']['contract']['place'] = $data['payment_contract_place'];
					$edited1[0]['settings']['myvox']['menu']['payment']['contract']['date'] = Functions::get_current_date();
					$edited1[0]['settings']['myvox']['menu']['payment']['contract']['signature'] = Functions::base_64($data['payment_contract_signature']);
					$edited1[0]['settings']['myvox']['menu']['payment']['contract']['titular']['fiscal']['person'] = $data['payment_contract_titular_fiscal_person'];
					$edited1[0]['settings']['myvox']['menu']['payment']['contract']['titular']['fiscal']['id'] = $data['payment_contract_titular_fiscal_id'];
					$edited1[0]['settings']['myvox']['menu']['payment']['contract']['titular']['fiscal']['name'] = $data['payment_contract_titular_fiscal_name'];
					$edited1[0]['settings']['myvox']['menu']['payment']['contract']['titular']['fiscal']['activity'] = $data['payment_contract_titular_fiscal_activity'];
					$edited1[0]['settings']['myvox']['menu']['payment']['contract']['titular']['address']['street'] = $data['payment_contract_titular_address_street'];
					$edited1[0]['settings']['myvox']['menu']['payment']['contract']['titular']['address']['external_number'] = $data['payment_contract_titular_address_external_number'];
					$edited1[0]['settings']['myvox']['menu']['payment']['contract']['titular']['address']['internal_number'] = !empty($data['payment_contract_titular_address_internal_number']) ? $data['payment_contract_titular_address_internal_number'] : '';
					$edited1[0]['settings']['myvox']['menu']['payment']['contract']['titular']['address']['cp'] = $data['payment_contract_titular_address_cp'];
					$edited1[0]['settings']['myvox']['menu']['payment']['contract']['titular']['address']['colony'] = $data['payment_contract_titular_address_colony'];
					$edited1[0]['settings']['myvox']['menu']['payment']['contract']['titular']['address']['delegation'] = $data['payment_contract_titular_address_delegation'];
					$edited1[0]['settings']['myvox']['menu']['payment']['contract']['titular']['address']['city'] = $data['payment_contract_titular_address_city'];
					$edited1[0]['settings']['myvox']['menu']['payment']['contract']['titular']['address']['state'] = $data['payment_contract_titular_address_state'];
					$edited1[0]['settings']['myvox']['menu']['payment']['contract']['titular']['address']['country'] = $data['payment_contract_titular_address_country'];
					$edited1[0]['settings']['myvox']['menu']['payment']['contract']['titular']['bank']['name'] = $data['payment_contract_titular_bank_name'];
					$edited1[0]['settings']['myvox']['menu']['payment']['contract']['titular']['bank']['branch'] = $data['payment_contract_titular_bank_branch'];
					$edited1[0]['settings']['myvox']['menu']['payment']['contract']['titular']['bank']['checkbook'] = $data['payment_contract_titular_bank_checkbook'];
					$edited1[0]['settings']['myvox']['menu']['payment']['contract']['titular']['bank']['clabe'] = $data['payment_contract_titular_bank_clabe'];
					$edited1[0]['settings']['myvox']['menu']['payment']['contract']['titular']['personal_references']['first']['name'] = $data['payment_contract_titular_personal_references_first_name'];
					$edited1[0]['settings']['myvox']['menu']['payment']['contract']['titular']['personal_references']['first']['email'] = $data['payment_contract_titular_personal_references_first_email'];
					$edited1[0]['settings']['myvox']['menu']['payment']['contract']['titular']['personal_references']['first']['phone']['country'] = $data['payment_contract_titular_personal_references_first_phone_lada'];
					$edited1[0]['settings']['myvox']['menu']['payment']['contract']['titular']['personal_references']['first']['phone']['number'] = $data['payment_contract_titular_personal_references_first_phone_number'];
					$edited1[0]['settings']['myvox']['menu']['payment']['contract']['titular']['personal_references']['second']['name'] = $data['payment_contract_titular_personal_references_second_name'];
					$edited1[0]['settings']['myvox']['menu']['payment']['contract']['titular']['personal_references']['second']['email'] = $data['payment_contract_titular_personal_references_second_email'];
					$edited1[0]['settings']['myvox']['menu']['payment']['contract']['titular']['personal_references']['second']['phone']['country'] = $data['payment_contract_titular_personal_references_second_phone_lada'];
					$edited1[0]['settings']['myvox']['menu']['payment']['contract']['titular']['personal_references']['second']['phone']['number'] = $data['payment_contract_titular_personal_references_second_phone_number'];
					$edited1[0]['settings']['myvox']['menu']['payment']['contract']['titular']['personal_references']['third']['name'] = $data['payment_contract_titular_personal_references_third_name'];
					$edited1[0]['settings']['myvox']['menu']['payment']['contract']['titular']['personal_references']['third']['email'] = $data['payment_contract_titular_personal_references_third_email'];
					$edited1[0]['settings']['myvox']['menu']['payment']['contract']['titular']['personal_references']['third']['phone']['country'] = $data['payment_contract_titular_personal_references_third_phone_lada'];
					$edited1[0]['settings']['myvox']['menu']['payment']['contract']['titular']['personal_references']['third']['phone']['number'] = $data['payment_contract_titular_personal_references_third_phone_number'];
					$edited1[0]['settings']['myvox']['menu']['payment']['contract']['titular']['personal_references']['fourth']['name'] = $data['payment_contract_titular_personal_references_fourth_name'];
					$edited1[0]['settings']['myvox']['menu']['payment']['contract']['titular']['personal_references']['fourth']['email'] = $data['payment_contract_titular_personal_references_fourth_email'];
					$edited1[0]['settings']['myvox']['menu']['payment']['contract']['titular']['personal_references']['fourth']['phone']['country'] = $data['payment_contract_titular_personal_references_fourth_phone_lada'];
					$edited1[0]['settings']['myvox']['menu']['payment']['contract']['titular']['personal_references']['fourth']['phone']['number'] = $data['payment_contract_titular_personal_references_fourth_phone_number'];
					$edited1[0]['settings']['myvox']['menu']['payment']['contract']['titular']['email'] = $data['payment_contract_titular_email'];
					$edited1[0]['settings']['myvox']['menu']['payment']['contract']['titular']['phone']['country'] = $data['payment_contract_titular_phone_lada'];
					$edited1[0]['settings']['myvox']['menu']['payment']['contract']['titular']['phone']['number'] = $data['payment_contract_titular_phone_number'];
					$edited1[0]['settings']['myvox']['menu']['payment']['contract']['titular']['tpv'] = $data['payment_contract_titular_tpv'];
					$edited1[0]['settings']['myvox']['menu']['payment']['contract']['company']['writing_number'] = $data['payment_contract_company_writing_number'];
					$edited1[0]['settings']['myvox']['menu']['payment']['contract']['company']['writing_date'] = $data['payment_contract_company_writing_date'];
					$edited1[0]['settings']['myvox']['menu']['payment']['contract']['company']['public_record_folio'] = $data['payment_contract_company_public_record_folio'];
					$edited1[0]['settings']['myvox']['menu']['payment']['contract']['company']['public_record_date'] = $data['payment_contract_company_public_record_date'];
					$edited1[0]['settings']['myvox']['menu']['payment']['contract']['company']['notary_name'] = $data['payment_contract_company_notary_name'];
					$edited1[0]['settings']['myvox']['menu']['payment']['contract']['company']['notary_number'] = $data['payment_contract_company_notary_number'];
					$edited1[0]['settings']['myvox']['menu']['payment']['contract']['company']['city'] = $data['payment_contract_company_city'];
					$edited1[0]['settings']['myvox']['menu']['payment']['contract']['company']['legal_representative']['name'] = $data['payment_contract_company_legal_representative_name'];
					$edited1[0]['settings']['myvox']['menu']['payment']['contract']['company']['legal_representative']['writing_number'] = $data['payment_contract_company_legal_representative_writing_number'];
					$edited1[0]['settings']['myvox']['menu']['payment']['contract']['company']['legal_representative']['writing_date'] = $data['payment_contract_company_legal_representative_writing_date'];
					$edited1[0]['settings']['myvox']['menu']['payment']['contract']['company']['legal_representative']['notary_name'] = $data['payment_contract_company_legal_representative_notary_name'];
					$edited1[0]['settings']['myvox']['menu']['payment']['contract']['company']['legal_representative']['notary_number'] = $data['payment_contract_company_legal_representative_notary_number'];
					$edited1[0]['settings']['myvox']['menu']['payment']['contract']['company']['legal_representative']['city'] = $data['payment_contract_company_legal_representative_city'];
					$edited1[0]['settings']['myvox']['menu']['payment']['contract']['company']['legal_representative']['card']['type'] = $data['payment_contract_company_legal_representative_card_type'];
					$edited1[0]['settings']['myvox']['menu']['payment']['contract']['company']['legal_representative']['card']['number'] = $data['payment_contract_company_legal_representative_card_number'];
					$edited1[0]['settings']['myvox']['menu']['payment']['contract']['company']['legal_representative']['card']['expedition_date'] = $data['payment_contract_company_legal_representative_card_expedition_date'];
					$edited1[0]['settings']['myvox']['menu']['payment']['contract']['company']['legal_representative']['card']['validity'] = $data['payment_contract_company_legal_representative_card_validity'];
				}

				$edited1[0]['settings']['myvox']['menu']['multi'] = !empty($data['multi']) ? true : false;
			}
			else
				$edited1[0]['settings']['myvox']['menu']['status'] = false;
		}
		else if ($field == 'myvox_survey')
		{
			if (!empty($data['status']))
			{
				$edited1[0]['settings']['myvox']['survey']['status'] = true;
				$edited1[0]['settings']['myvox']['survey']['title']['es'] = $data['title_es'];
				$edited1[0]['settings']['myvox']['survey']['title']['en'] = $data['title_en'];
				$edited1[0]['settings']['myvox']['survey']['mail']['subject']['es'] = $data['mail_subject_es'];
				$edited1[0]['settings']['myvox']['survey']['mail']['subject']['en'] = $data['mail_subject_en'];
				$edited1[0]['settings']['myvox']['survey']['mail']['description']['es'] = $data['mail_description_es'];
				$edited1[0]['settings']['myvox']['survey']['mail']['description']['en'] = $data['mail_description_en'];

				if (!empty($data['mail_image']['name']))
					$edited1[0]['settings']['myvox']['survey']['mail']['image'] = Functions::uploader($data['mail_image'], Session::get_value('account')['path'] . '_settings_myvox_survey_mail_image_');

				if (!empty($data['mail_attachment']['name']))
					$edited1[0]['settings']['myvox']['survey']['mail']['attachment'] = Functions::uploader($data['mail_attachment'], Session::get_value('account')['path'] . '_settings_myvox_survey_mail_attachment_');

			}
			else
				$edited1[0]['settings']['myvox']['survey']['status'] = false;
		}
		else if ($field == 'reviews')
		{
			if (!empty($data['status']))
			{
				$edited1[0]['settings']['reviews']['status'] = true;
				$edited1[0]['settings']['reviews']['email'] = $data['email'];
				$edited1[0]['settings']['reviews']['phone']['lada'] = $data['phone_lada'];
				$edited1[0]['settings']['reviews']['phone']['number'] = $data['phone_number'];
				$edited1[0]['settings']['reviews']['website'] = $data['website'];
				$edited1[0]['settings']['reviews']['description']['es'] = $data['description_es'];
				$edited1[0]['settings']['reviews']['description']['en'] = $data['description_en'];
				$edited1[0]['settings']['reviews']['seo']['keywords']['es'] = $data['seo_keywords_es'];
				$edited1[0]['settings']['reviews']['seo']['keywords']['en'] = $data['seo_keywords_en'];
				$edited1[0]['settings']['reviews']['seo']['description']['es'] = $data['seo_description_es'];
				$edited1[0]['settings']['reviews']['seo']['description']['en'] = $data['seo_description_en'];
				$edited1[0]['settings']['reviews']['social_media']['facebook'] = $data['social_media_facebook'];
				$edited1[0]['settings']['reviews']['social_media']['instagram'] = $data['social_media_instagram'];
				$edited1[0]['settings']['reviews']['social_media']['twitter'] = $data['social_media_twitter'];
				$edited1[0]['settings']['reviews']['social_media']['linkedin'] = $data['social_media_linkedin'];
				$edited1[0]['settings']['reviews']['social_media']['youtube'] = $data['social_media_youtube'];
				$edited1[0]['settings']['reviews']['social_media']['google'] = $data['social_media_google'];
				$edited1[0]['settings']['reviews']['social_media']['tripadvisor'] = $data['social_media_tripadvisor'];
			}
			else
				$edited1[0]['settings']['reviews']['status'] = false;
		}
		else if ($field == 'voxes_attention_times')
		{
			$edited1[0]['settings']['voxes']['attention_times']['request']['low'] = $data['request_low'];
			$edited1[0]['settings']['voxes']['attention_times']['request']['medium'] = $data['request_medium'];
			$edited1[0]['settings']['voxes']['attention_times']['request']['high'] = $data['request_high'];
			$edited1[0]['settings']['voxes']['attention_times']['incident']['low'] = $data['incident_low'];
			$edited1[0]['settings']['voxes']['attention_times']['incident']['medium'] = $data['incident_medium'];
			$edited1[0]['settings']['voxes']['attention_times']['incident']['high'] = $data['incident_high'];
		}

		$query = $this->database->update('accounts', [
			'settings' => json_encode($edited1[0]['settings'])
		], [
			'id' => Session::get_value('account')['id']
		]);

		if ($field == 'myvox_survey')
		{
			if (!empty($query))
			{
				if (!empty($data['mail_image']['name']) AND !empty($edited2[0]['settings']['myvox']['survey']['mail']['image']))
					Functions::undoloader($edited2[0]['settings']['myvox']['survey']['mail']['image']);

				if (!empty($data['mail_attachment']['name']) AND !empty($edited2[0]['settings']['myvox']['survey']['mail']['attachment']))
					Functions::undoloader($edited2[0]['settings']['myvox']['survey']['mail']['attachment']);
			}
		}

		return $query;
	}
}
