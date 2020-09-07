<?php

defined('_EXEC') or die;

$this->dependencies->add(['js', '{$path.js}Menu/categories.js']);
$this->dependencies->add(['other', '<script>menu_focus("menu_categories");</script>']);

?>

%{header}%
<main class="dashboard">
    <section class="workspace">
        {$tbl_menu_categories}
    </section>
    <section class="buttons">
        <div>
            <a data-button-modal="search"><i class="fas fa-search"></i></a>
            <?php if (Functions::check_user_access(['{menu_categories_create}']) == true) : ?>
            <a class="new" data-button-modal="new_menu_category"><i class="fas fa-plus"></i></a>
            <?php endif; ?>
            <a data-button-modal="more_info"><i class="fas fa-info-circle"></i></a>
        </div>
    </section>
</main>
<?php if (Functions::check_user_access(['{menu_categories_create}','{menu_categories_update}']) == true) : ?>
<section class="modal fullscreen" data-modal="new_menu_category">
    <div class="content">
        <main>
            <form name="new_menu_category">
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
                    <div class="span6">
                        <div class="label">
                            <label required>
                                <p>{$lang.position}</p>
                                <input type="number" name="position" min="1">
                            </label>
                        </div>
                    </div>
                    <div class="span12">
                        <div class="checkboxes stl_4">
                            {$cbx_icons}
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
<?php if (Functions::check_user_access(['{menu_categories_deactivate}']) == true) : ?>
<section class="modal edit" data-modal="deactivate_menu_category">
    <div class="content">
        <footer>
            <a button-close><i class="fas fa-times"></i></a>
            <a button-success><i class="fas fa-check"></i></a>
        </footer>
    </div>
</section>
<?php endif; ?>
<?php if (Functions::check_user_access(['{menu_categories_activate}']) == true) : ?>
<section class="modal edit" data-modal="activate_menu_category">
    <div class="content">
        <footer>
            <a button-close><i class="fas fa-times"></i></a>
            <a button-success><i class="fas fa-check"></i></a>
        </footer>
    </div>
</section>
<?php endif; ?>
<?php if (Functions::check_user_access(['{menu_categories_delete}']) == true) : ?>
<section class="modal delete" data-modal="delete_menu_category">
    <div class="content">
        <footer>
            <a button-close><i class="fas fa-times"></i></a>
            <a button-success><i class="fas fa-check"></i></a>
        </footer>
    </div>
</section>
<?php endif; ?>
<section class="modal fullscreen" data-modal="more_info">
    <div class="content">
        <main>
            <p>{$lang.menu_categories_description_1}</p>
            <div class="buttons">
                <a class="new" button-close><i class="fas fa-check"></i></a>
            </div>
        </main>
    </div>
</section>
