<?php

defined('_EXEC') or die;

$this->dependencies->add(['js', '{$path.js}Gueststypes/index.js']);
$this->dependencies->add(['other', '<script>menu_focus("guests_types");</script>']);

?>

%{header}%
<main class="dashboard">
    <section class="workspace">
        <div class="tbl_stl_2" data-table>
            {$tbl_guests_types}
        </div>
    </section>
    <section class="buttons">
        <div>
            <a data-button-modal="search"><i class="fas fa-search"></i></a>
            <?php if (Functions::check_user_access(['{guests_types_create}']) == true) : ?>
            <a class="active" data-button-modal="new_guest_type"><i class="fas fa-plus"></i></a>
            <?php endif; ?>
        </div>
    </section>
</main>
<?php if (Functions::check_user_access(['{guests_types_create}','{guests_types_update}']) == true) : ?>
<section class="modal fullscreen" data-modal="new_guest_type">
    <div class="content">
        <main>
            <form name="new_guest_type">
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
<?php if (Functions::check_user_access(['{guests_types_deactivate}']) == true) : ?>
<section class="modal edit" data-modal="deactivate_guest_type">
    <div class="content">
        <footer>
            <a button-close><i class="fas fa-times"></i></a>
            <a button-success><i class="fas fa-check"></i></a>
        </footer>
    </div>
</section>
<?php endif; ?>
<?php if (Functions::check_user_access(['{guests_types_activate}']) == true) : ?>
<section class="modal edit" data-modal="activate_guest_type">
    <div class="content">
        <footer>
            <a button-close><i class="fas fa-times"></i></a>
            <a button-success><i class="fas fa-check"></i></a>
        </footer>
    </div>
</section>
<?php endif; ?>
<?php if (Functions::check_user_access(['{guests_types_delete}']) == true) : ?>
<section class="modal delete" data-modal="delete_guest_type">
    <div class="content">
        <footer>
            <a button-close><i class="fas fa-times"></i></a>
            <a button-success><i class="fas fa-check"></i></a>
        </footer>
    </div>
</section>
<?php endif; ?>
