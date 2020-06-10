<?php

defined('_EXEC') or die;

$this->dependencies->add(['css', '{$path.css}Myvox/incident.css']);
$this->dependencies->add(['js', '{$path.js}Myvox/incident.js']);

?>

<main class="myvox">
    {$html}
</main>
