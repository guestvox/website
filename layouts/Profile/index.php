<?php

defined('_EXEC') or die;

$this->dependencies->add(['js', '{$path.js}Profile/index.js']);
$this->dependencies->add(['other', '<script>menu_focus("other");</script>']);

?>

%{header}%
<main class="dashboard">
    <section class="workspace">
        <div class="profile">
            <figure data-uploader>
                <img src="{$avatar}" data-image-preview>
                <a data-action="edit_avatar" data-type="fast" data-image-select><i class="fas fa-upload"></i></a>
                <input type="file" name="avatar" accept="image/*" data-image-upload>
            </figure>
            <h1>{$name}</h1>
            <span>{$username}</span>
            <span>{$email}</span>
            <span>{$phone}</span>
        </div>
    </section>
    <section class="buttons">
        <div>
            <a class="active" data-action="edit_profile"><i class="fas fa-pen"></i></a>
            <a data-button-modal="restore_password"><i class="fas fa-key"></i></a>
        </div>
    </section>
</main>
<section class="modal" data-modal="edit_profile">
    <div class="content">
        <main>
            <form name="edit_profile">
                <div class="row">
                    <div class="span6">
                        <div class="label">
                            <label required>
                                <p>{$lang.firstname}</p>
                                <input type="text" name="firstname" />
                            </label>
                        </div>
                    </div>
                    <div class="span6">
                        <div class="label">
                            <label required>
                                <p>{$lang.lastname}</p>
                                <input type="text" name="lastname" />
                            </label>
                        </div>
                    </div>
                    <div class="span6">
                        <div class="label">
                            <label required>
                                <p>{$lang.email}</p>
                                <input type="email" name="email" />
                            </label>
                        </div>
                    </div>
                    <div class="span3">
                        <div class="label">
                            <label required>
                                <p>{$lang.lada}</p>
                                <select name="phone_lada">
                                    {$opt_ladas}
                                </select>
                            </label>
                        </div>
                    </div>
                    <div class="span3">
                        <div class="label">
                            <label required>
                                <p>{$lang.phone}</p>
                                <input type="text" name="phone_number" />
                            </label>
                        </div>
                    </div>
                    <div class="span12">
                        <div class="label">
                            <label required>
                                <p>{$lang.username}</p>
                                <input type="text" name="username" />
                            </label>
                        </div>
                    </div>
                    <div class="span12">
                        <div class="buttons">
                            <button type="submit">{$lang.accept}</button>
                            <a button-cancel>{$lang.cancel}</a>
                        </div>
                    </div>
                </div>
            </form>
        </main>
    </div>
</section>
<section class="modal" data-modal="restore_password">
    <div class="content">
        <main>
            <form name="restore_password">
                <div class="row">
                    <div class="span12">
                        <div class="label">
                            <label required>
                                <p>{$lang.password}</p>
                                <input type="password" name="password" />
                            </label>
                        </div>
                    </div>
                    <div class="span12">
                        <div class="buttons">
                            <button type="submit">{$lang.accept}</button>
                            <a button-cancel>{$lang.cancel}</a>
                        </div>
                    </div>
                </div>
            </form>
        </main>
    </div>
</section>
