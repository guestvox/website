<?php

defined('_EXEC') or die;

$this->dependencies->add(['css', '{$path.plugins}chosen_select/chosen.css']);
$this->dependencies->add(['js', '{$path.plugins}chosen_select/chosen.jquery.js']);
$this->dependencies->add(['js', '{$path.js}Master/index.js']);
$this->dependencies->add(['other', '<script>menu_focus("index");</script>']);

?>

%{header}%
<main class="dashboard">
    <section class="workspace">
        <div class="tbl_stl_3" data-table>
            {$tbl_accounts}
        </div>
    </section>
</main>
<section class="modal edit" data-modal="change_account">
    <div class="content">
        <footer>
            <a button-close><i class="fas fa-times"></i></a>
            <a button-success><i class="fas fa-check"></i></a>
        </footer>
    </div>
</section>
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
<section class="modal fullscreen" data-modal="filter_categories">
    <div class="content">
        <main>
            <form name="filter_categories">
                <div class="row">
                    <div class="span12">
                        <div class="label">
                            <label required>
                                <p>{$lang.categories}</p>
                                <select name="search_categories">
                                    <option value="all"<?php echo ((Session::get_value('settings')['menu']['categories']['filter']['id'] == 'all') ? 'selected' : '')?>>{$lang.all}</option>
                                    {$opt_categories}
                                </select>
                            </label>
                        </div>
                    </div>
                    <div class="span12">
                        <div class="buttons">
                            <a class="delete" button-close><i class="fas fa-times"></i></a>
                            <button type="submit" class="new"><i class="fas fa-check"></i></button>
                        </div>
                    </div>
                </div>
            </form>
        </main>
    </div>
</section>
