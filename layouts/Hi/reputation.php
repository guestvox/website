<?php

defined('_EXEC') or die;

$this->dependencies->add(['css', '{$path.css}Hi/reputation.css']);
$this->dependencies->add(['js', '{$path.js}Hi/reputation.js']);

?>

<header class="landingpage-reputation">
    <a data-button-modal="contact"><i class="fas fa-qrcode"></i></a>
    <a data-button-modal="contact"><i class="fas fa-paper-plane"></i></a>
    <a data-button-modal="contact"><i class="fas fa-gift"></i></a>
    <figure>
        <img src="{$path.images}icon-white.svg" alt="Guestvox logotipo">
    </figure>
</header>
<main class="landingpage-reputation">
    <section id="section-one" class="gradient hand-background">
        <div class="container">
            <figure class="logotype">
                <img src="{$path.images}hi/reputation/logotype.svg" alt="Guestvox logotipo">
            </figure>
            <div class="content">
                <h3>Conoce la opinión de tus consumidores</h3>
                <p><span>GuestVox es una plataforma, en la que <strong>sólo tus clientes</strong> pueden contestar tu encuesta de satisfacción y dejar una valoración.</span></p>
            </div>
        </div>
    </section>
    <section id="section-two" class="gradient-t">
        <div class="container">
            <div class="space50"></div>
            <div class="content">
                <div>
                    <span class="st-2-img-1"></span>
                    <div class="box">
                        <p>Construye confianza y compromiso con tus clientes recibiendo sus opiniones reales.</p>
                    </div>
                </div>
                <div>
                    <span class="st-2-img-2"></span>
                    <div class="box">
                        <p>Personaliza y configura tus encuestas de acuerdo a tus necesidades, en el momento que quieras.</p>
                    </div>
                </div>
                <div>
                    <span class="st-2-img-3"></span>
                    <div class="box">
                        <p>Obtén en tiempo real, las métricas de las respuestas de tus consumidores y no dejes que se vaya insatisfecho.</p>
                    </div>
                </div>
            </div>
            <div class="space50"></div>
            <a data-button-modal="contact" class="btn">¡Lo quiero!</a>
            <div class="space50"></div>
        </div>
    </section>
    <section id="section-three">
        <div class="container">
            <h3>Aprovecha los comentarios y reseñas de sus usuarios, a través de nuestras herramientas.</h3>
            <figure>
                <img src="{$path.images}hi/reputation/st-3-img-1.png" alt="Comentarios">
            </figure>
        </div>
        <span class="st-2-img-1"></span>
    </section>
    <section id="section-four">
        <div class="container">
            <h3>Identifica las necesidades de tus clientes para maximizar su experiencia y convertirlos en clientes frecuentes.</h3>
        </div>
        <span>Comentarios reales, <br>son cambios reales.<span class="st-2-img-1"></span></span>
    </section>
    <section id="section-five">
        <div class="container">
            <h5>Personaliza</h5>
            <div>
                <img src="{$path.images}hi/reputation/pantalla_ipad.png" alt="iPad">
                <div class="content">
                    <h3>Nuestra herramienta es totalmente autogestionable.</h3>

                    <a data-button-modal="contact" class="btn">¡Lo quiero!</a>
                </div>
            </div>
        </div>
    </section>
    <section id="section-six">
        <div class="container">
            <h3>Decide la cantidad de preguntas y subpreguntas que requieres, modifícalas sin restricciones en cualquier momento.</h3>
        </div>
    </section>
    <section id="section-seven">
        <div class="container">
            <h3>Visualiza las métricas y datos generados de las encuestas realizadas por tus clientes y toma acciones concretas para mejorar el servicio.</h3>

            <img src="{$path.images}hi/reputation/graficas.png" alt="graficas">
        </div>
    </section>
    <section id="section-eight">
        <div class="container">
            <h3>Identifica tus áreas de oportunidad y haz inteligencia de negocio.</h3>

            <p><span>Convierte</span> Convierte los datos en mejoras del servicio</p>
        </div>
    </section>
    <section id="section-nine" class="gradient-c-r">
        <div class="container">
            <div class="content">
                <img src="https://api.qrserver.com/v1/create-qr-code/?size=200x200&data=https://guestvox.com/demorestaurante/myvox" alt="QR Demo">
                <h4>Contesta nuestra encuesta.</h4>
                <p>*Si pones puntuación negativa o menos de 3, se despliega pregunta secundaria.</p>
            </div>
            <h3>VIVE NUESTRA <strong>EXPERIENCIA</strong></h3>
        </div>
    </section>
    <section id="section-ten" class="gradient-c-l">
        <div class="container">
            <div class="content">
                <h3>Quiero agendar una demo</h3>
                <a data-button-modal="contact" class="btn">¡Agendar ahora!</a>
            </div>
            <div class="content">
                <figure class="logotype">
                    <img src="{$path.images}hi/reputation/logotype.svg" alt="Guestvox logotipo">
                </figure>

                <a href="https://facebook.com/guestvox" class="social-media fb-logo" target="_blank">FB</a>
                <a href="https://www.youtube.com/channel/UCKSAce4n1NqahbL5RQ8QN9Q" class="social-media yt-logo" target="_blank">YT</a>
                <a href="https://instagram.com/guestvox" class="social-media ig-logo" target="_blank">IG</a>
                <a href="https://linkedin.com/guestvox" class="social-media in-logo" target="_blank">IN</a>
            </div>
        </div>
    </section>
</main>
<section class="modal" data-modal="contact">
    <div class="content">
        <header>
            <h3>Pongamonos en contacto</h3>
        </header>
        <main>
            <form name="contact">
                <div class="row">
                    <div class="span12">
                        <div class="label">
                            <label>
                                <p>Nombre del negocio</p>
                                <input type="text" name="business" />
                            </label>
                        </div>
                    </div>
                    <div class="span12">
                        <div class="label">
                            <label>
                                <p>Nombre de contacto</p>
                                <input type="text" name="contact" />
                            </label>
                        </div>
                    </div>
                    <div class="span6">
                        <div class="label">
                            <label>
                                <p>Correo electrónico</p>
                                <input type="text" name="email" />
                            </label>
                        </div>
                    </div>
                    <div class="span6">
                        <div class="label">
                            <label>
                                <p>Teléfono</p>
                                <input type="text" name="phone" />
                            </label>
                        </div>
                    </div>
                    <div class="span12">
                        <p style="font-size: 10px; line-height: 1.3; opacity: 0.5; margin-bottom: 0px;">Al enviar este formulario, solicitará que un representante de Guestvox S.A.P.I de C.V. se ponga en contacto con usted por teléfono o correo electrónico en los próximos días.</p>
                    </div>
                </div>
            </form>
        </main>
        <footer>
            <div class="action-buttons">
                <button class="btn btn-flat" button-cancel>{$lang.cancel}</button>
                <button class="btn btn-colored" button-success>¡Contáctenme!</button>
            </div>
        </footer>
    </div>
</section>
