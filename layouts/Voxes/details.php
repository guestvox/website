<?php

defined('_EXEC') or die;

$this->dependencies->add(['js', '{$path.plugins}moment/moment.min.js']);
$this->dependencies->add(['js', '{$path.plugins}moment/moment-timezone-with-data.min.js']);
$this->dependencies->add(['js', '{$path.js}Voxes/details.js']);
$this->dependencies->add(['other', '<script>menu_focus("voxes");</script>']);

?>

%{header}%
<main class="dashboard gry dkp">
    <section class="workspace">
        <div class="vox_details">
            <div class="stl_1">
                {$spn_type}
                {$h3_elapsed_time}
                {$h1_name}
                <h2>{$token}</h2>
            </div>
            <div class="stl_2">
                <span><i class="fas fa-shapes"></i>{$owner}</span>
                <span><i class="fas fa-mask"></i>{$opportunity_area}</span>
                <span><i class="fas fa-feather-alt"></i>{$opportunity_type}</span>
                <span><i class="fas fa-map-marker-alt"></i>{$location}</span>
                <span><i class="fas fa-calendar-alt"></i>{$started_date}</span>
                {$spn_cost}
            </div>
            <div class="stl_3">
                {$p_observations}
                {$p_subject}
                {$p_description}
                {$p_action_taken}
            </div>
            {$div_confidentiality}
            <div class="stl_5">
                {$spn_guest}
            </div>
            <div class="stl_6">
                {$btn_get_attachments}
                {$btn_get_assigned_users}
                {$btn_get_viewed_by}
                {$btn_get_comments}
            </div>
            <div class="stl_7">
                <figure>
                    <img src="{$created_user_avatar}">
                </figure>
                <h4>{$created_user_name}</h4>
                <span>{$created_user_username}</span>
                <span>{$lang.created_at} {$created_date}</span>
            </div>
            {$div_actions}
            <div class="stl_9">
                <a data-button-modal="get_changes_history"><i class="fas fa-history"></i></a>
            </div>
        </div>
    </section>
    <section class="buttons">
        <div>
            {$btn_comment_vox}
            <a href="/voxes" class="delete"><i class="fas fa-times"></i></a>
            {$btn_edit_vox}
            {$btn_complete_vox}
            {$btn_reopen_vox}
        </div>
    </section>
</main>
{$mdl_get_attachments}
{$mdl_get_assigned_users}
{$mdl_get_viewed_by}
{$mdl_get_comments}
<section class="modal fullscreen" data-modal="get_changes_history">
    <div class="content">
        <main class="vox_details">
            <div class="stl_11">
                {$div_changes_history}
            </div>
            <div class="buttons">
                <a button-close><i class="fas fa-check"></i></a>
            </div>
        </main>
    </div>
</section>
{$mdl_comment_vox}
{$mdl_complete_vox}
{$mdl_reopen_vox}
