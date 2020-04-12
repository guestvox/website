
<!-- Dashboard -->
<main class="dashboard">
    <?php if (Functions::check_account_access(['operation']) == true) : ?>
    <nav>
        <h2><i class="fas fa-heart"></i>{$lang.voxes_unresolve}</h2>
    </nav>
    <article>
        <main>
            <div class="table">
                <aside>
                    <label>
                        <span><i class="fas fa-search"></i></span>
                         <input type="text" name="tbl_voxes_unresolve_search">
                    </label>
                </aside>
                <span>{$_tmp_time_zone}</span>
                <table id="tbl_voxes_unresolve">
                    <thead>
                        <tr>
                            <th align="left" class="icon">{$lang.abr_type}</th>
                            <?php if (Session::get_value('account')['type'] == 'hotel') : ?>
                            <th align="left">{$lang.abr_room} | {$lang.abr_department}</th>
                            <th align="left">{$lang.abr_guest}</th>
                            <?php endif; ?>
                            <?php if (Session::get_value('account')['type'] == 'restaurant') : ?>
                            <th align="left">{$lang.abr_table} | {$lang.abr_department}</th>
                            <th align="left">{$lang.abr_name}</th>
                            <?php endif; ?>
                            <?php if (Session::get_value('account')['type'] == 'others') : ?>
                            <th align="left">{$lang.abr_client} | {$lang.abr_department}</th>
                            <th align="left">{$lang.abr_name}</th>
                            <?php endif; ?>
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
