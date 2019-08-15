<?php

defined('_EXEC') or die;

$this->dependencies->add(['js', '{$path.js}Profile/index.js']);
$this->dependencies->add(['other', '<script>menu_focus("profile");</script>']);

?>

%{header}%
<main>
    <section class="box-container complete">
        <div class="main">
            <article>
                <main class="tables">
                    <h4>Mi Perfil</h4>
                        <figure>
                            <img src="images/avatar.png" alt="">
                        </figure>
                        <h4>{$account}</h4>
                        <h4>{$name} {$lastname}</h4>
                        <h6>{$email}</h6>
                        <h6>{$cellphone}</h6>
                        <h6>{$username}</h6>
                        {$temporal_password}
                        <h6>{$user_level}</h6>
                        {$opportunity_areas}
                        {$user_permissions}
                        {$status}
                        <div class="buttons ">
							<a class="btn" data-button-modal="edit_profile">Editar perfil</a>
                            <a class="btn" data-button-modal="reset_password">Restablecer contraseña</a>
						</div>
                </main>
            </article>
        </div>
    </section>
</main>
<section class="modal" data-modal="edit_profile">
    <div class="content">
        <header>
            <h3>{$lang.edit}</h3>
        </header>
        <main>
            <form name="edit_profile">
                <div class="row">
                    <div class="span6">
                        <div class="label">
                            <label>
                                <p>{$lang.name}</p>
                                <input type="text" name="name" value="{$name}" />
                            </label>
                        </div>
                    </div>
                    <div class="span6">
                        <div class="label">
                            <label>
                                <p>{$lang.lastname}</p>
                                <input type="text" name="lastname" value="{$lastname}" />
                            </label>
                        </div>
                    </div>
                    <div class="span12">
                        <div class="label">
                            <label>
                                <p>{$lang.email}</p>
                                <input type="email" name="email" value="{$email}"/>
                            </label>
                        </div>
                    </div>
                    <div class="span12">
                        <div class="label">
                            <label>
                                <p>{$lang.cellphone}</p>
                                <input type="text" name="cellphone" value="{$cellphone}"/>
                            </label>
                        </div>
                    </div>
                    <div class="span12">
                        <div class="label">
                            <label>
                                <p>{$lang.username}</p>
                                <input type="text" name="username" value="{$username}"/>
                            </label>
                        </div>
                    </div>
                </div>
            </form>
        </main>
        <footer>
            <div class="action-buttons">
                <button class="btn btn-flat" button-close>{$lang.cancel}</button>
                <button class="btn" button-success>{$lang.accept}</button>
            </div>
        </footer>
    </div>
</section>
<section class="modal" data-modal="reset_password">
    <div class="content">
        <header>
            <h3>{$lang.edit}</h3>
        </header>
        <main>
            <form name="reset_password">
                <div class="row">
                    <div class="span12">
                        <div class="label">
                            <label>
                                <p>Contraseña</p>
                                <input type="password" name="password"/>
                            </label>
                        </div>
                    </div>
                </div>
            </form>
        </main>
        <footer>
            <div class="action-buttons">
                <button class="btn btn-flat" button-close>{$lang.cancel}</button>
                <button class="btn" button-success>{$lang.accept}</button>
            </div>
        </footer>
    </div>
</section>
