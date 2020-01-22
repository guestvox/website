<?php

defined('_EXEC') or die;

$this->dependencies->add(['css', '{$path.css}Index/index.css']);
$this->dependencies->add(['js', '{$path.js}Index/index.js']);
// $this->dependencies->add(['other', '<script async defer src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBLCea8Q6BtcTHwY3YFCiB0EoHE5KnsMUE"></script>']);

?>

<header class="landing-page-index">
    <div class="container">
        <figure>
            <img src="{$path.images}logotype-white.png" alt="GuestVox logotype">
        </figure>
        <nav>
            <ul>
                <li><a href="/blog" class="btn no-border">{$lang.our_blog}</a></li>
                <li><a data-button-modal="signup" class="btn">{$lang.start_free_demo}</a></li>
                <li><a data-button-modal="login" class="btn">{$lang.login}</a></li>
                <li><a href="?<?php echo Language::get_lang_url('es'); ?>" class="btn no-border lang"><img src="{$path.images}es.png" alt="ES Lang"></a></li>
                <li><a href="?<?php echo Language::get_lang_url('en'); ?>" class="btn no-border lang"><img src="{$path.images}en.png" alt="EN Lang"></a></li>
            </ul>
            <ul>
                <li><a class="btn" data-action="open-land-menu"><i class="fas fa-bars"></i></a></li>
            </ul>
        </nav>
    </div>
</header>
<main class="landing-page-index">
    <section class="home">
    	<div class="container">
    		<figure>
    			<img src="{$path.images}home.png" alt="Home background">
    		</figure>
            <div>
    			<h4>{$lang.im_the_guests_voice}</h4>
    			<h1>{$lang.manages_correctly_the_incidents}</h1>
    		</div>
    	</div>
    </section>
    <section class="features-one">
    	<div class="container">
    		<h2>{$lang.how_do_we_help_your_hotel}</h2>
            <div>
                <img src="/images/feature-1.svg" alt="Feature">
                <p>{$lang.capture_all_kinds}</p>
            </div>
            <div>
                <img src="/images/feature-2.svg" alt="Feature">
                <p>{$lang.coordinate_follow_cases}</p>
            </div>
            <div>
                <img src="/images/feature-3.svg" alt="Feature">
                <p>{$lang.control_performance_your_hotel}</p>
            </div>
            <div>
                <img src="/images/feature-4.svg" alt="Feature">
                <p>{$lang.check_metrics_best_decisions}</p>
            </div>
    	</div>
    </section>
    <section class="features-two">
		<div>
            <ul class="container">
                <li><i class="fas fa-check"></i>{$lang.multi_device}</li>
                <li><i class="fas fa-check"></i>{$lang.on_the_cloud}</li>
                <li><i class="fas fa-check"></i>{$lang.100_encrypted_safe}</li>
                <li><i class="fas fa-check"></i>{$lang.simple}</li>
                <li><a data-button-modal="signup" class="btn">{$lang.start_free_demo}</a></li>
            </ul>
        </div>
    </section>
    <section class="clients">
    	<div class="container">
    		<h2>{$lang.they_already_trust_us}</h2>
            <div>
                <figure>
                    <img src="{$path.images}clients-1.jpg" alt="Client logotype">
                </figure>
                <figure>
                    <img src="{$path.images}clients-2.jpg" alt="Client logotype">
                </figure>
                <figure>
                    <img src="{$path.images}clients-3.jpg" alt="Client logotype">
                </figure>
                <figure>
                    <img src="{$path.images}clients-4.jpg" alt="Client logotype">
                </figure>
                <figure>
                    <img src="{$path.images}clients-5.jpg" alt="Client logotype">
                </figure>
                <figure>
                    <img src="{$path.images}clients-6.jpg" alt="Client logotype">
                </figure>
            </div>
            <a data-button-modal="signup" class="btn">{$lang.start_free_demo}</a>
    	</div>
    </section>
    <section class="team">
        <div>
            <div>
                <figure>
                    <img src="{$path.images}basurto.png" alt="Member team avatar">
                </figure>
            </div>
            <span><strong>Daniel Basurto</strong></span>
            <span>{$lang.ceo_cofounder}</span>
        </div>
        <div>
            <div>
                <figure>
                    <img src="{$path.images}gerson.png" alt="Member team avatar">
                </figure>
            </div>
            <span><strong>Gersón Gómez</strong></span>
            <span>{$lang.cto}</span>
        </div>
        <div>
            <div>
                <figure>
                    <img src="{$path.images}saul.png" alt="Member team avatar">
                </figure>
            </div>
            <span><strong>Saúl Poot</strong></span>
            <span>{$lang.chief_programmer}</span>
        </div>
    </section>
</main>
<footer class="landing-page-index">
    <div class="container">
        <div class="widget_cs">
            <p align="center"><a href="https://www.comparasoftware.com/guestvox/"><img src="https://www.comparasoftware.com/wp-content/uploads/2019/05/comparasoftware_verificado.png" alt="logo_verificado" width="180"/></a></p>
            <p style="text-align: center;" align="center"><a href="https://www.comparasoftware.com/guestvox/"> GuestVox</a> se encuentra verificada como <a href="https://www.comparasoftware.com/hoteleria/"> software de Hotelería</a></p>
        </div>
        <nav>
            <ul>
                <li><a href="https://facebook.com/guestvox" class="btn" target="_blank"><i class="fab fa-facebook-square"></i></a></li>
                <li><a href="https://instagram.com/guestvox" class="btn" target="_blank"><i class="fab fa-instagram"></i></a></li>
                <li><a href="https://linkedin.com/guestvox" class="btn" target="_blank"><i class="fab fa-linkedin"></i></a></li>
                <li><a href="https://www.youtube.com/channel/UCKSAce4n1NqahbL5RQ8QN9Q" class="btn" target="_blank"><i class="fab fa-youtube" ></i></i></a></li>
                <li><a class="btn no-border">{$lang.copyright}</a></li>
                <li><a href="/terms" class="btn no-border" target="_blank">{$lang.terms_conditions}</a></li>
            </ul>
        </nav>
        <figure>
            <img src="{$path.images}logotype-color.png" alt="GuestVox logotype">
        </figure>
    </div>
</footer>
<section class="modal fullscreen" data-modal="signup">
    <div class="content">
        <main>
            <form name="signup">
                <h2>¡{$lang.signup}!</h2>
                <h3>{$lang.and_start_free_demo}</h3>
                <div class="steps">
                    <div class="step-buttons">
                        <a class="view"><img src="{$path.images}icon-white.svg" alt="GuestVox icontype"></a>
                        <a class="view" data-step="1">1</a>
                        <a data-step="2">2</a>
                        <a data-step="3">3</a>
                        <a data-step="4">4</a>
                        <a data-step="5">5</a>
                        <a data-step="6"><i class="fas fa-check"></i></a>
                    </div>
                    <div class="step-container view" data-step="1">
                        <h2>{$lang.step_1}: {$lang.account_information}</h2>
                        <div class="row">
                            <div class="span6">
                                <div class="span6">
                                    <fieldset>
                                        <input type="text" name="name" placeholder="{$lang.name}">
                                    </fieldset>
                                </div>
                                <div class="span6">
                                    <fieldset class="path">
                                        <span><?php echo Configuration::$domain; ?>/<strong>{$lang.path_my_account}</strong></span>
                                        <input type="text" name="path" placeholder="{$lang.path}">
                                    </fieldset>
                                </div>
                                <div class="span6">
                                    <fieldset>
                                        <select name="type">
                                            <option value="" selected hidden>{$lang.type}</option>
                                            <option value="hotel">{$lang.hotel}</option>
                                            <option value="restaurant">{$lang.restaurant}</option>
                                        </select>
                                    </fieldset>
                                </div>
                                <div class="span3 hidden">
                                    <fieldset>
                                        <input type="number" name="rooms_number" placeholder="{$lang.n_rooms}" min="1">
                                    </fieldset>
                                </div>
                                <div class="span3 hidden">
                                    <fieldset>
                                        <input type="number" name="tables_number" placeholder="{$lang.n_tables}" min="1">
                                    </fieldset>
                                </div>
                                <div class="span3">
                                    <fieldset>
                                        <input type="text" name="zip_code" placeholder="{$lang.zip_code}">
                                    </fieldset>
                                </div>
                                <div class="span3">
                                    <fieldset>
                                        <select name="country">
                                            <option value="" selected hidden>{$lang.country}</option>
                                            {$opt_countries}
                                        </select>
                                    </fieldset>
                                </div>
                                <div class="span3">
                                    <fieldset>
                                        <input type="text" name="city" placeholder="{$lang.city}">
                                    </fieldset>
                                </div>
                                <div class="span9">
                                    <fieldset>
                                        <input type="text" name="address" placeholder="{$lang.address}">
                                    </fieldset>
                                </div>
                                <div class="span4">
                                    <fieldset>
                                        <select name="time_zone">
                                            <option value="" selected hidden>{$lang.time_zone}</option>
                                            {$opt_time_zones}
                                        </select>
                                    </fieldset>
                                </div>
                                <div class="span4">
                                    <fieldset>
                                        <select name="currency">
                                            <option value="" selected hidden>{$lang.currency}</option>
                                            {$opt_currencies}
                                        </select>
                                    </fieldset>
                                </div>
                                <div class="span4">
                                    <fieldset>
                                        <select name="language">
                                            <option value="" selected hidden>{$lang.language}</option>
                                            {$opt_languages}
                                        </select>
                                    </fieldset>
                                </div>
                                <!-- <div class="span12 hidden">
                                    <div id="map" class="map"></div>
                                </div> -->
                            </div>
                            <div class="span3">
                                <label>
                                    <div class="package" id="operation">
                                        <span><i class="fas fa-users"></i></span>
                                        <h3>{$lang.solution_of} <span>{$lang.operation}</span></h3>
                                        <h4><span><?php echo Functions::get_formatted_currency(0, 'MXN'); ?></span> {$lang.per_month}</h4>
                                        <input type="checkbox" name="operation">
                                        <p>* {$lang.no_charge_generated_demo}</p>
                                    </div>
                                </label>
                            </div>
                            <div class="span3">
                                <label>
                                    <div class="package" id="reputation">
                                        <span><i class="fas fa-smile"></i></span>
                                        <h3>{$lang.solution_of} <span>{$lang.reputation}</span></h3>
                                        <h4><span><?php echo Functions::get_formatted_currency(0, 'MXN'); ?></span> {$lang.per_month}</h4>
                                        <input type="checkbox" name="reputation">
                                        <p>* {$lang.no_charge_generated_demo}</p>
                                    </div>
                                </label>
                            </div>
                        </div>
                        <a class="btn" data-action="go_to_step">{$lang.next}</a>
                        <a button-cancel>{$lang.cancel}</a>
                    </div>
                    <div class="step-container" data-step="2">
                        <h2>{$lang.step_2}: {$lang.logotype}</h2>
                        <div class="row">
                            <div class="span6">
                                <div class="uploader">
                                    <fieldset>
                                        <figure>
                                            <img src="{$path.images}empty.png" alt="Account logotype">
                                            <a><i class="fas fa-upload"></i></a>
                                            <input type="file" name="logotype" accept="image/*">
                                        </figure>
                                    </fieldset>
                                </div>
                            </div>
                        </div>
                        <a class="btn" data-action="go_to_step">{$lang.next}</a>
                        <a button-cancel>{$lang.cancel}</a>
                    </div>
                    <div class="step-container" data-step="3">
                        <h2>{$lang.step_3}: {$lang.billing_information}</h2>
                        <div class="row">
                            <div class="span6">
                                <div class="span6">
                                    <fieldset>
                                        <input type="text" name="fiscal_id" placeholder="{$lang.fiscal_id}">
                                    </fieldset>
                                </div>
                                <div class="span6">
                                    <fieldset>
                                        <input type="text" name="fiscal_name" placeholder="{$lang.fiscal_name}">
                                    </fieldset>
                                </div>
                                <div class="span12">
                                    <fieldset>
                                        <input type="text" name="fiscal_address" placeholder="{$lang.fiscal_address}">
                                    </fieldset>
                                </div>
                                <div class="span6">
                                    <fieldset>
                                        <input type="text" name="contact_firstname" placeholder="{$lang.firstname}">
                                    </fieldset>
                                </div>
                                <div class="span6">
                                    <fieldset>
                                        <input type="text" name="contact_lastname" placeholder="{$lang.lastname}">
                                    </fieldset>
                                </div>
                                <div class="span12">
                                    <fieldset>
                                        <input type="text" name="contact_department" placeholder="{$lang.department}">
                                    </fieldset>
                                </div>
                                <div class="span6">
                                    <fieldset>
                                        <input type="email" name="contact_email" placeholder="{$lang.email}">
                                    </fieldset>
                                </div>
                                <div class="span3">
                                    <fieldset>
                                        <select name="contact_phone_lada">
                                            <option value="" selected hidden>{$lang.lada}</option>
                                            {$opt_ladas}
                                        </select>
                                    </fieldset>
                                </div>
                                <div class="span3">
                                    <fieldset>
                                        <input type="text" name="contact_phone_number" placeholder="{$lang.phone}">
                                    </fieldset>
                                </div>
                            </div>
                        </div>
                        <a class="btn" data-action="go_to_step">{$lang.next}</a>
                        <a button-cancel>{$lang.cancel}</a>
                    </div>
                    <div class="step-container" data-step="4">
                        <h2>{$lang.step_4}: {$lang.admin_information}</h2>
                        <div class="row">
                            <div class="span6">
                                <div class="span6">
                                    <fieldset>
                                        <input type="text" name="firstname" placeholder="{$lang.firstname}">
                                    </fieldset>
                                </div>
                                <div class="span6">
                                    <fieldset>
                                        <input type="text" name="lastname" placeholder="{$lang.lastname}">
                                    </fieldset>
                                </div>
                                <div class="span6">
                                    <fieldset>
                                        <input type="email" name="email" placeholder="{$lang.email}">
                                    </fieldset>
                                </div>
                                <div class="span3">
                                    <fieldset>
                                        <select name="phone_lada">
                                            <option value="" selected hidden>{$lang.lada}</option>
                                            {$opt_ladas}
                                        </select>
                                    </fieldset>
                                </div>
                                <div class="span3">
                                    <fieldset>
                                        <input type="text" name="phone_number" placeholder="{$lang.phone}">
                                    </fieldset>
                                </div>
                                <div class="span6">
                                    <fieldset>
                                        <input type="text" name="username" placeholder="{$lang.username}">
                                    </fieldset>
                                </div>
                                <div class="span6">
                                    <fieldset>
                                        <input type="password" name="password" placeholder="{$lang.password}">
                                    </fieldset>
                                </div>
                            </div>
                        </div>
                        <a class="btn" data-action="go_to_step">{$lang.next}</a>
                        <a button-cancel>{$lang.cancel}</a>
                    </div>
                    <div class="step-container" data-step="5">
                        <h2>{$lang.step_5}: {$lang.payment_information}</h2>
                        <div class="row">
                            <div class="span6">
                                <div class="package" id="total">
                                    <span><i class="fas fa-credit-card"></i></span>
                                    <h3>{$lang.total}</h3>
                                    <h4><span></span> {$lang.per_month}</h4>
                                    <p>* {$lang.no_charge_generated_demo}</p>
                                </div>
                                <!-- <div class="payment">
                                    <fieldset>
                                        <label>
                                            <figure>
                                                <img src="{$path.images}mastercard_visa.png" alt="Payment logotype">
                                            </figure>
                                            <input type="radio" name="payment" value="card" checked>
                                        </label>
                                    </fieldset>
                                    <fieldset>
                                        <label>
                                            <figure>
                                                <img src="{$path.images}mercado_pago.png" alt="Payment logotype">
                                            </figure>
                                            <input type="radio" name="payment" value="mercado_pago">
                                        </label>
                                    </fieldset>
                                    <fieldset>
                                        <label>
                                            <figure>
                                                <img src="{$path.images}paypal.png" alt="Payment logotype">
                                            </figure>
                                            <input type="radio" name="payment" value="paypal">
                                        </label>
                                    </fieldset>
                                </div> -->
                                <!-- <fieldset>
                                    <input type="text" name="promotional_code" placeholder="{$lang.apply_promotional_code}">
                                </fieldset> -->
                            </div>
                        </div>
                        <p>* {$lang.signup_accept_terms} <a href="/terms" target="_blank">{$lang.terms_conditions}</a></p>
                        <a class="btn" data-action="go_to_step">{$lang.start_demo}</a>
                        <a button-cancel>{$lang.cancel}</a>
                    </div>
                    <div class="step-container" data-step="6">
                        <div class="row">
                            <div class="span6">
                                <div class="success">
                                    <figure>
                                        <img src="{$path.images}check_color.png" alt="Check icon">
                                    </figure>
                                    <p id="success"></p>
                                </div>
                            </div>
                        </div>
                        <figure>
                            <img src="{$path.images}load.gif" alt="Load gif">
                            <span>{$lang.redirect_to} <?php echo Configuration::$domain; ?></span>
                        </figure>
                    </div>
                </div>
            </form>
        </main>
    </div>
</section>
<section class="modal fullscreen" data-modal="login">
    <div class="content">
        <main>
            <form name="login">
                <figure>
                    <img src="{$path.images}icon-color.svg" alt="GuestVox icontype">
                </figure>
                <fieldset>
                    <input type="text" name="username" placeholder="{$lang.username_or_email}" />
                </fieldset>
                <fieldset>
                    <input type="password" name="password" placeholder="{$lang.password}" />
                </fieldset>
                <a class="btn" data-action="login">{$lang.login}</a>
                <a button-cancel>{$lang.cancel}</a>
            </form>
        </main>
    </div>
</section>
