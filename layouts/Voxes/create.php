<?php

defined('_EXEC') or die;

$this->dependencies->add(['css', '{$path.plugins}chosen_select/chosen.css']);
$this->dependencies->add(['js', '{$path.plugins}chosen_select/chosen.jquery.js']);
$this->dependencies->add(['js', '{$path.js}Voxes/create.js']);
$this->dependencies->add(['other', '<script>menu_focus("voxes");</script>']);

?>

%{header}%
<main class="dashboard">
    <section class="workspace">
        <form name="new_vox">
            <div class="row">
                <div class="span12">
                    <div class="tabers">
                        <div>
                            <input id="rqrd" type="radio" name="type" value="request" checked>
                            <label for="rwrd"><i class="fas fa-rocket"></i></label>
                        </div>
                        <div>
                            <input id="inrd" type="radio" name="type" value="incident">
                            <label for="inrd"><i class="fas fa-meteor"></i></label>
                        </div>
                        <div>
                            <input id="wkrd" type="radio" name="type" value="workorder">
                            <label for="wkrd"><i class="fas fa-bomb"></i></label>
                        </div>
                    </div>
                </div>
                <div class="span3">
                    <div class="label">
                        <label required>
                            <p>{$lang.owner}</p>
                            <select name="owner">
                                <option value="" selected hidden>{$lang.choose}</option>
                                {$opt_owners}
                            </select>
                        </label>
                    </div>
                </div>
                <div class="span3">
                    <div class="label">
                        <label required>
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
                        <label required>
                            <p>{$lang.opportunity_type}</p>
                            <select name="opportunity_type" disabled>
                                <option value="" selected hidden>{$lang.choose_opportunity_area}</option>
                            </select>
                        </label>
                    </div>
                </div>
                <div class="span3">
                    <div class="label">
                        <label required>
                            <p>{$lang.date}</p>
                            <input type="date" name="started_date" value="<?php echo Functions::get_current_date('Y-m-d'); ?>">
                        </label>
                    </div>
                </div>
                <div class="span3">
                    <div class="label">
                        <label required>
                            <p>{$lang.hour}</p>
                            <input type="time" name="started_hour" value="<?php echo Functions::get_current_hour(); ?>">
                        </label>
                    </div>
                </div>
                <div class="span3">
                    <div class="label">
                        <label required>
                            <p>{$lang.location}</p>
                            <select name="location">
                                <option value="" selected hidden>{$lang.choose}</option>
                                {$opt_locations}
                            </select>
                        </label>
                    </div>
                </div>
                <div class="span3 hidden">
                    <div class="label">
                        <label unrequired>
                            <p>{$lang.cost} <?php echo Session::get_value('account')['currency']; ?></p>
                            <input type="number" name="cost">
                        </label>
                    </div>
                </div>
                <div class="span3">
                    <div class="label">
                        <label required>
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
                        <label unrequired>
                            <p>{$lang.confidentiality}</p>
                            <div class="switch">
                                <input id="cfsw" type="checkbox" name="confidentiality" data-switcher>
                                <label for="cfsw"></label>
                            </div>
                        </label>
                    </div>
                </div>
                <div class="span3">
                    <div class="label">
                        <label unrequired>
                            <p>{$lang.assigned_users}</p>
                            <select name="assigned_users[]" class="chosen-select" multiple>
                                {$opt_users}
                            </select>
                        </label>
                    </div>
                </div>
                <div class="span3">
                    <div class="label">
                        <label unrequired>
                            <p>{$lang.observations}</p>
                            <input type="text" name="observations">
                        </label>
                    </div>
                </div>
                <div class="span6 hidden">
                    <div class="label">
                        <label unrequired>
                            <p>{$lang.subject}</p>
                            <input type="text" name="subject">
                        </label>
                    </div>
                </div>
                <div class="span6 hidden">
                    <div class="label">
                        <label unrequired>
                            <p>{$lang.description}</p>
                            <textarea name="description"></textarea>
                        </label>
                    </div>
                </div>
                <div class="span6 hidden">
                    <div class="label">
                        <label unrequired>
                            <p>{$lang.action_taken}</p>
                            <textarea name="action_taken"></textarea>
                        </label>
                    </div>
                </div>
                <?php if (Session::get_value('account')['type'] == 'hotel') : ?>
                <div class="span3">
                    <div class="label">
                        <label unrequired>
                            <p>{$lang.guest_treatment}</p>
                            <select name="guest_treatment">
                                <option value="" selected>{$lang.empty} ({$lang.choose})</option>
                                {$opt_guests_treatments}
                            </select>
                        </label>
                    </div>
                </div>
                <?php endif; ?>
                <div class="span3">
                    <div class="label">
                        <label unrequired>
                            <p>{$lang.firstname}</p>
                            <input type="text" name="firstname">
                        </label>
                    </div>
                </div>
                <div class="span3">
                    <div class="label">
                        <label unrequired>
                            <p>{$lang.lastname}</p>
                            <input type="text" name="lastname">
                        </label>
                    </div>
                </div>
                <?php if (Session::get_value('account')['type'] == 'hotel') : ?>
                <div class="span3 hidden">
                    <div class="label">
                        <label unrequired>
                            <p>{$lang.guest_id}</p>
                            <input type="text" name="guest_id">
                        </label>
                    </div>
                </div>
                <div class="span3 hidden">
                    <div class="label">
                        <label unrequired>
                            <p>{$lang.guest_type}</p>
                            <select name="guest_type">
                                <option value="" selected>{$lang.empty} ({$lang.choose})</option>
                                {$opt_guests_types}
                            </select>
                        </label>
                    </div>
                </div>
                <div class="span3 hidden">
                    <div class="label">
                        <label unrequired>
                            <p>{$lang.reservation_number}</p>
                            <input type="text" name="reservation_number">
                        </label>
                    </div>
                </div>
                <div class="span3 hidden">
                    <div class="label">
                        <label unrequired>
                            <p>{$lang.reservation_status}</p>
                            <select name="reservation_status">
                                <option value="" selected>{$lang.empty} ({$lang.choose})</option>
                                {$opt_reservations_statuses}
                            </select>
                        </label>
                    </div>
                </div>
                <div class="span3 hidden">
                    <div class="label">
                        <label unrequired>
                            <p>{$lang.check_in}</p>
                            <input type="date" name="check_in">
                        </label>
                    </div>
                </div>
                <div class="span3 hidden">
                    <div class="label">
                        <label unrequired>
                            <p>{$lang.check_out}</p>
                            <input type="date" name="check_out">
                        </label>
                    </div>
                </div>
                <?php endif; ?>
                <div class="span12">
                    <div class="stl_3" data-uploader="multiple">
                        <div data-preview>
                            <div data-image>
                                <i class="fas fa-file-image"></i>
                                <span><strong>0</strong>{$lang.images}</span>
                            </div>
                            <div data-pdf>
                                <i class="fas fa-file-pdf"></i>
                                <span><strong>0</strong>{$lang.pdf}</span>
                            </div>
                            <div data-word>
                                <i class="fas fa-file-word"></i>
                                <span><strong>0</strong>{$lang.word}</span>
                            </div>
                            <div data-excel>
                                <i class="fas fa-file-excel"></i>
                                <span><strong>0</strong>{$lang.excel}</span>
                            </div>
                        </div>
                        <a data-select><i class="fas fa-cloud-upload-alt"></i></a>
                        <input type="file" name="attachments[]" accept="image/*, application/pdf, application/vnd.ms-word, application/vnd.openxmlformats-officedocument.wordprocessingml.document, application/vnd.ms-excel, application/vnd.openxmlformats-officedocument.spreadsheetml.sheet" multiple data-upload>
                    </div>
                </div>
            </div>
        </form>
    </section>
    <section class="buttons">
        <div>
            <a href="/voxes" class="active delete"><i class="fas fa-times"></i></a>
            <a class="active" data-action="new_vox"><i class="fas fa-check"></i></a>
        </div>
    </section>
</main>
