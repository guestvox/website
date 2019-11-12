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

				Functions::environment([
					'status' => !empty($query) ? 'success' : 'error',
					'message' => !empty($query) ? '{$lang.success_operation_database}' : '{$lang.error_operation_database}',
					'path' => '/account',
				]);
			}

			if ($_POST['action'] == 'edit_account')
			{
				$labels = [];

				if (!isset($_POST['account']) OR empty($_POST['account']) OR $this->model->check_exist_account($_POST['account'], 'account') == true)
					array_push($labels, ['account','']);

				if (!isset($_POST['country']) OR empty($_POST['country']))
					array_push($labels, ['country','']);

				if (!isset($_POST['cp']) OR empty($_POST['cp']))
					array_push($labels, ['cp','']);

				if (!isset($_POST['city']) OR empty($_POST['city']))
					array_push($labels, ['city','']);

				if (!isset($_POST['address']) OR empty($_POST['address']))
					array_push($labels, ['address','']);

				if (!isset($_POST['time_zone']) OR empty($_POST['time_zone']))
					array_push($labels, ['time_zone','']);

				if (!isset($_POST['language']) OR empty($_POST['language']))
					array_push($labels, ['language','']);

				if (!isset($_POST['currency']) OR empty($_POST['currency']))
					array_push($labels, ['currency','']);

				if (!isset($_POST['fiscal_id']) OR empty($_POST['fiscal_id']) OR $this->model->check_exist_account($_POST['fiscal_id'], 'fiscal_id') == true)
			        array_push($labels, ['fiscal_id','']);

				if (!isset($_POST['fiscal_name']) OR empty($_POST['fiscal_name']) OR $this->model->check_exist_account($_POST['fiscal_name'], 'fiscal_name') == true)
			        array_push($labels, ['fiscal_name','']);

				if (!isset($_POST['fiscal_address']) OR empty($_POST['fiscal_address']))
			        array_push($labels, ['fiscal_address','']);

				if (!isset($_POST['contact_name']) OR empty($_POST['contact_name']))
			        array_push($labels, ['contact_name','']);

				if (!isset($_POST['contact_department']) OR empty($_POST['contact_department']))
			        array_push($labels, ['contact_department','']);

				if (!isset($_POST['contact_lada']) OR empty($_POST['contact_lada']))
			        array_push($labels, ['contact_lada','']);

				if (!isset($_POST['contact_phone']) OR empty($_POST['contact_phone']) OR strlen($_POST['contact_phone']) != 10)
			        array_push($labels, ['contact_phone','']);

				if (!isset($_POST['contact_email']) OR empty($_POST['contact_email']) OR Functions::check_email($_POST['contact_email']) == false)
			        array_push($labels, ['contact_email','']);

				if (empty($labels))
				{
					$query = $this->model->edit_account($_POST);

					Functions::environment([
						'status' => !empty($query) ? 'success' : 'error',
						'message' => !empty($query) ? '{$lang.success_operation_database}' : '{$lang.error_operation_database}',
						'path' => '/account',
					]);
				}
				else
				{
					Functions::environment([
						'status' => 'error',
						'labels' => $labels
					]);
				}
			}

			if ($_POST['action'] == 'request_sms')
			{
				$labels = [];

				if (!isset($_POST['package']) OR empty($_POST['package']))
					array_push($labels, ['package','']);

				if (empty($labels))
				{
					$_POST['package'] = $this->model->get_sms_package($_POST['package']);

					$mail = new Mailer(true);

					try
					{
						$mail->setFrom('noreply@guestvox.com', 'GuestVox');
						$mail->addAddress('daniel@guestvox.com', 'Daniel Basurto');
						$mail->addAddress('gerson@guestvox.com', 'Gersón Gómez');
						$mail->isHTML(true);
						$mail->Subject = 'Nueva solicitud de sms';
						$mail->Body =
						'Cuenta: ' . Session::get_value('account')['name'] . '<br>
						Paquete: ' . $_POST['package']['quantity'] . ' SMS ' . Functions::get_formatted_currency($_POST['package']['price'], 'MXN') . '<br>';
						$mail->AltBody = '';
						$mail->send();
					}
					catch (Exception $e) { }

					if (Session::get_value('settings')['language'] == 'es')
						$mail_message = 'Hemos recibido tu solicitud';
					else if (Session::get_value('settings')['language'] == 'en')
						$mail_message = 'We have received your request';

					Functions::environment([
						'status' => 'success',
						'message' => $mail_message,
						'path' => '/account',
					]);
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
			define('_title', 'GuestVox | {$lang.account}');

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
				$opt_ladas .= '<option value="' . $value['lada'] . '" ' . (($account['contact']['lada'] == $value['lada']) ? 'selected' : '') . '>' . $value['name'][Session::get_value('lang')] . ' (+' . $value['lada'] . ')</option>';

			$opt_sms_packages = '';

			foreach ($this->model->get_sms_packages() as $value)
				$opt_sms_packages .= '<option value="' . $value['id'] . '">' . $value['quantity'] . ' SMS (' . Functions::get_formatted_currency($value['price'], 'MXN') . ')</option>';

			$replace = [
				'{$logotype}' => !empty($account['logotype']) ? '{$path.uploads}' . $account['logotype'] : '{$path.images}empty.png',
				'{$account}' => $account['name'],
				'{$signup_date}' => 'Registrado desde ' . Functions::get_formatted_date($account['signup_date'], 'd M Y'),
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
				'{$contact_lada}' => $account['contact']['lada'],
				'{$contact_phone}' => $account['contact']['phone'],
				'{$contact_email}' => $account['contact']['email'],
				'{$sms}' => $account['sms'],
				'{$private_key}' => $account['private_key'],
				'{$opt_countries}' => $opt_countries,
				'{$opt_time_zones}' => $opt_time_zones,
				'{$opt_languages}' => $opt_languages,
				'{$opt_currencies}' => $opt_currencies,
				'{$opt_ladas}' => $opt_ladas,
				'{$opt_sms_packages}' => $opt_sms_packages,
			];

			$template = $this->format->replace($replace, $template);

			echo $template;
		}
	}
}
