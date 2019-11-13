<?php

defined('_EXEC') or die;

$this->dependencies->add(['css', '{$path.plugins}data-tables/jquery.dataTables.min.css']);
$this->dependencies->add(['js', '{$path.plugins}data-tables/jquery.dataTables.min.js']);
$this->dependencies->add(['js', '{$path.js}Settings/rooms.js']);
$this->dependencies->add(['other', '<script>menu_focus("settings");</script>']);

?>

%{header}%
<main>
    <div class="multi-tabs" data-tab-active="tab5">
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
        <?php if (Functions::check_access(['{rooms_create}','{rooms_update}','{rooms_delete}']) == true) : ?>
        <div class="tab" data-target="tab5">
            <section class="box-container complete">
                <div class="main">
                    <?php if (Functions::check_access(['{rooms_create}']) == true) : ?>
                    <article>
                        <main class="tables">
                            <form name="new_room">
                                <div class="row">
                                    <div class="span12 height-auto">
                                        <div class="label">
                                            <label>
                                                <div class="checkboxes">
                                                    <div class="checkbox">
                                    					<input type="radio" name="type" value="many" checked>
                                    					<span>{$lang.many_rooms}</span>
                                    				</div>
                                                    <div class="checkbox">
                                    					<input type="radio" name="type" value="one">
                                    					<span>{$lang.one_room}</span>
                                    				</div>
                                                </div>
                                            </label>
                                        </div>
                                    </div>
                                    <div class="span3">
                                        <div class="label">
                                            <label>
                                                <p>{$lang.prefix}</p>
                                                <input type="text" name="prefix" />
                                            </label>
                                        </div>
                                    </div>
                                    <div class="span3">
                                        <div class="label">
                                            <label>
                                                <p>{$lang.since}</p>
                                                <input type="number" name="since" />
                                            </label>
                                        </div>
                                    </div>
                                    <div class="span3">
                                        <div class="label">
                                            <label>
                                                <p>{$lang.to}</p>
                                                <input type="number" name="to" />
                                            </label>
                                        </div>
                                    </div>
                                    <div class="span3">
                                        <div class="label">
                                            <label>
                                                <p>{$lang.suffix}</p>
                                                <input type="text" name="suffix" />
                                            </label>
                                        </div>
                                    </div>
                                    <div class="span12 hidden">
                                        <div class="label">
                                            <label>
                                                <p>{$lang.room}</p>
                                                <input type="text" name="name" />
                                                <p class="description">{$lang.name_number}</p>
                                            </label>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </main>
                        <footer>
                            <div class="buttons text-center">
                                <a class="btn" data-action="new_room">{$lang.add}</a>
                            </div>
                        </footer>
                    </article>
                    <?php endif; ?>
                    <article>
                        <main class="tables">
                            <div class="table-container">
                                <table id="rooms" class="table">
                                    <thead>
                                        <tr>
                                            <th align="left">{$lang.room}</th>
                                            <th align="left" width="100px">{$lang.qr}</th>
                                            <th align="right" class="icon"></th>
                                            <?php if (Functions::check_access(['{rooms_delete}']) == true) : ?>
                                            <th align="right" class="icon"></th>
                                            <?php endif; ?>
                                            <?php if (Functions::check_access(['{rooms_update}']) == true) : ?>
                                            <th align="right" class="icon"></th>
                                            <?php endif; ?>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        {$tbl_rooms}
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
<?php if (Functions::check_access(['{rooms_update}']) == true) : ?>
<section class="modal" data-modal="edit_room">
    <div class="content">
        <header>
            <h3>{$lang.edit}</h3>
        </header>
        <main>
            <form name="edit_room">
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
<?php if (Functions::check_access(['{rooms_delete}']) == true) : ?>
<section class="modal" data-modal="delete_room">
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
