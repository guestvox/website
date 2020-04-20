<?php

defined('_EXEC') or die;

$this->dependencies->add(['css', '{$path.css}Hi/webinar.css']);
$this->dependencies->add(['js', '{$path.js}Hi/webinar.js']);

?>

<main class="landing-page-webinar">
    <figure>
        <img src="{$path.images}hi/webinar/{$image}" alt="Background">
    </figure>
    {$btn_signup}
    <h1>{$status}</h1>
    <ul id="countdown" data-date="{$date}">
        <li><strong id="days"></strong>Días</li>
        <li><strong id="hours"></strong>Horas</li>
        <li><strong id="minutes"></strong>Minutos</li>
        <li><strong id="seconds"></strong>Segundos</li>
    </ul>
    <figure>
        <img src="{$path.images}hi/webinar/background.png" alt="Background">
    </figure>
</main>
{$mdl_signup}
