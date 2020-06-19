<?php

defined('_EXEC') or die;

$this->dependencies->add(['js', '{$path.js}Menu/products.js']);
$this->dependencies->add(['other', '<script>menu_focus("menu");</script>']);

?>

%{header}%
<main class="dashboard">
    <section class="workspace">
        <div class="tbl_stl_3">
            {$tbl_menu_products}
        </div>
    </section>
    <section class="buttons">
        <div>
            <a data-button-modal="search"><i class="fas fa-search"></i></a>
            <?php if (Functions::check_user_access(['{menu_create}']) == true) : ?>
            <a class="active" data-button-modal="new_menu_product"><i class="fas fa-plus"></i></a>
            <?php endif; ?>
            <?php if (Functions::check_user_access(['{menu_create}','{menu_update}','{menu_deactivate}','{menu_activate}','{menu_delete}']) == true) : ?>
            <a class="active" href="/menu/products"><i class="fas fa-concierge-bell"></i></a>
            <?php endif; ?>
            <?php if (Functions::check_user_access(['{menu_owners_create}','{menu_owners_update}','{menu_owners_deactivate}','{menu_owners_activate}','{menu_owners_delete}']) == true) : ?>
            <a href="/menu/owners"><i class="fas fa-shapes"></i></a>
            <?php endif; ?>
        </div>
    </section>
</main>
<?php if (Functions::check_user_access(['{menu_create}','{menu_update}']) == true) : ?>
<section class="modal fullscreen" data-modal="new_menu_product">
    <div class="content">
        <main>
            <form name="new_menu_product">
                <div class="row">
                    <div class="span14">
                        <div class="stl_1" data-uploader="low">
                            <figure data-preview>
                                <img src="{$path.images}empty.png">
                                <a data-select><i class="fas fa-upload"></i></a>
                                <input type="file" name="avatar" accept="image/*" data-upload>
                            </figure>
                        </div>
                    </div>
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
                                <p>(ES) {$lang.description}</p>
                                <textarea name="description_es"></textarea>
                            </label>
                        </div>
                    </div>
                    <div class="span6">
                        <div class="label">
                            <label required>
                                <p>(EN) {$lang.description}</p>
                                <textarea name="description_en"></textarea>
                            </label>
                        </div>
                    </div>
                    <div class="span12">
                        <div class="label">
                            <label required>
                                <p>({$menu_currency}) {$lang.cost}</p>
                                <input type="number" name="price">
                            </label>
                        </div>
                    </div>
                    <div class="span12">
                        <div class="label">
                            <div class="checkboxes stl_1">
                                <p>{$lang.categories}</p>
                                {$cbx_categories}
                            </div>
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
<?php if (Functions::check_user_access(['{menu_deactivate}']) == true) : ?>
<section class="modal edit" data-modal="deactivate_menu_product">
    <div class="content">
        <footer>
            <a button-close><i class="fas fa-times"></i></a>
            <a button-success><i class="fas fa-check"></i></a>
        </footer>
    </div>
</section>
<?php endif; ?>
<?php if (Functions::check_user_access(['{menu_activate}']) == true) : ?>
<section class="modal edit" data-modal="activate_menu_product">
    <div class="content">
        <footer>
            <a button-close><i class="fas fa-times"></i></a>
            <a button-success><i class="fas fa-check"></i></a>
        </footer>
    </div>
</section>
<?php endif; ?>
<?php if (Functions::check_user_access(['{menu_delete}']) == true) : ?>
<section class="modal delete" data-modal="delete_menu_product">
    <div class="content">
        <footer>
            <a button-close><i class="fas fa-times"></i></a>
            <a button-success><i class="fas fa-check"></i></a>
        </footer>
    </div>
</section>
<?php endif; ?>
