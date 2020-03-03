<?php

defined('_EXEC') or die;

$this->dependencies->add(['js', '{$path.js}Account/index.js']);
$this->dependencies->add(['other', '<script>menu_focus("other");</script>']);

?>

%{header}%
<main>
    <nav>
        <h2><i class="far fa-user-circle"></i>{$lang.account}</h2>
    </nav>
    <article>
        <main>
            <div class="account">
                <div class="qr">
                    <figure class="qr">
                        <img src="{$qr}">
                        <a href="{$qr}" download="{$qr}"><i class="fas fa-download"></i></a>
                    </figure>
                </div>
                <div class="logotype">
                    <figure>
                        <img src="{$logotype}" data-image-preview>
                        <input type="file" name="logotype" accept="image/*" data-image-upload>
                        <a data-image-select><i class="fas fa-upload"></i></a>
                    </figure>
                </div>
                <div class="settings">
                    <div>
                        <h4>{$lang.account_information}</h4>
                        <a data-button-modal="edit_profile" class="edit"><i class="fas fa-pen"></i></a>
                    </div>
                    <div>
                        <h4>{$lang.billing_information}</h4>
                        <a data-button-modal="edit_billing" class="edit"><i class="fas fa-pen"></i></a>
                    </div>
                    <?php if (Functions::check_account_access(['operation','reputation']) == true) : ?>
                    <div>
                        <h4>{$lang.myvox_settings}</h4>
                        <a data-button-modal="edit_myvox_settings" class="edit"><i class="fas fa-pen"></i></a>
                    </div>
                    <?php endif; ?>
                    <?php if (Functions::check_account_access(['reputation']) == true) : ?>
                    <div>
                        <h4>{$lang.review_settings}</h4>
                        <a data-button-modal="edit_review_settings" class="edit"><i class="fas fa-pen"></i></a>
                    </div>
                    <?php endif; ?>
                    <!-- <div>
                        <h4>{$lang.payment_information}</h4>
                        <a class="edit" disabled><i class="fas fa-pen"></i></a>
                    </div> -->
                    <h6>{$myvox_url}</h6>
                    <h6>{$reviews_url}</h6>
                </div>
                <div>
                    <h2>
                        <i class="fas fa-users"></i>
                        <span><strong>{$lang.solution_of} {$lang.operation}</strong></span>
                        <span>{$operation}</span>
                    </h2>
                </div>
                <div>
                    <h2>
                        <i class="fas fa-smile"></i>
                        <span><strong>{$lang.solution_of} {$lang.reputation}</strong></span>
                        <span>{$reputation}</span>
                    </h2>
                </div>
                <?php if (Session::get_value('account')['type'] == 'hotel') : ?>
                <div>
                    <h2>
                        <i class="fas fa-bed"></i>
                        <span><strong>{$lang.room_package}</strong></span>
                        <span>{$room_package} {$lang.rooms}</span>
                    </h2>
                </div>
                <?php endif; ?>
                <?php if (Session::get_value('account')['type'] == 'restaurant') : ?>
                <div>
                    <h2>
                        <i class="fas fa-utensils"></i>
                        <span><strong>{$lang.table_package}</strong></span>
                        <span>{$table_package} {$lang.tables}</span>
                    </h2>
                </div>
                <?php endif; ?>
                <?php if (Session::get_value('account')['type'] == 'others') : ?>
                <div>
                    <h2>
                        <i class="fas fa-user-tie"></i>
                        <span><strong>{$lang.client_package}</strong></span>
                        <span>{$client_package} {$lang.clients}</span>
                    </h2>
                </div>
                <?php endif; ?>
                <?php if (Session::get_value('account')['type'] == 'hotel') : ?>
                <div>
                    <h2>
                        <figure>
                            <img src="{$path.images}zaviapms.png">
                        </figure>
                        <span><strong>Zavia PMS</strong></span>
                        <span>{$zaviapms}</span>
                    </h2>
                </div>
                <?php endif; ?>
                <div>
                    <h2>
                        <i class="fas fa-sms"></i>
                        <span><strong>{$lang.sms_package}</strong></span>
                        <span>{$sms} {$lang.sms}</span>
                    </h2>
                </div>
            </div>
        </main>
    </article>
</main>
<section class="modal edit" data-modal="edit_profile">
    <div class="content">
        <header>
            <h3>{$lang.edit}</h3>
        </header>
        <main>
            <form name="edit_profile">
                <div class="row">
                    <div class="span12">
                        <div class="label">
                            <label>
                                <p>{$lang.name}</p>
                                <input type="text" name="profile_name" value="{$profile_name}" />
                            </label>
                        </div>
                    </div>
                    <div class="span4">
                        <div class="label">
                            <label>
                                <p>{$lang.zip_code}</p>
                                <input type="text" name="profile_zip_code" value="{$profile_zip_code}" />
                            </label>
                        </div>
                    </div>
                    <div class="span4">
                        <div class="label">
                            <label>
                                <p>{$lang.country}</p>
                                <select name="profile_country">
                                    {$opt_countries}
                                </select>
                            </label>
                        </div>
                    </div>
                    <div class="span4">
                        <div class="label">
                            <label>
                                <p>{$lang.city}</p>
                                <input type="text" name="profile_city" value="{$profile_city}" />
                            </label>
                        </div>
                    </div>
                    <div class="span12">
                        <div class="label">
                            <label>
                                <p>{$lang.address}</p>
                                <input type="text" name="profile_address" value="{$profile_address}" />
                            </label>
                        </div>
                    </div>
                    <div class="span4">
                        <div class="label">
                            <label>
                                <p>{$lang.time_zone}</p>
                                <select name="profile_time_zone">
                                    {$opt_time_zones}
                                </select>
                            </label>
                        </div>
                    </div>
                    <div class="span4">
                        <div class="label">
                            <label>
                                <p>{$lang.currency}</p>
                                <select name="profile_currency">
                                    {$opt_currencies}
                                </select>
                            </label>
                        </div>
                    </div>
                    <div class="span4">
                        <div class="label">
                            <label>
                                <p>{$lang.language}</p>
                                <select name="profile_language">
                                    {$opt_languages}
                                </select>
                            </label>
                        </div>
                    </div>
                </div>
            </form>
        </main>
        <footer>
            <div class="action-buttons">
                <button class="btn" button-success>{$lang.accept}</button>
            </div>
        </footer>
    </div>
</section>
<section class="modal edit" data-modal="edit_billing">
    <div class="content">
        <header>
            <h3>{$lang.edit}</h3>
        </header>
        <main>
            <form name="edit_billing">
                <div class="row">
                    <div class="span6">
                        <div class="label">
                            <label>
                                <p>{$lang.fiscal_id}</p>
                                <input type="text" name="billing_fiscal_id" value="{$billing_fiscal_id}" />
                            </label>
                        </div>
                    </div>
                    <div class="span6">
                        <div class="label">
                            <label>
                                <p>{$lang.fiscal_name}</p>
                                <input type="text" name="billing_fiscal_name" value="{$billing_fiscal_name}" />
                            </label>
                        </div>
                    </div>
                    <div class="span12">
                        <div class="label">
                            <label>
                                <p>{$lang.fiscal_address}</p>
                                <input type="text" name="billing_fiscal_address" value="{$billing_fiscal_address}" />
                            </label>
                        </div>
                    </div>
                    <div class="span6">
                        <div class="label">
                            <label>
                                <p>{$lang.firstname}</p>
                                <input type="text" name="billing_contact_firstname" value="{$billing_contact_firstname}" />
                            </label>
                        </div>
                    </div>
                    <div class="span6">
                        <div class="label">
                            <label>
                                <p>{$lang.lastname}</p>
                                <input type="text" name="billing_contact_lastname" value="{$billing_contact_lastname}" />
                            </label>
                        </div>
                    </div>
                    <div class="span12">
                        <div class="label">
                            <label>
                                <p>{$lang.department}</p>
                                <input type="text" name="billing_contact_department" value="{$billing_contact_department}" />
                            </label>
                        </div>
                    </div>
                    <div class="span6">
                        <div class="label">
                            <label>
                                <p>{$lang.email}</p>
                                <input type="text" name="billing_contact_email" value="{$billing_contact_email}" />
                            </label>
                        </div>
                    </div>
                    <div class="span3">
                        <div class="label">
                            <label>
                                <p>{$lang.lada}</p>
                                <select name="billing_contact_phone_lada">
                                    {$opt_billing_ladas}
                                </select>
                            </label>
                        </div>
                    </div>
                    <div class="span3">
                        <div class="label">
                            <label>
                                <p>{$lang.phone}</p>
                                <input type="text" name="billing_contact_phone_number" value="{$billing_contact_phone_number}" />
                            </label>
                        </div>
                    </div>
                </div>
            </form>
        </main>
        <footer>
            <div class="action-buttons">
                <button class="btn" button-success>{$lang.accept}</button>
            </div>
        </footer>
    </div>
</section>
<?php if (Functions::check_account_access(['operation','reputation']) == true) : ?>
<section class="modal edit" data-modal="edit_myvox_settings">
    <div class="content">
        <header>
            <h3>{$lang.edit}</h3>
        </header>
        <main>
            <form name="edit_myvox_settings">
                <div class="row">
                    <?php if (Functions::check_account_access(['operation']) == true) : ?>
                    <div class="span4">
                        <div class="label">
                            <label>
                                <p>{$lang.request}</p>
                                <div class="switch">
                                    <input id="st-mv-request" type="checkbox" name="myvox_settings_request" class="switch-input" {$myvox_settings_request}>
                                    <label class="switch-label" for="st-mv-request"></label>
                                </div>
                            </label>
                        </div>
                    </div>
                    <div class="span4">
                        <div class="label">
                            <label>
                                <p>{$lang.incident}</p>
                                <div class="switch">
                                    <input id="st-mv-incident" type="checkbox" name="myvox_settings_incident" class="switch-input" {$myvox_settings_incident}>
                                    <label class="switch-label" for="st-mv-incident"></label>
                                </div>
                            </label>
                        </div>
                    </div>
                    <?php endif; ?>
                    <?php if (Functions::check_account_access(['reputation']) == true) : ?>
                    <div class="span4">
                        <div class="label">
                            <label>
                                <p>{$lang.surveys}</p>
                                <div class="switch">
                                    <input id="st-mv-survey" type="checkbox" name="myvox_settings_survey" class="switch-input" {$myvox_settings_survey}>
                                    <label class="switch-label" for="st-mv-survey"></label>
                                </div>
                            </label>
                        </div>
                    </div>
                    <div class="span6 {$myvox_settings_survey_hidden}">
                        <div class="label">
                            <label>
                                <p>(ES) {$lang.survey_title}</p>
                                <input type="text" name="myvox_settings_survey_title_es" value="{$myvox_settings_survey_title_es}" />
                            </label>
                        </div>
                    </div>
                    <div class="span6 {$myvox_settings_survey_hidden}">
                        <div class="label">
                            <label>
                                <p>(EN) {$lang.survey_title}</p>
                                <input type="text" name="myvox_settings_survey_title_en" value="{$myvox_settings_survey_title_en}" />
                            </label>
                        </div>
                    </div>
                    <div class="span12 {$myvox_settings_survey_hidden}">
                        <div class="label">
                            <label>
                                <p>{$lang.survey_widget}</p>
                                <textarea name="myvox_settings_survey_widget">{$myvox_settings_survey_widget}</textarea>
                            </label>
                        </div>
                    </div>
                    <!-- <div class="span6 {$myvox_settings_survey_title_mail}">
                        <div class="label">
                            <label>
                                <p>(ES) {$lang.survey_title}</p>
                                <input type="text" name="myvox_settings_survey_title_mail_es" value="{$myvox_settings_survey_title_mail_es}" />
                            </label>
                        </div>
                    </div>
                    <div class="span6 {$myvox_settings_survey_title_mail}">
                        <div class="label">
                            <label>
                                <p>(ES) {$lang.survey_title}</p>
                                <input type="text" name="myvox_settings_survey_title_mail_en" value="{$myvox_settings_survey_title_mail_en}" />
                            </label>
                        </div>
                    </div>
                    <div class="span6 {$myvox_settings_survey_paragraph_mail}">
                        <div class="label">
                            <label>
                                <p>(ES) {$lang.description}</p>
                                <textarea name="myvox_settings_survey_paragraph_mail_es">{$myvox_settings_survey_paragraph_mail_es}</textarea>
                            </label>
                        </div>
                    </div>
                    <div class="span6 {$myvox_settings_survey_paragraph_mail}">
                        <div class="label">
                            <label>
                                <p>(EN) {$lang.description}</p>
                                <textarea name="myvox_settings_survey_paragraph_mail_en">{$myvox_settings_survey_paragraph_mail_en}</textarea>
                            </label>
                        </div>
                    </div> -->
                    <?php endif; ?>
                </div>
            </form>
        </main>
        <footer>
            <div class="action-buttons">
                <button class="btn" button-success>{$lang.accept}</button>
            </div>
        </footer>
    </div>
</section>
<?php endif; ?>
<?php if (Functions::check_account_access(['reputation']) == true) : ?>
<section class="modal edit" data-modal="edit_review_settings">
    <div class="content">
        <header>
            <h3>{$lang.edit}</h3>
        </header>
        <main>
            <form name="edit_review_settings">
                <div class="row">
                    <div class="span4">
                        <div class="label">
                            <label>
                                <p>{$lang.online}</p>
                                <div class="switch">
                                    <input id="st-rv-online" type="checkbox" name="review_settings_online" class="switch-input" {$review_settings_online}>
                                    <label class="switch-label" for="st-rv-online"></label>
                                </div>
                            </label>
                        </div>
                    </div>
                    <div class="clear"></div>
                    <div class="span6 {$review_settings_hidden}">
                        <div class="label">
                            <label>
                                <p>{$lang.email}</p>
                                <input type="text" name="review_settings_email" value="{$review_settings_email}" />
                            </label>
                        </div>
                    </div>
                    <div class="span3 {$review_settings_hidden}">
                        <div class="label">
                            <label>
                                <p>{$lang.lada}</p>
                                <select name="review_settings_phone_lada">
                                    <option value="" selected hidden>{$lang.choose}</option>
                                    {$opt_review_settings_ladas}
                                </select>
                            </label>
                        </div>
                    </div>
                    <div class="span3 {$review_settings_hidden}">
                        <div class="label">
                            <label>
                                <p>{$lang.phone}</p>
                                <input type="text" name="review_settings_phone_number" value="{$review_settings_phone_number}" />
                            </label>
                        </div>
                    </div>
                    <div class="span6 {$review_settings_hidden}">
                        <div class="label">
                            <label>
                                <p>(ES) {$lang.description}</p>
                                <textarea name="review_settings_description_es">{$review_settings_description_es}</textarea>
                            </label>
                        </div>
                    </div>
                    <div class="span6 {$review_settings_hidden}">
                        <div class="label">
                            <label>
                                <p>(EN) {$lang.description}</p>
                                <textarea name="review_settings_description_en">{$review_settings_description_en}</textarea>
                            </label>
                        </div>
                    </div>
                    <div class="span6 {$review_settings_hidden}">
                        <div class="label">
                            <label>
                                <p>(ES) {$lang.keywords}</p>
                                <input type="text" name="review_settings_seo_keywords_es" value="{$review_settings_seo_keywords_es}" />
                            </label>
                        </div>
                    </div>
                    <div class="span6 {$review_settings_hidden}">
                        <div class="label">
                            <label>
                                <p>(EN) {$lang.keywords}</p>
                                <input type="text" name="review_settings_seo_keywords_en" value="{$review_settings_seo_keywords_en}" />
                            </label>
                        </div>
                    </div>
                    <div class="span6 {$review_settings_hidden}">
                        <div class="label">
                            <label>
                                <p>(ES) {$lang.meta_description}</p>
                                <textarea name="review_settings_seo_meta_description_es">{$review_settings_seo_meta_description_es}</textarea>
                            </label>
                        </div>
                    </div>
                    <div class="span6 {$review_settings_hidden}">
                        <div class="label">
                            <label>
                                <p>(EN) {$lang.meta_description}</p>
                                <textarea name="review_settings_seo_meta_description_en">{$review_settings_seo_meta_description_en}</textarea>
                            </label>
                        </div>
                    </div>
                    <div class="span12 {$review_settings_hidden}">
                        <div class="label">
                            <label>
                                <p>{$lang.website}</p>
                                <input type="text" name="review_settings_website" value="{$review_settings_website}" />
                            </label>
                        </div>
                    </div>
                    <div class="span12 {$review_settings_hidden}">
                        <div class="label">
                            <label>
                                <p>Facebook</p>
                                <input type="text" name="review_settings_social_media_facebook" value="{$review_settings_social_media_facebook}" />
                            </label>
                        </div>
                    </div>
                    <div class="span12 {$review_settings_hidden}">
                        <div class="label">
                            <label>
                                <p>Instagram</p>
                                <input type="text" name="review_settings_social_media_instagram" value="{$review_settings_social_media_instagram}" />
                            </label>
                        </div>
                    </div>
                    <div class="span12 {$review_settings_hidden}">
                        <div class="label">
                            <label>
                                <p>Twitter</p>
                                <input type="text" name="review_settings_social_media_twitter" value="{$review_settings_social_media_twitter}" />
                            </label>
                        </div>
                    </div>
                    <div class="span12 {$review_settings_hidden}">
                        <div class="label">
                            <label>
                                <p>LinkedIn</p>
                                <input type="text" name="review_settings_social_media_linkedin" value="{$review_settings_social_media_linkedin}" />
                            </label>
                        </div>
                    </div>
                    <div class="span12 {$review_settings_hidden}">
                        <div class="label">
                            <label>
                                <p>YouTube</p>
                                <input type="text" name="review_settings_social_media_youtube" value="{$review_settings_social_media_youtube}" />
                            </label>
                        </div>
                    </div>
                    <div class="span12 {$review_settings_hidden}">
                        <div class="label">
                            <label>
                                <p>Google</p>
                                <input type="text" name="review_settings_social_media_google" value="{$review_settings_social_media_google}" />
                            </label>
                        </div>
                    </div>
                    <?php if (Session::get_value('account')['type'] == 'hotel' OR Session::get_value('account')['type'] == 'restaurant') : ?>
                    <div class="span12 {$review_settings_hidden}">
                        <div class="label">
                            <label>
                                <p>Tripadvisor</p>
                                <input type="text" name="review_settings_social_media_tripadvisor" value="{$review_settings_social_media_tripadvisor}" />
                            </label>
                        </div>
                    </div>
                    <?php endif; ?>
                </div>
            </form>
        </main>
        <footer>
            <div class="action-buttons">
                <button class="btn" button-success>{$lang.accept}</button>
            </div>
        </footer>
    </div>
</section>
<?php endif; ?>
