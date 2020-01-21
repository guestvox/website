<?php

defined('_EXEC') or die;

$this->dependencies->add(['css', '{$path.plugins}data-tables/jquery.dataTables.min.css']);
$this->dependencies->add(['js', '{$path.plugins}data-tables/jquery.dataTables.min.js']);
$this->dependencies->add(['js', '{$path.js}Rooms/index.js']);
$this->dependencies->add(['other', '<script>menu_focus("other");</script>']);

?>

%{header}%
<main>
    <nav>
        <h2><i class="fas fa-bed"></i>{$lang.rooms}</h2>
    </nav>
    <article>
        <main>
            <div class="table">
                <aside>
                    <label>
                        <span><i class="fas fa-search"></i></span>
                        <input type="text" name="tbl_rooms_search">
                    </label>
                    <?php if (Session::get_value('account')['zaviapms']['status'] == true AND Functions::check_user_access(['{rooms_create}']) == true) : ?>
                    <a data-button-modal="download_rooms"><i class="fas fa-cloud-download-alt"></i></a>
                    <?php endif; ?>
                    <?php if (Functions::check_user_access(['{rooms_create}']) == true) : ?>
                    <a data-button-modal="new_room" class="new"><i class="fas fa-plus"></i></a>
                    <?php endif; ?>
                </aside>
                <table id="tbl_rooms">
                    <thead>
                        <tr>
                            <th align="left" width="100px">{$lang.token}</th>
                            <th align="left" width="100px">{$lang.number}</th>
                            <th align="left">{$lang.name}</th>
                            <th align="right" class="icon"></th>
                            <?php if (Functions::check_user_access(['{rooms_delete}']) == true) : ?>
                            <th align="right" class="icon"></th>
                            <?php endif; ?>
                            <?php if (Functions::check_user_access(['{rooms_update}']) == true) : ?>
                            <th align="right" class="icon"></th>
                            <?php endif; ?>
                        </tr>
                    </thead>
                    <tbody>
                        {$tbl_rooms}
                    </tbody>
                </table>
            </div>
        </main>
    </article>
</main>
{$mdl_new_room}
{$mdl_download_rooms}
<?php if (Functions::check_user_access(['{rooms_update}']) == true) : ?>
<section class="modal edit" data-modal="edit_room">
    <div class="content">
        <header>
            <h3>{$lang.edit}</h3>
        </header>
        <main>
            <form name="edit_room">
                <div class="row">
                    <div class="span12">
                        <div class="label">
                            <label>
                                <p>{$lang.number}</p>
                                <input type="number" name="number" />
                            </label>
                        </div>
                    </div>
                    <div class="span12">
                        <div class="label">
                            <label>
                                <p>{$lang.name}</p>
                                <input type="text" name="name" />
                            </label>
                        </div>
                    </div>
                </div>
            </form>
        </main>
        <footer>
            <div class="action-buttons">
                <button class="btn btn-flat" button-cancel>{$lang.cancel}</button>
                <button class="btn" button-success>{$lang.accept}</button>
            </div>
        </footer>
    </div>
</section>
<?php endif; ?>
<?php if (Functions::check_user_access(['{rooms_delete}']) == true) : ?>
<section class="modal delete" data-modal="delete_room">
    <div class="content">
        <header>
            <h3>{$lang.delete}</h3>
        </header>
        <footer>
            <div class="action-buttons">
                <button class="btn btn-flat" button-close>{$lang.cancel}</button>
                <button class="btn" button-success>{$lang.accept}</button>
            </div>
        </footer>
    </div>
</section>
<?php endif; ?>
