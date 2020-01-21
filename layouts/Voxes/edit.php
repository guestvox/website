<?php

defined('_EXEC') or die;

// $this->dependencies->add(['css', '{$path.plugins}date-picker/jquery-ui.min.css']);
// $this->dependencies->add(['js', '{$path.plugins}date-picker/jquery-ui.min.js']);
// $this->dependencies->add(['css', '{$path.plugins}time-picker/timepicker.css']);
// $this->dependencies->add(['js', '{$path.plugins}time-picker/timepicker.js']);
$this->dependencies->add(['css', '{$path.plugins}chosen-select/chosen.css']);
$this->dependencies->add(['js', '{$path.plugins}chosen-select/chosen.jquery.js']);
// $this->dependencies->add(['css', '{$path.plugins}upload-file/input-file.css']);
// $this->dependencies->add(['js', '{$path.plugins}upload-file/input-file.js']);
$this->dependencies->add(['js', '{$path.js}Voxes/edit.js']);
$this->dependencies->add(['other', '<script>menu_focus("voxes");</script>']);

?>

%{header}%
<main>
    <nav>
        <h2><i class="fas fa-heart"></i>{$lang.edit_vox}</h2>
    </nav>
    <article>
        <main>
            <form name="edit_vox">
                <div class="row">
                    {$lbl_edit_vox}
                </div>
            </form>
        </main>
        <footer>
             <a data-action="edit_vox">{$lang.accept}</a>
        </footer>
    </article>
</main>
