<?php

defined('_EXEC') or die;

$this->dependencies->add(['js', '{$path.plugins}charts/Chart.js']);
$this->dependencies->add(['css', '{$path.plugins}date-picker/jquery-ui.min.css']);
$this->dependencies->add(['js', '{$path.plugins}date-picker/jquery-ui.min.js']);
$this->dependencies->add(['js', '{$vkye_base}stats/charts']);
$this->dependencies->add(['js', '{$path.js}Stats/index.js']);
$this->dependencies->add(['other', '<script>menu_focus("stats");</script>']);

?>

%{header}%
<main>
    <section class="box-container">
        <div class="main">
            <article>
                <main class="tables">
                    <h6>{$lang.voxes}</h6>
                    <form name="get_v_chart_data">
                        <div class="row">
                            <div class="span4">
                                <div class="label">
                                    <label>
                                        <p>{$lang.started_date}</p>
                                        <input type="text" name="started_date" class="datepicker" placeholder="{$lang.choose}" value="<?php echo Dates::get_past_date(Dates::get_current_date(), '7', 'days'); ?>" />
                                    </label>
                                </div>
                            </div>
                            <div class="span4">
                                <div class="label">
                                    <label>
                                        <p>{$lang.end_date}</p>
                                        <input type="text" name="date_end" class="datepicker" placeholder="{$lang.choose}" value="<?php echo Dates::get_current_date(); ?>" />
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
                        <canvas id="v_oa_chart" height="320"></canvas>
                    </div>
                    <div class="charts">
                        <canvas id="v_r_chart" height="320"></canvas>
                    </div>
                    <div class="charts">
                        <canvas id="v_l_chart" height="320"></canvas>
                    </div>
                    <div class="clear"></div>
                </main>
            </article>
            <article>
                <main class="tables">
                    <h6>{$lang.average_resolution}</h6>
                    <form name="get_ar_chart_data">
                        <div class="row">
                            <div class="span4">
                                <div class="label">
                                    <label>
                                        <p>{$lang.started_date}</p>
                                        <input type="text" name="started_date" class="datepicker" placeholder="{$lang.choose}" value="<?php echo Dates::get_past_date(Dates::get_current_date(), '7', 'days'); ?>" />
                                    </label>
                                </div>
                            </div>
                            <div class="span4">
                                <div class="label">
                                    <label>
                                        <p>{$lang.end_date}</p>
                                        <input type="text" name="date_end" class="datepicker" placeholder="{$lang.choose}" value="<?php echo Dates::get_current_date(); ?>" />
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
                    <div class="charts complete">
                        <canvas id="ar_oa_chart" height="320"></canvas>
                    </div>
                    <div class="charts medium">
                        <canvas id="ar_r_chart" height="320"></canvas>
                    </div>
                    <div class="charts medium">
                        <canvas id="ar_l_chart" height="320"></canvas>
                    </div>
                    <div class="clear"></div>
                </main>
            </article>
            <article>
                <main class="tables">
                    <h6>{$lang.incidents_cost}</h6>
                    <form name="get_c_chart_data">
                        <div class="row">
                            <div class="span6">
                                <div class="label">
                                    <label>
                                        <p>{$lang.started_date}</p>
                                        <input type="text" name="started_date" class="datepicker" placeholder="{$lang.choose}" value="<?php echo Dates::get_past_date(Dates::get_current_date(), '7', 'days'); ?>" />
                                    </label>
                                </div>
                            </div>
                            <div class="span6">
                                <div class="label">
                                    <label>
                                        <p>{$lang.end_date}</p>
                                        <input type="text" name="date_end" class="datepicker" placeholder="{$lang.choose}" value="<?php echo Dates::get_current_date(); ?>" />
                                    </label>
                                </div>
                            </div>
                        </div>
                    </form>
                    <div class="charts">
                        <canvas id="c_oa_chart" height="320"></canvas>
                    </div>
                    <div class="charts">
                        <canvas id="c_r_chart" height="320"></canvas>
                    </div>
                    <div class="charts">
                        <canvas id="c_l_chart" height="320"></canvas>
                    </div>
                    <div class="clear"></div>
                </main>
            </article>
        </div>
        <aside class="padding">
            <div class="counts">
                <h2 class="average">{$average_resolution}<span>{$lang.average_resolution}</span></h2>
                <h2>{$count_created_today}<span>{$lang.created_today} <strong><?php echo Dates::get_current_date('d M'); ?></strong></span></h2>
                <h2>{$count_created_week}<span>{$lang.created_week} <strong><?php echo Dates::get_format_date(Dates::get_current_week()[0], 'd M'); ?> - <?php echo Dates::get_format_date(Dates::get_current_week()[1], 'd M'); ?></strong></span></h2>
                <h2>{$count_created_month}<span>{$lang.created_month} <strong><?php echo Dates::get_format_date(Dates::get_current_month()[0], 'F'); ?></strong></span></h2>
                <h2>{$count_created_year}<span>{$lang.created_year} <strong><?php echo Dates::get_current_year(); ?></strong></span></h2>
                <h2>{$count_created_total}<span>{$lang.created_total}</span></h2>
            </div>
        </aside>
    </section>
</main>
