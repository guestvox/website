<?php

defined('_EXEC') or die;

$this->dependencies->add(['js', '{$path.js}Menu/products.js']);
$this->dependencies->add(['js', '{$path.plugins}push/push.min.js']);
$this->dependencies->add(['other', '<script>menu_focus("menu");</script>']);
$this->dependencies->add(['other', '<script src="https://js.pusher.com/7.0/pusher.min.js"></script>']);

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
            <a href="/menu/products" class="big new"><i class="fas fa-cocktail"></i><span>{$lang.products}</span></a>
            <?php endif; ?>
            <?php if (Functions::check_user_access(['{menu_products_create}']) == true) : ?>
            <a class="new" data-button-modal="new_menu_product"><i class="fas fa-plus"></i></a>
            <?php endif; ?>
            <!-- <?php if (Functions::check_user_access(['{menu_restaurants_create}','{menu_restaurants_update}','{menu_restaurants_deactivate}','{menu_restaurants_activate}','{menu_restaurants_delete}']) == true) : ?>
            <a href="/menu/restaurants" class="big"><i class="fas fa-utensils"></i><span>{$lang.restaurants}</span></a>
            <?php endif; ?> -->
            <?php if (Functions::check_user_access(['{menu_categories_create}','{menu_categories_update}','{menu_categories_deactivate}','{menu_categories_activate}','{menu_categories_delete}']) == true) : ?>
            <a href="/menu/categories" class="big"><i class="fas fa-tag"></i><span>{$lang.categories}</span></a>
            <?php endif; ?>
            <?php if (Functions::check_user_access(['{menu_topics_create}','{menu_topics_update}','{menu_topics_deactivate}','{menu_topics_activate}','{menu_topics_delete}']) == true) : ?>
            <a href="/menu/topics" class="big"><i class="fas fa-bookmark"></i><span>{$lang.topics}</span></a>
            <?php endif; ?>
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
                            <label unrequired>
                                <p>(ES) {$lang.description}</p>
                                <textarea name="description_es"></textarea>
                            </label>
                        </div>
                    </div>
                    <div class="span6">
                        <div class="label">
                            <label unrequired>
                                <p>(EN) {$lang.description}</p>
                                <textarea name="description_en"></textarea>
                            </label>
                        </div>
                    </div>
                    <div class="span6">
                        <div class="label">
                            <label unrequired>
                                <p>{$lang.outstanding}</p>
                                <input type="number" name="outstanding">
                            </label>
                        </div>
                    </div>
                    <div class="span6">
                        <div class="label">
                            <label required>
                                <p>(<?php echo !empty(Session::get_value('account')['settings']['menu']['currency']) ? Session::get_value('account')['settings']['menu']['currency'] : Session::get_value('account')['currency'] ?>) {$lang.price}</p>
                                <input type="text" name="price">
                            </label>
                        </div>
                    </div>
                    <div class="span12">
                        <div class="menu_topics_groups">
                            <aside>
                                {$cbx_menu_topics_groups}
                            </aside>
                            <div class="checkboxes stl_1">
                                {$cbx_menu_topics}
                            </div>
                            <div class="label">
                                <label required>
                                    <select name="selection">
                                        <option value="" hidden>{$lang.selection_type}</option>
                                        <option value="checkbox">{$lang.multi_selection}</option>
                                        <option value="radio">{$lang.one_selection}</option>
                                    </select>
                                </label>
                            </div>
                            <a data-action="add_menu_topics_group">{$lang.add_menu_topics_group}</a>
                        </div>
                    </div>
                    <div class="span12">
                        <div class="label">
                            <label unrequired>
                                <p>{$lang.avatar}</p>
                                <select name="avatar">
                                    <option value="image">{$lang.image}</option>
                                    <option value="icon">{$lang.icon}</option>
                                </select>
                            </label>
                        </div>
                    </div>
                    <div class="span12">
                        <div class="stl_2" data-uploader="low">
                            <p>{$lang.image}</p>
                            <figure data-preview>
                                <img src="{$path.images}empty.png">
                                <a data-select><i class="fas fa-upload"></i></a>
                                <input type="file" name="image" accept="image/*" data-upload>
                            </figure>
                        </div>
                    </div>
                    <div class="span12 hidden">
                        <div class="checkboxes stl_4">
                            {$cbx_icons}
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
                            <label unrequired>
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
