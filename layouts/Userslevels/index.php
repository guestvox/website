<?php

defined('_EXEC') or die;

$this->dependencies->add(['js', '{$path.js}Userslevels/index.js']);
$this->dependencies->add(['other', '<script>menu_focus("users_levels");</script>']);

?>

%{header}%
<main class="dashboard">
    <section class="workspace">
        <div class="tbl_stl_2" data-table>
            {$tbl_users_levels}
        </div>
    </section>
    <section class="buttons">
        <div>
            <a data-button-modal="search"><i class="fas fa-search"></i></a>
            <?php if (Functions::check_user_access(['{users_levels_create}']) == true) : ?>
            <a class="active" data-button-modal="new_user_level"><i class="fas fa-plus"></i></a>
            <?php endif; ?>
        </div>
    </section>
</main>
<?php if (Functions::check_user_access(['{users_levels_create}','{users_levels_update}']) == true) : ?>
<section class="modal fullscreen" data-modal="new_user_level">
    <div class="content">
        <main>
            <form name="new_user_level">
                <div class="row">
                    <div class="span12">
                        <div class="label">
                            <label required>
                                <p>{$lang.name}</p>
                                <input type="text" name="name">
                            </label>
                        </div>
                    </div>
                    <div class="span12">
                        <div class="checkboxes stl_2">
                            {$cbx_permissions}
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
<?php if (Functions::check_user_access(['{users_levels_deactivate}']) == true) : ?>
<section class="modal edit" data-modal="deactivate_user_level">
    <div class="content">
        <footer>
            <a button-close><i class="fas fa-times"></i></a>
            <a button-success><i class="fas fa-check"></i></a>
        </footer>
    </div>
</section>
<?php endif; ?>
<?php if (Functions::check_user_access(['{users_levels_activate}']) == true) : ?>
<section class="modal edit" data-modal="activate_user_level">
    <div class="content">
        <footer>
            <a button-close><i class="fas fa-times"></i></a>
            <a button-success><i class="fas fa-check"></i></a>
        </footer>
    </div>
</section>
<?php endif; ?>
<?php if (Functions::check_user_access(['{users_levels_delete}']) == true) : ?>
<section class="modal delete" data-modal="delete_user_level">
    <div class="content">
        <footer>
            <a button-close><i class="fas fa-times"></i></a>
            <a button-success><i class="fas fa-check"></i></a>
        </footer>
    </div>
</section>
<?php endif; ?>
