<?php

defined('_EXEC') or die;

$this->dependencies->add(['js', '{$path.plugins}charts/Chart.js']);
$this->dependencies->add(['js', '{$vkye_base}Voxes/charts']);
$this->dependencies->add(['js', '{$path.js}Voxes/stats.js']);
$this->dependencies->add(['other', '<script>menu_focus("voxes");</script>']);

?>

%{header}%
<main>
    <nav>
        <ul>
            <li><a href="/voxes"><i class="fas fa-heart"></i></a></li>
            <?php if (Functions::check_user_access(['{vox_reports_view}']) == true) : ?>
            <li><a href="/voxes/reports/generate"><i class="fas fa-file-invoice"></i></a></li>
            <?php endif; ?>
            <?php if (Functions::check_user_access(['{vox_reports_create}','{vox_reports_update}','{vox_reports_delete}']) == true) : ?>
            <li><a href="/voxes/reports"><i class="fas fa-file-invoice"></i></a></li>
            <?php endif; ?>
            <?php if (Functions::check_user_access(['{vox_stats_view}']) == true) : ?>
            <li><a href="/voxes/stats" class="view"><i class="fas fa-chart-pie"></i></a></li>
            <?php endif; ?>
        </ul>
    </nav>
    <article>
        <header>
            <h2><i class="fas fa-chart-pie"></i>{$lang.vox_stats}</h2>
        </header>
        <main>
            <div class="voxes-counts">
                <h2>{$average_resolution}<span>{$lang.average_resolution}</span></h2>
                <h2>{$count_created_today}<span>{$lang.created_today}</span><strong><?php echo Functions::get_current_date('d M'); ?></strong></h2>
                <h2>{$count_created_week}<span>{$lang.created_week}</span><strong><?php echo Functions::get_formatted_date(Functions::get_current_week()[0], 'd M'); ?> - <?php echo Functions::get_formatted_date(Functions::get_current_week()[1], 'd M'); ?></strong></h2>
                <h2>{$count_created_month}<span>{$lang.created_month}</span><strong><?php echo Functions::get_formatted_date(Functions::get_current_month()[0], 'F'); ?></strong></h2>
                <h2>{$count_created_year}<span>{$lang.created_year}</span><strong><?php echo Functions::get_current_year(); ?></strong></h2>
                <h2>{$count_created_total}<span>{$lang.created_total}</span></h2>
            </div>
            <form name="get_v_chart_data">
                <div class="row">
                    <div class="span4">
                        <div class="label">
                            <label>
                                <p>{$lang.started_date}</p>
                                <input type="date" name="started_date" value="<?php echo Functions::get_past_date(Functions::get_current_date(), '7', 'days'); ?>" />
                            </label>
                        </div>
                    </div>
                    <div class="span4">
                        <div class="label">
                            <label>
                                <p>{$lang.end_date}</p>
                                <input type="date" name="date_end" value="<?php echo Functions::get_current_date(); ?>" />
                            </label>
                        </div>
                    </div>
                    <div class="span4">
                        <div class="label">
                            <label>
                                <p>{$lang.vox_type}</p>
                                <select name="type">
                                    <option value="all">{$lang.view_all}</option>
                                    <option value="request">{$lang.view_only_requests}</option>
                                    <option value="incident">{$lang.view_only_incidents}</option>
                                </select>
                            </label>
                        </div>
                    </div>
                </div>
            </form>
            <div class="charts">
                <canvas id="v_oa_chart" height="300"></canvas>
            </div>
            <div class="charts">
                <canvas id="v_r_chart" height="300"></canvas>
            </div>
            <div class="charts">
                <canvas id="v_l_chart" height="300"></canvas>
            </div>
            <form name="get_ar_chart_data">
                <div class="row">
                    <div class="span4">
                        <div class="label">
                            <label>
                                <p>{$lang.started_date}</p>
                                <input type="date" name="started_date" value="<?php echo Functions::get_past_date(Functions::get_current_date(), '7', 'days'); ?>" />
                            </label>
                        </div>
                    </div>
                    <div class="span4">
                        <div class="label">
                            <label>
                                <p>{$lang.end_date}</p>
                                <input type="date" name="date_end" value="<?php echo Functions::get_current_date(); ?>" />
                            </label>
                        </div>
                    </div>
                    <div class="span4">
                        <div class="label">
                            <label>
                                <p>{$lang.vox_type}</p>
                                <select name="type">
                                    <option value="all">{$lang.view_all}</option>
                                    <option value="request">{$lang.view_only_requests}</option>
                                    <option value="incident">{$lang.view_only_incidents}</option>
                                </select>
                            </label>
                        </div>
                    </div>
                </div>
            </form>
            <div class="charts">
                <canvas id="ar_oa_chart" height="300"></canvas>
            </div>
            <div class="charts">
                <canvas id="ar_r_chart" height="300"></canvas>
            </div>
            <div class="charts">
                <canvas id="ar_l_chart" height="300"></canvas>
            </div>
            <form name="get_c_chart_data">
                <div class="row">
                    <div class="span6">
                        <div class="label">
                            <label>
                                <p>{$lang.started_date}</p>
                                <input type="date" name="started_date" value="<?php echo Functions::get_past_date(Functions::get_current_date(), '7', 'days'); ?>" />
                            </label>
                        </div>
                    </div>
                    <div class="span6">
                        <div class="label">
                            <label>
                                <p>{$lang.end_date}</p>
                                <input type="date" name="date_end" value="<?php echo Functions::get_current_date(); ?>" />
                            </label>
                        </div>
                    </div>
                </div>
            </form>
            <div class="charts">
                <canvas id="c_oa_chart" height="300"></canvas>
            </div>
            <div class="charts">
                <canvas id="c_r_chart" height="300"></canvas>
            </div>
            <div class="charts">
                <canvas id="c_l_chart" height="300"></canvas>
            </div>
            <div class="clear"></div>
        </main>
    </article>
</main>
