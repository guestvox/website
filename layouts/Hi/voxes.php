<?php

defined('_EXEC') or die;

$this->dependencies->add(['js', '{$path.plugins}owl_carousel/owl.carousel.min.js']);
$this->dependencies->add(['css', '{$path.plugins}owl_carousel/assets/owl.carousel.min.css']);
$this->dependencies->add(['css', '{$path.plugins}owl_carousel/assets/owl.theme.default.min.css']);
$this->dependencies->add(['css', '{$path.plugins}fancy_box/jquery.fancybox.min.css']);
$this->dependencies->add(['js', '{$path.plugins}fancy_box/jquery.fancybox.min.js']);
$this->dependencies->add(['css', '{$path.css}Hi/voxes.css']);
$this->dependencies->add(['js', '{$path.js}Hi/voxes.js']);

?>

<main class="landing_page_voxes">
    <header class="topbar">
        <figure>
            <img src="{$path.images}hi/voxes/logotype_white.png" alt="Guestvox">
        </figure>
        <nav>
            <ul>
                <li><a class="btn" data-button-modal="contact">{$lang.request_your_demo}</a></li>
            </ul>
        </nav>
    </header>
    <section class="main">
        <header class="cover">
            <div class="container">
                <div class="content">
                    <h1>{$lang.landing_page_hi_voxes_text_1}</h1>
                    <h2>{$lang.landing_page_hi_voxes_text_2}</h2>
                    <a class="btn" data-button-modal="contact">{$lang.request_your_demo}</a>
                </div>
                <figure>
                    <img src="{$path.images}hi/voxes/screen_1.jpg" alt="Background">
                </figure>
            </div>
            <div class="rocket"></div>
        </header>
        <section class="container background">
            <div class="space50"></div>
            <div class="title">
                <h2>{$lang.landing_page_hi_voxes_text_3}</h2>
                <p>...</p>
            </div>
            <div class="space50"></div>
            <div class="boxes three_boxes">
                <div class="box">
                    <span class="icon_communication"></span>
                    <h4>{$lang.landing_page_hi_voxes_text_4}</h4>
                </div>
                <div class="box">
                    <span class="icon_clients"></span>
                    <h4>{$lang.landing_page_hi_voxes_text_5}</h4>
                </div>
                <div class="box">
                    <span class="icon_like"></span>
                    <h4>{$lang.landing_page_hi_voxes_text_6}</h4>
                </div>
            </div>
            <div class="space100"></div>
            <div class="title">
                <h2>{$lang.landing_page_hi_voxes_text_7}</h2>
                <p>...</p>
            </div>
            <div class="space50"></div>
            <div class="boxes_product">
                <div class="box">
                    <figure>
                        <img src="{$path.images}hi/voxes/icon_lock.svg" alt="Icon" width="70" height="70">
                    </figure>
                    <h4>{$lang.landing_page_hi_voxes_text_8}</h4>
                    <p>{$lang.landing_page_hi_voxes_text_9}</p>
                </div>
                <div class="box">
                    <figure>
                        <img src="{$path.images}hi/voxes/icon_person.svg" alt="Icon" width="70" height="70">
                    </figure>
                    <h4>{$lang.landing_page_hi_voxes_text_10}</h4>
                    <p>{$lang.landing_page_hi_voxes_text_11}</p>
                </div>
                <div class="box">
                    <figure>
                        <img src="{$path.images}hi/voxes/icon_attachment.svg" alt="Icon" width="70" height="70">
                    </figure>
                    <h4>{$lang.landing_page_hi_voxes_text_12}</h4>
                    <p>{$lang.landing_page_hi_voxes_text_13}</p>
                </div>
                <div class="box">
                    <figure>
                        <img src="{$path.images}hi/voxes/icon_person_follow.svg" alt="Icon" width="70" height="70">
                    </figure>
                    <h4>{$lang.landing_page_hi_voxes_text_14}</h4>
                    <p>{$lang.landing_page_hi_voxes_text_15}</p>
                </div>
                <div class="box">
                    <figure>
                        <img src="{$path.images}hi/voxes/icon_time.svg" alt="Icon" width="70" height="70">
                    </figure>
                    <h4>{$lang.landing_page_hi_voxes_text_16}</h4>
                    <p>{$lang.landing_page_hi_voxes_text_17}</p>
                </div>
                <div class="box">
                    <figure>
                        <img src="{$path.images}hi/voxes/icon_multi_device.svg" alt="Icon" width="70" height="70">
                    </figure>
                    <h4>{$lang.landing_page_hi_voxes_text_18}</h4>
                    <p>{$lang.landing_page_hi_voxes_text_19}</p>
                </div>
            </div>
        </section>
        <section class="call_to_action">
            <div class="container">
                <div class="content">
                    <h4>{$lang.landing_page_hi_voxes_text_20}</h4>
                </div>
                <a data-button-modal="contact">{$lang.request_your_demo}</a>
            </div>
        </section>
        <section class="container background">
            <div class="title">
                <h2>{$lang.landing_page_hi_voxes_text_21}</h2>
                <p>{$lang.landing_page_hi_voxes_text_22}</p>
            </div>
            <div class="space50"></div>
            <div id="screenshots" class="owl-carousel owl-theme">
                <div class="item" style="background-image: url('{$path.images}hi/voxes/screenshot_1_thumb.jpg');">
                    <a data-fancybox="gallery" href="{$path.images}hi/voxes/screenshot_1.jpg"></a>
                </div>
                <div class="item" style="background-image: url('{$path.images}hi/voxes/screenshot_2_thumb.jpg');">
                    <a data-fancybox="gallery" href="{$path.images}hi/voxes/screenshot_2.jpg"></a>
                </div>
                <div class="item" style="background-image: url('{$path.images}hi/voxes/screenshot_3_thumb.jpg');">
                    <a data-fancybox="gallery" href="{$path.images}hi/voxes/screenshot_3.jpg"></a>
                </div>
                <div class="item" style="background-image: url('{$path.images}hi/voxes/screenshot_4_thumb.jpg');">
                    <a data-fancybox="gallery" href="{$path.images}hi/voxes/screenshot_4.jpg"></a>
                </div>
                <div class="item" style="background-image: url('{$path.images}hi/voxes/screenshot_5_thumb.jpg');">
                    <a data-fancybox="gallery" href="{$path.images}hi/voxes/screenshot_5.jpg"></a>
                </div>
            </div>
        </section>
    </section>
    <footer class="main">
        <div class="container">
            <h2>{$lang.landing_page_hi_voxes_text_23}</h2>
            <h3>{$lang.landing_page_hi_voxes_text_24}</h3>
            <a class="btn" data-button-modal="contact">{$lang.request_your_demo}</a>
            <ul class="social_media">
                <li><a href="https://www.facebook.com/Guestvox/" target="_blank">Facebook</a></li>
                <li><a href="https://www.instagram.com/guestvox/" target="_blank">Instagram</a></li>
                <li><a href="https://www.linkedin.com/company/guestvox/" target="_blank">LinkedIn</a></li>
                <li><a href="https://www.youtube.com/channel/UCKSAce4n1NqahbL5RQ8QN9Q" target="_blank">YouTube</a></li>
            </ul>
            <div class="copyright">
                <strong>guestvox.com</strong> {$lang.all_right_reserved}
            </div>
        </div>
    </footer>
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
                            <a class="delete" button-cancel><i class="fas fa-times"></i></a>
                            <button type="submit" class="new"><i class="fas fa-check"></i></button>
                        </div>
                    </div>
                </div>
            </form>
        </main>
    </div>
</section>
