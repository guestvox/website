<?php

defined('_EXEC') or die;

$this->dependencies->add(['css', '{$path.plugins}data-tables/jquery.dataTables.min.css']);
$this->dependencies->add(['js', '{$path.plugins}data-tables/jquery.dataTables.min.js']);
$this->dependencies->add(['js', '{$path.js}Settings/reservationstatus.js']);
$this->dependencies->add(['other', '<script>menu_focus("settings");</script>']);

?>

%{header}%
<main>
    <div class="multi-tabs" data-tab-active="tab8">
        <ul>
            <?php if (Functions::check_access(['{opportunityareas_create}','{opportunityareas_update}','{opportunityareas_delete}']) == true) : ?>
            <li data-tab-target="tab1" class="active"><a href="/settings/opportunityareas">{$lang.opportunity_areas}</a></li>
            <?php endif; ?>
            <?php if (Functions::check_access(['{opportunitytypes_create}','{opportunitytypes_update}','{opportunitytypes_delete}']) == true) : ?>
            <li data-tab-target="tab3" class="active"><a href="/settings/opportunitytypes">{$lang.opportunity_types}</a></li>
            <?php endif; ?>
            <?php if (Functions::check_access(['{locations_create}','{locations_update}','{locations_delete}']) == true) : ?>
            <li data-tab-target="tab4" class="active"><a href="/settings/locations">{$lang.locations}</a></li>
            <?php endif; ?>
            <?php if (Functions::check_access(['{rooms_create}','{rooms_update}','{rooms_delete}']) == true) : ?>
            <li data-tab-target="tab5" class="active"><a href="/settings/rooms">{$lang.rooms}</a></li>
            <?php endif; ?>
            <?php if (Functions::check_access(['{guesttreatments_create}','{guesttreatments_update}','{guesttreatments_delete}']) == true) : ?>
            <li data-tab-target="tab6" class="active"><a href="/settings/guesttreatments">{$lang.guest_treatments}</a></li>
            <?php endif; ?>
            <?php if (Functions::check_access(['{guesttypes_create}','{guesttypes_update}','{guesttypes_delete}']) == true) : ?>
            <li data-tab-target="tab7" class="active"><a href="/settings/guesttypes">{$lang.guest_types}</a></li>
            <?php endif; ?>
            <?php if (Functions::check_access(['{reservationstatus_create}','{reservationstatus_update}','{reservationstatus_delete}']) == true) : ?>
            <li data-tab-target="tab8" class="active"><a href="/settings/reservationstatus">{$lang.reservation_status}</a></li>
            <?php endif; ?>
        </ul>
        <?php if (Functions::check_access(['{reservationstatus_create}','{reservationstatus_update}','{reservationstatus_delete}']) == true) : ?>
        <div class="tab" data-target="tab8">
            <section class="box-container complete">
                <div class="main">
                    <?php if (Functions::check_access(['{reservationstatus_create}']) == true) : ?>
                    <article>
                        <main class="tables">
                            <form name="new_reservation_status">
                                <div class="row">
                                    <div class="span12">
                                        <div class="label">
                                            <label>
                                                <p>{$lang.reservation_status}</p>
                                                <input type="text" name="name" />
                                            </label>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </main>
                        <footer>
                            <div class="buttons text-center">
                                <a class="btn" data-action="new_reservation_status">{$lang.add}</a>
                            </div>
                        </footer>
                    </article>
                    <?php endif; ?>
                    <article>
                        <main class="tables">
                            <div class="table-container">
                                <table id="reservation_status" class="table">
                                    <thead>
                                        <tr>
                                            <th align="left">{$lang.reservation_status}</th>
                                            <?php if (Functions::check_access(['{reservationstatus_delete}']) == true) : ?>
                                            <th align="right" class="icon"></th>
                                            <?php endif; ?>
                                            <?php if (Functions::check_access(['{reservationstatus_update}']) == true) : ?>
                                            <th align="right" class="icon"></th>
                                            <?php endif; ?>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        {$tbl_reservation_status}
                                    </tbody>
                                </table>
                            </div>
                        </main>
                    </article>
                </div>
            </section>
        </div>
        <?php endif; ?>
    </div>
</main>
<?php if (Functions::check_access(['{reservationstatus_update}']) == true) : ?>
<section class="modal" data-modal="edit_reservation_status">
    <div class="content">
        <header>
            <h3>{$lang.edit}</h3>
        </header>
        <main>
            <form name="edit_reservation_status">
                <div class="row">
                    <div class="span12">
                        <div class="label">
                            <label>
                                <p>{$lang.firstname}</p>
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
<?php if (Functions::check_access(['{reservationstatus_update}']) == true) : ?>
<section class="modal" data-modal="delete_reservation_status">
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
