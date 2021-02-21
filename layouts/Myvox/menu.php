<?php

defined('_EXEC') or die;

$this->dependencies->add(['css', '{$path.css}Myvox/menu.css']);
$this->dependencies->add(['js', '{$path.js}Myvox/menu.js']);
$this->dependencies->add(['other', '<script async defer src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBLCea8Q6BtcTHwY3YFCiB0EoHE5KnsMUE&callback=map"></script>']);

?>

<header class="menu">
    <figure>
        <img src="{$logotype}" alt="Client">
    </figure>
    <nav>
        <ul>
            <li>{$btn_home}</li>
            <li><a href="?<?php echo Language::get_lang_url('es'); ?>"><img src="{$path.images}es.png"></a></li>
            <li><a href="?<?php echo Language::get_lang_url('en'); ?>"><img src="{$path.images}en.png"></a></li>
        </ul>
    </nav>
</header>
<main class="menu">
    {$html}
</main>
<footer class="menu">
    <a href="/">Powered by <img src="{$path.images}logotype_color.png" alt="Guestvox"></a>
    <p>Copyright<i class="far fa-copyright"></i>2021 | Guestvox S.A.P.I. de C.V.</p>
</footer>
