<?php

defined('_EXEC') or die;

$this->dependencies->add(['css', '{$path.css}Index/index.css']);
$this->dependencies->add(['js', '{$path.js}Index/index.js']);
$this->dependencies->add(['others',
'<div id="fb-root"></div>
<script>
    window.fbAsyncInit = function() {
        FB.init({
            xfbml: true,
            version: "v7.0"
        });
    }; (function(d, s, id) {
        var js, fjs = d.getElementsByTagName(s)[0];
        if (d.getElementById(id)) return;
        js = d.createElement(s); js.id = id;
        js.src = "https://connect.facebook.net/es_ES/sdk/xfbml.customerchat.js";
        fjs.parentNode.insertBefore(js, fjs);
    } (document, "script, "facebook-jssdk"));
</script>
<div class="fb-customerchat" attribution=setup_tool page_id="544915395886636" theme_color="#00A5AB" logged_in_greeting="Hola, estoy aquí para resolver tus dudas. ¿Te puedo ayudar en algo?" logged_out_greeting="Hola, estoy aquí para resolver tus dudas. ¿Te puedo ayudar en algo?"></div>']);

?>

<main class="landing_page_index">
    <header>
        <figure>
            <img src="{$path.images}imagotype_color.png" alt="Imagotype">
        </figure>
        <nav class="desktop">
            <ul>
                <li><a href="#solutions" data-smooth-scroll>{$lang.solutions}</a></li>
                <li><a href="#prices" data-smooth-scroll>{$lang.specialized_packages}</a></li>
                <li class="focus"><a href="/login">{$lang.login}</a></li>
                <li><a href="https://blog.guestvox.com">{$lang.blog}</a></li>
            </ul>
        </nav>
        <nav class="mobile">
            <ul>
                <li><a data-action="open_index_menu"><i class="fas fa-bars"></i></a></li>
            </ul>
        </nav>
    </header>
    <section class="stl_1">
        <video autoplay loop muted>
            <source src="{$path.images}index/stl_1_video_1.mp4" type="video/mp4">
        </video>
        <div>
            <figure>
                <img src="{$path.images}logotype_white.png" alt="Guestvox">
            </figure>
            <h1>{$lang.landing_page_index_stl_1_text_1}</h1>
            <p>{$lang.landing_page_index_stl_1_text_2}</p>
        </div>
    </section>
    <section id="solutions" class="stl_2">
        <figure>
            <img src="{$path.images}index/stl_2_image_2.png" alt="Background">
        </figure>
        <div>
            <h2>{$lang.landing_page_index_stl_2_text_5}</h2>
            <div>
                <div>
                    <i class="fas fa-mobile"></i>
                    <p>{$lang.landing_page_index_stl_2_text_6}</p>
                </div>
                <div>
                    <i class="fas fa-user-ninja"></i>
                    <p>{$lang.landing_page_index_stl_2_text_7}</p>
                </div>
                <div>
                    <i class="fas fa-qrcode"></i>
                    <p>{$lang.landing_page_index_stl_2_text_8}</p>
                </div>
            </div>
        </div>
    </section>
    <section class="stl_3">
        <figure>
            <img src="{$path.images}index/stl_2_image_1.png" alt="Background">
        </figure>
        <div>
            <h2>{$lang.landing_page_index_stl_2_text_1}</h2>
            <div>
                <div>
                    <i class="fas fa-desktop"></i>
                    <p>{$lang.landing_page_index_stl_2_text_2}</p>
                </div>
                <div>
                    <i class="fas fa-users"></i>
                    <p>{$lang.landing_page_index_stl_2_text_3}</p>
                </div>
                <div>
                    <i class="fas fa-chart-pie"></i>
                    <p>{$lang.landing_page_index_stl_2_text_4}</p>
                </div>
            </div>
        </div>
    </section>
    <section class="stl_2">
        <figure>
            <img src="{$path.images}index/stl_2_image_3.png" alt="Background">
        </figure>
        <div>
            <h2>{$lang.landing_page_index_stl_2_text_9}</h2>
            <div>
                <div>
                    <i class="fas fa-comments"></i>
                    <p>{$lang.landing_page_index_stl_2_text_10}</p>
                </div>
                <div>
                    <i class="fas fa-clipboard-list"></i>
                    <p>{$lang.landing_page_index_stl_2_text_11}</p>
                </div>
                <div>
                    <i class="fas fa-chart-area"></i>
                    <p>{$lang.landing_page_index_stl_2_text_12}</p>
                </div>
            </div>
        </div>
    </section>
    <section id="prices" class="stl_4">
        <div>
            <div>
                <i class="fas fa-hotel"></i>
                <h2>{$lang.guestvox_hotels}</h2>
                <a href="/hoteles">{$lang.discover_more}</a>
                <p>{$lang.guestvox_hotels_text}</p>
                <a data-button-modal="quote_hotel">{$lang.quote_now}</a>
            </div>
        </div>
        <div>
            <div>
                <i class="fas fa-utensils"></i>
                <h2>{$lang.guestvox_restaurants}</h2>
                <a href="/restaurantes">{$lang.discover_more}</a>
                <p>{$lang.guestvox_restaurants_text}</p>
                <a data-button-modal="quote_restaurant">{$lang.quote_now}</a>
            </div>
        </div>
        <div>
            <div>
                <i class="fas fa-grin-stars"></i>
                <h2>{$lang.guestvox_personalize}</h2>
                <a href="/personaliza">¡{$lang.personalize_now}!</a>
                <p>{$lang.guestvox_personalize_text}</p>
                <a data-button-modal="quote_personalize">{$lang.quote_now}</a>
            </div>
        </div>
    </section>
    <!-- <section class="stl_5">
        <h2>{$lang.landing_page_index_stl_5_text_1}</h2>
        <h3>{$lang.landing_page_index_stl_5_text_2}</h3>
        <div>
            <figure>
                <a href="https://magicbluespahotel.com/es/"><img src="{$path.images}index/stl_5_image_1.png" alt="Client"></a>
            </figure>
            <figure>
                <a href="https://www.facebook.com/CoConAmorr/"><img src="{$path.images}index/stl_5_image_2.png" alt="Client"></a>
            </figure>
            <figure>
                <a href="https://www.facebook.com/lacoyotacancun/"><img src="{$path.images}index/stl_5_image_3.png" alt="Client"></a>
            </figure>
        </div>
        <div>
            <figure>
                <a href="https://aws.amazon.com/es/"><img src="{$path.images}index/stl_5_image_4.png" alt="Partner"></a>
            </figure>
            <figure>
                <a href="https://www.siteminder.com/es/"><img src="{$path.images}index/stl_5_image_5.png" alt="Partner"></a>
            </figure>
            <figure>
                <a href="https://zaviaerp.com/"><img src="{$path.images}index/stl_5_image_6.png" alt="Partner"></a>
            </figure>
        </div>
        <div>
            <figure>
                <img src="https://www.comparasoftware.com/wp-content/uploads/2019/05/comparasoftware_verificado.png" alt="Partner">
            </figure>
        </div>
    </section>
    <section class="stl_6">
        <h2>{$lang.landing_page_index_stl_6_text_1}<i class="fas fa-heart"></i>{$lang.landing_page_index_stl_6_text_2}</h2>
        <h3>{$lang.landing_page_index_stl_6_text_3}</h3>
        <div>
            <div>
                <figure>
                    <img src="{$path.images}index/stl_6_image_1.png" alt="Work team">
                </figure>
                <h3>Daniel Basurto</h3>
                <h4>{$lang.ceo}</h4>
            </div>
            <div>
                <figure>
                    <img src="{$path.images}index/stl_6_image_2.png" alt="Work team">
                </figure>
                <h3>Alexa Zamora</h3>
                <h4>{$lang.coo}</h4>
            </div>
            <div>
                <figure>
                    <img src="{$path.images}index/stl_6_image_3.png" alt="Work team">
                </figure>
                <h3>Gersón Gómez</h3>
                <h4>{$lang.cto}</h4>
            </div>
            <div>
                <figure>
                    <img src="{$path.images}index/stl_6_image_4.png" alt="Work team">
                </figure>
                <h3>Saúl Poot</h3>
                <h4>{$lang.chief_programmer}</h4>
            </div>
        </div>
    </section> -->
    <section class="contacts">
        <a data-button-modal="quote_personalize" data-email><i class="fas fa-envelope"></i></a>
        <a href="tel:+520987654321" data-phone><i class="fas fa-phone"></i></a>
        <a href="https://api.whatsapp.com/send?phone=+520987654321" data-whatsapp target="_blank"><i class="fab fa-whatsapp"></i></a>
    </section>
    <div id="fb-root"></div>
    <script>
        window.fbAsyncInit = function() {
         FB.init({
           xfbml            : true,
           version          : "v7.0"
         });
        };

        (function(d, s, id) {
        var js, fjs = d.getElementsByTagName(s)[0];
        if (d.getElementById(id)) return;
            js = d.createElement(s); js.id = id;
            js.src = "https://connect.facebook.net/es_ES/sdk/xfbml.customerchat.js";
            fjs.parentNode.insertBefore(js, fjs);
        }(document, "script", "facebook-jssdk"));
    </script>
    <div class="fb-customerchat" attribution=setup_tool page_id="544915395886636" theme_color="#00A5AB"
        logged_in_greeting="Hola, estoy aquí para resolver tus dudas. ¿Te puedo ayudar en algo?"
        logged_out_greeting="Hola, estoy aquí para resolver tus dudas. ¿Te puedo ayudar en algo?">
    </div>
    <footer>
        <div>
            <a href="https://facebook.com/guestvox" target="_blank"><i class="fab fa-facebook-square"></i></a>
            <a href="https://instagram.com/guestvox" target="_blank"><i class="fab fa-instagram"></i></a>
            <a href="https://linkedin.com/guestvox" target="_blank"><i class="fab fa-linkedin"></i></a>
            <a href="https://www.youtube.com/channel/UCKSAce4n1NqahbL5RQ8QN9Q" target="_blank"><i class="fab fa-youtube"></i></a>
        </div>
        <div>
            <!-- <a href="/acerca-de-nosotros">{$lang.about_us}</a> -->
            <a href="/404">{$lang.about_us}</a>
            <i class="fas fa-circle"></i>
            <a href="/terminos-y-condiciones" target="_blank">{$lang.terms_and_conditions}</a>
            <i class="fas fa-circle"></i>
            <a href="/politicas-de-privacidad" target="_blank">{$lang.privacy_policies}</a>
        </div>
        <p>Copyright<i class="far fa-copyright"></i>2021 | Guestvox S.A.P.I. de C.V.</p>
    </footer>
</main>
<section class="modal" data-modal="quote_hotel">
    <div class="content">
        <main>
            <form name="quote_hotel">
                <div class="row">
                    <div class="span8">
                        <div class="label">
                            <label required>
                                <p>{$lang.hotel_name}</p>
                                <input type="text" name="business">
                            </label>
                        </div>
                    </div>
                    <div class="span4">
                        <div class="label">
                            <label required>
                                <p>{$lang.hotel_rooms}</p>
                                <input type="number" name="quantity">
                            </label>
                        </div>
                    </div>
                    <div class="span12">
                        <div class="label">
                            <label required>
                                <p>{$lang.contact_name}</p>
                                <input type="text" name="name">
                            </label>
                        </div>
                    </div>
                    <div class="span6">
                        <div class="label">
                            <label required>
                                <p>{$lang.contact_email}</p>
                                <input type="text" name="email">
                            </label>
                        </div>
                    </div>
                    <div class="span6">
                        <div class="label">
                            <label required>
                                <p>{$lang.contact_phone}</p>
                                <input type="text" name="phone">
                            </label>
                        </div>
                    </div>
                    <div class="span12">
                        <p>{$lang.to_send_form}</p>
                    </div>
                    <div class="span12">
                        <div class="buttons">
                            <a class="delete" button-cancel><i class="fas fa-times"></i></a>
                            <button type="submit" class="new"><i class="fas fa-check"></i></button>
                        </div>
                    </div>
                </div>
            </form>
        </main>
    </div>
</section>
<section class="modal" data-modal="quote_restaurant">
    <div class="content">
        <main>
            <form name="quote_restaurant">
                <div class="row">
                    <div class="span8">
                        <div class="label">
                            <label required>
                                <p>{$lang.restaurant_name}</p>
                                <input type="text" name="business">
                            </label>
                        </div>
                    </div>
                    <div class="span4">
                        <div class="label">
                            <label required>
                                <p>{$lang.restaurant_tables}</p>
                                <input type="number" name="quantity">
                            </label>
                        </div>
                    </div>
                    <div class="span12">
                        <div class="label">
                            <label required>
                                <p>{$lang.contact_name}</p>
                                <input type="text" name="name">
                            </label>
                        </div>
                    </div>
                    <div class="span6">
                        <div class="label">
                            <label required>
                                <p>{$lang.contact_email}</p>
                                <input type="text" name="email">
                            </label>
                        </div>
                    </div>
                    <div class="span6">
                        <div class="label">
                            <label required>
                                <p>{$lang.contact_phone}</p>
                                <input type="text" name="phone">
                            </label>
                        </div>
                    </div>
                    <div class="span12">
                        <p>{$lang.to_send_form}</p>
                    </div>
                    <div class="span12">
                        <div class="buttons">
                            <a class="delete" button-cancel><i class="fas fa-times"></i></a>
                            <button type="submit" class="new"><i class="fas fa-check"></i></button>
                        </div>
                    </div>
                </div>
            </form>
        </main>
    </div>
</section>
<section class="modal" data-modal="quote_personalize">
    <div class="content">
        <main>
            <form name="quote_personalize">
                <div class="row">
                    <div class="span12">
                        <div class="label">
                            <label required>
                                <p>{$lang.business_name}</p>
                                <input type="text" name="business">
                            </label>
                        </div>
                    </div>
                    <div class="span12">
                        <div class="label">
                            <label required>
                                <p>{$lang.contact_name}</p>
                                <input type="text" name="name">
                            </label>
                        </div>
                    </div>
                    <div class="span6">
                        <div class="label">
                            <label required>
                                <p>{$lang.contact_email}</p>
                                <input type="text" name="email">
                            </label>
                        </div>
                    </div>
                    <div class="span6">
                        <div class="label">
                            <label required>
                                <p>{$lang.contact_phone}</p>
                                <input type="text" name="phone">
                            </label>
                        </div>
                    </div>
                    <div class="span12">
                        <p>{$lang.to_send_form}</p>
                    </div>
                    <div class="span12">
                        <div class="buttons">
                            <a class="delete" button-cancel><i class="fas fa-times"></i></a>
                            <button type="submit" class="new"><i class="fas fa-check"></i></button>
                        </div>
                    </div>
                </div>
            </form>
        </main>
    </div>
</section>
