<?php

defined('_EXEC') or die;

$this->dependencies->add(['css', '{$path.css}Myvox/request.css']);
$this->dependencies->add(['js', '{$path.js}Myvox/request.js']);

?>

<main class="myvox">
    {$html}
</main>
