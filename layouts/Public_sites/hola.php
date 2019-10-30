<?php
defined('_EXEC') or die;

$this->dependencies->add(['css', '{$path.css}public_sites.css']);

$this->dependencies->add(['js', '{$path.plugins}owl-carousel/owl.carousel.min.js']);
$this->dependencies->add(['css', '{$path.plugins}owl-carousel/assets/owl.carousel.min.css']);
$this->dependencies->add(['css', '{$path.plugins}owl-carousel/assets/owl.theme.default.min.css']);

$this->dependencies->add(['css', '{$path.plugins}fancybox/jquery.fancybox.min.css']);
$this->dependencies->add(['js', '{$path.plugins}fancybox/jquery.fancybox.min.js']);

$this->dependencies->add(['js', '{$path.js}Public_sites/hola.js']);
?>

<main class="public_page mkt_page">
    <header class="topbar">
        <figure>
            <img src="{$path.images}logotype-white.svg" alt="Guestvox">
        </figure>
        <nav>
            <ul>
                <li><a class="btn">¡Solicita tu demo ahora!</a></li>
            </ul>
        </nav>
    </header>

    <section class="main">
        <header class="cover">
            <div class="container">
                <div class="content">
                    <h1>Solución hotelera en la nube, para la optimización de operaciones y mejora de reputación en línea.</h1>
                    <h2>Gestiona correctamente las incidencias y peticiones de tus huéspedes.</h2>
                    <a class="btn">¡Solicita tu demo ahora!</a>
                </div>
                <figure>
                    <img src="{$path.images}screen-1.jpg" alt="Software">
                </figure>
            </div>
            <div class="rocket"></div>
        </header>

        <section class="container background">
            <div class="boxes three-boxes">
                <div class="box">
                    <span class="icon-check"></span>
                    <h4>Gestionamos las órdenes de trabajo entre departamentos y mejoramos su comunicación.</h4>
                </div>
                <div class="box">
                    <span class="icon-check"></span>
                    <h4>Recibimos y damos seguimiento a las peticiones, comentarios y quejas de los huéspedes.</h4>
                </div>
                <div class="box">
                    <span class="icon-check"></span>
                    <h4>Recibimos la retroalimentación de tus huéspedes y los invitamos a dejar una evaluación en línea.</h4>
                </div>
            </div>

            <div class="space100"></div>

            <div class="title">
                <h2>Funciones</h2>
                <p>¿Qué ofrece GuestVox?</p>
            </div>

            <div class="space50"></div>

            <div class="boxes-product">
                <div class="box">
                    <figure>
                        <img src="{$path.images}icon-check-color-gray.svg" alt="" width="70" height="70">
                    </figure>
                    <h4>Credenciales encriptadas</h4>
                    <p>Los colaboradores acceden fácilmente a la plataforma utilizando sus credenciales de acceso (usuario y contraseña).</p>
                </div>

                <div class="box">
                    <figure>
                        <img src="{$path.images}icon-check-color-gray.svg" alt="" width="70" height="70">
                    </figure>
                    <h4>Crea un Vox.</h4>
                    <p>De manera rápida e intuitiva el colaborador crea una nueva incidencia en el sistema, enriqueciéndola con información que facilitará su seguimiento.</p>
                </div>

                <div class="box">
                    <figure>
                        <img src="{$path.images}icon-check-color-gray.svg" alt="" width="70" height="70">
                    </figure>
                    <h4>Asigna al área y/o persona responsable del seguimiento.</h4>
                    <p>Los colaboradores acceden fácilmente a la plataforma utilizando sus credenciales de acceso (usuario y contraseña).</p>
                </div>

                <div class="box">
                    <figure>
                        <img src="{$path.images}icon-check-color-gray.svg" alt="" width="70" height="70">
                    </figure>
                    <h4>Adjunta archivos de soporte.</h4>
                    <p>Los colaboradores acceden fácilmente a la plataforma utilizando sus credenciales de acceso (usuario y contraseña).</p>
                </div>

                <div class="box">
                    <figure>
                        <img src="{$path.images}icon-check-color-gray.svg" alt="" width="70" height="70">
                    </figure>
                    <h4>Da seguimiento a las incidencias.</h4>
                    <p>Una vez creada la incidencia, los departamentos asignados dan seguimiento a cada caso, agregan notas y comentarios de las acciones tomadas, archivos adjuntos de apoyo, y cierran la incidencia una vez que se ha concluido.</p>
                </div>

                <div class="box">
                    <figure>
                        <img src="{$path.images}icon-check-color-gray.svg" alt="" width="70" height="70">
                    </figure>
                    <h4>Sigue en tiempo real el estatus de cada incidencia.</h4>
                    <p>Una vez creada la incidencia, los departamentos asignados dan seguimiento a cada caso.</p>
                </div>

                <div class="box">
                    <figure>
                        <img src="{$path.images}icon-check-color-gray.svg" alt="" width="70" height="70">
                    </figure>
                    <h4>Seguimiento de acuerdo a prioridad y tiempo transcurrido.</h4>
                    <p>Una vez creada la incidencia, los departamentos asignados dan seguimiento a cada caso.</p>
                </div>

                <div class="box">
                    <figure>
                        <img src="{$path.images}icon-check-color-gray.svg" alt="" width="70" height="70">
                    </figure>
                    <h4>Adjunta imágenes, videos, archivos PDF, Word y Excel.</h4>
                    <p>Una vez creada la incidencia, los departamentos asignados dan seguimiento a cada caso.</p>
                </div>

                <div class="box">
                    <figure>
                        <img src="{$path.images}icon-check-color-gray.svg" alt="" width="70" height="70">
                    </figure>
                    <h4>Accede desde cualquier dispositivo.</h4>
                    <p>Una vez creada la incidencia, los departamentos asignados dan seguimiento a cada caso.</p>
                </div>
            </div>
        </section>

        <!-- <section class="container"> -->
            <!-- <div class="boxes three-boxes">
                <div class="box">
                    <span class="icon-check"></span>
                    <h4>Gestionamos las órdenes de trabajo entre departamentos y mejoramos su comunicación.</h4>
                </div>
                <div class="box">
                    <span class="icon-check"></span>
                    <h4>Recibimos y damos seguimiento a las peticiones, comentarios y quejas de los huéspedes.</h4>
                </div>
                <div class="box">
                    <span class="icon-check"></span>
                    <h4>Recibimos la retroalimentación de tus huéspedes y los invitamos a dejar una evaluación en línea.</h4>
                </div>
            </div>

            <div class="space100"></div> -->

            <!-- <div class="double-section">
                <section>
                    <h4><span class="icon-check color"></span>Credenciales encriptadas.</h4>
                    <p>Los colaboradores acceden fácilmente a la plataforma utilizando sus credenciales de acceso (usuario y contraseña).</p>

                    <h4><span class="icon-check color"></span>Crea un Vox.</h4>
                    <p>De manera rápida e intuitiva el colaborador crea una nueva incidencia en el sistema, enriqueciéndola con información que facilitará su seguimiento.</p>

                    <h4><span class="icon-check color"></span>Asigna al área y/o persona responsable del seguimiento.</h4>
                    <p></p>

                    <h4><span class="icon-check color"></span>Adjunta archivos de soporte.</h4>
                    <p></p>
                </section>
                <figure>
                    <img src="{$path.images}screen-2.png" alt="">
                </figure>
            </div>

            <div class="double-section">
                <figure>
                    <img src="{$path.images}screen-3.png" alt="">
                </figure>
                <section>
                    <h4><span class="icon-check color"></span>Da seguimiento a las incidencias.</h4>
                    <p>Una vez creada la incidencia, los departamentos asignados dan seguimiento a cada caso, agregan notas y comentarios de las acciones tomadas, archivos adjuntos de apoyo, y cierran la incidencia una vez que se ha concluido.</p>

                    <h4><span class="icon-check color"></span>Sigue en tiempo real el estatus de cada incidencia.</h4>
                    <p></p>

                    <h4><span class="icon-check color"></span>Seguimiento de acuerdo a prioridad y tiempo transcurrido.</h4>
                    <p></p>

                    <h4><span class="icon-check color"></span>Adjunta imágenes, videos, archivos PDF, Word y Excel.</h4>
                    <p></p>

                    <h4><span class="icon-check color"></span>Accede desde cualquier dispositivo.</h4>
                    <p></p>
                </section>
            </div> -->

            <!-- <div class="double-section">
                <section>
                    <h2>Recibe retroalimentación de tu huésped.</h2>
                    <p class="description-one">Tus huéspedes pueden hacer sus requerimientos, comentarios, o incluso responder tu encuesta de satisfacción, sin necesidad de descargar una app.</p>

                    <ul>
                        <li>Abre un canal de comunicación con tu huésped sin una app.</li>
                        <li>Recibe, a través del huésped, peticiones y órdenes de servicio para las áreas que tú decidas.</li>
                        <li>Tu huésped puede contestar la encuesta de satisfacción en cualquier momento de su estancia.</li>
                        <li>Obtén, en tiempo real, las métricas de tus encuestas.</li>
                        <li>Mejora tus comentarios en línea con las ligas inteligentes a TripAdvisor o Google Reviews.</li>
                    </ul>
                </section>
                <figure>
                    <img src="{$path.images}screen-4.jpg" alt="">
                </figure>
            </div> -->
        <!-- </section> -->

        <section class="call-to-action">
            <div class="container">
                <div class="content">
                    <h4>Lorem ipsum</h4>
                    <p>¿No encuentras una opción de acuerdo a tus necesidades?</p>
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
                <div class="item" style="background-image: url('{$path.images}screenshot-1.jpg');">
                    <a data-fancybox="gallery" href="{$path.images}screenshot-1.jpg"></a>
                </div>
                <div class="item" style="background-image: url('{$path.images}screenshot-1.jpg');">
                    <a data-fancybox="gallery" href="{$path.images}screenshot-1.jpg"></a>
                </div>
                <div class="item" style="background-image: url('{$path.images}screenshot-1.jpg');">
                    <a data-fancybox="gallery" href="{$path.images}screenshot-1.jpg"></a>
                </div>
                <div class="item" style="background-image: url('{$path.images}screenshot-1.jpg');">
                    <a data-fancybox="gallery" href="{$path.images}screenshot-1.jpg"></a>
                </div>
                <div class="item" style="background-image: url('{$path.images}screenshot-1.jpg');">
                    <a data-fancybox="gallery" href="{$path.images}screenshot-1.jpg"></a>
                </div>
            </div>
        </section>
    </section>

    <footer class="main">
        <div class="container">
            <h2>Haz inteligencia de negocio</h2>
            <h3>Y ahorra hasta un 20% en costos, incrementa tu reputación en linea, calidad de servicio, productividad de colaboradores e ingresos.</h3>

            <a class="btn" data-button-modal="modal_contact">¡SOLICITA TU DEMO AHORA!</a>

            <div class="copyright">
                <strong>guestvox.com</strong> Todos los derechos reservados.
            </div>
        </div>
    </footer>
</main>

<section id="modal_contact" class="modal size-small" data-modal="modal_contact">
    <div class="content">
        <header>
            <h3>¿En que podemos ayudarte?</h3>
        </header>
        <main>
            <p style="font-size: 10px; line-height: 1.3; opacity: 0.5;">Lorem ipsum dolor sit amet, consectetuer adipiscing elit. Aenean commodo ligula eget dolor. Aenean massa. Cum sociis natoque penatibus et magnis dis parturient montes, nascetur ridiculus mus. Donec quam felis, ultricies nec, pellentesque eu, pretium quis, sem. Nulla consequat massa quis enim. Donec pede justo, fringilla vel, aliquet nec, vulputate eget, arcu.</p>

            <form>
                <div class="label">
                    <label>
                        <input type="text" name="" value="">
                        <p class="description">Nombre completo</p>
                    </label>
                </div>
                <div class="label">
                    <label>
                        <input type="text" name="" value="">
                        <p class="description">Correo electrónico</p>
                    </label>
                </div>
                <div class="label">
                    <label>
                        <input type="text" name="" value="">
                        <p class="description">Teléfono a 10 dígitos</p>
                    </label>
                </div>
                <div class="label">
                    <label>
                        <textarea name=""></textarea>
                        <p class="description">Describe tu duda o comentario.</p>
                    </label>
                </div>
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
