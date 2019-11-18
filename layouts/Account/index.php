<?php

defined('_EXEC') or die;

$this->dependencies->add(['js', '{$path.js}Account/index.js']);
$this->dependencies->add(['other', '<script>menu_focus("other");</script>']);

?>

%{header}%
<main>
    <article>
        <header>
            <h2><i class="far fa-user-circle"></i>{$lang.account}</h2>
        </header>
        <main>
            <div class="account">
                <div>
                    <figure>
                        <img src="{$logotype}" data-image-preview>
                        <input type="file" name="logotype" accept="image/*" data-image-upload>
                    </figure>
                    <a data-image-select class="edit"><i class="fas fa-upload"></i></a>
                </div>
                <div>
                    <h6><i class="fas fa-user-alt"></i>{$name}</h6>
                    <h6><i class="fas fa-flag"></i>{$country}</h6>
                    <h6><i class="fas fa-map-marked"></i>{$cp}</h6>
                    <h6><i class="fas fa-map-marked"></i>{$city}</h6>
                    <h6><i class="fas fa-map-marked"></i>{$address}</h6>
                    <h6><i class="fas fa-globe-americas"></i>{$time_zone}</h6>
                    <h6><i class="fas fa-globe"></i>{$language}</h6>
                    <h6><i class="fas fa-money-bill"></i>{$currency}</h6>
                    <a data-button-modal="edit_profile" class="edit"><i class="fas fa-pencil-alt"></i></a>
                </div>
                <div>
                    <h6><i class="fas fa-user-alt"></i>{$fiscal_id}</h6>
                    <h6><i class="fas fa-user-alt"></i>{$fiscal_name}</h6>
                    <h6><i class="fas fa-map-marked"></i>{$fiscal_address}</h6>
                    <h6><i class="fas fa-user-alt"></i>{$contact_name}</h6>
                    <h6><i class="fas fa-address-card"></i>{$contact_department}</h6>
                    <h6><i class="fas fa-envelope"></i>{$contact_email}</h6>
                    <h6><i class="fas fa-mobile-alt"></i>+{$contact_phone_lada} {$contact_phone_number}</h6>
                    <a data-button-modal="edit_fiscal" class="edit"><i class="fas fa-pencil-alt"></i></a>
                </div>
                <?php if (Functions::check_account_access(['operation','reputation']) == true) : ?>
                <div>
                    <?php if (Functions::check_account_access(['operation']) == true) : ?>
                    <h6><i class="fas fa-user-clock"></i>{$lang.request}: {$myvox_request}</h6>
                    <h6><i class="fas fa-user-tag"></i>{$lang.incident}: {$myvox_incident}</h6>
                    <?php endif; ?>
                    <?php if (Functions::check_account_access(['reputation']) == true) : ?>
                    <h6><i class="fas fa-list-ol"></i>{$lang.surveys}: {$myvox_survey}</h6>
                    <h6><i class="fas fa-list-ol"></i>{$lang.survey_title}: {$myvox_survey_title}</h6>
                    <?php endif; ?>
                    <a data-button-modal="edit_myvox" class="edit"><i class="fas fa-pencil-alt"></i></a>
                </div>
                <?php endif; ?>
                <div>
                    <h2>{$sms}</h2>
                </div>
                <div>
                    <h2>{$pms}</h2>
                </div>
                <div>
                    <h2>{$room_package}</h2>
                </div>
                <div>
                    <h2>{$user_package}</h2>
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
                                <input type="text" name="name" value="{$name}" />
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
                                <p>{$lang.cp}</p>
                                <input type="text" name="cp" value="{$cp}" />
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
                                <p>{$lang.language}</p>
                                <select name="language">
                                    {$opt_languages}
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
                </div>
            </form>
        </main>
        <footer>
            <div class="action-buttons">
                <button class="btn btn-flat" button-cancel>{$lang.cancel}</button>
                <button class="btn" button-success>{$lang.accept}</button>
            </div>
        </footer>
    </div>
</section>
<section class="modal edit" data-modal="edit_fiscal">
    <div class="content">
        <header>
            <h3>{$lang.edit}</h3>
        </header>
        <main>
            <form name="edit_fiscal">
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
                                <p>{$lang.contact_name}</p>
                                <input type="text" name="contact_name" value="{$contact_name}" />
                            </label>
                        </div>
                    </div>
                    <div class="span6">
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
                <button class="btn btn-flat" button-cancel>{$lang.cancel}</button>
                <button class="btn" button-success>{$lang.accept}</button>
            </div>
        </footer>
    </div>
</section>
<?php if (Functions::check_account_access(['operation','reputation']) == true) : ?>
<section class="modal edit" data-modal="edit_myvox">
    <div class="content">
        <header>
            <h3>{$lang.edit}</h3>
        </header>
        <main>
            <form name="edit_myvox">
                <div class="row">
                    <?php if (Functions::check_account_access(['operation']) == true) : ?>
                    <div class="span4">
                        <div class="label">
                            <label>
                                <p>{$lang.request}</p>
                                <div class="switch">
                                    <input id="mv-request" type="checkbox" name="myvox_request" class="switch-input" {$myvox_request_ckd}>
                                    <label class="switch-label" for="mv-request"></label>
                                </div>
                            </label>
                        </div>
                    </div>
                    <div class="span4">
                        <div class="label">
                            <label>
                                <p>{$lang.incident}</p>
                                <div class="switch">
                                    <input id="mv-incident" type="checkbox" name="myvox_incident" class="switch-input" {$myvox_incident_ckd}>
                                    <label class="switch-label" for="mv-incident"></label>
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
                                    <input id="mv-survey" type="checkbox" name="myvox_survey" class="switch-input" {$myvox_survey_ckd}>
                                    <label class="switch-label" for="mv-survey"></label>
                                </div>
                            </label>
                        </div>
                    </div>
                    <div class="span6">
                        <div class="label">
                            <label>
                                <p>(ES) {$lang.survey_title}</p>
                                <input type="text" name="myvox_survey_title_es" value="{$myvox_survey_title_es}" />
                            </label>
                        </div>
                    </div>
                    <div class="span6">
                        <div class="label">
                            <label>
                                <p>(EN) {$lang.survey_title}</p>
                                <input type="text" name="myvox_survey_title_en" value="{$myvox_survey_title_en}" />
                            </label>
                        </div>
                    </div>
                    <?php endif; ?>
                </div>
            </form>
        </main>
        <footer>
            <div class="action-buttons">
                <button class="btn btn-flat" button-cancel>{$lang.cancel}</button>
                <button class="btn" button-success>{$lang.accept}</button>
            </div>
        </footer>
    </div>
</section>
<?php endif; ?>
