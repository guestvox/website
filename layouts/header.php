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
            <img src="{$path.uploads}<?php echo Session::get_value('user')['avatar']; ?>">
            <?php else: ?>
            <img src="{$path.images}avatar.png">
            <?php endif; ?>
        </figure>
        <h2><?php echo Session::get_value('user')['firstname'] . ' ' . Session::get_value('user')['lastname']; ?></h2>
        <h4><?php echo Session::get_value('account')['name']; ?></h4>
    </div>
    <nav>
        <ul>
            <li target="dashboard"><a href="/dashboard">{$lang.dashboard}<i class="fas fa-home"></i></a></li>
            <?php if (Functions::check_account_access(['operation']) == true) : ?>
            <li target="voxes"><a href="/voxes">{$lang.voxes}<i class="fas fa-heart"></i></a></li>
            <?php endif; ?>
            <?php if (Functions::check_account_access(['reputation']) == true AND Functions::check_user_access(['{survey_questions_create}','{survey_questions_update}','{survey_questions_deactivate}','{survey_questions_activate}','{survey_questions_delete}','{survey_answers_view}','{survey_stats_view}']) == true) : ?>
            <li target="surveys"><a href="/surveys">{$lang.surveys}<i class="fas fa-star"></i></a></li>
            <?php endif; ?>
        </ul>
    </nav>
    <nav>
        <ul>
            <?php if (Functions::check_account_access(['operation','reputation']) == true AND Functions::check_user_access(['{owners_create}','{owners_update}','{owners_delete}']) == true) : ?>
            <li target="owners"><a href="/owners">{$lang.owners}<i class="fas fa-user-tie"></i></a></li>
            <?php endif; ?>
            <?php if (Functions::check_account_access(['operation']) AND Functions::check_user_access(['{opportunity_areas_create}','{opportunity_areas_update}','{opportunity_areas_delete}']) == true) : ?>
            <li target="opportunityareas"><a href="/opportunityareas">{$lang.opportunity_areas}<i class="fas fa-compass"></i></a></li>
            <?php endif; ?>
            <?php if (Functions::check_account_access(['operation']) AND Functions::check_user_access(['{opportunity_types_create}','{opportunity_types_update}','{opportunity_types_delete}']) == true) : ?>
            <li target="opportunitytypes"><a href="/opportunitytypes">{$lang.opportunity_types}<i class="far fa-compass"></i></a></li>
            <?php endif; ?>
            <?php if (Functions::check_account_access(['operation']) AND Functions::check_user_access(['{locations_create}','{locations_update}','{locations_delete}']) == true) : ?>
            <li target="locations"><a href="/locations">{$lang.locations}<i class="fas fa-map-marker-alt"></i></a></li>
            <?php endif; ?>
            <?php if (Session::get_value('account')['type'] == 'hotel' AND Functions::check_account_access(['operation']) AND Functions::check_user_access(['{guest_treatments_create}','{guest_treatments_update}','{guest_treatments_delete}']) == true) : ?>
            <li target="guesttreatments"><a href="/guesttreatments">{$lang.guest_treatments}<i class="fas fa-smile"></i></a></li>
            <?php endif; ?>
            <?php if (Session::get_value('account')['type'] == 'hotel' AND Functions::check_account_access(['operation']) AND Functions::check_user_access(['{guest_types_create}','{guest_types_update}','{guest_types_delete}']) == true) : ?>
            <li target="guesttypes"><a href="/guesttypes">{$lang.guest_types}<i class="far fa-smile"></i></a></li>
            <?php endif; ?>
            <?php if (Session::get_value('account')['type'] == 'hotel' AND Functions::check_account_access(['operation']) AND Functions::check_user_access(['{reservation_statuses_create}','{reservation_statuses_update}','{reservation_statuses_delete}']) == true) : ?>
            <li target="reservationstatuses"><a href="/reservationstatuses">{$lang.reservation_statuses}<i class="fas fa-check"></i></a></li>
            <?php endif; ?>
            <?php if (Functions::check_user_access(['{users_create}','{users_update}','{users_restore_password}','{users_deactivate}','{users_activate}','{users_delete}']) == true) : ?>
            <li target="users"><a href="/users">{$lang.users}<i class="fas fa-users"></i></a></li>
            <?php endif; ?>
            <?php if (Functions::check_user_access(['{user_levels_create}','{user_levels_update}','{user_levels_delete}']) == true) : ?>
            <li target="userlevels"><a href="/userlevels">{$lang.user_levels}<i class="fas fa-user-friends"></i></a></li>
            <?php endif; ?>
            <?php if (Functions::check_user_access(['{account_update}']) == true) : ?>
            <li target="account"><a href="/account">{$lang.account}<i class="far fa-user-circle"></i></a></li>
            <?php endif; ?>
        </ul>
    </nav>
    <nav>
        <ul>
            <li class="active"><a href="/logout">{$lang.logout}<i class="fas fa-power-off"></i></a></li>
        </ul>
    </nav>
</header>
