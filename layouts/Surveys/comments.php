<?php

defined('_EXEC') or die;

$this->dependencies->add(['css', '{$path.plugins}data-tables/jquery.dataTables.min.css']);
$this->dependencies->add(['js', '{$path.plugins}data-tables/jquery.dataTables.min.js']);
$this->dependencies->add(['js', '{$path.js}Surveys/comments.js']);
$this->dependencies->add(['other', '<script>menu_focus("surveys");</script>']);

?>

%{header}%
<main>
    <nav>
        <h2><i class="fas fa-comment-dots"></i>{$lang.comments}</h2>
        <ul>
            <?php if (Functions::check_user_access(['{survey_questions_create}','{survey_questions_update}','{survey_questions_deactivate}','{survey_questions_activate}','{survey_questions_delete}']) == true) : ?>
            <li><a href="/surveys/questions"><i class="fas fa-question-circle"></i></a></li>
            <?php endif; ?>
            <?php if (Functions::check_user_access(['{survey_answers_view}']) == true) : ?>
            <li><a href="/surveys/answers"><i class="fas fa-comment-alt"></i></a></li>
            <?php endif; ?>
            <?php if (Functions::check_user_access(['{survey_answers_view}']) == true) : ?>
            <li><a href="/surveys/comments" class="view"><i class="far fa-comment-dots"></i></a></li>
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
            <form name="get_filter_survey_comments" class="charts-filter">
                <select name="room">
                    <option value="all">{$lang.all_rooms}</option>
                    {$opt_rooms}
                </select>
                <input type="date" name="started_date" value="<?php echo Functions::get_past_date(Functions::get_current_date(), '7', 'days'); ?>">
                <input type="date" name="end_date" value="<?php echo Functions::get_current_date(); ?>" max="<?php echo Functions::get_current_date(); ?>">
            </form>
            <div class="table">
                <aside>
                    <label>
                        <span><i class="fas fa-search"></i></span>
                        <input type="text" name="tbl_survey_comments_search">
                    </label>
                </aside>
                <table id="tbl_survey_comments">
                    <thead>
                        <tr>
                            <th align="left" width="100px">{$lang.token}</th>
                            <?php if (Session::get_value('account')['type'] == 'hotel') : ?>
                            <th align="left" width="100px">{$lang.room}</th>
                            <th align="left">{$lang.guest}</th>
                            <?php endif; ?>
                            <?php if (Session::get_value('account')['type'] == 'restaurant') : ?>
                            <th align="left" width="100px">{$lang.table}</th>
                            <th align="left">{$lang.guest}</th>
                            <?php endif; ?>
                            <?php if (Session::get_value('account')['type'] == 'others') : ?>
                            <th align="left">{$lang.client}</th>
                            <th align="left">{$lang.guest}</th>
                            <?php endif; ?>
                            <th align="left">{$lang.comments}</th>
                            <th align="right" class="icon"></th>
                        </tr>
                    </thead>
                    <tbody>
                        {$tbl_survey_comments}
                    </tbody>
                </table>
            </div>
        </main>
    </article>
</main>
<section class="modal" data-modal="deactivate_comment">
    <div class="content">
        <header>
            <h3>{$lang.deactivate}</h3>
        </header>
        <footer>
            <div class="action-buttons">
                <button class="btn btn-flat" button-close>{$lang.cancel}</button>
                <button class="btn" button-success>{$lang.accept}</button>
            </div>
        </footer>
    </div>
</section>
<section class="modal" data-modal="activate_comment">
    <div class="content">
        <header>
            <h3>{$lang.activate}</h3>
        </header>
        <footer>
            <div class="action-buttons">
                <button class="btn btn-flat" button-close>{$lang.cancel}</button>
                <button class="btn" button-success>{$lang.accept}</button>
            </div>
        </footer>
    </div>
</section>
