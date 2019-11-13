<?php

defined('_EXEC') or die;

$this->dependencies->add(['css', '{$path.plugins}data-tables/jquery.dataTables.min.css']);
$this->dependencies->add(['js', '{$path.plugins}data-tables/jquery.dataTables.min.js']);
$this->dependencies->add(['js', '{$path.js}Users/deactivates.js']);
$this->dependencies->add(['other', '<script>menu_focus("users");</script>']);

?>

%{header}%
<main>
    <div class="multi-tabs" data-tab-active="tab2">
        <ul>
            <?php if (Functions::check_access(['{users_create}','{users_update}','{users_restorepassword}','{users_deactivate}','{users_delete}']) == true) : ?>
            <li data-tab-target="tab1" class="active">{$lang.activates}</li>
            <?php endif; ?>
            <?php if (Functions::check_access(['{users_activate}']) == true) : ?>
            <li data-tab-target="tab2">{$lang.deactivates}</li>
            <?php endif; ?>
            <?php if (Functions::check_access(['{userlevels_create}','{userlevels_update}','{userlevels_delete}']) == true) : ?>
            <li data-tab-target="tab3">{$lang.user_permissions}</li>
            <?php endif; ?>
        </ul>
        <?php if (Functions::check_access(['{users_activate}']) == true) : ?>
        <div class="tab" data-target="tab2">
            <section class="box-container complete">
                <div class="main">
                    <article>
                        <main class="tables">
                            <div class="table-container">
                                <table id="users_deactivate" class="table">
                                    <thead>
                                        <tr>
                                            <th align="left">{$lang.firstname}</th>
                                            <th align="left">{$lang.email}</th>
                                            <th align="left">{$lang.cellphone}</th>
                                            <th align="left">{$lang.username}</th>
                                            <th align="left">{$lang.password_default}</th>
                                            <th align="left">{$lang.user_level}</th>
                                            <th align="right" class="icon"></th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        {$tbl_users_deactivate}
                                    </tbody>
                                </table>
                            </div>
                        </main>
                    </article>
                </div>
            </section>
        </div>
        <?php endif; ?>
    </div>
</main>
<?php if (Functions::check_access(['{users_activate}']) == true) : ?>
<section class="modal" data-modal="activate_user">
    <div class="content">
        <header>
            <h3>{$lang.activate}</h3>
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
