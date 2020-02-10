<?php
defined('_EXEC') or die;

$this->dependencies->add(['css', '{$path.css}Login/index.css']);
$this->dependencies->add(['js', '{$path.js}Login/index.js']);
// $this->dependencies->add(['other', '<script async defer src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBLCea8Q6BtcTHwY3YFCiB0EoHE5KnsMUE"></script>']);
?>



    <section class="modals">
        <main>
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
        <a class="btn btn-login" data-action="login">{$lang.login}</a>
        <br>
        <a button-cancel href="/" class="btn-cancel">{$lang.cancel}</a>
    </form>            
        </main>

    </section>