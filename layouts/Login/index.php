<?php
defined('_EXEC') or die;

$this->dependencies->add(['css', '{$path.css}Index/index.css']);
$this->dependencies->add(['js', '{$path.js}Index/index.js']);
// $this->dependencies->add(['other', '<script async defer src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBLCea8Q6BtcTHwY3YFCiB0EoHE5KnsMUE"></script>']);
?>

<header class="landing-page-index">
    <div class="container">
        <figure>
            <img src="{$path.images}logotype-white.png" alt="GuestVox logotype">
        </figure>
        <nav>
            <ul>
                <li><a href="/blog" class="btn no-border">{$lang.our_blog}</a></li>
                <li><a data-button-modal="signup" class="btn">{$lang.start_free_demo}</a></li>
                <li><a data-button-modal="login" class="btn">{$lang.login}</a></li>
                <li><a href="?<?php echo Language::get_lang_url('es'); ?>" class="btn no-border lang"><img src="{$path.images}es.png" alt="ES Lang"></a></li>
                <li><a href="?<?php echo Language::get_lang_url('en'); ?>" class="btn no-border lang"><img src="{$path.images}en.png" alt="EN Lang"></a></li>
            </ul>
            <ul>
                <li><a class="btn" data-action="open-land-menu"><i class="fas fa-bars"></i></a></li>
            </ul>
        </nav>
    </div>
</header>
<main class="landing-page-index">
    <section class="modal fullscreen" data-modal="login">
        <div class="content">
            <main>
                <form name="login">
                    <figure>
                        <img src="{$path.images}icon-color.svg" alt="GuestVox icontype">
                    </figure>
                    <fieldset>
                        <input type="text" name="username" placeholder="{$lang.username_or_email}" />
                    </fieldset>
                    <fieldset>
                        <input type="password" name="password" placeholder="{$lang.password}" />
                    </fieldset>
                    <a class="btn" data-action="login">{$lang.login}</a>
                    <a button-cancel>{$lang.cancel}</a>
                </form>
            </main>
        </div>
    </section>

</main>
