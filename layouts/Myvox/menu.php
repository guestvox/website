<?php

defined('_EXEC') or die;

$this->dependencies->add(['css', '{$path.css}Myvox/menu.css']);
$this->dependencies->add(['js', '{$path.js}Myvox/menu.js']);

?>

<main class="myvox">
    {$html}
</main>
