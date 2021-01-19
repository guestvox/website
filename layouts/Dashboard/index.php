<?php

defined('_EXEC') or die;

$this->dependencies->add(['js', '{$path.js}Dashboard/index.js']);
$this->dependencies->add(['other', '<script>menu_focus("dashboard");</script>']);

?>

%{header}%
<main class="dashboard">
    <section class="workspace">
        <div class="row">
            <div class="span12">
                <div class="tabers">
                    <div>
                        <input id="rqrd" type="radio" name="type" value="voxes" checked>
                        <label for="rqrd">
                            <i class="fas fa-atom"></i>
                            <span>{$lang.voxes}</span>
                        </label>
                    </div>
                    <div>
                        <input id="inrd" type="radio" name="type" value="menu_orders">
                        <label for="inrd">
                            <i class="fas fa-utensils"></i>
                            <span>{$lang.menu}</span>
                        </label>
                    </div>
                    <div>
                        <input id="wkrd" type="radio" name="type" value="surveys_answers">
                        <label for="wkrd">
                            <i class="fas fa-star"></i>
                            <span>{$lang.surveys}</span>
                        </label>
                    </div>
                </div>
            </div>
        </div>
        <div class="voxes_counters">
            <div>
                <div>
                    <h2>{$voxes_average}</h2>
                    <span>{$lang.average}</span>
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
        <div class="tbl_stl_1" id="voxes_table" data-table>
            {$tbl_voxes}
        </div>
        <div class="tbl_stl_1 hidden" id="orders_table" data-table>
            {$tbl_menu_orders}
        </div>
        <div class="surveys_chart_rate hidden">
            <div class="average">
                {$h2_surveys_average}
                {$spn_surveys_average}
            </div>
            <div class="progress">
                <span>1<i class="fas fa-star"></i></span>
                <progress value="{$surveys_porcentage_one}" max="100"></progress>
                <span>{$surveys_porcentage_one}%</span>
            </div>
            <div class="progress">
                <span>2<i class="fas fa-star"></i></span>
                <progress value="{$surveys_porcentage_two}" max="100"></progress>
                <span>{$surveys_porcentage_two}%</span>
            </div>
            <div class="progress">
                <span>3<i class="fas fa-star"></i></span>
                <progress value="{$surveys_porcentage_tree}" max="100"></progress>
                <span>{$surveys_porcentage_tree}%</span>
            </div>
            <div class="progress">
                <span>4<i class="fas fa-star"></i></span>
                <progress value="{$surveys_porcentage_four}" max="100"></progress>
                <span>{$surveys_porcentage_four}%</span>
            </div>
            <div class="progress">
                <span>5<i class="fas fa-star"></i></span>
                <progress value="{$surveys_porcentage_five}" max="100"></progress>
                <span>{$surveys_porcentage_five}%</span>
            </div>
        </div>
        {$tbl_surveys_raters}
    </section>
</main>
