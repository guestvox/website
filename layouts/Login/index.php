<?php

defined('_EXEC') or die;

$this->dependencies->add(['css', '{$path.css}Login/index.css']);
$this->dependencies->add(['js', '{$path.js}Login/index.js']);

?>

<main class="login">
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
        <a data-action="login">{$lang.login}</a>
        <a href="/">{$lang.cancel}</a>
        <img class="logotype-login" style="display: none;" src="{$path.images}logotype-color.png">
    </form>
</main>
