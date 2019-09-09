<?php

defined('_EXEC') or die;

$this->dependencies->add(['js', '{$path.js}Index/validate.js']);

?>

<main class="landing-page">
    <section class="validate">
        <div>
			<h4>{$lang.im_the_guests_voice}</h4>
			<h1>{$lang.manages_correctly_the_incidents}</h1>
		</div>
        <figure>
			<img src="{$path.images}home.png" alt="">
		</figure>
    </section>
</main>
<section class="modal fullscreen" data-modal="login">
    <div class="content">
        <main>
            <form name="login">
                <figure>
                    <img src="{$path.images}icon-color.svg" alt="">
                </figure>
                <fieldset>
                    <input type="text" name="username" placeholder="{$lang.username_or_email}" />
                </fieldset>
                <fieldset>
                    <input type="password" name="password" placeholder="{$lang.password}" />
                </fieldset>
                <a class="btn" data-action="login">{$lang.next}</a>
                <a button-cancel>{$lang.cancel}</a>
            </form>
        </main>
    </div>
</section>
