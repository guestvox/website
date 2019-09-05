<?php defined('_EXEC') or die; ?>

<header class="main">
    <section class="topbar">
        <figure class="logotype">
            <a href="index.php"><img src="{$path.images}logotype-color.png"></a>
        </figure>
        <nav>
            <ul>
                <li>
                    <p class="user_data"><?php echo Session::get_value('user')['name'] . ' ' . Session::get_value('user')['lastname'] . '<i class="fas fa-circle"></i>' . Session::get_value('account')['name'] . '<i class="fas fa-circle"></i>' . Session::get_value('user')['user_level']['name']; ?></p>
                </li>
                <li>
                    <a href="/voxes/create" class="new_vox">{$lang.new_vox}</a>
                </li>
                <li>
                    <a data-button-modal="support" class="support">{$lang.request_support}</a>
                </li>
                <li>
                    <a data-button-modal="logout" class="logout">{$lang.logout}</a>
                </li>
            </ul>
        </nav>
    </section>
    <section class="menu">
        <nav>
            <ul>
                <li target="dashboard">
                    <a href="/dashboard">{$lang.dashboard}</a>
                </li>
                <li target="voxes">
                    <a href="/voxes">{$lang.voxes}</a>
                </li>
                <?php if (Functions::check_access(['{stats_view}']) == true) : ?>
                <li target="stats">
                    <a href="/stats">{$lang.stats}</a>
                </li>
                <?php endif; ?>
                <?php if (Functions::check_access(['{reports_generate}']) == true) : ?>
                <li target="reports">
                    <a href="/reports">{$lang.reports}</a>
                </li>
                <?php endif; ?>
                <?php if (Functions::check_access(['{opportunityareas_create}','{opportunityareas_update}','{opportunityareas_delete}','{opportunitytypes_create}','{opportunitytypes_update}','{opportunitytypes_delete}','{locations_create}','{locations_update}','{locations_delete}','{rooms_create}','{rooms_update}','{rooms_delete}','{guesttreatments_create}','{guesttreatments_update}','{guesttreatments_delete}','{guesttypes_create}','{guesttypes_update}','{guesttypes_delete}','{reservationstatus_create}','{reservationstatus_update}','{reservationstatus_delete}']) == true) : ?>
                <li target="settings">
                    <a href="/settings">{$lang.settings}</a>
                </li>
                <?php endif; ?>
                <?php if (Functions::check_access(['{users_create}','{users_update}','{users_restorepassword}','{users_deactivate}','{users_activate}','{users_delete}','{userlevels_create}','{userlevels_update}','{userlevels_delete}']) == true) : ?>
                <li target="users">
                    <a href="/users">{$lang.users}</a>
                </li>
                <?php endif; ?>

                <li target="survey">
                    <a href="/survey">Encuesta</a>
                </li>
                <!-- <li target="account">
                    <a href="/account">Mi cuenta</a>
                </li> -->
                <li target="profile">
                    <a href="/profile">Mi perfil</a>
                </li>
                <!-- <li target="tasks">
                    <a href="/tasks">Mis tareas</a>
                </li> -->
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
<section class="modal" data-modal="support">
    <div class="content">
        <header>
            <h3>{$lang.request_support}</h3>
        </header>
        <main>
            <form name="support">
                <div class="label">
                    <label>
                        <p>{$lang.how_can_we_help_you}</p>
                        <textarea name="message"></textarea>
                    </label>
                </div>
                <div class="label">
                    <label>
                        <p>{$lang.attachments}</p>
                        <input type="file" name="attachments[]" multiple />
                        <!-- <div class="box">
                            <input type="file" name="attachments[]" class="inputfile" data-multiple-caption="{count} {$lang.files_selected}" multiple />
                            <label for="input-file">
                                <span>{$lang.select_file}&hellip;</span>
                            </label>
                        </div> -->
                    </label>
                </div>
            </form>
        </main>
        <footer>
            <div class="action-buttons">
                <button class="btn btn-flat" button-close>{$lang.cancel}</button>
                <button class="btn" button-success>{$lang.accept}</button>
            </div>
        </footer>
    </div>
</section>
