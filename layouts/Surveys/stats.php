<?php

defined('_EXEC') or die;

$this->dependencies->add(['js', '{$path.plugins}charts/Chart.js']);
$this->dependencies->add(['js', '{$vkye_base}surveys/charts']);
$this->dependencies->add(['js', '{$path.js}Surveys/stats.js']);
$this->dependencies->add(['other', '<script>menu_focus("surveys");</script>']);

?>

%{header}%
<main class="surveys-stats">
    <nav>
        <h2><i class="fas fa-chart-pie"></i>{$lang.stats}</h2>
        <ul>
            <?php if (Functions::check_user_access(['{survey_questions_create}','{survey_questions_update}','{survey_questions_deactivate}','{survey_questions_activate}','{survey_questions_delete}']) == true) : ?>
            <li><a href="/surveys/questions"><i class="fas fa-question-circle"></i></a></li>
            <?php endif; ?>
            <?php if (Functions::check_user_access(['{survey_answers_view}']) == true) : ?>
            <li><a href="/surveys/answers"><i class="fas fa-comment-alt"></i></a></li>
            <?php endif; ?>
            <?php if (Functions::check_user_access(['{survey_answers_view}']) == true) : ?>
            <li><a href="/surveys/comments"><i class="far fa-comment-dots"></i></a></li>
            <?php endif; ?>
            <?php if (Functions::check_user_access(['{survey_answers_view}']) == true) : ?>
            <li><a href="/surveys/contacts"><i class="far fa-address-book"></i></a></li>
            <?php endif; ?>
            <?php if (Functions::check_user_access(['{survey_stats_view}']) == true) : ?>
            <li><a href="/surveys/stats" class="view"><i class="fas fa-chart-pie"></i></a></li>
            <?php endif; ?>
        </ul>
    </nav>
    <article>
        <main>
            <form name="get_charts_by_date_filter" class="charts-filter">
                <select name="question">
                    <option value="all">{$lang.all_questions}</option>
                    {$opt_survey_questions}
                </select>
                <input type="date" name="started_date" value="<?php echo Functions::get_past_date(Functions::get_current_date(), '7', 'days'); ?>">
                <input type="date" name="end_date" value="<?php echo Functions::get_current_date(); ?>" max="<?php echo Functions::get_current_date(); ?>">
            </form>
            <div class="chart-rate">
                <h2>{$lang.general_rate}</h2>
                <div class="average">
                    {$h4_general_average_rate}
                    {$spn_general_avarage_rate}
                </div>
                <div class="progress">
                    <span>5<i class="fas fa-star"></i></span>
                    <progress value="{$five_percentage_rate}" max="100"></progress>
                    <span>{$five_percentage_rate}%</span>
                </div>
                <div class="progress">
                    <span>4<i class="fas fa-star"></i></span>
                    <progress value="{$four_percentage_rate}" max="100"></progress>
                    <span>{$four_percentage_rate}%</span>
                </div>
                <div class="progress">
                    <span>3<i class="fas fa-star"></i></span>
                    <progress value="{$tree_percentage_rate}" max="100"></progress>
                    <span>{$tree_percentage_rate}%</span>
                </div>
                <div class="progress">
                    <span>2<i class="fas fa-star"></i></span>
                    <progress value="{$two_percentage_rate}" max="100"></progress>
                    <span>{$two_percentage_rate}%</span>
                </div>
                <div class="progress">
                    <span>1<i class="fas fa-star"></i></span>
                    <progress value="{$one_percentage_rate}" max="100"></progress>
                    <span>{$one_percentage_rate}%</span>
                </div>
            </div>
            <div class="chart-answered">
                <h2>{$lang.surveys_answered}</h2>
                <div class="counters">
                    <span>{$count_answered_total}<strong>{$lang.total}</strong></span>
                    <span>{$count_answered_today}<strong>{$lang.today}</strong></span>
                    <span>{$count_answered_week}<strong>{$lang.this_week}</strong></span>
                    <span>{$count_answered_month}<strong>{$lang.this_month}</strong></span>
                    <span>{$count_answered_year}<strong>{$lang.this_year}</strong></span>
                </div>
                <div class="chart">
                    <canvas id="s1_chart" height="300"></canvas>
                </div>
            </div>
            <div class="charts big">
                <canvas id="s2_chart" height="300"></canvas>
            </div>
            <?php if (Session::get_value('account')['zaviapms']['status'] == true) : ?>
            <div class="charts little">
                <canvas id="s5_chart" height="300"></canvas>
            </div>
            <div class="charts little">
                <canvas id="s6_chart" height="300"></canvas>
            </div>
            <div class="charts little">
                <canvas id="s7_chart" height="300"></canvas>
            </div>
            <div class="charts little">
                <canvas id="s8_chart" height="300"></canvas>
            </div>
            <?php endif; ?>
            <div class="clear"></div>
        </main>
    </article>
</main>
