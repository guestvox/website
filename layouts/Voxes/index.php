<?php

defined('_EXEC') or die;

$this->dependencies->add(['js', '{$path.plugins}moment/moment.min.js']);
$this->dependencies->add(['js', '{$path.plugins}moment/moment-timezone-with-data.min.js']);
$this->dependencies->add(['js', '{$path.js}Voxes/index.js']);
$this->dependencies->add(['other', '<script>menu_focus("voxes");</script>']);
// $this->dependencies->add(['other', '<script src="https://js.pusher.com/7.0/pusher.min.js"></script>']);
// $this->dependencies->add(['other', '/webpushr-sw.js']);
// $this->dependencies->add(['other', '<!-- start webpushr code --> 
// <script>(function(w,d, s, id) {if(typeof(w.webpushr)!=="undefined") return;w.webpushr=w.webpushr||function(){(w.webpushr.q=w.webpushr.q||[]).push(arguments)};var js, fjs = d.getElementsByTagName(s)[0];js = d.createElement(s); js.id = id;js.src = "https://cdn.webpushr.com/app.min.js";fjs.parentNode.appendChild(js);}(window,document, "script", "webpushr-jssdk"));webpushr("setup",{"key":"BIcwQVszHXtzTGChI3oIkDIsXB8BwIG9jjPr4EVUhXGYPCKMS-ISacL3T79P9o-1l920bOVzyyiF5KWrwCc1KCM" });
// </script><!-- end webpushr code -->']);

?>

%{header}%
<main class="dashboard">
    <section class="workspace">
        <div class="tbl_stl_1" data-table>
            {$tbl_voxes}
        </div>
    </section>
    <section class="buttons">
        <div>
            <a data-button-modal="search"><i class="fas fa-search"></i></a>
            <a href="/voxes/create" class="new"><i class="fas fa-plus"></i></a>
            <a class="big new" data-button-modal="filter_voxes"><i class="fas fa-stream"></i><span>{$lang.filter}</span></a>
        </div>
    </section>
</main>
<section class="modal fullscreen" data-modal="filter_voxes">
    <div class="content">
        <main>
            <form name="filter_voxes">
                <div class="row">
                    <div class="span6">
                        <div class="label">
                            <label required>
                                <p>{$lang.type}</p>
                                <select name="type">
                                    <option value="all" <?php echo ((Session::get_value('settings')['voxes']['voxes']['filter']['type'] == 'all') ? 'selected' : ''); ?>>{$lang.all}</option>
                                    <option value="request" <?php echo ((Session::get_value('settings')['voxes']['voxes']['filter']['type'] == 'request') ? 'selected' : ''); ?>>{$lang.requests}</option>
                                    <option value="incident" <?php echo ((Session::get_value('settings')['voxes']['voxes']['filter']['type'] == 'incident') ? 'selected' : ''); ?>>{$lang.incidents}</option>
                                    <option value="workorder" <?php echo ((Session::get_value('settings')['voxes']['voxes']['filter']['type'] == 'workorder') ? 'selected' : ''); ?>>{$lang.workorders}</option>
                                </select>
                            </label>
                        </div>
                    </div>
                    <div class="span6">
                        <div class="label">
                            <label required>
                                <p>{$lang.owner}</p>
                                <select name="owner">
                                    <option value="all" <?php echo ((Session::get_value('settings')['voxes']['voxes']['filter']['owner'] == 'all') ? 'selected' : ''); ?>>{$lang.all}</option>
                                    {$opt_owners}
                                </select>
                            </label>
                        </div>
                    </div>
                    <div class="span6">
                        <div class="label">
                            <label required>
                                <p>{$lang.opportunity_area}</p>
                                <select name="opportunity_area">
                                    <option value="all" <?php echo ((Session::get_value('settings')['voxes']['voxes']['filter']['opportunity_area'] == 'all') ? 'selected' : ''); ?>>{$lang.all}</option>
                                    {$opt_opportunity_areas}
                                </select>
                            </label>
                        </div>
                    </div>
                    <div class="span6">
                        <div class="label">
                            <label required>
                                <p>{$lang.opportunity_type}</p>
                                <select name="opportunity_type">
                                    <option value="all" <?php echo ((Session::get_value('settings')['voxes']['voxes']['filter']['opportunity_type'] == 'all') ? 'selected' : ''); ?>>{$lang.all}</option>
                                    {$opt_opportunity_types}
                                </select>
                            </label>
                        </div>
                    </div>
                    <div class="span6">
                        <div class="label">
                            <label required>
                                <p>{$lang.location}</p>
                                <select name="location">
                                    <option value="all" <?php echo ((Session::get_value('settings')['voxes']['voxes']['filter']['location'] == 'all') ? 'selected' : ''); ?>>{$lang.all}</option>
                                    {$opt_locations}
                                </select>
                            </label>
                        </div>
                    </div>
                    <div class="span6">
                        <div class="label">
                            <label required>
                                <p>{$lang.urgency}</p>
                                <select name="urgency">
                                    <option value="all" <?php echo ((Session::get_value('settings')['voxes']['voxes']['filter']['urgency'] == 'all') ? 'selected' : ''); ?>>{$lang.all}</option>
                                    <option value="low" <?php echo ((Session::get_value('settings')['voxes']['voxes']['filter']['urgency'] == 'low') ? 'selected' : ''); ?>>{$lang.low}</option>
                                    <option value="medium" <?php echo ((Session::get_value('settings')['voxes']['voxes']['filter']['urgency'] == 'medium') ? 'selected' : ''); ?>>{$lang.medium}</option>
                                    <option value="high" <?php echo ((Session::get_value('settings')['voxes']['voxes']['filter']['urgency'] == 'high') ? 'selected' : ''); ?>>{$lang.high}</option>
                                </select>
                            </label>
                        </div>
                    </div>
                    <div class="span4">
                        <div class="label">
                            <label required>
                                <p>{$lang.assigned_to}</p>
                                <select name="assigned">
                                    <?php if (Functions::check_user_access(['{view_all}']) == true) : ?>
                                    <option value="all" <?php echo ((Session::get_value('settings')['voxes']['voxes']['filter']['assigned'] == 'all') ? 'selected' : ''); ?>>{$lang.alls}</option>
                                    <?php endif; ?>
                                    <?php if (Functions::check_user_access(['{view_all}','{view_opportunity_areas}']) == true) : ?>
                                    <option value="opportunity_areas" <?php echo ((Session::get_value('settings')['voxes']['voxes']['filter']['assigned'] == 'opportunity_areas') ? 'selected' : ''); ?>>{$lang.my_opportunity_areas}</option>
                                    <?php endif; ?>
                                    <option value="me" <?php echo ((Session::get_value('settings')['voxes']['voxes']['filter']['assigned'] == 'me') ? 'selected' : ''); ?>>{$lang.assigned_to_me}</option>
                                    {$opt_assigned}
                                </select>
                            </label>
                        </div>
                    </div>
                    <div class="span4">
                        <div class="label">
                            <label required>
                                <p>{$lang.order_by}</p>
                                <select name="order">
                                    <option value="date_up" <?php echo ((Session::get_value('settings')['voxes']['voxes']['filter']['order'] == 'date_up') ? 'selected' : ''); ?>>{$lang.date_up}</option>
                                    <option value="date_down" <?php echo ((Session::get_value('settings')['voxes']['voxes']['filter']['order'] == 'date_down') ? 'selected' : ''); ?>>{$lang.date_down}</option>
                                </select>
                            </label>
                        </div>
                    </div>
                    <div class="span4">
                        <div class="label">
                            <label required>
                                <p>{$lang.status}</p>
                                <select name="status">
                                    <option value="open" <?php echo ((Session::get_value('settings')['voxes']['voxes']['filter']['status'] == 'open') ? 'selected' : ''); ?>>{$lang.open}</option>
                                    <option value="close" <?php echo ((Session::get_value('settings')['voxes']['voxes']['filter']['status'] == 'close') ? 'selected' : ''); ?>>{$lang.close}</option>
                                </select>
                            </label>
                        </div>
                    </div>
                    <div class="span12">
                        <div class="buttons">
                            <a class="delete" button-close><i class="fas fa-times"></i></a>
                            <button type="submit" class="new"><i class="fas fa-check"></i></button>
                        </div>
                    </div>
                </div>
            </form>
        </main>
    </div>
</section>
<section class="modal fullscreen" data-modal="preview_vox">
    <div class="content">
        <main class="vox_details">
            <div class="stl_11">
            </div>
            <div class="buttons">
                <a class="new" button-close><i class="fas fa-check"></i></a>
            </div>
        </main>
    </div>
</section>
<section class="modal edit" data-modal="complete_vox">
    <div class="content">
        <footer>
            <a button-close><i class="fas fa-times"></i></a>
            <a button-success><i class="fas fa-check"></i></a>
        </footer>
    </div>
</section>
