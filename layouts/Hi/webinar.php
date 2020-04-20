<?php

defined('_EXEC') or die;

$this->dependencies->add(['css', '{$path.css}Hi/webinar.css']);
$this->dependencies->add(['js', '{$path.js}Hi/webinar.js']);
$this->dependencies->add(['js', '{$path.plugins}moment/moment.min.js']);
$this->dependencies->add(['js', '{$path.plugins}moment/moment-timezone-with-data.min.js']);

?>

<main class="landing-page-webinar">
    <figure>
        <img src="{$image}" alt="Background">
    </figure>
    <h1>{$status}</h1>
    <ul id="countdown" data-date="{$date}">
        <li><strong id="days"></strong>Días</li>
        <li><strong id="hours"></strong>Horas</li>
        <li><strong id="minutes"></strong>Minutos</li>
        <li><strong id="seconds"></strong>Segundos</li>
    </ul>
    {$btn_signup}
    <figure>
        <img src="{$path.images}hi/webinar/background.png" alt="Background">
    </figure>
</main>
{$mdl_signup}
