<?php

defined('_EXEC') or die;

$this->dependencies->add(['css', '{$path.css}Hi/restaurants.css']);
$this->dependencies->add(['js', '{$path.js}Hi/restaurants.js']);

?>

<header class="landing_page_restaurants">
    <div class="container">
        <figure>
            <img src="{$path.images}logotype_color.png" alt="Guestvox">
        </figure>
        <nav>
            <a href="" class="active" data-target="1">{$lang.lpr_txt_1}</a>
            <a href="" data-target="2">{$lang.lpr_txt_2}</a>
            <a href="" data-target="3">{$lang.lpr_txt_3}</a>
            <a href="" class="focus" data-target="4">{$lang.lpr_txt_4}</a>
        </nav>
        <a data-action="lpr_opn_mnu"><i class="fas fa-bars"></i></a>
    </div>
</header>
<main class="landing_page_restaurants" data-target="1">
    <section class="stn_1">
        <div>
            <figure>
                <img src="{$path.images}hi/restaurants/img_1.png" alt="Background">
            </figure>
            <div>
                <h1>{$lang.lpr_txt_5}</h1>
                <h2>{$lang.lpr_txt_6}</h2>
                <p>{$lang.lpr_txt_7}</p>
                <a href="">{$lang.lpr_txt_8}</a>
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
                        <a href=""><i class="fas fa-star"></i></a>
                        <a href=""><i class="fas fa-star"></i></a>
                        <a href=""><i class="fas fa-heart"></i></a>
                        <a href=""><i class="fas fa-bullhorn"></i></a>
                        <a href=""><i class="fas fa-grin"></i></a>
                    </div>
                    <a href="">{$lang.lpr_txt_15}</a>
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
                        <span>1</span>
                        <h2>{$lang.lpr_txt_16}</h2>
                    </div>
                    <div>
                        <span>2</span>
                        <h2>{$lang.lpr_txt_17}<span>{$lang.lpr_txt_18}</span></h2>
                    </div>
                    <div>
                        <span>3</span>
                        <h2>{$lang.lpr_txt_19}<span>{$lang.lpr_txt_20}</span></h2>
                    </div>
                    <div>
                        <span>4</span>
                        <h2>{$lang.lpr_txt_21}<span>{$lang.lpr_txt_22}</span></h2>
                    </div>
                    <div>
                        <span>5</span>
                        <h2>{$lang.lpr_txt_23}<span>{$lang.lpr_txt_24}</span></h2>
                    </div>
                    <a href="">{$lang.lpr_txt_25}</a>
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
                <a href="">{$lang.lpr_txt_27}</a>
                <span><i class="fas fa-headset"></i>{$lang.lpr_txt_28}</span>
            </div>
        </div>
    </section>
</main>
<main class="landing_page_restaurants hidden" data-target="3">
    <section class="stn_5">
        <div>
            <div>
                <div>
                    <span>{$lang.lpr_txt_29}</span>
                    <p>{$lang.lpr_txt_30}</p>
                    <figure>
                        <img src="{$path.images}hi/restaurants/img_5.png" alt="Background">
                    </figure>
                </div>
                <div>
                    <span>{$lang.lpr_txt_31}</span>
                    <p>{$lang.lpr_txt_32}</p>
                    <figure>
                        <img src="{$path.images}hi/restaurants/img_6.png" alt="Background">
                    </figure>
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
                    <span><i class="far fa-grin-stars"></i></span>
                    <span><i class="far fa-grin-stars"></i></span>
                </div>
                <div>
                    <h2>{$lang.lpr_txt_36}</h2>
                    <span><i class="far fa-grin-stars"></i></span>
                    <span><i class="far fa-grin-stars"></i></span>
                </div>
                <div>
                    <h2>{$lang.lpr_txt_37}</h2>
                    <span><i class="far fa-grin-stars"></i></span>
                    <span><i class="far fa-grin-stars"></i></span>
                </div>
                <div>
                    <h2>{$lang.lpr_txt_38}</h2>
                    <span><i class="far fa-grin-stars"></i></span>
                    <span><i class="far fa-grin-stars"></i></span>
                </div>
                <div>
                    <h2>{$lang.lpr_txt_39}</h2>
                    <span><i class="far fa-grin-stars"></i></span>
                    <span><i class="far fa-grin-stars"></i></span>
                </div>
                <div>
                    <h2>{$lang.lpr_txt_40}</h2>
                    <span><i class="far fa-grin-stars"></i></span>
                    <span class="focus"><i class="far fa-sad-cry"></i></span>
                </div>
                <div>
                    <h2>{$lang.lpr_txt_41}</h2>
                    <span><i class="far fa-grin-stars"></i></span>
                    <span class="focus"><i class="far fa-sad-cry"></i></span>
                </div>
                <div>
                    <h2>{$lang.lpr_txt_42}</h2>
                    <span><i class="far fa-grin-stars"></i></span>
                    <span class="focus"><i class="far fa-sad-cry"></i></span>
                </div>
                <div>
                    <h2>{$lang.lpr_txt_43}</h2>
                    <span><i class="far fa-grin-stars"></i></span>
                    <span class="focus"><i class="far fa-sad-cry"></i></span>
                </div>
                <div>
                    <h2>{$lang.lpr_txt_44}</h2>
                    <span><i class="far fa-grin-stars"></i></span>
                    <span class="focus"><i class="far fa-sad-cry"></i></span>
                </div>
                <div>
                    <h2>{$lang.lpr_txt_45}</h2>
                    <span><i class="far fa-grin-stars"></i></span>
                    <span class="focus"><i class="far fa-sad-cry"></i></span>
                </div>
                <div>
                    <h6>{$lang.lpr_txt_46}</h6>
                    <h6>{$lang.lpr_txt_47}</h6>
                </div>
            </div>
        </div>
    </section>
</main>
<footer class="landing_page_restaurants">
    <div>
        <a href="" target="_blank"><i class="fab fa-facebook-square"></i></a>
        <a href="" target="_blank"><i class="fab fa-instagram"></i></a>
        <a href="" target="_blank"><i class="fab fa-linkedin"></i></a>
        <a href="" target="_blank"><i class="fab fa-youtube"></i></a>
    </div>
    <div>
        <a href="">{$lang.terms_and_conditions}</a>
        <a href="">{$lang.privacy_policies}</a>
    </div>
    <span>Copyright (C) {$lang.all_right_reserved}</span>
</footer>
