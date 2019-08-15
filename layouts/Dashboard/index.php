<?php

defined('_EXEC') or die;

$this->dependencies->add(['css', '{$path.plugins}data-tables/jquery.dataTables.min.css']);
$this->dependencies->add(['js', '{$path.plugins}data-tables/jquery.dataTables.min.js']);
$this->dependencies->add(['js', '{$path.plugins}charts/Chart.js']);
$this->dependencies->add(['js', '{$vkye_base}dashboard/charts']);
$this->dependencies->add(['js', '{$path.js}Dashboard/index.js']);
$this->dependencies->add(['other', '<script>menu_focus("dashboard");</script>']);

?>

%{header}%
<main>
    <section class="box-container complete">
        <div class="main">
            <article>
                <main class="tables">
                    <div class="search">
                        <div class="label">
                            <span class="icon-search"></span>
                            <label>
                                <input name="search" type="text" placeholder="{$lang.search}">
                            </label>
                        </div>
                    </div>
                    <div class="table-container">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th align="left">{$lang.abr_room}</th>
                                    <th align="left">{$lang.abr_guest}</th>
                                    <th align="left">{$lang.abr_subject}</th>
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
                    <div class="title">
                        <h2>{$lang.to_solve}</h2>
                    </div>
                    <div class="counts-home">
                        <h2>{$cnt_voxes_noreaded}<span>{$lang.noreaded}</span></h2>
                        <h2>{$cnt_voxes_readed}<span>{$lang.readed}</span></h2>
                        <h2>{$cnt_voxes_today}<span>{$lang.today}<strong><?php echo Dates::get_current_date('d M'); ?></strong></span></h2>
                        <h2>{$cnt_voxes_week}<span>{$lang.this_week}<strong><?php echo Dates::get_format_date(Dates::get_current_week()[0], 'd M'); ?> - <?php echo Dates::get_format_date(Dates::get_current_week()[1], 'd M'); ?></strong></span></h2>
                        <h2>{$cnt_voxes_month}<span>{$lang.this_month}<strong><?php echo Dates::get_format_date(Dates::get_current_month()[0], 'F'); ?></strong></span></h2>
                        <h2>{$cnt_voxes_total}<span>{$lang.total}</span></h2>
                    </div>
                </main>
                <footer>
                    <div class="buttons text-center">
                        <a href="/voxes" class="btn">{$lang.view_all_voxes}</a>
                    </div>
                </footer>
            </article>
            <?php if (Functions::check_access(['{stats_view}']) == true) : ?>
            <article>
                <main class="tables">
                    <div class="charts complete">
                        <canvas id="g_chart" height="200"></canvas>
                    </div>
                    <div class="clear"></div>
                </main>
                <footer>
                    <div class="buttons text-center">
                        <a href="/stats" class="btn">{$lang.view_all_stats}</a>
                    </div>
                </footer>
            </article>
            <?php endif; ?>
        </div>
    </section>
</main>
