<?php

defined('_EXEC') or die;

$this->dependencies->add(['css', '{$path.plugins}data-tables/jquery.dataTables.min.css']);
$this->dependencies->add(['js', '{$path.plugins}data-tables/jquery.dataTables.min.js']);
$this->dependencies->add(['js', '{$path.js}Voxes/reports.js']);
$this->dependencies->add(['other', '<script>menu_focus("voxes");</script>']);

?>

%{header}%
<main>
    <nav>
        <ul>
            <li><a href="/voxes"><i class="fas fa-heart"></i></a></li>
            <?php if (Functions::check_user_access(['{vox_reports_view}']) == true) : ?>
            <li><a href="/voxes/reports/generate"><i class="fas fa-file-invoice"></i></a></li>
            <?php endif; ?>
            <?php if (Functions::check_user_access(['{vox_reports_create}','{vox_reports_update}','{vox_reports_delete}']) == true) : ?>
            <li><a href="/voxes/reports" class="view"><i class="fas fa-file-invoice"></i></a></li>
            <?php endif; ?>
            <?php if (Functions::check_user_access(['{vox_stats_view}']) == true) : ?>
            <li><a href="/voxes/stats"><i class="fas fa-chart-pie"></i></a></li>
            <?php endif; ?>
        </ul>
    </nav>
    <article>
        <header>
            <h2><i class="fas fa-file-invoice"></i>{$lang.vox_reports}</h2>
        </header>
        <main>
            <div class="table">
                <aside>
                    <label>
                        <span><i class="fas fa-search"></i></span>
                        <input type="text" name="tbl_vox_reports_search">
                    </label>
                    <?php if (Functions::check_user_access(['{vox_reports_create}']) == true) : ?>
                    <a data-button-modal="new_vox_report" class="new"><i class="fas fa-plus"></i></a>
                    <?php endif; ?>
                </aside>
                <table id="tbl_vox_reports">
                    <thead>
                        <tr>
                            <th align="left">{$lang.name}</th>
                            <?php if (Functions::check_user_access(['{vox_reports_delete}']) == true) : ?>
                            <th align="right" class="icon"></th>
                            <?php endif; ?>
                            <?php if (Functions::check_user_access(['{vox_reports_update}']) == true) : ?>
                            <th align="right" class="icon"></th>
                            <?php endif; ?>
                        </tr>
                    </thead>
                    <tbody>
                        {$tbl_vox_reports}
                    </tbody>
                </table>
            </div>
        </main>
    </article>
</main>
<?php if (Functions::check_user_access(['{vox_reports_create}','{vox_reports_update}']) == true) : ?>
<section class="modal new" data-modal="new_vox_report">
    <div class="content">
        <header>
            <h3>{$lang.new}</h3>
        </header>
        <main>
            <form name="new_vox_report">
                <div class="row">
                    <div class="span12">
                        <div class="label">
                            <label>
                                <p>{$lang.name}</p>
                                <input type="text" name="name" />
                            </label>
                        </div>
                    </div>
                    <div class="span6">
                        <div class="label">
                            <label>
                                <p>{$lang.vox_type}</p>
                                <select name="type">
                                    <option value="all">{$lang.all}</option>
                                    <option value="request">{$lang.request}</option>
                                    <option value="incident">{$lang.incident}</option>
                                    <option value="workorder">{$lang.workorder}</option>
                                </select>
                            </label>
                        </div>
                    </div>
                    <div class="span6">
                        <div class="label">
                            <label>
                                <p>{$lang.opportunity_area}</p>
                                <select name="opportunity_area">
                                    <option value="">{$lang.all}</option>
                                    {$opt_opportunity_areas}
                                </select>
                            </label>
                        </div>
                    </div>
                    <div class="span6">
                        <div class="label">
                            <label>
                                <p>{$lang.opportunity_type}</p>
                                <select name="opportunity_type">
                                    <option value="">{$lang.all}</option>
                                </select>
                            </label>
                        </div>
                    </div>
                    <?php if (Session::get_value('account')['type'] == 'hotel') : ?>
                    <div class="span6">
                        <div class="label">
                            <label>
                                <p>{$lang.room}</p>
                                <select name="room">
                                    <option value="">{$lang.all}</option>
                                    {$opt_rooms}
                                </select>
                            </label>
                        </div>
                    </div>
                    <?php endif; ?>
                    <?php if (Session::get_value('account')['type'] == 'restaurant') : ?>
                    <div class="span6">
                        <div class="label">
                            <label>
                                <p>{$lang.table}</p>
                                <select name="table">
                                    <option value="">{$lang.all}</option>
                                    {$opt_tables}
                                </select>
                            </label>
                        </div>
                    </div>
                    <?php endif; ?>
                    <div class="span6">
                        <div class="label">
                            <label>
                                <p>{$lang.location}</p>
                                <select name="location">
                                    <option value="">{$lang.all}</option>
                                    {$opt_locations}
                                </select>
                            </label>
                        </div>
                    </div>
                    <div class="span6">
                        <div class="label">
                            <label>
                                <p>{$lang.order_by}</p>
                                <select name="order">
                                    <?php if (Session::get_value('account')['type'] == 'hotel') : ?>
                                    <option value="room">{$lang.room}</option>
                                    <?php endif; ?>
                                    <?php if (Session::get_value('account')['type'] == 'restaurant') : ?>
                                    <option value="table">{$lang.table}</option>
                                    <?php endif; ?>
                                    <option value="guest">{$lang.guest}</option>
                                </select>
                            </label>
                        </div>
                    </div>
                    <div class="span6">
                        <div class="label">
                            <label>
                                <p>{$lang.time_period} ({$lang.days})</p>
                                <input type="number" name="time_period" min="1" value="7">
                            </label>
                        </div>
                    </div>
                    <div class="span6">
                        <div class="label">
                            <label>
                                <p>{$lang.addressed_to}</p>
                                <select name="addressed_to">
                                    <?php if (Functions::check_user_access(['{view_all}']) == true) : ?>
                                    <option value="all">{$lang.all}</option>
                                    <?php endif; ?>
                                    <?php if (Functions::check_user_access(['{view_all}','{view_opportunity_areas}']) == true) : ?>
                                    <option value="opportunity_areas">{$lang.opportunity_areas}</option>
                                    <?php endif; ?>
                                    <option value="me">{$lang.me}</option>
                                </select>
                            </label>
                        </div>
                    </div>
                    <div class="span12 hidden">
                        <div class="label">
                            <label>
                                <p>{$lang.opportunity_areas}</p>
                            </label>
                            <div class="checkboxes">
                                <div>
                                    <div>
                                        <div>
                                            <input type="checkbox" name="checked_all">
                                            <span>{$lang.all}</span>
                                        </div>
                                        {$cbx_addressed_to_opportunity_areas}
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="span12">
                        <div class="label">
                            <div>
                                <p>{$lang.data_displayed}</p>
                                <div class="checkboxes">
                                    <div>
                                        <div>
                                            <div>
                                                <input type="checkbox" name="checked_all">
                                                <span>{$lang.all}</span>
                                            </div>
                                            {$cbx_fields}
                                        </div>
                                    </div>
                                </div>
                            </div>
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
<?php if (Functions::check_user_access(['{vox_reports_delete}']) == true) : ?>
<section class="modal delete" data-modal="delete_vox_report">
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
