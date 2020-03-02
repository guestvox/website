<?php

defined('_EXEC') or die;

$this->dependencies->add(['css', '{$path.plugins}data-tables/jquery.dataTables.min.css']);
$this->dependencies->add(['js', '{$path.plugins}data-tables/jquery.dataTables.min.js']);
$this->dependencies->add(['css', '{$path.css}Reviews/index.css']);
$this->dependencies->add(['js', '{$path.js}Reviews/index.js']);
// $this->dependencies->add(['other', '<script async defer src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBLCea8Q6BtcTHwY3YFCiB0EoHE5KnsMUE"></script>']);

?>

<header class="landing-page-reviews">
    <figure>
        <img src="{$logotype}" alt="Logotype">
    </figure>
</header>
<main class="landing-page-reviews">
    <div class="container">
        <div class="chart-rate">
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
        <div class="datas">
            <h4>{$name}</h4>
            <a href="" target="_blank"><i class="fas fa-map-marker-alt"></i>{$address}</a>
            <a href="mailto:{$email}"><i class="fas fa-envelope"></i>{$email}</a>
            <a href="tel:{$phone}"><i class="fas fa-phone"></i>{$phone}</a>
            <a href="https://{$website}" target="_blank"><i class="fas fa-globe"></i>{$website}</a>
            <p>{$description}</p>
        </div>
        <div class="clear"></div>
        <div class="comments">
            {$tbl_comments}
        </div>
    </div>
</main>
<footer class="landing-page-reviews">
    <div class="container">
        <nav>
            <ul>
                {$facebook}
                {$instagram}
                {$twitter}
                {$linkedin}
                {$youtube}
                {$google}
                {$tripadvisor}
            </ul>
        </nav>
        <figure>
            <img src="{$path.images}logotype-color.png" alt="GuestVox logotype">
        </figure>
    </div>
</footer>
