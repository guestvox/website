<?php

defined('_EXEC') or die;

$this->dependencies->add(['css', '{$path.plugins}data-tables/jquery.dataTables.min.css']);
$this->dependencies->add(['js', '{$path.plugins}data-tables/jquery.dataTables.min.js']);
$this->dependencies->add(['js', '{$path.js}Settings/index.js']);
$this->dependencies->add(['other', '<script>menu_focus("settings");</script>']);

?>

%{header}%
<main>
    <div class="multi-tabs" data-tab-active="tab1">
        <ul>
            <?php if (Functions::check_access(['{opportunityareas_create}','{opportunityareas_update}','{opportunityareas_delete}']) == true) : ?>
            <li data-tab-target="tab1" class="active">{$lang.opportunity_areas}</li>
            <?php endif; ?>
            <?php if (Functions::check_access(['{opportunitytypes_create}','{opportunitytypes_update}','{opportunitytypes_delete}']) == true) : ?>
            <li data-tab-target="tab3" class="active">{$lang.opportunity_types}</li>
            <?php endif; ?>
            <?php if (Functions::check_access(['{locations_create}','{locations_update}','{locations_delete}']) == true) : ?>
            <li data-tab-target="tab4" class="active">{$lang.locations}</li>
            <?php endif; ?>
            <?php if (Functions::check_access(['{rooms_create}','{rooms_update}','{rooms_delete}']) == true) : ?>
            <li data-tab-target="tab5" class="active">{$lang.rooms}</li>
            <?php endif; ?>
            <?php if (Functions::check_access(['{guesttreatments_create}','{guesttreatments_update}','{guesttreatments_delete}']) == true) : ?>
            <li data-tab-target="tab6" class="active">{$lang.guest_treatments}</li>
            <?php endif; ?>
            <?php if (Functions::check_access(['{guesttypes_create}','{guesttypes_update}','{guesttypes_delete}']) == true) : ?>
            <li data-tab-target="tab7" class="active">{$lang.guest_types}</li>
            <?php endif; ?>
            <?php if (Functions::check_access(['{reservationstatus_create}','{reservationstatus_update}','{reservationstatus_delete}']) == true) : ?>
            <li data-tab-target="tab8" class="active">{$lang.reservation_status}</li>
            <?php endif; ?>
        </ul>
        <?php if (Functions::check_access(['{opportunityareas_create}','{opportunityareas_update}','{opportunityareas_delete}']) == true) : ?>
        <div class="tab" data-target="tab1">
            <section class="box-container complete">
                <div class="main">
                    <?php if (Functions::check_access(['{opportunityareas_create}']) == true) : ?>
                    <article>
                        <main class="tables">
                            <form name="new_opportunity_area">
                                <div class="row">
                                    <div class="span3">
                                        <div class="label">
                                            <label>
                                                <p>(ES) {$lang.opportunity_area}</p>
                                                <input type="text" name="name_es" />
                                            </label>
                                        </div>
                                    </div>
                                    <div class="span3">
                                        <div class="label">
                                            <label>
                                                <p>(EN) {$lang.opportunity_area}</p>
                                                <input type="text" name="name_en" />
                                            </label>
                                        </div>
                                    </div>
                                    <div class="span2">
                                        <div class="label">
                                            <label>
                                                <p>{$lang.to_request}</p>
                                                <div class="switch">
                                                    <input id="oa-request" type="checkbox" name="request" class="switch-checkbox" checked>
                                                    <label class="switch-label" for="oa-request"></label>
                                                </div>
                                            </label>
                                        </div>
                                    </div>
                                    <div class="span2">
                                        <div class="label">
                                            <label>
                                                <p>{$lang.to_incident}</p>
                                                <div class="switch">
                                                    <input id="oa-incident" type="checkbox" name="incident" class="switch-checkbox" checked>
                                                    <label class="switch-label" for="oa-incident"></label>
                                                </div>
                                            </label>
                                        </div>
                                    </div>
                                    <div class="span2">
                                        <div class="label">
                                            <label>
                                                <p>{$lang.public}</p>
                                                <div class="switch">
                                                    <input id="oa-public" type="checkbox" name="public" class="switch-checkbox" checked>
                                                    <label class="switch-label" for="oa-public"></label>
                                                </div>
                                            </label>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </main>
                        <footer>
                            <div class="buttons text-center">
                                <a class="btn" data-action="new_opportunity_area">{$lang.add}</a>
                            </div>
                        </footer>
                    </article>
                    <?php endif; ?>
                    <article>
                        <main class="tables">
                            <div class="table-container">
                                <table id="opportunity_areas" class="table">
                                    <thead>
                                        <tr>
                                            <th align="left">{$lang.opportunity_area}</th>
                                            <th align="left" width="100px">{$lang.to_request}</th>
                                            <th align="left" width="100px">{$lang.to_incident}</th>
                                            <th align="left" width="100px">{$lang.public}</th>
                                            <?php if (Functions::check_access(['{opportunityareas_delete}']) == true) : ?>
                                            <th align="right" class="icon"></th>
                                            <?php endif; ?>
                                            <?php if (Functions::check_access(['{opportunityareas_update}']) == true) : ?>
                                            <th align="right" class="icon"></th>
                                            <?php endif; ?>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        {$tbl_opportunity_areas}
                                    </tbody>
                                </table>
                            </div>
                        </main>
                    </article>
                </div>
            </section>
        </div>
        <?php endif; ?>
        <?php if (Functions::check_access(['{opportunitytypes_create}','{opportunitytypes_update}','{opportunitytypes_delete}']) == true) : ?>
        <div class="tab" data-target="tab3">
            <section class="box-container complete">
                <div class="main">
                    <?php if (Functions::check_access(['{opportunitytypes_create}']) == true) : ?>
                    <article>
                        <main class="tables">
                            <form name="new_opportunity_type">
                                <div class="row">
                                    <div class="span2">
                                        <div class="label">
                                            <label>
                                                <p>{$lang.opportunity_area}</p>
                                                <select name="opportunity_area">
                                                    <option value="" selected hidden>{$lang.choose}</option>
                                                    {$opt_opportunity_areas}
                                                </select>
                                            </label>
                                        </div>
                                    </div>
                                    <div class="span2">
                                        <div class="label">
                                            <label>
                                                <p>(ES) {$lang.opportunity_type}</p>
                                                <input type="text" name="name_es" />
                                            </label>
                                        </div>
                                    </div>
                                    <div class="span2">
                                        <div class="label">
                                            <label>
                                                <p>(EN) {$lang.opportunity_type}</p>
                                                <input type="text" name="name_en" />
                                            </label>
                                        </div>
                                    </div>
                                    <div class="span2">
                                        <div class="label">
                                            <label>
                                                <p>{$lang.to_request}</p>
                                                <div class="switch">
                                                    <input id="ot-request" type="checkbox" name="request" class="switch-checkbox" checked>
                                                    <label class="switch-label" for="ot-request"></label>
                                                </div>
                                            </label>
                                        </div>
                                    </div>
                                    <div class="span2">
                                        <div class="label">
                                            <label>
                                                <p>{$lang.to_incident}</p>
                                                <div class="switch">
                                                    <input id="ot-incident" type="checkbox" name="incident" class="switch-checkbox" checked>
                                                    <label class="switch-label" for="ot-incident"></label>
                                                </div>
                                            </label>
                                        </div>
                                    </div>
                                    <div class="span2">
                                        <div class="label">
                                            <label>
                                                <p>{$lang.public}</p>
                                                <div class="switch">
                                                    <input id="ot-public" type="checkbox" name="public" class="switch-checkbox" checked>
                                                    <label class="switch-label" for="ot-public"></label>
                                                </div>
                                            </label>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </main>
                        <footer>
                            <div class="buttons text-center">
                                <a class="btn" data-action="new_opportunity_type">{$lang.add}</a>
                            </div>
                        </footer>
                    </article>
                    <?php endif; ?>
                    <article>
                        <main class="tables">
                            <div class="table-container">
                                <table id="opportunity_types" class="table">
                                    <thead>
                                        <tr>
                                            <th align="left" width="200px">{$lang.opportunity_area}</th>
                                            <th align="left">{$lang.opportunity_type}</th>
                                            <th align="left" width="100px">{$lang.to_request}</th>
                                            <th align="left" width="100px">{$lang.to_incident}</th>
                                            <th align="left" width="100px">{$lang.public}</th>
                                            <?php if (Functions::check_access(['{opportunitytypes_delete}']) == true) : ?>
                                            <th align="right" class="icon"></th>
                                            <?php endif; ?>
                                            <?php if (Functions::check_access(['{opportunitytypes_update}']) == true) : ?>
                                            <th align="right" class="icon"></th>
                                            <?php endif; ?>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        {$tbl_opportunity_types}
                                    </tbody>
                                </table>
                            </div>
                        </main>
                    </article>
                </div>
            </section>
        </div>
        <?php endif; ?>
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
        <?php if (Functions::check_access(['{guesttreatments_create}','{guesttreatments_update}','{guesttreatments_delete}']) == true) : ?>
        <div class="tab" data-target="tab6">
            <section class="box-container complete">
                <div class="main">
                    <?php if (Functions::check_access(['{guesttreatments_create}']) == true) : ?>
                    <article>
                        <main class="tables">
                            <form name="new_guest_treatment">
                                <div class="row">
                                    <div class="span12">
                                        <div class="label">
                                            <label>
                                                <p>{$lang.guest_treatment}</p>
                                                <input type="text" name="name" />
                                            </label>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </main>
                        <footer>
                            <div class="buttons text-center">
                                <a class="btn" data-action="new_guest_treatment">{$lang.add}</a>
                            </div>
                        </footer>
                    </article>
                    <?php endif; ?>
                    <article>
                        <main class="tables">
                            <div class="table-container">
                                <table id="treatments" class="table">
                                    <thead>
                                        <tr>
                                            <th align="left">{$lang.guest_treatment}</th>
                                            <?php if (Functions::check_access(['{guesttreatments_delete}']) == true) : ?>
                                            <th align="right" class="icon"></th>
                                            <?php endif; ?>
                                            <?php if (Functions::check_access(['{guesttreatments_update}']) == true) : ?>
                                            <th align="right" class="icon"></th>
                                            <?php endif; ?>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        {$tbl_guest_treatments}
                                    </tbody>
                                </table>
                            </div>
                        </main>
                    </article>
                </div>
            </section>
        </div>
        <?php endif; ?>
        <?php if (Functions::check_access(['{guesttypes_create}','{guesttypes_update}','{guesttypes_delete}']) == true) : ?>
        <div class="tab" data-target="tab7">
            <section class="box-container complete">
                <div class="main">
                    <?php if (Functions::check_access(['{guesttypes_create}']) == true) : ?>
                    <article>
                        <main class="tables">
                            <form name="new_guest_type">
                                <div class="row">
                                    <div class="span12">
                                        <div class="label">
                                            <label>
                                                <p>{$lang.guest_type}</p>
                                                <input type="text" name="name" />
                                            </label>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </main>
                        <footer>
                            <div class="buttons text-center">
                                <a class="btn" data-action="new_guest_type">{$lang.add}</a>
                            </div>
                        </footer>
                    </article>
                    <?php endif; ?>
                    <article>
                        <main class="tables">
                            <div class="table-container">
                                <table id="guest_types" class="table">
                                    <thead>
                                        <tr>
                                            <th align="left">{$lang.guest_type}</th>
                                            <?php if (Functions::check_access(['{guesttypes_delete}']) == true) : ?>
                                            <th align="right" class="icon"></th>
                                            <?php endif; ?>
                                            <?php if (Functions::check_access(['{guesttypes_update}']) == true) : ?>
                                            <th align="right" class="icon"></th>
                                            <?php endif; ?>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        {$tbl_guest_types}
                                    </tbody>
                                </table>
                            </div>
                        </main>
                    </article>
                </div>
            </section>
        </div>
        <?php endif; ?>
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
<?php if (Functions::check_access(['{opportunityareas_update}']) == true) : ?>
<section class="modal" data-modal="edit_opportunity_area">
    <div class="content">
        <header>
            <h3>{$lang.edit}</h3>
        </header>
        <main>
            <form name="edit_opportunity_area">
                <div class="row">
                    <div class="span6">
                        <div class="label">
                            <label>
                                <p>(ES) {$lang.opportunity_area}</p>
                                <input type="text" name="name_es" />
                            </label>
                        </div>
                    </div>
                    <div class="span6">
                        <div class="label">
                            <label>
                                <p>(EN) {$lang.opportunity_area}</p>
                                <input type="text" name="name_en" />
                            </label>
                        </div>
                    </div>
                    <div class="span4">
                        <div class="label">
                            <label>
                                <p>{$lang.to_request}</p>
                                <div class="switch">
                                    <input id="oa-e-request" type="checkbox" name="request" class="switch-checkbox">
                                    <label class="switch-label" for="oa-e-request"></label>
                                </div>
                            </label>
                        </div>
                    </div>
                    <div class="span4">
                        <div class="label">
                            <label>
                                <p>{$lang.to_incident}</p>
                                <div class="switch">
                                    <input id="oa-e-incident" type="checkbox" name="incident" class="switch-checkbox">
                                    <label class="switch-label" for="oa-e-incident"></label>
                                </div>
                            </label>
                        </div>
                    </div>
                    <div class="span4">
                        <div class="label">
                            <label>
                                <p>{$lang.public}</p>
                                <div class="switch">
                                    <input id="oa-e-public" type="checkbox" name="public" class="switch-checkbox">
                                    <label class="switch-label" for="oa-e-public"></label>
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
<?php if (Functions::check_access(['{opportunityareas_delete}']) == true) : ?>
<section class="modal" data-modal="delete_opportunity_area">
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
<?php if (Functions::check_access(['{opportunitytypes_update}']) == true) : ?>
<section class="modal" data-modal="edit_opportunity_type">
    <div class="content">
        <header>
            <h3>{$lang.edit}</h3>
        </header>
        <main>
            <form name="edit_opportunity_type">
                <div class="row">
                    <div class="span12">
                        <div class="label">
                            <label>
                                <p>{$lang.opportunity_area}</p>
                                <select name="opportunity_area">
                                    <option value="" selected hidden>{$lang.choose}</option>
                                    {$opt_opportunity_areas}
                                </select>
                            </label>
                        </div>
                    </div>
                    <div class="span6">
                        <div class="label">
                            <label>
                                <p>(ES) {$lang.opportunity_type}</p>
                                <input type="text" name="name_es" />
                            </label>
                        </div>
                    </div>
                    <div class="span6">
                        <div class="label">
                            <label>
                                <p>(EN) {$lang.opportunity_type}</p>
                                <input type="text" name="name_en" />
                            </label>
                        </div>
                    </div>
                    <div class="span4">
                        <div class="label">
                            <label>
                                <p>{$lang.to_request}</p>
                                <div class="switch">
                                    <input id="ot-e-request" type="checkbox" name="request" class="switch-checkbox">
                                    <label class="switch-label" for="ot-e-request"></label>
                                </div>
                            </label>
                        </div>
                    </div>
                    <div class="span4">
                        <div class="label">
                            <label>
                                <p>{$lang.to_incident}</p>
                                <div class="switch">
                                    <input id="ot-e-incident" type="checkbox" name="incident" class="switch-checkbox">
                                    <label class="switch-label" for="ot-e-incident"></label>
                                </div>
                            </label>
                        </div>
                    </div>
                    <div class="span4">
                        <div class="label">
                            <label>
                                <p>{$lang.public}</p>
                                <div class="switch">
                                    <input id="ot-e-public" type="checkbox" name="public" class="switch-checkbox">
                                    <label class="switch-label" for="ot-e-public"></label>
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
<?php if (Functions::check_access(['{opportunitytypes_delete}']) == true) : ?>
<section class="modal" data-modal="delete_opportunity_type">
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
<?php if (Functions::check_access(['{guesttreatments_update}']) == true) : ?>
<section class="modal" data-modal="edit_guest_treatment">
    <div class="content">
        <header>
            <h3>{$lang.edit}</h3>
        </header>
        <main>
            <form name="edit_guest_treatment">
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
<?php if (Functions::check_access(['{guesttreatments_delete}']) == true) : ?>
<section class="modal" data-modal="delete_guest_treatment">
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
<?php if (Functions::check_access(['{guesttypes_update}']) == true) : ?>
<section class="modal" data-modal="edit_guest_type">
    <div class="content">
        <header>
            <h3>{$lang.edit}</h3>
        </header>
        <main>
            <form name="edit_guest_type">
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
<?php if (Functions::check_access(['{guesttypes_delete}']) == true) : ?>
<section class="modal" data-modal="delete_guest_type">
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
