<?php

defined('_EXEC') or die;

$this->dependencies->add(['js', '{$path.plugins}charts/Chart.js']);
$this->dependencies->add(['js', '{$vkye_base}Dashboard/charts']);
$this->dependencies->add(['js', '{$path.js}Dashboard/index.js']);
$this->dependencies->add(['other', '<script>menu_focus("dashboard");</script>']);

?>

%{header}%
<main class="dashboard">
    <section class="workspace">
        <div class="row">
            <div class="span4">
                <div class="voxes_not_complete">
                    <h2><span class="{$voxes_not_complete_all_class}">{$voxes_not_complete_all_count}</span> voxes sin resolver en total</h2>
                    <h3><i class="fas fa-rocket"></i> Peticiones | {$voxes_not_complete_request_count} voxes sin resolver</h3>
                    <h3><i class="fas fa-meteor"></i> Incidencias | {$voxes_not_complete_incident_count} voxes sin resolver</h3>
                    <h3><i class="fas fa-bomb"></i> Ordenes de trabajo | {$voxes_not_complete_workorder_count} voxes sin resolver</h3>
                    <h4><i class="fas fa-circle high"></i> Urgentes | {$voxes_not_complete_high_count} voxes sin resolver</h4>
                    <h4><i class="fas fa-circle medium"></i> Semi urgentes | {$voxes_not_complete_medium_count} voxes sin resolver</h4>
                    <h4><i class="fas fa-circle low"></i> Sin urgencia | {$voxes_not_complete_low_count} voxes sin resolver</h4>
                </div>
                <a href="/voxes" class="btn">Ver todo</a>
            </div>
            <div class="span4">
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
                <a href="/surveys" class="btn">Ver todo</a>
            </div>
            <div class="span4">
                <div class="surveys_charts">
                    <div>
                        <canvas id="s2_chart"></canvas>
                        <h1 id="nps"></h1>
                    </div>
                </div>
                <a href="/surveys" class="btn">Ver todo</a>
            </div>
        </div>
    </section>
</main>
