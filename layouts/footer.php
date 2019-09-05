<?php defined('_EXEC') or die; ?>

    <section class="modal fullscreen" data-modal="success">
        <div class="content">
            <main>
                <figure>
                    <img src="{$path.images}check_white.png">
                </figure>
                <p></p>
            </main>
        </div>
    </section>
    <section class="modal fullscreen" data-modal="error">
        <div class="content">
            <main>
                <figure>
                    <img src="{$path.images}error.png">
                </figure>
                <p></p>
                <a button-close>{$lang.accept}</a>
            </main>
        </div>
    </section>
    <script src="{$path.js}jquery-3.3.1.min.js"></script>
    <script src="{$path.js}valkyrie.min.js"></script>
    <script src="{$path.js}scripts.js"></script>
    <script defer src="https://use.fontawesome.com/releases/v5.0.6/js/all.js"></script>
    {$dependencies.js}
    {$dependencies.other}
    </body>
</html>
