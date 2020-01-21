<?php

defined('_EXEC') or die;

$this->dependencies->add(['css', '{$path.plugins}data-tables/jquery.dataTables.min.css']);
$this->dependencies->add(['js', '{$path.plugins}data-tables/jquery.dataTables.min.js']);
$this->dependencies->add(['js', '{$path.js}Users/index.js']);
$this->dependencies->add(['other', '<script>menu_focus("other");</script>']);

?>

%{header}%
<main>
    <nav>
        <h2><i class="fas fa-users"></i>{$lang.users}</h2>
    </nav>
    <article>
        <main>
            <div class="table">
                <aside>
                    <label>
                        <span><i class="fas fa-search"></i></span>
                        <input type="text" name="tbl_users_search">
                    </label>
                    <?php if (Functions::check_user_access(['{users_create}']) == true) : ?>
                    <a data-button-modal="new_user" class="new"><i class="fas fa-plus"></i></a>
                    <?php endif; ?>
                </aside>
                <table id="tbl_users">
                    <thead>
                        <tr>
                            <th align="left" width="40px"></th>
                            <th align="left">{$lang.name}</th>
                            <th align="left">{$lang.email}</th>
                            <th align="left">{$lang.phone}</th>
                            <th align="left">{$lang.username}</th>
                            <th align="left">{$lang.user_permissions}</th>
                            <th align="left" width="100px">{$lang.status}</th>
                            <?php if (Functions::check_user_access(['{users_delete}']) == true) : ?>
                            <th align="right" class="icon"></th>
                            <?php endif; ?>
                            <?php if (Functions::check_user_access(['{users_deactivate}','{users_activate}']) == true) : ?>
                            <th align="right" class="icon"></th>
                            <?php endif; ?>
                            <?php if (Functions::check_user_access(['{users_restore_password}']) == true) : ?>
                            <th align="right" class="icon"></th>
                            <?php endif; ?>
                            <?php if (Functions::check_user_access(['{users_update}']) == true) : ?>
                            <th align="right" class="icon"></th>
                            <?php endif; ?>
                        </tr>
                    </thead>
                    <tbody>
                        {$tbl_users}
                    </tbody>
                </table>
            </div>
        </main>
    </article>
</main>
<?php if (Functions::check_user_access(['{users_create}','{users_update}']) == true) : ?>
<section class="modal new" data-modal="new_user">
    <div class="content">
        <header>
            <h3>{$lang.new}</h3>
        </header>
        <main>
            <form name="new_user">
                <div class="row">
                    <div class="span6">
                        <div class="label">
                            <label>
                                <p>{$lang.firstname}</p>
                                <input type="text" name="firstname" />
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
                    <div class="span6">
                        <div class="label">
                            <label>
                                <p>{$lang.email}</p>
                                <input type="email" name="email" />
                            </label>
                        </div>
                    </div>
                    <div class="span3">
                        <div class="label">
                            <label>
                                <p>{$lang.lada}</p>
                                <select name="phone_lada">
                                    <option value="" selected hidden>{$lang.choose}</option>
                                    {$opt_ladas}
                                </select>
                            </label>
                        </div>
                    </div>
                    <div class="span3">
                        <div class="label">
                            <label>
                                <p>{$lang.phone}</p>
                                <input type="text" name="phone_number" />
                            </label>
                        </div>
                    </div>
                    <div class="span6">
                        <div class="label">
                            <label>
                                <p>{$lang.username}</p>
                                <input type="text" name="username" />
                            </label>
                        </div>
                    </div>
                    <div class="span6">
                        <div class="label">
                            <label>
                                <p>{$lang.password}</p>
                                <input type="text" name="password" />
                                <a data-action="get_password_user">{$lang.generate}</a>
                            </label>
                        </div>
                    </div>
                    <div class="span12">
                        <div class="label">
                            <label>
                                <p>{$lang.user_permissions}</p>
                                <select name="user_level">
                                    <option value="" selected hidden>{$lang.choose}</option>
                                    <option value="empty">{$lang.not_user_level}</option>
                                    {$opt_user_levels}
                                </select>
                            </label>
                            <div class="checkboxes">
                                {$cbx_user_permissions}
                            </div>
                        </div>
                    </div>
                    <div class="span12">
                        <div class="label">
                            <label>
                                <p>{$lang.opportunity_areas}</p>
                            </label>
                            <div class="checkboxes">
                                {$cbx_opportunity_areas}
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
<?php if (Functions::check_user_access(['{users_restore_password}']) == true) : ?>
<section class="modal" data-modal="restore_password_user">
    <div class="content">
        <header>
            <h3>{$lang.restore_password}</h3>
        </header>
        <main>
            <form name="restore_password_user">
                <div class="row">
                    <div class="span12">
                        <div class="label">
                            <label>
                                <p>{$lang.password}</p>
                                <input type="text" name="password" />
                                <a data-action="get_password_user">{$lang.generate}</a>
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
<?php if (Functions::check_user_access(['{users_deactivate}']) == true) : ?>
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
<?php if (Functions::check_user_access(['{users_activate}']) == true) : ?>
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
<?php if (Functions::check_user_access(['{users_delete}']) == true) : ?>
<section class="modal delete" data-modal="delete_user">
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
