<?php

defined('_EXEC') or die;

$this->dependencies->add(['js', '{$path.js}Voxes/generate.js']);
$this->dependencies->add(['other', '<script>menu_focus("voxes");</script>']);

?>

%{header}%
<main>
    <nav>
        <ul>
            <li><a href="/voxes"><i class="fas fa-heart"></i></a></li>
            <?php if (Functions::check_user_access(['{vox_reports_view}']) == true) : ?>
            <li><a href="/voxes/reports/generate" class="view"><i class="fas fa-file-invoice"></i></a></li>
            <?php endif; ?>
            <?php if (Functions::check_user_access(['{vox_reports_create}','{vox_reports_update}','{vox_reports_delete}']) == true) : ?>
            <li><a href="/voxes/reports"><i class="fas fa-file-invoice"></i></a></li>
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
            <form name="generate_report">
                <div class="row">
                    <div class="span2">
                        <div class="label">
                            <label>
                                <p>{$lang.report_type}</p>
                                <select name="filter">
                                    <option value="free">{$lang.free_report}</option>
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
                                    <option value="workorder">{$lang.workorder}</option>
                                </select>
                            </label>
                        </div>
                    </div>
                    <div class="span2">
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
                    <div class="span2">
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
                    <div class="span2">
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
                    <div class="span2">
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
                    <div class="span2">
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
                    <div class="span2">
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
                    <div class="span2">
                        <div class="label">
                            <label>
                                <p>{$lang.started_date}</p>
                                <input type="date" name="started_date" value="<?php echo Functions::get_current_date(); ?>" max="<?php echo Functions::get_current_date(); ?>" />
                            </label>
                        </div>
                    </div>
                    <div class="span2">
                        <div class="label">
                            <label>
                                <p>{$lang.end_date}</p>
                                <input type="date" name="end_date" value="<?php echo Functions::get_current_date(); ?>" max="<?php echo Functions::get_current_date(); ?>" />
                            </label>
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
                <a class="btn" data-action="generate_report">{$lang.generate}</a>
                <a class="btn hidden" data-action="print_report">{$lang.print}</a>
            </form>
            <div id="report" class="report"></div>
        </main>
    </article>
</main>
