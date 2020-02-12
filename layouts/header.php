<?php defined('_EXEC') or die; ?>
<header class="main">
    <section class="topbar">
        <nav>
            <ul>
                <?php if (Functions::check_account_access(['operation']) == true) : ?>
                <li><a href="/voxes/create"><i class="fas fa-plus"></i>{$lang.new_vox}</a></li>
                <?php endif; ?>
                <li><a href="<?php echo ((Functions::check_user_access(['{account_update}']) == true) ?  '/account' : ''); ?>"><?php echo Session::get_value('account')['name']; ?></a></li>
                <li><a href="/profile" class="profile"><i class="fas fa-circle"></i><?php echo Session::get_value('user')['firstname'] . ' ' . Session::get_value('user')['lastname']; ?></a></li>
                <li><a href="/profile"><?php echo (!empty(Session::get_value('user')['avatar']) ? '<span><img src="{$path.uploads}' . Session::get_value('user')['avatar'] . '"></span>' : '<i class="fas fa-user-circle"></i>') ?></a></li>
                <li><a data-button-modal="logout"><i class="fas fa-power-off"></i></a></li>
                <li><a data-action="open-dash-menu"><i class="fas fa-ellipsis-v"></i></a></li>
            </ul>
        </nav>
    </section>
    <section class="menu">
        <figure>
            <img src="{$path.images}logotype-white.png">
        </figure>
        <nav class="main-menu">
            <ul>
                <li target="dashboard"><a href="/dashboard"><i class="fas fa-home"></i>{$lang.dashboard}</a></li>
                <?php if (Functions::check_account_access(['operation']) == true) : ?>
                <li target="voxes"><a href="/voxes"><i class="fas fa-heart"></i>{$lang.voxes}</a></li>
                <?php endif; ?>
                <?php if (Functions::check_account_access(['reputation']) == true AND Functions::check_user_access(['{survey_questions_create}','{survey_questions_update}','{survey_questions_deactivate}','{survey_questions_activate}','{survey_questions_delete}','{survey_answers_view}','{survey_stats_view}']) == true) : ?>
                <li target="surveys"><a href="/surveys"><i class="fas fa-star"></i>{$lang.surveys}</a></li>
                <?php endif; ?>
            </ul>
        </nav>
        <nav class="open-menu">
            <figure>
                <img src="{$path.uploads}<?php echo Session::get_value('account')['logotype']; ?>">
            </figure>
            <ul>
                <?php if (Session::get_value('account')['type'] == 'hotel' AND Functions::check_account_access(['operation','reputation']) == true AND Functions::check_user_access(['{rooms_create}','{rooms_update}','{rooms_delete}']) == true) : ?>
                <li><a href="/rooms">{$lang.rooms}<i class="fas fa-bed"></i></a></li>
                <?php endif; ?>
                <?php if (Session::get_value('account')['type'] == 'restaurant' AND Functions::check_account_access(['operation','reputation']) == true AND Functions::check_user_access(['{tables_create}','{tables_update}','{tables_delete}']) == true) : ?>
                <li><a href="/tables">{$lang.tables}<i class="fas fa-utensils"></i></a></li>
                <?php endif; ?>
                <?php if (Session::get_value('account')['type'] == 'others' AND Functions::check_account_access(['operation','reputation']) == true AND Functions::check_user_access(['{clients_create}','{clients_update}','{clients_delete}']) == true) : ?>
                <li><a href="/clients">{$lang.clients}<i class="fas fa-user-tie"></i></a></li>
                <?php endif; ?>
                <?php if (Functions::check_account_access(['operation']) AND Functions::check_user_access(['{opportunity_areas_create}','{opportunity_areas_update}','{opportunity_areas_delete}']) == true) : ?>
                <li><a href="/opportunityareas">{$lang.opportunity_areas}<i class="fas fa-compass"></i></a></li>
                <?php endif; ?>
                <?php if (Functions::check_account_access(['operation']) AND Functions::check_user_access(['{opportunity_types_create}','{opportunity_types_update}','{opportunity_types_delete}']) == true) : ?>
                <li><a href="/opportunitytypes">{$lang.opportunity_types}<i class="far fa-compass"></i></a></li>
                <?php endif; ?>
                <?php if (Functions::check_account_access(['operation']) AND Functions::check_user_access(['{locations_create}','{locations_update}','{locations_delete}']) == true) : ?>
                <li><a href="/locations">{$lang.locations}<i class="fas fa-map-marker-alt"></i></a></li>
                <?php endif; ?>
                <?php if (Session::get_value('account')['type'] == 'hotel' AND Functions::check_account_access(['operation']) AND Functions::check_user_access(['{guest_treatments_create}','{guest_treatments_update}','{guest_treatments_delete}']) == true) : ?>
                <li><a href="/guesttreatments">{$lang.guest_treatments}<i class="fas fa-smile"></i></a></li>
                <?php endif; ?>
                <?php if (Session::get_value('account')['type'] == 'hotel' AND Functions::check_account_access(['operation']) AND Functions::check_user_access(['{guest_types_create}','{guest_types_update}','{guest_types_delete}']) == true) : ?>
                <li><a href="/guesttypes">{$lang.guest_types}<i class="far fa-smile"></i></a></li>
                <?php endif; ?>
                <?php if (Session::get_value('account')['type'] == 'hotel' AND Functions::check_account_access(['operation']) AND Functions::check_user_access(['{reservation_statuses_create}','{reservation_statuses_update}','{reservation_statuses_delete}']) == true) : ?>
                <li><a href="/reservationstatuses">{$lang.reservation_statuses}<i class="fas fa-check"></i></a></li>
                <?php endif; ?>
                <?php if (Functions::check_user_access(['{users_create}','{users_update}','{users_restore_password}','{users_deactivate}','{users_activate}','{users_delete}']) == true) : ?>
                <li><a href="/users">{$lang.users}<i class="fas fa-users"></i></a></li>
                <?php endif; ?>
                <?php if (Functions::check_user_access(['{user_levels_create}','{user_levels_update}','{user_levels_delete}']) == true) : ?>
                <li><a href="/userlevels">{$lang.user_levels}<i class="fas fa-user-friends"></i></a></li>
                <?php endif; ?>
                <?php if (Functions::check_user_access(['{account_update}']) == true) : ?>
                <li><a href="/account">{$lang.account}<i class="far fa-user-circle"></i></a></li>
                <?php endif; ?>
            </ul>
        </nav>
    </section>
</header>
<section class="modal" data-modal="logout">
    <div class="content">
        <header>
            <h3>{$lang.logout}</h3>
        </header>
        <footer>
            <div class="action-buttons">
                <button class="btn btn-flat" button-close>{$lang.cancel}</button>
                <a href="/logout" class="btn">{$lang.accept}</a>
            </div>
        </footer>
    </div>
</section>
