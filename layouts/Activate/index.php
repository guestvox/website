<?php

defined('_EXEC') or die;

$this->dependencies->add(['css', '{$path.css}Activate/index.css']);
$this->dependencies->add(['js', '{$path.js}Activate/index.js']);

?>

<main class="activate">
    <figure>
        <img src="{$path.images}logotype_color.png" alt="Guestvox">
    </figure>
    <p>{$html}</p>
    <a href="/login">{$lang.login}</a>
</main>
