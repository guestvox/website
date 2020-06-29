<?php

defined('_EXEC') or die;

$this->dependencies->add(['css', '{$path.css}Index/index.css']);
$this->dependencies->add(['js', '{$path.js}Index/index.js']);
$this->dependencies->add(['others',
'<div id="fb-root"></div>
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
   }(document, "script, "facebook-jssdk"));</script>

 <div class="fb-customerchat" attribution=setup_tool page_id="544915395886636" theme_color="#00A5AB"
    logged_in_greeting="Hola, estoy aquí para resolver tus dudas. ¿Te puedo ayudar en algo?"
    logged_out_greeting="Hola, estoy aquí para resolver tus dudas. ¿Te puedo ayudar en algo?">
 </div>']);

?>

<main class="landing_page_index">
    <header>
        <figure>
            <img src="{$path.images}imagotype_color.png" alt="Imagotype">
        </figure>
        <nav>
            <ul>
                <li><a href="/blog">{$lang.blog}</a></li>
                <li><a href="/signup">¡{$lang.signup_now}!</a></li>
                <li><a href="/login">{$lang.login}</a></li>
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
    <section class="stl_2">
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
            <a href="/hola/voxes">{$lang.know_more}</a>
        </div>
    </section>
    <section class="stl_3">
        <figure>
            <img src="{$path.images}index/stl_2_image_2.png" alt="Background">
        </figure>
        <div>
            <h2>{$lang.landing_page_index_stl_2_text_5}</h2>
            <div>
                <div>
                    <i class="fas fa-concierge-bell"></i>
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
            <a href="/hola/menu">{$lang.know_more}</a>
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
            <a href="/hola/encuestas">{$lang.know_more}</a>
        </div>
    </section>
    <section class="stl_3">
        <figure>
            <img src="{$path.images}index/stl_2_image_4.png" alt="Background">
        </figure>
        <div>
            <h2>{$lang.landing_page_index_stl_2_text_13}</h2>
            <div>
                <div>
                    <i class="fas fa-star"></i>
                    <p>{$lang.landing_page_index_stl_2_text_14}</p>
                </div>
                <div>
                    <i class="fas fa-comment"></i>
                    <p>{$lang.landing_page_index_stl_2_text_15}</p>
                </div>
                <div>
                    <i class="fas fa-qrcode"></i>
                    <p>{$lang.landing_page_index_stl_2_text_16}</p>
                </div>
            </div>
            <!-- <a href="/hola/resenas">{$lang.know_more}</a> -->
        </div>
    </section>
    <section class="stl_4">
        <div>
            <div>
                <i class="fas fa-bed"></i>
                <p>{$lang.landing_page_index_stl_4_text_1}</p>
                <a href="/hola/hoteles">{$lang.know_more}</a>
            </div>
            <div>
                <i class="fas fa-utensils"></i>
                <p>{$lang.landing_page_index_stl_4_text_2}</p>
                <a href="/hola/restaurantes">{$lang.know_more}</a>
            </div>
            <div>
                <i class="fas fa-stethoscope"></i>
                <p>{$lang.landing_page_index_stl_4_text_3}</p>
                <a href="/hola/hospitales">{$lang.know_more}</a>
            </div>
        </div>
        <div>
            <div>
                <i class="fas fa-tablet-alt"></i>
                <p>{$lang.landing_page_index_stl_4_text_4}</p>
            </div>
            <div>
                <i class="fas fa-cloud"></i>
                <p>{$lang.landing_page_index_stl_4_text_5}</p>
            </div>
            <div>
                <i class="fas fa-lock"></i>
                <p>{$lang.landing_page_index_stl_4_text_6}</p>
            </div>
        </div>
        <figure>
            <img src="{$path.images}index/stl_4_image_1.png" alt="Background">
        </figure>
    </section>
    <section class="stl_5">
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
            <!-- <figure>
                <img src="https://www.comparasoftware.com/wp-content/uploads/2019/05/comparasoftware_verificado.png" alt="Partner">
            </figure> -->
        </div>
        <a href="/signup">¡{$lang.signup_now}!</a>
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
        </div>
        <div>
            <div>
                <figure>
                    <img src="{$path.images}index/stl_6_image_4.png" alt="Work team">
                </figure>
                <h3>Saúl Poot</h3>
                <h4>{$lang.chief_programmer_web}</h4>
            </div>
            <div>
                <figure>
                    <img src="{$path.images}index/stl_6_image_5.png" alt="Work team">
                </figure>
                <h3>David Gómez</h3>
                <h4>{$lang.chief_programmer_mobile}</h4>
            </div>
        </div>
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
            <a href="/terms-and-conditions" target="_blank">{$lang.terms_and_conditions}</a>
            <i class="fas fa-circle"></i>
            <a href="/privacy-policies" target="_blank">{$lang.privacy_policies}</a>
        </div>
        <p>Copyright<i class="far fa-copyright"></i>{$lang.all_right_reserved}</p>
    </footer>
</main>
