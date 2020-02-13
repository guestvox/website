<?php

defined('_EXEC') or die;

$this->dependencies->add(['css', '{$path.css}Reviews/index.css']);
$this->dependencies->add(['js', '{$path.js}Reviews/index.js']);

?>

<main class="my-vox">
    <div class="menu">
        <h4>{$name}</h4>
        <div class="average">
            {$h4_general_average_rate}
            {$spn_general_avarage_rate}
        </div>
        <div class="progress">
            <span>5<i class="fas fa-star"></i></span>
            <progress value="{$five_percentage_rate}" max="100"></progress>
            <span>{$five_percentage_rate}%</span>
        </div>
        <div class="progress">
            <span>4<i class="fas fa-star"></i></span>
            <progress value="{$four_percentage_rate}" max="100"></progress>
            <span>{$four_percentage_rate}%</span>
        </div>
        <div class="progress">
            <span>3<i class="fas fa-star"></i></span>
            <progress value="{$tree_percentage_rate}" max="100"></progress>
            <span>{$tree_percentage_rate}%</span>
        </div>
        <div class="progress">
            <span>2<i class="fas fa-star"></i></span>
            <progress value="{$two_percentage_rate}" max="100"></progress>
            <span>{$two_percentage_rate}%</span>
        </div>
        <div class="progress">
            <span>1<i class="fas fa-star"></i></span>
            <progress value="{$one_percentage_rate}" max="100"></progress>
            <span>{$one_percentage_rate}%</span>
        </div>
    </div>
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
