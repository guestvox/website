<?php

defined('_EXEC') or die;

$this->dependencies->add(['js', '{$path.js}Gueststreatments/index.js']);
$this->dependencies->add(['other', '<script>menu_focus("guests_treatments");</script>']);

?>

%{header}%
<main class="dashboard">
    <section class="workspace">
        <div class="tbl_stl_2">
            {$tbl_guests_treatments}
        </div>
    </section>
    <?php if (Functions::check_user_access(['{guests_treatments_create}']) == true) : ?>
    <section class="buttons">
        <div>
            <a class="active" data-button-modal="new_guest_treatment"><i class="fas fa-plus"></i></a>
        </div>
    </section>
    <?php endif; ?>
</main>
<?php if (Functions::check_user_access(['{guests_treatments_create}','{guests_treatments_update}']) == true) : ?>
<section class="modal fullscreen" data-modal="new_guest_treatment">
    <div class="content">
        <main>
            <form name="new_guest_treatment">
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
<?php if (Functions::check_user_access(['{guests_treatments_deactivate}']) == true) : ?>
<section class="modal edit" data-modal="deactivate_guest_treatment">
    <div class="content">
        <footer>
            <a button-close><i class="fas fa-times"></i></a>
            <a button-success><i class="fas fa-check"></i></a>
        </footer>
    </div>
</section>
<?php endif; ?>
<?php if (Functions::check_user_access(['{guests_treatments_activate}']) == true) : ?>
<section class="modal edit" data-modal="activate_guest_treatment">
    <div class="content">
        <footer>
            <a button-close><i class="fas fa-times"></i></a>
            <a button-success><i class="fas fa-check"></i></a>
        </footer>
    </div>
</section>
<?php endif; ?>
<?php if (Functions::check_user_access(['{guests_treatments_delete}']) == true) : ?>
<section class="modal delete" data-modal="delete_guest_treatment">
    <div class="content">
        <footer>
            <a button-close><i class="fas fa-times"></i></a>
            <a button-success><i class="fas fa-check"></i></a>
        </footer>
    </div>
</section>
<?php endif; ?>
