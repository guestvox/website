<?php

defined('_EXEC') or die;

$this->dependencies->add(['css', '{$path.plugins}data-tables/jquery.dataTables.min.css']);
$this->dependencies->add(['js', '{$path.plugins}data-tables/jquery.dataTables.min.js']);
$this->dependencies->add(['js', '{$path.js}Users/index.js']);
$this->dependencies->add(['other', '<script>menu_focus("users");</script>']);

?>

%{header}%
<main>
    <div class="multi-tabs" data-tab-active="tab1">
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
        <?php if (Functions::check_access(['{users_create}','{users_update}','{users_restorepassword}','{users_deactivate}','{users_delete}']) == true) : ?>
        <div class="tab" data-target="tab1">
            <section class="box-container complete">
                <div class="main">
                    <article>
                        <main class="tables">
                            <div class="table-container">
                                <table id="users_activate" class="table">
                                    <thead>
                                        <tr>
                                            <th align="left">{$lang.firstname}</th>
                                            <th align="left">{$lang.email}</th>
                                            <th align="left">{$lang.cellphone}</th>
                                            <th align="left">{$lang.username}</th>
                                            <th align="left">{$lang.password_default}</th>
                                            <th align="left">{$lang.user_level}</th>
                                            <?php if (Functions::check_access(['{users_restorepassword}']) == true) : ?>
                                            <th align="right" class="icon"></th>
                                            <?php endif; ?>
                                            <?php if (Functions::check_access(['{users_delete}']) == true) : ?>
                                            <th align="right" class="icon"></th>
                                            <?php endif; ?>
                                            <?php if (Functions::check_access(['{users_deactivate}']) == true) : ?>
                                            <th align="right" class="icon"></th>
                                            <?php endif; ?>
                                            <?php if (Functions::check_access(['{users_update}']) == true) : ?>
                                            <th align="right" class="icon"></th>
                                            <?php endif; ?>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        {$tbl_users_activate}
                                    </tbody>
                                </table>
                            </div>
                        </main>
                    </article>
                    <?php if (Functions::check_access(['{users_create}']) == true) : ?>
                    <article>
                        <main class="tables">
                            <form name="new_user">
                                <div class="row">
                                    <div class="span2">
                                        <div class="label">
                                            <label>
                                                <p>{$lang.firstname}</p>
                                                <input type="text" name="name" />
                                            </label>
                                        </div>
                                    </div>
                                    <div class="span2">
                                        <div class="label">
                                            <label>
                                                <p>{$lang.lastname}</p>
                                                <input type="text" name="lastname" />
                                            </label>
                                        </div>
                                    </div>
                                    <div class="span2">
                                        <div class="label">
                                            <label>
                                                <p>{$lang.email}</p>
                                                <input type="email" name="email" />
                                            </label>
                                        </div>
                                    </div>
                                    <div class="span2">
                                        <div class="label">
                                            <label>
                                                <p>{$lang.cellphone}</p>
                                                <input type="text" name="cellphone" />
                                            </label>
                                        </div>
                                    </div>
                                    <div class="span2">
                                        <div class="label">
                                            <label>
                                                <p>{$lang.username}</p>
                                                <input type="text" name="username" />
                                            </label>
                                        </div>
                                    </div>
                                    <div class="span2">
                                        <div class="label">
                                            <label>
                                                <p>{$lang.user_level}</p>
                                                <select name="user_level">
                                                    <option value="" selected hidden>{$lang.choose}</option>
                                                    {$opt_user_levels}
                                                </select>
                                            </label>
                                        </div>
                                    </div>
                                    <div class="span12">
                                        <div class="label">
                                            <div>
                                                <p>{$lang.user_permissions}</p>
                                                <div class="checkboxes">
                                                    {$cbx_user_permissions}
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="span12">
                                        <div class="label">
                                            <div>
                                                <p>{$lang.opportunity_areas}</p>
                                                <div class="checkboxes">
                                                    {$cbx_opportunity_areas}
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </main>
                        <footer>
                            <div class="buttons text-center">
                                <a class="btn" data-action="new_user">{$lang.add}</a>
                            </div>
                        </footer>
                    </article>
                    <?php endif; ?>
                </div>
            </section>
        </div>
        <?php endif; ?>
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
        <?php if (Functions::check_access(['{userlevels_create}','{userlevels_update}','{userlevels_delete}']) == true) : ?>
        <div class="tab" data-target="tab3">
            <section class="box-container complete">
                <div class="main">
                    <article>
                        <main class="tables">
                            <div class="table-container">
                                <table id="users_levels" class="table">
                                    <thead>
                                        <tr>
                                            <th align="left">{$lang.firstname}</th>
                                            <?php if (Functions::check_access(['{userlevels_delete}']) == true) : ?>
                                            <th align="right" class="icon"></th>
                                            <?php endif; ?>
                                            <?php if (Functions::check_access(['{userlevels_update}']) == true) : ?>
                                            <th align="right" class="icon"></th>
                                            <?php endif; ?>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        {$tbl_user_levels}
                                    </tbody>
                                </table>
                            </div>
                        </main>
                    </article>
                    <?php if (Functions::check_access(['{userlevels_create}']) == true) : ?>
                    <article>
                        <main class="tables">
                            <form name="new_user_level" class="row">
                                <div class="span12">
                                    <div class="label">
                                        <label>
                                            <p>{$lang.firstname}</p>
                                            <input type="text" name="name" />
                                        </label>
                                    </div>
                                </div>
                                <div class="span12">
                                    <div class="label">
                                        <div>
                                            <p>{$lang.user_permissions}</p>
                                            <div class="checkboxes">
                                                {$cbx_user_permissions}
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </main>
                        <footer>
                            <div class="buttons text-center">
                                <a class="btn" data-action="new_user_level">{$lang.add}</a>
                            </div>
                        </footer>
                    </article>
                    <?php endif; ?>
                </div>
            </section>
        </div>
        <?php endif; ?>
    </div>
</main>
<?php if (Functions::check_access(['{users_update}']) == true) : ?>
<section class="modal" data-modal="edit_user">
    <div class="content">
        <header>
            <h3>{$lang.edit}</h3>
        </header>
        <main>
            <form name="edit_user">
                <div class="row">
                    <div class="span6">
                        <div class="label">
                            <label>
                                <p>{$lang.firstname}</p>
                                <input type="text" name="name" />
                            </label>
                        </div>
                    </div>
                    <div class="span6">
                        <div class="label">
                            <label>
                                <p>{$lang.lastname}</p>
                                <input type="text" name="lastname" />
                            </label>
                        </div>
                    </div>
                    <div class="span12">
                        <div class="label">
                            <label>
                                <p>{$lang.email}</p>
                                <input type="email" name="email" />
                            </label>
                        </div>
                    </div>
                    <div class="span12">
                        <div class="label">
                            <label>
                                <p>{$lang.cellphone}</p>
                                <input type="text" name="cellphone" />
                            </label>
                        </div>
                    </div>
                    <div class="span12">
                        <div class="label">
                            <label>
                                <p>{$lang.username}</p>
                                <input type="text" name="username" />
                            </label>
                        </div>
                    </div>
                    <div class="span12">
                        <div class="label">
                            <label>
                                <p>{$lang.user_level}</p>
                                <select name="user_level">
                                    <option value="" selected hidden>{$lang.choose}</option>
                                    {$opt_user_levels}
                                </select>
                            </label>
                        </div>
                    </div>
                    <div class="span12">
                        <div class="label">
                            <div>
                                <p>{$lang.user_permissions}</p>
                                <div class="checkboxes">
                                    {$cbx_user_permissions}
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="span12">
                        <div class="label">
                            <div>
                                <p>{$lang.opportunity_areas}</p>
                                <div class="checkboxes">
                                    {$cbx_opportunity_areas}
                                </div>
                            </div>
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
<?php if (Functions::check_access(['{users_restorepassword}']) == true) : ?>
<section class="modal" data-modal="restore_password_user">
    <div class="content">
        <header>
            <h3>{$lang.restore_password}</h3>
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
<?php if (Functions::check_access(['{users_deactivate}']) == true) : ?>
<section class="modal" data-modal="deactivate_user">
    <div class="content">
        <header>
            <h3>{$lang.deactivate}</h3>
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
<?php if (Functions::check_access(['{users_delete}']) == true) : ?>
<section class="modal" data-modal="delete_user">
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
<?php if (Functions::check_access(['{userlevels_update}']) == true) : ?>
<section class="modal" data-modal="edit_user_level">
    <div class="content">
        <header>
            <h3>{$lang.edit}</h3>
        </header>
        <main>
            <form name="edit_user_level">
                <div class="row">
                    <div class="span12">
                        <div class="label">
                            <label>
                                <p>{$lang.firstname}</p>
                                <input type="text" name="name" />
                            </label>
                        </div>
                    </div>
                    <div class="span12">
                        <div class="label">
                            <div>
                                <p>{$lang.user_permissions}</p>
                                <div class="checkboxes">
                                    {$cbx_user_permissions}
                                </div>
                            </div>
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
<?php if (Functions::check_access(['{userlevels_delete}']) == true) : ?>
<section class="modal" data-modal="delete_user_level">
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
