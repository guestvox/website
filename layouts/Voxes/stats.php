<?php

defined('_EXEC') or die;

$this->dependencies->add(['js', '{$path.plugins}charts/Chart.js']);
$this->dependencies->add(['js', '{$vkye_base}Voxes/charts']);
$this->dependencies->add(['js', '{$path.js}Voxes/stats.js']);
$this->dependencies->add(['other', '<script>menu_focus("voxes");</script>']);

?>

%{header}%
<main class="dashboard gry">
    <section class="workspace">
        <div class="voxes_charts">
            <div>
                <canvas id="v_oa_chart"></canvas>
            </div>
            <div>
                <canvas id="v_o_chart"></canvas>
            </div>
            <div>
                <canvas id="v_l_chart"></canvas>
            </div>
            <div>
                <canvas id="ar_oa_chart"></canvas>
            </div>
            <div>
                <canvas id="ar_o_chart"></canvas>
            </div>
            <div>
                <canvas id="ar_l_chart"></canvas>
            </div>
            <div class="last">
                <canvas id="c_oa_chart"></canvas>
            </div>
            <div class="last">
                <canvas id="c_o_chart"></canvas>
            </div>
            <div class="last">
                <canvas id="c_l_chart"></canvas>
            </div>
        </div>
        <div class="voxes_counters">
            <div>
                <div>
                    <h2>{$voxes_average_resolution}</h2>
                    <span>{$lang.resolution}</span>
                </div>
                <div>
                    <h2>{$voxes_count_open}</h2>
                    <span>{$lang.pending}</span>
                </div>
                <div>
                    <h2>{$voxes_count_close}</h2>
                    <span>{$lang.finished}</span>
                </div>
            </div>
            <div>
                <div>
                    <h2>{$voxes_count_total}</h2>
                    <span>{$lang.created_total}</span>
                </div>
                <div>
                    <div>
                        <h3>{$voxes_count_today}</h3>
                        <span>{$lang.today}</span>
                    </div>
                    <div>
                        <h3>{$voxes_count_week}</h3>
                        <span>{$lang.this_week}</span>
                    </div>
                    <div>
                        <h3>{$voxes_count_month}</h3>
                        <span>{$lang.this_month}</span>
                    </div>
                    <div>
                        <h3>{$voxes_count_year}</h3>
                        <span>{$lang.this_year}</span>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <section class="buttons">
        <div>
            <a data-button-modal="search"><i class="fas fa-search"></i></a>
            <a href="/voxes"><i class="fas fa-atom"></i></a>
            <?php if (Functions::check_user_access(['{voxes_stats_view}']) == true) : ?>
            <a href="/voxes/stats" class="active"><i class="fas fa-chart-pie"></i></a>
            <a class="active" data-button-modal="filter_voxes_stats"><i class="fas fa-stream"></i></a>
            <?php endif; ?>
            <?php if (Functions::check_user_access(['{voxes_reports_print}']) == true) : ?>
            <a href="/voxes/reports/print"><i class="fas fa-bug"></i></a>
            <?php elseif (Functions::check_user_access(['{voxes_reports_create}','{voxes_reports_update}','{voxes_reports_deactivate}','{voxes_reports_activate}','{voxes_reports_delete}']) == true) : ?>
            <a href="/voxes/reports"><i class="fas fa-bug"></i></a>
            <?php endif; ?>
        </div>
    </section>
</main>
<section class="modal fullscreen" data-modal="filter_voxes_stats">
    <div class="content">
        <main>
            <form name="filter_voxes_stats">
                <div class="row">
                    <div class="span6">
                        <div class="label">
                            <label required>
                                <p>{$lang.started_date}</p>
                                <input type="date" name="started_date" value="<?php echo Functions::get_past_date(Functions::get_current_date(), '7', 'days'); ?>">
                            </label>
                        </div>
                    </div>
                    <div class="span6">
                        <div class="label">
                            <label required>
                                <p>{$lang.end_date}</p>
                                <input type="date" name="end_date" value="<?php echo Functions::get_current_date(); ?>">
                            </label>
                        </div>
                    </div>
                    <div class="span12">
                        <div class="label">
                            <label required>
                                <p>{$lang.type}</p>
                                <select name="type">
                                    <option value="all">{$lang.all_voxes}</option>
                                    <option value="request">{$lang.requests}</option>
                                    <option value="incident">{$lang.incidents}</option>
                                    <option value="workorder">{$lang.workorders}</option>
                                </select>
                            </label>
                        </div>
                    </div>
                    <div class="span12">
                        <div class="buttons">
                            <a button-close><i class="fas fa-times"></i></a>
                            <button type="submit"><i class="fas fa-check"></i></button>
                        </div>
                    </div>
                </div>
            </form>
        </main>
    </div>
</section>
