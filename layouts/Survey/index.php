<?php

defined('_EXEC') or die;

// $this->dependencies->add(['js', '{$path.plugins}charts/Chart.js']);
$this->dependencies->add(['css', '{$path.plugins}data-tables/jquery.dataTables.min.css']);
$this->dependencies->add(['js', '{$path.plugins}data-tables/jquery.dataTables.min.js']);
// $this->dependencies->add(['js', '{$vkye_base}survey/charts']);
$this->dependencies->add(['js', '{$path.js}Survey/index.js']);
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
    <div class="multi-tabs" data-tab-active="tab2">
        <ul>
            <!-- <li data-tab-target="tab1">Respuestas</li> -->
            <li data-tab-target="tab2">Preguntas</li>
            <!-- <li data-tab-target="tab3">Comentarios</li> -->
            <!-- <li data-tab-target="tab4">Preguntas</li> -->
        </ul>
        <!-- <div class="tab" data-target="tab1">
            <section class="box-container complete">
                <div class="main">
                    <article>
                        <main class="tables">
                            <div class="table-container">
                                <table id="tbl_survey_answers" class="table">
                                    <thead>
                                        <tr>
                                            <th align="left">Pregunta</th>
                                            <th align="left" width="100px">{$lang.room}</th>
                                            <th align="left" width="100px">Rate</th>
                                            <th align="left" width="100px">{$lang.date}</th>
                                            <th align="left" width="100px">Token</th>
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
        </div> -->
        <!-- <div class="tab" data-target="tab2">
            <section class="box-container complete">
                <div class="main">
                    <article>
                        <main class="tables">
                            <div class="table-container">
                                <table id="tbl_survey_subanswers" class="table">
                                    <thead>
                                        <tr>
                                            <th align="left">Subpregunta</th>
                                            <th align="left" width="100px">{$lang.room}</th>
                                            <th align="left" width="350px">Subrespuesta</th>
                                    </thead>
                                    <tbody>
                                        {$tbl_survey_subanswers}
                                    </tbody>
                                </table>
                            </div>
                        </main>
                    </article>
                </div>
            </section>
        </div> -->
        <!-- <div class="tab" data-target="tab3">
            <section class="box-container complete">
                <div class="main">
                    <article>
                        <main class="tables">
                            <div class="table-container">
                                <table id="tbl_survey_comments" class="table">
                                    <thead>
                                        <tr>
                                            <th align="left">Comentario</th>
                                            <th align="left" width="100px">{$lang.room}</th>
                                            <th align="left" width="100px">{$lang.date}</th>
                                            <th align="left" width="100px">Token</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        {$tbl_survey_comments}
                                    </tbody>
                                </table>
                            </div>
                        </main>
                    </article>
                </div>
            </section>
        </div> -->
        <div class="tab" data-target="tab2">
            <section class="box-container complete">
                <div class="main">
                    <article>
                        <main class="tables">
                            <form name="new_survey_question">
                                <div class="row">
                                    <div class="span6">
                                        <div class="label">
                                            <label>
                                                <p>(ES) Pregunta</p>
                                                <input type="text" name="survey_question_es" />
                                            </label>
                                        </div>
                                    </div>
                                    <div class="span6">
                                        <div class="label">
                                            <label>
                                                <p>(EN) Pregunta</p>
                                                <input type="text" name="survey_question_en" />
                                            </label>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </main>
                        <footer>
                            <div class="buttons text-center">
                                <a class="btn" data-action="new_survey_question">{$lang.add}</a>
                            </div>
                        </footer>
                    </article>
                    <article>
                        <main class="tables">
                            <div class="table-container">
                                <table id="tbl_survey_questions" class="table">
                                    <thead>
                                        <tr>
                                            <th align="left">Pregunta</th>
                                            <th align="left" width="100px">Estado</th>
                                            <th align="right" class="icon"></th>
                                            <th align="right" class="icon"></th>
                                            <th align="right" class="icon"></th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        {$tbl_survey_questions}
                                    </tbody>
                                </table>
                            </div>
                        </main>
                    </article>
                    <!-- <article>
                        <main class="tables">
                            <form name="edit_survey_title">
                                <div class="row">
                                    <div class="span6">
                                        <div class="label">
                                            <label>
                                                <p>(ES) Titulo de encuesta</p>
                                                <input type="text" name="survey_title_es" value="{$survey_title_es}" />
                                            </label>
                                        </div>
                                    </div>
                                    <div class="span6">
                                        <div class="label">
                                            <label>
                                                <p>(EN) Titulo de encuesta</p>
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
                    </article> -->
                </div>
            </section>
        </div>
    </div>
</main>
<section class="modal" data-modal="edit_survey_question">
    <div class="content">
        <header>
            <h3>{$lang.edit}</h3>
        </header>
        <main>
            <form name="edit_survey_question">
                <div class="row">
                    <div class="span12">
                        <div class="label">
                            <label>
                                <p>(ES) Pregunta</p>
                                <input type="text" name="survey_question_es" />
                            </label>
                        </div>
                    </div>
                    <div class="span12">
                        <div class="label">
                            <label>
                                <p>(EN) Pregunta</p>
                                <input type="text" name="survey_question_en" />
                            </label>
                        </div>
                    </div>
                </div>
            </form>
        </main>
        <footer>
            <div class="action-buttons">
                <button class="btn btn-flat" button-close>{$lang.cancel}</button>
                <button class="btn" button-success>{$lang.accept}</button>
            </div>
        </footer>
    </div>
</section>
<section class="modal" data-modal="deactivate_survey_question">
    <div class="content">
        <header>
            <h3>Desactivar</h3>
        </header>
        <footer>
            <div class="action-buttons">
                <button class="btn btn-flat" button-close>{$lang.cancel}</button>
                <button class="btn" button-success>{$lang.accept}</button>
            </div>
        </footer>
    </div>
</section>
<section class="modal" data-modal="activate_survey_question">
    <div class="content">
        <header>
            <h3>Activar</h3>
        </header>
        <footer>
            <div class="action-buttons">
                <button class="btn btn-flat" button-close>{$lang.cancel}</button>
                <button class="btn" button-success>{$lang.accept}</button>
            </div>
        </footer>
    </div>
</section>
<section class="modal" data-modal="new_survey_subquestion">
    <div class="content">
        <header>
            <h3>Nuevo</h3>
        </header>
        <main>
            <form name="new_survey_subquestion">
                <div class="row">
                    <div class="span12">
                        <div class="label">
                            <label>
                                <p>(ES) Subpregunta</p>
                                <input type="text" name="survey_subquestion_es" />
                            </label>
                        </div>
                    </div>
                    <div class="span12">
                        <div class="label">
                            <label>
                                <p>(EN) Subpregunta</p>
                                <input type="text" name="survey_subquestion_en" />
                            </label>
                        </div>
                    </div>
                    <div class="span12">
                        <div class="label">
                            <label>
                                <div class="checkboxes">
                                    <div class="checkbox">
                                        <input type="radio" name="type" value="rate" checked>
                                        <span>Rate</span>
                                    </div>
                                    <div class="checkbox">
                                        <input type="radio" name="type" value="open">
                                        <span>Abierta</span>
                                    </div>
                                </div>
                            </label>
                        </div>
                    </div>
                </div>
            </form>
        </main>
        <footer>
            <div class="action-buttons">
                <button class="btn btn-flat" button-close>{$lang.cancel}</button>
                <button class="btn" button-success>{$lang.accept}</button>
            </div>
        </footer>
    </div>
</section>
<section class="modal" data-modal="edit_survey_subquestion">
    <div class="content">
        <header>
            <h3>Editar</h3>
        </header>
        <main>
            <form name="edit_survey_subquestion">
                <div class="row">
                    <div class="span12">
                        <div class="label">
                            <label>
                                <p>(ES) Subpregunta</p>
                                <input type="text" name="survey_subquestion_es" />
                            </label>
                        </div>
                    </div>
                    <div class="span12">
                        <div class="label">
                            <label>
                                <p>(EN) Subpregunta</p>
                                <input type="text" name="survey_subquestion_en" />
                            </label>
                        </div>
                    </div>
                    <div class="span12">
                        <div class="label">
                            <label>
                                <div class="checkboxes">
                                    <div class="checkbox">
                                        <input type="radio" name="type" value="rate">
                                        <span>Rate</span>
                                    </div>
                                    <div class="checkbox">
                                        <input type="radio" name="type" value="open">
                                        <span>Abierta</span>
                                    </div>
                                </div>
                            </label>
                        </div>
                    </div>
                </div>
            </form>
        </main>
        <footer>
            <div class="action-buttons">
                <button class="btn btn-flat" button-close>{$lang.cancel}</button>
                <button class="btn" button-success>{$lang.accept}</button>
            </div>
        </footer>
    </div>
</section>
<section class="modal" data-modal="deactivate_survey_subquestion">
    <div class="content">
        <header>
            <h3>Desactivar</h3>
        </header>
        <footer>
            <div class="action-buttons">
                <button class="btn btn-flat" button-close>{$lang.cancel}</button>
                <button class="btn" button-success>{$lang.accept}</button>
            </div>
        </footer>
    </div>
</section>
<section class="modal" data-modal="activate_survey_subquestion">
    <div class="content">
        <header>
            <h3>Activar</h3>
        </header>
        <footer>
            <div class="action-buttons">
                <button class="btn btn-flat" button-close>{$lang.cancel}</button>
                <button class="btn" button-success>{$lang.accept}</button>
            </div>
        </footer>
    </div>
</section>
<!-- <section class="modal" data-modal="delete_survey_subquestion">
    <div class="content">
        <header>
            <h3>{$lang.delete}</h3>
        </header>
        <footer>
            <div class="action-buttons">
                <button class="btn btn-flat" button-close>{$lang.cancel}</button>
                <button class="btn" button-success>{$lang.accept}</button>
            </div>
        </footer>
    </div>
</section>
<section class="modal" data-modal="show_survey">
    <div class="content">
        <header>
            <h3>Respuestas</h3>
        </header>
        <main>

        </main>
        <footer>
            <div class="action-buttons">
                <button class="btn btn-flat" button-close>{$lang.accept}</button>
            </div>
        </footer>
    </div>
</section> -->
