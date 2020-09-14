<?php

defined('_EXEC') or die;

$this->dependencies->add(['css', '{$path.plugins}chosen_select/chosen.css']);
$this->dependencies->add(['js', '{$path.plugins}chosen_select/chosen.jquery.js']);
$this->dependencies->add(['js', '{$path.js}Menu/products.js']);
$this->dependencies->add(['other', '<script>menu_focus("menu_products");</script>']);

?>

%{header}%
<main class="dashboard">
    <section class="workspace">
        {$tbl_menu_products}
    </section>
    {$sct_buttons}
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
                    <div class="span6">
                        <div class="label">
                            <label unrequired>
                                <p>(ES) {$lang.description}</p>
                                <textarea name="description_es" data-translates="description"></textarea>
                            </label>
                        </div>
                    </div>
                    <div class="span6">
                        <div class="label">
                            <label unrequired>
                                <p>(EN) {$lang.description}</p>
                                <textarea name="description_en" data-translaten="description"></textarea>
                            </label>
                        </div>
                    </div>
                    <div class="span3">
                        <div class="label">
                            <label required>
                                <p>{$lang.position} <a data-action="get_help" data-text=""><i class="fas fa-question-circle"></i></a></p>
                                <input type="number" name="position">
                            </label>
                        </div>
                    </div>
                    <div class="span3">
                        <div class="label">
                            <label required>
                                <p>(<?php echo !empty(Session::get_value('account')['settings']['menu']['currency']) ? Session::get_value('account')['settings']['menu']['currency'] : Session::get_value('account')['currency'] ?>) {$lang.price}</p>
                                <input type="text" name="price">
                            </label>
                        </div>
                    </div>
                    <div class="span6">
                        <div class="label">
                            <label unrequired>
                                <p>{$lang.available_only_days} <a data-action="get_help" data-text=""><i class="fas fa-question-circle"></i></a></p>
                                <select name="available[]" class="chosen-select" multiple>
                                    <option value="sunday">{$lang.sunday}</option>
                                    <option value="monday">{$lang.monday}</option>
                                    <option value="tuesday">{$lang.tuesday}</option>
                                    <option value="wednesday">{$lang.wednesday}</option>
                                    <option value="thursday">{$lang.thursday}</option>
                                    <option value="friday">{$lang.friday}</option>
                                    <option value="saturday">{$lang.saturday}</option>
                                </select>
                            </label>
                        </div>
                    </div>
                    <div class="span12">
                        <div class="menu_topics_groups">
                            {$cbx_menu_topics}
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
                            <div class="button">
                                <a href="/menu/categories">{$lang.create_more_categories}</a>
                            </div>
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
