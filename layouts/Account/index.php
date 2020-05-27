<?php

defined('_EXEC') or die;

$this->dependencies->add(['js', '{$path.js}Account/index.js']);
$this->dependencies->add(['other', '<script>menu_focus("account");</script>']);

?>

%{header}%
<main class="dashboard">
    <section class="workspace">
        <div class="account">
            <div>
                <div class="st-1" data-uploader="fast">
                    <figure data-preview>
                        <img src="{$logotype}">
                        <a data-action="edit_logotype" data-select><i class="fas fa-upload"></i></a>
                        <input type="file" name="logotype" accept="image/png,image/jpg,image/jpeg" data-upload>
                    </figure>
                </div>
            </div>
            <div>
                <figure>
                    <img src="{$qr}">
                </figure>
            </div>
            <div>
                <h1>{$name}</h1>
                <span>{$token}</span>
                <span>{$country}</span>
                <span>{$city}</span>
                <span>{$zip_code}</span>
                <span>{$address}</span>
                <span>{$time_zone}</span>
                <span>{$currency}</span>
                <span>{$language}</span>
                {$spn_myvox_url}
                {$spn_reviews_url}
                <a data-action="edit_account"><i class="fas fa-pen"></i></a>
            </div>
            <div>
                <h2>{$fiscal_name}</h2>
                <span>{$fiscal_id}</span>
                <span>{$fiscal_address}</span>
                <span>{$contact_name}</span>
                <span>{$contact_department}</span>
                <span>{$contact_email}</span>
                <span>{$contact_phone}</span>
                <a data-action="edit_billing"><i class="fas fa-pen"></i></a>
            </div>
            {$div_myvox_settings}
            {$div_reviews_settings}
            <div>
                <i class="fas fa-users"></i>
                <h3>{$lang.operation_solution}</h3>
                <span>{$operation}</span>
            </div>
            <div>
                <i class="fas fa-smile"></i>
                <h3>{$lang.reputation_solution}</h3>
                <span>{$reputation}</span>
            </div>
            <div>
                {$icn_package}
                <h3>{$lang.package_active}</h3>
                <span>{$ttl_package}</span>
            </div>
            {$div_siteminder}
            {$div_zaviapms}
            <div>
                <i class="fas fa-comment-alt"></i>
                <h3>{$lang.sms_credit}</h3>
                <span>{$sms} {$lang.sms}</span>
            </div>
        </div>
    </section>
</main>
<section class="modal" data-modal="edit_account">
    <div class="content">
        <main>
            <form name="edit_profile">
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
                            <button type="submit">{$lang.accept}</button>
                            <a button-cancel>{$lang.cancel}</a>
                        </div>
                    </div>
                </div>
            </form>
        </main>
    </div>
</section>
<section class="modal" data-modal="edit_billing">
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
                    <div class="span12">
                        <div class="label">
                            <label required>
                                <p>{$lang.email}</p>
                                <input type="text" name="contact_email" />
                            </label>
                        </div>
                    </div>
                    <div class="span4">
                        <div class="label">
                            <label required>
                                <p>{$lang.lada}</p>
                                <select name="contact_phone_lada">
                                    {$opt_ladas}
                                </select>
                            </label>
                        </div>
                    </div>
                    <div class="span8">
                        <div class="label">
                            <label required>
                                <p>{$lang.phone}</p>
                                <input type="text" name="contact_phone_number" />
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
</section>
{$mdl_edit_myvox_settings}
{$mdl_edit_reviews_settings}
