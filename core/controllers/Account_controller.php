<?php

defined('_EXEC') or die;

class Account_controller extends Controller
{
	private $lang;

	public function __construct()
	{
		parent::__construct();

		$this->lang = Session::get_value('account')['language'];
	}

	public function index()
	{
		$account = $this->model->get_account();

		if (Format::exist_ajax_request() == true)
		{
			if ($_POST['action'] == 'get_account')
			{
				Functions::environment([
					'status' => 'success',
					'data' => $account
				]);
			}

			if ($_POST['action'] == 'edit_logotype')
			{
				$labels = [];

				if (!isset($_FILES['logotype']['name']) OR empty($_FILES['logotype']['name']))
					array_push($labels, ['logotype','']);

				if (empty($labels))
				{
					$query = $this->model->edit_logotype($_FILES);

					if (!empty($query))
					{
						$account = Session::get_value('account');

						$account['logotype'] = $query;

						Session::set_value('account', $account);

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

			if ($_POST['action'] == 'edit_account')
			{
				$labels = [];

				if (!isset($_POST['name']) OR empty($_POST['name']) OR $this->model->check_exist_account('name', $_POST['name']) == true)
					array_push($labels, ['name','']);

				if (!isset($_POST['country']) OR empty($_POST['country']))
					array_push($labels, ['country','']);

				if (!isset($_POST['city']) OR empty($_POST['city']))
					array_push($labels, ['city','']);

				if (!isset($_POST['zip_code']) OR empty($_POST['zip_code']))
					array_push($labels, ['zip_code','']);

				if (!isset($_POST['address']) OR empty($_POST['address']))
					array_push($labels, ['address','']);

				if (!isset($_POST['time_zone']) OR empty($_POST['time_zone']))
					array_push($labels, ['time_zone','']);

				if (!isset($_POST['currency']) OR empty($_POST['currency']))
					array_push($labels, ['currency','']);

				if (!isset($_POST['language']) OR empty($_POST['language']))
					array_push($labels, ['language','']);

				if (empty($labels))
				{
					$query = $this->model->edit_account($_POST);

					if (!empty($query))
					{
						$account = Session::get_value('account');

						$account['name'] = $_POST['name'];
						$account['time_zone'] = $_POST['time_zone'];
						$account['currency'] = $_POST['currency'];
						$account['language'] = $_POST['language'];

						Session::set_value('account', $account);

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
					array_push($labels, ['fiscal_id','']);

				if (!isset($_POST['fiscal_name']) OR empty($_POST['fiscal_name']))
					array_push($labels, ['fiscal_name','']);

				if (!isset($_POST['fiscal_address']) OR empty($_POST['fiscal_address']))
					array_push($labels, ['fiscal_address','']);

				if (!isset($_POST['contact_firstname']) OR empty($_POST['contact_firstname']))
					array_push($labels, ['contact_firstname','']);

				if (!isset($_POST['contact_lastname']) OR empty($_POST['contact_lastname']))
					array_push($labels, ['contact_lastname','']);

				if (!isset($_POST['contact_department']) OR empty($_POST['contact_department']))
					array_push($labels, ['contact_department','']);

				if (!isset($_POST['contact_email']) OR empty($_POST['contact_email']) OR Functions::check_email($_POST['contact_email']) == false)
					array_push($labels, ['contact_email','']);

				if (!isset($_POST['contact_phone_lada']) OR empty($_POST['contact_phone_lada']))
					array_push($labels, ['contact_phone_lada','']);

				if (!isset($_POST['contact_phone_number']) OR empty($_POST['contact_phone_number']))
					array_push($labels, ['contact_phone_number','']);

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

			if ($_POST['action'] == 'edit_location')
			{
				$labels = [];

				if (!isset($_POST['lat']) OR empty($_POST['lat']))
					array_push($labels, ['lat','']);

				if (!isset($_POST['lng']) OR empty($_POST['lng']))
					array_push($labels, ['lng','']);

				if (empty($labels))
				{
					$query = $this->model->edit_location($_POST);

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

			if ($_POST['action'] == 'get_opt_opportunity_types')
			{
				$html = '<option value="" hidden>{$lang.choose}</option>';

				if (!empty($_POST['opportunity_area']))
				{
					foreach ($this->model->get_opportunity_types($_POST['opportunity_area'], 'request') as $value)
						$html .= '<option value="' . $value['id'] . '">' . $value['name'][$this->lang] . '</option>';
				}

				Functions::environment([
					'status' => 'success',
					'html' => $html
				]);
			}

			if ($_POST['action'] == 'edit_myvox_menu_settings' OR $_POST['action'] == 'edit_myvox_request_settings' OR $_POST['action'] == 'edit_myvox_incident_settings' OR $_POST['action'] == 'edit_voxes_attention_times_settings' OR $_POST['action'] == 'edit_myvox_survey_settings' OR $_POST['action'] == 'edit_reviews_settings')
			{
				$labels = [];

				if ($_POST['action'] == 'edit_myvox_menu_settings')
				{
					if (!empty($_POST['status']))
					{
						if (!isset($_POST['title_es']) OR empty($_POST['title_es']))
							array_push($labels, ['title_es','']);

						if (!isset($_POST['title_en']) OR empty($_POST['title_en']))
							array_push($labels, ['title_en','']);

						if (!isset($_POST['email']) OR empty($_POST['email']))
							array_push($labels, ['email','']);

						if (!isset($_POST['phone_lada']) OR empty($_POST['phone_lada']))
							array_push($labels, ['phone_lada','']);

						if (!isset($_POST['phone_number']) OR empty($_POST['phone_number']))
							array_push($labels, ['phone_number','']);

						if (!isset($_POST['currency']) OR empty($_POST['currency']))
							array_push($labels, ['currency','']);

						if (!isset($_POST['schedule_monday_status']) OR empty($_POST['schedule_monday_status']))
							array_push($labels, ['schedule_monday_status','']);
						else if ($_POST['schedule_monday_status'] == 'open')
						{
							if (!isset($_POST['schedule_monday_opening']) OR empty($_POST['schedule_monday_opening']) OR $_POST['schedule_monday_opening'] >= $_POST['schedule_monday_closing'])
								array_push($labels, ['schedule_monday_opening','']);

							if (!isset($_POST['schedule_monday_closing']) OR empty($_POST['schedule_monday_closing']) OR $_POST['schedule_monday_closing'] <= $_POST['schedule_monday_opening'])
								array_push($labels, ['schedule_monday_closing','']);
						}

						if (!isset($_POST['schedule_tuesday_status']) OR empty($_POST['schedule_tuesday_status']))
							array_push($labels, ['schedule_tuesday_status','']);
						else if ($_POST['schedule_tuesday_status'] == 'open')
						{
							if (!isset($_POST['schedule_tuesday_opening']) OR empty($_POST['schedule_tuesday_opening']) OR $_POST['schedule_tuesday_opening'] >= $_POST['schedule_tuesday_closing'])
								array_push($labels, ['schedule_tuesday_opening','']);

							if (!isset($_POST['schedule_tuesday_closing']) OR empty($_POST['schedule_tuesday_closing']) OR $_POST['schedule_tuesday_closing'] <= $_POST['schedule_tuesday_opening'])
								array_push($labels, ['schedule_tuesday_closing','']);
						}

						if (!isset($_POST['schedule_wednesday_status']) OR empty($_POST['schedule_wednesday_status']))
							array_push($labels, ['schedule_wednesday_status','']);
						else if ($_POST['schedule_wednesday_status'] == 'open')
						{
							if (!isset($_POST['schedule_wednesday_opening']) OR empty($_POST['schedule_wednesday_opening']) OR $_POST['schedule_wednesday_opening'] >= $_POST['schedule_wednesday_closing'])
								array_push($labels, ['schedule_wednesday_opening','']);

							if (!isset($_POST['schedule_wednesday_closing']) OR empty($_POST['schedule_wednesday_closing']) OR $_POST['schedule_wednesday_closing'] <= $_POST['schedule_wednesday_opening'])
								array_push($labels, ['schedule_wednesday_closing','']);
						}

						if (!isset($_POST['schedule_thursday_status']) OR empty($_POST['schedule_thursday_status']))
							array_push($labels, ['schedule_thursday_status','']);
						else if ($_POST['schedule_thursday_status'] == 'open')
						{
							if (!isset($_POST['schedule_thursday_opening']) OR empty($_POST['schedule_thursday_opening']) OR $_POST['schedule_thursday_opening'] >= $_POST['schedule_thursday_closing'])
								array_push($labels, ['schedule_thursday_opening','']);

							if (!isset($_POST['schedule_thursday_closing']) OR empty($_POST['schedule_thursday_closing']) OR $_POST['schedule_thursday_closing'] <= $_POST['schedule_thursday_opening'])
								array_push($labels, ['schedule_thursday_closing','']);
						}

						if (!isset($_POST['schedule_friday_status']) OR empty($_POST['schedule_friday_status']))
							array_push($labels, ['schedule_friday_status','']);
						else if ($_POST['schedule_friday_status'] == 'open')
						{
							if (!isset($_POST['schedule_friday_opening']) OR empty($_POST['schedule_friday_opening']) OR $_POST['schedule_friday_opening'] >= $_POST['schedule_friday_closing'])
								array_push($labels, ['schedule_friday_opening','']);

							if (!isset($_POST['schedule_friday_closing']) OR empty($_POST['schedule_friday_closing']) OR $_POST['schedule_friday_closing'] <= $_POST['schedule_friday_opening'])
								array_push($labels, ['schedule_friday_closing','']);
						}

						if (!isset($_POST['schedule_saturday_status']) OR empty($_POST['schedule_saturday_status']))
							array_push($labels, ['schedule_saturday_status','']);
						else if ($_POST['schedule_saturday_status'] == 'open')
						{
							if (!isset($_POST['schedule_saturday_opening']) OR empty($_POST['schedule_saturday_opening']) OR $_POST['schedule_saturday_opening'] >= $_POST['schedule_saturday_closing'])
								array_push($labels, ['schedule_saturday_opening','']);

							if (!isset($_POST['schedule_saturday_closing']) OR empty($_POST['schedule_saturday_closing']) OR $_POST['schedule_saturday_closing'] <= $_POST['schedule_saturday_opening'])
								array_push($labels, ['schedule_saturday_closing','']);
						}

						if (!isset($_POST['schedule_sunday_status']) OR empty($_POST['schedule_sunday_status']))
							array_push($labels, ['schedule_sunday_status','']);
						else if ($_POST['schedule_sunday_status'] == 'open')
						{
							if (!isset($_POST['schedule_sunday_opening']) OR empty($_POST['schedule_sunday_opening']) OR $_POST['schedule_sunday_opening'] >= $_POST['schedule_sunday_closing'])
								array_push($labels, ['schedule_sunday_opening','']);

							if (!isset($_POST['schedule_sunday_closing']) OR empty($_POST['schedule_sunday_closing']) OR $_POST['schedule_sunday_closing'] <= $_POST['schedule_sunday_opening'])
								array_push($labels, ['schedule_sunday_closing','']);
						}

						if (($account['type'] == 'restaurant' OR $account['type'] == 'others') AND !empty($_POST['delivery']) AND (!isset($_POST['sell_radius']) OR empty($_POST['sell_radius'])))
							array_push($labels, ['sell_radius','']);
					}
				}
				else if ($_POST['action'] == 'edit_myvox_request_settings')
				{
					if (!empty($_POST['status']))
					{
						if (!isset($_POST['title_es']) OR empty($_POST['title_es']))
							array_push($labels, ['title_es','']);

						if (!isset($_POST['title_en']) OR empty($_POST['title_en']))
							array_push($labels, ['title_en','']);
					}
				}
				else if ($_POST['action'] == 'edit_myvox_incident_settings')
				{
					if (!empty($_POST['status']))
					{
						if (!isset($_POST['title_es']) OR empty($_POST['title_es']))
							array_push($labels, ['title_es','']);

						if (!isset($_POST['title_en']) OR empty($_POST['title_en']))
							array_push($labels, ['title_en','']);
					}
				}
				else if ($_POST['action'] == 'edit_voxes_attention_times_settings')
				{
					if (!isset($_POST['request_low']) OR empty($_POST['request_low']))
						array_push($labels, ['request_low','']);

					if (!isset($_POST['request_medium']) OR empty($_POST['request_medium']))
						array_push($labels, ['request_medium','']);

					if (!isset($_POST['request_high']) OR empty($_POST['request_high']))
						array_push($labels, ['request_high','']);

					if (!isset($_POST['incident_low']) OR empty($_POST['incident_low']))
						array_push($labels, ['incident_low','']);

					if (!isset($_POST['incident_medium']) OR empty($_POST['incident_medium']))
						array_push($labels, ['incident_medium','']);

					if (!isset($_POST['incident_high']) OR empty($_POST['incident_high']))
						array_push($labels, ['incident_high','']);
				}
				else if ($_POST['action'] == 'edit_myvox_survey_settings')
				{
					if (!empty($_POST['status']))
					{
						if (!isset($_POST['title_es']) OR empty($_POST['title_es']))
							array_push($labels, ['title_es','']);

						if (!isset($_POST['title_en']) OR empty($_POST['title_en']))
							array_push($labels, ['title_en','']);

						if (!isset($_POST['mail_subject_es']) OR empty($_POST['mail_subject_es']))
							array_push($labels, ['mail_subject_es','']);

						if (!isset($_POST['mail_subject_en']) OR empty($_POST['mail_subject_en']))
							array_push($labels, ['mail_subject_en','']);

						if (!isset($_POST['mail_description_es']) OR empty($_POST['mail_description_es']))
							array_push($labels, ['mail_description_es','']);

						if (!isset($_POST['mail_description_en']) OR empty($_POST['mail_description_en']))
							array_push($labels, ['mail_description_en','']);
					}
				}
				else if ($_POST['action'] == 'edit_reviews_settings')
				{
					if (!empty($_POST['status']))
					{
						if (!isset($_POST['email']) OR empty($_POST['email']) OR Functions::check_email($_POST['email']) == false)
							array_push($labels, ['email','']);

						if (!isset($_POST['phone_lada']) OR empty($_POST['phone_lada']))
							array_push($labels, ['phone_lada','']);

						if (!isset($_POST['phone_number']) OR empty($_POST['phone_number']))
							array_push($labels, ['phone_number','']);

						if (!isset($_POST['website']) OR empty($_POST['website']))
							array_push($labels, ['website','']);

						if (!isset($_POST['description_es']) OR empty($_POST['description_es']))
							array_push($labels, ['description_es','']);

						if (!isset($_POST['description_en']) OR empty($_POST['description_en']))
							array_push($labels, ['description_en','']);

						if (!isset($_POST['seo_keywords_es']) OR empty($_POST['seo_keywords_es']))
							array_push($labels, ['seo_keywords_es','']);

						if (!isset($_POST['seo_keywords_en']) OR empty($_POST['seo_keywords_en']))
							array_push($labels, ['seo_keywords_en','']);

						if (!isset($_POST['seo_description_es']) OR empty($_POST['seo_description_es']))
							array_push($labels, ['seo_description_es','']);

						if (!isset($_POST['seo_description_en']) OR empty($_POST['seo_description_en']))
							array_push($labels, ['seo_description_en','']);
					}
				}

				if (empty($labels))
				{
					if ($_POST['action'] == 'edit_myvox_menu_settings')
						$query = $this->model->edit_settings('myvox_menu', $_POST, $account);
					else if ($_POST['action'] == 'edit_myvox_request_settings')
						$query = $this->model->edit_settings('myvox_request', $_POST);
					else if ($_POST['action'] == 'edit_myvox_incident_settings')
						$query = $this->model->edit_settings('myvox_incident', $_POST);
					else if ($_POST['action'] == 'edit_voxes_attention_times_settings')
						$query = $this->model->edit_settings('voxes_attention_times', $_POST);
					else if ($_POST['action'] == 'edit_myvox_survey_settings')
					{
						if (!empty($_POST['status']))
						{
							$_POST['mail_image'] = $_FILES['mail_image'];
							$_POST['mail_attachment'] = $_FILES['mail_attachment'];
						}

						$query = $this->model->edit_settings('myvox_survey', $_POST);
					}
					else if ($_POST['action'] == 'edit_reviews_settings')
						$query = $this->model->edit_settings('reviews', $_POST);

					if (!empty($query))
					{
						if ($_POST['action'] == 'edit_myvox_menu_settings')
						{
							$account = Session::get_value('account');

							if (isset($_POST['currency']))
								$account['settings']['menu']['currency'] = $_POST['currency'];

							if (isset($_POST['multi']))
								$account['settings']['menu']['multi'] = !empty($_POST['multi']) ? true : false;

							Session::set_value('account', $account);
						}

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

			if ($_POST['action'] == 'edit_payment')
			{
				$labels = [];

				if (!empty($_POST['status']) AND $account['payment']['contract']['status'] == 'deactivated')
				{
					if (!isset($_POST['contract_titular_fiscal_person']) OR empty($_POST['contract_titular_fiscal_person']))
						array_push($labels, ['contract_titular_fiscal_person','']);

					if (!isset($_POST['contract_titular_fiscal_id']) OR empty($_POST['contract_titular_fiscal_id']))
						array_push($labels, ['contract_titular_fiscal_id','']);

					if (!isset($_POST['contract_titular_fiscal_name']) OR empty($_POST['contract_titular_fiscal_name']))
						array_push($labels, ['contract_titular_fiscal_name','']);

					if (!isset($_POST['contract_titular_fiscal_activity']) OR empty($_POST['contract_titular_fiscal_activity']))
						array_push($labels, ['contract_titular_fiscal_activity','']);

					if (!isset($_POST['contract_titular_address_street']) OR empty($_POST['contract_titular_address_street']))
						array_push($labels, ['contract_titular_address_street','']);

					if (!isset($_POST['contract_titular_address_external_number']) OR empty($_POST['contract_titular_address_external_number']))
						array_push($labels, ['contract_titular_address_external_number','']);

					if (!isset($_POST['contract_titular_address_cp']) OR empty($_POST['contract_titular_address_cp']))
						array_push($labels, ['contract_titular_address_cp','']);

					if (!isset($_POST['contract_titular_address_colony']) OR empty($_POST['contract_titular_address_colony']))
						array_push($labels, ['contract_titular_address_colony','']);

					if (!isset($_POST['contract_titular_address_delegation']) OR empty($_POST['contract_titular_address_delegation']))
						array_push($labels, ['contract_titular_address_delegation','']);

					if (!isset($_POST['contract_titular_address_city']) OR empty($_POST['contract_titular_address_city']))
						array_push($labels, ['contract_titular_address_city','']);

					if (!isset($_POST['contract_titular_address_state']) OR empty($_POST['contract_titular_address_state']))
						array_push($labels, ['contract_titular_address_state','']);

					if (!isset($_POST['contract_titular_address_country']) OR empty($_POST['contract_titular_address_country']))
						array_push($labels, ['contract_titular_address_country','']);

					if (!isset($_POST['contract_titular_bank_name']) OR empty($_POST['contract_titular_bank_name']))
						array_push($labels, ['contract_titular_bank_name','']);

					if (!isset($_POST['contract_titular_bank_branch']) OR empty($_POST['contract_titular_bank_branch']))
						array_push($labels, ['contract_titular_bank_branch','']);

					if (!isset($_POST['contract_titular_bank_checkbook']) OR empty($_POST['contract_titular_bank_checkbook']))
						array_push($labels, ['contract_titular_bank_checkbook','']);

					if (!isset($_POST['contract_titular_bank_clabe']) OR empty($_POST['contract_titular_bank_clabe']))
						array_push($labels, ['contract_titular_bank_clabe','']);

					if (!isset($_POST['contract_place']) OR empty($_POST['contract_place']))
						array_push($labels, ['contract_place','']);

					if (!isset($_POST['contract_signature']) OR empty($_POST['contract_signature']))
						array_push($labels, ['contract_signature','']);
				}

				if (empty($labels))
				{
					$_POST['contract_status'] = $account['payment']['contract']['status'];

					$query = $this->model->edit_payment($_POST);

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
			$template = $this->view->render($this, 'index');

			define('_title', 'Guestvox | {$lang.account}');

			$div_menu = '';

			if ($account['digital_menu'] == true)
			{
				$div_menu .=
				'<div class="stl_5">
					<i class="fas fa-fire-alt"></i>
					<h2>{$lang.menu}</h2>
					<span>' . (($account['settings']['myvox']['menu']['status'] == true) ? '{$lang.activated}' : '{$lang.deactivated}') . '</span>
					<div class="switch_group">
						<div class="switch">
							<input id="mnsw" type="checkbox" ' . (($account['settings']['myvox']['menu']['status'] == true) ? 'checked' : '') . ' data-switcher>
							<label for="mnsw"></label>
						</div>
						' . (($account['settings']['myvox']['menu']['status'] == true) ? '<a class="edit" data-action="edit_myvox_menu_settings"><i class="fas fa-pen" aria-hidden="true"></i></a>' : '') . '
					</div>
				</div>';
			}

			$div_public_requests = '';
			$div_public_incidents = '';
			$div_attention_times = '';
			$div_siteminder = '';
			$div_zaviapms = '';
			$div_ambit = '';

			if ($account['operation'] == true)
			{
				$div_public_requests .=
				'<div class="stl_5">
	                <i class="fas fa-rocket"></i>
	                <h2>{$lang.public_requests}</h2>
	                <span>' . (($account['settings']['myvox']['request']['status'] == true) ? '{$lang.activated}' : '{$lang.deactivated}') . '</span>
					<div class="switch_group">
						<div class="switch">
							<input id="rqsw" type="checkbox" ' . (($account['settings']['myvox']['request']['status'] == true) ? 'checked' : '') . ' data-switcher>
							<label for="rqsw"></label>
						</div>
						' . (($account['settings']['myvox']['request']['status'] == true) ? '<a class="edit" data-action="edit_myvox_request_settings"><i class="fas fa-pen" aria-hidden="true"></i></a>' : '') . '
					</div>
	            </div>';

				$div_public_incidents .=
				'<div class="stl_5">
	                <i class="fas fa-meteor"></i>
	                <h2>{$lang.public_incidents}</h2>
	                <span>' . (($account['settings']['myvox']['incident']['status'] == true) ? '{$lang.activated}' : '{$lang.deactivated}') . '</span>
					<div class="switch_group">
						<div class="switch">
						    <input id="insw" type="checkbox" ' . (($account['settings']['myvox']['incident']['status'] == true) ? 'checked' : '') . ' data-switcher>
						    <label for="insw"></label>
						</div>
						' . (($account['settings']['myvox']['incident']['status'] == true) ? '<a class="edit" data-action="edit_myvox_incident_settings"><i class="fas fa-pen" aria-hidden="true"></i></a>' : '') . '
					</div>
	            </div>';

				$div_attention_times .=
				'<div class="stl_5">
	                <i class="fas fa-clock"></i>
	                <h2>{$lang.attention_times}</h2>
	                <span>{$lang.activated}</span>
					<a class="edit" data-action="edit_voxes_attention_times_settings"><i class="fas fa-pen"></i></a>
	            </div>';

				if ($account['type'] == 'hotel')
				{
					$div_siteminder .=
					'<div class="stl_5">
						<figure>
							<img src="{$path.images}siteminder.png">
						</figure>
						<h2>Siteminder</h2>
						<span>' . (($account['siteminder']['status'] == true) ? '{$lang.activated}' : '{$lang.deactivated}') . '</span>
	                </div>';

					$div_zaviapms .=
					'<div class="stl_5">
						<figure>
							<img src="{$path.images}zaviapms.png">
						</figure>
						<h2>Zavia PMS</h2>
						<span>' . (($account['zaviapms']['status'] == true) ? '{$lang.activated}' : '{$lang.deactivated}') . '</span>
	                </div>';
				}

				if ($account['type'] == 'hotel' OR $account['type'] == 'restaurant')
				{
					$div_ambit .=
					'<div class="stl_5">
						<figure>
							<img src="{$path.images}ambit.png">
						</figure>
						<h2>Ambit</h2>
						<span>' . (($account['ambit']['status'] == true) ? '{$lang.activated}' : '{$lang.deactivated}') . '</span>
					</div>';
				}
			}

			$div_answer_surveys = '';
			$div_reviews_page = '';

			if ($account['surveys'] == true)
			{
				$div_answer_surveys .=
				'<div class="stl_5">
	                <i class="fas fa-ghost"></i>
	                <h2>{$lang.answer_surveys}</h2>
	                <span>' . (($account['settings']['myvox']['survey']['status'] == true) ? '{$lang.activated}' : '{$lang.deactivated}') . '</span>
					<div class="switch_group">
						<div class="switch">
							<input id="susw" type="checkbox" ' . (($account['settings']['myvox']['survey']['status'] == true) ? 'checked' : '') . ' data-switcher>
							<label for="susw"></label>
						</div>
						' . (($account['settings']['myvox']['survey']['status'] == true) ? '<a class="edit" data-action="edit_myvox_survey_settings"><i class="fas fa-pen" aria-hidden="true"></i></a>' : '') . '
					</div>
	            </div>';

				$div_reviews_page .=
				'<div class="stl_5">
	                <i class="fas fa-star"></i>
	                <h2>{$lang.reviews_page}</h2>
	                <span>' . (($account['settings']['reviews']['status'] == true) ? '{$lang.activated}' : '{$lang.deactivated}') . '</span>
					<div class="switch_group">
						<div class="switch">
						    <input id="rvsw" type="checkbox" ' . (($account['settings']['reviews']['status'] == true) ? 'checked' : '') . ' data-switcher>
						    <label for="rvsw"></label>
						</div>
						' . (($account['settings']['reviews']['status'] == true) ? '<a class="edit" data-action="edit_reviews_settings"><i class="fas fa-pen" aria-hidden="true"></i></a>' : '') . '
					</div>
	            </div>';
			}

			$div_payment =
			'<div class="stl_5">
				<i class="fas fa-credit-card"></i>
				<h2>{$lang.payment}</h2>
				<span>' . (($account['payment']['status'] == true) ? '{$lang.activated}' : '{$lang.deactivated}') . '</span>
				<div class="switch_group">
					<div class="switch">
						<input id="pysw" type="checkbox" ' . (($account['payment']['status'] == true) ? 'checked' : '') . ' data-switcher>
						<label for="pysw"></label>
					</div>
					' . (($account['payment']['status'] == true) ? '<a class="edit" data-action="edit_payment"><i class="fas fa-pen" aria-hidden="true"></i></a>' : '') . '
				</div>
			</div>';

			$opt_countries = '';

			foreach ($this->model->get_countries() as $value)
				$opt_countries .= '<option value="' . $value['code'] . '">' . $value['name'][$this->lang] . '</option>';

			$opt_times_zones = '';

			foreach ($this->model->get_times_zones() as $value)
				$opt_times_zones .= '<option value="' . $value['code'] . '">' . $value['code'] . '</option>';

			$opt_currencies = '';

			foreach ($this->model->get_currencies() as $value)
				$opt_currencies .= '<option value="' . $value['code'] . '">' . $value['name'][$this->lang] . ' (' . $value['code'] . ')</option>';

			$opt_languages = '';

			foreach ($this->model->get_languages() as $value)
				$opt_languages .= '<option value="' . $value['code'] . '">' . $value['name'] . '</option>';

			$opt_ladas = '';

			foreach ($this->model->get_countries() as $value)
				$opt_ladas .= '<option value="' . $value['lada'] . '">' . $value['name'][$this->lang] . ' (+' . $value['lada'] . ')</option>';

			$mdl_edit_myvox_menu_settings = '';

			if ($account['digital_menu'] == true)
			{
				$mdl_edit_myvox_menu_settings .=
				'<section class="modal fullscreen" data-modal="edit_myvox_menu_settings">
					<div class="content">
						<main>
							<form name="edit_myvox_menu_settings">
								<div class="row">
									<div class="span6">
										<div class="label">
											<label required>
												<p>(ES) {$lang.title} <a data-action="get_help" data-text=""><i class="fas fa-question-circle"></i></a></p>
												<input type="text" name="title_es" data-translates="menu_title">
											</label>
										</div>
									</div>
									<div class="span6">
										<div class="label">
											<label required>
												<p>(EN) {$lang.title} <a data-action="get_help" data-text=""><i class="fas fa-question-circle"></i></a></p>
												<input type="text" name="title_en" data-translaten="menu_title">
											</label>
										</div>
									</div>
									<div class="span3">
										<div class="label">
											<label required>
												<p>{$lang.email} <a data-action="get_help" data-text=""><i class="fas fa-question-circle"></i></a></p>
												<input type="email" name="email">
											</label>
										</div>
									</div>
									<div class="span3">
										<div class="label">
											<label required>
												<p>{$lang.lada} <a data-action="get_help" data-text=""><i class="fas fa-question-circle"></i></a></p>
												<select name="phone_lada">
													<option value="" hidden>{$lang.choose}</option>';

				foreach ($this->model->get_countries() as $value)
					$mdl_edit_myvox_menu_settings .= '<option value="' . $value['lada'] . '">' . $value['name'][$this->lang] . ' (+' . $value['lada'] . ')</option>';

				$mdl_edit_myvox_menu_settings .=
				'								</select>
											</label>
										</div>
									</div>
									<div class="span3">
										<div class="label">
											<label required>
												<p>{$lang.phone} <a data-action="get_help" data-text=""><i class="fas fa-question-circle"></i></a></p>
												<input type="text" name="phone_number">
											</label>
										</div>
									</div>
									<div class="span3">
										<div class="label">
											<label required>
												<p>{$lang.currency} <a data-action="get_help" data-text=""><i class="fas fa-question-circle"></i></a></p>
												<select name="currency">
													<option value="" hidden>{$lang.choose}</option>';

				foreach ($this->model->get_currencies() as $value)
					$mdl_edit_myvox_menu_settings .= '<option value="' . $value['code'] . '">' . $value['name'][$this->lang] . ' (' . $value['code'] . ')</option>';

				$mdl_edit_myvox_menu_settings .=
				'			</select>
						</label>
					</div>
				</div>
				<div class="span3">
					<div class="label">
						<label class="success">
							<p>{$lang.schedule} <a data-action="get_help" data-text=""><i class="fas fa-question-circle"></i></a></p>
							<input type="text" value="{$lang.monday}" disabled>
						</label>
					</div>
				</div>
				<div class="span3">
					<div class="label">
						<label required>
							<p></p>
							<select name="schedule_monday_status">
								<option value="open">{$lang.open}</option>
								<option value="close">{$lang.close}</option>
							</select>
						</label>
					</div>
				</div>
				<div class="span3">
					<div class="label">
						<label required>
							<p>{$lang.opening} <a data-action="get_help" data-text=""><i class="fas fa-question-circle"></i></a></p>
							<input type="time" name="schedule_monday_opening">
						</label>
					</div>
				</div>
				<div class="span3">
					<div class="label">
						<label required>
							<p>{$lang.closing} <a data-action="get_help" data-text=""><i class="fas fa-question-circle"></i></a></p>
							<input type="time" name="schedule_monday_closing">
						</label>
					</div>
				</div>
				<div class="span3">
					<div class="label">
						<label class="success">
							<input type="text" value="{$lang.tuesday}" disabled>
						</label>
					</div>
				</div>
				<div class="span3">
					<div class="label">
						<label required>
							<select name="schedule_tuesday_status">
								<option value="open">{$lang.open}</option>
								<option value="close">{$lang.close}</option>
							</select>
						</label>
					</div>
				</div>
				<div class="span3">
					<div class="label">
						<label required>
							<input type="time" name="schedule_tuesday_opening">
						</label>
					</div>
				</div>
				<div class="span3">
					<div class="label">
						<label required>
							<input type="time" name="schedule_tuesday_closing">
						</label>
					</div>
				</div>
				<div class="span3">
					<div class="label">
						<label class="success">
							<input type="text" value="{$lang.wednesday}" disabled>
						</label>
					</div>
				</div>
				<div class="span3">
					<div class="label">
						<label required>
							<select name="schedule_wednesday_status">
								<option value="open">{$lang.open}</option>
								<option value="close">{$lang.close}</option>
							</select>
						</label>
					</div>
				</div>
				<div class="span3">
					<div class="label">
						<label required>
							<input type="time" name="schedule_wednesday_opening">
						</label>
					</div>
				</div>
				<div class="span3">
					<div class="label">
						<label required>
							<input type="time" name="schedule_wednesday_closing">
						</label>
					</div>
				</div>
				<div class="span3">
					<div class="label">
						<label class="success">
							<input type="text" value="{$lang.thursday}" disabled>
						</label>
					</div>
				</div>
				<div class="span3">
					<div class="label">
						<label required>
							<select name="schedule_thursday_status">
								<option value="open">{$lang.open}</option>
								<option value="close">{$lang.close}</option>
							</select>
						</label>
					</div>
				</div>
				<div class="span3">
					<div class="label">
						<label required>
							<input type="time" name="schedule_thursday_opening">
						</label>
					</div>
				</div>
				<div class="span3">
					<div class="label">
						<label required>
							<input type="time" name="schedule_thursday_closing">
						</label>
					</div>
				</div>
				<div class="span3">
					<div class="label">
						<label class="success">
							<input type="text" value="{$lang.friday}" disabled>
						</label>
					</div>
				</div>
				<div class="span3">
					<div class="label">
						<label required>
							<select name="schedule_friday_status">
								<option value="open">{$lang.open}</option>
								<option value="close">{$lang.close}</option>
							</select>
						</label>
					</div>
				</div>
				<div class="span3">
					<div class="label">
						<label required>
							<input type="time" name="schedule_friday_opening">
						</label>
					</div>
				</div>
				<div class="span3">
					<div class="label">
						<label required>
							<input type="time" name="schedule_friday_closing">
						</label>
					</div>
				</div>
				<div class="span3">
					<div class="label">
						<label class="success">
							<input type="text" value="{$lang.saturday}" disabled>
						</label>
					</div>
				</div>
				<div class="span3">
					<div class="label">
						<label required>
							<select name="schedule_saturday_status">
								<option value="open">{$lang.open}</option>
								<option value="close">{$lang.close}</option>
							</select>
						</label>
					</div>
				</div>
				<div class="span3">
					<div class="label">
						<label required>
							<input type="time" name="schedule_saturday_opening">
						</label>
					</div>
				</div>
				<div class="span3">
					<div class="label">
						<label required>
							<input type="time" name="schedule_saturday_closing">
						</label>
					</div>
				</div>
				<div class="span3">
					<div class="label">
						<label class="success">
							<input type="text" value="{$lang.sunday}" disabled>
						</label>
					</div>
				</div>
				<div class="span3">
					<div class="label">
						<label required>
							<select name="schedule_sunday_status">
								<option value="open">{$lang.open}</option>
								<option value="close">{$lang.close}</option>
							</select>
						</label>
					</div>
				</div>
				<div class="span3">
					<div class="label">
						<label required>
							<input type="time" name="schedule_sunday_opening">
						</label>
					</div>
				</div>
				<div class="span3">
					<div class="label">
						<label required>
							<input type="time" name="schedule_sunday_closing">
						</label>
					</div>
				</div>';

				if ($account['type'] == 'hotel' OR $account['type'] == 'restaurant')
				{
					$mdl_edit_myvox_menu_settings .=
					'<div class="' . (($account['type'] == 'hotel') ? 'span12' : 'span6') . '">
						<div class="label">
							<label unrequired>
								<p>{$lang.receive_requests_' . $account['type'] . '} <a data-action="get_help" data-text=""><i class="fas fa-question-circle"></i></a></p>
								<div class="switch">
									<input id="rrsw" type="checkbox" name="requests" data-switcher>
									<label for="rrsw"></label>
								</div>
							</label>
						</div>
					</div>';
				}

				if ($account['type'] == 'restaurant' OR $account['type'] == 'others')
				{
					$mdl_edit_myvox_menu_settings .=
					'<div class="' . (($account['type'] == 'others') ? 'span12' : 'span6') . '">
						<div class="label">
							<label unrequired>
								<p>{$lang.receive_delivery_from_home} <a data-action="get_help" data-text=""><i class="fas fa-question-circle"></i></a></p>
								<div class="switch">
									<input id="rdsw" type="checkbox" name="delivery" data-switcher>
									<label for="rdsw"></label>
								</div>
							</label>
						</div>
					</div>
					<div class="span12">
						<div id="menu_map" data-lat="' . $account['location']['lat'] . '" data-lng="' . $account['location']['lng'] . '" data-rad="' . $account['settings']['myvox']['menu']['sell_radius'] . '"></div>
					</div>
					<div class="span12">
						<div class="label">
							<label required>
								<p>{$lang.sell_radius} <a data-action="get_help" data-text=""><i class="fas fa-question-circle"></i></a></p>
								<input id="menu_rad" type="number" name="sell_radius">
							</label>
						</div>
					</div>';
				}

				$mdl_edit_myvox_menu_settings .=
				'					<!-- <div class="span4">
										<div class="label">
											<label unrequired>
												<p>{$lang.multi} <a data-action="get_help" data-text=""><i class="fas fa-question-circle"></i></a></p>
												<div class="switch">
													<input id="mlsw" type="checkbox" name="multi" data-switcher>
													<label for="mlsw"></label>
												</div>
											</label>
										</div>
									</div> -->
									<div class="span12">
										<div class="buttons">
											<a class="delete" button-cancel><i class="fas fa-times"></i></a>
											<button type="submit" class="new"><i class="fas fa-check"></i></button>
										</div>
									</div>
								</div>
							</form>
						</main>
					</div>
				</section>';
			}

			$mdl_edit_myvox_request_settings = '';
			$mdl_edit_myvox_incident_settings = '';
			$mdl_edit_voxes_attention_times_settings = '';

			if ($account['operation'] == true)
			{
				$mdl_edit_myvox_request_settings .=
				'<section class="modal fullscreen" data-modal="edit_myvox_request_settings">
					<div class="content">
						<main>
							<form name="edit_myvox_request_settings">
								<div class="row">
									<div class="span6">
										<div class="label">
											<label required>
												<p>(ES) {$lang.title} <a data-action="get_help" data-text=""><i class="fas fa-question-circle"></i></a></p>
												<input type="text" name="title_es" data-translates="request_title">
											</label>
										</div>
									</div>
									<div class="span6">
										<div class="label">
											<label required>
												<p>(EN) {$lang.title} <a data-action="get_help" data-text=""><i class="fas fa-question-circle"></i></a></p>
												<input type="text" name="title_en" data-translaten="request_title">
											</label>
										</div>
									</div>
									<div class="span12">
										<div class="buttons">
											<a class="delete" button-cancel><i class="fas fa-times"></i></a>
											<button type="submit" class="new"><i class="fas fa-check"></i></button>
										</div>
									</div>
								</div>
							</form>
						</main>
					</div>
				</section>';

				$mdl_edit_myvox_incident_settings .=
				'<section class="modal fullscreen" data-modal="edit_myvox_incident_settings">
					<div class="content">
						<main>
							<form name="edit_myvox_incident_settings">
								<div class="row">
									<div class="span6">
										<div class="label">
											<label required>
												<p>(ES) {$lang.title} <a data-action="get_help" data-text=""><i class="fas fa-question-circle"></i></a></p>
												<input type="text" name="title_es" data-translates="incident_title">
											</label>
										</div>
									</div>
									<div class="span6">
										<div class="label">
											<label required>
												<p>(EN) {$lang.title} <a data-action="get_help" data-text=""><i class="fas fa-question-circle"></i></a></p>
												<input type="text" name="title_en" data-translaten="incident_title">
											</label>
										</div>
									</div>
									<div class="span12">
										<div class="buttons">
											<a class="delete" button-cancel><i class="fas fa-times"></i></a>
											<button type="submit" class="new"><i class="fas fa-check"></i></button>
										</div>
									</div>
								</div>
							</form>
						</main>
					</div>
				</section>';

				$mdl_edit_voxes_attention_times_settings .=
				'<section class="modal fullscreen" data-modal="edit_voxes_attention_times_settings">
					<div class="content">
						<main>
							<form name="edit_voxes_attention_times_settings">
								<div class="row">
									<div class="span4">
										<div class="label">
											<label required>
												<p>{$lang.request}</p>
												<p>{$lang.urgency_low} ({$lang.minutes})</p>
												<input type="number" name="request_low">
											</label>
										</div>
									</div>
									<div class="span4">
										<div class="label">
											<label required>
												<p>{$lang.request}</p>
												<p>{$lang.urgency_medium} ({$lang.minutes})</p>
												<input type="number" name="request_medium">
											</label>
										</div>
									</div>
									<div class="span4">
										<div class="label">
											<label required>
												<p>{$lang.request}</p>
												<p>{$lang.urgency_high} ({$lang.minutes})</p>
												<input type="number" name="request_high">
											</label>
										</div>
									</div>
									<div class="span4">
										<div class="label">
											<label required>
												<p>{$lang.incident}</p>
												<p>{$lang.urgency_low} ({$lang.minutes})</p>
												<input type="number" name="incident_low">
											</label>
										</div>
									</div>
									<div class="span4">
										<div class="label">
											<label required>
												<p>{$lang.incident}</p>
												<p>{$lang.urgency_medium} ({$lang.minutes})</p>
												<input type="number" name="incident_medium">
											</label>
										</div>
									</div>
									<div class="span4">
										<div class="label">
											<label required>
												<p>{$lang.incident}</p>
												<p>{$lang.urgency_high} ({$lang.minutes})</p>
												<input type="number" name="incident_high">
											</label>
										</div>
									</div>
									<div class="span12">
										<div class="buttons">
											<a class="delete" button-cancel><i class="fas fa-times"></i></a>
											<button type="submit" class="new"><i class="fas fa-check"></i></button>
										</div>
									</div>
								</div>
							</form>
						</main>
					</div>
				</section>';
			}

			$mdl_edit_myvox_survey_settings = '';
			$mdl_edit_reviews_settings = '';

			if ($account['surveys'] == true)
			{
				$mdl_edit_myvox_survey_settings .=
				'<section class="modal fullscreen" data-modal="edit_myvox_survey_settings">
					<div class="content">
						<main>
							<form name="edit_myvox_survey_settings">
								<div class="row">
									<div class="span6">
										<div class="label">
											<label required>
												<p>(ES) {$lang.title} <a data-action="get_help" data-text=""><i class="fas fa-question-circle"></i></a></p>
												<input type="text" name="title_es" data-translates="survey_title">
											</label>
										</div>
									</div>
									<div class="span6">
										<div class="label">
											<label required>
												<p>(EN) {$lang.title} <a data-action="get_help" data-text=""><i class="fas fa-question-circle"></i></a></p>
												<input type="text" name="title_en" data-translaten="survey_title">
											</label>
										</div>
									</div>
									<div class="span6">
										<div class="label">
											<label required>
												<p>(ES) {$lang.subject} <a data-action="get_help" data-text=""><i class="fas fa-question-circle"></i></a></p>
												<input type="text" name="mail_subject_es" data-translates="survey_subject">
											</label>
										</div>
									</div>
									<div class="span6">
										<div class="label">
											<label required>
												<p>(EN) {$lang.subject} <a data-action="get_help" data-text=""><i class="fas fa-question-circle"></i></a></p>
												<input type="text" name="mail_subject_en" data-translaten="survey_subject">
											</label>
										</div>
									</div>
									<div class="span6">
										<div class="label">
											<label required>
												<p>(ES) {$lang.description} <a data-action="get_help" data-text=""><i class="fas fa-question-circle"></i></a></p>
												<textarea name="mail_description_es" data-translates="survey_description"></textarea>
											</label>
										</div>
									</div>
									<div class="span6">
										<div class="label">
											<label required>
												<p>(EN) {$lang.description} <a data-action="get_help" data-text=""><i class="fas fa-question-circle"></i></a></p>
												<textarea name="mail_description_en" data-translaten="survey_description"></textarea>
											</label>
										</div>
									</div>
									<div class="span12">
										<div class="stl_2" data-uploader="low">
											<p>{$lang.image} <a data-action="get_help" data-text=""><i class="fas fa-question-circle"></i></a></p>
											<figure data-preview>
												<img src="{$path.images}empty.png">
												<a data-select><i class="fas fa-upload"></i></a>
												<input type="file" name="mail_image" accept="image/*" data-upload>
											</figure>
										</div>
									</div>
									<div class="span12">
										<div class="stl_2" data-uploader="low">
											<p>{$lang.attachment} <a data-action="get_help" data-text=""><i class="fas fa-question-circle"></i></a></p>
											<figure data-preview>
												<img src="{$path.images}empty.png">
												<a data-select><i class="fas fa-upload"></i></a>
												<input type="file" name="mail_attachment" accept="image/*, application/pdf, application/vnd.ms-word, application/vnd.openxmlformats-officedocument.wordprocessingml.document, application/vnd.ms-excel, application/vnd.openxmlformats-officedocument.spreadsheetml.sheet" data-upload>
											</figure>
										</div>
									</div>
									<!-- <div class="span12">
										<div class="label">
											<label unrequired>
												<p>{$lang.widget} <a data-action="get_help" data-text=""><i class="fas fa-question-circle"></i></a></p>
												<textarea name="widget"></textarea>
											</label>
										</div>
									</div> -->
									<div class="span12">
										<div class="buttons">
											<a class="delete" button-cancel><i class="fas fa-times"></i></a>
											<button type="submit" class="new"><i class="fas fa-check"></i></button>
										</div>
									</div>
								</div>
							</form>
						</main>
					</div>
				</section>';

				$mdl_edit_reviews_settings .=
				'<section class="modal fullscreen" data-modal="edit_reviews_settings">
				    <div class="content">
				        <main>
				            <form name="edit_reviews_settings">
				                <div class="row">
									<div class="span6">
										<div class="label">
											<label required>
												<p>{$lang.email}</p>
												<input type="email" name="email">
											</label>
										</div>
									</div>
									<div class="span3">
										<div class="label">
											<label required>
												<p>{$lang.lada}</p>
												<select name="phone_lada">
													<option value="" hidden>{$lang.choose}</option>';

				foreach ($this->model->get_countries() as $value)
					$mdl_edit_reviews_settings .= '<option value="' . $value['lada'] . '">' . $value['name'][$this->lang] . ' (+' . $value['lada'] . ')</option>';

				$mdl_edit_reviews_settings .=
				'								</select>
											</label>
										</div>
									</div>
									<div class="span3">
										<div class="label">
											<label required>
												<p>{$lang.phone}</p>
												<input type="text" name="phone_number">
											</label>
										</div>
									</div>
									<div class="span12">
										<div class="label">
											<label required>
												<p>{$lang.website}</p>
												<input type="text" name="website">
											</label>
										</div>
									</div>
									<div class="span6">
										<div class="label">
											<label required>
												<p>(ES) {$lang.description} <a data-action="get_help" data-text=""><i class="fas fa-question-circle"></i></a></p>
												<textarea name="description_es" data-translates="reviews_description"></textarea>
											</label>
										</div>
									</div>
									<div class="span6">
										<div class="label">
											<label required>
												<p>(EN) {$lang.description} <a data-action="get_help" data-text=""><i class="fas fa-question-circle"></i></a></p>
												<textarea name="description_en" data-translaten="reviews_description"></textarea>
											</label>
										</div>
									</div>
									<div class="span6">
										<div class="label">
											<label required>
												<p>(ES) {$lang.seo_keywords} <a data-action="get_help" data-text=""><i class="fas fa-question-circle"></i></a></p>
												<input type="text" name="seo_keywords_es" data-translates="reviews_seo_keywords">
											</label>
										</div>
									</div>
									<div class="span6">
										<div class="label">
											<label required>
												<p>(EN) {$lang.seo_keywords} <a data-action="get_help" data-text=""><i class="fas fa-question-circle"></i></a></p>
												<input type="text" name="seo_keywords_en" data-translaten="reviews_seo_keywords">
											</label>
										</div>
									</div>
									<div class="span6">
										<div class="label">
											<label required>
												<p>(ES) {$lang.seo_description} <a data-action="get_help" data-text=""><i class="fas fa-question-circle"></i></a></p>
												<textarea name="seo_description_es" data-translates="reviews_seo_description"></textarea>
											</label>
										</div>
									</div>
									<div class="span6">
										<div class="label">
											<label required>
												<p>(EN) {$lang.seo_description} <a data-action="get_help" data-text=""><i class="fas fa-question-circle"></i></a></p>
												<textarea name="seo_description_en" data-translaten="reviews_seo_description"></textarea>
											</label>
										</div>
									</div>
									<div class="span12">
										<div class="label">
											<label unrequired>
												<p>Facebook</p>
												<input type="text" name="social_media_facebook">
											</label>
										</div>
									</div>
									<div class="span12">
										<div class="label">
											<label unrequired>
												<p>Instagram</p>
												<input type="text" name="social_media_instagram">
											</label>
										</div>
									</div>
									<div class="span12">
										<div class="label">
											<label unrequired>
												<p>Twitter</p>
												<input type="text" name="social_media_twitter">
											</label>
										</div>
									</div>
									<div class="span12">
										<div class="label">
											<label unrequired>
												<p>LinkedIn</p>
												<input type="text" name="social_media_linkedin">
											</label>
										</div>
									</div>
									<div class="span12">
										<div class="label">
											<label unrequired>
												<p>YouTube</p>
												<input type="text" name="social_media_youtube">
											</label>
										</div>
									</div>
									<div class="span12">
										<div class="label">
											<label unrequired>
												<p>Google</p>
												<input type="text" name="social_media_google">
											</label>
										</div>
									</div>
									<div class="span12">
										<div class="label">
											<label unrequired>
												<p>TripAdvisor</p>
												<input type="text" name="social_media_tripadvisor">
											</label>
										</div>
									</div>
									<div class="span12">
										<div class="buttons">
											<a class="delete" button-cancel><i class="fas fa-times"></i></a>
											<button type="submit" class="new"><i class="fas fa-check"></i></button>
										</div>
									</div>
				                </div>
				            </form>
				        </main>
				    </div>
				</section>';
			}

			$mdl_edit_payment =
			'<section class="modal fullscreen" data-modal="edit_payment">
				<div class="content">
					<main>
						<form name="edit_payment">
							<div class="row">';

			if ($account['payment']['contract']['status'] == 'activated')
			{
				if ($account['payment']['type'] == 'mit')
				{
					$mdl_edit_payment .=
					'<div class="span6">
						<div class="label">
							<label unrequired>
								<p>Código de transacción</p>
								<input type="text" value="' . $account['payment']['mit']['code'] . '" disabled>
							</label>
						</div>
					</div>
					<div class="span6">
						<div class="label">
							<label unrequired>
								<p>Tipos de transacción</p>
								<input type="text" value="' . $account['payment']['mit']['types'] . '" disabled>
							</label>
						</div>
					</div>';
				}
			}
			else if ($account['payment']['contract']['status'] == 'pending')
			{
				$mdl_edit_payment .=
				'<div class="span12">
					<div class="message">
						<p>{$lang.contract_pending}</p>
					</div>
				</div>';
			}
			else if ($account['payment']['contract']['status'] == 'deactivated')
			{
				$mdl_edit_payment .=
				'<h6><strong>{$lang.transaction_processing_contract}</strong></h6>
				<h6>{$lang.titular_data}</h6>
				<div class="span4">
					<div class="label">
						<label required>
							<p>{$lang.fiscal_name}</p>
							<input type="text" name="contract_titular_fiscal_name">
						</label>
					</div>
				</div>
				<div class="span4">
					<div class="label">
						<label required>
							<p>{$lang.rfc}</p>
							<input type="text" name="contract_titular_fiscal_id">
						</label>
					</div>
				</div>
				<div class="span4">
					<div class="label">
						<label required>
							<p>{$lang.person}</p>
							<select name="contract_titular_fiscal_person">
								<option value="" hidden>{$lang.choose}</option>
								<option value="physical">{$lang.physical_person}</option>
								<option value="moral">{$lang.moral_person}</option>
							</select>
						</label>
					</div>
				</div>
				<div class="span12">
					<div class="label">
						<label required>
							<p>{$lang.activity} <a data-action="get_help" data-text=""><i class="fas fa-question-circle"></i></a></p>
							<input type="text" name="contract_titular_fiscal_activity">
						</label>
					</div>
				</div>
				<div class="span4">
					<div class="label">
						<label required>
							<p>{$lang.street}</p>
							<input type="text" name="contract_titular_address_street">
						</label>
					</div>
				</div>
				<div class="span4">
					<div class="label">
						<label required>
							<p>{$lang.external_number}</p>
							<input type="text" name="contract_titular_address_external_number">
						</label>
					</div>
				</div>
				<div class="span4">
					<div class="label">
						<label unrequired>
							<p>{$lang.internal_number}</p>
							<input type="text" name="contract_titular_address_internal_number">
						</label>
					</div>
				</div>
				<div class="span4">
					<div class="label">
						<label required>
							<p>{$lang.cp}</p>
							<input type="text" name="contract_titular_address_cp">
						</label>
					</div>
				</div>
				<div class="span4">
					<div class="label">
						<label required>
							<p>{$lang.colony}</p>
							<input type="text" name="contract_titular_address_colony">
						</label>
					</div>
				</div>
				<div class="span4">
					<div class="label">
						<label required>
							<p>{$lang.delegation}</p>
							<input type="text" name="contract_titular_address_delegation">
						</label>
					</div>
				</div>
				<div class="span4">
					<div class="label">
						<label required>
							<p>{$lang.city}</p>
							<input type="text" name="contract_titular_address_city">
						</label>
					</div>
				</div>
				<div class="span4">
					<div class="label">
						<label required>
							<p>{$lang.state}</p>
							<input type="text" name="contract_titular_address_state">
						</label>
					</div>
				</div>
				<div class="span4">
					<div class="label">
						<label required>
							<p>{$lang.country}</p>
							<input type="text" name="contract_titular_address_country">
						</label>
					</div>
				</div>
				<div class="span3">
					<div class="label">
						<label required>
							<p>{$lang.bank}</p>
							<input type="text" name="contract_titular_bank_name">
						</label>
					</div>
				</div>
				<div class="span3">
					<div class="label">
						<label required>
							<p>{$lang.branch}</p>
							<input type="text" name="contract_titular_bank_branch">
						</label>
					</div>
				</div>
				<div class="span3">
					<div class="label">
						<label required>
							<p>{$lang.checkbook}</p>
							<input type="text" name="contract_titular_bank_checkbook">
						</label>
					</div>
				</div>
				<div class="span3">
					<div class="label">
						<label required>
							<p>{$lang.clabe}</p>
							<input type="text" name="contract_titular_bank_clabe">
						</label>
					</div>
				</div>
				<h6>{$lang.company_data}</h6>
				<div class="span6">
					<div class="label">
						<label unrequired>
							<p>{$lang.writing_number}</p>
							<input type="text" name="contract_company_writing_number">
						</label>
					</div>
				</div>
				<div class="span6">
					<div class="label">
						<label unrequired>
							<p>{$lang.writing_date}</p>
							<input type="date" name="contract_company_writing_date">
						</label>
					</div>
				</div>
				<div class="span6">
					<div class="label">
						<label unrequired>
							<p>{$lang.public_record_folio}</p>
							<input type="text" name="contract_company_public_record_folio">
						</label>
					</div>
				</div>
				<div class="span6">
					<div class="label">
						<label unrequired>
							<p>{$lang.public_record_date}</p>
							<input type="date" name="contract_company_public_record_date">
						</label>
					</div>
				</div>
				<div class="span4">
					<div class="label">
						<label unrequired>
							<p>{$lang.notary}</p>
							<input type="text" name="contract_company_notary_name">
						</label>
					</div>
				</div>
				<div class="span4">
					<div class="label">
						<label unrequired>
							<p>{$lang.number}</p>
							<input type="text" name="contract_company_notary_number">
						</label>
					</div>
				</div>
				<div class="span4">
					<div class="label">
						<label unrequired>
							<p>{$lang.city}</p>
							<input type="text" name="contract_company_city">
						</label>
					</div>
				</div>
				<h6>{$lang.legal_representative_data}</h6>
				<div class="span12">
					<div class="label">
						<label unrequired>
							<p>{$lang.name}</p>
							<input type="text" name="contract_company_legal_representative_name">
						</label>
					</div>
				</div>
				<div class="span6">
					<div class="label">
						<label unrequired>
							<p>{$lang.writing_number}</p>
							<input type="text" name="contract_company_legal_representative_writing_number">
						</label>
					</div>
				</div>
				<div class="span6">
					<div class="label">
						<label unrequired>
							<p>{$lang.writing_date}</p>
							<input type="date" name="contract_company_legal_representative_writing_date">
						</label>
					</div>
				</div>
				<div class="span4">
					<div class="label">
						<label unrequired>
							<p>{$lang.notary}</p>
							<input type="text" name="contract_company_legal_representative_notary_name">
						</label>
					</div>
				</div>
				<div class="span4">
					<div class="label">
						<label unrequired>
							<p>{$lang.number}</p>
							<input type="text" name="contract_company_legal_representative_notary_number">
						</label>
					</div>
				</div>
				<div class="span4">
					<div class="label">
						<label unrequired>
							<p>{$lang.city}</p>
							<input type="text" name="contract_company_legal_representative_city">
						</label>
					</div>
				</div>
				<div class="span3">
					<div class="label">
						<label unrequired>
							<p>{$lang.card}</p>
							<select name="contract_company_legal_representative_card_type">
								<option value="" hidden>{$lang.choose}</option>
								<option value="ine">{$lang.ine}</option>
							</select>
						</label>
					</div>
				</div>
				<div class="span3">
					<div class="label">
						<label unrequired>
							<p>{$lang.number}</p>
							<input type="text" name="contract_company_legal_representative_card_number">
						</label>
					</div>
				</div>
				<div class="span3">
					<div class="label">
						<label unrequired>
							<p>{$lang.expedition_date}</p>
							<input type="date" name="contract_company_legal_representative_card_expedition_date">
						</label>
					</div>
				</div>
				<div class="span3">
					<div class="label">
						<label unrequired>
							<p>{$lang.validity}</p>
							<input type="date" name="contract_company_legal_representative_card_validity">
						</label>
					</div>
				</div>
				<h6>{$lang.contract}</h6>
				<div class="span12">
					<div class="contract">
						<iframe width="100%" height="600px" src="https://docs.google.com/viewer?url=https://' . Configuration::$domain . '/files/spug.pdf&embedded=true"></iframe>
					</div>
				</div>
				<div class="span6">
					<div class="label">
						<label required>
							<p>{$lang.signature_place}</p>
							<input type="text" name="contract_place">
						</label>
					</div>
				</div>
				<div class="span6">
					<div class="label">
						<label unrequired>
							<p>{$lang.signature_date}</p>
							<input type="date" value="' . Functions::get_current_date() . '" disabled>
						</label>
					</div>
				</div>
				<div class="span12">
					<div class="label">
						<label required>
							<p>{$lang.signature}</p>
							<div class="signature" id="contract_signature">
								<canvas></canvas>
								<div>
									<a data-action="clean_contract_signature"><i class="fas fa-trash"></i></a>
								</div>
							</div>
						</label>
					</div>
				</div>';
			}

			$mdl_edit_payment .=
			'					<div class="span12">
									<div class="buttons">
										<a class="delete" button-cancel><i class="fas fa-times"></i></a>
										<button type="submit" class="new"><i class="fas fa-check"></i></button>
									</div>
								</div>
							</div>
						</form>
					</main>
				</div>
			</section>';

			$replace = [
				'{$logotype}' => '{$path.uploads}' . $account['logotype'],
				'{$name}' => $account['name'],
				'{$token}' => strtoupper($account['token']),
				'{$fiscal_name}' => !empty($account['fiscal']['name']) ? $account['fiscal']['name'] : '{$lang.not_fiscal_name}',
				'{$fiscal_id}' => !empty($account['fiscal']['id']) ? $account['fiscal']['id'] : '{$lang.not_fiscal_id}',
				'{$location}' => (!empty($account['location']['lat']) AND !empty($account['location']['lng'])) ? '{$lang.activated}' : '{$lang.deactivated}',
				'{$lat_lng}' => (!empty($account['location']['lat']) AND !empty($account['location']['lng'])) ? $account['location']['lat'] . ' ' . $account['location']['lng'] : '{$lang.not_location}',
				'{$lat}' => !empty($account['location']['lat']) ? $account['location']['lat'] : '',
				'{$lng}' => !empty($account['location']['lng']) ? $account['location']['lng'] : '',
				'{$div_menu}' => $div_menu,
				'{$div_public_requests}' => $div_public_requests,
				'{$div_public_incidents}' => $div_public_incidents,
				'{$div_attention_times}' => $div_attention_times,
				'{$div_siteminder}' => $div_siteminder,
				'{$div_zaviapms}' => $div_zaviapms,
				'{$div_ambit}' => $div_ambit,
				'{$div_answer_surveys}' => $div_answer_surveys,
				'{$div_reviews_page}' => $div_reviews_page,
				'{$div_payment}' => $div_payment,
				'{$sms}' => $account['sms'],
				'{$whatsapp}' => $account['whatsapp'],
				'{$opt_countries}' => $opt_countries,
				'{$opt_times_zones}' => $opt_times_zones,
				'{$opt_currencies}' => $opt_currencies,
				'{$opt_languages}' => $opt_languages,
				'{$opt_ladas}' => $opt_ladas,
				'{$mdl_edit_myvox_menu_settings}' => $mdl_edit_myvox_menu_settings,
				'{$mdl_edit_myvox_request_settings}' => $mdl_edit_myvox_request_settings,
				'{$mdl_edit_myvox_incident_settings}' => $mdl_edit_myvox_incident_settings,
				'{$mdl_edit_voxes_attention_times_settings}' => $mdl_edit_voxes_attention_times_settings,
				'{$mdl_edit_myvox_survey_settings}' => $mdl_edit_myvox_survey_settings,
				'{$mdl_edit_reviews_settings}' => $mdl_edit_reviews_settings,
				'{$mdl_edit_payment}' => $mdl_edit_payment
			];

			$template = $this->format->replace($replace, $template);

			echo $template;
		}
	}
}
