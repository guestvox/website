<?php

defined('_EXEC') or die;

$this->dependencies->add(['css', '{$path.plugins}fancy_box/jquery.fancybox.min.css']);
$this->dependencies->add(['js', '{$path.plugins}fancy_box/jquery.fancybox.min.js']);
// $this->dependencies->add(['css', '{$path.plugins}upload-file/input-file.css']);
// $this->dependencies->add(['js', '{$path.plugins}upload-file/input-file.js']);
$this->dependencies->add(['js', '{$path.plugins}moment/moment.min.js']);
$this->dependencies->add(['js', '{$path.plugins}moment/moment-timezone-with-data.min.js']);
$this->dependencies->add(['js', '{$path.js}Voxes/details.js']);
$this->dependencies->add(['other', '<script>menu_focus("voxes");</script>']);

?>

%{header}%
<main>
    <nav>
        <h2><i class="fas fa-heart"></i>{$lang.details}</h2>
        <ul>
            <li><a href="/voxes/view/details/{$id}" class="view"><i class="fas fa-info-circle"></i></a></li>
            <li><a href="/voxes/view/history/{$id}"><i class="fas fa-history"></i></a></li>
        </ul>
    </nav>
    <article>
        <main>
            <div class="vox-details">
                <div>
                    <div class="datas">
                        <h4>{$lang.type}: {$lang.{$type}}</h4>
                        {$h4_room}
                        {$h4_table}
                        {$h4_client}
                        <h4>{$lang.opportunity_area}: {$opportunity_area}</h4>
                        <h4>{$lang.opportunity_type}: {$opportunity_type}</h4>
                        <h4>{$lang.date_hour}: {$started_date} {$lang.at} {$started_hour}</h4>
                        <h4>{$lang.location}: {$location}</h4>
                        {$h4_cost}
                        {$h4_urgency}
                        {$h4_confidentiality}
                        {$h4_observations}
                        {$h4_subject}
                        {$h4_description}
                        {$h4_action_taken}
                        {$h4_date_hour}
                    </div>
                    {$div_attachments}
                    {$div_comments}
                </div>
                <aside>
                    {$div_assigned_users}
                    {$div_viewed_by}
                    <div class="datas">
                        {$h4_guest}
                        {$h4_guest_id}
                        {$h4_guest_type}
                        {$h4_reservation_number}
                        {$h4_reservation_status}
                        {$h4_check_in}
                        {$h4_check_out}
                    </div>
                    <div class="datas">
                        <h4>Token: {$token}</h4>
                        {$h4_created_user}
                        {$h4_edited_user}
                        {$h4_completed_user}
                        {$h4_reopened_user}
                        <h4>{$lang.status}: {$status}</h4>
                        <h4>{$lang.origin}: {$origin}</h4>
                    </div>
                    <div class="actions">
                        {$btn_reopen}
                        {$btn_complete}
                        {$btn_edit}
                        {$btn_comment}
                    </div>
                </aside>
            </div>
        </main>
    </article>
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
<section class="modal" data-modal="new_vox_comment" name="{$type}">
    <div class="content">
        <header>
            <h3>{$lang.comment}</h3>
        </header>
        <main>
            <form name="new_vox_comment">
                <div class="label" id="cost">
                    <label>
                        <p>{$lang.cost} (<?php echo Session::get_value('account')['currency']; ?>)</p>
                        <input type="number" name="cost" />
                    </label>
                </div>
                <div class="label">
                    <label>
                        <p>{$lang.message}</p>
                        <textarea name="message"></textarea>
                    </label>
                </div>
                <div class="label">
                    <label>
                        <p>{$lang.attachments}</p>
                        <input type="file" name="attachments[]" multiple />
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
