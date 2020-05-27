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

				if (!isset($_POST['contact_email']) OR empty($_POST['contact_email']))
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

			if ($_POST['action'] == 'edit_myvox_settings' OR $_POST['action'] == 'edit_reviews_settings')
			{
				$labels = [];

				if ($_POST['action'] == 'edit_myvox_settings')
				{
					if (!empty($_POST['survey_status']))
					{
						if (!isset($_POST['survey_title_es']) OR empty($_POST['survey_title_es']))
							array_push($labels, ['survey_title_es','']);

						if (!isset($_POST['survey_title_en']) OR empty($_POST['survey_title_en']))
							array_push($labels, ['survey_title_en','']);

						if (!isset($_POST['survey_mail_subject_es']) OR empty($_POST['survey_mail_subject_es']))
							array_push($labels, ['survey_mail_subject_es','']);

						if (!isset($_POST['survey_mail_subject_en']) OR empty($_POST['survey_mail_subject_en']))
							array_push($labels, ['survey_mail_subject_en','']);

						if (!isset($_POST['survey_mail_description_es']) OR empty($_POST['survey_mail_description_es']))
							array_push($labels, ['survey_mail_description_es','']);

						if (!isset($_POST['survey_mail_description_en']) OR empty($_POST['survey_mail_description_en']))
							array_push($labels, ['survey_mail_description_en','']);
					}
				}
				else if ($_POST['action'] == 'edit_reviews_settings')
				{
					if (!empty($_POST['status']))
					{
						if (!isset($_POST['email']) OR empty($_POST['email']))
							array_push($labels, ['email','']);

						if (!isset($_POST['phone_lada']) OR empty($_POST['phone_lada']))
							array_push($labels, ['phone_lada','']);

						if (!isset($_POST['phone_number']) OR empty($_POST['phone_number']))
							array_push($labels, ['phone_number','']);

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
					if ($_POST['action'] == 'edit_myvox_settings')
					{
						$_POST['survey_mail_image'] = $_FILES['survey_mail_image'];
						$_POST['survey_mail_attachment'] = $_FILES['survey_mail_attachment'];

						$query = $this->model->edit_settings('myvox', $_POST);
					}
					else if ($_POST['action'] == 'edit_reviews_settings')
						$query = $this->model->edit_settings('reviews', $_POST);

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

			$div_urls = '';

			if ($account['operation'] == true OR $account['reputation'] == true)
			{
				$div_urls .=
				'<div>
					' . (($account['operation'] == true OR $account['reputation'] == true) ? '<span>https://' . Configuration::$domain . '/' . $account['path'] . '/myvox</span>' : '') . '
					' . (($account['reputation'] == true) ? '<span>https://' . Configuration::$domain . '/' . $account['path'] . '/reviews</span>' : '') . '
				</div>';
			}

			$div_myvox_settings = '';

			if ($account['operation'] == true OR $account['reputation'] == true)
			{
				$div_myvox_settings .= '<div>';

				if ($account['operation'] == true)
				{
					$div_myvox_settings .=
					'<span>' . (($account['settings']['myvox']['request']['status'] == true) ? '{$lang.request_activated}' : '{$lang.request_deactivated}') . '</span>
					<span>' . (($account['settings']['myvox']['incident']['status'] == true) ? '{$lang.incident_activated}' : '{$lang.incident_deactivated}') . '</span>';
				}

				if ($account['reputation'] == true)
				{
					$div_myvox_settings .= '<span>' . (($account['settings']['myvox']['survey']['status'] == true) ? '{$lang.survey_activated}' : '{$lang.survey_deactivated}') . '</span>';

					if ($account['settings']['myvox']['survey']['status'] == true)
					{
						$div_myvox_settings .=
						'<span>' . $account['settings']['myvox']['survey']['title'][$this->lang] . '</span>
		                <span>' . $account['settings']['myvox']['survey']['mail']['subject'][$this->lang] . '</span>
		                <p>' . Functions::shorten_string($account['settings']['myvox']['survey']['mail']['description'][$this->lang], 200) . '</p>';

						if (!empty($account['settings']['myvox']['survey']['mail']['image']))
						{
							$div_myvox_settings .=
							'<figure>
								<img src="{$path.uploads}' . $account['settings']['myvox']['survey']['mail']['image'] . '">
							</figure>';
						}
						else
							$div_myvox_settings .= '<span>{$lang.not_image}</span>';

						if (!empty($account['settings']['myvox']['survey']['mail']['attachment']))
						{
							$ext = strtoupper(explode('.', $account['settings']['myvox']['survey']['mail']['attachment'])[1]);

							if ($ext == 'JPG' OR $ext == 'JPEG' OR $ext == 'PNG')
							{
								$div_myvox_settings .=
								'<figure>
									<img src="{$path.uploads}' . $account['settings']['myvox']['survey']['mail']['attachment'] . '">
								</figure>';
							}
							else if ($ext == 'PDF' OR $ext == 'DOC' OR $ext == 'DOCX' OR $ext == 'XLS' OR $ext == 'XLSX')
								$div_myvox_settings .= '<iframe src="https://docs.google.com/viewer?url=https://' . Configuration::$domain . '/uploads/' . $account['settings']['myvox']['survey']['mail']['attachment'] . '&embedded=true"></iframe>';
						}
						else
							$div_myvox_settings .= '<span>{$lang.not_attachment}</span>';

		                $div_myvox_settings .= '<span>' . (!empty($account['settings']['myvox']['survey']['widget']) ? '{$lang.widget_activated}' : '{$lang.widget_deactivated}') . '</span>';
					}
				}

				$div_myvox_settings .=
				'	<a data-action="edit_myvox_settings"><i class="fas fa-pen"></i></a>
				</div>';
			}

			$div_reviews_settings = '';

			if ($account['reputation'] == true)
			{
				$div_reviews_settings .=
				'<div>
	                <span>' . (($account['settings']['reviews']['status'] == true) ? '{$lang.reviews_activated}' : '{$lang.reviews_deactivated}') . '</span>';

					if ($account['settings']['reviews']['status'] == true)
					{
						$div_reviews_settings .=
						'<span>' . $account['settings']['reviews']['email'] . '</span>
						<span>+ (' . $account['settings']['reviews']['phone']['lada'] . ') ' . $account['settings']['reviews']['phone']['number'] . '</span>
						<p>' . Functions::shorten_string($account['settings']['reviews']['description'][$this->lang], 200) . '</p>
						<p>' . Functions::shorten_string($account['settings']['reviews']['seo']['keywords'][$this->lang], 200) . '</p>
						<p>' . Functions::shorten_string($account['settings']['reviews']['seo']['description'][$this->lang], 200) . '</p>
						<span>' . (!empty($account['settings']['reviews']['social_media']['facebook']) ? '{$lang.facebook_activated}' : '{$lang.facebook_deactivated}') . '</span>
						<span>' . (!empty($account['settings']['reviews']['social_media']['instagram']) ? '{$lang.instagram_activated}' : '{$lang.instagram_deactivated}') . '</span>
						<span>' . (!empty($account['settings']['reviews']['social_media']['twitter']) ? '{$lang.twitter_activated}' : '{$lang.twitter_deactivated}') . '</span>
						<span>' . (!empty($account['settings']['reviews']['social_media']['linkedin']) ? '{$lang.linkedin_activated}' : '{$lang.linkedin_deactivated}') . '</span>
						<span>' . (!empty($account['settings']['reviews']['social_media']['youtube']) ? '{$lang.youtube_activated}' : '{$lang.youtube_deactivated}') . '</span>
						<span>' . (!empty($account['settings']['reviews']['social_media']['google']) ? '{$lang.google_activated}' : '{$lang.google_deactivated}') . '</span>
						<span>' . (!empty($account['settings']['reviews']['social_media']['tripadvisor']) ? '{$lang.tripadvisor_activated}' : '{$lang.tripadvisor_deactivated}') . '</span>';
					}

				$div_reviews_settings .=
				'	<a data-action="edit_reviews_settings"><i class="fas fa-pen"></i></a>
				</div>';
			}

			$icn_package = '';
			$ttl_package = '';
			$div_siteminder = '';
			$div_zaviapms = '';

			if ($account['type'] == 'hotel')
			{
				$icn_package .= '<i class="fas fa-bed"></i>';
				$ttl_package .= '{$lang.rooms}';

				$div_siteminder .=
				'<div>
					<figure>
						<img src="{$path.images}siteminder.png">
					</figure>
					<h3>Siteminder</h3>
					<span>' . (($account['siteminder']['status'] == true) ? '{$lang.activated}' : '{$lang.deactivated}') . '</span>
                </div>';

				$div_zaviapms .=
				'<div>
					<figure>
						<img src="{$path.images}zaviapms.png">
					</figure>
					<h3>Zavia PMS</h3>
					<span>' . (($account['zaviapms']['status'] == true) ? '{$lang.activated}' : '{$lang.deactivated}') . '</span>
                </div>';
			}
			else if ($account['type'] == 'restaurant')
			{
				$icn_package .= '<i class="fas fa-utensils"></i>';
				$ttl_package .= '{$lang.tables}';
			}
			else if ($account['type'] == 'hospital')
			{
				$icn_package .= '<i class="fas fa-stethoscope"></i>';
				$ttl_package .= '{$lang.beds}';
			}
			else if ($account['type'] == 'others')
			{
				$icn_package .= '<i class="fas fa-users"></i>';
				$ttl_package .= '{$lang.clients}';
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

			$mdl_edit_myvox_settings = '';

			if ($account['operation'] == true OR $account['reputation'] == true)
			{
				$mdl_edit_myvox_settings .=
				'<section class="modal" data-modal="edit_myvox_settings">
				    <div class="content">
				        <main>
				            <form name="edit_myvox_settings">
				                <div class="row">';

				if ($account['operation'] == true)
				{
					$mdl_edit_myvox_settings .=
					'<div class="span12">
						<div class="label">
							<label unrequired>
								<p>{$lang.request}</p>
								<div class="switch">
									<input id="rqsw" type="checkbox" name="request_status" class="switch-input">
									<label class="switch-label" for="rqsw"></label>
								</div>
							</label>
						</div>
					</div>
					<div class="span12">
						<div class="label">
							<label unrequired>
								<p>{$lang.incident}</p>
								<div class="switch">
									<input id="insw" type="checkbox" name="incident_status" class="switch-input">
									<label class="switch-label" for="insw"></label>
								</div>
							</label>
						</div>
					</div>';
				}

				if ($account['reputation'] == true)
				{
					$mdl_edit_myvox_settings .=
					'<div class="span12">
						<div class="label">
							<label unrequired>
								<p>{$lang.survey}</p>
								<div class="switch">
									<input id="susw" type="checkbox" name="survey_status" class="switch-input">
									<label class="switch-label" for="susw"></label>
								</div>
							</label>
						</div>
					</div>
					<div class="span6 hidden">
						<div class="label">
							<label required>
								<p>ES - {$lang.title}</p>
								<input type="text" name="survey_title_es">
							</label>
						</div>
					</div>
					<div class="span6 hidden">
						<div class="label">
							<label required>
								<p>EN - {$lang.title}</p>
								<input type="text" name="survey_title_en">
							</label>
						</div>
					</div>
					<div class="span6 hidden">
						<div class="label">
							<label required>
								<p>ES - {$lang.subject}</p>
								<input type="text" name="survey_mail_subject_es">
							</label>
						</div>
					</div>
					<div class="span6 hidden">
						<div class="label">
							<label required>
								<p>EN - {$lang.subject}</p>
								<input type="text" name="survey_mail_subject_en">
							</label>
						</div>
					</div>
					<div class="span6 hidden">
						<div class="label">
							<label required>
								<p>ES - {$lang.description}</p>
								<textarea name="survey_mail_description_es"></textarea>
							</label>
						</div>
					</div>
					<div class="span6 hidden">
						<div class="label">
							<label required>
								<p>EN - {$lang.description}</p>
								<textarea name="survey_mail_description_en"></textarea>
							</label>
						</div>
					</div>
					<div class="span12 hidden">
						<div class="st-2" data-uploader="low">
							<p>{$lang.image}</p>
							<figure data-preview>
								<img src="{$path.images}empty.png">
								<a data-select><i class="fas fa-upload"></i></a>
								<input type="file" name="survey_mail_image" accept="image/*" data-upload>
							</figure>
						</div>
                    </div>
					<div class="span12 hidden">
						<div class="st-2" data-uploader="low">
							<p>{$lang.attachment}</p>
							<figure data-preview>
								<img src="{$path.images}empty.png">
								<a data-select><i class="fas fa-upload"></i></a>
								<input type="file" name="survey_mail_attachment" accept="image/*, application/pdf, application/vnd.ms-word, application/vnd.openxmlformats-officedocument.wordprocessingml.document, application/vnd.ms-excel, application/vnd.openxmlformats-officedocument.spreadsheetml.sheet" data-upload>
							</figure>
						</div>
                    </div>
					<div class="span12 hidden">
						<div class="label">
							<label unrequired>
								<p>{$lang.widget}</p>
								<textarea name="survey_widget"></textarea>
							</label>
						</div>
					</div>';
				}

				$mdl_edit_myvox_settings .=
			    '                	<div class="span12">
				                        <div class="buttons">
				                            <button type="submit">{$lang.accept}</button>
				                            <a button-cancel>{$lang.cancel}</a>
				                        </div>
				                    </div>
				                </div>
				            </form>
				        </main>
				    </div>
				</section>';
			}

			$mdl_edit_reviews_settings = '';

			if ($account['reputation'] == true)
			{
				$mdl_edit_reviews_settings .=
				'<section class="modal" data-modal="edit_reviews_settings">
				    <div class="content">
				        <main>
				            <form name="edit_reviews_settings">
				                <div class="row">
									<div class="span12">
										<div class="label">
											<label unrequired>
												<p>{$lang.reviews}</p>
												<div class="switch">
													<input id="rvsw" type="checkbox" name="status" class="switch-input">
													<label class="switch-label" for="rvsw"></label>
												</div>
											</label>
										</div>
									</div>
									<div class="span6 hidden">
										<div class="label">
											<label required>
												<p>{$lang.email}</p>
												<input type="email" name="email">
											</label>
										</div>
									</div>
									<div class="span3 hidden">
										<div class="label">
											<label required>
												<p>{$lang.lada}</p>
												<select name="phone_lada">
													<option value="" selected hidden>{$lang.choose}</option>';

				foreach ($this->model->get_countries() as $value)
					$mdl_edit_reviews_settings .= '<option value="' . $value['lada'] . '">' . $value['name'][$this->lang] . ' (+' . $value['lada'] . ')</option>';

				$mdl_edit_reviews_settings .=
				'								</select>
											</label>
										</div>
									</div>
									<div class="span3 hidden">
										<div class="label">
											<label required>
												<p>{$lang.phone}</p>
												<input type="text" name="phone_number">
											</label>
										</div>
									</div>
									<div class="span6 hidden">
										<div class="label">
											<label required>
												<p>ES - {$lang.description}</p>
												<textarea name="description_es"></textarea>
											</label>
										</div>
									</div>
									<div class="span6 hidden">
										<div class="label">
											<label required>
												<p>EN - {$lang.description}</p>
												<textarea name="description_en"></textarea>
											</label>
										</div>
									</div>
									<div class="span6 hidden">
										<div class="label">
											<label required>
												<p>ES - {$lang.seo_keywords}</p>
												<input type="text" name="seo_keywords_es">
											</label>
										</div>
									</div>
									<div class="span6 hidden">
										<div class="label">
											<label required>
												<p>EN - {$lang.seo_keywords}</p>
												<input type="text" name="seo_keywords_en">
											</label>
										</div>
									</div>
									<div class="span6 hidden">
										<div class="label">
											<label required>
												<p>ES - {$lang.seo_description}</p>
												<textarea name="seo_description_es"></textarea>
											</label>
										</div>
									</div>
									<div class="span6 hidden">
										<div class="label">
											<label required>
												<p>EN - {$lang.seo_description}</p>
												<textarea name="seo_description_en"></textarea>
											</label>
										</div>
									</div>
									<div class="span12 hidden">
										<div class="label">
											<label unrequired>
												<p>Facebook</p>
												<input type="text" name="social_media_facebook">
											</label>
										</div>
									</div>
									<div class="span12 hidden">
										<div class="label">
											<label unrequired>
												<p>Instagram</p>
												<input type="text" name="social_media_instagram">
											</label>
										</div>
									</div>
									<div class="span12 hidden">
										<div class="label">
											<label unrequired>
												<p>Twitter</p>
												<input type="text" name="social_media_twitter">
											</label>
										</div>
									</div>
									<div class="span12 hidden">
										<div class="label">
											<label unrequired>
												<p>LinkedIn</p>
												<input type="text" name="social_media_linkedin">
											</label>
										</div>
									</div>
									<div class="span12 hidden">
										<div class="label">
											<label unrequired>
												<p>YouTube</p>
												<input type="text" name="social_media_youtube">
											</label>
										</div>
									</div>
									<div class="span12 hidden">
										<div class="label">
											<label unrequired>
												<p>Google</p>
												<input type="text" name="social_media_google">
											</label>
										</div>
									</div>
									<div class="span12 hidden">
										<div class="label">
											<label unrequired>
												<p>TripAdvisor</p>
												<input type="text" name="social_media_tripadvisor">
											</label>
										</div>
									</div>
									<div class="span12">
				                        <div class="buttons">
				                            <button type="submit">{$lang.accept}</button>
				                            <a button-cancel>{$lang.cancel}</a>
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
				'{$token}' => $account['token'],
				'{$country}' => $account['country'],
				'{$city}' => $account['city'],
				'{$zip_code}' => $account['zip_code'],
				'{$address}' => $account['address'],
				'{$time_zone}' => $account['time_zone'],
				'{$currency}' => $account['currency'],
				'{$language}' => $account['language'],
				'{$div_urls}' => $div_urls,
				'{$fiscal_name}' => $account['fiscal']['name'],
				'{$fiscal_id}' => $account['fiscal']['id'],
				'{$fiscal_address}' => $account['fiscal']['address'],
				'{$contact_name}' => $account['contact']['firstname'] . ' ' . $account['contact']['lastname'],
				'{$contact_department}' => $account['contact']['department'],
				'{$contact_email}' => $account['contact']['email'],
				'{$contact_phone}' => $account['contact']['phone']['lada'] . ' ' . $account['contact']['phone']['number'],
				'{$div_myvox_settings}' => $div_myvox_settings,
				'{$div_reviews_settings}' => $div_reviews_settings,
				'{$operation}' => ($account['operation'] == true) ? '{$lang.activated}' : '{$lang.deactivated}',
				'{$reputation}' => ($account['reputation'] == true) ? '{$lang.activated}' : '{$lang.deactivated}',
				'{$icn_package}' => $icn_package,
				'{$ttl_package}' => $account['package']['quantity_end'] . ' ' . $ttl_package,
				'{$div_siteminder}' => $div_siteminder,
				'{$div_zaviapms}' => $div_zaviapms,
				'{$sms}' => $account['sms'],
				'{$opt_countries}' => $opt_countries,
				'{$opt_times_zones}' => $opt_times_zones,
				'{$opt_currencies}' => $opt_currencies,
				'{$opt_languages}' => $opt_languages,
				'{$opt_ladas}' => $opt_ladas,
				'{$mdl_edit_myvox_settings}' => $mdl_edit_myvox_settings,
				'{$mdl_edit_reviews_settings}' => $mdl_edit_reviews_settings
			];

			$template = $this->format->replace($replace, $template);

			echo $template;
		}
	}
}
