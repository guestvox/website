<?php

defined('_EXEC') or die;

$this->dependencies->add(['js', '{$path.js}Index/index.js']);

?>

<header class="landing-page">
    <div class="container">
        <figure>
            <img src="{$path.images}logotype-white.png" alt="">
        </figure>
        <nav class="resoff">
            <a href="https://blog.guestvox.com" class="btn no-border">{$lang.our_blog}</a>
            <a data-button-modal="signup" class="btn">{$lang.signup_free}</a>
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
                <li><a data-button-modal="signup" class="btn">{$lang.signup_free}</a></li>
            </ul>
        </div>
    </section>
    <section class="clients">
    	<div class="container">
    		<h2>{$lang.they_already_trust_us}</h2>
            <figure>
                <img src="{$path.images}clients.jpg" alt="">
            </figure>
            <a data-button-modal="signup" class="btn">{$lang.signup_free}</a>
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
<section class="modal fullscreen" data-modal="signup">
    <div class="content">
        <main>
            <form name="signup">
                <figure>
                    <img src="{$path.images}icon-color.svg" alt="">
                </figure>
                <div class="row">
                    <div class="span12">
                        <div class="label">
                            <label>
                                <input type="text" name="account">
                                <p class="description">{$lang.hotel}</p>
                            </label>
                        </div>
                    </div>
                    <div class="separator"></div>
                    <div class="span6">
                        <div class="label">
                            <label>
                                <input type="text" name="name">
                                <p class="description">{$lang.name}</p>
                            </label>
                        </div>
                    </div>
                    <div class="span6">
                        <div class="label">
                            <label>
                                <input type="text" name="lastname">
                                <p class="description">{$lang.lastname}</p>
                            </label>
                        </div>
                    </div>
                    <div class="span12">
                        <div class="label">
                            <label>
                                <input type="email" name="email">
                                <p class="description">{$lang.email}</p>
                            </label>
                        </div>
                    </div>
                    <div class="span12">
                        <div class="label">
                            <label>
                                <input type="text" name="cellphone">
                                <p class="description">{$lang.cellphone}</p>
                            </label>
                        </div>
                    </div>
                    <div class="separator"></div>
                    <div class="span6">
                        <div class="label">
                            <label>
                                <input type="text" name="username">
                                <p class="description">{$lang.username}</p>
                            </label>
                        </div>
                    </div>
                    <div class="span6">
                        <div class="label">
                            <label>
                                <input type="password" name="password">
                                <p class="description">{$lang.password}</p>
                            </label>
                        </div>
                    </div>
                    <div class="separator"></div>
                    <div class="span12">
                        <div class="label">
                            <label>
                                <div data-select>
                                    <div data-preview>
                                        <input type="text" name="time_zone" data-typer>
                                    </div>
                                    <div data-search>
                                        <span>América</span>
                                        <a><span data-zone>America/Adak</span><span data-hour></span></a>
                                        <a><span data-zone>America/Anchorage</span><span data-hour></span></a>
                                        <a><span data-zone>America/Anguilla</span><span data-hour></span></a>
                                        <a><span data-zone>America/Antigua</span><span data-hour></span></a>
                                        <a><span data-zone>America/Araguaina</span><span data-hour></span></a>
                                        <a><span data-zone>America/Argentina/Buenos_Aires</span><span data-hour></span></a>
                                        <a><span data-zone>America/Argentina/Catamarca</span><span data-hour></span></a>
                                        <a><span data-zone>America/Argentina/Cordoba</span><span data-hour></span></a>
                                        <a><span data-zone>America/Argentina/Jujuy</span><span data-hour></span></a>
                                        <a><span data-zone>America/Argentina/La_Rioja</span><span data-hour></span></a>
                                        <a><span data-zone>America/Argentina/Mendoza</span><span data-hour></span></a>
                                        <a><span data-zone>America/Argentina/Rio_Gallegos</span><span data-hour></span></a>
                                        <a><span data-zone>America/Argentina/Salta</span><span data-hour></span></a>
                                        <a><span data-zone>America/Argentina/San_Juan</span><span data-hour></span></a>
                                        <a><span data-zone>America/Argentina/San_Luis</span><span data-hour></span></a>
                                        <a><span data-zone>America/Argentina/Tucuman</span><span data-hour></span></a>
                                        <a><span data-zone>America/Argentina/Ushuaia</span><span data-hour></span></a>
                                        <a><span data-zone>America/Aruba</span><span data-hour></span></a>
                                        <a><span data-zone>America/Asuncion</span><span data-hour></span></a>
                                        <a><span data-zone>America/Atikokan</span><span data-hour></span></a>
                                        <a><span data-zone>America/Bahia</span><span data-hour></span></a>
                                        <a><span data-zone>America/Bahia_Banderas</span><span data-hour></span></a>
                                        <a><span data-zone>America/Barbados</span><span data-hour></span></a>
                                        <a><span data-zone>America/Belem</span><span data-hour></span></a>
                                        <a><span data-zone>America/Belize</span><span data-hour></span></a>
                                        <a><span data-zone>America/Blanc-Sablon</span><span data-hour></span></a>
                                        <a><span data-zone>America/Boa_Vista</span><span data-hour></span></a>
                                        <a><span data-zone>America/Bogota</span><span data-hour></span></a>
                                        <a><span data-zone>America/Boise</span><span data-hour></span></a>
                                        <a><span data-zone>America/Cambridge_Bay</span><span data-hour></span></a>
                                        <a><span data-zone>America/Campo_Grande</span><span data-hour></span></a>
                                        <a><span data-zone>America/Cancun</span><span data-hour></span></a>
                                        <a><span data-zone>America/Caracas</span><span data-hour></span></a>
                                        <a><span data-zone>America/Cayenne</span><span data-hour></span></a>
                                        <a><span data-zone>America/Cayman</span><span data-hour></span></a>
                                        <a><span data-zone>America/Chicago</span><span data-hour></span></a>
                                        <a><span data-zone>America/Chihuahua</span><span data-hour></span></a>
                                        <a><span data-zone>America/Costa_Rica</span><span data-hour></span></a>
                                        <a><span data-zone>America/Creston</span><span data-hour></span></a>
                                        <a><span data-zone>America/Cuiaba</span><span data-hour></span></a>
                                        <a><span data-zone>America/Curacao</span><span data-hour></span></a>
                                        <a><span data-zone>America/Danmarkshavn</span><span data-hour></span></a>
                                        <a><span data-zone>America/Dawson</span><span data-hour></span></a>
                                        <a><span data-zone>America/Dawson_Creek</span><span data-hour></span></a>
                                        <a><span data-zone>America/Denver</span><span data-hour></span></a>
                                        <a><span data-zone>America/Detroit</span><span data-hour></span></a>
                                        <a><span data-zone>America/Dominica</span><span data-hour></span></a>
                                        <a><span data-zone>America/Edmonton</span><span data-hour></span></a>
                                        <a><span data-zone>America/Eirunepe</span><span data-hour></span></a>
                                        <a><span data-zone>America/El_Salvador</span><span data-hour></span></a>
                                        <a><span data-zone>America/Fort_Nelson</span><span data-hour></span></a>
                                        <a><span data-zone>America/Fortaleza</span><span data-hour></span></a>
                                        <a><span data-zone>America/Glace_Bay</span><span data-hour></span></a>
                                        <a><span data-zone>America/Godthab</span><span data-hour></span></a>
                                        <a><span data-zone>America/Goose_Bay</span><span data-hour></span></a>
                                        <a><span data-zone>America/Grand_Turk</span><span data-hour></span></a>
                                        <a><span data-zone>America/Grenada</span><span data-hour></span></a>
                                        <a><span data-zone>America/Guadeloupe</span><span data-hour></span></a>
                                        <a><span data-zone>America/Guatemala</span><span data-hour></span></a>
                                        <a><span data-zone>America/Guayaquil</span><span data-hour></span></a>
                                        <a><span data-zone>America/Guyana</span><span data-hour></span></a>
                                        <a><span data-zone>America/Halifax</span><span data-hour></span></a>
                                        <a><span data-zone>America/Havana</span><span data-hour></span></a>
                                        <a><span data-zone>America/Hermosillo</span><span data-hour></span></a>
                                        <a><span data-zone>America/Indiana/Indianapolis</span><span data-hour></span></a>
                                        <a><span data-zone>America/Indiana/Knox</span><span data-hour></span></a>
                                        <a><span data-zone>America/Indiana/Marengo</span><span data-hour></span></a>
                                        <a><span data-zone>America/Indiana/Petersburg</span><span data-hour></span></a>
                                        <a><span data-zone>America/Indiana/Tell_City</span><span data-hour></span></a>
                                        <a><span data-zone>America/Indiana/Vevay</span><span data-hour></span></a>
                                        <a><span data-zone>America/Indiana/Vincennes</span><span data-hour></span></a>
                                        <a><span data-zone>America/Indiana/Winamac</span><span data-hour></span></a>
                                        <a><span data-zone>America/Inuvik</span><span data-hour></span></a>
                                        <a><span data-zone>America/Iqaluit</span><span data-hour></span></a>
                                        <a><span data-zone>America/Jamaica</span><span data-hour></span></a>
                                        <a><span data-zone>America/Juneau</span><span data-hour></span></a>
                                        <a><span data-zone>America/Kentucky/Louisville</span><span data-hour></span></a>
                                        <a><span data-zone>America/Kentucky/Monticello</span><span data-hour></span></a>
                                        <a><span data-zone>America/Kralendijk</span><span data-hour></span></a>
                                        <a><span data-zone>America/La_Paz</span><span data-hour></span></a>
                                        <a><span data-zone>America/Lima</span><span data-hour></span></a>
                                        <a><span data-zone>America/Los_Angeles</span><span data-hour></span></a>
                                        <a><span data-zone>America/Lower_Princes</span><span data-hour></span></a>
                                        <a><span data-zone>America/Maceio</span><span data-hour></span></a>
                                        <a><span data-zone>America/Managua</span><span data-hour></span></a>
                                        <a><span data-zone>America/Manaus</span><span data-hour></span></a>
                                        <a><span data-zone>America/Marigot</span><span data-hour></span></a>
                                        <a><span data-zone>America/Martinique</span><span data-hour></span></a>
                                        <a><span data-zone>America/Matamoros</span><span data-hour></span></a>
                                        <a><span data-zone>America/Mazatlan</span><span data-hour></span></a>
                                        <a><span data-zone>America/Menominee</span><span data-hour></span></a>
                                        <a><span data-zone>America/Merida</span><span data-hour></span></a>
                                        <a><span data-zone>America/Metlakatla</span><span data-hour></span></a>
                                        <a><span data-zone>America/Mexico_City</span><span data-hour></span></a>
                                        <a><span data-zone>America/Miquelon</span><span data-hour></span></a>
                                        <a><span data-zone>America/Moncton</span><span data-hour></span></a>
                                        <a><span data-zone>America/Monterrey</span><span data-hour></span></a>
                                        <a><span data-zone>America/Montevideo</span><span data-hour></span></a>
                                        <a><span data-zone>America/Montserrat</span><span data-hour></span></a>
                                        <a><span data-zone>America/Nassau</span><span data-hour></span></a>
                                        <a><span data-zone>America/New_York</span><span data-hour></span></a>
                                        <a><span data-zone>America/Nipigon</span><span data-hour></span></a>
                                        <a><span data-zone>America/Nome</span><span data-hour></span></a>
                                        <a><span data-zone>America/Noronha</span><span data-hour></span></a>
                                        <a><span data-zone>America/North_Dakota/Beulah</span><span data-hour></span></a>
                                        <a><span data-zone>America/North_Dakota/Center</span><span data-hour></span></a>
                                        <a><span data-zone>America/North_Dakota/New_Salem</span><span data-hour></span></a>
                                        <a><span data-zone>America/Ojinaga</span><span data-hour></span></a>
                                        <a><span data-zone>America/Panama</span><span data-hour></span></a>
                                        <a><span data-zone>America/Pangnirtung</span><span data-hour></span></a>
                                        <a><span data-zone>America/Paramaribo</span><span data-hour></span></a>
                                        <a><span data-zone>America/Phoenix</span><span data-hour></span></a>
                                        <a><span data-zone>America/Port-au-Prince</span><span data-hour></span></a>
                                        <a><span data-zone>America/Port_of_Spain</span><span data-hour></span></a>
                                        <a><span data-zone>America/Porto_Velho</span><span data-hour></span></a>
                                        <a><span data-zone>America/Puerto_Rico</span><span data-hour></span></a>
                                        <a><span data-zone>America/Punta_Arenas</span><span data-hour></span></a>
                                        <a><span data-zone>America/Rainy_River</span><span data-hour></span></a>
                                        <a><span data-zone>America/Rankin_Inlet</span><span data-hour></span></a>
                                        <a><span data-zone>America/Recife</span><span data-hour></span></a>
                                        <a><span data-zone>America/Regina</span><span data-hour></span></a>
                                        <a><span data-zone>America/Resolute</span><span data-hour></span></a>
                                        <a><span data-zone>America/Rio_Branco</span><span data-hour></span></a>
                                        <a><span data-zone>America/Santarem</span><span data-hour></span></a>
                                        <a><span data-zone>America/Santiago</span><span data-hour></span></a>
                                        <a><span data-zone>America/Santo_Domingo</span><span data-hour></span></a>
                                        <a><span data-zone>America/Sao_Paulo</span><span data-hour></span></a>
                                        <a><span data-zone>America/Scoresbysund</span><span data-hour></span></a>
                                        <a><span data-zone>America/Sitka</span><span data-hour></span></a>
                                        <a><span data-zone>America/St_Barthelemy</span><span data-hour></span></a>
                                        <a><span data-zone>America/St_Johns</span><span data-hour></span></a>
                                        <a><span data-zone>America/St_Kitts</span><span data-hour></span></a>
                                        <a><span data-zone>America/St_Lucia</span><span data-hour></span></a>
                                        <a><span data-zone>America/St_Thomas</span><span data-hour></span></a>
                                        <a><span data-zone>America/St_Vincent</span><span data-hour></span></a>
                                        <a><span data-zone>America/Swift_Current</span><span data-hour></span></a>
                                        <a><span data-zone>America/Tegucigalpa</span><span data-hour></span></a>
                                        <a><span data-zone>America/Thule</span><span data-hour></span></a>
                                        <a><span data-zone>America/Thunder_Bay</span><span data-hour></span></a>
                                        <a><span data-zone>America/Tijuana</span><span data-hour></span></a>
                                        <a><span data-zone>America/Toronto</span><span data-hour></span></a>
                                        <a><span data-zone>America/Tortola</span><span data-hour></span></a>
                                        <a><span data-zone>America/Vancouver</span><span data-hour></span></a>
                                        <a><span data-zone>America/Whitehorse</span><span data-hour></span></a>
                                        <a><span data-zone>America/Winnipeg</span><span data-hour></span></a>
                                        <a><span data-zone>America/Yakutat</span><span data-hour></span></a>
                                        <a><span data-zone>America/Yellowknife</span><span data-hour></span></a>
                                        <span>África</span>
                                        <a><span data-zone>Africa/Abidjan</span><span data-hour></span></a>
                                        <a><span data-zone>Africa/Accra</span><span data-hour></span></a>
                                        <a><span data-zone>Africa/Addis_Ababa</span><span data-hour></span></a>
                                        <a><span data-zone>Africa/Algiers</span><span data-hour></span></a>
                                        <a><span data-zone>Africa/Asmara</span><span data-hour></span></a>
                                        <a><span data-zone>Africa/Bamako</span><span data-hour></span></a>
                                        <a><span data-zone>Africa/Bangui</span><span data-hour></span></a>
                                        <a><span data-zone>Africa/Banjul</span><span data-hour></span></a>
                                        <a><span data-zone>Africa/Bissau</span><span data-hour></span></a>
                                        <a><span data-zone>Africa/Blantyre</span><span data-hour></span></a>
                                        <a><span data-zone>Africa/Brazzaville</span><span data-hour></span></a>
                                        <a><span data-zone>Africa/Bujumbura</span><span data-hour></span></a>
                                        <a><span data-zone>Africa/Cairo</span><span data-hour></span></a>
                                        <a><span data-zone>Africa/Casablanca</span><span data-hour></span></a>
                                        <a><span data-zone>Africa/Ceuta</span><span data-hour></span></a>
                                        <a><span data-zone>Africa/Conakry</span><span data-hour></span></a>
                                        <a><span data-zone>Africa/Dakar</span><span data-hour></span></a>
                                        <a><span data-zone>Africa/Dar_es_Salaam</span><span data-hour></span></a>
                                        <a><span data-zone>Africa/Djibouti</span><span data-hour></span></a>
                                        <a><span data-zone>Africa/Douala</span><span data-hour></span></a>
                                        <a><span data-zone>Africa/El_Aaiun</span><span data-hour></span></a>
                                        <a><span data-zone>Africa/Freetown</span><span data-hour></span></a>
                                        <a><span data-zone>Africa/Gaborone</span><span data-hour></span></a>
                                        <a><span data-zone>Africa/Harare</span><span data-hour></span></a>
                                        <a><span data-zone>Africa/Johannesburg</span><span data-hour></span></a>
                                        <a><span data-zone>Africa/Juba</span><span data-hour></span></a>
                                        <a><span data-zone>Africa/Kampala</span><span data-hour></span></a>
                                        <a><span data-zone>Africa/Khartoum</span><span data-hour></span></a>
                                        <a><span data-zone>Africa/Kigali</span><span data-hour></span></a>
                                        <a><span data-zone>Africa/Kinshasa</span><span data-hour></span></a>
                                        <a><span data-zone>Africa/Lagos</span><span data-hour></span></a>
                                        <a><span data-zone>Africa/Libreville</span><span data-hour></span></a>
                                        <a><span data-zone>Africa/Lome</span><span data-hour></span></a>
                                        <a><span data-zone>Africa/Luanda</span><span data-hour></span></a>
                                        <a><span data-zone>Africa/Lubumbashi</span><span data-hour></span></a>
                                        <a><span data-zone>Africa/Lusaka</span><span data-hour></span></a>
                                        <a><span data-zone>Africa/Malabo</span><span data-hour></span></a>
                                        <a><span data-zone>Africa/Maputo</span><span data-hour></span></a>
                                        <a><span data-zone>Africa/Maseru</span><span data-hour></span></a>
                                        <a><span data-zone>Africa/Mbabane</span><span data-hour></span></a>
                                        <a><span data-zone>Africa/Mogadishu</span><span data-hour></span></a>
                                        <a><span data-zone>Africa/Monrovia</span><span data-hour></span></a>
                                        <a><span data-zone>Africa/Nairobi</span><span data-hour></span></a>
                                        <a><span data-zone>Africa/Ndjamena</span><span data-hour></span></a>
                                        <a><span data-zone>Africa/Niamey</span><span data-hour></span></a>
                                        <a><span data-zone>Africa/Nouakchott</span><span data-hour></span></a>
                                        <a><span data-zone>Africa/Ouagadougou</span><span data-hour></span></a>
                                        <a><span data-zone>Africa/Porto-Novo</span><span data-hour></span></a>
                                        <a><span data-zone>Africa/Sao_Tome</span><span data-hour></span></a>
                                        <a><span data-zone>Africa/Tripoli</span><span data-hour></span></a>
                                        <a><span data-zone>Africa/Tunis</span><span data-hour></span></a>
                                        <a><span data-zone>Africa/Windhoek</span><span data-hour></span></a>
                                        <span>Antártida</span>
                                        <a><span data-zone>Antarctica/Casey</span><span data-hour></span></a>
                                        <a><span data-zone>Antarctica/Davis</span><span data-hour></span></a>
                                        <a><span data-zone>Antarctica/DumontDUrville</span><span data-hour></span></a>
                                        <a><span data-zone>Antarctica/Macquarie</span><span data-hour></span></a>
                                        <a><span data-zone>Antarctica/Mawson</span><span data-hour></span></a>
                                        <a><span data-zone>Antarctica/McMurdo</span><span data-hour></span></a>
                                        <a><span data-zone>Antarctica/Palmer</span><span data-hour></span></a>
                                        <a><span data-zone>Antarctica/Rothera</span><span data-hour></span></a>
                                        <a><span data-zone>Antarctica/Syowa</span><span data-hour></span></a>
                                        <a><span data-zone>Antarctica/Troll</span><span data-hour></span></a>
                                        <a><span data-zone>Antarctica/Vostok</span><span data-hour></span></a>
                                        <span>Ártico</span>
                                        <a><span data-zone>Arctic/Longyearbyen</span><span data-hour></span></a>
                                        <span>Ásia</span>
                                        <a><span data-zone>Asia/Aden</span><span data-hour></span></a>
                                        <a><span data-zone>Asia/Almaty</span><span data-hour></span></a>
                                        <a><span data-zone>Asia/Amman</span><span data-hour></span></a>
                                        <a><span data-zone>Asia/Anadyr</span><span data-hour></span></a>
                                        <a><span data-zone>Asia/Aqtau</span><span data-hour></span></a>
                                        <a><span data-zone>Asia/Aqtobe</span><span data-hour></span></a>
                                        <a><span data-zone>Asia/Ashgabat</span><span data-hour></span></a>
                                        <a><span data-zone>Asia/Atyrau</span><span data-hour></span></a>
                                        <a><span data-zone>Asia/Baghdad</span><span data-hour></span></a>
                                        <a><span data-zone>Asia/Bahrain</span><span data-hour></span></a>
                                        <a><span data-zone>Asia/Baku</span><span data-hour></span></a>
                                        <a><span data-zone>Asia/Bangkok</span><span data-hour></span></a>
                                        <a><span data-zone>Asia/Barnaul</span><span data-hour></span></a>
                                        <a><span data-zone>Asia/Beirut</span><span data-hour></span></a>
                                        <a><span data-zone>Asia/Bishkek</span><span data-hour></span></a>
                                        <a><span data-zone>Asia/Brunei</span><span data-hour></span></a>
                                        <a><span data-zone>Asia/Chita</span><span data-hour></span></a>
                                        <a><span data-zone>Asia/Choibalsan</span><span data-hour></span></a>
                                        <a><span data-zone>Asia/Colombo</span><span data-hour></span></a>
                                        <a><span data-zone>Asia/Damascus</span><span data-hour></span></a>
                                        <a><span data-zone>Asia/Dhaka</span><span data-hour></span></a>
                                        <a><span data-zone>Asia/Dili</span><span data-hour></span></a>
                                        <a><span data-zone>Asia/Dubai</span><span data-hour></span></a>
                                        <a><span data-zone>Asia/Dushanbe</span><span data-hour></span></a>
                                        <a><span data-zone>Asia/Famagusta</span><span data-hour></span></a>
                                        <a><span data-zone>Asia/Gaza</span><span data-hour></span></a>
                                        <a><span data-zone>Asia/Hebron</span><span data-hour></span></a>
                                        <a><span data-zone>Asia/Ho_Chi_Minh</span><span data-hour></span></a>
                                        <a><span data-zone>Asia/Hong_Kong</span><span data-hour></span></a>
                                        <a><span data-zone>Asia/Hovd</span><span data-hour></span></a>
                                        <a><span data-zone>Asia/Irkutsk</span><span data-hour></span></a>
                                        <a><span data-zone>Asia/Jakarta</span><span data-hour></span></a>
                                        <a><span data-zone>Asia/Jayapura</span><span data-hour></span></a>
                                        <a><span data-zone>Asia/Jerusalem</span><span data-hour></span></a>
                                        <a><span data-zone>Asia/Kabul</span><span data-hour></span></a>
                                        <a><span data-zone>Asia/Kamchatka</span><span data-hour></span></a>
                                        <a><span data-zone>Asia/Karachi</span><span data-hour></span></a>
                                        <a><span data-zone>Asia/Kathmandu</span><span data-hour></span></a>
                                        <a><span data-zone>Asia/Khandyga</span><span data-hour></span></a>
                                        <a><span data-zone>Asia/Kolkata</span><span data-hour></span></a>
                                        <a><span data-zone>Asia/Krasnoyarsk</span><span data-hour></span></a>
                                        <a><span data-zone>Asia/Kuala_Lumpur</span><span data-hour></span></a>
                                        <a><span data-zone>Asia/Kuching</span><span data-hour></span></a>
                                        <a><span data-zone>Asia/Kuwait</span><span data-hour></span></a>
                                        <a><span data-zone>Asia/Macau</span><span data-hour></span></a>
                                        <a><span data-zone>Asia/Magadan</span><span data-hour></span></a>
                                        <a><span data-zone>Asia/Makassar</span><span data-hour></span></a>
                                        <a><span data-zone>Asia/Manila</span><span data-hour></span></a>
                                        <a><span data-zone>Asia/Muscat</span><span data-hour></span></a>
                                        <a><span data-zone>Asia/Nicosia</span><span data-hour></span></a>
                                        <a><span data-zone>Asia/Novokuznetsk</span><span data-hour></span></a>
                                        <a><span data-zone>Asia/Novosibirsk</span><span data-hour></span></a>
                                        <a><span data-zone>Asia/Omsk</span><span data-hour></span></a>
                                        <a><span data-zone>Asia/Oral</span><span data-hour></span></a>
                                        <a><span data-zone>Asia/Phnom_Penh</span><span data-hour></span></a>
                                        <a><span data-zone>Asia/Pontianak</span><span data-hour></span></a>
                                        <a><span data-zone>Asia/Pyongyang</span><span data-hour></span></a>
                                        <a><span data-zone>Asia/Qatar</span><span data-hour></span></a>
                                        <a><span data-zone>Asia/Qyzylorda</span><span data-hour></span></a>
                                        <a><span data-zone>Asia/Riyadh</span><span data-hour></span></a>
                                        <a><span data-zone>Asia/Sakhalin</span><span data-hour></span></a>
                                        <a><span data-zone>Asia/Samarkand</span><span data-hour></span></a>
                                        <a><span data-zone>Asia/Seoul</span><span data-hour></span></a>
                                        <a><span data-zone>Asia/Shanghai</span><span data-hour></span></a>
                                        <a><span data-zone>Asia/Singapore</span><span data-hour></span></a>
                                        <a><span data-zone>Asia/Srednekolymsk</span><span data-hour></span></a>
                                        <a><span data-zone>Asia/Taipei</span><span data-hour></span></a>
                                        <a><span data-zone>Asia/Tashkent</span><span data-hour></span></a>
                                        <a><span data-zone>Asia/Tbilisi</span><span data-hour></span></a>
                                        <a><span data-zone>Asia/Tehran</span><span data-hour></span></a>
                                        <a><span data-zone>Asia/Thimphu</span><span data-hour></span></a>
                                        <a><span data-zone>Asia/Tokyo</span><span data-hour></span></a>
                                        <a><span data-zone>Asia/Tomsk</span><span data-hour></span></a>
                                        <a><span data-zone>Asia/Ulaanbaatar</span><span data-hour></span></a>
                                        <a><span data-zone>Asia/Urumqi</span><span data-hour></span></a>
                                        <a><span data-zone>Asia/Ust-Nera</span><span data-hour></span></a>
                                        <a><span data-zone>Asia/Vientiane</span><span data-hour></span></a>
                                        <a><span data-zone>Asia/Vladivostok</span><span data-hour></span></a>
                                        <a><span data-zone>Asia/Yakutsk</span><span data-hour></span></a>
                                        <a><span data-zone>Asia/Yangon</span><span data-hour></span></a>
                                        <a><span data-zone>Asia/Yekaterinburg</span><span data-hour></span></a>
                                        <a><span data-zone>Asia/Yerevan</span><span data-hour></span></a>
                                        <span>Atlántico</span>
                                        <a><span data-zone>Atlantic/Azores</span><span data-hour></span></a>
                                        <a><span data-zone>Atlantic/Bermuda</span><span data-hour></span></a>
                                        <a><span data-zone>Atlantic/Canary</span><span data-hour></span></a>
                                        <a><span data-zone>Atlantic/Cape_Verde</span><span data-hour></span></a>
                                        <a><span data-zone>Atlantic/Faroe</span><span data-hour></span></a>
                                        <a><span data-zone>Atlantic/Madeira</span><span data-hour></span></a>
                                        <a><span data-zone>Atlantic/Reykjavik</span><span data-hour></span></a>
                                        <a><span data-zone>Atlantic/South_Georgia</span><span data-hour></span></a>
                                        <a><span data-zone>Atlantic/St_Helena</span><span data-hour></span></a>
                                        <a><span data-zone>Atlantic/Stanley</span><span data-hour></span></a>
                                        <span>Australia</span>
                                        <a><span data-zone>Australia/Adelaide</span><span data-hour></span></a>
                                        <a><span data-zone>Australia/Brisbane</span><span data-hour></span></a>
                                        <a><span data-zone>Australia/Broken_Hill</span><span data-hour></span></a>
                                        <a><span data-zone>Australia/Currie</span><span data-hour></span></a>
                                        <a><span data-zone>Australia/Darwin</span><span data-hour></span></a>
                                        <a><span data-zone>Australia/Eucla</span><span data-hour></span></a>
                                        <a><span data-zone>Australia/Hobart</span><span data-hour></span></a>
                                        <a><span data-zone>Australia/Lindeman</span><span data-hour></span></a>
                                        <a><span data-zone>Australia/Lord_Howe</span><span data-hour></span></a>
                                        <a><span data-zone>Australia/Melbourne</span><span data-hour></span></a>
                                        <a><span data-zone>Australia/Perth</span><span data-hour></span></a>
                                        <a><span data-zone>Australia/Sydney</span><span data-hour></span></a>
                                        <span>Europa</span>
                                        <a><span data-zone>Europe/Amsterdam</span><span data-hour></span></a>
                                        <a><span data-zone>Europe/Andorra</span><span data-hour></span></a>
                                        <a><span data-zone>Europe/Astrakhan</span><span data-hour></span></a>
                                        <a><span data-zone>Europe/Athens</span><span data-hour></span></a>
                                        <a><span data-zone>Europe/Belgrade</span><span data-hour></span></a>
                                        <a><span data-zone>Europe/Berlin</span><span data-hour></span></a>
                                        <a><span data-zone>Europe/Bratislava</span><span data-hour></span></a>
                                        <a><span data-zone>Europe/Brussels</span><span data-hour></span></a>
                                        <a><span data-zone>Europe/Bucharest</span><span data-hour></span></a>
                                        <a><span data-zone>Europe/Budapest</span><span data-hour></span></a>
                                        <a><span data-zone>Europe/Busingen</span><span data-hour></span></a>
                                        <a><span data-zone>Europe/Chisinau</span><span data-hour></span></a>
                                        <a><span data-zone>Europe/Copenhagen</span><span data-hour></span></a>
                                        <a><span data-zone>Europe/Dublin</span><span data-hour></span></a>
                                        <a><span data-zone>Europe/Gibraltar</span><span data-hour></span></a>
                                        <a><span data-zone>Europe/Guernsey</span><span data-hour></span></a>
                                        <a><span data-zone>Europe/Helsinki</span><span data-hour></span></a>
                                        <a><span data-zone>Europe/Isle_of_Man</span><span data-hour></span></a>
                                        <a><span data-zone>Europe/Istanbul</span><span data-hour></span></a>
                                        <a><span data-zone>Europe/Jersey</span><span data-hour></span></a>
                                        <a><span data-zone>Europe/Kaliningrad</span><span data-hour></span></a>
                                        <a><span data-zone>Europe/Kiev</span><span data-hour></span></a>
                                        <a><span data-zone>Europe/Kirov</span><span data-hour></span></a>
                                        <a><span data-zone>Europe/Lisbon</span><span data-hour></span></a>
                                        <a><span data-zone>Europe/Ljubljana</span><span data-hour></span></a>
                                        <a><span data-zone>Europe/London</span><span data-hour></span></a>
                                        <a><span data-zone>Europe/Luxembourg</span><span data-hour></span></a>
                                        <a><span data-zone>Europe/Madrid</span><span data-hour></span></a>
                                        <a><span data-zone>Europe/Malta</span><span data-hour></span></a>
                                        <a><span data-zone>Europe/Mariehamn</span><span data-hour></span></a>
                                        <a><span data-zone>Europe/Minsk</span><span data-hour></span></a>
                                        <a><span data-zone>Europe/Monaco</span><span data-hour></span></a>
                                        <a><span data-zone>Europe/Moscow</span><span data-hour></span></a>
                                        <a><span data-zone>Europe/Oslo</span><span data-hour></span></a>
                                        <a><span data-zone>Europe/Paris</span><span data-hour></span></a>
                                        <a><span data-zone>Europe/Podgorica</span><span data-hour></span></a>
                                        <a><span data-zone>Europe/Prague</span><span data-hour></span></a>
                                        <a><span data-zone>Europe/Riga</span><span data-hour></span></a>
                                        <a><span data-zone>Europe/Rome</span><span data-hour></span></a>
                                        <a><span data-zone>Europe/Samara</span><span data-hour></span></a>
                                        <a><span data-zone>Europe/San_Marino</span><span data-hour></span></a>
                                        <a><span data-zone>Europe/Sarajevo</span><span data-hour></span></a>
                                        <a><span data-zone>Europe/Saratov</span><span data-hour></span></a>
                                        <a><span data-zone>Europe/Simferopol</span><span data-hour></span></a>
                                        <a><span data-zone>Europe/Skopje</span><span data-hour></span></a>
                                        <a><span data-zone>Europe/Sofia</span><span data-hour></span></a>
                                        <a><span data-zone>Europe/Stockholm</span><span data-hour></span></a>
                                        <a><span data-zone>Europe/Tallinn</span><span data-hour></span></a>
                                        <a><span data-zone>Europe/Tirane</span><span data-hour></span></a>
                                        <a><span data-zone>Europe/Ulyanovsk</span><span data-hour></span></a>
                                        <a><span data-zone>Europe/Uzhgorod</span><span data-hour></span></a>
                                        <a><span data-zone>Europe/Vaduz</span><span data-hour></span></a>
                                        <a><span data-zone>Europe/Vatican</span><span data-hour></span></a>
                                        <a><span data-zone>Europe/Vienna</span><span data-hour></span></a>
                                        <a><span data-zone>Europe/Vilnius</span><span data-hour></span></a>
                                        <a><span data-zone>Europe/Volgograd</span><span data-hour></span></a>
                                        <a><span data-zone>Europe/Warsaw</span><span data-hour></span></a>
                                        <a><span data-zone>Europe/Zagreb</span><span data-hour></span></a>
                                        <a><span data-zone>Europe/Zaporozhye</span><span data-hour></span></a>
                                        <a><span data-zone>Europe/Zurich</span><span data-hour></span></a>
                                        <span>India</span>
                                        <a><span data-zone>Indian/Antananarivo</span><span data-hour></span></a>
                                        <a><span data-zone>Indian/Chagos</span><span data-hour></span></a>
                                        <a><span data-zone>Indian/Christmas</span><span data-hour></span></a>
                                        <a><span data-zone>Indian/Cocos</span><span data-hour></span></a>
                                        <a><span data-zone>Indian/Comoro</span><span data-hour></span></a>
                                        <a><span data-zone>Indian/Kerguelen</span><span data-hour></span></a>
                                        <a><span data-zone>Indian/Mahe</span><span data-hour></span></a>
                                        <a><span data-zone>Indian/Maldives</span><span data-hour></span></a>
                                        <a><span data-zone>Indian/Mauritius</span><span data-hour></span></a>
                                        <a><span data-zone>Indian/Mayotte</span><span data-hour></span></a>
                                        <a><span data-zone>Indian/Reunion</span><span data-hour></span></a>
                                        <span>Pacífico</span>
                                        <a><span data-zone>Pacific/Apia</span><span data-hour></span></a>
                                        <a><span data-zone>Pacific/Auckland</span><span data-hour></span></a>
                                        <a><span data-zone>Pacific/Bougainville</span><span data-hour></span></a>
                                        <a><span data-zone>Pacific/Chatham</span><span data-hour></span></a>
                                        <a><span data-zone>Pacific/Chuuk</span><span data-hour></span></a>
                                        <a><span data-zone>Pacific/Easter</span><span data-hour></span></a>
                                        <a><span data-zone>Pacific/Efate</span><span data-hour></span></a>
                                        <a><span data-zone>Pacific/Enderbury</span><span data-hour></span></a>
                                        <a><span data-zone>Pacific/Fakaofo</span><span data-hour></span></a>
                                        <a><span data-zone>Pacific/Fiji</span><span data-hour></span></a>
                                        <a><span data-zone>Pacific/Funafuti</span><span data-hour></span></a>
                                        <a><span data-zone>Pacific/Galapagos</span><span data-hour></span></a>
                                        <a><span data-zone>Pacific/Gambier</span><span data-hour></span></a>
                                        <a><span data-zone>Pacific/Guadalcanal</span><span data-hour></span></a>
                                        <a><span data-zone>Pacific/Guam</span><span data-hour></span></a>
                                        <a><span data-zone>Pacific/Honolulu</span><span data-hour></span></a>
                                        <a><span data-zone>Pacific/Kiritimati</span><span data-hour></span></a>
                                        <a><span data-zone>Pacific/Kosrae</span><span data-hour></span></a>
                                        <a><span data-zone>Pacific/Kwajalein</span><span data-hour></span></a>
                                        <a><span data-zone>Pacific/Majuro</span><span data-hour></span></a>
                                        <a><span data-zone>Pacific/Marquesas</span><span data-hour></span></a>
                                        <a><span data-zone>Pacific/Midway</span><span data-hour></span></a>
                                        <a><span data-zone>Pacific/Nauru</span><span data-hour></span></a>
                                        <a><span data-zone>Pacific/Niue</span><span data-hour></span></a>
                                        <a><span data-zone>Pacific/Norfolk</span><span data-hour></span></a>
                                        <a><span data-zone>Pacific/Noumea</span><span data-hour></span></a>
                                        <a><span data-zone>Pacific/Pago_Pago</span><span data-hour></span></a>
                                        <a><span data-zone>Pacific/Palau</span><span data-hour></span></a>
                                        <a><span data-zone>Pacific/Pitcairn</span><span data-hour></span></a>
                                        <a><span data-zone>Pacific/Pohnpei</span><span data-hour></span></a>
                                        <a><span data-zone>Pacific/Port_Moresby</span><span data-hour></span></a>
                                        <a><span data-zone>Pacific/Rarotonga</span><span data-hour></span></a>
                                        <a><span data-zone>Pacific/Saipan</span><span data-hour></span></a>
                                        <a><span data-zone>Pacific/Tahiti</span><span data-hour></span></a>
                                        <a><span data-zone>Pacific/Tarawa</span><span data-hour></span></a>
                                        <a><span data-zone>Pacific/Tongatapu</span><span data-hour></span></a>
                                        <a><span data-zone>Pacific/Wake</span><span data-hour></span></a>
                                        <a><span data-zone>Pacific/Wallis</span><span data-hour></span></a>
                                    </div>
                                </div>
                                <p class="description">{$lang.time_zone}</p>
                            </label>
                        </div>
                    </div>
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
                    <div class="separator"></div>
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
                </div>
                <button type="submit">{$lang.signup_free}</button>
                <a button-cancel>{$lang.close}</a>
            </form>
        </main>
    </div>
</section>
