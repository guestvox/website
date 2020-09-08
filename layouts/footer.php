<?php defined('_EXEC') or die; ?>

        <section class="modal fullscreen" data-modal="search">
            <div class="content">
                <main>
                    <form>
                        <div class="row">
                            <div class="span12">
                                <div class="label">
                                    <label required>
                                        <p>{$lang.search}</p>
                                        <input type="text" name="search">
                                    </label>
                                </div>
                            </div>
                            <div class="span12">
                                <div class="buttons">
                                    <a class="new" button-close><i class="fas fa-check"></i></a>
                                </div>
                            </div>
                        </div>
                    </form>
                </main>
            </div>
        </section>
        <section class="modal fullscreen" data-modal="get_help">
            <div class="content">
                <main>
                    <i class="fas fa-question-circle"></i>
                    <p></p>
                    <a button-close><i class="fas fa-check"></i></a>
                </main>
            </div>
        </section>
        <section class="modal fullscreen" data-modal="success">
            <div class="content">
                <main>
                    <i class="fas fa-check-circle"></i>
                    <!-- <p></p> -->
                </main>
            </div>
        </section>
        <section class="modal fullscreen" data-modal="error">
            <div class="content">
                <main>
                    <i class="fas fa-times-circle"></i>
                    <p></p>
                    <a button-close><i class="fas fa-check"></i></a>
                </main>
            </div>
        </section>
        <div data-ajax-loader>
            <div class="loader"></div>
        </div>
        <script src="{$path.js}jquery-3.3.1.min.js"></script>
        <script src="{$path.js}valkyrie.min.js"></script>
        <script src="{$path.js}scripts.js"></script>
        <script src="https://kit.fontawesome.com/743152b0c5.js"></script>
        {$dependencies.js}
        {$dependencies.other}

        <!-- PWA -->
        <!-- <?php if (isset($GLOBALS['vkye_path']) && !empty($GLOBALS['vkye_path'])) : ?>
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
        <?php endif; ?> -->
        <!--  -->
    </body>
</html>
