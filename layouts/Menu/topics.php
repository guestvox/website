<?php

defined('_EXEC') or die;

$this->dependencies->add(['js', '{$path.js}Menu/topics.js']);
$this->dependencies->add(['other', '<script>menu_focus("menu_topics");</script>']);

?>

%{header}%
<main class="dashboard">
    <section class="workspace">
        {$tbl_menu_topics}
    </section>
    <section class="buttons">
        <div>
            <a data-button-modal="search"><i class="fas fa-search"></i></a>
            <?php if (Functions::check_user_access(['{menu_topics_create}']) == true) : ?>
            <a class="new" data-button-modal="new_menu_topic"><i class="fas fa-plus"></i></a>
            <?php endif; ?>
        </div>
    </section>
</main>
<?php if (Functions::check_user_access(['{menu_topics_create}','{menu_topics_update}']) == true) : ?>
<section class="modal fullscreen" data-modal="new_menu_topic">
    <div class="content">
        <main>
            <form name="new_menu_topic">
                <div class="row">
                    <div class="span6">
                        <div class="label">
                            <label required>
                                <p>(ES) {$lang.name}</p>
                                <input type="text" name="name_es">
                            </label>
                        </div>
                    </div>
                    <div class="span6">
                        <div class="label">
                            <label required>
                                <p>(EN) {$lang.name}</p>
                                <input type="text" name="name_en">
                            </label>
                        </div>
                    </div>
                    <div class="span6">
                        <div class="label">
                            <label required>
                                <p>{$lang.position}</p>
                                <input type="number" name="position" min="1">
                            </label>
                        </div>
                    </div>
                    <div class="span12">
                        <div class="buttons">
                            <a class="delete" button-cancel><i class="fas fa-times"></i></a>
                            <button type="submit" class="new"><i class="fas fa-check"></i></button>
                        </div>
                    </div>
                </div>
            </form>
        </main>
    </div>
</section>
<?php endif; ?>
<?php if (Functions::check_user_access(['{menu_topics_deactivate}']) == true) : ?>
<section class="modal edit" data-modal="deactivate_menu_topic">
    <div class="content">
        <footer>
            <a button-close><i class="fas fa-times"></i></a>
            <a button-success><i class="fas fa-check"></i></a>
        </footer>
    </div>
</section>
<?php endif; ?>
<?php if (Functions::check_user_access(['{menu_topics_activate}']) == true) : ?>
<section class="modal edit" data-modal="activate_menu_topic">
    <div class="content">
        <footer>
            <a button-close><i class="fas fa-times"></i></a>
            <a button-success><i class="fas fa-check"></i></a>
        </footer>
    </div>
</section>
<?php endif; ?>
<?php if (Functions::check_user_access(['{menu_topics_delete}']) == true) : ?>
<section class="modal delete" data-modal="delete_menu_topic">
    <div class="content">
        <footer>
            <a button-close><i class="fas fa-times"></i></a>
            <a button-success><i class="fas fa-check"></i></a>
        </footer>
    </div>
</section>
<?php endif; ?>
<section class="modal fullscreen" data-modal="actions">
    <div class="content">
        <main>
            <i class="fas fa-check-circle"></i>
            <!-- <p></p> -->
            <div>
                <a href="/menu/products">{$lang.create_product}</a>
                <a data-action="create_other_topic">{$lang.create_other_topic}</a>
                <a button-reload>{$lang.only_save}</a>
            </div>
        </main>
    </div>
</section>
