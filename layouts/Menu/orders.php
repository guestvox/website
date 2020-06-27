<?php

defined('_EXEC') or die;

$this->dependencies->add(['js', '{$path.js}Menu/orders.js']);
$this->dependencies->add(['other', '<script>menu_focus("menu");</script>']);

?>

%{header}%
<main class="dashboard">
    <section class="workspace">
        <div class="tbl_stl_2" data-table>
            {$tbl_menu_orders}
        </div>
    </section>
    <section class="buttons">
        <div>
            <a data-button-modal="search"><i class="fas fa-search"></i></a>
            <?php if (Functions::check_user_access(['{menu_products_create}','{menu_products_update}','{menu_products_deactivate}','{menu_products_activate}','{menu_products_delete}']) == true) : ?>
            <a href="/menu/products"><i class="fas fa-cocktail"></i></a>
            <?php endif; ?>
            <?php if (Functions::check_user_access(['{menu_orders_view}']) == true) : ?>
            <a href="/menu/orders" class="active"><i class="fas fa-receipt"></i></a>
            <?php endif; ?>
            <?php if (Functions::check_user_access(['{menu_restaurants_create}','{menu_restaurants_update}','{menu_restaurants_deactivate}','{menu_restaurants_activate}','{menu_restaurants_delete}']) == true) : ?>
            <a href="/menu/restaurants"><i class="fas fa-utensils"></i></a>
            <?php endif; ?>
        </div>
    </section>
</main>
