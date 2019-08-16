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
        <nav class="resoff">
            <a href="https://blog.guestvox.com" class="btn no-border">{$lang.our_blog}</a>
            <a data-button-modal="signup" class="btn">{$lang.signup}</a>
            <a data-button-modal="login" class="btn">{$lang.login}</a>
            <a href="?<?php if (Session::get_value('lang') == 'es') { $lang = 'en'; } else if (Session::get_value('lang') == 'en') { $lang = 'es'; } echo Language::get_lang_url($lang); ?>" class="btn no-border">{$lang.<?php echo $lang ?>}</a>
        </nav>
        <nav class="reson">
            <a class="btn" data-open-resoff><i class="fas fa-bars"></i></a>
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
    <section class="ceo">
        <div>
            <figure>
                <img src="{$path.images}basurto.png" alt="">
            </figure>
        </div>
        <span><strong>Daniel Basurto</strong></span>
        <span>{$lang.ceo_founder}</span>
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
                        <a class="view"><img src="{$path.images}icon-white.svg" alt="Logotype"></a>
                        <a class="active">1</a>
                        <a>2</a>
                        <a>3</a>
                        <a>4</a>
                        <a>5</a>
                        <a><i class="fas fa-check"></i></a>
                    </div>
                    <div class="step-container active" data-step="1">
                        <h2>{$lang.step_1}: {$lang.account_information}</h2>
                        <div class="row">
                            <div class="span6">
                                <div class="span8">
                                    <div class="label">
                                        <label>
                                            <input type="text" name="hotel" placeholder="{$lang.hotel}">
                                        </label>
                                    </div>
                                </div>
                                <div class="span4">
                                    <div class="label">
                                        <label>
                                            <select name="currency">
                                                <option value="" selected hidden>{$lang.currency}</option>
                                                {$opt_currencies}
                                            </select>
                                        </label>
                                    </div>
                                </div>
                                <div class="span4">
                                    <div class="label">
                                        <label>
                                            <input type="number" name="rooms_number" placeholder="{$lang.n_rooms}">
                                        </label>
                                    </div>
                                </div>
                                <div class="span4">
                                    <div class="label">
                                        <label>
                                            <input type="number" name="users_number" placeholder="{$lang.n_users}">
                                        </label>
                                    </div>
                                </div>
                                <div class="span4">
                                    <div class="label">
                                        <label>
                                            <select name="language">
                                                <option value="" selected hidden>{$lang.language}</option>
                                                {$opt_languages}
                                            </select>
                                        </label>
                                    </div>
                                </div>
                                <div class="span4">
                                    <div class="label">
                                        <label>
                                            <input type="number" name="cp" placeholder="{$lang.cp}">
                                        </label>
                                    </div>
                                </div>
                                <div class="span4">
                                    <div class="label">
                                        <label>
                                            <select name="country">
                                                <option value="" selected hidden>{$lang.country}</option>
                                                {$opt_countries}
                                            </select>
                                        </label>
                                    </div>
                                </div>
                                <div class="span4">
                                    <div class="label">
                                        <label>
                                            <input type="text" name="city" placeholder="{$lang.city}">
                                        </label>
                                    </div>
                                </div>
                                <div class="span4">
                                    <div class="label">
                                        <label>
                                            <select name="time_zone">
                                                <option value="" selected hidden>{$lang.time_zone}</option>
                                                {$opt_time_zones}
                                            </select>
                                            <!-- <div data-select-select>
                                                <div data-select-preview>
                                                    <input type="text" name="time_zone" data-select-value>
                                                    <input type="text" placeholder="{$lang.time_zone}" data-select-typer>
                                                </div>
                                                <div data-select-search>
                                                    <a data-select-close>{$lang.close}</a>
                                                    {$opt_time_zones}
                                                </div>
                                            </div> -->
                                        </label>
                                    </div>
                                </div>
                                <div class="span8">
                                    <div class="label">
                                        <label>
                                            <input type="text" name="address" placeholder="{$lang.address}">
                                        </label>
                                    </div>
                                </div>
                                <div class="span12 hidden">
                                    <div class="label">
                                        <label>
                                            <div id="map" class="map"></div>
                                        </label>
                                    </div>
                                </div>
                            </div>
                            <div class="span3 hidden">
                                <article id="room_package" class="package">
                                    <span><i class="fas fa-star"></i></span>
                                    <h3><strong></strong> {$lang.rooms}</h3>
                                    <h4><strong></strong> {$lang.per_month}</h4>
                                </article>
                            </div>
                            <div class="span3 hidden">
                                <article id="user_package" class="package">
                                    <span><i class="fas fa-users"></i></span>
                                    <h3><strong></strong> {$lang.users}</h3>
                                    <h4><strong></strong> {$lang.per_month}</h4>
                                </article>
                            </div>
                        </div>
                        <a class="btn" data-action="go_to_step" data-step="2">{$lang.next}</a>
                    </div>
                    <div class="step-container" data-step="2">
                        <h2>{$lang.step_2}: {$lang.logotype}</h2>
                        <div class="label">
                            <div class="uploader">
                                <figure class="round big">
                                    <img src="{$path.images}empty.png" alt="Logotype">
                                    <a data-image-select><i class="fas fa-upload"></i></a>
                                </figure>
                                <input type="file" name="logotype" accept="image/*" data-image-upload>
                            </div>
                        </div>
                        <a class="btn" data-action="go_to_step" data-step="3">{$lang.next}</a>
                        <a class="btn skip" data-action="go_to_step" data-step="3">{$lang.skip}</a>
                    </div>
                    <div class="step-container" data-step="3">
                        <h2>{$lang.step_3}: {$lang.billing_information}</h2>
                        <div class="row">
                            <div class="span6">
                                <div class="span12">
                                    <div class="label">
                                        <h3><i class="fas fa-chevron-right"></i>{$lang.fiscal_information}</h3>
                                    </div>
                                </div>
                                <div class="span6">
                                    <div class="label">
                                        <label>
                                            <input type="text" name="fiscal_id" placeholder="{$lang.fiscal_id}">
                                        </label>
                                    </div>
                                </div>
                                <div class="span6">
                                    <div class="label">
                                        <label>
                                            <input type="text" name="fiscal_name" placeholder="{$lang.fiscal_name}">
                                        </label>
                                    </div>
                                </div>
                                <div class="span12">
                                    <div class="label">
                                        <label>
                                            <input type="text" name="fiscal_address" placeholder="{$lang.fiscal_address}">
                                        </label>
                                    </div>
                                </div>
                                <div class="span12">
                                    <div class="label">
                                        <h3><i class="fas fa-chevron-right"></i>{$lang.contact_information}</h3>
                                    </div>
                                </div>
                                <div class="span6">
                                    <div class="label">
                                        <label>
                                            <input type="text" name="contact_name" placeholder="{$lang.name}">
                                        </label>
                                    </div>
                                </div>
                                <div class="span6">
                                    <div class="label">
                                        <label>
                                            <input type="text" name="contact_department" placeholder="{$lang.department}">
                                        </label>
                                    </div>
                                </div>
                                <div class="span4">
                                    <div class="label">
                                        <label>
                                            <select name="contact_lada">
                                                <option value="" selected hidden>{$lang.lada}</option>
                                                {$opt_ladas}
                                            </select>
                                        </label>
                                    </div>
                                </div>
                                <div class="span8">
                                    <div class="label">
                                        <label>
                                            <input type="text" name="contact_phone_number" placeholder="{$lang.phone_number}">
                                        </label>
                                    </div>
                                </div>
                                <div class="span12">
                                    <div class="label">
                                        <label>
                                            <input type="email" name="contact_email" placeholder="{$lang.email}">
                                        </label>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <a data-action="go_to_step" data-step="4">{$lang.next}</a>
                    </div>
                    <div class="step-container" data-step="4">
                        <h2>{$lang.step_4}: {$lang.user_information}</h2>
                        <div class="row">
                            <div class="span6">
                                <div class="span6">
                                    <div class="label">
                                        <label>
                                            <input type="text" name="name" placeholder="{$lang.name}">
                                        </label>
                                    </div>
                                </div>
                                <div class="span6">
                                    <div class="label">
                                        <label>
                                            <input type="text" name="lastname" placeholder="{$lang.lastname}">
                                        </label>
                                    </div>
                                </div>
                                <div class="span4">
                                    <div class="label">
                                        <label>
                                            <select name="country_code">
                                                <option value="" selected hidden>{$lang.lada}</option>
                                                {$opt_ladas}
                                            </select>
                                        </label>
                                    </div>
                                </div>
                                <div class="span8">
                                    <div class="label">
                                        <label>
                                            <input type="text" name="phone_number" placeholder="{$lang.phone_number}">
                                        </label>
                                    </div>
                                </div>
                                <div class="span12">
                                    <div class="label">
                                        <label>
                                            <input type="email" name="email" placeholder="{$lang.email}">
                                        </label>
                                    </div>
                                </div>
                                <div class="separator"></div>
                                <div class="span6">
                                    <div class="label">
                                        <label>
                                            <input type="text" name="username" placeholder="{$lang.username}">
                                        </label>
                                    </div>
                                </div>
                                <div class="span6">
                                    <div class="label">
                                        <label>
                                            <input type="password" name="password" placeholder="{$lang.password}">
                                        </label>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <a data-action="go_to_step" data-step="5">{$lang.next}</a>
                    </div>
                    <div class="step-container" data-step="5">
                        <h2>{$lang.step_5}: {$lang.payment}</h2>
                        <div class="row">

                        </div>
                        <a data-action="signup">{$lang.signup}</a>
                    </div>
                </div>

                <!-- <div class="row">
                    <div class="span12">
                        <div class="label">
                            <label>
                                <select name="language">
                                    <option value="es" <?php if (Session::get_value('lang') == 'es') : echo 'selected'; endif; ?>>Español</option>
                                    <option value="en" <?php if (Session::get_value('lang') == 'en') : echo 'selected'; endif; ?>>English</option>
                                </select>
                                <p class="description">{$lang.language}</p>
                            </label>
                        </div>
                    </div>
                    <div class="span12">
                        <div class="label">
                            <label>
                                <input type="text" name="promotional_code" disabled>
                            </label>
                            <input type="checkbox" name="apply_promotional_code">
                            <span>{$lang.apply_promotional_code}</span>
                        </div>
                    </div>
                    <div class="separator"></div>
                </div> -->
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
                <div class="label">
                    <label>
                        <input type="text" name="username" placeholder="{$lang.username} {$lang.or} {$lang.email}" />
                    </label>
                </div>
                <div class="label">
                    <label>
                        <input type="password" name="password" placeholder="{$lang.password}" />
                    </label>
                </div>
                <button type="submit">{$lang.login}</button>
                <a button-close>{$lang.close}</a>
            </form>
        </main>
    </div>
</section>
