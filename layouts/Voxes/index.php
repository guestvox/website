<?php

defined('_EXEC') or die;

$this->dependencies->add(['js', '{$path.js}Voxes/index.js']);
$this->dependencies->add(['js', '{$path.plugins}moment/moment.min.js']);
$this->dependencies->add(['js', '{$path.plugins}moment/moment-timezone-with-data.min.js']);
$this->dependencies->add(['other', '<script>menu_focus("voxes");</script>']);

?>

%{header}%
<main class="dashboard">
    <section class="workspace">
        <div class="tbl-st-1">
            <div>
                <div>
                    <div class="item-1">
                        <figure>
                            <img src="{$path.images}avatar.png">
                        </figure>
                    </div>
                    <div class="item-2">
                        <h2>Trato y huésped</h2>
                        <h4>Habitación, mesa o cliente</h4>
                        <h6>Tiempo transcurrido</h6>
                    </div>
                    <div class="item-3">
                        <span>AO</span>
                        <span>TO</span>
                        <span>Ubicación</span>
                        <span>Urgencia</span>
                    </div>
                    <div class="item-4">
                        <span><i class="fas fa-users"></i></span>
                        <span><i class="fas fa-comment"></i></span>
                        <span><i class="fas fa-paperclip"></i></span>
                        <span><i class="fas fa-clock"></i></span>
                        <span><i class="fas fa-key"></i></span>
                        <span><i class="fas fa-spa"></i></span>
                    </div>
                </div>
            </div>
            <div>
                <div>
                    <div class="item-1">
                        <figure>
                            <img src="{$path.images}avatar.png">
                        </figure>
                    </div>
                    <div class="item-2">
                        <h2>Trato y huésped</h2>
                        <h4>Habitación, mesa o cliente</h4>
                        <h6>Tiempo transcurrido</h6>
                    </div>
                    <div class="item-3">
                        <span>AO</span>
                        <span>TO</span>
                        <span>Ubicación</span>
                        <span>Urgencia</span>
                    </div>
                    <div class="item-4">
                        <span><i class="fas fa-users"></i></span>
                        <span><i class="fas fa-comment"></i></span>
                        <span><i class="fas fa-paperclip"></i></span>
                        <span><i class="fas fa-clock"></i></span>
                        <span><i class="fas fa-key"></i></span>
                        <span><i class="fas fa-spa"></i></span>
                    </div>
                </div>
            </div>
        </div>
        <!-- <table id="tbl_voxes">
            <tbody>
                {$tbl_voxes}
            </tbody>
        </table> -->
    </section>
    <section class="buttons">
        <div>
            <a href="/voxes/create"><i class="fas fa-plus"></i></a>
            <a href="/voxes" class="active"><i class="fas fa-list-ul"></i></a>
            <?php if (Functions::check_user_access(['{vox_stats_view}']) == true) : ?>
            <a href="/voxes/stats"><i class="fas fa-chart-pie"></i></a>
            <?php endif; ?>
            <?php if (Functions::check_user_access(['{vox_reports_view}']) == true) : ?>
            <a href="/voxes/reports/generate"><i class="fas fa-file-invoice"></i></a>
            <?php endif; ?>
        </div>
    </section>
</main>
