<?php

defined('_EXEC') or die;

$this->dependencies->add(['js', '{$path.js}Opportunitytypes/index.js']);
$this->dependencies->add(['other', '<script>menu_focus("opportunity_types");</script>']);

?>

%{header}%
<main class="dashboard">
    <section class="workspace">
        <div class="tbl_stl_2">
            {$tbl_opportunity_types}
        </div>
    </section>
    <?php if (Functions::check_user_access(['{opportunity_types_create}']) == true) : ?>
    <section class="buttons">
        <div>
            <a class="active" data-button-modal="new_opportunity_type"><i class="fas fa-plus"></i></a>
        </div>
    </section>
    <?php endif; ?>
</main>
<?php if (Functions::check_user_access(['{opportunity_types_create}','opportunity_types_update']) == true) : ?>
<section class="modal fullscreen" data-modal="new_opportunity_type">
    <div class="content">
        <main>
            <form name="new_opportunity_type">
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
                            <label required>
                                <p>{$lang.opportunity_area}</p>
                                <select name="opportunity_area">
                                    <option value="" selected hidden>{$lang.choose}</option>
                                    {$opt_opportunity_areas}
                                </select>
                            </label>
                        </div>
                    </div>
                    <div class="span12">
                        <div class="label">
                            <label unrequired>
                                <p>{$lang.request}</p>
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
                                <p>{$lang.incident}</p>
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
                                <p>{$lang.workorder}</p>
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
                                <p>{$lang.public}</p>
                                <div class="switch">
                                    <input id="pusw" type="checkbox" name="public" class="switch_input">
                                    <label class="switch_label" for="pusw"></label>
                                </div>
                            </label>
                        </div>
                    </div>
                    <div class="span12">
                        <div class="buttons">
                            <button type="submit"><i class="fas fa-check"></i></button>
                            <a button-cancel><i class="fas fa-times"></i></a>
                        </div>
                    </div>
                </div>
            </form>
        </main>
    </div>
</section>
<?php endif; ?>
<?php if (Functions::check_user_access(['{opportunity_types_deactivate}']) == true) : ?>
<section class="modal edit" data-modal="deactivate_opportunity_type">
    <div class="content">
        <footer>
            <a button-success><i class="fas fa-check"></i></a>
            <a button-close><i class="fas fa-times"></i></a>
        </footer>
    </div>
</section>
<?php endif; ?>
<?php if (Functions::check_user_access(['{opportunity_types_activate}']) == true) : ?>
<section class="modal edit" data-modal="activate_opportunity_type">
    <div class="content">
        <footer>
            <a button-success><i class="fas fa-check"></i></a>
            <a button-close><i class="fas fa-times"></i></a>
        </footer>
    </div>
</section>
<?php endif; ?>
<?php if (Functions::check_user_access(['{opportunity_types_delete}']) == true) : ?>
<section class="modal delete" data-modal="delete_opportunity_type">
    <div class="content">
        <footer>
            <a button-success><i class="fas fa-check"></i></a>
            <a button-close><i class="fas fa-times"></i></a>
        </footer>
    </div>
</section>
<?php endif; ?>
