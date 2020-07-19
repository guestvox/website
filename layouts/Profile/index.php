<?php

defined('_EXEC') or die;

$this->dependencies->add(['js', '{$path.js}Profile/index.js']);
$this->dependencies->add(['other', '<script>menu_focus("my_profile");</script>']);

?>

%{header}%
<main class="dashboard">
    <section class="workspace">
        <div class="profile">
            <div class="stl_1" data-uploader="fast">
                <figure data-preview>
                    <img src="{$avatar}">
                    <a data-action="edit_avatar" data-select><i class="fas fa-upload"></i></a>
                    <input type="file" name="avatar" accept="image/*" data-upload>
                </figure>
            </div>
            <h1>{$name}</h1>
            <span>{$username}</span>
            <span>{$email}</span>
            <span>{$phone}</span>
        </div>
    </section>
    <section class="buttons">
        <div>
            <a class="big new" data-button-modal="restore_password"><i class="fas fa-key"></i><span>{$lang.restore_password}</span></a>
            <a class="edit" data-action="edit_profile"><i class="fas fa-pen"></i></a>
        </div>
    </section>
</main>
<section class="modal fullscreen" data-modal="edit_profile">
    <div class="content">
        <main>
            <form name="edit_profile">
                <div class="row">
                    <div class="span6">
                        <div class="label">
                            <label required>
                                <p>{$lang.firstname}</p>
                                <input type="text" name="firstname">
                            </label>
                        </div>
                    </div>
                    <div class="span6">
                        <div class="label">
                            <label required>
                                <p>{$lang.lastname}</p>
                                <input type="text" name="lastname">
                            </label>
                        </div>
                    </div>
                    <div class="span6">
                        <div class="label">
                            <label required>
                                <p>{$lang.email}</p>
                                <input type="email" name="email">
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
                                <input type="text" name="phone_number">
                            </label>
                        </div>
                    </div>
                    <div class="span12">
                        <div class="label">
                            <label required>
                                <p>{$lang.username}</p>
                                <input type="text" name="username">
                            </label>
                        </div>
                    </div>
                    <div class="span12">
                        <div class="buttons">
                            <a class="delete" button-cancel><i class="fas fa-times"></i></a>
                            <button type="submit" class="new"><i class="fas fa-check"></i></button>
                        </div>
                    </div>
                </div>
            </form>
        </main>
    </div>
</section>
<section class="modal fullscreen" data-modal="restore_password">
    <div class="content">
        <main>
            <form name="restore_password">
                <div class="row">
                    <div class="span12">
                        <div class="label">
                            <label required>
                                <p>{$lang.password}</p>
                                <input type="password" name="password">
                            </label>
                        </div>
                    </div>
                    <div class="span12">
                        <div class="buttons">
                            <a class="delete" button-cancel><i class="fas fa-times"></i></a>
                            <button type="submit" class="new"><i class="fas fa-check"></i></button>
                        </div>
                    </div>
                </div>
            </form>
        </main>
    </div>
</section>
