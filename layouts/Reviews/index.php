<?php

defined('_EXEC') or die;

$this->dependencies->add(['css', '{$path.css}Reviews/index.css']);
$this->dependencies->add(['js', '{$path.js}Reviews/index.js']);
// $this->dependencies->add(['other', '<script async defer src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBLCea8Q6BtcTHwY3YFCiB0EoHE5KnsMUE"></script>']);

?>

<header class="reviews">
    <figure>
        <img src="{$logotype}" alt="Client">
    </figure>
</header>
<main class="reviews">
    <div class="container">
        <div class="chart-rate">
            <div class="average">
                {$h2_surveys_average}
                {$spn_surveys_average}
            </div>
            <div class="progress">
                <span>5<i class="fas fa-star"></i></span>
                <progress value="{$five_surveys_porcentage}" max="100"></progress>
                <span>{$five_surveys_porcentage}%</span>
            </div>
            <div class="progress">
                <span>4<i class="fas fa-star"></i></span>
                <progress value="{$four_surveys_porcentage}" max="100"></progress>
                <span>{$four_surveys_porcentage}%</span>
            </div>
            <div class="progress">
                <span>3<i class="fas fa-star"></i></span>
                <progress value="{$tree_surveys_porcentage}" max="100"></progress>
                <span>{$tree_surveys_porcentage}%</span>
            </div>
            <div class="progress">
                <span>2<i class="fas fa-star"></i></span>
                <progress value="{$two_surveys_porcentage}" max="100"></progress>
                <span>{$two_surveys_porcentage}%</span>
            </div>
            <div class="progress">
                <span>1<i class="fas fa-star"></i></span>
                <progress value="{$one_surveys_porcentage}" max="100"></progress>
                <span>{$one_surveys_porcentage}%</span>
            </div>
        </div>
        <div class="datas">
            <h1>{$name}</h1>
            <a href="" target="_blank"><i class="fas fa-map-marker-alt"></i>{$address}</a>
            <a href="mailto:{$email}"><i class="fas fa-envelope"></i>{$email}</a>
            <a href="tel:{$phone}"><i class="fas fa-phone"></i>{$phone}</a>
            <a href="https://{$website}" target="_blank"><i class="fas fa-globe"></i>{$website}</a>
            <p>{$description}</p>
        </div>
        <div class="clear"></div>
        {$tbl_surveys_comments}
        <div class="social-media">
            {$facebook}
            {$instagram}
            {$twitter}
            {$linkedin}
            {$youtube}
            {$google}
            {$tripadvisor}
        </div>
    </div>
</main>
<footer class="reviews">
    <h4>Power by <img src="{$path.images}logotype-color.png" alt="Guestvox"></h4>
    <p>Copyright<i class="far fa-copyright"></i>{$lang.all_right_reserved}</p>
</footer>
