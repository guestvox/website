<?php

defined('_EXEC') or die;

$this->dependencies->add(['css', '{$path.plugins}data-tables/jquery.dataTables.min.css']);
$this->dependencies->add(['js', '{$path.plugins}data-tables/jquery.dataTables.min.js']);
$this->dependencies->add(['js', '{$path.plugins}moment/moment.min.js']);
$this->dependencies->add(['js', '{$path.plugins}moment/moment-timezone-with-data.min.js']);
$this->dependencies->add(['js', '{$path.js}Voxes/index.js']);
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
        <span>{$_tmp_time_zone}</span>
    </section>
    <section class="buttons">
        <div>
            <a href=""><i class="fas fa-plus"></i></a>
            <a href="" class="success"><i class="fas fa-plus"></i></a>
            <a href=""><i class="fas fa-plus"></i></a>
        </div>
    </section>
</main>

<!-- <nav>
    <ul>
        <li><a href="/voxes" class="view"><i class="fas fa-heart"></i></a></li>
        <?php if (Functions::check_user_access(['{vox_reports_view}']) == true) : ?>
        <li><a href="/voxes/reports/generate"><i class="fas fa-file-invoice"></i></a></li>
        <?php endif; ?>
        <?php if (Functions::check_user_access(['{vox_stats_view}']) == true) : ?>
        <li><a href="/voxes/stats"><i class="fas fa-chart-pie"></i></a></li>
        <?php endif; ?>
    </ul>
</nav> -->
