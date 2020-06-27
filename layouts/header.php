<?php defined('_EXEC') or die; ?>

<header class="topbar">
    <figure>
        <img src="{$path.images}logotype_white.png">
    </figure>
    <nav>
        <ul>
            <?php if (Functions::check_account_access(['operation']) == true) : ?>
            <li><a href="/voxes/create"><i class="fas fa-plus"></i></a></li>
            <?php endif; ?>
            <?php if (Functions::check_account_access(['operation','reputation']) == true) : ?>
            <li><a href="/qr"><i class="fas fa-qrcode"></i></a></li>
            <?php endif; ?>
            <li><a data-action="open_rightbar"><i class="fas fa-bars"></i></a></li>
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
        <h3><?php echo Session::get_value('account')['name']; ?></h3>
    </div>
    <nav>
        <ul>
            <li target="dashboard"><a href="/dashboard">{$lang.dashboard}<i class="fas fa-tachometer-alt"></i></a></li>
            <?php if (Functions::check_account_access(['operation','reputation']) == true) : ?>
            <li target="qr"><a href="/qr">{$lang.qr}<i class="fas fa-qrcode"></i></a></li>
            <?php endif; ?>
            <li target="my_profile"><a href="/my-profile">{$lang.my_profile}<i class="fas fa-user-astronaut"></i></a></li>
        </ul>
    </nav>
    <nav>
        <ul>
            <?php if (Functions::check_account_access(['operation']) == true) : ?>
            <li target="voxes"><a href="/voxes">{$lang.voxes}<i class="fas fa-atom"></i></a></li>
            <?php endif; ?>
            <?php if (Session::get_value('account')['type'] == 'hotel' OR Session::get_value('account')['type'] == 'restaurant') : ?>
                <?php if (Functions::check_account_access(['operation']) == true) : ?>
                    <?php if (Functions::check_user_access(['{menu_products_create}','{menu_products_update}','{menu_products_deactivate}','{menu_products_activate}','{menu_products_delete}']) == true) : ?>
                    <li target="menu"><a href="/menu/products">{$lang.menu}<i class="fas fa-cocktail"></i></a></li>
                    <?php elseif (Functions::check_user_access(['{menu_orders_view}']) == true) : ?>
                    <li target="menu"><a href="/menu/orders">{$lang.menu}<i class="fas fa-cocktail"></i></a></li>
                    <?php elseif (Functions::check_user_access(['{menu_restaurants_create}','{menu_restaurants_update}','{menu_restaurants_deactivate}','{menu_restaurants_activate}','{menu_restaurants_delete}']) == true) : ?>
                    <li target="menu"><a href="/menu/restaurants">{$lang.menu}<i class="fas fa-cocktail"></i></a></li>
                    <?php endif; ?>
                <?php endif; ?>
            <?php endif; ?>
            <?php if (Functions::check_account_access(['reputation']) == true) : ?>
                <?php if (Functions::check_user_access(['{surveys_answers_view}']) == true) : ?>
                <li target="surveys"><a href="/surveys/answers">{$lang.surveys}<i class="fas fa-ghost"></i></a></li>
                <?php elseif (Functions::check_user_access(['{surveys_stats_view}']) == true) : ?>
                <li target="surveys"><a href="/surveys/stats">{$lang.surveys}<i class="fas fa-ghost"></i></a></li>
                <?php elseif (Functions::check_user_access(['{surveys_questions_create}','{surveys_questions_update}','{surveys_questions_deactivate}','{surveys_questions_activate}','{surveys_questions_delete}']) == true) : ?>
                <li target="surveys"><a href="/surveys/questions">{$lang.surveys}<i class="fas fa-ghost"></i></a></li>
                <?php endif; ?>
            <?php endif; ?>
        </ul>
    </nav>
    <nav>
        <ul>
            <?php if (Functions::check_account_access(['operation','reputation']) == true AND Functions::check_user_access(['{owners_create}','{owners_update}','{owners_deactivate}','{owners_activate}','{owners_delete}']) == true) : ?>
            <li target="owners"><a href="/owners">{$lang.owners}<i class="fas fa-shapes"></i></a></li>
            <?php endif; ?>
            <?php if (Functions::check_account_access(['operation']) AND Functions::check_user_access(['{opportunity_areas_create}','{opportunity_areas_update}','{opportunity_areas_deactivate}','{opportunity_areas_activate}','{opportunity_areas_delete}']) == true) : ?>
            <li target="opportunity_areas"><a href="/opportunity-areas">{$lang.opportunity_areas}<i class="fas fa-mask"></i></a></li>
            <?php endif; ?>
            <?php if (Functions::check_account_access(['operation']) AND Functions::check_user_access(['{opportunity_types_create}','{opportunity_types_update}','{opportunity_types_deactivate}','{opportunity_types_activate}','{opportunity_types_delete}']) == true) : ?>
            <li target="opportunity_types"><a href="/opportunity-types">{$lang.opportunity_types}<i class="fas fa-feather-alt"></i></a></li>
            <?php endif; ?>
            <?php if (Functions::check_account_access(['operation']) AND Functions::check_user_access(['{locations_create}','{locations_update}','{locations_deactivate}','{locations_activate}','{locations_delete}']) == true) : ?>
            <li target="locations"><a href="/locations">{$lang.locations}<i class="fas fa-map-marker-alt"></i></a></li>
            <?php endif; ?>
            <?php if (Session::get_value('account')['type'] == 'hotel' AND Functions::check_account_access(['operation']) AND Functions::check_user_access(['{guests_treatments_create}','{guests_treatments_update}','{guests_treatments_deactivate}','{guests_treatments_activate}','{guests_treatments_delete}']) == true) : ?>
            <li target="guests_treatments"><a href="/guests-treatments">{$lang.guests_treatments}<i class="fas fa-snowplow"></i></a></li>
            <?php endif; ?>
            <?php if (Session::get_value('account')['type'] == 'hotel' AND Functions::check_account_access(['operation']) AND Functions::check_user_access(['{guests_types_create}','{guests_types_update}','{guests_types_deactivate}','{guests_types_activate}','{guests_types_delete}']) == true) : ?>
            <li target="guests_types"><a href="/guests-types">{$lang.guests_types}<i class="fas fa-helicopter"></i></a></li>
            <?php endif; ?>
            <?php if (Session::get_value('account')['type'] == 'hotel' AND Functions::check_account_access(['operation']) AND Functions::check_user_access(['{reservations_statuses_create}','{reservations_statuses_update}','{reservations_statuses_deactivate}','{reservations_statuses_activate}','{reservations_statuses_delete}']) == true) : ?>
            <li target="reservations_statuses"><a href="/reservations-statuses">{$lang.reservations_statuses}<i class="fas fa-parachute-box"></i></a></li>
            <?php endif; ?>
            <?php if (Functions::check_user_access(['{users_create}','{users_update}','{users_restore_password}','{users_deactivate}','{users_activate}','{users_delete}']) == true) : ?>
            <li target="users"><a href="/users">{$lang.users}<i class="fas fa-users"></i></a></li>
            <?php endif; ?>
            <?php if (Functions::check_user_access(['{users_levels_create}','{users_levels_update}','{users_levels_deactivate}','{users_levels_activate}','{users_levels_delete}']) == true) : ?>
            <li target="users_levels"><a href="/users-levels">{$lang.users_levels}<i class="fas fa-user-friends"></i></a></li>
            <?php endif; ?>
        </ul>
    </nav>
    <nav>
        <ul>
            <?php if (Functions::check_user_access(['{account_update}']) == true) : ?>
            <li target="account"><a href="/account">{$lang.account}<i class="fas fa-igloo"></i></a></li>
            <?php endif; ?>
        </ul>
    </nav>
    <nav>
        <ul>
            <li class="active"><a href="/logout">{$lang.logout}<i class="fas fa-power-off"></i></a></li>
        </ul>
    </nav>
</header>
