<?php

defined('_EXEC') or die;

$this->dependencies->add(['js', '{$path.js}Surveys/questions.js']);
$this->dependencies->add(['other', '<script>menu_focus("surveys");</script>']);

?>

%{header}%
<main class="dashboard">
    <section class="workspace">
        <div class="tbl_stl_1">
            <aside class="filter">
              <?php if (Functions::check_user_access(['{surveys_questions_create}','{surveys_questions_update}','{surveys_questions_deactivate}','{surveys_questions_activate}','{surveys_questions_delete}']) == true) : ?>
              <a href="/surveys/questions" class="view"><i class="fas fa-question-circle"></i></a>
              <?php endif; ?>
              <?php if (Functions::check_user_access(['{surveys_answers_view}']) == true) : ?>
              <a href="/surveys/answers"><i class="fas fa-comment-alt"></i></a>
              <?php endif; ?>
              <?php if (Functions::check_user_access(['{surveys_answers_view}']) == true) : ?>
              <a href="/surveys/comments"><i class="far fa-comment-dots"></i></a>
              <?php endif; ?>
              <?php if (Functions::check_user_access(['{surveys_answers_view}']) == true) : ?>
              <a href="/surveys/contacts"><i class="far fa-address-book"></i></a>
              <?php endif; ?>
              <?php if (Functions::check_user_access(['{surveys_stats_view}']) == true) : ?>
              <a href="/surveys/stats"><i class="fas fa-chart-pie"></i></a>
              <?php endif; ?>
            </aside>
            {$tbl_survey_questions}
        </div>
    </section>
    <section class="buttons">
        <div>
            <a data-button-modal="search"><i class="fas fa-search"></i></a>
            <?php if (Functions::check_user_access(['{surveys_questions_create}']) == true) : ?>
            <a class="active" data-button-modal="new_survey_question"><i class="fas fa-plus"></i></a>
            <?php endif; ?>
            <a data-action="get_preview_survey"><i class="fas fa-eye"></i></a>
        </div>
    </section>
</main>
<?php if (Functions::check_user_access(['{surveys_questions_create}','{surveys_questions_update}']) == true) : ?>
<section class="modal fullscreen" data-modal="new_survey_question">
    <div class="content">
        <main>
            <form name="new_survey_question">
                <div class="row">
                    <div class="span6">
                        <div class="label">
                            <label>
                                <p>(ES) {$lang.name}</p>
                                <input type="text" name="name_es">
                            </label>
                        </div>
                    </div>
                    <div class="span6">
                        <div class="label">
                            <label>
                                <p>(EN) {$lang.name}</p>
                                <input type="text" name="name_en">
                            </label>
                        </div>
                    </div>
                    <div id="check" class="checkers hidden">
                        <div class="span6">
                            <div class="label">
                                <label>
                                    <p>(ES) {$lang.check_value}</p>
                                    <input type="text" name="check_name_es">
                                </label>
                            </div>
                        </div>
                        <div class="span6">
                            <div class="label">
                                <label>
                                    <p>(EN) {$lang.check_value}</p>
                                    <input type="text" name="check_name_en">
                                </label>
                                <a data-action="new_check_value" class="new"><i class="fas fa-check"></i></a>
                            </div>
                        </div>
                        <div class="list"></div>
                    </div>
                    <div class="span12">
                        <div class="label">
                            <label>
                                <p>{$lang.type}</p>
                            </label>
                            <div class="checkboxes">
                                <div>
                    				<div>
                                        <div>
                        					<input type="radio" name="type" value="rate">
                        					<span>{$lang.rate}</span>
                        				</div>
                                        <div>
                        					<input type="radio" name="type" value="twin">
                        					<span>{$lang.twin}</span>
                        				</div>
                                        <div>
                        					<input type="radio" name="type" value="open">
                        					<span>{$lang.open}</span>
                        				</div>
                                        <div>
                        					<input type="radio" name="type" value="check">
                        					<span>{$lang.check}</span>
                        				</div>
                                    </div>
                    			</div>
                            </div>
                        </div>
                    </div>
                    <div class="span12">
                        <div class="buttons">
                            <a button-cancel><i class="fas fa-times"></i></a>
                            <button type="submit"><i class="fas fa-check"></i></button>
                        </div>
                    </div>
                </div>
            </form>
        </main>
    </div>
</section>
<?php endif; ?>
<?php if (Functions::check_user_access(['{surveys_questions_deactivate}']) == true) : ?>
<section class="modal edit" data-modal="deactivate_survey_question">
    <div class="content">
        <footer>
            <a button-close><i class="fas fa-times"></i></a>
            <a button-success><i class="fas fa-check"></i></a>
        </footer>
    </div>
</section>
<?php endif; ?>
<?php if (Functions::check_user_access(['{surveys_questions_activate}']) == true) : ?>
<section class="modal edit" data-modal="activate_survey_question">
    <div class="content">
        <footer>
            <a button-close><i class="fas fa-times"></i></a>
            <a button-success><i class="fas fa-check"></i></a>
        </footer>
    </div>
</section>
<?php endif; ?>
<?php if (Functions::check_user_access(['{surveys_questions_delete}']) == true) : ?>
<section class="modal delete" data-modal="delete_survey_question">
    <div class="content">
        <footer>
            <a button-close><i class="fas fa-times"></i></a>
            <a button-success><i class="fas fa-check"></i></a>
        </footer>
    </div>
</section>
<?php endif; ?>
