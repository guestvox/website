<?php

defined('_EXEC') or die;

$this->dependencies->add(['css', '{$path.css}Myvox/index.css']);
$this->dependencies->add(['js', '{$path.js}Myvox/index.js']);

?>

<header class="my-vox">
    <div class="topbar">
        <figure class="logotype">
            <img src="{$logotype}" alt="">
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
        {$a_new_request}
        {$a_new_incident}
        {$a_new_survey_answer}
    </div>
</main>
<footer class="my-vox">
    <h4>Powered by <img src="{$path.images}logotype-color.png" alt=""></h4>
    <p>{$lang.copyright}</p>
</footer>
{$mdl_new_request}
{$mdl_new_incident}
{$mdl_new_survey_answer}
