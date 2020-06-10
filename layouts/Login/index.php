<?php

defined('_EXEC') or die;

$this->dependencies->add(['css', '{$path.css}Login/index.css']);
$this->dependencies->add(['js', '{$path.js}Login/index.js']);

?>

<main class="login">
    <figure>
        <img src="{$path.images}logotype_white.png" alt="Guestvox">
    </figure>
    <form name="login">
        <fieldset>
            <input type="text" name="username" placeholder="{$lang.username}" />
        </fieldset>
        <fieldset>
            <input type="password" name="password" placeholder="{$lang.password}" />
        </fieldset>
        <button type="submit">{$lang.login}</button>
        <a href="/">{$lang.cancel}</a>
    </form>
</main>
