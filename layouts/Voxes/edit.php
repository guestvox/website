<?php

defined('_EXEC') or die;

$this->dependencies->add(['css', '{$path.plugins}date-picker/jquery-ui.min.css']);
$this->dependencies->add(['js', '{$path.plugins}date-picker/jquery-ui.min.js']);
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
    <section class="box-container complete">
        <div class="main">
            <article>
                <main>
                    <form name="edit_vox">
                        <div class="row">
                            {$html}
                        </div>
                    </form>
                </main>
                <footer>
                    <div class="buttons text-center">
                        <a class="btn" data-action="edit_vox">{$lang.edit}</a>
                    </div>
                </footer>
            </article>
        </div>
    </section>
</main>
