<?php

defined('_EXEC') or die;

$this->dependencies->add(['css', '{$path.plugins}data-tables/jquery.dataTables.min.css']);
$this->dependencies->add(['js', '{$path.plugins}data-tables/jquery.dataTables.min.js']);
$this->dependencies->add(['css', '{$path.css}Reviews/index.css']);
$this->dependencies->add(['js', '{$path.js}Reviews/index.js']);

?>

<header class="reviews">
    <div class="topbar">
        <figure class="logotype">
            <img src="{$logotype}" alt="Account logotype">
        </figure>
    </div>
</header>
<main class="reviews">
        {$name}
        {$address}
        {$contact_email}
        {$contact_number}
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
            <iframe width="600" height="450" frameborder="0" style="border:0"
                src="https://www.google.com/maps/embed/v1/place?q=place_id:ChIJJzc5iSZDTo8RAhITSspkB5Q&key=AIzaSyDciZm7zomBLUwx6_Ez44OegZNMiC7tX3o" allowfullscreen>
            </iframe>
            <div class="">
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
        </div>

</main>
<footer class="landing-page-index">
    <div class="container">
        <nav>
            <ul>
                <li><a href="https://facebook.com/guestvox" class="btn" target="_blank"><i class="fab fa-facebook-square"></i></a></li>
                <li><a href="https://instagram.com/guestvox" class="btn" target="_blank"><i class="fab fa-instagram"></i></a></li>
                <li><a href="https://linkedin.com/guestvox" class="btn" target="_blank"><i class="fab fa-linkedin"></i></a></li>
                <li><a href="https://www.youtube.com/channel/UCKSAce4n1NqahbL5RQ8QN9Q" class="btn" target="_blank"><i class="fab fa-youtube" ></i></i></a></li>
            </ul>
        </nav>
        <figure>
            <img src="{$path.images}logotype-color.png" alt="GuestVox logotype">
        </figure>
    </div>
</footer>
