<?php

defined('_EXEC') or die;

$this->dependencies->add(['css', '{$path.plugins}data-tables/jquery.dataTables.min.css']);
$this->dependencies->add(['js', '{$path.plugins}data-tables/jquery.dataTables.min.js']);
$this->dependencies->add(['js', '{$path.js}Settings/locations.js']);
$this->dependencies->add(['other', '<script>menu_focus("settings");</script>']);

?>

%{header}%
<main>
    <div class="multi-tabs" data-tab-active="tab4">
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
        <?php if (Functions::check_access(['{locations_create}','{locations_update}','{locations_delete}']) == true) : ?>
        <div class="tab" data-target="tab4">
            <section class="box-container complete">
                <div class="main">
                    <?php if (Functions::check_access(['{locations_create}']) == true) : ?>
                    <article>
                        <main class="tables">
                            <form name="new_location">
                                <div class="row">
                                    <div class="span3">
                                        <div class="label">
                                            <label>
                                                <p>(ES) {$lang.location}</p>
                                                <input type="text" name="name_es" />
                                            </label>
                                        </div>
                                    </div>
                                    <div class="span3">
                                        <div class="label">
                                            <label>
                                                <p>(EN) {$lang.location}</p>
                                                <input type="text" name="name_en" />
                                            </label>
                                        </div>
                                    </div>
                                    <div class="span2">
                                        <div class="label">
                                            <label>
                                                <p>{$lang.to_request}</p>
                                                <div class="switch">
                                                    <input id="l-request" type="checkbox" name="request" class="switch-checkbox" checked>
                                                    <label class="switch-label" for="l-request"></label>
                                                </div>
                                            </label>
                                        </div>
                                    </div>
                                    <div class="span2">
                                        <div class="label">
                                            <label>
                                                <p>{$lang.to_incident}</p>
                                                <div class="switch">
                                                    <input id="l-incident" type="checkbox" name="incident" class="switch-checkbox" checked>
                                                    <label class="switch-label" for="l-incident"></label>
                                                </div>
                                            </label>
                                        </div>
                                    </div>
                                    <div class="span2">
                                        <div class="label">
                                            <label>
                                                <p>{$lang.public}</p>
                                                <div class="switch">
                                                    <input id="l-public" type="checkbox" name="public" class="switch-checkbox" checked>
                                                    <label class="switch-label" for="l-public"></label>
                                                </div>
                                            </label>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </main>
                        <footer>
                            <div class="buttons text-center">
                                <a class="btn" data-action="new_location">{$lang.add}</a>
                            </div>
                        </footer>
                    </article>
                    <?php endif; ?>
                    <article>
                        <main class="tables">
                            <div class="table-container">
                                <table id="locations" class="table">
                                    <thead>
                                        <tr>
                                            <th align="left">{$lang.location}</th>
                                            <th align="left" width="100px">{$lang.to_request}</th>
                                            <th align="left" width="100px">{$lang.to_incident}</th>
                                            <th align="left" width="100px">{$lang.public}</th>
                                            <?php if (Functions::check_access(['{locations_delete}']) == true) : ?>
                                            <th align="right" class="icon"></th>
                                            <?php endif; ?>
                                            <?php if (Functions::check_access(['{locations_update}']) == true) : ?>
                                            <th align="right" class="icon"></th>
                                            <?php endif; ?>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        {$tbl_locations}
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
<?php if (Functions::check_access(['{locations_update}']) == true) : ?>
<section class="modal" data-modal="edit_location">
    <div class="content">
        <header>
            <h3>{$lang.edit}</h3>
        </header>
        <main>
            <form name="edit_location">
                <div class="row">
                    <div class="span6">
                        <div class="label">
                            <label>
                                <p>(ES) {$lang.location}</p>
                                <input type="text" name="name_es" />
                            </label>
                        </div>
                    </div>
                    <div class="span6">
                        <div class="label">
                            <label>
                                <p>(EN) {$lang.location}</p>
                                <input type="text" name="name_en" />
                            </label>
                        </div>
                    </div>
                    <div class="span4">
                        <div class="label">
                            <label>
                                <p>{$lang.to_request}</p>
                                <div class="switch">
                                    <input id="l-e-request" type="checkbox" name="request" class="switch-checkbox">
                                    <label class="switch-label" for="l-e-request"></label>
                                </div>
                            </label>
                        </div>
                    </div>
                    <div class="span4">
                        <div class="label">
                            <label>
                                <p>{$lang.to_incident}</p>
                                <div class="switch">
                                    <input id="l-e-incident" type="checkbox" name="incident" class="switch-checkbox">
                                    <label class="switch-label" for="l-e-incident"></label>
                                </div>
                            </label>
                        </div>
                    </div>
                    <div class="span4">
                        <div class="label">
                            <label>
                                <p>{$lang.public}</p>
                                <div class="switch">
                                    <input id="l-e-public" type="checkbox" name="public" class="switch-checkbox">
                                    <label class="switch-label" for="l-e-public"></label>
                                </div>
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
<?php if (Functions::check_access(['{locations_delete}']) == true) : ?>
<section class="modal" data-modal="delete_location">
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
