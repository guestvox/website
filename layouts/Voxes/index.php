<?php

defined('_EXEC') or die;

$this->dependencies->add(['js', '{$path.js}Voxes/index.js']);
$this->dependencies->add(['js', '{$path.plugins}moment/moment.min.js']);
$this->dependencies->add(['js', '{$path.plugins}moment/moment-timezone-with-data.min.js']);
$this->dependencies->add(['other', '<script>menu_focus("voxes");</script>']);

?>

%{header}%
<main>
    <section class="dashboard">
        <table id="tbl_voxes">
            <thead>
                <tr>
                    <th align="left" class="icon" hidden>Token</th>
                    <th align="left" class="icon">{$lang.abr_type}</th>
                    <?php if (Session::get_value('account')['type'] == 'hotel') : ?>
                    <th align="left">{$lang.abr_room} | {$lang.abr_department}</th>
                    <th align="left">{$lang.abr_guest}</th>
                    <?php endif; ?>
                    <?php if (Session::get_value('account')['type'] == 'restaurant') : ?>
                    <th align="left">{$lang.abr_table} | {$lang.abr_department}</th>
                    <th align="left">{$lang.abr_name}</th>
                    <?php endif; ?>
                    <?php if (Session::get_value('account')['type'] == 'others') : ?>
                    <th align="left">{$lang.abr_client} | {$lang.abr_department}</th>
                    <th align="left">{$lang.abr_name}</th>
                    <?php endif; ?>
                    <th align="left">{$lang.abr_opportunity_area}</th>
                    <th align="left">{$lang.abr_opportunity_type}</th>
                    <th align="left">{$lang.abr_location}</th>
                    <th align="left">{$lang.abr_started_date}</th>
                    <th align="left">{$lang.abr_elapsed_time}</th>
                    <th align="right" class="icon"></th>
                    <th align="right" class="icon"></th>
                    <th align="right" class="icon"></th>
                    <th align="right" class="icon"></th>
                    <th align="right" class="icon"></th>
                </tr>
            </thead>
            <tbody>
                {$tbl_voxes}
            </tbody>
        </table>
    </section>
    <section class="buttons">
        <div>
            <a href="/voxes/create"><i class="fas fa-plus"></i></a>
            <a href="/voxes" class="active"><i class="fas fa-list-ul"></i></a>
            <?php if (Functions::check_user_access(['{vox_stats_view}']) == true) : ?>
            <a href="/voxes/stats"><i class="fas fa-chart-pie"></i></a>
            <?php endif; ?>
            <?php if (Functions::check_user_access(['{vox_reports_view}']) == true) : ?>
            <a href="/voxes/reports/generate"><i class="fas fa-file-invoice"></i></a>
            <?php endif; ?>
        </div>
    </section>
</main>
