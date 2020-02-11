<?php

defined('_EXEC') or die;

$this->dependencies->add(['css', '{$path.css}Myvox/index.css']);
$this->dependencies->add(['js', '{$path.js}Myvox/index.js']);
//$this->dependencies->add(['other', "
//<script>
//        if('serviceWorker' in navigator){
//                console.log('El navegador admite service workers');
//            window.addEventListener('load', function(){
//            navigator.serviceWorker.register('sw.js').then(function(registration){
//            console.log('Service worker registrado de modo correcto');
//            console.log('Scope: ' + registration.scope)
//            },function(error){
//                console.log('El registro del Service worker ha fallado');
//                console.log(error)
//            });
//            });
//        }//Cierra validacion si el navegador admite service workers
//        </script>
//"]);

?>

<header class="my-vox">
    <div class="topbar">
        <figure class="logotype">
            <img src="{$logotype}" alt="Account logotype">
        </figure>
    </div>
    <div class="bottombar">
        {$weather}
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
