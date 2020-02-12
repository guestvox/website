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
        <script src="https://kit.fontawesome.com/743152b0c5.js"></script>
        {$dependencies.js}
        {$dependencies.other}
        
        <?php if ( isset($GLOBALS['vkye_path']) && !empty($GLOBALS['vkye_path']) ): ?>
            <?php if ($GLOBALS['vkye_path']=='/Login/index' ): ?>
                <script>
                    if('serviceWorker' in navigator){
                            //console.log('El navegador admite service workers');
                            window.addEventListener('load', function(){
                            navigator.serviceWorker.register('sw.js').then(function(registration){
                            console.log('Service worker registrado de modo correcto el el Login');
                            //console.log('Scope: ' + registration.scope);
                            },function(error){
                                console.log('El registro del Service worker ha fallado');
                                console.log(error);
                            });
                        });
                    }//Cierra validacion si el navegador admite service workers
                 </script>
            <?php else: ?>
                 <script>
                    navigator.serviceWorker.getRegistrations().then(
                    function(registrations) {
                        for(let registration of registrations){
                            registration.unregister();
                        }
                    });
                    document.querySelector('link[rel="manifest"]').remove();
                 </script>
            <?php endif; ?>
        <?php endif; ?>
    </body>
</html>
