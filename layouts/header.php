<?php defined('_EXEC') or die; ?>

<header class="topbar">
    <figure>
        <a href="/dashboard" data-desktop>
            <img src="{$path.images}logotype_white.png">
        </a>
        <a href="/dashboard" data-mobile>
            <img src="{$path.images}imagotype_white.png">
        </a>
    </figure>
    <nav>
        <ul>
            <li><a href="/voxes/create"><i class="fas fa-atom"></i></a></li>
            <li><a data-action="open_rightbar"><i class="fas fa-bars"></i></a></li>
        </ul>
    </nav>
    <fieldset>
        <div>
            <i class="fas fa-search"></i>
            <input type="text" name="search">
        </div>
    </fieldset>
</header>
<header class="rightbar">
    <div>
        <figure>
            <img src="<?php echo (!empty(Session::get_value('user')['avatar']) ? '{$path.uploads}' . Session::get_value('user')['avatar'] : '{$path.images}avatar.png'); ?>">
        </figure>
        <h2><?php echo Session::get_value('user')['firstname'] . ' ' . Session::get_value('user')['lastname']; ?></h2>
        <h3><?php echo Session::get_value('account')['name']; ?></h3>
    </div>
    <nav>
        <ul>
            <li target="dashboard"><a href="/dashboard">{$lang.dashboard}<i class="fas fa-tachometer-alt"></i></a></li>
        </ul>
    </nav>
    <?php if (Functions::check_account_access(['operation']) == true) : ?>
    <nav>
        <ul>
            <li><h4>{$lang.operation}</h4></li>
            <li target="voxes"><a href="/voxes">{$lang.voxes}<i class="fas fa-atom"></i></a></li>
            <?php if (Functions::check_user_access(['{voxes_stats_view}']) == true) : ?>
            <li target="voxes_stats"><a href="/voxes/stats">{$lang.stats}<i class="fas fa-chart-pie"></i></a></li>
            <?php endif; ?>
            <?php if (Functions::check_user_access(['{voxes_reports_create}','{voxes_reports_update}','{voxes_reports_deactivate}','{voxes_reports_activate}','{voxes_reports_delete}']) == true) : ?>
            <li target="voxes_reports_saved"><a href="/voxes/reports/saved">{$lang.reports_saved}<i class="fas fa-save"></i></a></li>
            <?php endif; ?>
            <?php if (Functions::check_user_access(['{voxes_reports_print}']) == true) : ?>
            <li target="voxes_reports_generate"><a href="/voxes/reports/generate">{$lang.generate_reports}<i class="fas fa-bug"></i></a></li>
            <?php endif; ?>
        </ul>
    </nav>
    <?php endif; ?>
    <?php if (Functions::check_account_access(['digital_menu']) == true AND Functions::check_user_access(['{menu_products_create}','{menu_products_update}','{menu_products_deactivate}','{menu_products_activate}','{menu_products_delete}','{menu_categories_create}','{menu_categories_update}','{menu_categories_deactivate}','{menu_categories_activate}','{menu_categories_delete}','{menu_topics_create}','{menu_topics_update}','{menu_topics_deactivate}','{menu_topics_activate}','{menu_topics_delete}','{menu_restaurants_create}','{menu_restaurants_update}','{menu_restaurants_deactivate}','{menu_restaurants_activate}','{menu_restaurants_delete}']) == true) : ?>
    <nav>
        <ul>
            <li><h4>{$lang.menu}</h4></li>
            <li target="menu_orders"><a href="/menu/orders">{$lang.menu_orders}<i class="fas fa-tasks"></i></a></li>
            <?php if (Functions::check_user_access(['{menu_products_create}','{menu_products_update}','{menu_products_deactivate}','{menu_products_activate}','{menu_products_delete}']) == true) : ?>
            <li target="menu_products"><a href="/menu/products">{$lang.products}<i class="fas fa-cocktail"></i></a></li>
            <?php endif; ?>
            <?php if (Functions::check_user_access(['{menu_categories_create}','{menu_categories_update}','{menu_categories_deactivate}','{menu_categories_activate}','{menu_categories_delete}']) == true) : ?>
            <li target="menu_categories"><a href="/menu/categories">{$lang.categories}<i class="fas fa-tag"></i></a></li>
            <?php endif; ?>
            <?php if (Functions::check_user_access(['{menu_topics_create}','{menu_topics_update}','{menu_topics_deactivate}','{menu_topics_activate}','{menu_topics_delete}']) == true) : ?>
            <li target="menu_topics"><a href="/menu/topics">{$lang.topics}<i class="fas fa-bookmark"></i></a></li>
            <?php endif; ?>
            <!-- <?php if (Functions::check_user_access(['{menu_restaurants_create}','{menu_restaurants_update}','{menu_restaurants_deactivate}','{menu_restaurants_activate}','{menu_restaurants_delete}']) == true) : ?>
            <li target="menu_restaurants"><a href="/menu/restaurants">{$lang.restaurants}<i class="fas fa-utensils"></i></a></li>
            <?php endif; ?> -->
        </ul>
    </nav>
    <?php endif; ?>
    <?php if (Functions::check_account_access(['surveys']) == true AND Functions::check_user_access(['{surveys_questions_create}','{surveys_questions_update}','{surveys_questions_deactivate}','{surveys_questions_activate}','{surveys_questions_delete}','{surveys_answers_view}','{surveys_stats_view}']) == true) : ?>
    <nav>
        <ul>
            <li><h4>{$lang.surveys}</h4></li>
            <?php if (Functions::check_user_access(['{surveys_questions_create}','{surveys_questions_update}','{surveys_questions_deactivate}','{surveys_questions_activate}','{surveys_questions_delete}']) == true) : ?>
            <li target="surveys_questions"><a href="/surveys/questions">{$lang.questions}<i class="fas fa-ghost"></i></a></li>
            <?php endif; ?>
            <?php if (Functions::check_user_access(['{surveys_answers_view}']) == true) : ?>
            <li target="surveys_raters"><a href="/surveys/answers/raters">{$lang.answers}<i class="fas fa-star"></i></a></li>
            <li target="surveys_comments"><a href="/surveys/answers/comments">{$lang.comments}<i class="fas fa-comment-alt"></i></a></li>
            <?php endif; ?>
            <?php if (Functions::check_user_access(['{surveys_stats_view}']) == true) : ?>
            <li target="surveys_stats"><a href="/surveys/stats">{$lang.stats}<i class="fas fa-chart-pie"></i></a></li>
            <?php endif; ?>
        </ul>
    </nav>
    <?php endif; ?>
    <nav>
        <ul>
            <li><h4>{$lang.administration}</h4></li>
            <?php if (Functions::check_account_access(['digital_menu','operation','surveys']) == true AND Functions::check_user_access(['{owners_create}','{owners_update}','{owners_deactivate}','{owners_activate}','{owners_delete}']) == true) : ?>
            <li target="owners"><a href="/owners">{$lang.owners}<i class="fas fa-shapes"></i></a></li>
            <?php endif; ?>
            <?php if (Functions::check_account_access(['operation']) AND Functions::check_user_access(['{opportunity_areas_create}','{opportunity_areas_update}','{opportunity_areas_deactivate}','{opportunity_areas_activate}','{opportunity_areas_delete}']) == true) : ?>
            <li target="opportunity_areas"><a href="/opportunity-areas">{$lang.opportunity_areas}<i class="fas fa-mask"></i></a></li>
            <?php endif; ?>
            <?php if (Functions::check_account_access(['operation']) AND Functions::check_user_access(['{opportunity_types_create}','{opportunity_types_update}','{opportunity_types_deactivate}','{opportunity_types_activate}','{opportunity_types_delete}']) == true) : ?>
            <li target="opportunity_types"><a href="/opportunity-types">{$lang.opportunity_types}<i class="fas fa-feather-alt"></i></a></li>
            <?php endif; ?>
            <?php if (Functions::check_account_access(['digital_menu','operation']) AND Functions::check_user_access(['{locations_create}','{locations_update}','{locations_deactivate}','{locations_activate}','{locations_delete}']) == true) : ?>
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
            <li target="my_profile"><a href="/my-profile">{$lang.my_profile}<i class="fas fa-user-astronaut"></i></a></li>
            <?php if (Functions::check_account_access(['digital_menu','operation','surveys']) == true) : ?>
            <li target="qrs"><a href="/qrs">{$lang.qrs}<i class="fas fa-qrcode"></i></a></li>
            <?php endif; ?>
            <li target="support"><a href="/technical-support">{$lang.technical_support}<i class="fas fa-envelope"></i></a></li>
            <?php if (Functions::check_user_access(['{account_update}']) == true) : ?>
            <li target="account"><a href="/account">{$lang.account}<i class="fas fa-cog"></i></a></li>
            <?php endif; ?>
        </ul>
    </nav>
    <nav>
        <ul>
            <li class="active"><a href="/logout">{$lang.logout}<i class="fas fa-power-off"></i></a></li>
        </ul>
    </nav>
</header>
