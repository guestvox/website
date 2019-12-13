<?php

defined('_EXEC') or die;

$this->dependencies->add(['css', '{$path.plugins}data-tables/jquery.dataTables.min.css']);
$this->dependencies->add(['js', '{$path.plugins}data-tables/jquery.dataTables.min.js']);
$this->dependencies->add(['js', '{$path.js}Tables/index.js']);
$this->dependencies->add(['other', '<script>menu_focus("other");</script>']);

?>

%{header}%
<main>
    <article>
        <header>
            <h2><i class="fas fa-bed"></i>{$lang.tables}</h2>
        </header>
        <main>
            <div class="table">
                <aside>
                    <label>
                        <span><i class="fas fa-search"></i></span>
                        <input type="text" name="tbl_tables_search">
                    </label>
                    <?php if (Functions::check_user_access(['{tables_create}']) == true) : ?>
                    <a data-button-modal="new_table" class="new"><i class="fas fa-plus"></i></a>
                    <?php endif; ?>
                </aside>
                <table id="tbl_tables">
                    <thead>
                        <tr>
                            <th align="left" width="100px">{$lang.token}</th>
                            <th align="left" width="100px">{$lang.number}</th>
                            <th align="left">{$lang.name}</th>
                            <th align="right" class="icon"></th>
                            <?php if (Functions::check_user_access(['{tables_delete}']) == true) : ?>
                            <th align="right" class="icon"></th>
                            <?php endif; ?>
                            <?php if (Functions::check_user_access(['{tables_update}']) == true) : ?>
                            <th align="right" class="icon"></th>
                            <?php endif; ?>
                        </tr>
                    </thead>
                    <tbody>
                        {$tbl_tables}
                    </tbody>
                </table>
            </div>
        </main>
    </article>
</main>
{$mdl_new_table}
<?php if (Functions::check_user_access(['{tables_update}']) == true) : ?>
<section class="modal edit" data-modal="edit_table">
    <div class="content">
        <header>
            <h3>{$lang.edit}</h3>
        </header>
        <main>
            <form name="edit_table">
                <div class="row">
                    <div class="span12">
                        <div class="label">
                            <label>
                                <p>{$lang.number}</p>
                                <input type="number" name="number" />
                            </label>
                        </div>
                    </div>
                    <div class="span12">
                        <div class="label">
                            <label>
                                <p>{$lang.name}</p>
                                <input type="text" name="name" />
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
<?php if (Functions::check_user_access(['{tables_delete}']) == true) : ?>
<section class="modal delete" data-modal="delete_table">
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
</section>
<?php endif; ?>
