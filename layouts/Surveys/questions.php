<?php

defined('_EXEC') or die;

$this->dependencies->add(['js', '{$path.js}Surveys/questions.js']);
$this->dependencies->add(['other', '<script>menu_focus("surveys");</script>']);

?>

%{header}%
<main class="dashboard">
    <section class="workspace">
        <div class="tbl_stl_5">
            {$tbl_surveys_questions}
        </div>
    </section>
    <section class="buttons">
        <div>
            <a data-button-modal="search"><i class="fas fa-search"></i></a>
            <?php if (Functions::check_user_access(['{surveys_questions_create}','{surveys_questions_update}','{surveys_questions_deactivate}','{surveys_questions_activate}','{surveys_questions_delete}']) == true) : ?>
            <a href="/surveys/questions" class="active"><i class="fas fa-ghost"></i></a>
            <?php endif; ?>
            <?php if (Functions::check_user_access(['{surveys_questions_create}']) == true) : ?>
            <a class="active" data-button-modal="new_survey_question"><i class="fas fa-plus"></i></a>
            <?php endif; ?>
            <?php if (Functions::check_user_access(['{surveys_answers_view}']) == true) : ?>
            <a href="/surveys/answers/raters"><i class="fas fa-star"></i></a>
            <?php endif; ?>
            <?php if (Functions::check_user_access(['{surveys_stats_view}']) == true) : ?>
            <a href="/surveys/stats"><i class="fas fa-chart-pie"></i></a>
            <?php endif; ?>
        </div>
    </section>
</main>
<?php if (Functions::check_user_access(['{surveys_questions_create}','{surveys_questions_update}']) == true) : ?>
<section class="modal fullscreen" data-modal="new_survey_question">
    <div class="content">
        <main>
            <form name="new_survey_question">
                <div class="row">
                    <div class="span12">
                        <div class="label">
                            <label unrequired>
                                <p>{$lang.type}</p>
                                <select name="parent">
                                    <option value="">{$lang.general_question}</option>
                                    {$opt_surveys_questions}
                                </select>
                            </label>
                        </div>
                    </div>
                    <div class="span6">
                        <div class="label">
                            <label required>
                                <p>(ES) {$lang.name}</p>
                                <input type="text" name="name_es">
                            </label>
                        </div>
                    </div>
                    <div class="span6">
                        <div class="label">
                            <label required>
                                <p>(EN) {$lang.name}</p>
                                <input type="text" name="name_en">
                            </label>
                        </div>
                    </div>
                    <div class="span12">
                        <div class="label">
                            <label required>
                                <p>{$lang.type}</p>
                                <select name="type">
                                    <option value="" hidden>{$lang.choose}</option>
                                    <option value="open">{$lang.open}</option>
                                    <option value="rate">{$lang.rate} ({$lang.1_5_stars})</option>
                                    <option value="twin">{$lang.twin}</option>
                                    <option value="check">{$lang.check}</option>
                                </select>
                            </label>
                        </div>
                    </div>
                    <div class="span12 hidden">
                        <div class="tbl_stl_6">
                            <div>
                                <input type="text" name="value_es" placeholder="(ES) {$lang.value}">
                                <input type="text" name="value_en" placeholder="(EN) {$lang.value}">
                                <a data-action="add_to_values_table"><i class="fas fa-check"></i></a>
                            </div>
                            <div data-list></div>
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
