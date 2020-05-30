<?php

defined('_EXEC') or die;

$this->dependencies->add(['css', '{$path.plugins}chosen_select/chosen.css']);
$this->dependencies->add(['js', '{$path.plugins}chosen_select/chosen.jquery.js']);
$this->dependencies->add(['js', '{$path.js}Voxes/edit.js']);
$this->dependencies->add(['other', '<script>menu_focus("voxes");</script>']);

?>

%{header}%
<main class="dashboard">
    <section class="workspace">
        <form name="edit_vox">
            <div class="row">
                {$frm_edit_vox}
            </div>
        </form>
    </section>
    <section class="buttons">
        <div>
            <a href="/voxes/details/{$token}" class="active delete"><i class="fas fa-times"></i></a>
            <a class="active" data-action="edit_vox"><i class="fas fa-check"></i></a>
        </div>
    </section>
</main>
