<?php

defined('_EXEC') or die;

$this->dependencies->add(['css', '{$path.css}Hi/restaurants.css']);
$this->dependencies->add(['js', '{$path.js}Hi/restaurants.js']);
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

<header class="landing_page_restaurants">
    <div class="container">
        <figure>
            <a data-target="1"><img src="{$path.images}logotype_color.png" alt="Guestvox"></a>
        </figure>
        <nav>
            <a class="<?php echo ((Session::get_value('hi')['restaurant']['target'] == '1') ? 'active' : '') ?>" data-target="1">{$lang.lpr_txt_1}</a>
            <a class="<?php echo ((Session::get_value('hi')['restaurant']['target'] == '2') ? 'active' : '') ?>" data-target="2">{$lang.lpr_txt_2}</a>
            <a class="<?php echo ((Session::get_value('hi')['restaurant']['target'] == '3') ? 'active' : '') ?>" data-target="3">{$lang.lpr_txt_3}</a>
            <a class="focus <?php echo ((Session::get_value('hi')['restaurant']['target'] == '4') ? 'active' : '') ?>" data-target="4">{$lang.lpr_txt_4}</a>
        </nav>
        <a data-action="lpr_opn_mnu"><i class="fas fa-bars"></i></a>
    </div>
</header>
<main class="landing_page_restaurants <?php echo ((Session::get_value('hi')['restaurant']['target'] == '1') ? '' : 'hidden') ?>" data-target="1">
    <section class="stn_1">
        <div>
            <figure>
                <img src="{$path.images}hi/restaurants/img_1.png" alt="Background">
            </figure>
            <div>
                <h1>{$lang.lpr_txt_5}</h1>
                <h2>{$lang.lpr_txt_6}</h2>
                <p>{$lang.lpr_txt_7}</p>
                <a data-target="4">{$lang.lpr_txt_8}</a>
            </div>
        </div>
    </section>
    <section class="stn_2">
        <div>
            <div>
                <figure>
                    <img src="{$path.images}hi/restaurants/img_2.png" alt="Background">
                </figure>
                <div>
                    <h2>{$lang.lpr_txt_9}</h2>
                    <ul>
                        <li>{$lang.lpr_txt_10}</li>
                        <li>{$lang.lpr_txt_11}</li>
                        <li>{$lang.lpr_txt_12}</li>
                        <li>{$lang.lpr_txt_13}</li>
                        <li>{$lang.lpr_txt_14}</li>
                    </ul>
                    <div>
                        <a><i class="fas fa-star"></i></a>
                        <a><i class="fas fa-star"></i></a>
                        <a><i class="fas fa-heart"></i></a>
                        <a><i class="fas fa-bullhorn"></i></a>
                        <a><i class="fas fa-grin"></i></a>
                    </div>
                    <a data-target="4">{$lang.lpr_txt_15}</a>
                </div>
            </div>
        </div>
    </section>
    <section class="stn_3">
        <div>
            <div>
                <figure>
                    <img src="{$path.images}hi/restaurants/img_3.png" alt="Background">
                </figure>
                <div>
                    <div>
                        <h2>{$lang.lpr_txt_16}</h2>
                        <span>1</span>
                    </div>
                    <div>
                        <h2>{$lang.lpr_txt_17}<span>{$lang.lpr_txt_18}</span></h2>
                        <span>2</span>
                    </div>
                    <div>
                        <h2>{$lang.lpr_txt_19}<span>{$lang.lpr_txt_20}</span></h2>
                        <span>3</span>
                    </div>
                    <div>
                        <h2>{$lang.lpr_txt_21}<span>{$lang.lpr_txt_22}</span></h2>
                        <span>4</span>
                    </div>
                    <div>
                        <h2>{$lang.lpr_txt_23}<span>{$lang.lpr_txt_24}</span></h2>
                        <span>5</span>
                    </div>
                    <a data-target="4">{$lang.lpr_txt_25}</a>
                </div>
            </div>
        </div>
    </section>
    <section class="stn_4">
        <div>
            <figure>
                <img src="{$path.images}hi/restaurants/img_4.png" alt="Background">
            </figure>
            <div>
                <h2>{$lang.lpr_txt_26}</h2>
                <a data-target="4">{$lang.lpr_txt_27}</a>
                <!-- <span><i class="fas fa-headset"></i>{$lang.lpr_txt_28}</span> -->
            </div>
        </div>
    </section>
</main>
<main class="landing_page_restaurants <?php echo ((Session::get_value('hi')['restaurant']['target'] == '2') ? '' : 'hidden') ?>" data-target="2">
    <section class="stn_7">
        <div>
            <figure>
                <img src="{$path.images}hi/restaurants/img_7.png" alt="Background">
            </figure>
            <div>
                <h2>{$lang.lpr_txt_48}</h2>
                <p>{$lang.lpr_txt_49}</p>
                <a data-target="4">{$lang.lpr_txt_50}</a>
            </div>
        </div>
    </section>
    <section class="stn_8">
        <div>
            <figure>
                <img src="{$path.images}hi/restaurants/img_8.png" alt="Background">
            </figure>
            <div>
                <h2>{$lang.lpr_txt_51}</h2>
                <p>{$lang.lpr_txt_52}</p>
                <a data-target="4">{$lang.lpr_txt_53}</a>
            </div>
        </div>
    </section>
    <section class="stn_9">
        <div>
            <div>
                <figure>
                    <img src="{$path.images}hi/restaurants/img_9.png" alt="Background">
                </figure>
                <div>
                    <h2>{$lang.lpr_txt_54}</h2>
                    <p>{$lang.lpr_txt_55}</p>
                    <div>
                        <div>
                            <i class="fas fa-envelope"></i>
                            <i class="fab fa-instagram"></i>
                            <i class="fab fa-whatsapp"></i>
                            <i class="fab fa-facebook-square"></i>
                            <i class="fab fa-facebook-messenger"></i>
                            <i class="fab fa-linkedin"></i>
                        </div>
                        <figure>
                            <img src="{$path.images}hi/restaurants/img_10.png" alt="Background">
                        </figure>
                    </div>
                    <a data-target="4">{$lang.lpr_txt_56}</a>
                </div>
            </div>
        </div>
    </section>
    <section class="stn_10">
        <div>
            <div>
                <figure>
                    <img src="{$path.images}hi/restaurants/img_11.png" alt="Background">
                </figure>
                <h2>{$lang.lpr_txt_57}</h2>
                <h6>{$lang.lpr_txt_58}</h6>
                <a href="https://guestvox.com/restaurantes" target="_blank">{$lang.lpr_txt_58}</a>
            </div>
        </div>
    </section>
</main>
<main class="landing_page_restaurants <?php echo ((Session::get_value('hi')['restaurant']['target'] == '3') ? '' : 'hidden') ?>" data-target="3">
    <section class="stn_5">
        <div>
            <div>
                <div>
                    <h6>{$lang.lpr_txt_29}</h6>
                    <p>{$lang.lpr_txt_30}</p>
                    <figure>
                        <img src="{$path.images}hi/restaurants/img_5.png" alt="Background">
                    </figure>
                    <a data-target="4">{$lang.lpr_txt_46}</a>
                </div>
                <div>
                    <h6>{$lang.lpr_txt_31}</h6>
                    <p>{$lang.lpr_txt_32}</p>
                    <figure>
                        <img src="{$path.images}hi/restaurants/img_6.png" alt="Background">
                    </figure>
                    <a data-target="4">{$lang.lpr_txt_46}</a>
                </div>
            </div>
        </div>
    </section>
    <section class="stn_6">
        <div>
            <div>
                <div>
                    <h6>{$lang.lpr_txt_33}</h6>
                    <h6>{$lang.lpr_txt_34}</h6>
                </div>
                <div>
                    <h2>{$lang.lpr_txt_35}</h2>
                    <span class="focus"><i class="far fa-grin-stars"></i></span>
                    <span class="focus"><i class="far fa-grin-stars"></i></span>
                </div>
                <div>
                    <h2>{$lang.lpr_txt_36}</h2>
                    <span class="focus"><i class="far fa-grin-stars"></i></span>
                    <span class="focus"><i class="far fa-grin-stars"></i></span>
                </div>
                <div>
                    <h2>{$lang.lpr_txt_37}</h2>
                    <span class="focus"><i class="far fa-grin-stars"></i></span>
                    <span class="focus"><i class="far fa-grin-stars"></i></span>
                </div>
                <div>
                    <h2>{$lang.lpr_txt_38}</h2>
                    <span class="focus"><i class="far fa-grin-stars"></i></span>
                    <span class="focus"><i class="far fa-grin-stars"></i></span>
                </div>
                <div>
                    <h2>{$lang.lpr_txt_39}</h2>
                    <span class="focus"><i class="far fa-grin-stars"></i></span>
                    <span class="focus"><i class="far fa-grin-stars"></i></span>
                </div>
                <div>
                    <h2>{$lang.lpr_txt_40}</h2>
                    <span class="focus"><i class="far fa-grin-stars"></i></span>
                    <span><i class="far fa-sad-cry"></i></span>
                </div>
                <div>
                    <h2>{$lang.lpr_txt_41}</h2>
                    <span class="focus"><i class="far fa-grin-stars"></i></span>
                    <span><i class="far fa-sad-cry"></i></span>
                </div>
                <div>
                    <h2>{$lang.lpr_txt_42}</h2>
                    <span class="focus"><i class="far fa-grin-stars"></i></span>
                    <span><i class="far fa-sad-cry"></i></span>
                </div>
                <div>
                    <h2>{$lang.lpr_txt_43}</h2>
                    <span class="focus"><i class="far fa-grin-stars"></i></span>
                    <span><i class="far fa-sad-cry"></i></span>
                </div>
                <div>
                    <h2>{$lang.lpr_txt_44}</h2>
                    <span class="focus"><i class="far fa-grin-stars"></i></span>
                    <span><i class="far fa-sad-cry"></i></span>
                </div>
                <div>
                    <h2>{$lang.lpr_txt_45}</h2>
                    <span class="focus"><i class="far fa-grin-stars"></i></span>
                    <span><i class="far fa-sad-cry"></i></span>
                </div>
                <div>
                    <a data-target="4">{$lang.lpr_txt_46}</a>
                    <a data-target="4">{$lang.lpr_txt_47}</a>
                </div>
            </div>
        </div>
    </section>
</main>
<main class="landing_page_restaurants <?php echo ((Session::get_value('hi')['restaurant']['target'] == '4') ? '' : 'hidden') ?>" data-target="4">

</main>
<main class="contacts">
    <a href="mailto:contacto@guestvox.com" data-email><i class="fas fa-envelope"></i></a>
    <a href="tel:+520987654321" data-phone><i class="fas fa-phone"></i></a>
    <a href="https://api.whatsapp.com/send?phone=+520987654321" data-whatsapp target="_blank"><i class="fab fa-whatsapp"></i></a>
</main>
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
<footer class="landing_page_restaurants">
    <div>
        <a target="_blank"><i class="fab fa-facebook-square"></i></a>
        <a target="_blank"><i class="fab fa-instagram"></i></a>
        <a target="_blank"><i class="fab fa-linkedin"></i></a>
        <a target="_blank"><i class="fab fa-youtube"></i></a>
    </div>
    <span>Copyright (C) Guestvox S.A.P.I. de C.V. | {$lang.all_right_reserved}</span>
    <!-- <div>
        <a>{$lang.terms_and_conditions}</a>
        <a>{$lang.privacy_policies}</a>
    </div> -->
</footer>
