<?php

defined('_EXEC') or die;

$this->dependencies->add(['css', '{$path.css}Hi/webinar.css']);
$this->dependencies->add(['js', '{$path.js}Hi/webinar.js']);

?>

<main class="landing_page_webinar">
    <figure>
        <img src="{$image}" alt="Background">
    </figure>
    <a data-button-modal="signup">{$lang.signup}</a>
    <!-- <h1>{$lang.missing}</h1>
    <ul id="countdown" data-date="{$date}">
        <li><strong id="days"></strong>{$lang.days}</li>
        <li><strong id="hours"></strong>{$lang.hours}</li>
        <li><strong id="minutes"></strong>{$lang.minutes}</li>
        <li><strong id="seconds"></strong>{$lang.seconds}</li>
    </ul> -->
    <figure>
        <img src="{$path.images}hi/webinar/background.png" alt="Background">
    </figure>
</main>
<section class="modal" data-modal="signup">
    <div class="content">
        <main>
            <form name="signup">
                <div class="row">
                    <div class="span12">
                        <div class="label">
                            <label required>
                                <p>{$lang.name}</p>
                                <input type="text" name="name">
                            </label>
                        </div>
                    </div>
                    <div class="span12">
                        <div class="label">
                            <label required>
                                <p>{$lang.email}</p>
                                <input type="email" name="email">
                            </label>
                        </div>
                    </div>
                    <div class="span6">
                        <div class="label">
                            <label required>
                                <p>{$lang.business}</p>
                                <input type="text" name="business">
                            </label>
                        </div>
                    </div>
                    <div class="span6">
                        <div class="label">
                            <label required>
                                <p>{$lang.job}</p>
                                <input type="text" name="job">
                            </label>
                        </div>
                    </div>
                    <div class="span12">
                        <div class="buttons">
                            <a class="delete" button-cancel><i class="fas fa-times"></i></a>
                            <button type="submit" class="new"><i class="fas fa-check"></i></button>
                        </div>
                    </div>
                </div>
            </form>
        </main>
    </div>
</section>
