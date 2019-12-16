<?php

defined('_EXEC') or die;

$this->dependencies->add(['css', '{$path.plugins}data-tables/jquery.dataTables.min.css']);
$this->dependencies->add(['js', '{$path.plugins}data-tables/jquery.dataTables.min.js']);
$this->dependencies->add(['js', '{$path.js}Voxes/index.js']);
$this->dependencies->add(['other', '<script>menu_focus("voxes");</script>']);

?>

%{header}%
<main>
    <nav>
        <ul>
            <li><a href="/voxes" class="view"><i class="fas fa-heart"></i></a></li>
            <?php if (Functions::check_user_access(['{vox_reports_view}']) == true) : ?>
            <li><a href="/voxes/reports/generate"><i class="fas fa-file-invoice"></i></a></li>
            <?php endif; ?>
            <?php if (Functions::check_user_access(['{vox_reports_create}','{vox_reports_update}','{vox_reports_delete}']) == true) : ?>
            <li><a href="/voxes/reports"><i class="fas fa-file-invoice"></i></a></li>
            <?php endif; ?>
            <?php if (Functions::check_user_access(['{vox_stats_view}']) == true) : ?>
            <li><a href="/voxes/stats"><i class="fas fa-chart-pie"></i></a></li>
            <?php endif; ?>
        </ul>
    </nav>
    <article>
        <header>
            <h2><i class="fas fa-heart"></i>{$lang.voxes}</h2>
        </header>
        <main>
            <div class="table">
                <aside>
                    <label>
                        <span><i class="fas fa-search"></i></span>
                        <input type="text" name="tbl_voxes_search">
                    </label>
                    <a href="/voxes/create" class="new"><i class="fas fa-plus"></i></a>
                </aside>
                <table id="tbl_voxes">
                    <thead>
                        <tr>
                            <?php if (Session::get_value('account')['type'] == 'hotel') : ?>
                            <th align="left">{$lang.abr_room}</th>
                            <?php endif; ?>
                            <?php if (Session::get_value('account')['type'] == 'restaurant') : ?>
                            <th align="left">{$lang.abr_table}</th>
                            <?php endif; ?>
                            <th align="left">{$lang.abr_guest}</th>
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
            </div>
        </main>
    </article>
</main>
