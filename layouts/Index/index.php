<?php

defined('_EXEC') or die;

$this->dependencies->add(['css', '{$path.css}Index/index.css']);
$this->dependencies->add(['js', '{$path.js}Index/index.js']);

?>

<header class="landing-page-index">
    <div class="container">
        <figure>
            <img src="{$path.images}logotype-white.png" alt="GuestVox logotype">
        </figure>
        <nav>
            <ul>
                <li><a href="/blog" class="btn no-border">{$lang.our_blog}</a></li>
                <li><a href="/signup" class="btn">{$lang.start_free_demo}</a></li>
                <li><a href="/login" class="btn">{$lang.login}</a></li>
                <li><a href="?<?php echo Language::get_lang_url('es'); ?>" class="btn no-border lang"><img src="{$path.images}es.png" alt="ES Lang"></a></li>
                <li><a href="?<?php echo Language::get_lang_url('en'); ?>" class="btn no-border lang"><img src="{$path.images}en.png" alt="EN Lang"></a></li>
            </ul>
            <ul>
                <li><a class="btn" data-action="open-land-menu"><i class="fas fa-bars"></i></a></li>
            </ul>
        </nav>
    </div>
</header>
<main class="landing-page-index">
    <section class="home">
    	<div class="container">
    		<figure>
    			<img src="{$path.images}home.png" alt="Home background">
    		</figure>
            <div>
    			<h4>{$lang.im_the_guests_voice}</h4>
    			<h1>{$lang.manages_correctly_the_incidents}</h1>
    		</div>
    	</div>
    </section>
    <section class="features-one">
    	<div class="container">
    		<h2>{$lang.how_do_we_help_your_hotel}</h2>
            <div>
                <img src="/images/feature-1.svg" alt="Feature">
                <p>{$lang.capture_all_kinds}</p>
            </div>
            <div>
                <img src="/images/feature-2.svg" alt="Feature">
                <p>{$lang.coordinate_follow_cases}</p>
            </div>
            <div>
                <img src="/images/feature-3.svg" alt="Feature">
                <p>{$lang.control_performance_your_hotel}</p>
            </div>
            <div>
                <img src="/images/feature-4.svg" alt="Feature">
                <p>{$lang.check_metrics_best_decisions}</p>
            </div>
    	</div>
    </section>
    <section class="features-two">
		<div>
            <ul class="container">
                <li><i class="fas fa-check"></i>{$lang.multi_device}</li>
                <li><i class="fas fa-check"></i>{$lang.on_the_cloud}</li>
                <li><i class="fas fa-check"></i>{$lang.100_encrypted_safe}</li>
                <li><i class="fas fa-check"></i>{$lang.simple}</li>
                <li><a href="/signup" class="btn">{$lang.start_free_demo}</a></li>
            </ul>
        </div>
    </section>
    <section class="clients">
    	<div class="container">
    		<h2>{$lang.they_already_trust_us}</h2>
            <div>
                <figure>
                    <img src="{$path.images}clients-1.jpg" alt="Client logotype">
                </figure>
                <figure>
                    <img src="{$path.images}clients-2.jpg" alt="Client logotype">
                </figure>
                <figure>
                    <img src="{$path.images}clients-3.jpg" alt="Client logotype">
                </figure>
                <figure>
                    <img src="{$path.images}clients-4.jpg" alt="Client logotype">
                </figure>
                <figure>
                    <img src="{$path.images}clients-5.jpg" alt="Client logotype">
                </figure>
                <figure>
                    <img src="{$path.images}clients-6.jpg" alt="Client logotype">
                </figure>
            </div>
            <a href="/signup" class="btn">{$lang.start_free_demo}</a>
    	</div>
    </section>
    <section class="team">
        <div>
            <div>
                <figure>
                    <img src="{$path.images}basurto.png" alt="Member team avatar">
                </figure>
            </div>
            <span><strong>Daniel Basurto</strong></span>
            <span>{$lang.ceo_cofounder}</span>
        </div>
        <div>
            <div>
                <figure>
                    <img src="{$path.images}gerson.png" alt="Member team avatar">
                </figure>
            </div>
            <span><strong>Gersón Gómez</strong></span>
            <span>{$lang.cto}</span>
        </div>
        <div>
            <div>
                <figure>
                    <img src="{$path.images}saul.png" alt="Member team avatar">
                </figure>
            </div>
            <span><strong>Saúl Poot</strong></span>
            <span>{$lang.chief_programmer}</span>
        </div>
    </section>
</main>
<footer class="landing-page-index">
    <div class="container">
        <div class="widget_cs">
            <p align="center"><a href="https://www.comparasoftware.com/guestvox/"><img src="https://www.comparasoftware.com/wp-content/uploads/2019/05/comparasoftware_verificado.png" alt="logo_verificado" width="180"/></a></p>
            <p style="text-align: center;" align="center"><a href="https://www.comparasoftware.com/guestvox/"> GuestVox</a> se encuentra verificada como <a href="https://www.comparasoftware.com/hoteleria/"> software de Hotelería</a></p>
        </div>
        <nav>
            <ul>
                <li><a href="https://facebook.com/guestvox" class="btn" target="_blank"><i class="fab fa-facebook-square"></i></a></li>
                <li><a href="https://instagram.com/guestvox" class="btn" target="_blank"><i class="fab fa-instagram"></i></a></li>
                <li><a href="https://linkedin.com/guestvox" class="btn" target="_blank"><i class="fab fa-linkedin"></i></a></li>
                <li><a href="https://www.youtube.com/channel/UCKSAce4n1NqahbL5RQ8QN9Q" class="btn" target="_blank"><i class="fab fa-youtube" ></i></i></a></li>
                <li><a href="/copyright" class="btn no-border">{$lang.copyright}</a></li>
                <li><a href="/terms" class="btn no-border">{$lang.terms_conditions}</a></li>
            </ul>
        </nav>
        <figure>
            <img src="{$path.images}logotype-color.png" alt="GuestVox logotype">
        </figure>
    </div>
</footer>
