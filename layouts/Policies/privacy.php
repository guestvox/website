<?php

defined('_EXEC') or die;

$this->dependencies->add(['css', '{$path.css}Policies/privacy.css']);
$this->dependencies->add(['js', '{$path.js}Policies/privacy.js']);

?>

<main class="landing-page-terms">
    <figure>
        <img src="{$path.images}logotype-color.png" alt="Guestvox">
    </figure>
    <h1>{$lang.privacy_policies}</h1>
</main>
