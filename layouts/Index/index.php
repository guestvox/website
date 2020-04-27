<?php

defined('_EXEC') or die;

$this->dependencies->add(['css', '{$path.css}Index/index.css']);
$this->dependencies->add(['js', '{$path.js}Index/index.js']);

?>
<div id="fb-root"></div>
<script>
    window.fbAsyncInit = function() {
        FB.init({
            xfbml: true,
            version: 'v6.0'
        });
    };

    (function(d, s, id) {
        var js, fjs = d.getElementsByTagName(s)[0];
        if (d.getElementById(id)) return;
        js = d.createElement(s);
        js.id = id;
        js.src = 'https://connect.facebook.net/es_ES/sdk/xfbml.customerchat.js';
        fjs.parentNode.insertBefore(js, fjs);
    }(document, 'script', 'facebook-jssdk'));
</script>

<!-- Your customer chat code -->
<div class="fb-customerchat" attribution=setup_tool page_id="544915395886636" theme_color="#00A5AB" logged_in_greeting="Hola, como puedo ayudarte?" logged_out_greeting="Hola, como puedo ayudarte?">
</div>
<main class="landing-page-index">
    <section class="st-1">
        <figure>
            <img src="{$path.images}index/st-1-image-1.png" alt="Background">
        </figure>
        <div>
            <figure>
                <img src="{$path.images}logotype-white.png" alt="GuestVox">
            </figure>
            <h1>{$lang.landing_page_index_st_1_text_1}</h1>
            <a href="/login">{$lang.login}</a>
        </div>
    </section>
    <section class="st-2">
        <figure>
            <img src="{$path.images}index/st-2-image-1.png" alt="Background">
        </figure>
        <div>
            <h2>{$lang.landing_page_index_st_2_text_1}</h2>
            <div>
                <div>
                    <i class="fas fa-desktop"></i>
                    <p>{$lang.landing_page_index_st_2_text_2}</p>
                </div>
                <div>
                    <i class="fas fa-users"></i>
                    <p>{$lang.landing_page_index_st_2_text_3}</p>
                </div>
                <div>
                    <i class="fas fa-chart-pie"></i>
                    <p>{$lang.landing_page_index_st_2_text_4}</p>
                </div>
            </div>
            <a href="/operacion">{$lang.know_more}</a>
        </div>
    </section>
    <section class="st-3">
        <figure>
            <img src="{$path.images}index/st-3-image-1.png" alt="Background">
        </figure>
        <div>
            <h2>{$lang.landing_page_index_st_3_text_1}</h2>
            <div>
                <div>
                    <i class="fas fa-clipboard-list"></i>
                    <p>{$lang.landing_page_index_st_3_text_2}</p>
                </div>
                <div>
                    <i class="fas fa-comments"></i>
                    <p>{$lang.landing_page_index_st_3_text_3}</p>
                </div>
                <div>
                    <i class="fas fa-chart-bar"></i>
                    <p>{$lang.landing_page_index_st_3_text_4}</p>
                </div>
            </div>
            <a href="/reputacion">{$lang.know_more}</a>
        </div>
    </section>
    <section class="st-4">
        <div>
            <i class="fas fa-concierge-bell"></i>
            <p>{$lang.landing_page_index_st_4_text_1}</p>
        </div>
        <div>
            <i class="fas fa-utensils"></i>
            <p>{$lang.landing_page_index_st_4_text_2}</p>
        </div>
        <div>
            <i class="fas fa-ambulance"></i>
            <p>{$lang.landing_page_index_st_4_text_3}</p>
        </div>
        <div>
            <i class="fas fa-snowplow"></i>
            <p>{$lang.landing_page_index_st_4_text_4}</p>
        </div>
    </section>
    <section class="st-5">
        <div>
            <i class="fas fa-tablet-alt"></i>
            <p>{$lang.landing_page_index_st_5_text_1}</p>
        </div>
        <div>
            <i class="fas fa-cloud"></i>
            <p>{$lang.landing_page_index_st_5_text_2}</p>
        </div>
        <div>
            <i class="fas fa-lock"></i>
            <p>{$lang.landing_page_index_st_5_text_3}</p>
        </div>
        <div>
            <i class="fas fa-chart-area"></i>
            <p>{$lang.landing_page_index_st_5_text_4}</p>
        </div>
    </section>
    <section class="st-6">
        <h2>{$lang.landing_page_index_st_6_text_1}</h2>
        <div>
            <figure>
                <img src="{$path.images}index/st-6-image-1.png" alt="Client">
            </figure>
            <figure>
                <img src="{$path.images}index/st-6-image-2.png" alt="Client">
            </figure>
            <figure>
                <img src="{$path.images}index/st-6-image-3.png" alt="Client">
            </figure>
            <figure>
                <img src="{$path.images}index/st-6-image-4.png" alt="Client">
            </figure>
        </div>
    </section>
    <section class="st-7">
        <div>
            <i class="fas fa-user-plus"></i>
            <h2>{$lang.landing_page_index_st_7_text_1}</h2>
            <a href="/signup">{$lang.signup}</a>
        </div>
        <div>
            <i class="fas fa-th"></i>
            <h2>{$lang.landing_page_index_st_7_text_2}</h2>
            <a href="/blog">{$lang.blog}</a>
        </div>
    </section>
    <section class="st-8">
        <h2>{$lang.landing_page_index_st_8_text_1}</h2>
        <div>
            <figure>
                <img src="{$path.images}index/st-8-image-1.png" alt="Work team">
            </figure>
            <h3>Daniel Basurto</h3>
            <h4>{$lang.ceo}</h4>
        </div>
        <div>
            <figure>
                <img src="{$path.images}index/st-8-image-2.png" alt="Work team">
            </figure>
            <h3>Alexa Zamora</h3>
            <h4>{$lang.cpo}</h4>
        </div>
        <div>
            <figure>
                <img src="{$path.images}index/st-8-image-3.png" alt="Work team">
            </figure>
            <h3>Gersón Gómez</h3>
            <h4>{$lang.cto}</h4>
        </div>
        <div>
            <figure>
                <img src="{$path.images}index/st-8-image-4.png" alt="Work team">
            </figure>
            <h3>Saúl Poot</h3>
            <h4>{$lang.programmer}</h4>
        </div>
        <div>
            <figure>
                <img src="{$path.images}index/st-8-image-5.png" alt="Work team">
            </figure>
            <h3>Alejandro Espinoza</h3>
            <h4>{$lang.programmer}</h4>
        </div>
        <div>
            <figure>
                <img src="{$path.images}index/st-8-image-6.png" alt="Work team">
            </figure>
            <h3>David Gómez</h3>
            <h4>{$lang.programmer}</h4>
        </div>
    </section>
    <section class="st-9">
        <h2>{$lang.landing_page_index_st_9_text_1}</h2>
        <div>
            <figure>
                <img src="{$path.images}index/st-9-image-1.png" alt="Partner">
            </figure>
            <figure>
                <img src="{$path.images}index/st-9-image-2.png" alt="Partner">
            </figure>
            <figure>
                <img src="{$path.images}index/st-9-image-3.png" alt="Partner">
            </figure>
            <figure>
                <img src="https://www.comparasoftware.com/wp-content/uploads/2019/05/comparasoftware_verificado.png" alt="Partner">
            </figure>
        </div>
    </section>
    <section class="st-10">
        <div>
            <a href="https://facebook.com/guestvox" target="_blank"><i class="fab fa-facebook-square"></i></a>
            <a href="https://instagram.com/guestvox" target="_blank"><i class="fab fa-instagram"></i></a>
            <a href="https://linkedin.com/guestvox" target="_blank"><i class="fab fa-linkedin"></i></a>
            <a href="https://www.youtube.com/channel/UCKSAce4n1NqahbL5RQ8QN9Q" target="_blank"><i class="fab fa-youtube"></i></a>
        </div>
        <div>
            <a href="/about-us">{$lang.about_us}</a>
            <i class="fas fa-circle"></i>
            <a href="/terms-and-conditions">{$lang.terms_and_conditions}</a>
            <i class="fas fa-circle"></i>
            <a href="/privacy-policies">{$lang.privacy_policies}</a>
        </div>
        <p>Copyright<i class="far fa-copyright"></i>{$lang.all_right_reserved}</p>
    </section>
</main>