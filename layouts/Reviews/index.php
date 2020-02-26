<?php

defined('_EXEC') or die;

$this->dependencies->add(['css', '{$path.plugins}data-tables/jquery.dataTables.min.css']);
$this->dependencies->add(['js', '{$path.plugins}data-tables/jquery.dataTables.min.js']);
$this->dependencies->add(['css', '{$path.css}Reviews/index.css']);
$this->dependencies->add(['js', '{$path.js}Reviews/index.js']);
// $this->dependencies->add(['other', '<script async defer src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBLCea8Q6BtcTHwY3YFCiB0EoHE5KnsMUE"></script>']);

?>

<header class="reviews">
    <div class="topbar">
        <figure class="logotype">
            <img src="{$logotype}" alt="Account logotype">
        </figure>
    </div>
</header>
<main class="reviews">
        <h4>{$name}</h4>
        <div class="contact">
            <span>{$address}</span>
            <a href="mailto:{$contact_email}">{$contact_email}</a>
            <a href="tel:{$contact_number}">+{$contact_number}</a>
        </div>
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
        <div class="information">
            <span>{$descriptive_information}</span>
        </div>
        <div>
            <table id="tbl_reviews_comments">
                <thead>
                    <tr>
                        <th align="left">{$lang.name}</th>
                        <th align="left" width="300px" >{$lang.comments}</th>
                    </tr>
                </thead>
                <tbody>
                    {$tbl_reviews_comments}
                </tbody>
            </table>
        </div>
</main>
<footer class="landing-page-index">
    <div class="container">
        <nav>
            <ul>
                {$contact_facebook}
                {$contact_instagram}
                {$contact_twitter}
                {$contact_youtube}
                {$contact_linkedin}
                {$contact_tripadvisor}
            </ul>
        </nav>
        <figure>
            <img src="{$path.images}logotype-color.png" alt="GuestVox logotype">
        </figure>
    </div>
</footer>
