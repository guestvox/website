<?php

defined('_EXEC') or die;

$this->dependencies->add(['js', '{$path.js}Voxes/index.js']);
$this->dependencies->add(['js', '{$path.plugins}moment/moment.min.js']);
$this->dependencies->add(['js', '{$path.plugins}moment/moment-timezone-with-data.min.js']);
$this->dependencies->add(['other', '<script>menu_focus("voxes");</script>']);

?>

%{header}%
<main class="dashboard">
    <section class="workspace">
        <div class="tbl_stl_1">
            {$tbl_voxes}
        </div>
    </section>
    <section class="buttons">
        <div>
            <a data-button-modal="search"><i class="fas fa-search"></i></a>
            <a href="/voxes/create" class="active"><i class="fas fa-plus"></i></a>
            <?php if (Functions::check_user_access(['{voxes_stats_view}']) == true) : ?>
            <a href="/voxes/stats"><i class="fas fa-chart-pie"></i></a>
            <?php endif; ?>
            <?php if (Functions::check_user_access(['{voxes_reports_view}']) == true) : ?>
            <a href="/voxes/reports/generate"><i class="fas fa-file-invoice"></i></a>
            <?php endif; ?>
        </div>
    </section>
</main>
