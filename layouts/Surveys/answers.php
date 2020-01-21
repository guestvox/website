<?php

defined('_EXEC') or die;

$this->dependencies->add(['css', '{$path.plugins}data-tables/jquery.dataTables.min.css']);
$this->dependencies->add(['js', '{$path.plugins}data-tables/jquery.dataTables.min.js']);
$this->dependencies->add(['js', '{$path.js}Surveys/answers.js']);
$this->dependencies->add(['other', '<script>menu_focus("surveys");</script>']);

?>

%{header}%
<main>
    <nav>
        <h2><i class="fas fa-comment-alt"></i>{$lang.survey_answers}</h2>
        <ul>
            <?php if (Functions::check_user_access(['{survey_questions_create}','{survey_questions_update}','{survey_questions_deactivate}','{survey_questions_activate}','{survey_questions_delete}']) == true) : ?>
            <li><a href="/surveys/questions"><i class="fas fa-question-circle"></i></a></li>
            <?php endif; ?>
            <?php if (Functions::check_user_access(['{survey_answers_view}']) == true) : ?>
            <li><a href="/surveys/answers" class="view"><i class="fas fa-comment-alt"></i></a></li>
            <?php endif; ?>
            <?php if (Functions::check_user_access(['{survey_stats_view}']) == true) : ?>
            <li><a href="/surveys/stats"><i class="fas fa-chart-pie"></i></a></li>
            <?php endif; ?>
        </ul>
    </nav>
    <article>
        <main>
            <div class="table">
                <aside>
                    <label>
                        <span><i class="fas fa-search"></i></span>
                        <input type="text" name="tbl_survey_answers_search">
                    </label>
                </aside>
                <table id="tbl_survey_answers">
                    <thead>
                        <tr>
                            <th align="left" class="icon"></th>
                            <th align="left" width="100px">{$lang.token}</th>
                            <?php if (Session::get_value('account')['type'] == 'hotel') : ?>
                            <th align="left" width="100px">{$lang.room}</th>
                            <?php endif; ?>
                            <?php if (Session::get_value('account')['type'] == 'restaurant') : ?>
                            <th align="left" width="100px">{$lang.table}</th>
                            <?php endif; ?>
                            <th align="left">{$lang.guest}</th>
                            <th align="left" width="100px">{$lang.date}</th>
                            <th align="left" width="100px">{$lang.points}</th>
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
</main>
<section class="modal" data-modal="view_survey_answer">
    <div class="content">
        <header>
            <h3>{$lang.details}</h3>
        </header>
        <main></main>
        <footer>
            <div class="action-buttons">
                <button class="btn" button-close>{$lang.accept}</button>
            </div>
        </footer>
    </div>
</section>
