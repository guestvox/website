<?php

defined('_EXEC') or die;

$this->dependencies->add(['js', '{$path.js}Surveys/index.js']);
$this->dependencies->add(['other', '<script>menu_focus("surveys");</script>']);

?>

%{header}%
<main class="dashboard">
    <section class="workspace">
        <div class="tbl_stl_3" data-table>
            {$tbl_surveys}
        </div>
    </section>
    <section class="buttons">
        <?php if (Functions::check_user_access(['{surveys_questions_create}']) == true) : ?>
        <div>
            <a class="new" data-button-modal="new_survey"><i class="fas fa-plus"></i></a>
        </div>
        <?php endif; ?>
    </section>
</main>
<?php if (Functions::check_user_access(['{surveys_questions_create}','{surveys_questions_update}']) == true) : ?>
<section class="modal fullscreen" data-modal="new_survey">
    <div class="content">
        <main>
            <form name="new_survey">
                <div class="row">
                    <div class="span6">
                        <div class="label">
                            <label required>
                                <p>(ES) {$lang.name}</p>
                                <input type="text" name="name_es" data-translates="name">
                            </label>
                        </div>
                    </div>
                    <div class="span6">
                        <div class="label">
                            <label required>
                                <p>(EN) {$lang.name}</p>
                                <input type="text" name="name_en" data-translaten="name">
                            </label>
                        </div>
                    </div>
                    <div class="span6">
                        <div class="label">
                            <label unrequired>
                                <p>{$lang.signature}</p>
                                <div class="switch">
                                    <input id="sgsw" type="checkbox" name="signature" data-switcher>
                                    <label for="sgsw"></label>
                                </div>
                            </label>
                        </div>
                    </div>
                    <div class="span6">
                        <div class="label">
                            <label unrequired>
                                <p>{$lang.main}</p>
                                <div class="switch">
                                    <input id="masw" type="checkbox" name="main" data-switcher>
                                    <label for="masw"></label>
                                </div>
                            </label>
                        </div>
                    </div>
                    <div class="span12">
                        <div class="buttons">
                            <a class="delete" button-cancel><i class="fas fa-times"></i></a>
                            <button type="submit" class="new"><i class="fas fa-check"></i></button>
                        </div>
                    </div>
                </div>
            </form>
        </main>
    </div>
</section>
<?php endif; ?>
<?php if (Functions::check_user_access(['{surveys_questions_deactivate}']) == true) : ?>
<section class="modal edit" data-modal="deactivate_survey">
    <div class="content">
        <footer>
            <a button-close><i class="fas fa-times"></i></a>
            <a button-success><i class="fas fa-check"></i></a>
        </footer>
    </div>
</section>
<?php endif; ?>
<?php if (Functions::check_user_access(['{surveys_questions_activate}']) == true) : ?>
<section class="modal edit" data-modal="activate_survey">
    <div class="content">
        <footer>
            <a button-close><i class="fas fa-times"></i></a>
            <a button-success><i class="fas fa-check"></i></a>
        </footer>
    </div>
</section>
<?php endif; ?>
<?php if (Functions::check_user_access(['{surveys_questions_delete}']) == true) : ?>
<section class="modal delete" data-modal="delete_survey">
    <div class="content">
        <footer>
            <a button-close><i class="fas fa-times"></i></a>
            <a button-success><i class="fas fa-check"></i></a>
        </footer>
    </div>
</section>
<?php endif; ?>
