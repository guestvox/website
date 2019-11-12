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
                <main>
                    <div class="profile">
                        <div class="uploader">
                            <fieldset>
                                <figure>
                                    <img src="{$avatar}" alt="" data-image-preview>
                                    <a data-image-select><i class="fas fa-upload"></i></a>
                                </figure>
                                <input type="file" name="avatar" accept="image/*" data-image-upload>
                            </fieldset>
                        </div>
                        <h2>{$name} {$lastname}</h2>
                        <h4>{$account}</h4>
                        <h6><span><i class="fas fa-envelope"></i>{$email}</span><span><i class="fas fa-phone"></i>{$cellphone}</span><span><i class="fas fa-user"></i>{$profilename}</span><span><i class="fas fa-lock"></i>{$profile_level}</span></h6>
                        {$temporal_password}
                        <div class="">
                            <a class="btn" data-button-modal="edit_profile">{$lang.edit_profile}</a>
                            <a class="btn" data-button-modal="reset_password">{$lang.restore_password}</a>
                        </div>
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
                                <input type="text" name="username" value="{$profilename}"/>
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
                                <p>{$lang.password}</p>
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
