<?php

defined('_EXEC') or die;

$this->dependencies->add(['js', '{$path.js}Menu/owners.js']);
$this->dependencies->add(['other', '<script>menu_focus("menu");</script>']);

?>

%{header}%
<main class="dashboard">
    <section class="workspace">
        <div class="tbl_stl_3">
            {$tbl_menu_owners}
        </div>
    </section>
    <section class="buttons">
        <div>
            <a data-button-modal="search"><i class="fas fa-search"></i></a>
            <?php if (Functions::check_user_access(['{menu_owners_create}']) == true) : ?>
            <a class="active" data-button-modal="new_menu_owner"><i class="fas fa-plus"></i></a>
            <?php endif; ?>
        </div>
    </section>
</main>
<?php if (Functions::check_user_access(['{menu_owners_create}','{menu_owners_update}']) == true) : ?>
<section class="modal fullscreen" data-modal="new_menu_owner">
    <div class="content">
        <main>
            <form name="new_menu_owner">
                <div class="row">
                    <!-- <div class="span14">
                        <div class="stl_1" data-uploader="low">
                            <figure data-preview>
                                <img src="{$path.images}empty.png" alt="Food">
                                <a data-select><i class="fas fa-upload"></i></a>
                                <input type="file" name="avatar" accept="image/*" data-upload>
                            </figure>
                        </div>
                    </div> -->
                    <div class="span6">
                        <div class="label">
                            <label required>
                                <p>(ES) {$lang.firstname}</p>
                                <input type="text" name="name_es">
                            </label>
                        </div>
                    </div>
                    <div class="span6">
                        <div class="label">
                            <label required>
                                <p>(EN) {$lang.firstname}</p>
                                <input type="text" name="name_en">
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
<?php if (Functions::check_user_access(['{menu_owners_deactivate}']) == true) : ?>
<section class="modal edit" data-modal="deactivate_menu_owner">
    <div class="content">
        <footer>
            <a button-close><i class="fas fa-times"></i></a>
            <a button-success><i class="fas fa-check"></i></a>
        </footer>
    </div>
</section>
<?php endif; ?>
<?php if (Functions::check_user_access(['{menu_owners_activate}']) == true) : ?>
<section class="modal edit" data-modal="activate_menu_owner">
    <div class="content">
        <footer>
            <a button-close><i class="fas fa-times"></i></a>
            <a button-success><i class="fas fa-check"></i></a>
        </footer>
    </div>
</section>
<?php endif; ?>
<?php if (Functions::check_user_access(['{menu_owners_delete}']) == true) : ?>
<section class="modal delete" data-modal="delete_menu_owner">
    <div class="content">
        <footer>
            <a button-close><i class="fas fa-times"></i></a>
            <a button-success><i class="fas fa-check"></i></a>
        </footer>
    </div>
</section>
<?php endif; ?>
