<?php

defined('_EXEC') or die;

$this->dependencies->add(['js', '{$path.js}Locations/index.js']);
$this->dependencies->add(['other', '<script>menu_focus("locations");</script>']);

?>

%{header}%
<main class="dashboard">
    <section class="workspace">
        <div class="tbl_stl_2" data-table>
            {$tbl_locations}
        </div>
    </section>
    <section class="buttons">
        <div>
            <a data-button-modal="search"><i class="fas fa-search"></i></a>
            <?php if (Functions::check_user_access(['{locations_create}']) == true) : ?>
            <a class="new" data-button-modal="new_location"><i class="fas fa-plus"></i></a>
            <?php endif; ?>
        </div>
    </section>
</main>
<?php if (Functions::check_user_access(['{locations_create}','{locations_update}']) == true) : ?>
<section class="modal fullscreen" data-modal="new_location">
    <div class="content">
        <main>
            <form name="new_location">
                <div class="row">
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
                            <label>
                                <p class="center">{$lang.available_for_use_in}:</p>
                            </label>
                        </div>
                    </div>
                    <div class="span3">
                        <div class="label">
                            <label unrequired>
                                <p>{$lang.request}</p>
                                <div class="switch">
                                    <input id="rqsw" type="checkbox" name="request" data-switcher>
                                    <label for="rqsw"></label>
                                </div>
                            </label>
                        </div>
                    </div>
                    <div class="span3">
                        <div class="label">
                            <label unrequired>
                                <p>{$lang.incident}</p>
                                <div class="switch">
                                    <input id="insw" type="checkbox" name="incident" data-switcher>
                                    <label for="insw"></label>
                                </div>
                            </label>
                        </div>
                    </div>
                    <div class="span3">
                        <div class="label">
                            <label unrequired>
                                <p>{$lang.workorder}</p>
                                <div class="switch">
                                    <input id="wksw" type="checkbox" name="workorder" data-switcher>
                                    <label for="wksw"></label>
                                </div>
                            </label>
                        </div>
                    </div>
                    <div class="span3">
                        <div class="label">
                            <label unrequired>
                                <p>{$lang.public}</p>
                                <div class="switch">
                                    <input id="pusw" type="checkbox" name="public" data-switcher>
                                    <label for="pusw"></label>
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
<?php if (Functions::check_user_access(['{locations_deactivate}']) == true) : ?>
<section class="modal edit" data-modal="deactivate_location">
    <div class="content">
        <footer>
            <a button-close><i class="fas fa-times"></i></a>
            <a button-success><i class="fas fa-check"></i></a>
        </footer>
    </div>
</section>
<?php endif; ?>
<?php if (Functions::check_user_access(['{locations_activate}']) == true) : ?>
<section class="modal edit" data-modal="activate_location">
    <div class="content">
        <footer>
            <a button-close><i class="fas fa-times"></i></a>
            <a button-success><i class="fas fa-check"></i></a>
        </footer>
    </div>
</section>
<?php endif; ?>
<?php if (Functions::check_user_access(['{locations_delete}']) == true) : ?>
<section class="modal delete" data-modal="delete_location">
    <div class="content">
        <footer>
            <a button-close><i class="fas fa-times"></i></a>
            <a button-success><i class="fas fa-check"></i></a>
        </footer>
    </div>
</section>
<?php endif; ?>
