<?php

defined('_EXEC') or die;

$this->dependencies->add(['js', '{$path.js}Gueststypes/index.js']);
$this->dependencies->add(['other', '<script>menu_focus("guests_types");</script>']);

?>

%{header}%
<main class="dashboard">
    <section class="workspace">
        <div class="tbl_stl_2">
            {$tbl_guests_types}
        </div>
    </section>
    <?php if (Functions::check_user_access(['{guests_types_create}']) == true) : ?>
    <section class="buttons">
        <div>
            <a class="active" data-button-modal="new_guest_type"><i class="fas fa-plus"></i></a>
        </div>
    </section>
    <?php endif; ?>
</main>
<?php if (Functions::check_user_access(['{guests_types_create}','guests_types_update']) == true) : ?>
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
                            <button type="submit"><i class="fas fa-check"></i></button>
                            <a button-cancel><i class="fas fa-times"></i></a>
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
            <a button-success><i class="fas fa-check"></i></a>
            <a button-close><i class="fas fa-times"></i></a>
        </footer>
    </div>
</section>
<?php endif; ?>
<?php if (Functions::check_user_access(['{guests_types_activate}']) == true) : ?>
<section class="modal edit" data-modal="activate_guest_type">
    <div class="content">
        <footer>
            <a button-success><i class="fas fa-check"></i></a>
            <a button-close><i class="fas fa-times"></i></a>
        </footer>
    </div>
</section>
<?php endif; ?>
<?php if (Functions::check_user_access(['{guests_types_delete}']) == true) : ?>
<section class="modal delete" data-modal="delete_guest_type">
    <div class="content">
        <footer>
            <a button-success><i class="fas fa-check"></i></a>
            <a button-close><i class="fas fa-times"></i></a>
        </footer>
    </div>
</section>
<?php endif; ?>
