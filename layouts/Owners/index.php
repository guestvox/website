<?php

defined('_EXEC') or die;

$this->dependencies->add(['js', '{$path.js}Owners/index.js']);
$this->dependencies->add(['other', '<script>menu_focus("owners");</script>']);

?>

%{header}%
<main class="dashboard">
    <section class="workspace">
        <div class="tbl-stl-3">
            {$tbl_owners}
        </div>
    </section>
    <?php if (Functions::check_user_access(['{owners_create}']) == true) : ?>
    <section class="buttons">
        <div>
            <a class="active" data-button-modal="new_owner"><i class="fas fa-plus"></i></a>
        </div>
    </section>
    <?php endif; ?>
</main>
{$mdl_new_owner}
<?php if (Functions::check_user_access(['{owners_deactivate}']) == true) : ?>
<section class="modal warning" data-modal="deactivate_owner">
    <div class="content">
        <footer>
            <button button-success><i class="fas fa-check"></i></button>
            <button button-close><i class="fas fa-times"></i></button>
        </footer>
    </div>
</section>
<?php endif; ?>
<?php if (Functions::check_user_access(['{owners_activate}']) == true) : ?>
<section class="modal warning" data-modal="activate_owner">
    <div class="content">
        <footer>
            <button button-success><i class="fas fa-check"></i></button>
            <button button-close><i class="fas fa-times"></i></button>
        </footer>
    </div>
</section>
<?php endif; ?>
<?php if (Functions::check_user_access(['{owners_delete}']) == true) : ?>
<section class="modal alert" data-modal="delete_owner">
    <div class="content">
        <footer>
            <button button-success><i class="fas fa-check"></i></button>
            <button button-close><i class="fas fa-times"></i></button>
        </footer>
    </div>
</section>
<?php endif; ?>
