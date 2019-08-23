<?php

defined('_EXEC') or die;

$this->dependencies->add(['js', '{$path.js}Myvox/index.js']);

?>

<header class="my-vox">
    <div class="topbar">
        <figure class="logotype">
            <img src="{$path.images}tmp/casablanca.png" alt="Logotype">
        </figure>
    </div>
    <div class="bottombar">
        <div class="weather">
            <div id="cont_14b51bac9dd36d8c525f0cb7c94d00e0">
                <script type="text/javascript" async src="https://www.meteored.mx/wid_loader/14b51bac9dd36d8c525f0cb7c94d00e0"></script>
            </div>
        </div>
        <div class="multilanguage">
            <a href="?<?php echo Language::get_lang_url('es'); ?>">
                <img src="{$path.images}es.png">
            </a>
            <a href="?<?php echo Language::get_lang_url('en'); ?>">
                <img src="{$path.images}en.png">
            </a>
        </div>
    </div>
</header>
<main class="my-vox">
    <div class="menu">
        <h2>{$lang.how_may_i_help_you}</h2>
        <a data-button-modal="new_incident">{$lang.i_want_to_leave_a_comment}</a>
        <a data-button-modal="new_request">{$lang.make_a_request}</a>
        <a data-button-modal="new_survey_answers" class="survey">{$lang.answer_survey_right_now}<img src="{$path.images}gift.png" alt="Gift"></a>
    </div>
</main>
<footer class="my-vox">
    <h4>Powered by <img src="{$path.images}logotype-color.png" alt="GuestVox"></h4>
    <p>{$lang.copyright}</p>
</footer>
<section class="modal" data-modal="new_request">
    <div class="content">
        <header>
            <h3>{$lang.make_a_request}</h3>
        </header>
        <main>
            <form name="new_request">
                <div class="row">
                    <div class="span12">
                        <div class="label">
                            <label important>
                                <p>{$lang.opportunity_area}</p>
                                <select name="opportunity_area" data-type="request">
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
                                <input type="date" name="started_date" value="<?php echo Functions::get_current_date('Y-m-d'); ?>">
                                <p class="description">{$lang.what_date_need}</p>
                            </label>
                        </div>
                    </div>
                    <div class="span6">
                        <div class="label">
                            <label class="success">
                                <p>{$lang.hour}</p>
                                <input type="time" name="started_hour" value="<?php echo Functions::get_current_hour(); ?>">
                                <p class="description">{$lang.what_hour_need}</p>
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
            <div class="action-buttons">
                <button class="btn btn-flat" button-cancel>{$lang.cancel}</button>
                <button class="btn" button-success>{$lang.accept}</button>
            </div>
        </footer>
    </div>
</section>
<section class="modal" data-modal="new_incident">
    <div class="content">
        <header>
            <h3>{$lang.i_want_to_leave_a_comment}</h3>
        </header>
        <main>
            <form name="new_incident">
                <div class="row">
                    <div class="span12">
                        <div class="label">
                            <label important>
                                <p>{$lang.opportunity_area}</p>
                                <select name="opportunity_area" data-type="incident">
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
                                <input type="date" name="started_date" value="<?php echo Functions::get_current_date('Y-m-d'); ?>">
                                <p class="description">{$lang.what_date_happened}</p>
                            </label>
                        </div>
                    </div>
                    <div class="span6">
                        <div class="label">
                            <label class="success">
                                <p>{$lang.hour}</p>
                                <input type="time" name="started_hour" value="<?php echo Functions::get_current_hour(); ?>">
                                <p class="description">{$lang.what_hour_happened}</p>
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
                                <p class="description">{$lang.when_happened}</p>
                            </label>
                        </div>
                    </div>
                    <div class="span12">
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
            <div class="action-buttons">
                <button class="btn btn-flat" button-cancel>{$lang.cancel}</button>
                <button class="btn" button-success>{$lang.accept}</button>
            </div>
        </footer>
    </div>
</section>
<section class="modal" data-modal="new_survey_answers">
    <div class="content">
        <header>
            <h3>{$lang.answer_survey_right_now}</h3>
        </header>
        <main>
            <form name="new_survey_answers">
                {$art_survey_questions}
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
<section class="modal" data-modal="new_comment_tripadvisor">
    <div class="content">
        <header>
            <h3>{$lang.answer_survey_right_now}</h3>
        </header>
        <main>
            <div id="TA_cdswritereviewlg4" class="TA_cdswritereviewlg">
                <ul id="I7hJOKLd" class="TA_links FJfwMuzhhq">
                    <li id="SnaJrr" class="KBMX9k">
                    <a target="_blank" href="https://www.tripadvisor.com.mx/"><img src="https://www.tripadvisor.com.mx/img/cdsi/img2/branding/medium-logo-12097-2.png" alt="TripAdvisor"/></a>
                    </li>
                </ul>
            </div>
            <script async src="https://www.jscache.com/wejs?wtype=cdswritereviewlg&amp;uniq=4&amp;locationId=154652&amp;lang=es_MX&amp;lang=es_MX&amp;display_version=2" data-loadtrk onload="this.loadtrk=true">
            </script>
        </main>
    </div>
</section>
