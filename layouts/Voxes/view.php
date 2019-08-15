<?php

defined('_EXEC') or die;

$this->dependencies->add(['css', '{$path.plugins}fancy-box/source/jquery.fancybox.css']);
$this->dependencies->add(['js', '{$path.plugins}fancy-box/source/jquery.fancybox.js']);
$this->dependencies->add(['js', '{$path.plugins}fancy-box/source/jquery.fancybox.pack.js']);
// $this->dependencies->add(['css', '{$path.plugins}upload-file/input-file.css']);
// $this->dependencies->add(['js', '{$path.plugins}upload-file/input-file.js']);
$this->dependencies->add(['js', '{$path.js}Voxes/view.js']);
$this->dependencies->add(['other', '<script>menu_focus("voxes");</script>']);

?>

%{header}%
<main>
    <div id="multitabs" class="multi-tabs" data-tab-active="tab1">
        <ul>
            <li data-tab-target="tab1" class="active">{$lang.general}</li>
            <li data-tab-target="tab2">{$lang.changes_history}</li>
        </ul>
        <div class="tab" data-target="tab1">
            <section class="box-container">
                <div class="main">
                    <article>
                        <main class="tables">
                            <div class="viewer_data">
                                <div><h3>{$lang.type}:</h3><div>{$lang.{$type}}</div></div>
                                <div><h3>{$lang.room}:</h3><div>{$room}</div></div>
                                <div><h3>{$lang.opportunity_area}:</h3><div>{$opportunity_area}</div></div>
                                <div><h3>{$lang.opportunity_type}:</h3><div>{$opportunity_type}</div></div>
                                <div><h3>{$lang.date_hour}:</h3><div>{$started_date} {$lang.at} {$started_hour}</div></div>
                                <div><h3>{$lang.location}:</h3><div>{$location}</div></div>
                                {$div_cost}
                                {$div_urgency}
                                {$div_confidentiality}
                                {$div_observations}
                                {$div_subject}
                                {$div_description}
                                {$div_action_taken}
                            </div>
                        </main>
                    </article>
                    {$art_attachments}
                    {$art_comments}
                </div>
                <aside>
                    {$art_assigned_users}
                    {$art_viewed_by}
                    <article>
                        <main class="tables">
                            <ul class="info">
                                <li><strong>{$lang.guest}:</strong> {$guest_treatment} {$name} {$lastname}</li>
                                {$uli_guest_id}
                                {$uli_guest_type}
                                {$uli_reservation_number}
                                {$uli_reservation_status}
                                {$uli_check_in}
                                {$uli_check_out}
                            </ul>
                        </main>
                    </article>
                    <article>
                        <main class="tables">
                            <ul class="info">
                                <li><strong>Token:</strong> {$token}</li>
                                {$uli_created_user}
                                {$uli_edited_user}
                                {$uli_completed_user}
                                {$uli_reopened_user}
                                <li><strong>{$lang.status}:</strong> {$status}</li>
                                <li><strong>{$lang.origin}:</strong> {$origin}</li>
                            </ul>
                        </main>
                        <footer>
                            <div class="buttons text-center">
                                {$btn_edit}
                                {$btn_complete}
                                {$btn_reopen}
                            </div>
                        </footer>
                    </article>
                </aside>
            </section>
        </div>
        <div class="tab" data-target="tab2">
            <section class="box-container complete">
                <div class="main">
                    <article>
                        <main class="tables">
                            {$div_changes_history}
                        </main>
                    </article>
                </div>
            </section>
        </div>
    </div>
</main>
<section class="modal" data-modal="complete_vox">
    <div class="content">
        <header>
            <h3>{$lang.complete}</h3>
        </header>
        <footer>
            <div class="action-buttons">
                <button class="btn btn-flat" button-close>{$lang.cancel}</button>
                <button class="btn" button-success>{$lang.accept}</button>
            </div>
        </footer>
    </div>
</section>
<section class="modal" data-modal="reopen_vox">
    <div class="content">
        <header>
            <h3>{$lang.reopen}</h3>
        </header>
        <footer>
            <div class="action-buttons">
                <button class="btn btn-flat" button-close>{$lang.cancel}</button>
                <button class="btn" button-success>{$lang.accept}</button>
            </div>
        </footer>
    </div>
</section>
<section class="modal" data-modal="new_comment_vox">
    <div class="content">
        <header>
            <h3>{$lang.comment}</h3>
        </header>
        <main>
            <form name="new_comment_vox">
                <div class="label">
                    <label important>
                        <p>{$lang.message}</p>
                        <textarea name="message"></textarea>
                    </label>
                </div>
                <div class="label">
                    <label>
                        <p>{$lang.attachments}</p>
                        <input type="file" name="attachments[]" multiple />
                        <!-- <div class="box">
                            <input id="input-file" type="file" name="attachments[]" class="inputfile" data-multiple-caption="{count} {$lang.files_selected}" multiple />
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
                <button class="btn btn-flat" button-cancel>{$lang.cancel}</button>
                <button class="btn" button-success>{$lang.accept}</button>
            </div>
        </footer>
    </div>
</section>
