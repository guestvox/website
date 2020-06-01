<?php

defined('_EXEC') or die;

$this->dependencies->add(['js', '{$path.js}Dashboard/index.js']);
$this->dependencies->add(['other', '<script>menu_focus("dashboard");</script>']);

?>

%{header}%
<main class="dashboard">
    <section class="workspace">
        <figure class="qr">
            <img src="{$path.uploads}<?php echo Session::get_value('account')['qr']; ?>">
        </figure>
    </section>
</main>
