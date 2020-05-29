<?php

defined('_EXEC') or die;

$this->dependencies->add(['js', '{$path.js}Voxes/create.js']);
$this->dependencies->add(['css', '{$path.plugins}chosen_select/chosen.css']);
$this->dependencies->add(['js', '{$path.plugins}chosen_select/chosen.jquery.js']);
$this->dependencies->add(['other', '<script>menu_focus("voxes");</script>']);

?>

%{header}%
<main class="dashboard">
    <section class="workspace">
        <form class="frm_vox" name="new_vox">
            <div class="row">
                <div class="tmp-1">
                    <label class="label-iconos">
                        <span class="span-pwa">{$lang.request}</span>
                        <span><i class="fas fa-spa"></i></span>
                        <input class="radio-pwa" type="radio" name="type" value="request" checked>
                    </label>
                    <label class="label-iconos">
                        <span class="span-pwa">{$lang.incident}</span>
                        <span><i class="fas fa-exclamation-triangle"></i></span>
                        <input class="radio-pwa" type="radio" name="type" value="incident">
                    </label>
                    <label class="label-iconos">
                        <span class="span-pwa">{$lang.workorder}</span>
                        <span><i class="fas fa-id-card-alt"></i></span>
                        <input class="radio-pwa" type="radio" name="type" value="workorder">
                    </label>
                </div>
                <?php if (Session::get_value('account')['type'] == 'hotel') : ?>
                <div class="span3">
                    <div class="label">
                        <label important>
                            <p>{$lang.room}</p>
                            <select class="input" name="room">
                                <option value="" selected hidden>{$lang.choose}</option>
                                {$opt_rooms}
                            </select>
                        </label>
                    </div>
                </div>
                <?php endif; ?>
                <?php if (Session::get_value('account')['type'] == 'restaurant') : ?>
                <div class="span3">
                    <div class="label">
                        <label important>
                            <p>{$lang.table}</p>
                            <select name="table">
                                <option value="" selected hidden>{$lang.choose}</option>
                                {$opt_tables}
                            </select>
                        </label>
                    </div>
                </div>
                <?php endif; ?>
                <?php if (Session::get_value('account')['type'] == 'others') : ?>
                <div class="span3">
                    <div class="label">
                        <label important>
                            <p>{$lang.client}</p>
                            <select name="client">
                                <option value="" selected hidden>{$lang.choose}</option>
                                {$opt_clients}
                            </select>
                        </label>
                    </div>
                </div>
                <?php endif; ?>
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
                        <label>
                            <p>{$lang.date}</p>
                            <input type="date" name="started_date" class="input" value="<?php echo Functions::get_current_date('Y-m-d'); ?>" />
                            <!-- <input type="text" name="started_date" class="datepicker" placeholder="{$lang.choose}" value="<?php echo Functions::get_current_date('Y-m-d'); ?>" /> -->
                        </label>
                    </div>
                </div>
                <div class="span3">
                    <div class="label">
                        <label>
                            <p>{$lang.hour}</p>
                            <input type="time" name="started_hour" class="input" value="<?php echo Functions::get_current_hour(); ?>" />
                            <!-- <div class="time__input">
                                <input type="text" name="started_hour" class="timepicker" placeholder="{$lang.choose}" value="<?php echo Functions::get_current_hour(); ?>" />
                            </div> -->
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
                        </label>
                    </div>
                </div>
                <div class="span3">
                    <div class="label">
                        <label>
                            <p>{$lang.urgency}</p>
                            <select class="input" name="urgency">
                                <option value="low">{$lang.low}</option>
                                <option value="medium" selected>{$lang.medium}</option>
                                <option value="high">{$lang.high}</option>
                            </select>
                        </label>
                    </div>
                </div>
                <div class="span3">
                    <div class="label">
                        <label>
                            <p>{$lang.observations} ({$lang.max_120_characters})</p>
                            <input class="input" type="text" name="observations" maxlength="120">
                        </label>
                    </div>
                </div>
                <div class="span3 hidden">
                    <div class="label">
                        <label>
                            <p>{$lang.confidentiality}</p>
                            <div class="switch">
                                <input id="confidentiality" type="checkbox" name="confidentiality" class="switch-input">
                                <label class="switch-label" for="confidentiality"></label>
                            </div>
                        </label>
                    </div>
                </div>
                <div class="span3 hidden">
                    <div class="label">
                        <label>
                            <p>{$lang.cost} (<?php echo Session::get_value('account')['currency']; ?>)</p>
                            <input class="input" type="number" name="cost" />
                        </label>
                    </div>
                </div>
                <div class="span3 hidden">
                    <div class="label">
                        <label>
                            <p>{$lang.subject} ({$lang.max_120_characters})</p>
                            <input class="input" type="text" name="subject" maxlength="120">
                        </label>
                    </div>
                </div>
                <div class="span3 hidden">
                    <div class="label">
                        <label>
                            <p>{$lang.description}</p>
                            <textarea class="input" name="description"></textarea>
                        </label>
                    </div>
                </div>
                <div class="span3 hidden">
                    <div class="label">
                        <label>
                            <p>{$lang.action_taken}</p>
                            <textarea class="input" name="action_taken"></textarea>
                        </label>
                    </div>
                </div>
                <?php if (Session::get_value('account')['type'] == 'hotel') : ?>
                <div class="span3">
                    <div class="label">
                        <label>
                            <p>{$lang.guest_treatment}</p>
                            <select class="input" name="guest_treatment">
                                <option value="" selected hidden>{$lang.choose}</option>
                                {$opt_guest_treatments}
                            </select>
                        </label>
                    </div>
                </div>
                <?php endif; ?>
                <div class="span3">
                    <div class="label">
                        <label>
                            <p>{$lang.firstname}</p>
                            <input class="input" type="text" name="firstname" />
                        </label>
                    </div>
                </div>
                <div class="span3">
                    <div class="label">
                        <label>
                            <p>{$lang.lastname}</p>
                            <input class="input" type="text" name="lastname" />
                        </label>
                    </div>
                </div>
                <?php if (Session::get_value('account')['type'] == 'hotel') : ?>
                <div class="span3 hidden">
                    <div class="label">
                        <label>
                            <p>{$lang.guest_type}</p>
                            <select class="input" name="guest_type">
                                <option value="" selected hidden>{$lang.choose}</option>
                                {$opt_guest_types}
                            </select>
                        </label>
                    </div>
                </div>
                <div class="span3 hidden">
                    <div class="label">
                        <label>
                            <p>{$lang.guest_id}</p>
                            <input class="input" type="text" name="guest_id" />
                        </label>
                    </div>
                </div>
                <div class="span3 hidden">
                    <div class="label">
                        <label>
                            <p>{$lang.reservation_number}</p>
                            <input class="input" type="text" name="reservation_number" />
                        </label>
                    </div>
                </div>
                <div class="span3 hidden">
                    <div class="label">
                        <label>
                            <p>{$lang.reservation_statuses}</p>
                            <select class="input" name="reservation_status">
                                <option class="input" value="" selected hidden>{$lang.choose}</option>
                                {$opt_reservation_statuses}
                            </select>
                        </label>
                    </div>
                </div>
                <div class="span3 hidden">
                    <div class="label">
                        <label>
                            <p>{$lang.check_in}</p>
                            <input class="input" type="date" name="check_in" />
                            <!-- <input type="text" name="check_in" class="datepicker" placeholder="{$lang.choose}" /> -->
                        </label>
                    </div>
                </div>
                <div class="span3 hidden">
                    <div class="label">
                        <label>
                            <p>{$lang.check_out}</p>
                            <input class="input" type="date" name="check_out" />
                            <!-- <input type="text" name="check_out" class="datepicker" placeholder="{$lang.choose}" /> -->
                        </label>
                    </div>
                </div>
                <?php endif; ?>
                <div class="span3">
                    <div class="label">
                        <label>
                            <p>{$lang.assigned_users}</p>
                            <select class="input" name="assigned_users[]" class="chosen-select" multiple>
                                {$opt_users}
                            </select>
                        </label>
                    </div>
                </div>
                <div class="span3">
                    <div class="label">
                        <label>
                            <p>{$lang.attachments}</p>
                            <input class="input" type="file" name="attachments[]" multiple />
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
        <a data-action="new_vox">Aceptar</a>
    </section>
    <section class="buttons">
        <div>
            <a href="/voxes/create" class="active"><i class="fas fa-plus"></i></a>
            <a href="/voxes"><i class="fas fa-list-ul"></i></a>
            <?php if (Functions::check_user_access(['{vox_stats_view}']) == true) : ?>
            <a href="/voxes/stats"><i class="fas fa-chart-pie"></i></a>
            <?php endif; ?>
            <?php if (Functions::check_user_access(['{vox_reports_view}']) == true) : ?>
            <a href="/voxes/reports/generate"><i class="fas fa-file-invoice"></i></a>
            <?php endif; ?>
        </div>
    </section>
</main>
