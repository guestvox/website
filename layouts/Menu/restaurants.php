<?php

defined('_EXEC') or die;

$this->dependencies->add(['js', '{$path.js}Menu/restaurants.js']);
$this->dependencies->add(['other', '<script>menu_focus("menu");</script>']);

?>

%{header}%
<main class="dashboard">
    <section class="workspace">
        <div class="tbl_stl_3" data-table>
            {$tbl_menu_restaurants}
        </div>
    </section>
    <section class="buttons">
        <div>
            <a data-button-modal="search"><i class="fas fa-search"></i></a>
            <?php if (Functions::check_user_access(['{menu_products_create}','{menu_products_update}','{menu_products_deactivate}','{menu_products_activate}','{menu_products_delete}']) == true) : ?>
            <a href="/menu/products" class="big"><i class="fas fa-cocktail"></i><span>{$lang.products}</span></a>
            <?php endif; ?>
            <?php if (Functions::check_user_access(['{menu_restaurants_create}','{menu_restaurants_update}','{menu_restaurants_deactivate}','{menu_restaurants_activate}','{menu_restaurants_delete}']) == true) : ?>
            <a href="/menu/restaurants" class="big new"><i class="fas fa-utensils"></i><span>{$lang.restaurants}</span></a>
            <?php endif; ?>
            <?php if (Functions::check_user_access(['{menu_restaurants_create}']) == true) : ?>
            <a class="new" data-button-modal="new_menu_restaurant"><i class="fas fa-plus"></i></a>
            <?php endif; ?>
        </div>
    </section>
</main>
<?php if (Functions::check_user_access(['{menu_restaurants_create}','{menu_restaurants_update}']) == true) : ?>
<section class="modal fullscreen" data-modal="new_menu_restaurant">
    <div class="content">
        <main>
            <form name="new_menu_restaurant">
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
<?php if (Functions::check_user_access(['{menu_restaurants_deactivate}']) == true) : ?>
<section class="modal edit" data-modal="deactivate_menu_restaurant">
    <div class="content">
        <footer>
            <a button-close><i class="fas fa-times"></i></a>
            <a button-success><i class="fas fa-check"></i></a>
        </footer>
    </div>
</section>
<?php endif; ?>
<?php if (Functions::check_user_access(['{menu_restaurants_activate}']) == true) : ?>
<section class="modal edit" data-modal="activate_menu_restaurant">
    <div class="content">
        <footer>
            <a button-close><i class="fas fa-times"></i></a>
            <a button-success><i class="fas fa-check"></i></a>
        </footer>
    </div>
</section>
<?php endif; ?>
<?php if (Functions::check_user_access(['{menu_restaurants_delete}']) == true) : ?>
<section class="modal delete" data-modal="delete_menu_restaurant">
    <div class="content">
        <footer>
            <a button-close><i class="fas fa-times"></i></a>
            <a button-success><i class="fas fa-check"></i></a>
        </footer>
    </div>
</section>
<?php endif; ?>
