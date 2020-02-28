<?php

defined('_EXEC') or die;

$this->dependencies->add(['css', '{$path.plugins}data-tables/jquery.dataTables.min.css']);
$this->dependencies->add(['js', '{$path.plugins}data-tables/jquery.dataTables.min.js']);
$this->dependencies->add(['css', '{$path.css}Reviews/index.css']);
$this->dependencies->add(['js', '{$path.js}Reviews/index.js']);
// $this->dependencies->add(['other', '<script async defer src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBLCea8Q6BtcTHwY3YFCiB0EoHE5KnsMUE"></script>']);

?>

<main class="landing-page-reviews">
    <figure>
        <img src="{$logotype}" alt="Account logotype">
    </figure>
    <h4>{$name}</h4>
    <p>{$address}</p>
    <a href="mailto:{$email}">{$email}</a>
    <a href="tel:{$phone}">{$phone}</a>
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
    <p>{$description}</p>
    <table id="tbl_comments">
        <tbody>
            {$tbl_comments}
        </tbody>
    </table>
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
