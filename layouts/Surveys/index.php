<?php

defined('_EXEC') or die;

$this->dependencies->add(['css', '{$path.plugins}chosen_select/chosen.css']);
$this->dependencies->add(['js', '{$path.plugins}chosen_select/chosen.jquery.js']);
$this->dependencies->add(['js', '{$path.js}Surveys/index.js?v=1.1']);
$this->dependencies->add(['other', '<script>menu_focus("surveys");</script>']);

?>

%{header}%
<main class="dashboard">
    <section class="workspace">
        <div class="tbl_stl_3" data-table>
            {$tbl_surveys}
        </div>
    </section>
    <section class="buttons">
        <?php if (Functions::check_user_access(['{surveys_questions_create}']) == true) : ?>
        <div>
            <a class="new" data-button-modal="new_survey"><i class="fas fa-plus"></i></a>
        </div>
        <?php endif; ?>
    </section>
</main>
<?php if (Functions::check_user_access(['{surveys_questions_create}','{surveys_questions_update}']) == true) : ?>
<section class="modal fullscreen" data-modal="new_survey">
    <div class="content">
        <main>
            <form name="new_survey">
                <div class="row" style="border:1px solid #e0e0e0;box-sizing:border-box;padding:20px;margin-bottom:20px;">
                    <h6 style="font-size:12px;font-weight:600;text-transform:uppercase;padding-bottom:10px;margin-bottom:10px;border-bottom:1px solid #e0e0e0;">Configuración general</h6>
                    <div class="span6">
                        <div class="label">
                            <label required>
                                <p>(ES) {$lang.name}</p>
                                <input type="text" name="name_es" data-translates="name">
                            </label>
                        </div>
                    </div>
                    <div class="span6">
                        <div class="label">
                            <label required>
                                <p>(EN) {$lang.name}</p>
                                <input type="text" name="name_en" data-translaten="name">
                            </label>
                        </div>
                    </div>
                    <div class="span6">
                        <div class="label">
                            <label>
                                <p>(ES) Texto aleatorio</p>
                                <textarea name="text_es" data-translates="text_es"></textarea>
                            </label>
                        </div>
                    </div>
                    <div class="span6">
                        <div class="label">
                            <label>
                                <p>(EN) Texto aleatorio</p>
                                <textarea name="text_en" data-translates="text_en"></textarea>
                            </label>
                        </div>
                    </div>
                </div>
                <div class="row" style="border:1px solid #e0e0e0;box-sizing:border-box;padding:20px;margin-bottom:20px;">
                    <h6 style="font-size:12px;font-weight:600;text-transform:uppercase;padding-bottom:10px;margin-bottom:10px;border-bottom:1px solid #e0e0e0;">¿Establecer esta encuesta como predeterminada?</h6>
                    <div class="span6">
                        <div class="label">
                            <label unrequired>
                                <div class="switch">
                                    <input id="masw" type="checkbox" name="main" data-switcher>
                                    <label for="masw"></label>
                                </div>
                            </label>
                        </div>
                    </div>
                </div>
                <div class="row" style="border:1px solid #e0e0e0;box-sizing:border-box;padding:20px;margin-bottom:20px;">
                    <h6 style="font-size:12px;font-weight:600;text-transform:uppercase;padding-bottom:10px;margin-bottom:10px;border-bottom:1px solid #e0e0e0;">¿Activar solicitud de firma digital?</h6>
                    <div class="span6">
                        <div class="label">
                            <label unrequired>
                                <div class="switch">
                                    <input id="sgsw" type="checkbox" name="signature" data-switcher>
                                    <label for="sgsw"></label>
                                </div>
                            </label>
                        </div>
                    </div>
                </div>
                <div class="row" style="border:1px solid #e0e0e0;box-sizing:border-box;padding:20px;">
                    <h6 style="font-size:12px;font-weight:600;text-transform:uppercase;padding-bottom:10px;margin-bottom:10px;border-bottom:1px solid #bdbdbd;">¿Configurar envío automático de reporte?</h6>
                    <div class="span6">
                        <div class="label">
                            <label unrequired>
                                <div class="switch">
                                    <input id="rssw" type="checkbox" name="report_status" data-switcher>
                                    <label for="rssw"></label>
                                </div>
                            </label>
                        </div>
                    </div>
                    <div class="span12 hidden">
                        <div class="label">
                            <label required>
                                <p>Envíar reporte en los días:</p>
                                <select name="report_days[]" class="chosen-select" multiple>
                                    <option value="monday" selected>{$lang.monday}</option>
                                    <option value="tuesday" selected>{$lang.tuesday}</option>
                                    <option value="wednesday" selected>{$lang.wednesday}</option>
                                    <option value="thursday" selected>{$lang.thursday}</option>
                                    <option value="friday" selected>{$lang.friday}</option>
                                    <option value="saturday" selected>{$lang.saturday}</option>
                                    <option value="sunday" selected>{$lang.sunday}</option>
                                </select>
                            </label>
                        </div>
                    </div>
                    <div class="span6 hidden">
                        <div class="label">
                            <label required>
                                <p>Envíar reporte a las:</p>
                                <input type="time" name="report_time" value="21:00:00">
                            </label>
                        </div>
                    </div>
                    <div class="span6 hidden">
                        <div class="label">
                            <label required>
                                <p>Notificar envío al correo electrónico:</p>
                                <input type="email" name="report_email" value="">
                            </label>
                        </div>
                    </div>
                </div>
                <div class="row">
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
<?php endif; ?>
<?php if (Functions::check_user_access(['{surveys_questions_deactivate}']) == true) : ?>
<section class="modal edit" data-modal="deactivate_survey">
    <div class="content">
        <footer>
            <a button-close><i class="fas fa-times"></i></a>
            <a button-success><i class="fas fa-check"></i></a>
        </footer>
    </div>
</section>
<?php endif; ?>
<?php if (Functions::check_user_access(['{surveys_questions_activate}']) == true) : ?>
<section class="modal edit" data-modal="activate_survey">
    <div class="content">
        <footer>
            <a button-close><i class="fas fa-times"></i></a>
            <a button-success><i class="fas fa-check"></i></a>
        </footer>
    </div>
</section>
<?php endif; ?>
<?php if (Functions::check_user_access(['{surveys_questions_delete}']) == true) : ?>
<section class="modal delete" data-modal="delete_survey">
    <div class="content">
        <footer>
            <a button-close><i class="fas fa-times"></i></a>
            <a button-success><i class="fas fa-check"></i></a>
        </footer>
    </div>
</section>
<?php endif; ?>
