<?php
defined('_EXEC') or die;

$this->dependencies->add(['css', '{$path.css}Hi/operation.css']);

$this->dependencies->add(['js', '{$path.plugins}owl-carousel/owl.carousel.min.js']);
$this->dependencies->add(['css', '{$path.plugins}owl-carousel/assets/owl.carousel.min.css']);
$this->dependencies->add(['css', '{$path.plugins}owl-carousel/assets/owl.theme.default.min.css']);

$this->dependencies->add(['css', '{$path.plugins}fancy-box/jquery.fancybox.min.css']);
$this->dependencies->add(['js', '{$path.plugins}fancy-box/jquery.fancybox.min.js']);

$this->dependencies->add(['js', '{$path.js}Hi/operation.js']);

// Facebook
$this->dependencies->add(['meta', '{$vkye_domain}/hola?ref=6500', ["property='og:url'"]]);
$this->dependencies->add(['meta', 'website', ["property='og:type'"]]);
$this->dependencies->add(['meta', 'Conoce GuestVox y haz inteligencia de negocios', ["property='og:title'"]]);
$this->dependencies->add(['meta', 'Solución hotelera para la mejora de satisfacción del huesped y optimización de operaciones.', ["property='og:description'"]]);
$this->dependencies->add(['meta', '{$vkye_domain}/{$path.images}screenshot-social-media.png', ["property='og:image'"]]);

$this->dependencies->add(['other', '<!-- Hotjar Tracking Code for www.guestvox.com/hola -->
<script>
    (function(h,o,t,j,a,r){
        h.hj=h.hj||function(){(h.hj.q=h.hj.q||[]).push(arguments)};
        h._hjSettings={hjid:1584075,hjsv:6};
        a=o.getElementsByTagName(\'head\')[0];
        r=o.createElement(\'script\');r.async=1;
        r.src=t+h._hjSettings.hjid+j+h._hjSettings.hjsv;
        a.appendChild(r);
    })(window,document,\'https://static.hotjar.com/c/hotjar-\',\'.js?sv=\');
</script>']);
?>

<main class="public_page mkt_page">
    <header class="topbar">
        <figure>
            <img src="{$path.images}logotype-white.svg" alt="Guestvox">
        </figure>
        <nav>
            <ul>
                <li><a class="btn" data-button-modal="modal_contact">¡Solicita tu demo ahora!</a></li>
            </ul>
        </nav>
    </header>

    <section class="main">
        <header class="cover">
            <div class="container">
                <div class="content">
                    <h1>Solución hotelera en la nube, para la optimización de operaciones y mejora de reputación en línea.</h1>
                    <h2>Gestiona correctamente las incidencias y peticiones de tus huéspedes.</h2>
                    <a class="btn" data-button-modal="modal_contact">¡Solicita tu demo ahora!</a>
                </div>
                <figure>
                    <img src="{$path.images}screen-1.jpg" alt="Software">
                </figure>
            </div>
            <div class="rocket"></div>
        </header>

        <section class="container background">
            <div class="space50"></div>

            <div class="title">
                <h2>¿Qué hacemos?</h2>
                <p>...</p>
            </div>

            <div class="space50"></div>

            <div class="boxes three-boxes">
                <div class="box">
                    <span class="icon-communication"></span>
                    <h4>Gestionamos las órdenes de trabajo entre departamentos y mejoramos su comunicación.</h4>
                </div>
                <div class="box">
                    <span class="icon-clients"></span>
                    <h4>Recibimos y damos seguimiento a las peticiones, comentarios y quejas de los huéspedes.</h4>
                </div>
                <div class="box">
                    <span class="icon-like"></span>
                    <h4>Recibimos la retroalimentación de tus huéspedes y los invitamos a dejar una evaluación en línea.</h4>
                </div>
            </div>

            <div class="space100"></div>

            <div class="title">
                <h2>¿Cómo funciona GuestVox?</h2>
                <p>...</p>
            </div>

            <div class="space50"></div>

            <div class="boxes-product">
                <div class="box">
                    <figure>
                        <img src="{$path.images}icon-lock.svg" alt="" width="70" height="70">
                    </figure>
                    <h4>Credenciales encriptadas</h4>
                    <p>Los colaboradores acceden fácilmente a la plataforma utilizando sus credenciales de acceso (usuario y contraseña).</p>
                </div>

                <div class="box">
                    <figure>
                        <img src="{$path.images}icon-person.svg" alt="" width="70" height="70">
                    </figure>
                    <h4>Asigna al área y/o persona responsable del seguimiento.</h4>
                    <p>Crea una incidencia (Vox), y asigna al área o persona responsable del seguimiento.</p>
                </div>

                <div class="box">
                    <figure>
                        <img src="{$path.images}icon-attachment.svg" alt="" width="70" height="70">
                    </figure>
                    <h4>Adjunta imágenes, videos, archivos PDF, Word y Excel.</h4>
                    <p>Enriquece el Vox y respalda tu información con archivos adjuntos.</p>
                </div>

                <div class="box">
                    <figure>
                        <img src="{$path.images}icon-person-follow.svg" alt="" width="70" height="70">
                    </figure>
                    <h4>Seguimiento de acuerdo a prioridad y tiempo transcurrido.</h4>
                    <p>Una vez creada la incidencia, los departamentos asignados dan seguimiento a cada caso.</p>
                </div>

                <div class="box">
                    <figure>
                        <img src="{$path.images}icon-time.svg" alt="" width="70" height="70">
                    </figure>
                    <h4>Tu información siempre en tiempo real.</h4>
                    <p>Visualiza minuto a minuto el estatus de tu hotel, el seguimiento a los Voxes y la satisfacción de tus huéspedes.</p>
                </div>

                <div class="box">
                    <figure>
                        <img src="{$path.images}icon-multi-device.svg" alt="" width="70" height="70">
                    </figure>
                    <h4>Accede desde cualquier dispositivo.</h4>
                    <p>No importa dónde estes, ni que dispositivo uses, accesa a tu información cuando quieras y donde quieras.</p>
                </div>
            </div>
        </section>

        <section class="call-to-action">
            <div class="container">
                <div class="content">
                    <h4>Ahorra hasta un 20% de costos operativos</h4>
                    <!-- <p>¿No encuentras una opción de acuerdo a tus necesidades?</p> -->
                </div>

                <a data-button-modal="modal_contact">¡Solicita tu demo ahora!</a>
            </div>
        </section>

        <section class="container background">
            <div class="title">
                <h2>Screenshots</h2>
                <p>Un vistazo a nuestro software</p>
            </div>

            <div class="space50"></div>

            <div id="screenshots" class="owl-carousel owl-theme">
                <div class="item" style="background-image: url('{$path.images}screenshot-1-thumb.jpg');">
                    <a data-fancybox="gallery" href="{$path.images}screenshot-1.jpg"></a>
                </div>
                <div class="item" style="background-image: url('{$path.images}screenshot-2-thumb.jpg');">
                    <a data-fancybox="gallery" href="{$path.images}screenshot-2.jpg"></a>
                </div>
                <div class="item" style="background-image: url('{$path.images}screenshot-3-thumb.jpg');">
                    <a data-fancybox="gallery" href="{$path.images}screenshot-3.jpg"></a>
                </div>
                <div class="item" style="background-image: url('{$path.images}screenshot-4-thumb.jpg');">
                    <a data-fancybox="gallery" href="{$path.images}screenshot-4.jpg"></a>
                </div>
                <div class="item" style="background-image: url('{$path.images}screenshot-5-thumb.jpg');">
                    <a data-fancybox="gallery" href="{$path.images}screenshot-5.jpg"></a>
                </div>
            </div>
        </section>
    </section>

    <footer class="main">
        <div class="container">
            <h2>Haz inteligencia de negocio</h2>
            <h3>Y ahorra hasta un 20% en costos, incrementa tu reputación en linea, calidad de servicio, productividad de colaboradores e ingresos.</h3>

            <a class="btn" data-button-modal="modal_contact">¡SOLICITA TU DEMO AHORA!</a>

            <ul class="social_media">
                <li><a href="https://www.facebook.com/Guestvox/" target="_blank">Facebook</a></li>
                <li><a href="https://www.instagram.com/guestvox/" target="_blank">Instagram</a></li>
                <li><a href="https://www.linkedin.com/company/guestvox/" target="_blank">LinkedIn</a></li>
                <li><a href="https://www.youtube.com/channel/UCKSAce4n1NqahbL5RQ8QN9Q" target="_blank">YouTube</a></li>
            </ul>

            <div class="copyright">
                <strong>guestvox.com</strong> Todos los derechos reservados.
            </div>
        </div>
    </footer>
</main>

<section id="modal_contact" class="modal size-small" data-modal="modal_contact">
    <div class="content">
        <header>
            <h3>Pongamonos en contacto</h3>
        </header>
        <main>
            <form name="contact">
                <div class="label">
                    <label>
                        <input type="text" name="name_hotel" value="">
                        <p class="description">Nombre del hotel</p>
                    </label>
                </div>

                <div class="label">
                    <label>
                        <input type="text" name="number_rooms" value="">
                        <p class="description">Número de habitaciones</p>
                    </label>
                </div>

                <div class="label">
                    <label>
                        <input type="text" name="name_contact" value="">
                        <p class="description">Nombre completo</p>
                    </label>
                </div>

                <div class="label">
                    <label>
                        <input type="text" name="email" value="">
                        <p class="description">Correo electrónico</p>
                    </label>
                </div>

                <div class="label">
                    <label>
                        <input type="text" name="phone" value="">
                        <p class="description">Teléfono a 10 dígitos</p>
                    </label>
                </div>

                <?php
                if ( isset($_GET['ref']) && !empty($_GET['ref']) )
                    echo '<input type="hidden" name="ref" value="'. $_GET['ref'] .'">';
                ?>

                <p style="font-size: 10px; line-height: 1.3; opacity: 0.5; margin-bottom: 0px;">Al enviar este formulario, solicitará que un representante de Guestvox S.A.P.I de C.V. se ponga en contacto con usted por teléfono o correo electrónico en los próximos días.</p>
            </form>
        </main>
        <footer>
            <div class="action-buttons">
                <button class="btn btn-flat" button-cancel>Cancelar</button>
                <button class="btn btn-colored" button-success>¡Contáctenme!</button>
            </div>
        </footer>
    </div>
</section>

<section id="modal_contact_success" class="modal" data-modal="modal_contact_success">
    <div class="content">
        <header>
            <h3>¡Gracias! En breve nos contactaremos contigo.</h3>
        </header>
        <footer>
            <div class="action-buttons">
                <button class="btn btn-flat" button-close>Cerrar</button>
            </div>
        </footer>
    </div>
</section>
