<?php

defined('_EXEC') or die;

$this->dependencies->add(['js', '{$path.js}Users/index.js']);
$this->dependencies->add(['other', '<script>menu_focus("users");</script>']);

?>

%{header}%
<main class="dashboard">
    <section class="workspace">
        <div class="tbl_stl_3">
            {$tbl_users}
        </div>
    </section>
    <section class="buttons">
        <div>
            <a data-button-modal="search"><i class="fas fa-search"></i></a>
            <?php if (Functions::check_user_access(['{users_create}']) == true) : ?>
            <a class="active" data-button-modal="new_user"><i class="fas fa-plus"></i></a>
            <?php endif; ?>
        </div>
    </section>
</main>
<?php if (Functions::check_user_access(['{users_create}','{users_update}']) == true) : ?>
<section class="modal fullscreen" data-modal="new_user">
    <div class="content">
        <main>
            <form name="new_user">
                <div class="row">
                    <div class="span6">
                        <div class="label">
                            <label required>
                                <p>{$lang.firstname}</p>
                                <input type="text" name="firstname">
                            </label>
                        </div>
                    </div>
                    <div class="span6">
                        <div class="label">
                            <label required>
                                <p>{$lang.lastname}</p>
                                <input type="text" name="lastname">
                            </label>
                        </div>
                    </div>
                    <div class="span6">
                        <div class="label">
                            <label required>
                                <p>{$lang.email}</p>
                                <input type="text" name="email">
                            </label>
                        </div>
                    </div>
                    <div class="span3">
                        <div class="label">
                            <label required>
                                <p>{$lang.lada}</p>
                                <select name="phone_lada">
                                    <option value="" hidden>{$lang.choose}</option>
                                    {$opt_ladas}
                                </select>
                            </label>
                        </div>
                    </div>
                    <div class="span3">
                        <div class="label">
                            <label required>
                                <p>{$lang.phone}</p>
                                <input type="text" name="phone_number">
                            </label>
                        </div>
                    </div>
                    <div class="span8">
                        <div class="label">
                            <label required>
                                <p>{$lang.username}</p>
                                <input type="text" name="username">
                            </label>
                        </div>
                    </div>
                    <div class="span4">
                        <div class="label">
                            <label unrequired>
                                <p>{$lang.user_level}</p>
                                <select name="user_level">
                                    <option value="">{$lang.empty} ({$lang.choose})</option>
                                    {$opt_users_levels}
                                </select>
                            </label>
                        </div>
                    </div>
                    <div class="span12">
                        <div class="checkboxes stl_2">
                            {$cbx_permissions}
                        </div>
                    </div>
                    <div class="span12">
                        <div class="checkboxes stl_1">
                            <p>{$lang.opportunity_areas}</p>
                            {$cbx_opportunity_areas}
                        </div>
                    </div>
                    <div class="span12">
                        <div class="buttons">
                            <a button-cancel><i class="fas fa-times"></i></a>
                            <button type="submit"><i class="fas fa-check"></i></button>
                        </div>
                    </div>
                </div>
            </form>
        </main>
    </div>
</section>
<?php endif; ?>
<?php if (Functions::check_user_access(['{users_restore_password}']) == true) : ?>
    <section class="modal edit" data-modal="restore_password_user">
        <div class="content">
            <footer>
                <a button-close><i class="fas fa-times"></i></a>
                <a button-success><i class="fas fa-check"></i></a>
            </footer>
        </div>
    </section>
<?php endif; ?>
<?php if (Functions::check_user_access(['{users_deactivate}']) == true) : ?>
<section class="modal edit" data-modal="deactivate_user">
    <div class="content">
        <footer>
            <a button-close><i class="fas fa-times"></i></a>
            <a button-success><i class="fas fa-check"></i></a>
        </footer>
    </div>
</section>
<?php endif; ?>
<?php if (Functions::check_user_access(['{users_activate}']) == true) : ?>
<section class="modal edit" data-modal="activate_user">
    <div class="content">
        <footer>
            <a button-close><i class="fas fa-times"></i></a>
            <a button-success><i class="fas fa-check"></i></a>
        </footer>
    </div>
</section>
<?php endif; ?>
<?php if (Functions::check_user_access(['{users_delete}']) == true) : ?>
<section class="modal delete" data-modal="delete_user">
    <div class="content">
        <footer>
            <a button-close><i class="fas fa-times"></i></a>
            <a button-success><i class="fas fa-check"></i></a>
        </footer>
    </div>
</section>
<?php endif; ?>
