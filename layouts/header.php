<?php defined('_EXEC') or die; ?>
<header class="main">
    <section class="topbar">
        <figure>
            <img src="{$path.images}logotype-color.png">
        </figure>
        <nav>
            <ul>
                <li><a href="/profile"><?php echo '<i class="fas fa-circle"></i>' . Session::get_value('user')['firstname'] . ' ' . Session::get_value('user')['lastname']; ?></a></li>
                <?php if (Functions::check_account_access(['operation','reputation']) == true) : ?>
                <li><a href="/voxes/create" class="new">{$lang.new_vox}</a></li>
                <?php endif; ?>
                <li><a data-action="open-dash-menu"><i class="fas fa-ellipsis-v"></i></a></li>
            </ul>
        </nav>
    </section>
    <section class="menu">
        <nav>
            <ul>
                <li target="dashboard"><a href="/dashboard"><i class="fas fa-home"></i>{$lang.dashboard}</a></li>
                <?php if (Functions::check_account_access(['operation']) == true) : ?>
                <li target="voxes"><a href="/voxes"><i class="fas fa-heart"></i>{$lang.voxes}</a></li>
                <?php endif; ?>
                <?php if (Functions::check_account_access(['reputation']) == true) : ?>
                <li target="surveys"><a href="/surveys"><i class="fas fa-star"></i>Encuesta</a></li>
                <?php endif; ?>
                <li target="other"><a data-action="open-dash-menu"><i class="fas fa-ellipsis-h"></i></a></li>
            </ul>
        </nav>
        <nav>
            <figure>
                <img src="<?php echo (!empty(Session::get_value('user')['avatar']) ? '{$path.uploads}' . Session::get_value('user')['avatar'] : '{$path.images}avatar.png'); ?>">
            </figure>
            <h4><?php echo Session::get_value('user')['firstname'] . ' ' . Session::get_value('user')['lastname']; ?></h4>
            <ul>
                <?php if (Functions::check_account_access(['operation','reputation']) == true AND Functions::check_user_access(['{rooms_create}','{rooms_update}','{rooms_delete}']) == true) : ?>
                <li><a href="/rooms">{$lang.rooms}<i class="fas fa-bed"></i></a></li>
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
                <?php if (Functions::check_account_access(['operation']) AND Functions::check_user_access(['{reservation_statuses_create}','{reservation_statuses_update}','{reservation_statuses_delete}']) == true) : ?>
                <li><a href="/reservationstatuses">{$lang.reservation_statuses}<i class="fas fa-check"></i></a></li>
                <?php endif; ?>
                <?php if (Functions::check_account_access(['operation']) AND Functions::check_user_access(['{guest_treatments_create}','{guest_treatments_update}','{guest_treatments_delete}']) == true) : ?>
                <li><a href="/guesttreatments">{$lang.guest_treatments}<i class="fas fa-smile"></i></a></li>
                <?php endif; ?>
                <?php if (Functions::check_account_access(['operation']) AND Functions::check_user_access(['{guest_types_create}','{guest_types_update}','{guest_types_delete}']) == true) : ?>
                <li><a href="/guesttypes">{$lang.guest_types}<i class="far fa-smile"></i></a></li>
                <?php endif; ?>
                <?php if (Functions::check_user_access(['{users_create}','{users_update}','{users_restore_password}','{users_deactivate}','{users_activate}','{users_delete}']) == true) : ?>
                <li><a href="/users">{$lang.users}<i class="fas fa-users"></i></a></li>
                <?php endif; ?>
                <?php if (Functions::check_user_access(['{user_levels_create}','{user_levels_update}','{user_levels_delete}']) == true) : ?>
                <li><a href="/userlevels">{$lang.user_levels}<i class="fas fa-user-friends"></i></a></li>
                <?php endif; ?>
                <?php if (Functions::check_user_access(['{account_edit}']) == true) : ?>
                <li><a href="/account">{$lang.account}<i class="far fa-user-circle"></i></a></li>
                <?php endif; ?>
                <li><a href="/profile">{$lang.my_profile}<i class="fas fa-user-circle"></i></a></li>
                <li><a data-button-modal="logout">{$lang.logout}<i class="fas fa-sign-out-alt"></i></a></li>
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
