<?php

defined('_EXEC') or die;

$this->dependencies->add(['js', '{$path.js}Support/index.js']);
$this->dependencies->add(['other', '<script>menu_focus("support");</script>']);

?>

%{header}%
<main class="dashboard">
    <section class="workspace">
        <div class="support">
            <form name="get_support">
                <div class="row">
                    <div class="span12">
                        <div class="label">
                            <label unrequired>
                                <p>{$lang.for}</p>
                                <input type="text" value="contacto@guestvox.com" disabled>
                            </label>
                        </div>
                    </div>
                    <div class="span12">
                        <div class="label">
                            <label required>
                                <p>{$lang.message}</p>
                                <textarea name="message"></textarea>
                            </label>
                        </div>
                    </div>
                    <div class="span12">
                        <div class="buttons">
                            <button type="submit" class="big new"><i class="fas fa-envelope"></i><span>{$lang.send_email}</span></button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </section>
</main>
