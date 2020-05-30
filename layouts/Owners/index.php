<?php

defined('_EXEC') or die;

$this->dependencies->add(['js', '{$path.js}Owners/index.js']);
$this->dependencies->add(['other', '<script>menu_focus("owners");</script>']);

?>

%{header}%
<main class="dashboard">
    <section class="workspace">
        <div class="tbl_stl_3">
            {$tbl_owners}
        </div>
    </section>
    <section class="buttons">
        <div>
            <a data-action="search"><i class="fas fa-search"></i></a>
            <?php if (Functions::check_user_access(['{owners_create}']) == true) : ?>
            <a class="active" data-button-modal="new_owner"><i class="fas fa-plus"></i></a>
            <?php endif; ?>
        </div>
    </section>
</main>
{$mdl_new_owner}
<?php if (Functions::check_user_access(['{owners_deactivate}']) == true) : ?>
<section class="modal edit" data-modal="deactivate_owner">
    <div class="content">
        <footer>
            <a button-close><i class="fas fa-times"></i></a>
            <a button-success><i class="fas fa-check"></i></a>
        </footer>
    </div>
</section>
<?php endif; ?>
<?php if (Functions::check_user_access(['{owners_activate}']) == true) : ?>
<section class="modal edit" data-modal="activate_owner">
    <div class="content">
        <footer>
            <a button-close><i class="fas fa-times"></i></a>
            <a button-success><i class="fas fa-check"></i></a>
        </footer>
    </div>
</section>
<?php endif; ?>
<?php if (Functions::check_user_access(['{owners_delete}']) == true) : ?>
<section class="modal delete" data-modal="delete_owner">
    <div class="content">
        <footer>
            <a button-close><i class="fas fa-times"></i></a>
            <a button-success><i class="fas fa-check"></i></a>
        </footer>
    </div>
</section>
<?php endif; ?>
