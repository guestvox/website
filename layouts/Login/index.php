<?php

defined('_EXEC') or die;

$this->dependencies->add(['css', '{$path.css}Login/index.css']);
$this->dependencies->add(['js', '{$path.js}Login/index.js']);

?>

<main class="login">
    <figure>
        <img src="{$path.images}logotype-white.png" alt="GuestVox">
    </figure>
    <form name="login">
        <fieldset>
            <input type="text" name="username" placeholder="{$lang.username_or_email}" />
        </fieldset>
        <fieldset>
            <input type="password" name="password" placeholder="{$lang.password}" />
        </fieldset>
        <a data-action="login">{$lang.login}</a>
        <a href="/">{$lang.cancel}</a>
    </form>
</main>
