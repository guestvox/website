<?php

defined('_EXEC') or die;

$this->dependencies->add(['js', '{$path.js}Voxes/reports.js']);
$this->dependencies->add(['other', '<script>menu_focus("voxes_reports_{$menu_focus}");</script>']);

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
