<?php

defined('_EXEC') or die;

$this->dependencies->add(['js', '{$path.js}Profile/index.js']);
$this->dependencies->add(['other', '<script>menu_focus("other");</script>']);

?>

%{header}%
<main>
    <article>
        <header>
            <h2><i class="fas fa-user-circle"></i>{$lang.my_profile}</h2>
        </header>
        <main>
            <div class="profile">
                <figure>
                    <img src="{$avatar}" data-image-preview>
                    <a data-image-select><i class="fas fa-upload"></i></a>
                    <input type="file" name="avatar" accept="image/*" data-image-upload>
                </figure>
                <div>
                    <h6><i class="fas fa-user-alt"></i>{$firstname} {$lastname}</h6>
                    <h6><i class="fas fa-envelope"></i>{$email}</h6>
                    <h6><i class="fas fa-mobile-alt"></i>+{$phone_lada} {$phone_number}</h6>
                    <h6><i class="fas fa-shield-alt"></i>{$username}</h6>
                    <h6><i class="fas fa-lock"></i>{$user_permissions}</h6>
                    <a data-button-modal="restore_password"><i class="fas fa-key"></i></a>
                    <a data-button-modal="edit_profile" class="edit"><i class="fas fa-pencil-alt"></i></a>
                </div>
            </div>
        </main>
    </article>
</main>
<section class="modal edit" data-modal="edit_profile">
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
                                <input type="text" name="firstname" value="{$firstname}" />
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
                    <div class="span6">
                        <div class="label">
                            <label>
                                <p>{$lang.email}</p>
                                <input type="email" name="email" value="{$email}" />
                            </label>
                        </div>
                    </div>
                    <div class="span3">
                        <div class="label">
                            <label>
                                <p>{$lang.lada}</p>
                                <select name="phone_lada">
                                    {$opt_ladas}
                                </select>
                            </label>
                        </div>
                    </div>
                    <div class="span3">
                        <div class="label">
                            <label>
                                <p>{$lang.phone}</p>
                                <input type="text" name="phone_number" value="{$phone_number}" />
                            </label>
                        </div>
                    </div>
                    <div class="span12">
                        <div class="label">
                            <label>
                                <p>{$lang.username}</p>
                                <input type="text" name="username" value="{$username}" />
                            </label>
                        </div>
                    </div>
                </div>
            </form>
        </main>
        <footer>
            <div class="action-buttons">
                <button class="btn btn-flat" button-cancel>{$lang.cancel}</button>
                <button class="btn" button-success>{$lang.accept}</button>
            </div>
        </footer>
    </div>
</section>
<section class="modal" data-modal="restore_password">
    <div class="content">
        <header>
            <h3>{$lang.restore_password}</h3>
        </header>
        <main>
            <form name="restore_password">
                <div class="row">
                    <div class="span12">
                        <div class="label">
                            <label>
                                <p>{$lang.password}</p>
                                <input type="text" name="password" />
                            </label>
                        </div>
                    </div>
                </div>
            </form>
        </main>
        <footer>
            <div class="action-buttons">
                <button class="btn btn-flat" button-cancel>{$lang.cancel}</button>
                <button class="btn" button-success>{$lang.accept}</button>
            </div>
        </footer>
    </div>
</section>
