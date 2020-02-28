<?php

defined('_EXEC') or die;

$this->dependencies->add(['css', '{$path.plugins}data-tables/jquery.dataTables.min.css']);
$this->dependencies->add(['js', '{$path.plugins}data-tables/jquery.dataTables.min.js']);
$this->dependencies->add(['js', '{$path.js}Menus/index.js']);

?>

%{header}%
<main>
    <nav>
        <h2><i class="fas fa-compass"></i>{$lang.menus}</h2>
    </nav>
    <article>
        <main>
            <div class="table">
                <aside>
                    <label>
                        <span><i class="fas fa-search"></i></span>
                        <input type="text" name="tbl_menus_search">
                    </label>
                    <?php if (Functions::check_user_access(['{menus_create}']) == true) : ?>
                    <a data-button-modal="new_menu" class="new"><i class="fas fa-plus"></i></a>
                    <?php endif; ?>
                </aside>
                <!-- <table id="tbl_menus">
                    <thead>
                        <tr>

                        </tr>
                    </thead>
                    <tbody>
                        {$tbl_menus}
                    </tbody>
                </table> -->
            </div>
        </main>
    </article>
</main>
<?php if (Functions::check_user_access(['{menus_create}','{menus_update}']) == true) : ?>
<section class="modal new" data-modal="new_menu">
    <div class="content">
        <header>
            <h3>{$lang.new}</h3>
        </header>
        <main>
            <form name="new_menu">
                <div class="row">
                    <div class="span6">
                        <div class="label">
                            <label>
                                <p>(ES) {$lang.name}</p>
                                <input type="text" name="name_es" />
                            </label>
                        </div>
                    </div>
                    <div class="span6">
                        <div class="label">
                            <label>
                                <p>(EN) {$lang.name}</p>
                                <input type="text" name="name_en" />
                            </label>
                        </div>
                    </div>
                    <div class="span8">
                        <div class="label">
                            <label>
                                <p>{$lang.price}</p>
                                <input type="number" name="price" />
                            </label>
                        </div>
                    </div>
                    <div class="span4">
                        <div class="label">
                            <label>
                                <p>{$lang.currency}</p>
                                <select name="currency">
                                    <option value="" selected hidden>{$lang.choose}</option>
                                    <option value="MXN">MXN</option>
                                    <option value="USD">USD</option>
                                </select>
                            </label>
                        </div>
                    </div>
                    <div class="span6">
                        <div class="label">
                            <label>
                                <p>(ES) {$lang.description}</p>
                                <textarea name="description_es"></textarea>
                            </label>
                        </div>
                    </div>
                    <div class="span6">
                        <div class="label">
                            <label>
                                <p>(EN) {$lang.description}</p>
                                <textarea name="description_en"></textarea>
                            </label>
                        </div>
                    </div>
                </div>
            </form>
        </main>
        <footer>
            <div class="action-buttons">
                <button class="btn btn-flat" button-cancel>{$lang.cancel}</button>
                <button class="btn" button-success>{$lang.accept}</button>
            </div>
        </footer>
    </div>
</section>
<?php endif; ?>
<?php if (Functions::check_user_access(['{menus_delete}']) == true) : ?>
<!-- <section class="modal delete" data-modal="delete_menu">
    <div class="content">
        <header>
            <h3>{$lang.delete}</h3>
        </header>
        <footer>
            <div class="action-buttons">
                <button class="btn btn-flat" button-close>{$lang.cancel}</button>
                <button class="btn" button-success>{$lang.accept}</button>
            </div>
        </footer>
    </div>
</section> -->
<?php endif; ?>
