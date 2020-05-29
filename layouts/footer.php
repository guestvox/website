<?php defined('_EXEC') or die; ?>

        <section class="modal fullscreen" data-modal="success">
            <div class="content">
                <main>
                    <figure>
                        <img src="{$path.images}success.png">
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
                    <a button-close><i class="fas fa-times"></i></a>
                </main>
            </div>
        </section>
        <script src="{$path.js}jquery-3.3.1.min.js"></script>
        <script src="{$path.js}valkyrie.min.js"></script>
        <script src="{$path.js}scripts.js"></script>
        <script src="https://kit.fontawesome.com/743152b0c5.js"></script>
        {$dependencies.js}
        {$dependencies.other}

        <!-- PWA -->
        <?php if (isset($GLOBALS['vkye_path']) && !empty($GLOBALS['vkye_path'])) : ?>
            <?php if ($GLOBALS['vkye_path'] == '/Login/index') : ?>
            <script>
                if ('serviceWorker' in navigator)
                {
                    window.addEventListener('load', function()
                    {
                        navigator.serviceWorker.register('sw.js').then(function(registration)
                        {
                            console.log('Service worker registrado de modo correcto el el Login');
                        },
                        function(error)
                        {
                            console.log('El registro del Service worker ha fallado');
                            console.log(error);
                        });
                    });
                }
            </script>
            <?php else: ?>
            <script>
                navigator.serviceWorker.getRegistrations().then(
                function(registrations)
                {
                    for (let registration of registrations)
                    {
                        registration.unregister();
                    }
                });
                document.querySelector('link[rel="manifest"]').remove();
            </script>
            <?php endif; ?>
        <?php endif; ?>
        <!--  -->

        <!-- Facebook chatboot -->
        <div id="fb-root"></div>
        <script>
            window.fbAsyncInit = function() {
                FB.init({
                    xfbml: true,
                    version: 'v6.0'
                });
            };
            (function(d, s, id) {
                var js, fjs = d.getElementsByTagName(s)[0];
                if (d.getElementById(id)) return;
                js = d.createElement(s);
                js.id = id;
                js.src = 'https://connect.facebook.net/es_ES/sdk/xfbml.customerchat.js';
                fjs.parentNode.insertBefore(js, fjs);
            }(document, 'script', 'facebook-jssdk'));
        </script>
        <div class="fb-customerchat" attribution=setup_tool page_id="544915395886636" theme_color="#00A5AB" logged_in_greeting="Hola, ¿Cómo puedo ayudarte?" logged_out_greeting="Hola, ¿Cómo puedo ayudarte?"></div>
        <!--  -->
    </body>
</html>
