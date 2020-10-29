<?php

defined('_EXEC') or die;

$this->dependencies->add(['js', '{$path.js}Opportunitytypes/index.js']);
$this->dependencies->add(['other', '<script>menu_focus("opportunity_types");</script>']);

?>

%{header}%
<main class="dashboard">
    <section class="workspace">
        <form action="">
            <div class="row">
                <div class="span12">
                    <div class="label">
                        <label required>
                            <p>{$lang.opportunity_area}</p>
                            <select name="search_opportunity_area">
                                <option value="all"<?php echo ((Session::get_value('settings')['voxes']['opportunity_areas']['filter']['id'] == 'all') ? 'selected' : '')?>>{$lang.all}</option>
                                {$opt_opportunity_areas}
                            </select>
                        </label>
                    </div>
                </div>
            </div>
        </form>
        <div class="tbl_stl_2" data-table>
            {$tbl_opportunity_types}
        </div>
    </section>
    <section class="buttons">
        <div>
            <a data-button-modal="search"><i class="fas fa-search"></i></a>
            <?php if (Functions::check_user_access(['{opportunity_types_create}']) == true) : ?>
            <a class="new" data-button-modal="new_opportunity_type"><i class="fas fa-plus"></i></a>
            <?php endif; ?>
        </div>
    </section>
</main>
<?php if (Functions::check_user_access(['{opportunity_types_create}','{opportunity_types_update}']) == true) : ?>
<section class="modal fullscreen" data-modal="new_opportunity_type">
    <div class="content">
        <main>
            <form name="new_opportunity_type">
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
                    <div class="span12">
                        <div class="label">
                            <label required>
                                <p>{$lang.opportunity_area}</p>
                                <select name="opportunity_area">
                                    <option value="" hidden>{$lang.choose}</option>
                                    {$opt_opportunity_areas}
                                </select>
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
<?php if (Functions::check_user_access(['{opportunity_types_deactivate}']) == true) : ?>
<section class="modal edit" data-modal="deactivate_opportunity_type">
    <div class="content">
        <footer>
            <a button-close><i class="fas fa-times"></i></a>
            <a button-success><i class="fas fa-check"></i></a>
        </footer>
    </div>
</section>
<?php endif; ?>
<?php if (Functions::check_user_access(['{opportunity_types_activate}']) == true) : ?>
<section class="modal edit" data-modal="activate_opportunity_type">
    <div class="content">
        <footer>
            <a button-close><i class="fas fa-times"></i></a>
            <a button-success><i class="fas fa-check"></i></a>
        </footer>
    </div>
</section>
<?php endif; ?>
<?php if (Functions::check_user_access(['{opportunity_types_delete}']) == true) : ?>
<section class="modal delete" data-modal="delete_opportunity_type">
    <div class="content">
        <footer>
            <a button-close><i class="fas fa-times"></i></a>
            <a button-success><i class="fas fa-check"></i></a>
        </footer>
    </div>
</section>
<?php endif; ?>
