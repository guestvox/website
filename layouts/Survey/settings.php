<?php

defined('_EXEC') or die;

// $this->dependencies->add(['js', '{$path.plugins}charts/Chart.js']);
$this->dependencies->add(['css', '{$path.plugins}data-tables/jquery.dataTables.min.css']);
$this->dependencies->add(['js', '{$path.plugins}data-tables/jquery.dataTables.min.js']);
// $this->dependencies->add(['js', '{$vkye_base}survey/charts']);
$this->dependencies->add(['js', '{$path.js}Survey/settings.js']);
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
    <div class="multi-tabs" data-tab-active="tab3">
        <ul>
            <li data-tab-target="tab1"><a href="/survey/answers">{$lang.answers}</a></li>
            <li data-tab-target="tab2"><a href="/survey/questions">{$lang.questions}</a></li>
            <li data-tab-target="tab3"><a href="/survey/settings">{$lang.configuration}</a></li>
        </ul>
        <div class="tab" data-target="tab3">
            <section class="box-container complete">
                <div class="main">
                    <article>
                        <main class="tables">
                            <form name="edit_survey_title">
                                <div class="row">
                                    <div class="span6">
                                        <div class="label">
                                            <label>
                                                <p>(ES) {$lang.survey_title}</p>
                                                <input type="text" name="survey_title_es" value="{$survey_title_es}" />
                                            </label>
                                        </div>
                                    </div>
                                    <div class="span6">
                                        <div class="label">
                                            <label>
                                                <p>(EN) {$lang.survey_title}</p>
                                                <input type="text" name="survey_title_en" value="{$survey_title_en}" />
                                            </label>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </main>
                        <footer>
                            <div class="buttons text-center">
                                <a class="btn" data-action="edit_survey_title">{$lang.edit}</a>
                            </div>
                        </footer>
                    </article>
                </div>
            </section>
        </div>
    </div>
</main>
