<?php

defined('_EXEC') or die;

$this->dependencies->add(['js', '{$path.plugins}charts/Chart.js']);
$this->dependencies->add(['js', '{$vkye_base}Surveys/charts{$chart_params}']);
$this->dependencies->add(['js', '{$path.js}Surveys/stats.js']);
$this->dependencies->add(['other', '<script>menu_focus("surveys_stats");</script>']);

?>

%{header}%
<main class="dashboard gry">
    <section class="workspace">
        <div class="surveys_chart_rate">
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
        <div class="surveys_charts">
            <div>
                <canvas id="s1_chart"></canvas>
            </div>
            <div>
                <canvas id="s2_chart"></canvas>
            </div>
            <?php if (Session::get_value('account')['type'] == 'hotel' AND Session::get_value('account')['zaviapms']['status'] == true) : ?>
            <div class="small">
                <canvas id="s4_chart"></canvas>
            </div>
            <div class="small">
                <canvas id="s5_chart"></canvas>
            </div>
            <div class="small">
                <canvas id="s6_chart"></canvas>
            </div>
            <div class="small">
                <canvas id="s7_chart"></canvas>
            </div>
            <?php endif; ?>
        </div>
        <div class="surveys_counters">
            <div>
                <h2>{$surveys_count_total}</h2>
                <span>{$lang.answered_total}</span>
            </div>
            <div>
                <div>
                    <h3>{$surveys_count_today}</h3>
                    <span>{$lang.today}</span>
                </div>
                <div>
                    <h3>{$surveys_count_week}</h3>
                    <span>{$lang.this_week}</span>
                </div>
                <div>
                    <h3>{$surveys_count_month}</h3>
                    <span>{$lang.this_month}</span>
                </div>
                <div>
                    <h3>{$surveys_count_year}</h3>
                    <span>{$lang.this_year}</span>
                </div>
            </div>
        </div>
    </section>
    <section class="buttons">
        <?php if (Functions::check_user_access(['{surveys_stats_view}']) == true) : ?>
        <div>
            {$return_btn}
            <a class="big new" data-button-modal="filter_surveys_stats"><i class="fas fa-stream"></i><span>{$lang.filter}</span></a>
        </div>
        <?php endif; ?>
    </section>
</main>
<section class="modal fullscreen" data-modal="filter_surveys_stats">
    <div class="content">
        <main>
            <form name="filter_surveys_stats">
                <div class="row">
                    <div class="span6">
                        <div class="label">
                            <label required>
                                <p>{$lang.started_date}</p>
                                <input type="date" name="started_date" value="<?php echo Session::get_value('settings')['surveys']['stats']['filter']['started_date']; ?>">
                            </label>
                        </div>
                    </div>
                    <div class="span6">
                        <div class="label">
                            <label required>
                                <p>{$lang.end_date}</p>
                                <input type="date" name="end_date" value="<?php echo Session::get_value('settings')['surveys']['stats']['filter']['end_date']; ?>">
                            </label>
                        </div>
                    </div>
                    <div class="span12">
                        <div class="label">
                            <label required>
                                <p>{$lang.owner}</p>
                                <select name="owner">
                                    <option value="all" <?php echo ((Session::get_value('settings')['surveys']['stats']['filter']['owner'] == 'all') ? 'selected' : ''); ?>>{$lang.all}</option>
                                    <option value="not_owner" <?php echo ((Session::get_value('settings')['surveys']['stats']['filter']['owner'] == 'not_owner') ? 'selected' : ''); ?>>Sin propietario</option>
                                    {$opt_owners}
                                </select>
                            </label>
                        </div>
                    </div>
                    <div class="span12">
                        <div class="buttons">
                            <a class="delete" button-close><i class="fas fa-times"></i></a>
                            <button type="submit" class="new"><i class="fas fa-check"></i></button>
                        </div>
                    </div>
                </div>
            </form>
        </main>
    </div>
</section>
