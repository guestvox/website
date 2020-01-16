<?php

defined('_EXEC') or die;

$this->dependencies->add(['css', '{$path.plugins}data-tables/jquery.dataTables.min.css']);
$this->dependencies->add(['js', '{$path.plugins}data-tables/jquery.dataTables.min.js']);
$this->dependencies->add(['js', '{$path.js}Dashboard/index.js']);
$this->dependencies->add(['other', '<script>menu_focus("dashboard");</script>']);

?>

%{header}%
<main class="dashboard">
    <?php if (Functions::check_account_access(['operation']) == true) : ?>
    <article>
        <header>
            <h2><i class="fas fa-heart"></i>{$lang.voxes_unresolve}</h2>
        </header>
        <main>
            <div class="table">
                <aside>
                    <label>
                        <span><i class="fas fa-search"></i></span>
                         <input type="text" name="tbl_voxes_unresolve_search">
                    </label>
                </aside>
                <table id="tbl_voxes_unresolve">
                    <thead>
                        <tr>
                            <th align="left" class="icon">{$lang.abr_type}</th>
                            <?php if (Session::get_value('account')['type'] == 'hotel') : ?>
                            <th align="left">{$lang.abr_room}</th>
                            <?php endif; ?>
                            <?php if (Session::get_value('account')['type'] == 'restaurant') : ?>
                            <th align="left">{$lang.abr_table}</th>
                            <?php endif; ?>
                            <th align="left">{$lang.abr_guest}</th>
                            <th align="left">{$lang.abr_opportunity_area}</th>
                            <th align="left">{$lang.abr_opportunity_type}</th>
                            <th align="left">{$lang.abr_location}</th>
                            <th align="left">{$lang.abr_started_date}</th>
                            <th align="left">{$lang.abr_elapsed_time}</th>
                            <th align="right" class="icon"></th>
                            <th align="right" class="icon"></th>
                            <th align="right" class="icon"></th>
                            <th align="right" class="icon"></th>
                            <th align="right" class="icon"></th>
                        </tr>
                    </thead>
                    <tbody>
                        {$tbl_voxes_unresolve}
                    </tbody>
                </table>
            </div>
            <div class="counters">
                <h2>{$voxes_unresolve_noreaded}<span>{$lang.noreaded}</span></h2>
                <h2>{$voxes_unresolve_readed}<span>{$lang.readed}</span></h2>
                <h2>{$voxes_unresolve_today}<span>{$lang.today}</span></h2>
                <h2>{$voxes_unresolve_week}<span>{$lang.this_week}</span></h2>
                <h2>{$voxes_unresolve_month}<span>{$lang.this_month}</span></h2>
                <h2>{$voxes_unresolve_total}<span>{$lang.total}</span></h2>
            </div>
        </main>
        <footer>
            <a href="/voxes">{$lang.view_all}</a>
        </footer>
    </article>
    <?php endif; ?>
</main>
