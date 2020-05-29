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
    <h2>{$lang.how_may_i_help_you}</h2>
    {$a_new_request}
    {$a_new_incident}
    {$a_new_survey_answer}
</main>
<footer class="myvox">
    <h4>Power by <img src="{$path.images}logotype_color.png" alt="Guestvox"></h4>
    <p>Copyright<i class="far fa-copyright"></i>{$lang.all_right_reserved}</p>
</footer>
{$mdl_new_vox}
{$mdl_new_survey_answer}
{$mdl_survey_widget}
