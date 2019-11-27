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

				if (!isset($_POST['country']) OR empty($_POST['country']))
					array_push($labels, ['country', '']);

				if (!isset($_POST['cp']) OR empty($_POST['cp']))
					array_push($labels, ['cp', '']);

				if (!isset($_POST['city']) OR empty($_POST['city']))
					array_push($labels, ['city', '']);

				if (!isset($_POST['address']) OR empty($_POST['address']))
					array_push($labels, ['address', '']);

				if (!isset($_POST['time_zone']) OR empty($_POST['time_zone']))
					array_push($labels, ['time_zone', '']);

				if (!isset($_POST['language']) OR empty($_POST['language']))
					array_push($labels, ['language', '']);

				if (!isset($_POST['currency']) OR empty($_POST['currency']))
					array_push($labels, ['currency', '']);

				if (empty($labels))
				{
					$query = $this->model->edit_profile($_POST);

					if (!empty($query))
					{
						$tmp = Session::get_value('account');

						$tmp['name'] = $_POST['name'];
						$tmp['time_zone'] = $_POST['time_zone'];
						$tmp['language'] = $_POST['language'];
						$tmp['currency'] = $_POST['currency'];

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

			if ($_POST['action'] == 'edit_fiscal')
			{
				$labels = [];

				if (!isset($_POST['fiscal_id']) OR empty($_POST['fiscal_id']) AND $this->model->check_exist_account('fiscal_id', $_POST['fiscal_id']) == true)
					array_push($labels, ['fiscal_id', '']);

				if (!isset($_POST['fiscal_name']) OR empty($_POST['fiscal_name']) AND $this->model->check_exist_account('fiscal_name', $_POST['fiscal_name']) == true)
					array_push($labels, ['fiscal_name', '']);

				if (!isset($_POST['fiscal_address']) OR empty($_POST['fiscal_address']))
					array_push($labels, ['fiscal_address', '']);

				if (!isset($_POST['contact_name']) OR empty($_POST['contact_name']))
					array_push($labels, ['contact_name', '']);

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
					$query = $this->model->edit_fiscal($_POST);

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

			if ($_POST['action'] == 'edit_myvox')
			{
				$labels = [];

				if (Functions::check_account_access(['reputation']) == true)
				{
					if (!isset($_POST['myvox_survey_title_es']) OR empty($_POST['myvox_survey_title_es']))
						array_push($labels, ['myvox_survey_title_es', '']);

					if (!isset($_POST['myvox_survey_title_en']) OR empty($_POST['myvox_survey_title_en']))
						array_push($labels, ['myvox_survey_title_en', '']);
				}

				if (empty($labels))
				{
					$query = $this->model->edit_myvox($_POST);

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
				$opt_countries .= '<option value="' . $value['code'] . '" ' . (($account['country'] == $value['code']) ? 'selected' : '') . '>' . $value['name'][Session::get_value('lang')] . '</option>';

			$opt_time_zones = '';

			foreach ($this->model->get_time_zones() as $value)
				$opt_time_zones .= '<option value="' . $value['code'] . '" ' . (($account['time_zone'] == $value['code']) ? 'selected' : '') . '>' . $value['code'] . '</option>';

			$opt_languages = '';

			foreach ($this->model->get_languages() as $value)
				$opt_languages .= '<option value="' . $value['code'] . '" ' . (($account['language'] == $value['code']) ? 'selected' : '') . '>' . $value['name'] . '</option>';

			$opt_currencies = '';

			foreach ($this->model->get_currencies() as $value)
				$opt_currencies .= '<option value="' . $value['code'] . '" ' . (($account['currency'] == $value['code']) ? 'selected' : '') . '>' . $value['name'][Session::get_value('lang')] . ' (' . $value['code'] . ')</option>';

			$opt_ladas = '';

			foreach ($this->model->get_countries() as $value)
				$opt_ladas .= '<option value="' . $value['lada'] . '" ' . (($account['contact']['phone']['lada'] == $value['lada']) ? 'selected' : '') . '>' . $value['name'][Session::get_value('lang')] . ' (+' . $value['lada'] . ')</option>';

			$replace = [
				'{$logotype}' => !empty($account['logotype']) ? '{$path.uploads}' . $account['logotype'] : '{$path.images}empty.png',
				'{$name}' => $account['name'],
				'{$country}' => $account['country'],
				'{$cp}' => $account['cp'],
				'{$city}' => $account['city'],
				'{$address}' => $account['address'],
				'{$time_zone}' => $account['time_zone'],
				'{$language}' => $account['language'],
				'{$currency}' => $account['currency'],
				'{$fiscal_id}' => $account['fiscal_id'],
				'{$fiscal_name}' => $account['fiscal_name'],
				'{$fiscal_address}' => $account['fiscal_address'],
				'{$contact_name}' => $account['contact']['name'],
				'{$contact_department}' => $account['contact']['department'],
				'{$contact_email}' => $account['contact']['email'],
				'{$contact_phone_lada}' => $account['contact']['phone']['lada'],
				'{$contact_phone_number}' => $account['contact']['phone']['number'],
				'{$myvox_request}' => ($account['myvox_request'] == true) ? '{$lang.active}' : '{$lang.deactive}',
				'{$myvox_request_ckd}' => ($account['myvox_request'] == true) ? 'checked' : '',
				'{$myvox_incident}' => ($account['myvox_incident'] == true) ? '{$lang.active}' : '{$lang.deactive}',
				'{$myvox_incident_ckd}' => ($account['myvox_incident'] == true) ? 'checked' : '',
				'{$myvox_survey}' => ($account['myvox_survey'] == true) ? '{$lang.active}' : '{$lang.deactive}',
				'{$myvox_survey_ckd}' => ($account['myvox_survey'] == true) ? 'checked' : '',
				'{$myvox_survey_title}' => $account['myvox_survey_title'][Session::get_value('account')['language']],
				'{$myvox_survey_title_es}' => $account['myvox_survey_title']['es'],
				'{$myvox_survey_title_en}' => $account['myvox_survey_title']['en'],
				'{$sms}' => $account['sms'] . ' SMS <span>' . (($account['sms'] > 0) ? '{$lang.active}' : '{$lang.deactive}') . '</span>',
				// '{$pms}' => 'Zavia PMS <span>' . (($account['zav'] == true) ? '{$lang.active}' : '{$lang.deactive}') . '</span>',
				// '{$room_package}' => $account['room_package_quantity_end'] . ' {$lang.rooms} <span>' . Functions::get_formatted_currency($account['room_package_price'], 'MXN') . ' {$lang.per_month}</span>',
				// '{$user_package}' => $account['user_package_quantity_end'] . ' {$lang.users} <span>' . Functions::get_formatted_currency($account['user_package_price'], 'MXN') . ' {$lang.per_month}</span>',
				'{$opt_countries}' => $opt_countries,
				'{$opt_time_zones}' => $opt_time_zones,
				'{$opt_languages}' => $opt_languages,
				'{$opt_currencies}' => $opt_currencies,
				'{$opt_ladas}' => $opt_ladas,
			];

			$template = $this->format->replace($replace, $template);

			echo $template;
		}
	}
}
