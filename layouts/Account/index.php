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
                <div>
                    <h6>https://<?php echo Configuration::$domain; ?>/myvox/account/{$token}</h6>
                    <figure>
                        <img src="{$qr}">
                    </figure>
                    <a href="{$qr}" download="{$qr}"><i class="fas fa-download"></i></a>
                </div>
                <div>
                    <figure>
                        <img src="{$logotype}" data-image-preview>
                        <input type="file" name="logotype" accept="image/*" data-image-upload>
                    </figure>
                    <a data-image-select><i class="fas fa-upload"></i></a>
                </div>
                <div>
                    <h4>{$lang.account_information}</h4>
                    <h6><i class="fas fa-caret-right"></i>{$token}</h6>
                    <h6><i class="fas fa-caret-right"></i>{$name}</h6>
                    <h6><i class="fas fa-caret-right"></i>{$lang.{$type}}</h6>
                    <h6><i class="fas fa-caret-right"></i>{$zip_code}</h6>
                    <h6><i class="fas fa-caret-right"></i>{$country}</h6>
                    <h6><i class="fas fa-caret-right"></i>{$city}</h6>
                    <h6><i class="fas fa-caret-right"></i>{$address}</h6>
                    <h6><i class="fas fa-caret-right"></i>{$time_zone}</h6>
                    <h6><i class="fas fa-caret-right"></i>{$currency}</h6>
                    <h6><i class="fas fa-caret-right"></i>{$lang.{$language}}</h6>
                    <a data-button-modal="edit_profile" class="edit"><i class="fas fa-pen"></i></a>
                </div>
                <div>
                    <h4>{$lang.billing_information}</h4>
                    <h6><i class="fas fa-caret-right"></i>{$fiscal_id}</h6>
                    <h6><i class="fas fa-caret-right"></i>{$fiscal_name}</h6>
                    <h6><i class="fas fa-caret-right"></i>{$fiscal_address}</h6>
                    <h6><i class="fas fa-caret-right"></i>{$contact_firstname} {$contact_lastname}</h6>
                    <h6><i class="fas fa-caret-right"></i>{$contact_department}</h6>
                    <h6><i class="fas fa-caret-right"></i>{$contact_email}</h6>
                    <h6><i class="fas fa-caret-right"></i>+{$contact_phone_lada} {$contact_phone_number}</h6>
                    <a data-button-modal="edit_billing" class="edit"><i class="fas fa-pen"></i></a>
                </div>
                <div>
                    <h4>{$lang.payment_information}</h4>
                    <h6><i class="fas fa-caret-right"></i>{$lang.{$payment_type}}</h6>
                </div>
                <?php if (Functions::check_account_access(['operation','reputation']) == true) : ?>
                <div>
                    <h4>{$lang.settings}</h4>
                    <?php if (Functions::check_account_access(['operation']) == true) : ?>
                    <h6><i class="fas fa-caret-right"></i>MyVox {$lang.request}: {$settings_myvox_request}</h6>
                    <h6><i class="fas fa-caret-right"></i>MyVox {$lang.incident}: {$settings_myvox_incident}</h6>
                    <?php endif; ?>
                    <?php if (Functions::check_account_access(['reputation']) == true) : ?>
                    <h6><i class="fas fa-caret-right"></i>MyVox {$lang.surveys}: {$settings_myvox_survey}</h6>
                    <h6><i class="fas fa-caret-right"></i>MyVox {$lang.survey_title}: {$settings_myvox_survey_title}</h6>
                    <?php endif; ?>
                    <a data-button-modal="edit_settings" class="edit"><i class="fas fa-pen"></i></a>
                </div>
                <?php endif; ?>
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
                <div>
                    <h2>
                        <i class="fas fa-sms"></i>
                        <span><strong>{$lang.sms_package}</strong></span>
                        <span>{$sms} {$lang.sms}</span>
                    </h2>
                </div>
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
                                <input type="text" name="name" value="{$name}" />
                            </label>
                        </div>
                    </div>
                    <div class="span4">
                        <div class="label">
                            <label>
                                <p>{$lang.zip_code}</p>
                                <input type="text" name="zip_code" value="{$zip_code}" />
                            </label>
                        </div>
                    </div>
                    <div class="span4">
                        <div class="label">
                            <label>
                                <p>{$lang.country}</p>
                                <select name="country">
                                    {$opt_countries}
                                </select>
                            </label>
                        </div>
                    </div>
                    <div class="span4">
                        <div class="label">
                            <label>
                                <p>{$lang.city}</p>
                                <input type="text" name="city" value="{$city}" />
                            </label>
                        </div>
                    </div>
                    <div class="span12">
                        <div class="label">
                            <label>
                                <p>{$lang.address}</p>
                                <input type="text" name="address" value="{$address}" />
                            </label>
                        </div>
                    </div>
                    <div class="span4">
                        <div class="label">
                            <label>
                                <p>{$lang.time_zone}</p>
                                <select name="time_zone">
                                    {$opt_time_zones}
                                </select>
                            </label>
                        </div>
                    </div>
                    <div class="span4">
                        <div class="label">
                            <label>
                                <p>{$lang.currency}</p>
                                <select name="currency">
                                    {$opt_currencies}
                                </select>
                            </label>
                        </div>
                    </div>
                    <div class="span4">
                        <div class="label">
                            <label>
                                <p>{$lang.language}</p>
                                <select name="language">
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
                <button class="btn btn-flat" button-close>{$lang.cancel}</button>
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
                                <input type="text" name="fiscal_id" value="{$fiscal_id}" />
                            </label>
                        </div>
                    </div>
                    <div class="span6">
                        <div class="label">
                            <label>
                                <p>{$lang.fiscal_name}</p>
                                <input type="text" name="fiscal_name" value="{$fiscal_name}" />
                            </label>
                        </div>
                    </div>
                    <div class="span12">
                        <div class="label">
                            <label>
                                <p>{$lang.fiscal_address}</p>
                                <input type="text" name="fiscal_address" value="{$fiscal_address}" />
                            </label>
                        </div>
                    </div>
                    <div class="span6">
                        <div class="label">
                            <label>
                                <p>{$lang.firstname}</p>
                                <input type="text" name="contact_firstname" value="{$contact_firstname}" />
                            </label>
                        </div>
                    </div>
                    <div class="span6">
                        <div class="label">
                            <label>
                                <p>{$lang.lastname}</p>
                                <input type="text" name="contact_lastname" value="{$contact_lastname}" />
                            </label>
                        </div>
                    </div>
                    <div class="span12">
                        <div class="label">
                            <label>
                                <p>{$lang.department}</p>
                                <input type="text" name="contact_department" value="{$contact_department}" />
                            </label>
                        </div>
                    </div>
                    <div class="span6">
                        <div class="label">
                            <label>
                                <p>{$lang.email}</p>
                                <input type="text" name="contact_email" value="{$contact_email}" />
                            </label>
                        </div>
                    </div>
                    <div class="span3">
                        <div class="label">
                            <label>
                                <p>{$lang.lada}</p>
                                <select name="contact_phone_lada">
                                    {$opt_ladas}
                                </select>
                            </label>
                        </div>
                    </div>
                    <div class="span3">
                        <div class="label">
                            <label>
                                <p>{$lang.phone}</p>
                                <input type="text" name="contact_phone_number" value="{$contact_phone_number}" />
                            </label>
                        </div>
                    </div>
                </div>
            </form>
        </main>
        <footer>
            <div class="action-buttons">
                <button class="btn btn-flat" button-close>{$lang.cancel}</button>
                <button class="btn" button-success>{$lang.accept}</button>
            </div>
        </footer>
    </div>
</section>
<?php if (Functions::check_account_access(['operation','reputation']) == true) : ?>
<section class="modal edit" data-modal="edit_settings">
    <div class="content">
        <header>
            <h3>{$lang.edit}</h3>
        </header>
        <main>
            <form name="edit_settings">
                <div class="row">
                    <?php if (Functions::check_account_access(['operation']) == true) : ?>
                    <div class="span4">
                        <div class="label">
                            <label>
                                <p>{$lang.request}</p>
                                <div class="switch">
                                    <input id="st-mv-request" type="checkbox" name="settings_myvox_request" class="switch-input" {$settings_myvox_request_ckd}>
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
                                    <input id="st-mv-incident" type="checkbox" name="settings_myvox_incident" class="switch-input" {$settings_myvox_incident_ckd}>
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
                                    <input id="st-mv-survey" type="checkbox" name="settings_myvox_survey" class="switch-input" {$settings_myvox_survey_ckd}>
                                    <label class="switch-label" for="st-mv-survey"></label>
                                </div>
                            </label>
                        </div>
                    </div>
                    <div class="span6">
                        <div class="label">
                            <label>
                                <p>(ES) {$lang.survey_title}</p>
                                <input type="text" name="settings_myvox_survey_title_es" value="{$settings_myvox_survey_title_es}" />
                            </label>
                        </div>
                    </div>
                    <div class="span6">
                        <div class="label">
                            <label>
                                <p>(EN) {$lang.survey_title}</p>
                                <input type="text" name="settings_myvox_survey_title_en" value="{$settings_myvox_survey_title_en}" />
                            </label>
                        </div>
                    </div>
                    <?php endif; ?>
                </div>
            </form>
        </main>
        <footer>
            <div class="action-buttons">
                <button class="btn btn-flat" button-close>{$lang.cancel}</button>
                <button class="btn" button-success>{$lang.accept}</button>
            </div>
        </footer>
    </div>
</section>
<?php endif; ?>
