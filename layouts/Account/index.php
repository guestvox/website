<?php

defined('_EXEC') or die;

$this->dependencies->add(['js', '{$path.js}Profile/index.js']);
$this->dependencies->add(['other', '<script>menu_focus("account");</script>']);

?>

%{header}%
<main>
    <section class="box-container complete">
        <div class="main">
            <div class="account">
                <div class="item">
                    <div class="row">
                        <div class="span12">
                            <div class="label">
                                <label>
                                    <p>{$lang.user_level}</p>
                                    <input type="text" name="">
                                </label>
                            </div>
                        </div>
                        <div class="span6">
                            <div class="label">
                                <label>
                                    <p>{$lang.n_rooms}</p>
                                    <input type="number" name="">
                                </label>
                            </div>
                        </div>
                        <div class="span6">
                            <div class="label">
                                <label>
                                    <p>{$lang.n_users}</p>
                                    <input type="number" name="">
                                </label>
                            </div>
                        </div>


                        <div class="span6">
                            <div class="label">
                                <label>
                                    <p>{$lang.user_level}</p>
                                    <select name="">
                                        <option value="" selected hidden>{$lang.choose}</option>

                                    </select>
                                </label>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="item">
                    <div class="uploader">
                        <figure>
                            <img src="{$path.images}empty.png" alt="" data-image-preview>
                            <a data-image-select><i class="fas fa-upload"></i></a>
                        </figure>
                        <input type="file" name="logotype" accept="image/*" data-image-upload>
                    </div>
                </div>
                <div class="item">

                </div>
                <!-- <div class="account">
                    <div class="uploader">
                        <figure>
                            <img src="{$path.images}empty.png" alt="" data-image-preview>
                            <a data-image-select><i class="fas fa-upload"></i></a>
                        </figure>
                        <input type="file" name="logotype" accept="image/*" data-image-upload>
                    </div>
                    <h2>{$name}</h2>
                    <h4>{$signup_date}</h4>
                    <h6><span><i class="fas fa-envelope"></i>{$currency}</span><span><i class="fas fa-phone"></i>{$language}</span><span><i class="fas fa-user"></i>{$country}</span><span><i class="fas fa-lock"></i>{$time_zone}</span></h6>
                    <div class="">
                        <a class="btn" data-button-modal="edit_profile">Editar perfil</a>
                        <a class="btn" data-button-modal="reset_password">Restablecer contraseña</a>
                    </div>
                </div> -->
            </div>
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
                                <p>{$lang.firstname}</p>
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
