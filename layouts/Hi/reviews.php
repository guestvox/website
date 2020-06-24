<?php

defined('_EXEC') or die;

$this->dependencies->add(['css', '{$path.css}Hi/reviews.css']);
$this->dependencies->add(['js', '{$path.js}Hi/reviews.js']);

?>

<header class="landing_page_reviews">
    <a data-button-modal="contact"><i class="fas fa-qrcode"></i></a>
    <a data-button-modal="contact"><i class="fas fa-paper-plane"></i></a>
    <a data-button-modal="contact"><i class="fas fa-gift"></i></a>
    <figure>
        <img src="{$path.images}imagotype_white.png" alt="Guestvox">
    </figure>
</header>
<main class="landing_page_reviews">
    <section id="section_one" class="gradient hand_background">
        <div class="container">
            <figure class="logotype">
                <img src="{$path.images}hi/reviews/logotype_color.png" alt="Guestvox">
            </figure>
            <div class="content">
                <h3>{$lang.landing_page_hi_reviews_text_1}</h3>
                <p>{$lang.landing_page_hi_reviews_text_2}</p>
            </div>
        </div>
    </section>
    <section id="section_two" class="gradient_t">
        <div class="container">
            <div class="space50"></div>
            <div class="content">
                <div>
                    <span class="st_2_img_1"></span>
                    <div class="box">
                        <p>{$lang.landing_page_hi_reviews_text_3}</p>
                    </div>
                </div>
                <div>
                    <span class="st_2_img_2"></span>
                    <div class="box">
                        <p>{$lang.landing_page_hi_reviews_text_4}</p>
                    </div>
                </div>
                <div>
                    <span class="st_2_img_3"></span>
                    <div class="box">
                        <p>{$lang.landing_page_hi_reviews_text_5}</p>
                    </div>
                </div>
            </div>
            <div class="space50"></div>
            <a data-button-modal="contact" class="btn">{$lang.request_your_demo}</a>
            <div class="space50"></div>
        </div>
    </section>
    <!-- <section id="section_three">
        <div class="container">
            <h3>{$lang.landing_page_hi_reviews_text_6}</h3>
            <figure>
                <img src="{$path.images}hi/reviews/st_3_img_1.png" alt="Background">
            </figure>
        </div>
        <span class="st_2_img_1"></span>
    </section> -->
    <section id="section_four">
        <div class="container">
            <h3>{$lang.landing_page_hi_reviews_text_7}</h3>
        </div>
        <span>{$lang.landing_page_hi_reviews_text_8}<span class="st_2_img_1"></span></span>
    </section>
    <section id="section_five">
        <div class="container">
            <h5>{$lang.landing_page_hi_reviews_text_9}</h5>
            <div>
                <img src="{$path.images}hi/reviews/pantalla_ipad.png" alt="Background">
                <div class="content">
                    <h3>{$lang.landing_page_hi_reviews_text_10}</h3>
                    <a data-button-modal="contact" class="btn">{$lang.request_your_demo}</a>
                </div>
            </div>
        </div>
    </section>
    <section id="section_six">
        <div class="container">
            <h3>{$lang.landing_page_hi_reviews_text_11}</h3>
        </div>
    </section>
    <!-- <section id="section_seven">
        <div class="container">
            <h3>{$lang.landing_page_hi_reviews_text_12}</h3>
            <img src="{$path.images}hi/reviews/graficas.png" alt="Background">
        </div>
    </section>
    <section id="section_eight">
        <div class="container">
            <h3>{$lang.landing_page_hi_reviews_text_13}</h3>
            <p>{$lang.landing_page_hi_reviews_text_14}</p>
        </div>
    </section> -->
    <section id="section_nine" class="gradient_c_r">
        <div class="container">
            <div class="content">
                <img src="https://api.qrserver.com/v1/create-qr-code/?size=200x200&data=https://guestvox.com/demorestaurante/myvox" alt="QR">
                <h4>{$lang.landing_page_hi_reviews_text_15}</h4>
                <p>{$lang.landing_page_hi_reviews_text_16}</p>
            </div>
            <h3>{$lang.landing_page_hi_reviews_text_17}</h3>
        </div>
    </section>
    <section id="section_ten" class="gradient_c_l">
        <div class="container">
            <div class="content">
                <a data-button-modal="contact" class="btn">{$lang.request_your_demo}</a>
            </div>
            <div class="content">
                <figure class="logotype">
                    <img src="{$path.images}hi/reviews/logotype_color.png" alt="Guestvox">
                </figure>
                <a href="https://facebook.com/guestvox" class="social_media fb_logo" target="_blank">Facebook</a>
                <a href="https://www.youtube.com/channel/UCKSAce4n1NqahbL5RQ8QN9Q" class="social_media yt_logo" target="_blank">YouTube</a>
                <a href="https://instagram.com/guestvox" class="social_media ig_logo" target="_blank">Instagram</a>
                <a href="https://linkedin.com/guestvox" class="social_media in_logo" target="_blank">LinkedIn</a>
            </div>
        </div>
    </section>
</main>
<section class="modal" data-modal="contact">
    <div class="content">
        <main>
            <form name="contact">
                <div class="row">
                    <div class="span12">
                        <div class="label">
                            <label required>
                                <p>{$lang.business}</p>
                                <input type="text" name="business">
                            </label>
                        </div>
                    </div>
                    <div class="span12">
                        <div class="label">
                            <label required>
                                <p>{$lang.type}</p>
                                <select name="type">
                                    <option value="" hidden>{$lang.choose}</option>
                                    <option value="hotel">{$lang.hotel}</option>
                                    <option value="restaurant">{$lang.restaurant}</option>
                                    <option value="hospital">{$lang.hospital}</option>
                                    <option value="others">{$lang.others}</option>
                                </select>
                            </label>
                        </div>
                    </div>
                    <div class="span4 hidden">
                        <div class="label">
                            <label required>
                                <p>{$lang.n_rooms}</p>
                                <input type="number" name="rooms">
                            </label>
                        </div>
                    </div>
                    <div class="span12">
                        <div class="label">
                            <label required>
                                <p>{$lang.name}</p>
                                <input type="text" name="name">
                            </label>
                        </div>
                    </div>
                    <div class="span6">
                        <div class="label">
                            <label required>
                                <p>{$lang.email}</p>
                                <input type="text" name="email">
                            </label>
                        </div>
                    </div>
                    <div class="span6">
                        <div class="label">
                            <label required>
                                <p>{$lang.phone}</p>
                                <input type="text" name="phone">
                            </label>
                        </div>
                    </div>
                    <div class="span12">
                        <p>{$lang.to_send_form}</p>
                    </div>
                    <div class="span12">
                        <div class="buttons">
                            <a button-cancel><i class="fas fa-times"></i></a>
                            <button type="submit"><i class="fas fa-check"></i></button>
                        </div>
                    </div>
                </div>
            </form>
        </main>
    </div>
</section>
