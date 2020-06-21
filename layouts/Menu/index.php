<?php

defined('_EXEC') or die;

$this->dependencies->add(['js', '{$path.js}Menu/index.js']);
$this->dependencies->add(['other', '<script>menu_focus("menu");</script>']);

?>

%{header}%
<main class="dashboard">

</main>
