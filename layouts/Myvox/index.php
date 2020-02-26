<?php

defined('_EXEC') or die;

$this->dependencies->add(['css', '{$path.css}Myvox/index.css']);
$this->dependencies->add(['js', '{$path.js}Myvox/index.js']);

?>

<header class="my-vox">
    <div class="topbar">
        <figure class="logotype">
            <img src="{$logotype}" alt="Account logotype">
        </figure>
    </div>
    <div class="bottombar">
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
        {$a_new_request}
        {$a_new_incident}
        {$a_new_survey_answer}
    </div>
</main>
<footer class="my-vox">
    <h4>Powered by <img src="{$path.images}logotype-color.png" alt="Guestvox logotype"></h4>
    <p>{$lang.copyright}</p>
</footer>
{$mdl_new_request}
{$mdl_new_incident}
{$mdl_new_survey_answer}
<section class="modal" data-modal="tripadvisor">
    <div class="content">
        <header>
            <h3>{$lang.to_conclude_leave_us_your_review}</h3>
        </header>
        <main>
            <div id="TA_rated159" class="TA_rated">
                <ul id="lKtoDF" class="TA_links FPRlD8">
                    <li id="IhT9XHb" class="wD5pP6jb5CX">
                        <a target="_blank" href="https://www.tripadvisor.com.mx/"><img src="https://www.tripadvisor.com.mx/img/cdsi/img2/badges/ollie-11424-2.gif" alt="TripAdvisor"/></a>
                    </li>
                </ul>
            </div>
            <script async src="{$tripadvisor_url}" data-loadtrk onload="this.loadtrk=true"></script>
        </main>
        <footer>
            <div class="action-buttons">
                <button class="btn btn-flat" button-close>{$lang.accept}</button>
            </div>
        </footer>
    </div>
</section>
