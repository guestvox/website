<?php

defined('_EXEC') or die;

$this->dependencies->add(['js', '{$path.js}Voxes/generate.js']);
$this->dependencies->add(['other', '<script>menu_focus("voxes");</script>']);

?>

%{header}%
<main>
    <nav>
        <h2><i class="fas fa-file-invoice"></i>{$lang.reports}</h2>
        <ul>
            <li><a href="/voxes"><i class="fas fa-heart"></i></a></li>
            <?php if (Functions::check_user_access(['{vox_reports_view}']) == true) : ?>
            <li><a href="/voxes/reports/generate" class="view"><i class="fas fa-file-invoice"></i></a></li>
            <?php endif; ?>
            <?php if (Functions::check_user_access(['{vox_stats_view}']) == true) : ?>
            <li><a href="/voxes/stats"><i class="fas fa-chart-pie"></i></a></li>
            <?php endif; ?>
        </ul>
    </nav>
    <article>
        <main>
            <form name="generate_report">
                <div class="row">

                    
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
                <?php if (Functions::check_user_access(['{vox_reports_create}','{vox_reports_update}','{vox_reports_delete}']) == true) : ?>
                <a href="/voxes/reports" class="btn">{$lang.view_reports_list}</a>
                <?php endif; ?>
            </form>
            <div id="report" class="report"></div>
        </main>
    </article>
</main>
