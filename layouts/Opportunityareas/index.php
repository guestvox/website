<?php

defined('_EXEC') or die;

$this->dependencies->add(['js', '{$path.js}Opportunityareas/index.js']);
$this->dependencies->add(['other', '<script>menu_focus("opportunity_areas");</script>']);

?>

%{header}%
<main class="dashboard">
    <section class="workspace">
        <div class="tbl_stl_2">
            {$tbl_opportunity_areas}
        </div>
    </section>
    <section class="buttons">
        <div>
            <a data-action="search"><i class="fas fa-search"></i></a>
            <?php if (Functions::check_user_access(['{opportunity_areas_create}']) == true) : ?>
            <a class="active" data-button-modal="new_opportunity_area"><i class="fas fa-plus"></i></a>
            <?php endif; ?>
        </div>
    </section>
</main>
<?php if (Functions::check_user_access(['{opportunity_areas_create}','{opportunity_areas_update}']) == true) : ?>
<section class="modal fullscreen" data-modal="new_opportunity_area">
    <div class="content">
        <main>
            <form name="new_opportunity_area">
                <div class="row">
                    <div class="span6">
                        <div class="label">
                            <label required>
                                <p>(ES) - {$lang.name}</p>
                                <input type="text" name="name_es">
                            </label>
                        </div>
                    </div>
                    <div class="span6">
                        <div class="label">
                            <label required>
                                <p>(EN) - {$lang.name}</p>
                                <input type="text" name="name_en">
                            </label>
                        </div>
                    </div>
                    <div class="span12">
                        <div class="label">
                            <label unrequired>
                                <p class="center">{$lang.request}</p>
                                <div class="switch">
                                    <input id="rqsw" type="checkbox" name="request" class="switch_input">
                                    <label class="switch_label" for="rqsw"></label>
                                </div>
                            </label>
                        </div>
                    </div>
                    <div class="span12">
                        <div class="label">
                            <label unrequired>
                                <p class="center">{$lang.incident}</p>
                                <div class="switch">
                                    <input id="insw" type="checkbox" name="incident" class="switch_input">
                                    <label class="switch_label" for="insw"></label>
                                </div>
                            </label>
                        </div>
                    </div>
                    <div class="span12">
                        <div class="label">
                            <label unrequired>
                                <p class="center">{$lang.workorder}</p>
                                <div class="switch">
                                    <input id="wksw" type="checkbox" name="workorder" class="switch_input">
                                    <label class="switch_label" for="wksw"></label>
                                </div>
                            </label>
                        </div>
                    </div>
                    <div class="span12">
                        <div class="label">
                            <label unrequired>
                                <p class="center">{$lang.public}</p>
                                <div class="switch">
                                    <input id="pusw" type="checkbox" name="public" class="switch_input">
                                    <label class="switch_label" for="pusw"></label>
                                </div>
                            </label>
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
<?php if (Functions::check_user_access(['{opportunity_areas_deactivate}']) == true) : ?>
<section class="modal edit" data-modal="deactivate_opportunity_area">
    <div class="content">
        <footer>
            <a button-close><i class="fas fa-times"></i></a>
            <a button-success><i class="fas fa-check"></i></a>
        </footer>
    </div>
</section>
<?php endif; ?>
<?php if (Functions::check_user_access(['{opportunity_areas_activate}']) == true) : ?>
<section class="modal edit" data-modal="activate_opportunity_area">
    <div class="content">
        <footer>
            <a button-close><i class="fas fa-times"></i></a>
            <a button-success><i class="fas fa-check"></i></a>
        </footer>
    </div>
</section>
<?php endif; ?>
<?php if (Functions::check_user_access(['{opportunity_areas_delete}']) == true) : ?>
<section class="modal delete" data-modal="delete_opportunity_area">
    <div class="content">
        <footer>
            <a button-close><i class="fas fa-times"></i></a>
            <a button-success><i class="fas fa-check"></i></a>
        </footer>
    </div>
</section>
<?php endif; ?>
