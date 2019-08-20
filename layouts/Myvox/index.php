<?php

defined('_EXEC') or die;

$this->dependencies->add(['css', '{$path.plugins}date-picker/jquery-ui.min.css']);
$this->dependencies->add(['js', '{$path.plugins}date-picker/jquery-ui.min.js']);
$this->dependencies->add(['css', '{$path.plugins}time-picker/timepicker.css']);
$this->dependencies->add(['js', '{$path.plugins}time-picker/timepicker.js']);
$this->dependencies->add(['js', '{$path.js}Myvox/index.js']);

?>

<main>
    <section class="box-container complete">
        <div class="main">
            <article>
                <main>
                    <form name="new_vox">
                        <div class="row">
                            <div class="span12">
                                <div class="label">
                                    <figure class="my-room-logotype">
                                        <img src="{$path.images}logotype-color.png">
                                    </figure>
                                    <figure class="my-room-flags">
                                        <a href="?<?php echo Language::get_lang_url('es'); ?>"><img src="{$path.images}es.png"></a>
                                        <a href="?<?php echo Language::get_lang_url('en'); ?>"><img src="{$path.images}en.png"></a>
                                    </figure>
                                </div>
                            </div>
                            <div class="span12">
                                <div class="label">
                                    <label class="success">
                                        <p>{$lang.what_do_we_help_you}</p>
                                        <select name="type">
                                            <option value="request">{$lang.want_request}</option>
                                            <option value="incident">{$lang.want_incident}</option>
                                        </select>
                                    </label>
                                </div>
                            </div>
                            <div class="span12">
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
                            <div class="span12">
                                <div class="label">
                                    <label important>
                                        <p>{$lang.opportunity_type}</p>
                                        <select name="opportunity_type" disabled>
                                            <option value="" selected hidden>{$lang.choose}</option>
                                        </select>
                                    </label>
                                </div>
                            </div>
                            <div class="span6">
                                <div class="label">
                                    <label class="success">
                                        <p>{$lang.date}</p>
                                        <input type="text" name="started_date" class="datepicker" placeholder="{$lang.choose}" value="<?php echo Functions::get_current_date('Y-m-d'); ?>" />
                                        <p class="description">{$lang.what_date_need}</p>
                                        <p class="description hidden">{$lang.what_date_happened}</p>
                                    </label>
                                </div>
                            </div>
                            <div class="span6">
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
                            <div class="span12">
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
                            <div class="span12">
                                <div class="label">
                                    <label class="success">
                                        <p>{$lang.observations}</p>
                                        <input type="text" name="observations" maxlength="120" />
                                        <p class="description">{$lang.max_120_characters}</p>
                                    </label>
                                </div>
                            </div>
                            <div class="span12 hidden">
                                <div class="label">
                                    <label important>
                                        <p>{$lang.description}</p>
                                        <textarea name="description"></textarea>
                                        <p class="description">{$lang.what_happened} {$lang.dont_forget_mention_relevant_details}</p>
                                    </label>
                                </div>
                            </div>
                            <div class="span12">
                                <div class="label">
                                    <label important>
                                        <p>{$lang.lastname}</p>
                                        <input type="text" name="lastname" />
                                    </label>
                                </div>
                            </div>
                        </div>
                    </form>
                </main>
                <footer>
                    <div class="buttons text-center">
                        <a class="btn" data-action="new_vox">{$lang.accept}</a>
                    </div>
                </footer>
            </article>
        </div>
    </section>
</main>
