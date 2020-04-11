<?php

defined('_EXEC') or die;

$this->dependencies->add(['css', '{$path.css}Index/index.css']);
$this->dependencies->add(['js', '{$path.js}Index/index.js']);

?>

<main class="landing-page-index">
    <section class="st-1">
		<figure>
			<img src="{$path.images}index/st-1-image-1.png" alt="Background">
		</figure>
        <div>
            <figure>
                <img src="{$path.images}logotype-white.png" alt="Logotype">
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
            <a href="/operation">{$lang.know_more}</a>
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
            <a href="/reputation">{$lang.know_more}</a>
		</div>
    </section>
    <section class="st-4">
        <div>
            <i class="fas fa-tablet-alt"></i>
            <p>{$lang.landing_page_index_st_4_text_1}</p>
        </div>
        <div>
            <i class="fas fa-cloud"></i>
            <p>{$lang.landing_page_index_st_4_text_2}</p>
        </div>
        <div>
            <i class="fas fa-lock"></i>
            <p>{$lang.landing_page_index_st_4_text_3}</p>
        </div>
        <div>
            <i class="fas fa-chart-area"></i>
            <p>{$lang.landing_page_index_st_4_text_4}</p>
        </div>
    </section>
    <section class="st-5">
		<h2>{$lang.landing_page_index_st_5_text_1}</h2>
        <div>
            <figure>
                <img src="{$path.images}index/st-5-image-1.png" alt="Logotype">
            </figure>
            <figure>
                <img src="{$path.images}index/st-5-image-2.png" alt="Logotype">
            </figure>
            <figure>
                <img src="{$path.images}index/st-5-image-3.png" alt="Logotype">
            </figure>
            <figure>
                <img src="{$path.images}index/st-5-image-4.png" alt="Logotype">
            </figure>
        </div>
    </section>
    <section class="st-6">
        <div>
            <i class="fas fa-user-plus"></i>
            <h2>{$lang.landing_page_index_st_6_text_1}</h2>
            <a href="/signup">{$lang.signup}</a>
        </div>
        <div>
            <i class="fas fa-th"></i>
            <h2>{$lang.landing_page_index_st_6_text_2}</h2>
            <a href="/blog">{$lang.blog}</a>
        </div>
    </section>
    <section class="st-7">
        <h2>{$lang.landing_page_index_st_7_text_1}</h2>
        <div>
            <figure>
                <img src="{$path.images}index/st-7-image-1.png" alt="Avatar">
            </figure>
            <h3>Daniel Basurto</h3>
            <h4>{$lang.ceo}</h4>
        </div>
        <div>
            <figure>
                <img src="{$path.images}index/st-7-image-2.png" alt="Avatar">
            </figure>
            <h3>Alexa Zamora</h3>
            <h4>{$lang.cpo}</h4>
        </div>
        <div>
            <figure>
                <img src="{$path.images}index/st-7-image-3.png" alt="Avatar">
            </figure>
            <h3>Gersón Gómez</h3>
            <h4>{$lang.cto}</h4>
        </div>
        <div>
            <figure>
                <img src="{$path.images}index/st-7-image-4.png" alt="Avatar">
            </figure>
            <h3>Saúl Poot</h3>
            <h4>{$lang.programmer}</h4>
        </div>
        <div>
            <figure>
                <img src="{$path.images}index/st-7-image-5.png" alt="Avatar">
            </figure>
            <h3>Alejandro Espinoza</h3>
            <h4>{$lang.programmer}</h4>
        </div>
        <div>
            <figure>
                <img src="{$path.images}index/st-7-image-6.png" alt="Avatar">
            </figure>
            <h3>David Gómez</h3>
            <h4>{$lang.programmer}</h4>
        </div>
    </section>
    <section class="st-8">
        <h2>{$lang.landing_page_index_st_8_text_1}</h2>
        <div>
            <figure>
                <img src="{$path.images}index/st-8-image-1.png" alt="Logotype">
            </figure>
            <figure>
                <img src="{$path.images}index/st-8-image-2.png" alt="Logotype">
            </figure>
            <figure>
                <img src="{$path.images}index/st-8-image-3.png" alt="Logotype">
            </figure>
            <figure>
                <img src="https://www.comparasoftware.com/wp-content/uploads/2019/05/comparasoftware_verificado.png" alt="Logotype">
            </figure>
        </div>
    </section>
    <section class="st-9">
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
        </div>
        <p>Copyright<i class="far fa-copyright"></i>{$lang.all_right_reserved}</p>
    </section>
</main>
