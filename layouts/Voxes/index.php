<?php

defined('_EXEC') or die;

$this->dependencies->add(['js', '{$path.plugins}moment/moment.min.js']);
$this->dependencies->add(['js', '{$path.plugins}moment/moment-timezone-with-data.min.js']);
$this->dependencies->add(['js', '{$path.js}Voxes/index.js']);
$this->dependencies->add(['other', '<script>menu_focus("voxes");</script>']);

?>

%{header}%
<main class="dashboard">
    <section class="workspace">
        <div class="tbl_stl_1" data-table>
            <aside class="filter">
                <a data-action="get_filter" data-filter="type">
                    <?php if (Session::get_value('settings')['voxes']['filter']['type'] == 'all') : ?>
                    <i class="fas fa-ellipsis-h"></i>
                    <?php elseif (Session::get_value('settings')['voxes']['filter']['type'] == 'request') : ?>
                    <i class="fas fa-rocket"></i>
                    <?php elseif (Session::get_value('settings')['voxes']['filter']['type'] == 'incident') : ?>
                    <i class="fas fa-meteor"></i>
                    <?php elseif (Session::get_value('settings')['voxes']['filter']['type'] == 'workorder') : ?>
                    <i class="fas fa-bomb"></i>
                    <?php endif; ?>
                </a>
                <a class="<?php echo Session::get_value('settings')['voxes']['filter']['urgency']; ?>" data-action="get_filter" data-filter="urgency"><i class="fas fa-exclamation-circle"></i></a>
                <a data-action="get_filter" data-filter="date">
                    <?php if (Session::get_value('settings')['voxes']['filter']['date'] == 'up') : ?>
                    <i class="fas fa-clock"></i>
                    <?php elseif (Session::get_value('settings')['voxes']['filter']['date'] == 'down') : ?>
                    <i class="far fa-clock"></i>
                    <?php endif; ?>
                </a>
                <a data-action="get_filter" data-filter="status">
                    <?php if (Session::get_value('settings')['voxes']['filter']['status'] == 'open') : ?>
                    <i class="fas fa-toggle-on"></i>
                    <?php elseif (Session::get_value('settings')['voxes']['filter']['status'] == 'close') : ?>
                    <i class="fas fa-toggle-off"></i>
                    <?php endif; ?>
                </a>
            </aside>
            {$tbl_voxes}
        </div>
    </section>
    <section class="buttons">
        <div>
            <a data-button-modal="search"><i class="fas fa-search"></i></a>
            <a href="/voxes" class="active"><i class="fas fa-atom"></i></a>
            <a href="/voxes/create" class="active"><i class="fas fa-plus"></i></a>
            <?php if (Functions::check_user_access(['{voxes_stats_view}']) == true) : ?>
            <a href="/voxes/stats"><i class="fas fa-chart-pie"></i></a>
            <?php endif; ?>
            <?php if (Functions::check_user_access(['{voxes_reports_print}']) == true) : ?>
            <a href="/voxes/reports/print"><i class="fas fa-bug"></i></a>
            <?php elseif (Functions::check_user_access(['{voxes_reports_create}','{voxes_reports_update}','{voxes_reports_deactivate}','{voxes_reports_activate}','{voxes_reports_delete}']) == true) : ?>
            <a href="/voxes/reports"><i class="fas fa-bug"></i></a>
            <?php endif; ?>
        </div>
    </section>
</main>
