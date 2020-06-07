<?php

defined('_EXEC') or die;

$this->dependencies->add(['css', '{$path.css}Myvox/vox.css']);
$this->dependencies->add(['js', '{$path.js}Myvox/vox.js']);

?>

<main class="myvox">
    {$html}
</main>
