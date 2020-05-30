<?php

defined('_EXEC') or die;

$this->dependencies->add(['js', '{$path.plugins}moment/moment.min.js']);
$this->dependencies->add(['js', '{$path.plugins}moment/moment-timezone-with-data.min.js']);
$this->dependencies->add(['css', '{$path.plugins}fancy_box/jquery.fancybox.min.css']);
$this->dependencies->add(['js', '{$path.plugins}fancy_box/jquery.fancybox.min.js']);
$this->dependencies->add(['js', '{$path.js}Voxes/details.js']);
$this->dependencies->add(['other', '<script>menu_focus("voxes");</script>']);

?>

%{header}%
<main class="dashboard">
    <section class="workspace">
        <div class="vox_details">
            <div class="datas">
                {$spn_type}
                <h2>{$token}</h2>
                {$h1_name}
                {$spn_elapsed_time}
            </div>
            <div class="datas stl_1">
                <span><i class="fas fa-shapes"></i>{$owner}</span>
                <span><i class="fas fa-compass"></i>{$opportunity_area}</span>
                <span><i class="far fa-compass"></i>{$opportunity_type}</span>
                <span><i class="fas fa-map-marker-alt"></i>{$location}</span>
                <span><i class="fas fa-calendar-alt"></i>{$started_date}</span>
            </div>
            <div class="datas">
                {$p_observations}
                {$spn_subject}
                {$p_description}
                {$p_action_taken}
            </div>
        </div>
    </section>
    <section class="buttons">
        <div>
            <a href="/voxes"><i class="fas fa-heart"></i></a>
            {$btn_comment_vox}
            {$btn_complete_vox}
            {$btn_reopen_vox}
            {$btn_edit_vox}
        </div>
    </section>
</main>
{$mdl_comment_vox}
{$mdl_complete_vox}
{$mdl_reopen_vox}
