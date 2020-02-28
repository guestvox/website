<?php

defined('_EXEC') or die;

class Account_controller extends Controller
{
	public function __construct()
	{
		parent::__construct();
	}

	public function index()
	{
		$account = $this->model->get_account();

		if (Format::exist_ajax_request() == true)
		{
			if ($_POST['action'] == 'edit_logotype')
			{
				$query = $this->model->edit_logotype($_FILES);

				if (!empty($query))
				{
					$tmp = Session::get_value('account');

					$tmp['logotype'] = $query;

					Session::set_value('account', $tmp);

					Functions::environment([
						'status' => 'success',
						'message' => '{$lang.operation_success}'
					]);
				}
				else
				{
					Functions::environment([
						'status' => 'error',
						'message' => '{$lang.operation_error}'
					]);
				}
			}

			if ($_POST['action'] == 'edit_profile')
			{
				$labels = [];

				if (!isset($_POST['profile_name']) OR empty($_POST['profile_name']) AND $this->model->check_exist_account('name', $_POST['profile_name']) == true)
					array_push($labels, ['profile_name', '']);

				if (!isset($_POST['profile_zip_code']) OR empty($_POST['profile_zip_code']))
					array_push($labels, ['profile_zip_code', '']);

				if (!isset($_POST['profile_country']) OR empty($_POST['profile_country']))
					array_push($labels, ['profile_country', '']);

				if (!isset($_POST['profile_city']) OR empty($_POST['profile_city']))
					array_push($labels, ['profile_city', '']);

				if (!isset($_POST['profile_address']) OR empty($_POST['profile_address']))
					array_push($labels, ['profile_address', '']);

				if (!isset($_POST['profile_time_zone']) OR empty($_POST['profile_time_zone']))
					array_push($labels, ['profile_time_zone', '']);

				if (!isset($_POST['profile_currency']) OR empty($_POST['profile_currency']))
					array_push($labels, ['profile_currency', '']);

				if (!isset($_POST['profile_language']) OR empty($_POST['profile_language']))
					array_push($labels, ['profile_language', '']);

				if (empty($labels))
				{
					$query = $this->model->edit_profile($_POST);

					if (!empty($query))
					{
						$tmp = Session::get_value('account');

						$tmp['name'] = $_POST['profile_name'];
						$tmp['time_zone'] = $_POST['profile_time_zone'];
						$tmp['currency'] = $_POST['profile_currency'];
						$tmp['language'] = $_POST['profile_language'];

						Session::set_value('account', $tmp);

						Functions::environment([
							'status' => 'success',
							'message' => '{$lang.operation_success}'
						]);
					}
					else
					{
						Functions::environment([
							'status' => 'error',
							'message' => '{$lang.operation_error}'
						]);
					}
				}
				else
				{
					Functions::environment([
						'status' => 'error',
						'labels' => $labels
					]);
				}
			}

			if ($_POST['action'] == 'edit_billing')
			{
				$labels = [];

				if (!isset($_POST['billing_fiscal_id']) OR empty($_POST['billing_fiscal_id']))
					array_push($labels, ['billing_fiscal_id', '']);

				if (!isset($_POST['billing_fiscal_name']) OR empty($_POST['billing_fiscal_name']))
					array_push($labels, ['billing_fiscal_name', '']);

				if (!isset($_POST['billing_fiscal_address']) OR empty($_POST['billing_fiscal_address']))
					array_push($labels, ['billing_fiscal_address', '']);

				if (!isset($_POST['billing_contact_firstname']) OR empty($_POST['billing_contact_firstname']))
					array_push($labels, ['billing_contact_firstname', '']);

				if (!isset($_POST['billing_contact_lastname']) OR empty($_POST['billing_contact_lastname']))
					array_push($labels, ['billing_contact_lastname', '']);

				if (!isset($_POST['billing_contact_department']) OR empty($_POST['billing_contact_department']))
					array_push($labels, ['billing_contact_department', '']);

				if (!isset($_POST['billing_contact_email']) OR empty($_POST['billing_contact_email']))
					array_push($labels, ['billing_contact_email', '']);

				if (!isset($_POST['billing_contact_phone_lada']) OR empty($_POST['billing_contact_phone_lada']))
					array_push($labels, ['billing_contact_phone_lada', '']);

				if (!isset($_POST['billing_contact_phone_number']) OR empty($_POST['billing_contact_phone_number']))
					array_push($labels, ['billing_contact_phone_number', '']);

				if (empty($labels))
				{
					$query = $this->model->edit_billing($_POST);

					if (!empty($query))
					{
						Functions::environment([
							'status' => 'success',
							'message' => '{$lang.operation_success}'
						]);
					}
					else
					{
						Functions::environment([
							'status' => 'error',
							'message' => '{$lang.operation_error}'
						]);
					}
				}
				else
				{
					Functions::environment([
						'status' => 'error',
						'labels' => $labels
					]);
				}
			}

			if ($_POST['action'] == 'edit_myvox_settings' OR $_POST['action'] == 'edit_review_settings')
			{
				$labels = [];

				if ($_POST['action'] == 'edit_myvox_settings')
				{
					if (Functions::check_account_access(['reputation']) == true)
					{
						if (!empty($_POST['myvox_settings_survey']))
						{
							if (!isset($_POST['myvox_settings_survey_title_es']) OR empty($_POST['myvox_settings_survey_title_es']))
								array_push($labels, ['myvox_settings_survey_title_es', '']);

							if (!isset($_POST['myvox_settings_survey_title_en']) OR empty($_POST['myvox_settings_survey_title_en']))
								array_push($labels, ['myvox_settings_survey_title_en', '']);
						}
					}
				}

				if ($_POST['action'] == 'edit_review_settings')
				{
					if (Functions::check_account_access(['reputation']) == true)
					{
						if (!empty($_POST['review_settings_online']))
						{
							if (!isset($_POST['review_settings_email']) OR empty($_POST['review_settings_email']))
								array_push($labels, ['review_settings_email', '']);

							if (!isset($_POST['review_settings_phone_lada']) OR empty($_POST['review_settings_phone_lada']))
								array_push($labels, ['review_settings_phone_lada', '']);

							if (!isset($_POST['review_settings_phone_number']) OR empty($_POST['review_settings_phone_number']))
								array_push($labels, ['review_settings_phone_number', '']);

							if (!isset($_POST['review_settings_description_es']) OR empty($_POST['review_settings_description_es']))
								array_push($labels, ['review_settings_description_es', '']);

							if (!isset($_POST['review_settings_description_en']) OR empty($_POST['review_settings_description_en']))
								array_push($labels, ['review_settings_description_en', '']);

							if (!isset($_POST['review_settings_seo_keywords_es']) OR empty($_POST['review_settings_seo_keywords_es']))
								array_push($labels, ['review_settings_seo_keywords_es', '']);

							if (!isset($_POST['review_settings_seo_keywords_en']) OR empty($_POST['review_settings_seo_keywords_en']))
								array_push($labels, ['review_settings_seo_keywords_en', '']);

							if (!isset($_POST['review_settings_seo_meta_description_es']) OR empty($_POST['review_settings_seo_meta_description_es']))
								array_push($labels, ['review_settings_seo_meta_description_es', '']);

							if (!isset($_POST['review_settings_seo_meta_description_en']) OR empty($_POST['review_settings_seo_meta_description_en']))
								array_push($labels, ['review_settings_seo_meta_description_en', '']);
						}
					}
				}

				if (empty($labels))
				{
					$_POST['settings'] = $account['settings'];

					$query = $this->model->edit_settings($_POST);

					if (!empty($query))
					{
						Functions::environment([
							'status' => 'success',
							'message' => '{$lang.operation_success}'
						]);
					}
					else
					{
						Functions::environment([
							'status' => 'error',
							'message' => '{$lang.operation_error}'
						]);
					}
				}
				else
				{
					Functions::environment([
						'status' => 'error',
						'labels' => $labels
					]);
				}
			}
		}
		else
		{
			define('_title', 'GuestVox');

			$template = $this->view->render($this, 'index');

			$opt_countries = '';

			foreach ($this->model->get_countries() as $value)
				$opt_countries .= '<option value="' . $value['code'] . '" ' . (($account['country'] == $value['code']) ? 'selected' : '') . '>' . $value['name'][Session::get_value('account')['language']] . '</option>';

			$opt_time_zones = '';

			foreach ($this->model->get_time_zones() as $value)
				$opt_time_zones .= '<option value="' . $value['code'] . '" ' . (($account['time_zone'] == $value['code']) ? 'selected' : '') . '>' . $value['code'] . '</option>';

			$opt_currencies = '';

			foreach ($this->model->get_currencies() as $value)
				$opt_currencies .= '<option value="' . $value['code'] . '" ' . (($account['currency'] == $value['code']) ? 'selected' : '') . '>(' . $value['code'] . ') ' . $value['name'][Session::get_value('account')['language']] . '</option>';

			$opt_languages = '';

			foreach ($this->model->get_languages() as $value)
				$opt_languages .= '<option value="' . $value['code'] . '" ' . (($account['language'] == $value['code']) ? 'selected' : '') . '>' . $value['name'] . '</option>';

			$opt_billing_ladas = '';

			foreach ($this->model->get_countries() as $value)
				$opt_billing_ladas .= '<option value="' . $value['lada'] . '" ' . (($account['contact']['phone']['lada'] == $value['lada']) ? 'selected' : '') . '>(+' . $value['lada'] . ') ' . $value['name'][Session::get_value('account')['language']] . '</option>';

			$opt_review_settings_ladas = '';

			if (Functions::check_account_access(['reputation']) == true)
			{
				foreach ($this->model->get_countries() as $value)
					$opt_review_settings_ladas .= '<option value="' . $value['lada'] . '" ' . (($account['settings']['review']['phone']['lada'] == $value['lada']) ? 'selected' : '') . '>(+' . $value['lada'] . ') ' . $value['name'][Session::get_value('account')['language']] . '</option>';
			}

			$replace = [
				'{$myvox_url}' => 'https://' . Configuration::$domain . '/' . Session::get_value('account')['path'] . '/myvox',
				'{$qr}' => '{$path.uploads}' . $account['qr'],
				'{$logotype}' => '{$path.uploads}' . $account['logotype'],
				'{$operation}' => (Functions::check_account_access(['operation']) == true) ? '{$lang.activated}' : '{$lang.deactivated}',
				'{$reputation}' => (Functions::check_account_access(['reputation']) == true) ? '{$lang.activated}' : '{$lang.deactivated}',
				'{$room_package}' => (Session::get_value('account')['type'] == 'hotel') ? $account['room_package']['quantity_end'] : '',
				'{$table_package}' => (Session::get_value('account')['type'] == 'restaurant') ? $account['table_package']['quantity_end'] : '',
				'{$client_package}' => (Session::get_value('account')['type'] == 'others') ? $account['client_package']['quantity_end'] : '',
				'{$zaviapms}' => (Session::get_value('account')['type'] == 'hotel' AND $account['zaviapms']['status'] == true) ? '{$lang.activated}' : '{$lang.deactivated}',
				'{$sms}' => $account['sms'],
				'{$profile_name}' => $account['name'],
				'{$profile_type}' => $account['type'],
				'{$profile_zip_code}' => $account['zip_code'],
				'{$profile_country}' => $account['country'],
				'{$profile_city}' => $account['city'],
				'{$profile_address}' => $account['address'],
				'{$profile_time_zone}' => $account['time_zone'],
				'{$profile_currency}' => $account['currency'],
				'{$profile_language}' => $account['language'],
				'{$billing_fiscal_id}' => $account['fiscal']['id'],
				'{$billing_fiscal_name}' => $account['fiscal']['name'],
				'{$billing_fiscal_address}' => $account['fiscal']['address'],
				'{$billing_contact_firstname}' => $account['contact']['firstname'],
				'{$billing_contact_lastname}' => $account['contact']['lastname'],
				'{$billing_contact_department}' => $account['contact']['department'],
				'{$billing_contact_email}' => $account['contact']['email'],
				'{$billing_contact_phone_number}' => $account['contact']['phone']['number'],
				'{$myvox_settings_request}' => (Functions::check_account_access(['operation']) == true AND $account['settings']['myvox']['request'] == true) ? 'checked' : '',
				'{$myvox_settings_incident}' => (Functions::check_account_access(['operation']) == true AND $account['settings']['myvox']['incident'] == true) ? 'checked' : '',
				'{$myvox_settings_survey}' => (Functions::check_account_access(['reputation']) == true AND $account['settings']['myvox']['survey'] == true) ? 'checked' : '',
				'{$myvox_settings_survey_title_es}' => (Functions::check_account_access(['reputation']) == true) ? $account['settings']['myvox']['survey_title']['es'] : '',
				'{$myvox_settings_survey_title_en}' => (Functions::check_account_access(['reputation']) == true) ? $account['settings']['myvox']['survey_title']['en'] : '',
				'{$myvox_settings_survey_widget}' => (Functions::check_account_access(['reputation']) == true) ? $account['settings']['myvox']['survey_widget'] : '',
				'{$myvox_settings_survey_hidden}' => ($account['settings']['myvox']['survey'] == true) ? '' : 'hidden',
				'{$review_settings_online}' => (Functions::check_account_access(['reputation']) == true AND $account['settings']['review']['online'] == true) ? 'checked' : '',
				'{$review_settings_email}' => (Functions::check_account_access(['reputation']) == true) ? $account['settings']['review']['email'] : '',
				'{$review_settings_phone_number}' => (Functions::check_account_access(['reputation']) == true) ? $account['settings']['review']['phone']['number'] : '',
				'{$review_settings_description_es}' => (Functions::check_account_access(['reputation']) == true) ? $account['settings']['review']['description']['es'] : '',
				'{$review_settings_description_en}' => (Functions::check_account_access(['reputation']) == true) ? $account['settings']['review']['description']['en'] : '',
				'{$review_settings_seo_keywords_es}' => (Functions::check_account_access(['reputation']) == true) ? $account['settings']['review']['seo']['keywords']['es'] : '',
				'{$review_settings_seo_keywords_en}' => (Functions::check_account_access(['reputation']) == true) ? $account['settings']['review']['seo']['keywords']['en'] : '',
				'{$review_settings_seo_meta_description_es}' => (Functions::check_account_access(['reputation']) == true) ? $account['settings']['review']['seo']['meta_description']['es'] : '',
				'{$review_settings_seo_meta_description_en}' => (Functions::check_account_access(['reputation']) == true) ? $account['settings']['review']['seo']['meta_description']['en'] : '',
				'{$review_settings_social_media_facebook}' => (Functions::check_account_access(['reputation']) == true) ? $account['settings']['review']['social_media']['facebook'] : '',
				'{$review_settings_social_media_instagram}' => (Functions::check_account_access(['reputation']) == true) ? $account['settings']['review']['social_media']['instagram'] : '',
				'{$review_settings_social_media_twitter}' => (Functions::check_account_access(['reputation']) == true) ? $account['settings']['review']['social_media']['twitter'] : '',
				'{$review_settings_social_media_linkedin}' => (Functions::check_account_access(['reputation']) == true) ? $account['settings']['review']['social_media']['linkedin'] : '',
				'{$review_settings_social_media_youtube}' => (Functions::check_account_access(['reputation']) == true) ? $account['settings']['review']['social_media']['youtube'] : '',
				'{$review_settings_social_media_google}' => (Functions::check_account_access(['reputation']) == true) ? $account['settings']['review']['social_media']['google'] : '',
				'{$review_settings_social_media_tripadvisor}' => (Functions::check_account_access(['reputation']) == true) ? ((Session::get_value('account')['type'] == 'hotel' OR Session::get_value('account')['type'] == 'restaurant') ? $account['settings']['review']['social_media']['tripadvisor'] : '') : '',
				'{$review_settings_hidden}' => ($account['settings']['review']['online'] == true) ? '' : 'hidden',
				'{$opt_countries}' => $opt_countries,
				'{$opt_time_zones}' => $opt_time_zones,
				'{$opt_currencies}' => $opt_currencies,
				'{$opt_languages}' => $opt_languages,
				'{$opt_billing_ladas}' => $opt_billing_ladas,
				'{$opt_review_settings_ladas}' => $opt_review_settings_ladas
			];

			$template = $this->format->replace($replace, $template);

			echo $template;
		}
	}
}
