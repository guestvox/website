<?php
defined('_EXEC') or die;

$this->dependencies->add(['css', '{$path.css}Index/index.css']);
$this->dependencies->add(['js', '{$path.js}Index/index.js']);
// $this->dependencies->add(['other', '<script async defer src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBLCea8Q6BtcTHwY3YFCiB0EoHE5KnsMUE"></script>']);
?>

<main class="landing-page-index">
    <form name="login">
        <figure>
            <img src="{$path.images}icon-color.svg" alt="GuestVox icontype">
        </figure>
        <fieldset>
            <input type="text" name="username" placeholder="{$lang.username_or_email}" />
        </fieldset>
        <fieldset>
            <input type="password" name="password" placeholder="{$lang.password}" />
        </fieldset>
        <a class="btn" data-action="login">{$lang.login}</a>
        <a href="/">{$lang.cancel}</a>
    </form>
</main>
