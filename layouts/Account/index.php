<?php

defined('_EXEC') or die;

$this->dependencies->add(['js', '{$path.js}Account/index.js']);
$this->dependencies->add(['other', '<script>menu_focus("account");</script>']);

?>

%{header}%
<main>
    <section class="box-container complete">
        <div class="main">
            <article>
                <main>
                    <div class="account">
                        <div class="uploader">
                            <fieldset>
                                <figure>
                                    <img src="{$logotype}" alt="" data-image-preview>
                                    <a data-image-select><i class="fas fa-upload"></i></a>
                                </figure>
                                <input type="file" name="logotype" accept="image/*" data-image-upload>
                            </fieldset>
                        </div>
                        <h2>{$account}</h2>
                        <h4>{$signup_date}</h4>
                        <h5></h5>
                        <h6><span><i class="fas fa-globe"></i>{$country}</span><span><i class="fas fa-thumbtack"></i>{$cp}</span><span><i class="fas fa-globe"></i>{$city}</span><span><i class="fas fa-clock"></i>{$time_zone}</span><span><i class="fas fa-globe"></i>{$language}</span><span><i class="fas fa-dollar-sign"></i>{$currency}</span></h6>
                        <h6><span><i class="fas fa-location-arrow"></i>{$address}</span></h6>
                        <h5></h5>
                        <h6><span><i class="fas fa-user"></i>{$fiscal_id}</span><span><i class="fas fa-user"></i>{$fiscal_name}</span></h6>
                        <h6><span><i class="fas fa-location-arrow"></i>{$fiscal_address}</span></h6>
                        <h5></h5>
                        <h6><span><i class="fas fa-user"></i>{$contact_name}</span><span><i class="fas fa-briefcase"></i>{$contact_department}</span><span><i class="fas fa-phone"></i>({$contact_lada}) {$contact_phone}</span><span><i class="fas fa-envelope"></i>{$contact_email}</span></h6>
                        <h5></h5>
                        <h6><span><i class="fas fa-comment-alt"></i>{$sms} SMS</span><span><i class="fas fa-key"></i>{$private_key}</span></h6>
                        <div class="">
                            <a class="btn" data-button-modal="edit_account">Editar cuenta</a>
                            <a class="btn" data-button-modal="request_sms">Solicitar SMS</a>
                        </div>
                    </div>
                </main>
            </article>
        </div>
    </section>
</main>
<section class="modal" data-modal="edit_account">
    <div class="content">
        <header>
            <h3>{$lang.edit}</h3>
        </header>
        <main>
            <form name="edit_account">
                <div class="row">
                    <div class="span12">
                        <div class="label">
                            <label>
                                <p>Nombre de cuenta</p>
                                <input type="text" name="account" value="{$account}" />
                            </label>
                        </div>
                    </div>
                    <div class="span4">
                        <div class="label">
                            <label>
                                <p>País</p>
                                <select name="country">
                                    {$opt_countries}
                                </select>
                            </label>
                        </div>
                    </div>
                    <div class="span4">
                        <div class="label">
                            <label>
                                <p>Código postal</p>
                                <input type="text" name="cp" value="{$cp}" />
                            </label>
                        </div>
                    </div>
                    <div class="span4">
                        <div class="label">
                            <label>
                                <p>Ciudad</p>
                                <input type="text" name="city" value="{$city}" />
                            </label>
                        </div>
                    </div>
                    <div class="span12">
                        <div class="label">
                            <label>
                                <p>Dirección</p>
                                <input type="text" name="address" value="{$address}" />
                            </label>
                        </div>
                    </div>
                    <div class="span4">
                        <div class="label">
                            <label>
                                <p>Zona horaria</p>
                                <select name="time_zone">
                                    {$opt_time_zones}
                                </select>
                            </label>
                        </div>
                    </div>
                    <div class="span4">
                        <div class="label">
                            <label>
                                <p>Lenguage</p>
                                <select name="language">
                                    {$opt_languages}
                                </select>
                            </label>
                        </div>
                    </div>
                    <div class="span4">
                        <div class="label">
                            <label>
                                <p>Moneda</p>
                                <select name="currency">
                                    {$opt_currencies}
                                </select>
                            </label>
                        </div>
                    </div>
                    <div class="span6">
                        <div class="label">
                            <label>
                                <p>RFC</p>
                                <input type="text" name="fiscal_id" value="{$fiscal_id}" />
                            </label>
                        </div>
                    </div>
                    <div class="span6">
                        <div class="label">
                            <label>
                                <p>Razón Social</p>
                                <input type="text" name="fiscal_name" value="{$fiscal_name}" />
                            </label>
                        </div>
                    </div>
                    <div class="span12">
                        <div class="label">
                            <label>
                                <p>Dirección fiscal</p>
                                <input type="text" name="fiscal_address" value="{$fiscal_address}" />
                            </label>
                        </div>
                    </div>
                    <div class="span6">
                        <div class="label">
                            <label>
                                <p>Nombre de contacto</p>
                                <input type="text" name="contact_name" value="{$contact_name}" />
                            </label>
                        </div>
                    </div>
                    <div class="span6">
                        <div class="label">
                            <label>
                                <p>Departamento</p>
                                <input type="text" name="contact_department" value="{$contact_department}" />
                            </label>
                        </div>
                    </div>
                    <div class="span2">
                        <div class="label">
                            <label>
                                <p>Lada</p>
                                <select name="contact_lada">
                                    {$opt_ladas}
                                </select>
                            </label>
                        </div>
                    </div>
                    <div class="span4">
                        <div class="label">
                            <label>
                                <p>Teléfono</p>
                                <input type="text" name="contact_phone" value="{$contact_phone}" />
                            </label>
                        </div>
                    </div>
                    <div class="span6">
                        <div class="label">
                            <label>
                                <p>Correo electrónico</p>
                                <input type="email" name="contact_email" value="{$contact_email}" />
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
<section class="modal" data-modal="request_sms">
    <div class="content">
        <header>
            <h3>Solicitar SMS</h3>
        </header>
        <main>
            <form name="request_sms">
                <div class="row">
                    <div class="span12">
                        <div class="label">
                            <label>
                                <p>Paquete</p>
                                <select name="package">
                                    {$opt_sms_packages}
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
