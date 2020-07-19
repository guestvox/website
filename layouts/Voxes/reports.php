<?php

defined('_EXEC') or die;

$this->dependencies->add(['js', '{$path.js}Voxes/reports.js']);
$this->dependencies->add(['other', '<script>menu_focus("voxes");</script>']);

?>

%{header}%
<main class="dashboard">
    <section class="workspace">
        {$div_options}
        {$tbl_voxes_reports}
        {$div_print_vox_report}
    </section>
    <section class="buttons">
        <div>
            <a data-button-modal="search"><i class="fas fa-search"></i></a>
            <a href="/voxes" class="big"><i class="fas fa-atom"></i><span>{$lang.voxes}</span></a>
            <?php if (Functions::check_user_access(['{voxes_stats_view}']) == true) : ?>
            <a href="/voxes/stats" class="big"><i class="fas fa-chart-pie"></i><span>{$lang.stats}</span></a>
            <?php endif; ?>
            <?php if (Functions::check_user_access(['{voxes_reports_print}']) == true) : ?>
            <a href="/voxes/reports/generate" class="big new"><i class="fas fa-bug"></i><span>{$lang.reports}</span></a>
            <?php elseif (Functions::check_user_access(['{voxes_reports_create}','{voxes_reports_update}','{voxes_reports_deactivate}','{voxes_reports_activate}','{voxes_reports_delete}']) == true) : ?>
            <a href="/voxes/reports/saved" class="big new"><i class="fas fa-bug"></i><span>{$lang.reports}</span></a>
            <?php endif; ?>
            {$btn_new_vox_report}
            {$btn_filter_vox_report}
            {$btn_print_vox_report}
        </div>
    </section>
</main>
{$mdl_new_vox_report}
{$mdl_deactivate_vox_report}
{$mdl_activate_vox_report}
{$mdl_delete_vox_report}
{$mdl_filter_vox_report}
