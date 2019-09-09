<?php

defined('_EXEC') or die;

$this->dependencies->add(['js', '{$path.js}Index/index.js']);
$this->dependencies->add(['other', '<script async defer src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBLCea8Q6BtcTHwY3YFCiB0EoHE5KnsMUE"></script>']);

?>

<header class="landing-page">
    <div class="container">
        <figure>
            <img src="{$path.images}logotype-white.png" alt="">
        </figure>
        <nav data-main-menu>
            <a href="https://blog.guestvox.com" class="btn no-border">{$lang.our_blog}</a>
            <a data-button-modal="signup" class="btn">{$lang.signup}</a>
            <a data-button-modal="login" class="btn">{$lang.login}</a>
            <a href="?<?php echo Language::get_lang_url(Functions::get_lang(true)); ?>" class="btn no-border">{$lang.<?php echo Functions::get_lang(true) ?>}</a>
        </nav>
        <nav>
            <a class="btn" data-open-main-menu><i class="fas fa-bars"></i></a>
        </nav>
    </div>
</header>
<main class="landing-page">
    <section class="home">
    	<div class="container">
    		<figure>
    			<img src="{$path.images}home.png" alt="">
    		</figure>
            <div>
    			<h4>{$lang.im_the_guests_voice}</h4>
    			<h1>{$lang.manages_correctly_the_incidents}</h1>
    		</div>
    	</div>
    </section>
    <section class="features">
    	<div class="container">
    		<h2>{$lang.how_do_we_help_your_hotel}</h2>
            <div class="item">
                <img src="/images/feature-1.svg" alt="">
                <p>{$lang.capture_all_kinds}</p>
            </div>
            <div class="item">
                <img src="/images/feature-2.svg" alt="">
                <p>{$lang.coordinate_follow_cases}</p>
            </div>
            <div class="item">
                <img src="/images/feature-3.svg" alt="">
                <p>{$lang.control_performance_your_hotel}</p>
            </div>
            <div class="item">
                <img src="/images/feature-4.svg" alt="">
                <p>{$lang.check_metrics_best_decisions}</p>
            </div>
    	</div>
    </section>
    <section class="features">
		<div class="list">
            <ul class="container">
                <li><i class="fas fa-check"></i>{$lang.multi_device}</li>
                <li><i class="fas fa-check"></i>{$lang.on_the_cloud}</li>
                <li><i class="fas fa-check"></i>{$lang.100_encrypted_safe}</li>
                <li><i class="fas fa-check"></i>{$lang.simple}</li>
                <li><a data-button-modal="signup" class="btn">{$lang.signup}</a></li>
            </ul>
        </div>
    </section>
    <section class="clients">
    	<div class="container">
    		<h2>{$lang.they_already_trust_us}</h2>
            <figure>
                <img src="{$path.images}clients.jpg" alt="">
            </figure>
            <a data-button-modal="signup" class="btn">{$lang.signup}</a>
    	</div>
    </section>
    <section class="team">
        <div class="item">
            <div>
                <figure>
                    <img src="{$path.images}basurto.png" alt="">
                </figure>
            </div>
            <span><strong>Daniel Basurto</strong></span>
            <span>{$lang.ceo_founder}</span>
        </div>
        <div class="item">
            <div>
                <figure>
                    <img src="{$path.images}gerson.png" alt="">
                </figure>
            </div>
            <span><strong>Gersón Gómez</strong></span>
            <span>{$lang.cto}</span>
        </div>
        <div class="item">
            <div>
                <figure>
                    <img src="{$path.images}saul.png" alt="">
                </figure>
            </div>
            <span><strong>Saúl Poot</strong></span>
            <span>{$lang.chief_programmer}</span>
        </div>
    </section>
</main>
<footer class="landing-page">
    <div class="container">
        <nav>
            <a data-button-modal="login" class="btn">{$lang.login}</a>
            <a href="https://facebook.com/guestvox" class="btn" target="_blank"><i class="fab fa-facebook-square"></i></a>
            <a href="https://instagram.com/guestvox" class="btn" target="_blank"><i class="fab fa-instagram"></i></a>
            <a href="https://linkedin.com/guestvox" class="btn" target="_blank"><i class="fab fa-linkedin"></i></a>
            <a href="https://www.youtube.com/channel/UCKSAce4n1NqahbL5RQ8QN9Q" class="btn" target="_blank"><i class="fab fa-youtube" ></i></i></a>
            <a href="" class="btn no-border">{$lang.copyright}</a>
        </nav>
        <figure>
            <img src="{$path.images}logotype-color.png" alt="">
        </figure>
    </div>
</footer>
<section class="modal fullscreen" data-modal="signup">
    <div class="content">
        <main>
            <form name="signup">
                <div class="steps">
                    <div class="step-buttons">
                        <a class="view"><img src="{$path.images}icon-white.svg" alt=""></a>
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
                                        <input type="text" name="hotel" placeholder="{$lang.hotel}">
                                    </fieldset>
                                </div>
                                <div class="span3">
                                    <fieldset>
                                        <input type="number" name="rooms_number" placeholder="{$lang.n_rooms}" min="1">
                                    </fieldset>
                                </div>
                                <div class="span3">
                                    <fieldset>
                                        <input type="number" name="users_number" placeholder="{$lang.n_users}" min="1">
                                    </fieldset>
                                </div>
                                <div class="span4">
                                    <fieldset>
                                        <select name="country">
                                            <option value="" selected hidden>{$lang.country}</option>
                                            {$opt_countries}
                                        </select>
                                    </fieldset>
                                </div>
                                <div class="span4">
                                    <fieldset>
                                        <input type="text" name="cp" placeholder="{$lang.cp}">
                                    </fieldset>
                                </div>
                                <div class="span4">
                                    <fieldset>
                                        <input type="text" name="city" placeholder="{$lang.city}">
                                    </fieldset>
                                </div>
                                <div class="span12">
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
                                        <select name="language">
                                            <option value="" selected hidden>{$lang.language}</option>
                                            {$opt_languages}
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
                                <!-- <div class="span12 hidden">
                                    <div id="map" class="map"></div>
                                </div> -->
                            </div>
                            <div class="span3 hidden">
                                <div class="package" id="room_package">
                                    <span><i class="fas fa-star"></i></span>
                                    <h3><strong></strong> {$lang.rooms}</h3>
                                    <h4><strong></strong> {$lang.per_month}</h4>
                                </div>
                            </div>
                            <div class="span3 hidden">
                                <div class="package" id="user_package">
                                    <span><i class="fas fa-users"></i></span>
                                    <h3><strong></strong> {$lang.users}</h3>
                                    <h4><strong></strong> {$lang.per_month}</h4>
                                </div>
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
                                            <img src="{$path.images}empty.png" alt="" data-image-preview>
                                            <a data-image-select><i class="fas fa-upload"></i></a>
                                        </figure>
                                        <input type="file" name="logotype" accept="image/*" data-image-upload>
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
                                        <input type="text" name="contact_name" placeholder="{$lang.contact}">
                                    </fieldset>
                                </div>
                                <div class="span6">
                                    <fieldset>
                                        <input type="text" name="department" placeholder="{$lang.department}">
                                    </fieldset>
                                </div>
                                <div class="span4">
                                    <fieldset>
                                        <select name="contact_lada">
                                            <option value="" selected hidden>{$lang.lada}</option>
                                            {$opt_ladas}
                                        </select>
                                    </fieldset>
                                </div>
                                <div class="span8">
                                    <fieldset>
                                        <input type="text" name="contact_phone" placeholder="{$lang.phone}">
                                    </fieldset>
                                </div>
                                <div class="span12">
                                    <fieldset>
                                        <input type="email" name="contact_email" placeholder="{$lang.email}">
                                    </fieldset>
                                </div>
                            </div>
                        </div>
                        <a class="btn" data-action="go_to_step">{$lang.next}</a>
                        <a button-cancel>{$lang.cancel}</a>
                    </div>
                    <div class="step-container" data-step="4">
                        <h2>{$lang.step_4}: {$lang.user_information}</h2>
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
                                <div class="span4">
                                    <fieldset>
                                        <select name="lada">
                                            <option value="" selected hidden>{$lang.lada}</option>
                                            {$opt_ladas}
                                        </select>
                                    </fieldset>
                                </div>
                                <div class="span8">
                                    <fieldset>
                                        <input type="text" name="phone" placeholder="{$lang.phone}">
                                    </fieldset>
                                </div>
                                <div class="span12">
                                    <fieldset>
                                        <input type="email" name="email" placeholder="{$lang.email}">
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
                                <div class="package" id="total_package">
                                    <span><i class="fas fa-credit-card"></i></span>
                                    <h3>{$lang.total}</h3>
                                    <h4><strong></strong> {$lang.per_month}</h4>
                                </div>
                                <div class="payment">
                                    <fieldset>
                                        <label>
                                            <figure>
                                                <img src="{$path.images}mastercard_visa.png" alt="">
                                            </figure>
                                            <input type="radio" name="payment" value="card" checked>
                                        </label>
                                    </fieldset>
                                    <fieldset>
                                        <label>
                                            <figure>
                                                <img src="{$path.images}mercado_pago.png" alt="">
                                            </figure>
                                            <input type="radio" name="payment" value="mercado_pago">
                                        </label>
                                    </fieldset>
                                    <fieldset>
                                        <label>
                                            <figure>
                                                <img src="{$path.images}paypal.png" alt="">
                                            </figure>
                                            <input type="radio" name="payment" value="paypal">
                                        </label>
                                    </fieldset>
                                </div>
                                <fieldset>
                                    <input type="text" name="promotional_code" placeholder="{$lang.apply_promotional_code}">
                                </fieldset>
                            </div>
                        </div>
                        <a class="btn" data-action="go_to_step">{$lang.next}</a>
                        <a button-cancel>{$lang.cancel}</a>
                    </div>
                    <div class="step-container" data-step="6">
                        <div class="row">
                            <div class="span6">
                                <div class="success">
                                    <figure>
                                        <img src="{$path.images}check_color.png" alt="">
                                    </figure>
                                    <p id="success-step-message"></p>
                                </div>
                            </div>
                        </div>
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
                    <img src="{$path.images}icon-color.svg" alt="">
                </figure>
                <fieldset>
                    <input type="text" name="username" placeholder="{$lang.username_or_email}" />
                </fieldset>
                <fieldset>
                    <input type="password" name="password" placeholder="{$lang.password}" />
                </fieldset>
                <a class="btn" data-action="login">{$lang.next}</a>
                <a button-cancel>{$lang.cancel}</a>
            </form>
        </main>
    </div>
</section>
