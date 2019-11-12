<?php

defined('_EXEC') or die;

// $this->dependencies->add(['js', '{$path.plugins}charts/Chart.js']);
$this->dependencies->add(['css', '{$path.plugins}data-tables/jquery.dataTables.min.css']);
$this->dependencies->add(['js', '{$path.plugins}data-tables/jquery.dataTables.min.js']);
// $this->dependencies->add(['js', '{$vkye_base}survey/charts']);
$this->dependencies->add(['js', '{$path.js}Survey/answers.js']);
$this->dependencies->add(['other', '<script>menu_focus("survey");</script>']);

?>

%{header}%
<main>
    <!-- <section class="box-container">
        <div class="main">
            <article>
                <main class="tables">
                    <div class="charts">
                        <canvas id="s_r1_chart" height="320"></canvas>
                    </div>
                    <div class="charts">
                        <canvas id="s_r2_chart" height="320"></canvas>
                    </div>
                    <div class="clear"></div>
                </main>
            </article>
        </div>
        <aside class="padding">
            <div class="counts">
                <h2>{$total_rate_avarage} Pts<span>Promedio de puntuaje total</span></h2>
            </div>
        </aside>
    </section> -->
    <div class="multi-tabs" data-tab-active="tab1">
        <ul>
            <li data-tab-target="tab1"><a href="/survey/answers">{$lang.answers}</a></li>
            <li data-tab-target="tab2"><a href="/survey/questions">{$lang.questions}</a></li>
            <li data-tab-target="tab3"><a href="/survey/settings">{$lang.configuration}</a></li>
        </ul>
        <div class="tab" data-target="tab1">
            <section class="box-container complete">
                <div class="main">
                    <article>
                        <main class="tables">
                            <div class="table-container">
                                <table id="tbl_survey_answers" class="table">
                                    <thead>
                                        <tr>
                                            <th align="left" width="100px">Token</th>
                                            <th align="left" width="100px">{$lang.room}</th>
                                            <th align="left">{$lang.guest}</th>
                                            <th align="left">{$lang.email}</th>
                                            <th align="left" width="100px">{$lang.date}</th>
                                            <th align="left" width="100px">Calificación</th>
                                            <th align="right" class="icon"></th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        {$tbl_survey_answers}
                                    </tbody>
                                </table>
                            </div>
                        </main>
                    </article>
                </div>
            </section>
        </div>
    </div>
</main>
<section class="modal" data-modal="view_survey_answers">
    <div class="content">
        <header>
            <h3>{$lang.survey}</h3>
        </header>
        <main>

        </main>
        <footer>
            <div class="action-buttons">
                <button class="btn" button-close>{$lang.accept}</button>
            </div>
        </footer>
    </div>
</section>
