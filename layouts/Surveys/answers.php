<?php

defined('_EXEC') or die;

$this->dependencies->add(['css', '{$path.plugins}data-tables/jquery.dataTables.min.css']);
$this->dependencies->add(['js', '{$path.plugins}data-tables/jquery.dataTables.min.js']);
$this->dependencies->add(['js', '{$path.js}Surveys/answers.js']);
$this->dependencies->add(['other', '<script>menu_focus("surveys");</script>']);

?>

%{header}%
<main class="dashboard">
    <section class="workspace">
        <div class="tbl_stl_1">
            <aside class="filter">
              <?php if (Functions::check_user_access(['{surveys_questions_create}','{surveys_questions_update}','{surveys_questions_deactivate}','{surveys_questions_activate}','{surveys_questions_delete}']) == true) : ?>
              <a href="/surveys/questions"><i class="fas fa-question-circle"></i></a>
              <?php endif; ?>
              <?php if (Functions::check_user_access(['{surveys_answers_view}']) == true) : ?>
              <a href="/surveys/answers" class="view"><i class="fas fa-comment-alt"></i></a>
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
            {$tbl_survey_answers}
        </div>
    </section>
    <section class="buttons">
        <div>
            <a data-button-modal="search"><i class="fas fa-search"></i></a>
            <?php if (Functions::check_user_access(['{surveys_questions_create}']) == true) : ?>
            <a class="active" data-button-modal="new_survey_question"><i class="fas fa-plus"></i></a>
            <?php endif; ?>
        </div>
    </section>
</main>
<!-- <main class="answers">
    <nav>
        <h2><i class="fas fa-comment-alt"></i>{$lang.answers}</h2>
        <ul>
            <?php if (Functions::check_user_access(['{survey_questions_create}','{survey_questions_update}','{survey_questions_deactivate}','{survey_questions_activate}','{survey_questions_delete}']) == true) : ?>
            <li><a href="/surveys/questions"><i class="fas fa-question-circle"></i></a></li>
            <?php endif; ?>
            <?php if (Functions::check_user_access(['{survey_answers_view}']) == true) : ?>
            <li><a href="/surveys/answers" class="view"><i class="fas fa-comment-alt"></i></a></li>
            <?php endif; ?>
            <?php if (Functions::check_user_access(['{survey_answers_view}']) == true) : ?>
            <li><a href="/surveys/comments"><i class="far fa-comment-dots"></i></a></li>
            <?php endif; ?>
            <?php if (Functions::check_user_access(['{survey_answers_view}']) == true) : ?>
            <li><a href="/surveys/contacts"><i class="far fa-address-book"></i></a></li>
            <?php endif; ?>
            <?php if (Functions::check_user_access(['{survey_stats_view}']) == true) : ?>
            <li><a href="/surveys/stats"><i class="fas fa-chart-pie"></i></a></li>
            <?php endif; ?>
        </ul>
    </nav>
    <article>
        <main>
            <form name="get_filter_survey_answer" class="charts-filter">
                <select name="owner">
                    <option value="all">{$lang.all_owners}</option>
                    {$opt_owners}
                </select>
                <input type="date" name="started_date" value="<?php echo Functions::get_past_date(Functions::get_current_date(), '7', 'days'); ?>">
                <input type="date" name="end_date" value="<?php echo Functions::get_current_date(); ?>" max="<?php echo Functions::get_current_date(); ?>">
            </form>
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
                            <th align="left" width="100px">{$lang.owner}</th>
                            <th align="left">{$lang.guest}</th>
                            <?php endif; ?>
                            <?php if (Session::get_value('account')['type'] == 'restaurant') : ?>
                            <th align="left" width="100px">{$lang.owner}</th>
                            <th align="left">{$lang.name}</th>
                            <?php endif; ?>
                            <?php if (Session::get_value('account')['type'] == 'others') : ?>
                            <th align="left">{$lang.owner}</th>
                            <th align="left">{$lang.name}</th>
                            <?php endif; ?>
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
</section> -->
