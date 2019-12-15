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

				if (!isset($_POST['name']) OR empty($_POST['name']) AND $this->model->check_exist_account('name', $_POST['name']) == true)
					array_push($labels, ['name', '']);

				if (!isset($_POST['zip_code']) OR empty($_POST['zip_code']))
					array_push($labels, ['zip_code', '']);

				if (!isset($_POST['country']) OR empty($_POST['country']))
					array_push($labels, ['country', '']);

				if (!isset($_POST['city']) OR empty($_POST['city']))
					array_push($labels, ['city', '']);

				if (!isset($_POST['address']) OR empty($_POST['address']))
					array_push($labels, ['address', '']);

				if (!isset($_POST['time_zone']) OR empty($_POST['time_zone']))
					array_push($labels, ['time_zone', '']);

				if (!isset($_POST['currency']) OR empty($_POST['currency']))
					array_push($labels, ['currency', '']);

				if (!isset($_POST['language']) OR empty($_POST['language']))
					array_push($labels, ['language', '']);

				if (empty($labels))
				{
					$query = $this->model->edit_profile($_POST);

					if (!empty($query))
					{
						$tmp = Session::get_value('account');

						$tmp['name'] = $_POST['name'];
						$tmp['time_zone'] = $_POST['time_zone'];
						$tmp['currency'] = $_POST['currency'];
						$tmp['language'] = $_POST['language'];

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

				if (!isset($_POST['fiscal_id']) OR empty($_POST['fiscal_id']))
					array_push($labels, ['fiscal_id', '']);

				if (!isset($_POST['fiscal_name']) OR empty($_POST['fiscal_name']))
					array_push($labels, ['fiscal_name', '']);

				if (!isset($_POST['fiscal_address']) OR empty($_POST['fiscal_address']))
					array_push($labels, ['fiscal_address', '']);

				if (!isset($_POST['contact_firstname']) OR empty($_POST['contact_firstname']))
					array_push($labels, ['contact_firstname', '']);

				if (!isset($_POST['contact_lastname']) OR empty($_POST['contact_lastname']))
					array_push($labels, ['contact_lastname', '']);

				if (!isset($_POST['contact_department']) OR empty($_POST['contact_department']))
					array_push($labels, ['contact_department', '']);

				if (!isset($_POST['contact_email']) OR empty($_POST['contact_email']))
					array_push($labels, ['contact_email', '']);

				if (!isset($_POST['contact_phone_lada']) OR empty($_POST['contact_phone_lada']))
					array_push($labels, ['contact_phone_lada', '']);

				if (!isset($_POST['contact_phone_number']) OR empty($_POST['contact_phone_number']))
					array_push($labels, ['contact_phone_number', '']);

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

			if ($_POST['action'] == 'edit_settings')
			{
				$labels = [];

				if (Functions::check_account_access(['reputation']) == true)
				{
					if (!isset($_POST['settings_myvox_survey_title_es']) OR empty($_POST['settings_myvox_survey_title_es']))
						array_push($labels, ['settings_myvox_survey_title_es', '']);

					if (!isset($_POST['settings_myvox_survey_title_en']) OR empty($_POST['settings_myvox_survey_title_en']))
						array_push($labels, ['settings_myvox_survey_title_en', '']);
				}

				if (empty($labels))
				{
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

			$account = $this->model->get_account();

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

			$opt_ladas = '';

			foreach ($this->model->get_countries() as $value)
				$opt_ladas .= '<option value="' . $value['lada'] . '" ' . (($account['contact']['phone']['lada'] == $value['lada']) ? 'selected' : '') . '>(+' . $value['lada'] . ') ' . $value['name'][Session::get_value('account')['language']] . '</option>';

			$replace = [
				'{$qr}' => '{$path.uploads}' . $account['qr'],
				'{$token}' => $account['token'],
				'{$logotype}' => '{$path.uploads}' . $account['logotype'],
				'{$name}' => $account['name'],
				'{$type}' => $account['type'],
				'{$zip_code}' => $account['zip_code'],
				'{$country}' => $account['country'],
				'{$city}' => $account['city'],
				'{$address}' => $account['address'],
				'{$time_zone}' => $account['time_zone'],
				'{$currency}' => $account['currency'],
				'{$language}' => $account['language'],
				'{$fiscal_id}' => $account['fiscal']['id'],
				'{$fiscal_name}' => $account['fiscal']['name'],
				'{$fiscal_address}' => $account['fiscal']['address'],
				'{$contact_firstname}' => $account['contact']['firstname'],
				'{$contact_lastname}' => $account['contact']['lastname'],
				'{$contact_department}' => $account['contact']['department'],
				'{$contact_email}' => $account['contact']['email'],
				'{$contact_phone_lada}' => $account['contact']['phone']['lada'],
				'{$contact_phone_number}' => $account['contact']['phone']['number'],
				'{$payment_type}' => $account['payment']['type'],
				'{$settings_myvox_request}' => (Functions::check_account_access(['operation']) == true AND $account['settings']['myvox']['request'] == true) ? '{$lang.activated}' : '{$lang.deactivated}',
				'{$settings_myvox_incident}' => (Functions::check_account_access(['operation']) == true AND $account['settings']['myvox']['incident'] == true) ? '{$lang.activated}' : '{$lang.deactivated}',
				'{$settings_myvox_survey}' => (Functions::check_account_access(['reputation']) == true AND $account['settings']['myvox']['survey'] == true) ? '{$lang.activated}' : '{$lang.deactivated}',
				'{$settings_myvox_survey_title}' => (Functions::check_account_access(['operation']) == true) ? $account['settings']['myvox']['survey_title'][Session::get_value('account')['language']] : '',
				'{$operation}' => (Functions::check_account_access(['operation']) == true) ? '{$lang.activated}' : '{$lang.deactivated}',
				'{$reputation}' => (Functions::check_account_access(['reputation']) == true) ? '{$lang.activated}' : '{$lang.deactivated}',
				'{$room_package}' => (Session::get_value('account')['type'] == 'hotel') ? $account['room_package']['quantity_end'] : '',
				'{$table_package}' => (Session::get_value('account')['type'] == 'restaurant') ? $account['table_package']['quantity_end'] : '',
				'{$sms}' => $account['sms'],
				'{$zaviapms}' => Session::get_value('account')['type'] == 'hotel' AND ($account['zaviapms']['status'] == true) ? '{$lang.activated}' : '{$lang.deactivated}',
				'{$opt_countries}' => $opt_countries,
				'{$opt_time_zones}' => $opt_time_zones,
				'{$opt_currencies}' => $opt_currencies,
				'{$opt_languages}' => $opt_languages,
				'{$opt_ladas}' => $opt_ladas,
				'{$settings_myvox_request_ckd}' => (Functions::check_account_access(['operation']) == true AND $account['settings']['myvox']['request'] == true) ? 'checked' : '',
				'{$settings_myvox_incident_ckd}' => (Functions::check_account_access(['operation']) == true AND $account['settings']['myvox']['incident'] == true) ? 'checked' : '',
				'{$settings_myvox_survey_ckd}' => (Functions::check_account_access(['reputation']) == true AND $account['settings']['myvox']['survey'] == true) ? 'checked' : '',
				'{$settings_myvox_survey_title_es}' => (Functions::check_account_access(['reputation']) == true) ? $account['settings']['myvox']['survey_title']['es'] : '',
				'{$settings_myvox_survey_title_en}' => (Functions::check_account_access(['reputation']) == true) ? $account['settings']['myvox']['survey_title']['en'] : ''
			];

			$template = $this->format->replace($replace, $template);

			echo $template;
		}
	}
}
