<?php

defined('_EXEC') or die;

$this->dependencies->add(['css', '{$path.plugins}data-tables/jquery.dataTables.min.css']);
$this->dependencies->add(['js', '{$path.plugins}data-tables/jquery.dataTables.min.js']);
$this->dependencies->add(['js', '{$path.js}Reservationstatuses/index.js']);
$this->dependencies->add(['other', '<script>menu_focus("other");</script>']);

?>

%{header}%
<main>
    <nav>
        <h2><i class="fas fa-check"></i>{$lang.reservation_statuses}</h2>
    </nav>
    <article>
        <main>
            <div class="table">
                <aside>
                    <label>
                        <span><i class="fas fa-search"></i></span>
                        <input type="text" name="tbl_reservation_statuses_search">
                    </label>
                    <?php if (Functions::check_user_access(['{reservation_statuses_create}']) == true) : ?>
                    <a data-button-modal="new_reservation_status" class="new"><i class="fas fa-plus"></i></a>
                    <?php endif; ?>
                </aside>
                <table id="tbl_reservation_statuses">
                    <thead>
                        <tr>
                            <th align="left">{$lang.name}</th>
                            <?php if (Functions::check_user_access(['{reservation_statuses_delete}']) == true) : ?>
                            <th align="right" class="icon"></th>
                            <?php endif; ?>
                            <?php if (Functions::check_user_access(['{reservation_statuses_update}']) == true) : ?>
                            <th align="right" class="icon"></th>
                            <?php endif; ?>
                        </tr>
                    </thead>
                    <tbody>
                        {$tbl_reservation_statuses}
                    </tbody>
                </table>
            </div>
        </main>
    </article>
</main>
<?php if (Functions::check_user_access(['{reservation_statuses_create}','{reservation_statuses_update}']) == true) : ?>
<section class="modal new" data-modal="new_reservation_status">
    <div class="content">
        <header>
            <h3>{$lang.new}</h3>
        </header>
        <main>
            <form name="new_reservation_status">
                <div class="row">
                    <div class="span12">
                        <div class="label">
                            <label>
                                <p>{$lang.name}</p>
                                <input type="text" name="name" />
                            </label>
                        </div>
                    </div>
                </div>
            </form>
        </main>
        <footer>
            <div class="action-buttons">
                <button class="btn btn-flat" button-cancel>{$lang.cancel}</button>
                <button class="btn" button-success>{$lang.accept}</button>
            </div>
        </footer>
    </div>
</section>
<?php endif; ?>
<?php if (Functions::check_user_access(['{reservation_statuses_delete}']) == true) : ?>
<section class="modal delete" data-modal="delete_reservation_status">
    <div class="content">
        <header>
            <h3>{$lang.delete}</h3>
        </header>
        <footer>
            <div class="action-buttons">
                <button class="btn btn-flat" button-close>{$lang.cancel}</button>
                <button class="btn" button-success>{$lang.accept}</button>
            </div>
        </footer>
    </div>
</section>
<?php endif; ?>
