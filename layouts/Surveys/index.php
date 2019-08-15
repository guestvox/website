<?php

defined('_EXEC') or die;

$this->dependencies->add(['css', '{$path.plugins}data-tables/jquery.dataTables.min.css']);
$this->dependencies->add(['js', '{$path.plugins}data-tables/jquery.dataTables.min.js']);
$this->dependencies->add(['js', '{$path.js}Surveys/index.js']);
$this->dependencies->add(['other', '<script>menu_focus("surveys");</script>']);

?>

%{header}%

<main>
    <div class="multi-tabs" data-tab-active="tab1">
        <ul>
            <li data-tab-target="tab1" class="active">Preguntas</li>
            <li data-tab-target="tab2" class="active">Respuestas</li>
        </ul>
        <div class="tab" data-target="tab1">
            <section class="box-container complete">
                <div class="main">
                    <article>
                        <main class="tables">
                            <form name="new_question">
                                <div class="row">
                                    <div class="span6">
                                        <div class="label">
                                            <label>
                                                <p>(ES) Pregunta</p>
                                                <input type="text" name="question_es" />
                                            </label>
                                        </div>
                                    </div>
                                    <div class="span6">
                                        <div class="label">
                                            <label>
                                                <p>(EN) Pregunta</p>
                                                <input type="text" name="question_en" />
                                            </label>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </main>
                        <footer>
                            <div class="buttons text-center">
                                <a class="btn" data-action="new_question">{$lang.add}</a>
                            </div>
                        </footer>
                    </article>
                    <article>
                        <main class="tables">
                            <div class="table-container">
                                <table id="questions" class="table">
                                    <thead>
                                        <tr>
                                            <th align="left">Pregunta</th>
                                            <th align="right" class="icon"></th>
                                            <th align="right" class="icon"></th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        {$tbl_questions}
                                    </tbody>
                                </table>
                            </div>
                        </main>
                    </article>
                </div>
            </section>
        </div>
        <div class="tab" data-target="tab2">
            <section class="box-container complete">
                <div class="main">
                    <article>
                        <main class="tables">
                            <div class="table-container">
                                <table id="answers" class="table">
                                    <thead>
                                        <tr>
                                            <th align="left">Pregunta</th>
                                            <th align="left">Respuesta</th>
                                            <th align="right" class="icon"></th>
                                            <th align="right" class="icon"></th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        {$tbl_answers}
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
<section class="modal" data-modal="edit_question">
    <div class="content">
        <header>
            <h3>{$lang.edit}</h3>
        </header>
        <main>
            <form name="edit_question">
                <div class="row">
                    <div class="span6">
                        <div class="label">
                            <label>
                                <p>(ES) Pregunta</p>
                                <input type="text" name="question_es" />
                            </label>
                        </div>
                    </div>
                    <div class="span6">
                        <div class="label">
                            <label>
                                <p>(EN) Pregunta</p>
                                <input type="text" name="question_en" />
                            </label>
                        </div>
                    </div>
                </div>
            </form>
        </main>
        <footer>
            <div class="action-buttons">
                <button class="btn btn-flat" button-cancel>{$lang.cancel}</button>
                <button class="btn" button-success>{$lang.accept}</button>
            </div>
        </footer>
    </div>
</section>
<section class="modal" data-modal="delete_question">
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
