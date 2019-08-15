<?php

defined('_EXEC') or die;

$this->dependencies->add(['css', '{$path.plugins}date-picker/jquery-ui.min.css']);
$this->dependencies->add(['js', '{$path.plugins}date-picker/jquery-ui.min.js']);
$this->dependencies->add(['css', '{$path.plugins}time-picker/timepicker.css']);
$this->dependencies->add(['js', '{$path.plugins}time-picker/timepicker.js']);
$this->dependencies->add(['css', '{$path.plugins}chosen-select/chosen.css']);
$this->dependencies->add(['js', '{$path.plugins}chosen-select/chosen.jquery.js']);
// $this->dependencies->add(['css', '{$path.plugins}upload-file/input-file.css']);
// $this->dependencies->add(['js', '{$path.plugins}upload-file/input-file.js']);
// $this->dependencies->add(['js', '{$path.plugins}push/push.js']);
$this->dependencies->add(['js', '{$path.js}Voxes/create.js']);
$this->dependencies->add(['other', '<script>menu_focus("voxes");</script>']);

?>

%{header}%
<main>
    <section class="box-container complete">
        <div class="main">
            <article>
                <main>
                    <form name="new_vox">
                        <div class="row">
                            <div class="span3">
                                <div class="label">
                                    <label class="success">
                                        <p>{$lang.type}</p>
                                        <select name="type">
                                            <option value="request">{$lang.request}</option>
                                            <option value="incident">{$lang.incident}</option>
                                        </select>
                                    </label>
                                </div>
                            </div>
                            <div class="span3">
                                <div class="label">
                                    <label class="success">
                                        <p>{$lang.room}</p>
                                        <select name="room">
                                            <option value="" selected hidden>{$lang.choose}</option>
                                            {$opt_rooms}
                                        </select>
                                    </label>
                                </div>
                            </div>
                            <div class="span3">
                                <div class="label">
                                    <label important>
                                        <p>{$lang.opportunity_area}</p>
                                        <select name="opportunity_area">
                                            <option value="" selected hidden>{$lang.choose}</option>
                                            {$opt_opportunity_areas}
                                        </select>
                                    </label>
                                </div>
                            </div>
                            <div class="span3">
                                <div class="label">
                                    <label important>
                                        <p>{$lang.opportunity_type}</p>
                                        <select name="opportunity_type" disabled>
                                            <option value="" selected hidden>{$lang.choose}</option>
                                        </select>
                                    </label>
                                </div>
                            </div>
                            <div class="span3">
                                <div class="label">
                                    <label class="success">
                                        <p>{$lang.date}</p>
                                        <input type="text" name="started_date" class="datepicker" placeholder="{$lang.choose}" value="<?php echo Functions::get_current_date('Y-m-d'); ?>" />
                                        <p class="description">{$lang.what_date_need}</p>
                                        <p class="description hidden">{$lang.what_date_happened}</p>
                                    </label>
                                </div>
                            </div>
                            <div class="span3">
                                <div class="label">
                                    <label class="success">
                                        <p>{$lang.hour}</p>
                                        <div class="time__input">
                                            <input type="text" name="started_hour" class="timepicker" placeholder="{$lang.choose}" value="<?php echo Functions::get_current_hour(); ?>" />
                                        </div>
                                        <p class="description">{$lang.what_hour_need}</p>
                                        <p class="description hidden">{$lang.what_hour_happened}</p>
                                    </label>
                                </div>
                            </div>
                            <div class="span3">
                                <div class="label">
                                    <label important>
                                        <p>{$lang.location}</p>
                                        <select name="location">
                                            <option value="" selected hidden>{$lang.choose}</option>
                                            {$opt_locations}
                                        </select>
                                        <p class="description">{$lang.when_need}</p>
                                        <p class="description hidden">{$lang.when_happened}</p>
                                    </label>
                                </div>
                            </div>
                            <div class="span3 hidden">
                                <div class="label">
                                    <label class="success">
                                        <p>{$lang.cost}</p>
                                        <input type="number" name="cost" />
                                        <p class="description">{$lang.how_money_cost}</p>
                                    </label>
                                </div>
                            </div>
                            <div class="span3">
                                <div class="label">
                                    <label class="success">
                                        <p>{$lang.urgency}</p>
                                        <select name="urgency">
                                            <option value="low">{$lang.low}</option>
                                            <option value="medium" selected>{$lang.medium}</option>
                                            <option value="high">{$lang.high}</option>
                                        </select>
                                    </label>
                                </div>
                            </div>
                            <div class="span3 hidden">
                                <div class="label">
                                    <label class="success">
                                        <p>{$lang.confidentiality}</p>
                                        <div class="switch">
                                            <input id="confidentiality" type="checkbox" name="confidentiality" class="switch-checkbox">
                                            <label class="switch-label" for="confidentiality"></label>
                                        </div>
                                    </label>
                                </div>
                            </div>
                            <div class="span3">
                                <div class="label">
                                    <label class="success">
                                        <p>{$lang.observations}</p>
                                        <input type="text" name="observations" maxlength="120" />
                                        <p class="description">{$lang.max_120_characters}</p>
                                    </label>
                                </div>
                            </div>
                            <div class="span3 hidden">
                                <div class="label">
                                    <label class="success">
                                        <p>{$lang.subject}</p>
                                        <input type="text" name="subject" maxlength="120" />
                                        <p class="description">{$lang.max_120_characters}</p>
                                    </label>
                                </div>
                            </div>
                            <div class="span3">
                                <div class="label">
                                    <label class="success">
                                        <p>{$lang.assigned_users}</p>
                                        <select name="assigned_users[]" class="chosen-select" multiple>
                                            {$opt_users}
                                        </select>
                                        <p class="description">{$lang.assigned_users_keep_in_mind}</p>
                                    </label>
                                </div>
                            </div>
                            <div class="span6 hidden">
                                <div class="label">
                                    <label important>
                                        <p>{$lang.description}</p>
                                        <textarea name="description"></textarea>
                                        <p class="description">{$lang.what_happened} {$lang.dont_forget_mention_relevant_details}</p>
                                    </label>
                                </div>
                            </div>
                            <div class="span6 hidden">
                                <div class="label">
                                    <label class="success">
                                        <p>{$lang.action_taken}</p>
                                        <textarea name="action_taken"></textarea>
                                        <p class="description">{$lang.what_action_taken}</p>
                                    </label>
                                </div>
                            </div>
                            <div class="span3">
                                <div class="label">
                                    <label class="success">
                                        <p>{$lang.guest_treatment}</p>
                                        <select name="guest_treatment">
                                            <option value="" selected hidden>{$lang.choose}</option>
                                            {$opt_guest_treatments}
                                        </select>
                                    </label>
                                </div>
                            </div>
                            <div class="span3 hidden">
                                <div class="label">
                                    <label class="success">
                                        <p>{$lang.name}</p>
                                        <input type="text" name="name" />
                                    </label>
                                </div>
                            </div>
                            <div class="span3">
                                <div class="label">
                                    <label class="success">
                                        <p>{$lang.lastname}</p>
                                        <input type="text" name="lastname" />
                                    </label>
                                </div>
                            </div>
                            <div class="span2 hidden">
                                <div class="label">
                                    <label class="success">
                                        <p>{$lang.guest_id}</p>
                                        <input type="text" name="guest_id" />
                                    </label>
                                </div>
                            </div>
                            <div class="span2 hidden">
                                <div class="label">
                                    <label class="success">
                                        <p>{$lang.guest_type}</p>
                                        <select name="guest_type">
                                            <option value="" selected hidden>{$lang.choose}</option>
                                            {$opt_guest_types}
                                        </select>
                                    </label>
                                </div>
                            </div>
                            <div class="span3 hidden">
                                <div class="label">
                                    <label class="success">
                                        <p>{$lang.reservation_number}</p>
                                        <input type="text" name="reservation_number" />
                                    </label>
                                </div>
                            </div>
                            <div class="span3 hidden">
                                <div class="label">
                                    <label class="success">
                                        <p>{$lang.reservation_status}</p>
                                        <select name="reservation_status">
                                            <option value="" selected hidden>{$lang.choose}</option>
                                            {$opt_reservation_status}
                                        </select>
                                    </label>
                                </div>
                            </div>
                            <div class="span3 hidden">
                                <div class="label">
                                    <label class="success">
                                        <p>{$lang.check_in}</p>
                                        <input type="text" name="check_in" class="datepicker" placeholder="{$lang.choose}" />
                                    </label>
                                </div>
                            </div>
                            <div class="span3 hidden">
                                <div class="label">
                                    <label class="success">
                                        <p>{$lang.check_out}</p>
                                        <input type="text" name="check_out" class="datepicker" placeholder="{$lang.choose}" />
                                    </label>
                                </div>
                            </div>
                            <div class="span12">
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
                            </div>
                        </div>
                    </form>
                </main>
                <footer>
                    <div class="buttons text-center">
                        <a class="btn" data-action="new_vox">{$lang.add}</a>
                    </div>
                </footer>
            </article>
        </div>
    </section>
</main>
