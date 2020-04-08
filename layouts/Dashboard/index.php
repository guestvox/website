<?php

defined('_EXEC') or die;

$this->dependencies->add(['js', '{$path.js}Dashboard/index.js']);
$this->dependencies->add(['js', '{$path.plugins}moment/moment.min.js']);
$this->dependencies->add(['js', '{$path.plugins}moment/moment-timezone-with-data.min.js']);
$this->dependencies->add(['other', '<script>menu_focus("dashboard");</script>']);

?>

%{header}%
<main>
    <section class="dashboard">
        
    </section>
</main>
