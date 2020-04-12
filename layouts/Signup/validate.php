<?php

defined('_EXEC') or die;

$this->dependencies->add(['css', '{$path.css}Signup/validate.css']);
$this->dependencies->add(['js', '{$path.js}Signup/validate.js']);

?>

<main class="signup-validate">
    <figure>
        <img src="{$path.images}icon-color.svg" alt="GuestVox">
    </figure>
    <p>{$txt}</p>
    <figure>
        <img src="{$path.images}signup/load.gif" alt="Icon">
        <span>{$lang.redirect_to} <?php echo Configuration::$domain; ?></span>
    </figure>
</main>
