<?php

defined('_EXEC') or die;

$this->dependencies->add(['js', '{$path.js}Account/index.js']);
$this->dependencies->add(['other', '<script>menu_focus("account");</script>']);

?>

%{header}%
<main class="dashboard">
    <section class="workspace">
        <div class="account">
            <div class="stl_1">
                <div class="stl_1" data-uploader="fast">
                    <figure data-preview>
                        <img src="{$logotype}">
                        <a data-action="edit_logotype" data-select><i class="fas fa-upload"></i></a>
                        <input type="file" name="logotype" accept="image/*" data-upload>
                    </figure>
                </div>
            </div>
            <div class="stl_2">
                <figure>
                    <img src="{$qr}">
                </figure>
            </div>
            <div class="stl_3">
                <h1>{$name}</h1>
                <span>{$token}</span>
                <span>{$country}</span>
                <span>{$city}</span>
                <span>{$zip_code}</span>
                <span>{$address}</span>
                <span>{$time_zone}</span>
                <span>{$currency}</span>
                <span>{$language}</span>
                <a class="edit" data-action="edit_account"><i class="fas fa-pen"></i></a>
            </div>
            <div class="stl_3">
                <h2>{$fiscal_name}</h2>
                <span>{$fiscal_id}</span>
                <span>{$fiscal_address}</span>
                <span>{$contact_name}</span>
                <span>{$contact_department}</span>
                <span>{$contact_email}</span>
                <span>{$contact_phone}</span>
                <a class="edit" data-action="edit_billing"><i class="fas fa-pen"></i></a>
            </div>
            {$div_public_requests}
            {$div_public_incidents}
            {$div_digital_menu}
            {$div_answered_survey}
            {$div_reviews_page}
            <div class="stl_5">
                <i class="fas fa-space-shuttle"></i>
                <h2>{$lang.operation_solution}</h2>
                <span>{$operation}</span>
            </div>
            <div class="stl_5">
                <i class="fas fa-robot"></i>
                <h2>{$lang.reputation_solution}</h2>
                <span>{$reputation}</span>
            </div>
            <div class="stl_5">
                <i class="fas fa-shapes"></i>
                <h2>{$lang.contracted_package}</h2>
                <span>{$package} {$lang.owners}</span>
            </div>
            <div class="stl_5">
                <i class="fas fa-comment-alt"></i>
                <h2>{$lang.sms_credit}</h2>
                <span>{$sms} {$lang.sms}</span>
            </div>
            {$div_siteminder}
            {$div_zaviapms}
        </div>
    </section>
    <section class="buttons">
        <div>
            {$btn_get_urls}
            <a class="active" data-button-modal="get_support"><i class="fas fa-headset"></i></a>
        </div>
    </section>
</main>
{$mdl_get_urls}
<section class="modal fullscreen" data-modal="get_support">
    <div class="content">
        <main>
            <form name="get_support">
                <div class="row">
                    <div class="span12">
                        <div class="label">
                            <label required>
                                <p>{$lang.for}</p>
                                <input type="text" value="contacto@guestvox.com" disabled>
                            </label>
                        </div>
                    </div>
                    <div class="span12">
                        <div class="label">
                            <label required>
                                <p>{$lang.message}</p>
                                <textarea name="message"></textarea>
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
</section>
<section class="modal fullscreen" data-modal="edit_account">
    <div class="content">
        <main>
            <form name="edit_account">
                <div class="row">
                    <div class="span12">
                        <div class="label">
                            <label required>
                                <p>{$lang.name}</p>
                                <input type="text" name="name" />
                            </label>
                        </div>
                    </div>
                    <div class="span4">
                        <div class="label">
                            <label required>
                                <p>{$lang.country}</p>
                                <select name="country">
                                    {$opt_countries}
                                </select>
                            </label>
                        </div>
                    </div>
                    <div class="span4">
                        <div class="label">
                            <label required>
                                <p>{$lang.city}</p>
                                <input type="text" name="city" />
                            </label>
                        </div>
                    </div>
                    <div class="span4">
                        <div class="label">
                            <label required>
                                <p>{$lang.zip_code}</p>
                                <input type="text" name="zip_code" />
                            </label>
                        </div>
                    </div>
                    <div class="span12">
                        <div class="label">
                            <label required>
                                <p>{$lang.address}</p>
                                <input type="text" name="address" />
                            </label>
                        </div>
                    </div>
                    <div class="span4">
                        <div class="label">
                            <label required>
                                <p>{$lang.time_zone}</p>
                                <select name="time_zone">
                                    {$opt_times_zones}
                                </select>
                            </label>
                        </div>
                    </div>
                    <div class="span4">
                        <div class="label">
                            <label required>
                                <p>{$lang.currency}</p>
                                <select name="currency">
                                    {$opt_currencies}
                                </select>
                            </label>
                        </div>
                    </div>
                    <div class="span4">
                        <div class="label">
                            <label required>
                                <p>{$lang.language}</p>
                                <select name="language">
                                    {$opt_languages}
                                </select>
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
</section>
<section class="modal fullscreen" data-modal="edit_billing">
    <div class="content">
        <main>
            <form name="edit_billing">
                <div class="row">
                    <div class="span6">
                        <div class="label">
                            <label required>
                                <p>{$lang.fiscal_id}</p>
                                <input type="text" name="fiscal_id" />
                            </label>
                        </div>
                    </div>
                    <div class="span6">
                        <div class="label">
                            <label required>
                                <p>{$lang.fiscal_name}</p>
                                <input type="text" name="fiscal_name" />
                            </label>
                        </div>
                    </div>
                    <div class="span12">
                        <div class="label">
                            <label required>
                                <p>{$lang.fiscal_address}</p>
                                <input type="text" name="fiscal_address" />
                            </label>
                        </div>
                    </div>
                    <div class="span6">
                        <div class="label">
                            <label required>
                                <p>{$lang.firstname}</p>
                                <input type="text" name="contact_firstname" />
                            </label>
                        </div>
                    </div>
                    <div class="span6">
                        <div class="label">
                            <label required>
                                <p>{$lang.lastname}</p>
                                <input type="text" name="contact_lastname" />
                            </label>
                        </div>
                    </div>
                    <div class="span12">
                        <div class="label">
                            <label required>
                                <p>{$lang.department}</p>
                                <input type="text" name="contact_department" />
                            </label>
                        </div>
                    </div>
                    <div class="span6">
                        <div class="label">
                            <label required>
                                <p>{$lang.email}</p>
                                <input type="text" name="contact_email" />
                            </label>
                        </div>
                    </div>
                    <div class="span3">
                        <div class="label">
                            <label required>
                                <p>{$lang.lada}</p>
                                <select name="contact_phone_lada">
                                    {$opt_ladas}
                                </select>
                            </label>
                        </div>
                    </div>
                    <div class="span3">
                        <div class="label">
                            <label required>
                                <p>{$lang.phone}</p>
                                <input type="text" name="contact_phone_number" />
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
</section>
{$mdl_edit_myvox_request_settings}
{$mdl_edit_myvox_incident_settings}
{$mdl_edit_myvox_menu_settings}
{$mdl_edit_myvox_survey_settings}
{$mdl_edit_reviews_settings}
