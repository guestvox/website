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
			if ($_POST['action'] == 'get_support')
			{
				$labels = [];

				if (!isset($_POST['message']) OR empty($_POST['message']))
					array_push($labels, ['message','']);

				if (empty($labels))
				{
					$mail2->setFrom('noreply@guestvox.com', 'Guestvox');
					$mail2->addAddress('contacto@guestvox.com', 'Guestvox');
					$mail2->Subject = 'Soporte técnico | Nueva reporte';
					$mail2->Body =
					'Cuenta: ' . Session::get_value('account')['name'] . ' (#' . Session::get_value('account')['token'] . ')<br>
					Usuario: ' . Session::get_value('user')['firstname'] . ' ' . Session::get_value('user')['lastname'] . ' (@' . Session::get_value('user')['username'] . ')<br>
					Mensaje: ' . $_POST['message'];
					$mail2->send();

					Functions::environment([
						'status' => 'success',
						'message' => '{$lang.thanks_support}'
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

			if ($_POST['action'] == 'get_account')
			{
				Functions::environment([
					'status' => 'success',
					'data' => $account
				]);
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

			if ($_POST['action'] == 'edit_myvox_requests_settings' OR $_POST['action'] == 'edit_myvox_incidents_settings' OR $_POST['action'] == 'edit_myvox_menu_settings' OR $_POST['action'] == 'edit_myvox_surveys_settings' OR $_POST['action'] == 'edit_reviews_settings' OR $_POST['action'] == 'edit_voxes_attention_times_settings')
			{
				$labels = [];

				if ($_POST['action'] == 'edit_myvox_requests_settings')
				{
					if (!empty($_POST['status']))
					{
						if (!isset($_POST['title_es']) OR empty($_POST['title_es']))
							array_push($labels, ['title_es','']);

						if (!isset($_POST['title_en']) OR empty($_POST['title_en']))
							array_push($labels, ['title_en','']);
					}
				}
				else if ($_POST['action'] == 'edit_myvox_incidents_settings')
				{
					if (!empty($_POST['status']))
					{
						if (!isset($_POST['title_es']) OR empty($_POST['title_es']))
							array_push($labels, ['title_es','']);

						if (!isset($_POST['title_en']) OR empty($_POST['title_en']))
							array_push($labels, ['title_en','']);
					}
				}
				else if ($_POST['action'] == 'edit_myvox_menu_settings')
				{
					if (!empty($_POST['status']))
					{
						if (!isset($_POST['title_es']) OR empty($_POST['title_es']))
							array_push($labels, ['title_es','']);

						if (!isset($_POST['title_en']) OR empty($_POST['title_en']))
							array_push($labels, ['title_en','']);

						if (!isset($_POST['currency']) OR empty($_POST['currency']))
							array_push($labels, ['currency','']);

						if (!isset($_POST['opportunity_area']) OR empty($_POST['opportunity_area']))
							array_push($labels, ['opportunity_area','']);

						if (!isset($_POST['opportunity_type']) OR empty($_POST['opportunity_type']))
							array_push($labels, ['opportunity_type','']);
					}
				}
				else if ($_POST['action'] == 'edit_myvox_surveys_settings')
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

				if (empty($labels))
				{
					if ($_POST['action'] == 'edit_myvox_requests_settings')
						$query = $this->model->edit_settings('myvox_requests', $_POST);
					else if ($_POST['action'] == 'edit_myvox_incidents_settings')
						$query = $this->model->edit_settings('myvox_incidents', $_POST);
					else if ($_POST['action'] == 'edit_myvox_menu_settings')
						$query = $this->model->edit_settings('myvox_menu', $_POST);
					else if ($_POST['action'] == 'edit_myvox_surveys_settings')
					{
						if (!empty($_POST['status']))
						{
							$_POST['mail_image'] = $_FILES['mail_image'];
							$_POST['mail_attachment'] = $_FILES['mail_attachment'];
						}

						$query = $this->model->edit_settings('myvox_surveys', $_POST);
					}
					else if ($_POST['action'] == 'edit_reviews_settings')
						$query = $this->model->edit_settings('reviews', $_POST);
					else if ($_POST['action'] == 'edit_voxes_attention_times_settings')
						$query = $this->model->edit_settings('voxes_attention_times', $_POST);

					if (!empty($query))
					{
						if ($_POST['action'] == 'edit_myvox_menu_settings')
						{
							$account = Session::get_value('account');

							$account['settings']['menu']['currency'] = $_POST['currency'];
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
		}
		else
		{
			$template = $this->view->render($this, 'index');

			define('_title', 'Guestvox | {$lang.account}');

			$div_public_requests = '';
			$div_public_incidents = '';
			$div_menu = '';

			if ($account['operation'] == true)
			{
				$div_public_requests .=
				'<div class="stl_5">
	                <i class="fas fa-rocket"></i>
	                <h2>{$lang.public_requests}</h2>
	                <span>' . (($account['settings']['myvox']['requests']['status'] == true) ? '{$lang.activated}' : '{$lang.deactivated}') . '</span>
					<div class="switch">
					    <input id="rqsw" type="checkbox" ' . (($account['settings']['myvox']['requests']['status'] == true) ? 'checked' : '') . ' data-switcher>
						<label for="rqsw"></label>
					</div>
	            </div>';

				$div_public_incidents .=
				'<div class="stl_5">
	                <i class="fas fa-meteor"></i>
	                <h2>{$lang.public_incidents}</h2>
	                <span>' . (($account['settings']['myvox']['incidents']['status'] == true) ? '{$lang.activated}' : '{$lang.deactivated}') . '</span>
					<div class="switch">
					    <input id="insw" type="checkbox" ' . (($account['settings']['myvox']['incidents']['status'] == true) ? 'checked' : '') . ' data-switcher>
					    <label for="insw"></label>
					</div>
	            </div>';

				if ($account['type'] == 'hotel' OR $account['type'] == 'restaurant')
				{
					$div_menu .=
					'<div class="stl_5">
		                <i class="fas fa-fire-alt"></i>
		                <h2>{$lang.menu}</h2>
		                <span>' . (($account['settings']['myvox']['menu']['status'] == true) ? '{$lang.activated}' : '{$lang.deactivated}') . '</span>
						<div class="switch">
						    <input id="mnsw" type="checkbox" ' . (($account['settings']['myvox']['menu']['status'] == true) ? 'checked' : '') . ' data-switcher>
						    <label for="mnsw"></label>
						</div>
		            </div>';
				}
			}

			$div_answered_surveys = '';
			$div_reviews_page = '';

			if ($account['reputation'] == true)
			{
				$div_answered_surveys .=
				'<div class="stl_5">
	                <i class="fas fa-ghost"></i>
	                <h2>{$lang.answer_surveys}</h2>
	                <span>' . (($account['settings']['myvox']['surveys']['status'] == true) ? '{$lang.activated}' : '{$lang.deactivated}') . '</span>
					<div class="switch">
					    <input id="susw" type="checkbox" ' . (($account['settings']['myvox']['surveys']['status'] == true) ? 'checked' : '') . ' data-switcher>
					    <label for="susw"></label>
					</div>
	            </div>';

				$div_reviews_page .=
				'<div class="stl_5">
	                <i class="fas fa-star"></i>
	                <h2>{$lang.reviews_page}</h2>
	                <span>' . (($account['settings']['reviews']['status'] == true) ? '{$lang.activated}' : '{$lang.deactivated}') . '</span>
					<div class="switch">
					    <input id="rvsw" type="checkbox" ' . (($account['settings']['reviews']['status'] == true) ? 'checked' : '') . ' data-switcher>
					    <label for="rvsw"></label>
					</div>
	            </div>';
			}

			$div_attention_times = '';

			if ($account['operation'] == true)
			{
				$div_attention_times .=
				'<div class="stl_5">
	                <i class="fas fa-clock"></i>
	                <h2>{$lang.attention_times}</h2>
	                <span>{$lang.activated}</span>
					<a class="edit" data-action="edit_voxes_attention_times_settings"><i class="fas fa-pen"></i></a>
	            </div>';
			}

			$div_siteminder = '';
			$div_zaviapms = '';

			if ($account['operation'] == true)
			{
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
			}

			$btn_get_urls = '';
			$mdl_get_urls = '';

			if ($account['operation'] == true OR $account['reputation'] == true)
			{
				$btn_get_urls .= '<a data-button-modal="get_urls"><i class="fas fa-link"></i></a>';

				$mdl_get_urls .=
				'<section class="modal fullscreen" data-modal="get_urls">
				    <div class="content">
				        <main class="account">
				        	<div class="stl_6">
								<div>
									<p>https://' . Configuration::$domain . '/' . $account['path'] . '/myvox</p>
									<a data-action="copy_to_clipboard"><i class="fas fa-copy"></i></a>
								</div>';

				if ($account['reputation'] == true)
				{
					$mdl_get_urls .=
					'<div>
						<p>https://' . Configuration::$domain . '/' . $account['path'] . '/reviews</p>
						<a data-action="copy_to_clipboard"><i class="fas fa-copy"></i></a>
					</div>';
				}

				$mdl_get_urls .=
				'           </div>
				            <div class="buttons">
				                <a button-close><i class="fas fa-times"></i></a>
				            </div>
				        </main>
				    </div>
				</section>';
			}

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

			$mdl_edit_myvox_requests_settings = '';
			$mdl_edit_myvox_incidents_settings = '';
			$mdl_edit_myvox_menu_settings = '';

			if ($account['operation'] == true)
			{
				$mdl_edit_myvox_requests_settings .=
				'<section class="modal fullscreen" data-modal="edit_myvox_requests_settings">
					<div class="content">
						<main>
							<form name="edit_myvox_requests_settings">
								<div class="row">
									<div class="span6">
										<div class="label">
											<label required>
												<p>(ES) {$lang.title} <a data-action="get_help" data-text=""><i class="fas fa-question-circle"></i></a></p>
												<input type="text" name="title_es">
											</label>
										</div>
									</div>
									<div class="span6">
										<div class="label">
											<label required>
												<p>(EN) {$lang.title} <a data-action="get_help" data-text=""><i class="fas fa-question-circle"></i></a></p>
												<input type="text" name="title_en">
											</label>
										</div>
									</div>
									<div class="span12">
										<div class="buttons">
											<a button-cancel><i class="fas fa-times"></i></a>
											<button type="submit"><i class="fas fa-check"></i></button>
										</div>
									</div>
								</div>
							</form>
						</main>
					</div>
				</section>';

				$mdl_edit_myvox_incidents_settings .=
				'<section class="modal fullscreen" data-modal="edit_myvox_incidents_settings">
					<div class="content">
						<main>
							<form name="edit_myvox_incidents_settings">
								<div class="row">
									<div class="span6">
										<div class="label">
											<label required>
												<p>(ES) {$lang.title} <a data-action="get_help" data-text=""><i class="fas fa-question-circle"></i></a></p>
												<input type="text" name="title_es">
											</label>
										</div>
									</div>
									<div class="span6">
										<div class="label">
											<label required>
												<p>(EN) {$lang.title} <a data-action="get_help" data-text=""><i class="fas fa-question-circle"></i></a></p>
												<input type="text" name="title_en">
											</label>
										</div>
									</div>
									<div class="span12">
										<div class="buttons">
											<a button-cancel><i class="fas fa-times"></i></a>
											<button type="submit"><i class="fas fa-check"></i></button>
										</div>
									</div>
								</div>
							</form>
						</main>
					</div>
				</section>';

				if ($account['type'] == 'hotel' OR $account['type'] == 'restaurant')
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
													<input type="text" name="title_es">
												</label>
											</div>
										</div>
										<div class="span6">
											<div class="label">
												<label required>
													<p>(EN) {$lang.title} <a data-action="get_help" data-text=""><i class="fas fa-question-circle"></i></a></p>
													<input type="text" name="title_en">
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
					'								</select>
												</label>
											</div>
										</div>
										<div class="span3">
											<div class="label">
												<label required>
													<p>{$lang.opportunity_area} <a data-action="get_help" data-text=""><i class="fas fa-question-circle"></i></a></p>
													<select name="opportunity_area">
														<option value="" hidden>{$lang.choose}</option>';

					foreach ($this->model->get_opportunity_areas('request') as $value)
						$mdl_edit_myvox_menu_settings .= '<option value="' . $value['id'] . '">' . $value['name'][$this->lang] . '</option>';

					$mdl_edit_myvox_menu_settings .=
					'								</select>
												</label>
											</div>
										</div>
										<div class="span3">
											<div class="label">
												<label required>
													<p>{$lang.opportunity_type} <a data-action="get_help" data-text=""><i class="fas fa-question-circle"></i></a></p>
													<select name="opportunity_type" disabled>
														<option value="" hidden>{$lang.choose}</option>
													</select>
												</label>
											</div>
										</div>
										<div class="span3">
											<div class="label">
												<label unrequired>
													<p>{$lang.multi} <a data-action="get_help" data-text=""><i class="fas fa-question-circle"></i></a></p>
													<div class="switch">
													    <input id="mlsw" type="checkbox" name="multi" data-switcher>
													    <label for="mlsw"></label>
													</div>
												</label>
											</div>
										</div>
										<div class="span12">
											<div class="buttons">
												<a button-cancel><i class="fas fa-times"></i></a>
												<button type="submit"><i class="fas fa-check"></i></button>
											</div>
										</div>
									</div>
								</form>
							</main>
						</div>
					</section>';
				}
			}

			$mdl_edit_myvox_surveys_settings = '';
			$mdl_edit_reviews_settings = '';

			if ($account['reputation'] == true)
			{
				$mdl_edit_myvox_surveys_settings .=
				'<section class="modal fullscreen" data-modal="edit_myvox_surveys_settings">
					<div class="content">
						<main>
							<form name="edit_myvox_surveys_settings">
								<div class="row">
									<div class="span6">
										<div class="label">
											<label required>
												<p>(ES) {$lang.title} <a data-action="get_help" data-text=""><i class="fas fa-question-circle"></i></a></p>
												<input type="text" name="title_es">
											</label>
										</div>
									</div>
									<div class="span6">
										<div class="label">
											<label required>
												<p>(EN) {$lang.title} <a data-action="get_help" data-text=""><i class="fas fa-question-circle"></i></a></p>
												<input type="text" name="title_en">
											</label>
										</div>
									</div>
									<div class="span6">
										<div class="label">
											<label required>
												<p>(ES) {$lang.mail_subject} <a data-action="get_help" data-text=""><i class="fas fa-question-circle"></i></a></p>
												<input type="text" name="mail_subject_es">
											</label>
										</div>
									</div>
									<div class="span6">
										<div class="label">
											<label required>
												<p>(EN) {$lang.mail_subject} <a data-action="get_help" data-text=""><i class="fas fa-question-circle"></i></a></p>
												<input type="text" name="mail_subject_en">
											</label>
										</div>
									</div>
									<div class="span6">
										<div class="label">
											<label required>
												<p>(ES) {$lang.mail_description} <a data-action="get_help" data-text=""><i class="fas fa-question-circle"></i></a></p>
												<textarea name="mail_description_es"></textarea>
											</label>
										</div>
									</div>
									<div class="span6">
										<div class="label">
											<label required>
												<p>(EN) {$lang.mail_description} <a data-action="get_help" data-text=""><i class="fas fa-question-circle"></i></a></p>
												<textarea name="mail_description_en"></textarea>
											</label>
										</div>
									</div>
									<div class="span12">
										<div class="stl_2" data-uploader="low">
											<p>{$lang.mail_image} <a data-action="get_help" data-text=""><i class="fas fa-question-circle"></i></a></p>
											<figure data-preview>
												<img src="{$path.images}empty.png">
												<a data-select><i class="fas fa-upload"></i></a>
												<input type="file" name="mail_image" accept="image/*" data-upload>
											</figure>
										</div>
									</div>
									<div class="span12">
										<div class="stl_2" data-uploader="low">
											<p>{$lang.mail_attachment} <a data-action="get_help" data-text=""><i class="fas fa-question-circle"></i></a></p>
											<figure data-preview>
												<img src="{$path.images}empty.png">
												<a data-select><i class="fas fa-upload"></i></a>
												<input type="file" name="mail_attachment" accept="image/*, application/pdf, application/vnd.ms-word, application/vnd.openxmlformats-officedocument.wordprocessingml.document, application/vnd.ms-excel, application/vnd.openxmlformats-officedocument.spreadsheetml.sheet" data-upload>
											</figure>
										</div>
									</div>
									<div class="span12">
										<div class="label">
											<label unrequired>
												<p>{$lang.widget} <a data-action="get_help" data-text=""><i class="fas fa-question-circle"></i></a></p>
												<textarea name="widget"></textarea>
											</label>
										</div>
									</div>
									<div class="span12">
										<div class="buttons">
											<a button-cancel><i class="fas fa-times"></i></a>
											<button type="submit"><i class="fas fa-check"></i></button>
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
									'			</select>
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
												<textarea name="description_es"></textarea>
											</label>
										</div>
									</div>
									<div class="span6">
										<div class="label">
											<label required>
												<p>(EN) {$lang.description} <a data-action="get_help" data-text=""><i class="fas fa-question-circle"></i></a></p>
												<textarea name="description_en"></textarea>
											</label>
										</div>
									</div>
									<div class="span6">
										<div class="label">
											<label required>
												<p>(ES) {$lang.seo_keywords} <a data-action="get_help" data-text=""><i class="fas fa-question-circle"></i></a></p>
												<input type="text" name="seo_keywords_es">
											</label>
										</div>
									</div>
									<div class="span6">
										<div class="label">
											<label required>
												<p>(EN) {$lang.seo_keywords} <a data-action="get_help" data-text=""><i class="fas fa-question-circle"></i></a></p>
												<input type="text" name="seo_keywords_en">
											</label>
										</div>
									</div>
									<div class="span6">
										<div class="label">
											<label required>
												<p>(ES) {$lang.seo_description} <a data-action="get_help" data-text=""><i class="fas fa-question-circle"></i></a></p>
												<textarea name="seo_description_es"></textarea>
											</label>
										</div>
									</div>
									<div class="span6">
										<div class="label">
											<label required>
												<p>(EN) {$lang.seo_description} <a data-action="get_help" data-text=""><i class="fas fa-question-circle"></i></a></p>
												<textarea name="seo_description_en"></textarea>
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
											<a button-cancel><i class="fas fa-times"></i></a>
											<button type="submit"><i class="fas fa-check"></i></button>
										</div>
									</div>
				                </div>
				            </form>
				        </main>
				    </div>
				</section>';
			}

			$mdl_edit_voxes_attention_times_settings = '';

			if ($account['operation'] == true)
			{
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
											<a button-cancel><i class="fas fa-times"></i></a>
											<button type="submit"><i class="fas fa-check"></i></button>
										</div>
									</div>
								</div>
							</form>
						</main>
					</div>
				</section>';
			}

			$replace = [
				'{$logotype}' => '{$path.uploads}' . $account['logotype'],
				'{$qr}' => '{$path.uploads}' . $account['qr'],
				'{$name}' => $account['name'],
				'{$token}' => strtoupper($account['token']),
				'{$fiscal_name}' => $account['fiscal']['name'],
				'{$fiscal_id}' => $account['fiscal']['id'],
				'{$div_public_requests}' => $div_public_requests,
				'{$div_public_incidents}' => $div_public_incidents,
				'{$div_menu}' => $div_menu,
				'{$div_answered_surveys}' => $div_answered_surveys,
				'{$div_reviews_page}' => $div_reviews_page,
				'{$div_attention_times}' => $div_attention_times,
				'{$operation}' => ($account['operation'] == true) ? '{$lang.activated}' : '{$lang.deactivated}',
				'{$reputation}' => ($account['reputation'] == true) ? '{$lang.activated}' : '{$lang.deactivated}',
				'{$package}' => $account['package'],
				'{$sms}' => $account['sms'],
				'{$div_siteminder}' => $div_siteminder,
				'{$div_zaviapms}' => $div_zaviapms,
				'{$btn_get_urls}' => $btn_get_urls,
				'{$mdl_get_urls}' => $mdl_get_urls,
				'{$opt_countries}' => $opt_countries,
				'{$opt_times_zones}' => $opt_times_zones,
				'{$opt_currencies}' => $opt_currencies,
				'{$opt_languages}' => $opt_languages,
				'{$opt_ladas}' => $opt_ladas,
				'{$mdl_edit_myvox_requests_settings}' => $mdl_edit_myvox_requests_settings,
				'{$mdl_edit_myvox_incidents_settings}' => $mdl_edit_myvox_incidents_settings,
				'{$mdl_edit_myvox_menu_settings}' => $mdl_edit_myvox_menu_settings,
				'{$mdl_edit_myvox_surveys_settings}' => $mdl_edit_myvox_surveys_settings,
				'{$mdl_edit_reviews_settings}' => $mdl_edit_reviews_settings,
				'{$mdl_edit_voxes_attention_times_settings}' => $mdl_edit_voxes_attention_times_settings
			];

			$template = $this->format->replace($replace, $template);

			echo $template;
		}
	}
}
