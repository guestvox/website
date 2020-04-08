<?php defined('_EXEC') or die; ?>


<header class="topbar">
    <figure>
        <a href="/dashboard"><img src="{$path.images}logotype-white.png"></a>
    </figure>
    <nav>
        <ul>
            <li><a><i class="fas fa-search"></i></a></li>
            <li><a data-action="open-rightbar"><i class="fas fa-bars"></i></a></li>
        </ul>
    </nav>
</header>
<header class="rightbar">
    <div>
        <figure>
            <?php if (!empty(Session::get_value('user')['avatar'])) : ?>
            <img src="{$path.images}avatar.png">
            <?php else: ?>
            <img src="{$path.images}avatar.png">
            <?php endif; ?>
        </figure>
        <h2><?php echo Session::get_value('user')['firstname'] . ' ' . Session::get_value('user')['lastname']; ?></h2>
        <h4><?php echo Session::get_value('account')['name']; ?></h4>
    </div>
    <nav>
        <ul>
            <li><a href="/dashboard" target="dashboard">{$lang.dashboard}<i class="fas fa-home"></i></a></li>
            <?php if (Functions::check_account_access(['operation']) == true) : ?>
            <li><a href="/voxes" target="voxes">{$lang.voxes}<i class="fas fa-heart"></i></a></li>
            <?php endif; ?>
            <?php if (Functions::check_account_access(['reputation']) == true AND Functions::check_user_access(['{survey_questions_create}','{survey_questions_update}','{survey_questions_deactivate}','{survey_questions_activate}','{survey_questions_delete}','{survey_answers_view}','{survey_stats_view}']) == true) : ?>
            <li><a href="/surveys" target="surveys">{$lang.surveys}<i class="fas fa-star"></i></a></li>
            <?php endif; ?>
        </ul>
    </nav>
    <nav>
        <ul>
            <?php if (Session::get_value('account')['type'] == 'hotel' AND Functions::check_account_access(['operation','reputation']) == true AND Functions::check_user_access(['{rooms_create}','{rooms_update}','{rooms_delete}']) == true) : ?>
            <li><a href="/rooms" target="rooms">{$lang.rooms}<i class="fas fa-bed"></i></a></li>
            <?php endif; ?>
            <?php if (Session::get_value('account')['type'] == 'restaurant' AND Functions::check_account_access(['operation','reputation']) == true AND Functions::check_user_access(['{tables_create}','{tables_update}','{tables_delete}']) == true) : ?>
            <li><a href="/tables" target="tables">{$lang.tables}<i class="fas fa-utensils"></i></a></li>
            <?php endif; ?>
            <?php if (Session::get_value('account')['type'] == 'others' AND Functions::check_account_access(['operation','reputation']) == true AND Functions::check_user_access(['{clients_create}','{clients_update}','{clients_delete}']) == true) : ?>
            <li><a href="/clients" target="clients">{$lang.clients}<i class="fas fa-user-tie"></i></a></li>
            <?php endif; ?>
            <?php if (Functions::check_account_access(['operation']) AND Functions::check_user_access(['{opportunity_areas_create}','{opportunity_areas_update}','{opportunity_areas_delete}']) == true) : ?>
            <li><a href="/opportunityareas" target="opportunityareas">{$lang.opportunity_areas}<i class="fas fa-compass"></i></a></li>
            <?php endif; ?>
            <?php if (Functions::check_account_access(['operation']) AND Functions::check_user_access(['{opportunity_types_create}','{opportunity_types_update}','{opportunity_types_delete}']) == true) : ?>
            <li><a href="/opportunitytypes" target="opportunitytypes">{$lang.opportunity_types}<i class="far fa-compass"></i></a></li>
            <?php endif; ?>
            <?php if (Functions::check_account_access(['operation']) AND Functions::check_user_access(['{locations_create}','{locations_update}','{locations_delete}']) == true) : ?>
            <li><a href="/locations" target="locations">{$lang.locations}<i class="fas fa-map-marker-alt"></i></a></li>
            <?php endif; ?>
            <?php if (Session::get_value('account')['type'] == 'hotel' AND Functions::check_account_access(['operation']) AND Functions::check_user_access(['{guest_treatments_create}','{guest_treatments_update}','{guest_treatments_delete}']) == true) : ?>
            <li><a href="/guesttreatments" target="guesttreatments">{$lang.guest_treatments}<i class="fas fa-smile"></i></a></li>
            <?php endif; ?>
            <?php if (Session::get_value('account')['type'] == 'hotel' AND Functions::check_account_access(['operation']) AND Functions::check_user_access(['{guest_types_create}','{guest_types_update}','{guest_types_delete}']) == true) : ?>
            <li><a href="/guesttypes" target="guesttypes">{$lang.guest_types}<i class="far fa-smile"></i></a></li>
            <?php endif; ?>
            <?php if (Session::get_value('account')['type'] == 'hotel' AND Functions::check_account_access(['operation']) AND Functions::check_user_access(['{reservation_statuses_create}','{reservation_statuses_update}','{reservation_statuses_delete}']) == true) : ?>
            <li><a href="/reservationstatuses" target="reservationstatuses">{$lang.reservation_statuses}<i class="fas fa-check"></i></a></li>
            <?php endif; ?>
            <?php if (Session::get_value('account')['type'] == 'hotel' AND Functions::check_account_access(['operation']) AND Functions::check_user_access(['{menu_create}','{menu_update}','{menu_delete}']) == true) : ?>
            <li><a href="/menu" target="menu">{$lang.menu}<i class="fas fa-concierge-bell"></i></a></li>
            <?php endif; ?>
            <?php if (Functions::check_user_access(['{users_create}','{users_update}','{users_restore_password}','{users_deactivate}','{users_activate}','{users_delete}']) == true) : ?>
            <li><a href="/users" target="users">{$lang.users}<i class="fas fa-users"></i></a></li>
            <?php endif; ?>
            <?php if (Functions::check_user_access(['{user_levels_create}','{user_levels_update}','{user_levels_delete}']) == true) : ?>
            <li><a href="/userlevels" target="userlevels">{$lang.user_levels}<i class="fas fa-user-friends"></i></a></li>
            <?php endif; ?>
            <?php if (Functions::check_user_access(['{account_update}']) == true) : ?>
            <li><a href="/account" target="account">{$lang.account}<i class="far fa-user-circle"></i></a></li>
            <?php endif; ?>
        </ul>
    </nav>
    <nav>
        <ul>
            <li><a href="/logout">{$lang.logout}<i class="fas fa-power-off"></i></a></li>
        </ul>
    </nav>
</header>
