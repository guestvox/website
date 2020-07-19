<?php

defined('_EXEC') or die;

$this->dependencies->add(['js', '{$path.js}Menu/products.js']);
$this->dependencies->add(['other', '<script>menu_focus("menu");</script>']);

?>

%{header}%
<main class="dashboard">
    <section class="workspace">
        <div class="tbl_stl_3" data-table>
            {$tbl_menu_products}
        </div>
    </section>
    <section class="buttons">
        <div>
            <a data-button-modal="search"><i class="fas fa-search"></i></a>
            <?php if (Functions::check_user_access(['{menu_products_create}','{menu_products_update}','{menu_products_deactivate}','{menu_products_activate}','{menu_products_delete}']) == true) : ?>
            <a href="/menu/products" class="active"><i class="fas fa-cocktail"></i></a>
            <?php endif; ?>
            <?php if (Functions::check_user_access(['{menu_products_create}']) == true) : ?>
            <a class="active" data-button-modal="new_menu_product"><i class="fas fa-plus"></i></a>
            <?php endif; ?>
            <!-- <?php if (Functions::check_user_access(['{menu_restaurants_create}','{menu_restaurants_update}','{menu_restaurants_deactivate}','{menu_restaurants_activate}','{menu_restaurants_delete}']) == true) : ?>
            <a href="/menu/restaurants"><i class="fas fa-utensils"></i></a>
            <?php endif; ?> -->
        </div>
    </section>
</main>
<?php if (Functions::check_user_access(['{menu_products_create}','{menu_products_update}']) == true) : ?>
<section class="modal fullscreen" data-modal="new_menu_product">
    <div class="content">
        <main>
            <form name="new_menu_product">
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
                                <p>(<?php echo !empty(Session::get_value('account')['settings']['menu']['currency']) ? Session::get_value('account')['settings']['menu']['currency'] : Session::get_value('account')['currency'] ?>) {$lang.price}</p>
                                <input type="number" name="price">
                            </label>
                        </div>
                    </div>
                    <div class="span12">
                        <div class="stl_2" data-uploader="low">
                            <p>{$lang.avatar}</p>
                            <figure data-preview>
                                <img src="{$path.images}empty.png">
                                <a data-select><i class="fas fa-upload"></i></a>
                                <input type="file" name="avatar" accept="image/*" data-upload>
                            </figure>
                        </div>
                    </div>
                    <div class="span12">
                        <div class="checkboxes stl_1">
                            <p>{$lang.categories}</p>
                            {$cbx_menu_categories}
                        </div>
                    </div>
                    <?php if (Session::get_value('account')['settings']['menu']['multi'] == true) : ?>
                    <div class="span12">
                        <div class="label">
                            <label required>
                                <p>{$lang.restaurant}</p>
                                <select name="restaurant">
                                    <option value="" hidden>{$lang.choose}</option>
                                    {$opt_menu_restaurants}
                                </select>
                            </label>
                        </div>
                    </div>
                    <?php endif; ?>
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
<?php if (Functions::check_user_access(['{menu_products_deactivate}']) == true) : ?>
<section class="modal edit" data-modal="deactivate_menu_product">
    <div class="content">
        <footer>
            <a button-close><i class="fas fa-times"></i></a>
            <a button-success><i class="fas fa-check"></i></a>
        </footer>
    </div>
</section>
<?php endif; ?>
<?php if (Functions::check_user_access(['{menu_products_activate}']) == true) : ?>
<section class="modal edit" data-modal="activate_menu_product">
    <div class="content">
        <footer>
            <a button-close><i class="fas fa-times"></i></a>
            <a button-success><i class="fas fa-check"></i></a>
        </footer>
    </div>
</section>
<?php endif; ?>
<?php if (Functions::check_user_access(['{menu_products_delete}']) == true) : ?>
<section class="modal delete" data-modal="delete_menu_product">
    <div class="content">
        <footer>
            <a button-close><i class="fas fa-times"></i></a>
            <a button-success><i class="fas fa-check"></i></a>
        </footer>
    </div>
</section>
<?php endif; ?>
