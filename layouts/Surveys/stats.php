<?php

defined('_EXEC') or die;

$this->dependencies->add(['js', '{$path.plugins}charts/Chart.js']);
$this->dependencies->add(['js', '{$vkye_base}surveys/charts']);
$this->dependencies->add(['js', '{$path.js}Surveys/stats.js']);
$this->dependencies->add(['other', '<script>menu_focus("surveys");</script>']);

?>

%{header}%
<main>
    <nav>
        <ul>
            <?php if (Functions::check_user_access(['{survey_questions_create}','{survey_questions_update}','{survey_questions_deactivate}','{survey_questions_activate}','{survey_questions_delete}']) == true) : ?>
            <li><a href="/surveys/questions"><i class="fas fa-question-circle"></i></a></li>
            <?php endif; ?>
            <?php if (Functions::check_user_access(['{survey_answers_view}']) == true) : ?>
            <li><a href="/surveys/answers"><i class="fas fa-comment-alt"></i></a></li>
            <?php endif; ?>
            <?php if (Functions::check_user_access(['{survey_stats_view}']) == true) : ?>
            <li><a href="/surveys/stats" class="view"><i class="fas fa-chart-pie"></i></a></li>
            <?php endif; ?>
        </ul>
    </nav>
    <article>
        <header>
            <h2><i class="fas fa-chart-pie"></i>{$lang.survey_stats}</h2>
        </header>
        <main>
            <div class="voxes-counts">
                <h2>{$general_average_rate}<span>Calificación</span></h2>
                <h2>{$count_received_today}<span>Hoy</span></h2>
                <h2>{$count_received_week}<span>Esta semana</span></h2>
                <h2>{$count_received_month}<span>Este mes</span></h2>
                <h2>{$count_received_year}<span>Este año</span></h2>
                <h2>{$count_received_total}<span>Total</span></h2>
            </div>
            <div class="charts small">
                <div class="rates">

                </div>
            </div>
            <div class="charts small">
                <canvas id="s_r1_chart" height="300"></canvas>
            </div>
            <div class="charts small">
                <canvas id="s_r2_chart" height="300"></canvas>
            </div>
            <div class="charts small">
                <canvas id="s_r3_chart" height="300"></canvas>
            </div>
            <!-- <div class="charts small-medium">
                <canvas id="s_r4_chart" height="300"></canvas>
            </div>
            <div class="charts small-medium">
                <canvas id="s_r5_chart" height="300"></canvas>
            </div> -->
            <div class="clear"></div>
        </main>
    </article>
</main>
