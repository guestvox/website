<?php

defined('_EXEC') or die;

$this->dependencies->add(['css', '{$path.css}Myvox/index.css']);
$this->dependencies->add(['js', '{$path.js}Myvox/index.js']);

?>

<header class="myvox">
    <figure>
        <img src="{$logotype}" alt="Client">
    </figure>
    <div>
        <a href="?<?php echo Language::get_lang_url('es'); ?>"><img src="{$path.images}es.png"><span>{$lang.es}</span></a>
        <a href="?<?php echo Language::get_lang_url('en'); ?>"><img src="{$path.images}en.png"><span>{$lang.en}</span></a>
    </div>
</header>
<main class="myvox">
    {$btn_new_request}
    {$btn_new_incident}
    {$btn_new_menu_order}
    {$btn_new_survey_answer}
</main>
<footer class="myvox">
    <a href="/">Powered by <img src="{$path.images}logotype_color.png" alt="Guestvox"></a>
    <p>Copyright<i class="far fa-copyright"></i>{$lang.all_right_reserved}</p>
</footer>
