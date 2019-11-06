<?php

defined('_EXEC') or die;

$this->dependencies->add(['css', '{$path.plugins}data-tables/jquery.dataTables.min.css']);
$this->dependencies->add(['js', '{$path.plugins}data-tables/jquery.dataTables.min.js']);
$this->dependencies->add(['css', '{$path.plugins}date-picker/jquery-ui.min.css']);
$this->dependencies->add(['js', '{$path.plugins}date-picker/jquery-ui.min.js']);
$this->dependencies->add(['js', '{$path.js}Reports/index.js']);
$this->dependencies->add(['other', '<script>menu_focus("reports");</script>']);

?>

%{header}%
<main>
    <div class="multi-tabs" data-tab-active="tab1">
        <ul>
            <li data-tab-target="tab1" class="active">{$lang.generate}</li>
            <li data-tab-target="tab2">{$lang.personalize}</li>
        </ul>
        <div class="tab" data-target="tab1">
            <section class="box-container complete">
                <div class="main">
                    <article>
                        <main class="tables">
                            <form name="generate_report">
                                <div class="row">
                                    <div class="span2">
                                        <div class="label">
                                            <label>
                                                <p>{$lang.report_type}</p>
                                                <select name="filter">
                                                    <option value="all">{$lang.free_report}</option>
                                                    {$opt_reports}
                                                </select>
                                            </label>
                                        </div>
                                    </div>
                                    <div class="span2">
                                        <div class="label">
                                            <label>
                                                <p>{$lang.vox_type}</p>
                                                <select name="type">
                                                    <option value="all">{$lang.all}</option>
                                                    <option value="request">{$lang.request}</option>
                                                    <option value="incident">{$lang.incident}</option>
                                                </select>
                                            </label>
                                        </div>
                                    </div>
                                    <div class="span2">
                                        <div class="label">
                                            <label>
                                                <p>{$lang.opportunity_area}</p>
                                                <select name="opportunity_area">
                                                    <option value="all">{$lang.all}</option>
                                                    {$opt_opportunity_areas}
                                                </select>
                                            </label>
                                        </div>
                                    </div>
                                    <div class="span2">
                                        <div class="label">
                                            <label>
                                                <p>{$lang.opportunity_type}</p>
                                                <select name="opportunity_type">
                                                    <option value="all">{$lang.all}</option>
                                                </select>
                                            </label>
                                        </div>
                                    </div>
                                    <div class="span2">
                                        <div class="label">
                                            <label>
                                                <p>{$lang.room}</p>
                                                <select name="room">
                                                    <option value="all">{$lang.all}</option>
                                                    {$opt_rooms}
                                                </select>
                                            </label>
                                        </div>
                                    </div>
                                    <div class="span2">
                                        <div class="label">
                                            <label>
                                                <p>{$lang.location}</p>
                                                <select name="location">
                                                    <option value="all">{$lang.all}</option>
                                                    {$opt_locations}
                                                </select>
                                            </label>
                                        </div>
                                    </div>
                                    <div class="span2">
                                        <div class="label">
                                            <label>
                                                <p>{$lang.order_by}</p>
                                                <select name="order">
                                                    <option value="room">{$lang.room}</option>
                                                    <option value="guest">{$lang.guest}</option>
                                                </select>
                                            </label>
                                        </div>
                                    </div>
                                    <div class="span2">
                                        <div class="label">
                                            <label>
                                                <p>{$lang.started_date}</p>
                                                <input type="text" name="started_date" class="datepicker" placeholder="{$lang.choose}" value="<?php echo Dates::get_current_date('Y-m-d'); ?>" />
                                            </label>
                                        </div>
                                    </div>
                                    <div class="span2">
                                        <div class="label">
                                            <label>
                                                <p>{$lang.end_date}</p>
                                                <input type="text" name="end_date" class="datepicker" placeholder="{$lang.choose}" value="<?php echo Dates::get_current_date('Y-m-d'); ?>" />
                                            </label>
                                        </div>
                                    </div>
                                    <div class="span12">
                                        <div class="label">
                                            <div>
                                                <p>{$lang.data_displayed}</p>
                                                <div class="checkboxes">
                                                    <div class="checkbox">
                                    					<input type="checkbox" name="checked_all">
                                    					<span>{$lang.all}</span>
                                    				</div>
                                                    {$cbx_fields}
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </main>
                        <footer>
                            <div class="buttons text-center">
                                <a class="btn" data-action="generate_report">{$lang.generate}</a>
                            </div>
                        </footer>
                    </article>
                    <article>
                        <main class="tables">
                            <div id="report" class="report"></div>
                        </main>
                        <footer>
                            <div class="buttons text-center">
                                <a class="btn hidden" data-action="print_report">{$lang.print}</a>
                            </div>
                        </footer>
                    </article>
                </div>
            </section>
        </div>
        <div class="tab" data-target="tab2">
            <section class="box-container complete">
                <div class="main">
                    <article>
                        <main class="tables">
                            <form name="new_report">
                                <div class="row">
                                    <div class="span2">
                                        <div class="label">
                                            <label>
                                                <p>{$lang.name}</p>
                                                <input type="text" name="name" />
                                            </label>
                                        </div>
                                    </div>
                                    <div class="span2">
                                        <div class="label">
                                            <label>
                                                <p>{$lang.vox_type}</p>
                                                <select name="type">
                                                    <option value="all">{$lang.all}</option>
                                                    <option value="request">{$lang.request}</option>
                                                    <option value="incident">{$lang.incident}</option>
                                                </select>
                                            </label>
                                        </div>
                                    </div>
                                    <div class="span2">
                                        <div class="label">
                                            <label>
                                                <p>{$lang.opportunity_area}</p>
                                                <select name="opportunity_area">
                                                    <option value="all">{$lang.all}</option>
                                                    {$opt_opportunity_areas}
                                                </select>
                                            </label>
                                        </div>
                                    </div>
                                    <div class="span2">
                                        <div class="label">
                                            <label>
                                                <p>{$lang.opportunity_type}</p>
                                                <select name="opportunity_type">
                                                    <option value="all">{$lang.all}</option>
                                                </select>
                                            </label>
                                        </div>
                                    </div>
                                    <div class="span2">
                                        <div class="label">
                                            <label>
                                                <p>{$lang.room}</p>
                                                <select name="room">
                                                    <option value="all">{$lang.all}</option>
                                                    {$opt_rooms}
                                                </select>
                                            </label>
                                        </div>
                                    </div>
                                    <div class="span2">
                                        <div class="label">
                                            <label>
                                                <p>{$lang.location}</p>
                                                <select name="location">
                                                    <option value="all">{$lang.all}</option>
                                                    {$opt_locations}
                                                </select>
                                            </label>
                                        </div>
                                    </div>
                                    <div class="span2">
                                        <div class="label">
                                            <label>
                                                <p>{$lang.order_by}</p>
                                                <select name="order">
                                                    <option value="room">{$lang.room}</option>
                                                    <option value="guest">{$lang.guest}</option>
                                                </select>
                                            </label>
                                        </div>
                                    </div>
                                    <div class="span2">
                                        <div class="label">
                                            <label>
                                                <p>{$lang.time_period}</p>
                                                <input type="number" name="time_period" min="1" value="1">
                                                <p class="description">{$lang.days}</p>
                                            </label>
                                        </div>
                                    </div>
                                    <div class="span2">
                                        <div class="label">
                                            <label>
                                                <p>{$lang.addressed_to}</p>
                                                <select name="addressed_to">
                                                    <?php if (Functions::check_access(['{views_all}']) == true) : ?>
                                                    <option value="all">{$lang.all}</option>
                                                    <?php endif; ?>
                                                    <?php if (Functions::check_access(['{views_all}','{views_opportunity_areas}']) == true) : ?>
                                                    <option value="opportunity_areas">{$lang.opportunity_areas}</option>
                                                    <?php endif; ?>
                                                    <option value="me">{$lang.me}</option>
                                                </select>
                                            </label>
                                        </div>
                                    </div>
                                    <div class="span12 hidden">
                                        <div class="label">
                                            <div>
                                                <p>{$lang.addressed_to} ({$lang.opportunity_areas})</p>
                                                <div class="checkboxes">
                                                    <div class="checkbox">
                                    					<input type="checkbox" name="checked_all">
                                    					<span>{$lang.all}</span>
                                    				</div>
                                                    {$cbx_addressed_to_opportunity_areas}
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="span12">
                                        <div class="label">
                                            <div>
                                                <p>{$lang.data_displayed}</p>
                                                <div class="checkboxes">
                                                    <div class="checkbox">
                                    					<input type="checkbox" name="checked_all">
                                    					<span>{$lang.all}</span>
                                    				</div>
                                                    {$cbx_fields}
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </main>
                        <footer>
                            <div class="buttons text-center">
                                <a class="btn" data-action="new_report">{$lang.add}</a>
                            </div>
                        </footer>
                    </article>
                    <article>
                        <main class="tables">
                            <div class="table-container">
                                <table class="table">
                                    <thead>
                                        <tr>
                                            <th align="left">{$lang.name}</th>
                                            <th align="right" class="icon"></th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        {$tbl_reports}
                                    </tbody>
                                </table>
                            </div>
                        </main>
                    </article>
                </div>
            </section>
        </div>
    </div>
</main>
<section class="modal" data-modal="delete_report">
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
