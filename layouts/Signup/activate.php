<?php

defined('_EXEC') or die;

$this->dependencies->add(['css', '{$path.css}Signup/activate.css']);
$this->dependencies->add(['js', '{$path.js}Signup/activate.js']);

?>

<main class="signup_activate">
    <figure>
        <img src="{$path.images}logotype_color.png" alt="Guestvox">
    </figure>
    <p>{$html}</p>
    <a href="/login">{$lang.login}</a>
</main>
