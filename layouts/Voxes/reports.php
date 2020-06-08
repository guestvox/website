<?php

defined('_EXEC') or die;

$this->dependencies->add(['js', '{$path.js}Voxes/reports.js']);
$this->dependencies->add(['other', '<script>menu_focus("voxes");</script>']);

?>

%{header}%
<main class="dashboard">
    <section class="workspace">
        {$div_tabers}
        {$tbl_voxes_reports}
        {$div_vox_report_print}
    </section>
    <section class="buttons">
        <div>
            <a data-button-modal="search"><i class="fas fa-search"></i></a>
            <a href="/voxes"><i class="fas fa-atom"></i></a>
            <?php if (Functions::check_user_access(['{voxes_stats_view}']) == true) : ?>
            <a href="/voxes/stats"><i class="fas fa-chart-pie"></i></a>
            <?php endif; ?>
            <?php if (Functions::check_user_access(['{voxes_reports_view}']) == true) : ?>
            <a href="/voxes/reports/print" class="active"><i class="fas fa-bug"></i></a>
            <?php endif; ?>
            {$btn_new_vox_report}
            {$btn_get_vox_report}
        </div>
    </section>
</main>
{$mdl_new_vox_report}
{$mdl_deactivate_vox_report}
{$mdl_activate_vox_report}
{$mdl_delete_vox_report}
{$mdl_get_vox_report}
