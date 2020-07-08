<?php

defined('_EXEC') or die;

$this->dependencies->add(['js', '{$path.js}Surveys/answers.js']);
$this->dependencies->add(['other', '<script>menu_focus("surveys");</script>']);

?>

%{header}%
<main class="dashboard">
    <section class="workspace">
        <div class="tbl_stl_7">
            {$tbl_surveys_answers}
        </div>
    </section>
    <section class="buttons">
        <div>
            <a data-button-modal="search"><i class="fas fa-search"></i></a>
            <?php if (Functions::check_user_access(['{surveys_questions_create}','{surveys_questions_update}','{surveys_questions_deactivate}','{surveys_questions_activate}','{surveys_questions_delete}']) == true) : ?>
            <a href="/surveys/questions"><i class="fas fa-ghost"></i></a>
            <?php endif; ?>
            <?php if (Functions::check_user_access(['{surveys_answers_view}']) == true) : ?>
            <a href="/surveys/answers" class="active"><i class="fas fa-comment-alt"></i></a>
            <a class="active" data-button-modal="filter_surveys_answers"><i class="fas fa-stream"></i></a>
            <?php endif; ?>
            <?php if (Functions::check_user_access(['{surveys_stats_view}']) == true) : ?>
            <a href="/surveys/stats"><i class="fas fa-chart-pie"></i></a>
            <?php endif; ?>
        </div>
    </section>
</main>
<section class="modal fullscreen" data-modal="preview_survey_answer">
    <div class="content">
        <main>
            <div class="survey_answer_preview"></div>
            <div class="buttons">
                <a button-close><i class="fas fa-check"></i></a>
            </div>
        </main>
    </div>
</section>
<section class="modal fullscreen" data-modal="filter_surveys_answers">
    <div class="content">
        <main>
            <form name="filter_surveys_answers">
                <div class="row">
                    <div class="span6">
                        <div class="label">
                            <label required>
                                <p>{$lang.started_date}</p>
                                <input type="date" name="started_date" value="<?php echo Session::get_value('settings')['surveys']['answers']['filter']['started_date']; ?>">
                            </label>
                        </div>
                    </div>
                    <div class="span6">
                        <div class="label">
                            <label required>
                                <p>{$lang.end_date}</p>
                                <input type="date" name="end_date" value="<?php echo Session::get_value('settings')['surveys']['answers']['filter']['end_date']; ?>">
                            </label>
                        </div>
                    </div>
                    <div class="span6">
                        <div class="label">
                            <label required>
                                <p>{$lang.owner}</p>
                                <select name="owner">
                                    <option value="all" <?php echo ((Session::get_value('settings')['surveys']['answers']['filter']['owner'] == 'all') ? 'selected' : ''); ?>>{$lang.all}</option>
                                    {$opt_owners}
                                </select>
                            </label>
                        </div>
                    </div>
                    <div class="span6">
                        <div class="label">
                            <label required>
                                <p>{$lang.rating}</p>
                                <select name="rating">
                                    <option value="all" <?php echo ((Session::get_value('settings')['surveys']['answers']['filter']['rating'] == 'all') ? 'selected' : ''); ?>>{$lang.all}</option>
                                    <option value="1" <?php echo ((Session::get_value('settings')['surveys']['answers']['filter']['rating'] == '1') ? 'selected' : ''); ?>>1</option>
                                    <option value="2" <?php echo ((Session::get_value('settings')['surveys']['answers']['filter']['rating'] == '2') ? 'selected' : ''); ?>>2</option>
                                    <option value="3" <?php echo ((Session::get_value('settings')['surveys']['answers']['filter']['rating'] == '3') ? 'selected' : ''); ?>>3</option>
                                    <option value="4" <?php echo ((Session::get_value('settings')['surveys']['answers']['filter']['rating'] == '4') ? 'selected' : ''); ?>>4</option>
                                    <option value="5" <?php echo ((Session::get_value('settings')['surveys']['answers']['filter']['rating'] == '5') ? 'selected' : ''); ?>>5</option>
                                </select>
                            </label>
                        </div>
                    </div>
                    <div class="span12">
                        <div class="buttons">
                            <a button-close><i class="fas fa-times"></i></a>
                            <button type="submit"><i class="fas fa-check"></i></button>
                        </div>
                    </div>
                </div>
            </form>
        </main>
    </div>
</section>
