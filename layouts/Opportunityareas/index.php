<?php

defined('_EXEC') or die;

$this->dependencies->add(['css', '{$path.plugins}data-tables/jquery.dataTables.min.css']);
$this->dependencies->add(['js', '{$path.plugins}data-tables/jquery.dataTables.min.js']);
$this->dependencies->add(['js', '{$path.js}Opportunityareas/index.js']);
$this->dependencies->add(['other', '<script>menu_focus("other");</script>']);

?>

%{header}%
<main>
    <nav>
        <h2><i class="fas fa-compass"></i>{$lang.opportunity_areas}</h2>
    </nav>
    <article>
        <main>
            <div class="table">
                <aside>
                    <label>
                        <span><i class="fas fa-search"></i></span>
                        <input type="text" name="tbl_opportunity_areas_search">
                    </label>
                    <?php if (Functions::check_user_access(['{opportunity_areas_create}']) == true) : ?>
                    <a data-button-modal="new_opportunity_area" class="new"><i class="fas fa-plus"></i></a>
                    <?php endif; ?>
                </aside>
                <table id="tbl_opportunity_areas">
                    <thead>
                        <tr>
                            <th align="left">{$lang.name}</th>
                            <th align="left" class="flag">{$lang.request}</th>
                            <th align="left" class="flag">{$lang.incident}</th>
                            <th align="left" class="flag">{$lang.workorder}</th>
                            <th align="left" class="flag">{$lang.public}</th>
                            <?php if (Functions::check_user_access(['{opportunity_areas_delete}']) == true) : ?>
                            <th align="right" class="icon"></th>
                            <?php endif; ?>
                            <?php if (Functions::check_user_access(['{opportunity_areas_update}']) == true) : ?>
                            <th align="right" class="icon"></th>
                            <?php endif; ?>
                        </tr>
                    </thead>
                    <tbody>
                        {$tbl_opportunity_areas}
                    </tbody>
                </table>
            </div>
        </main>
    </article>
</main>
<?php if (Functions::check_user_access(['{opportunity_areas_create}','{opportunity_areas_update}']) == true) : ?>
<section class="modal new" data-modal="new_opportunity_area">
    <div class="content">
        <header>
            <h3>{$lang.new}</h3>
        </header>
        <main>
            <form name="new_opportunity_area">
                <div class="row">
                    <div class="span6">
                        <div class="label">
                            <label>
                                <p>(ES) {$lang.name}</p>
                                <input type="text" name="name_es" />
                            </label>
                        </div>
                    </div>
                    <div class="span6">
                        <div class="label">
                            <label>
                                <p>(EN) {$lang.name}</p>
                                <input type="text" name="name_en" />
                            </label>
                        </div>
                    </div>
                    <div class="span3">
                        <div class="label">
                            <label>
                                <p>{$lang.request}</p>
                                <div class="switch">
                                    <input id="oa-request" type="checkbox" name="request" class="switch-input">
                                    <label class="switch-label" for="oa-request"></label>
                                </div>
                            </label>
                        </div>
                    </div>
                    <div class="span3">
                        <div class="label">
                            <label>
                                <p>{$lang.incident}</p>
                                <div class="switch">
                                    <input id="oa-incident" type="checkbox" name="incident" class="switch-input">
                                    <label class="switch-label" for="oa-incident"></label>
                                </div>
                            </label>
                        </div>
                    </div>
                    <div class="span3">
                        <div class="label">
                            <label>
                                <p>{$lang.workorder}</p>
                                <div class="switch">
                                    <input id="oa-workorder" type="checkbox" name="workorder" class="switch-input">
                                    <label class="switch-label" for="oa-workorder"></label>
                                </div>
                            </label>
                        </div>
                    </div>
                    <div class="span3">
                        <div class="label">
                            <label>
                                <p>{$lang.public}</p>
                                <div class="switch">
                                    <input id="oa-public" type="checkbox" name="public" class="switch-input">
                                    <label class="switch-label" for="oa-public"></label>
                                </div>
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
<?php if (Functions::check_user_access(['{opportunity_areas_delete}']) == true) : ?>
<section class="modal delete" data-modal="delete_opportunity_area">
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
