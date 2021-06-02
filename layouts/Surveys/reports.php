<?php

defined('_EXEC') or die;

$this->dependencies->add(['js', '{$path.js}Surveys/reports.js']);
$this->dependencies->add(['other', '<script>menu_focus("surveys_reports_{$menu_focus}");</script>']);

?>

%{header}%
<main class="dashboard">
    <section class="workspace" style="padding:40px;">
        <div class="row" style="margin-bottom:60px;">
            <div class="span6">
                <figure>
                    <img src="{$path.uploads}<?php echo Session::get_value('account')['logotype']; ?>" style="width:auto;height:200px;">
                </figure>
            </div>
            <div class="span6">
                <h1 style="font-size:24px;text-transform:uppercase;text-align:right;color:#212121;"><?php echo Session::get_value('account')['name']; ?></h1>
                <h2 style="font-size:18px;text-align:right;color:#757575;">Periodo del reporte: Del {$started_date} al {$end_date}</h2>
                <h2 style="font-size:18px;text-align:right;color:#757575;">Reporte generado el <?php echo Functions::get_current_date(); ?></h2>
                <figure style="text-align:right;">
                    <img src="{$path.uploads}{$qr}" style="width:auto;height:100px;">
                </figure>
            </div>
            <div class="span12" style="text-align:right;">
                <a href="" class="btn" data-button-modal="filter_surveys_reports"><i class="fas fa-sync-alt" style="margin-right:10px;"></i>Actualizar datos</a>
                <a href="" class="btn" data-button-modal="send_survey_report" style="background-color:#2196F3;color:#fff;"><i class="fas fa-envelope" style="margin-right:10px;"></i>Enviar por correo electrónico</a>
                <!-- <?php if (Functions::check_user_access(['{surveys_reports_create}']) == true) : ?>
                <a href="" class="btn" data-button-modal="save_survey_report"><i class="fas fa-save" style="margin-right:10px;"></i>Guardar búsqueda</a>
                <?php endif; ?> -->
            </div>
        </div>
        {$tbl_report}
    </section>
    <section class="buttons">
        <div>
            <a href="/surveys" class="big delete"><i class="fas fa-times"></i></a>
        </div>
    </section>
</main>
<section class="modal fullscreen" data-modal="filter_surveys_reports">
    <div class="content">
        <main>
            <form name="filter_surveys_reports">
                <div class="row">
                    <div class="span4">
                        <div class="label">
                            <label required>
                                <p>Búsqueda</p>
                                <select name="search">
                                    <option value="period" <?php echo ((Session::get_value('settings')['surveys']['reports']['filter']['search'] == 'period') ? 'selected' : ''); ?>>Establecer periodo</option>
                                    <option value="date" <?php echo ((Session::get_value('settings')['surveys']['reports']['filter']['search'] == 'date') ? 'selected' : ''); ?>>Establecer fecha</option>
                                </select>
                            </label>
                        </div>
                    </div>
                    <div class="span4 <?php echo ((Session::get_value('settings')['surveys']['reports']['filter']['search'] == 'date') ? 'hidden' : ''); ?>">
                        <div class="label">
                            <label required>
                                <p>Tipo de periodo</p>
                                <select name="period_type">
                                    <option value="days" <?php echo ((Session::get_value('settings')['surveys']['reports']['filter']['period_type'] == 'days') ? 'selected' : ''); ?>>Días</option>
                                    <option value="months" <?php echo ((Session::get_value('settings')['surveys']['reports']['filter']['period_type'] == 'months') ? 'selected' : ''); ?>>Meses</option>
                                    <option value="years" <?php echo ((Session::get_value('settings')['surveys']['reports']['filter']['period_type'] == 'years') ? 'selected' : ''); ?>>Años</option>
                                </select>
                            </label>
                        </div>
                    </div>
                    <div class="span4 <?php echo ((Session::get_value('settings')['surveys']['reports']['filter']['search'] == 'date') ? 'hidden' : ''); ?>">
                        <div class="label">
                            <label required>
                                <p># Periodo</p>
                                <input type="number" name="period_number" value="<?php echo Session::get_value('settings')['surveys']['reports']['filter']['period_number']; ?>">
                            </label>
                        </div>
                    </div>
                    <div class="span4 <?php echo ((Session::get_value('settings')['surveys']['reports']['filter']['search'] == 'period') ? 'hidden' : ''); ?>">
                        <div class="label">
                            <label required>
                                <p>{$lang.started_date}</p>
                                <input type="date" name="started_date" value="<?php echo Session::get_value('settings')['surveys']['reports']['filter']['started_date']; ?>">
                            </label>
                        </div>
                    </div>
                    <div class="span4 <?php echo ((Session::get_value('settings')['surveys']['reports']['filter']['search'] == 'period') ? 'hidden' : ''); ?>">
                        <div class="label">
                            <label required>
                                <p>{$lang.end_date}</p>
                                <input type="date" name="end_date" value="<?php echo Session::get_value('settings')['surveys']['reports']['filter']['end_date']; ?>">
                            </label>
                        </div>
                    </div>
                    <div class="span6">
                        <div class="label">
                            <label required>
                                <p>{$lang.owner}</p>
                                <select name="owner">
                                    <option value="all" <?php echo ((Session::get_value('settings')['surveys']['reports']['filter']['owner'] == 'all') ? 'selected' : ''); ?>>{$lang.all}</option>
                                    <option value="not_owner" <?php echo ((Session::get_value('settings')['surveys']['reports']['filter']['owner'] == 'not_owner') ? 'selected' : ''); ?>>Sin propietarios</option>
                                    {$opt_owners}
                                </select>
                            </label>
                        </div>
                    </div>
                    <div class="span6">
                        <div class="label">
                            <label required>
                                <p>{$lang.rating}</p>
                                <select name="rating">
                                    <option value="all" <?php echo ((Session::get_value('settings')['surveys']['reports']['filter']['rating'] == 'all') ? 'selected' : ''); ?>>{$lang.all}</option>
                                    <option value="1" <?php echo ((Session::get_value('settings')['surveys']['reports']['filter']['rating'] == '1') ? 'selected' : ''); ?>>1</option>
                                    <option value="2" <?php echo ((Session::get_value('settings')['surveys']['reports']['filter']['rating'] == '2') ? 'selected' : ''); ?>>2</option>
                                    <option value="3" <?php echo ((Session::get_value('settings')['surveys']['reports']['filter']['rating'] == '3') ? 'selected' : ''); ?>>3</option>
                                    <option value="4" <?php echo ((Session::get_value('settings')['surveys']['reports']['filter']['rating'] == '4') ? 'selected' : ''); ?>>4</option>
                                    <option value="5" <?php echo ((Session::get_value('settings')['surveys']['reports']['filter']['rating'] == '5') ? 'selected' : ''); ?>>5</option>
                                </select>
                            </label>
                        </div>
                    </div>
                    <div class="span4">
                        <div class="label">
                            <label unrequired>
                                <p>Incluír información general</p>
                                <div class="switch">
                                    <input id="iigsw" type="checkbox" name="general" <?php echo ((Session::get_value('settings')['surveys']['reports']['filter']['general'] == true) ? 'checked' : ''); ?> data-switcher>
                                    <label for="iigsw"></label>
                                </div>
                            </label>
                        </div>
                    </div>
                    <div class="span4">
                        <div class="label">
                            <label unrequired>
                                <p>Incluír canales</p>
                                <div class="switch">
                                    <input id="icasw" type="checkbox" name="channels" <?php echo ((Session::get_value('settings')['surveys']['reports']['filter']['channels'] == true) ? 'checked' : ''); ?> data-switcher>
                                    <label for="icasw"></label>
                                </div>
                            </label>
                        </div>
                    </div>
                    <div class="span4">
                        <div class="label">
                            <label unrequired>
                                <p>Incluír comentarios</p>
                                <div class="switch">
                                    <input id="icosw" type="checkbox" name="comments" <?php echo ((Session::get_value('settings')['surveys']['reports']['filter']['comments'] == true) ? 'checked' : ''); ?> data-switcher>
                                    <label for="icosw"></label>
                                </div>
                            </label>
                        </div>
                    </div>
                    <div class="span12">
                        <div class="buttons">
                            <a class="delete" button-close><i class="fas fa-times"></i></a>
                            <button type="submit" class="new"><i class="fas fa-check"></i></button>
                        </div>
                    </div>
                </div>
            </form>
        </main>
    </div>
</section>
<section class="modal fullscreen" data-modal="send_survey_report">
    <div class="content">
        <main>
            <form name="send_survey_report">
                <div class="row">
                    <div class="span12">
                        <div class="label">
                            <label required>
                                <p>Correos electrónicos</p>
                                <input type="text" name="emails" placeholder="Por favor, separa los correos con una coma. (Ej. correo1@ejemplo.com, correo2@ejemplo.com, etc)">
                                <span></span>
                            </label>
                        </div>
                    </div>
                    <div class="span12">
                        <div class="buttons">
                            <a class="delete" button-close><i class="fas fa-times"></i></a>
                            <button type="submit" class="new"><i class="fas fa-check"></i></button>
                        </div>
                    </div>
                </div>
            </form>
        </main>
    </div>
</section>
<!-- <?php if (Functions::check_user_access(['{surveys_reports_create}']) == true) : ?>
<section class="modal fullscreen" data-modal="filter_surveys_reports">
    <div class="content">
        <main>
            <form name="filter_surveys_reports">
                <div class="row">
                    <div class="span6">
                        <div class="label">
                            <label required>
                                <p>{$lang.started_date}</p>
                                <input type="date" name="started_date" value="<?php echo Session::get_value('settings')['surveys']['reports']['filter']['started_date']; ?>">
                            </label>
                        </div>
                    </div>
                    <div class="span6">
                        <div class="label">
                            <label required>
                                <p>{$lang.end_date}</p>
                                <input type="date" name="end_date" value="<?php echo Session::get_value('settings')['surveys']['reports']['filter']['end_date']; ?>">
                            </label>
                        </div>
                    </div>
                    <div class="span6">
                        <div class="label">
                            <label required>
                                <p>{$lang.owner}</p>
                                <select name="owner">
                                    <option value="all" <?php echo ((Session::get_value('settings')['surveys']['reports']['filter']['owner'] == 'all') ? 'selected' : ''); ?>>{$lang.all}</option>
                                    <option value="not_owner" <?php echo ((Session::get_value('settings')['surveys']['reports']['filter']['owner'] == 'not_owner') ? 'selected' : ''); ?>>Sin propietarios</option>
                                    {$opt_owners}
                                </select>
                            </label>
                        </div>
                    </div>
                    <div class="span6">
                        <div class="label">
                            <label required>
                                <p>{$lang.rating}</p>
                                <select name="rating">
                                    <option value="all" <?php echo ((Session::get_value('settings')['surveys']['reports']['filter']['rating'] == 'all') ? 'selected' : ''); ?>>{$lang.all}</option>
                                    <option value="1" <?php echo ((Session::get_value('settings')['surveys']['reports']['filter']['rating'] == '1') ? 'selected' : ''); ?>>1</option>
                                    <option value="2" <?php echo ((Session::get_value('settings')['surveys']['reports']['filter']['rating'] == '2') ? 'selected' : ''); ?>>2</option>
                                    <option value="3" <?php echo ((Session::get_value('settings')['surveys']['reports']['filter']['rating'] == '3') ? 'selected' : ''); ?>>3</option>
                                    <option value="4" <?php echo ((Session::get_value('settings')['surveys']['reports']['filter']['rating'] == '4') ? 'selected' : ''); ?>>4</option>
                                    <option value="5" <?php echo ((Session::get_value('settings')['surveys']['reports']['filter']['rating'] == '5') ? 'selected' : ''); ?>>5</option>
                                </select>
                            </label>
                        </div>
                    </div>
                    <div class="span4">
                        <div class="label">
                            <label unrequired>
                                <p>Incluír información general</p>
                                <div class="switch">
                                    <input id="iigsw" type="checkbox" name="general" <?php echo ((Session::get_value('settings')['surveys']['reports']['filter']['general'] == true) ? 'checked' : ''); ?> data-switcher>
                                    <label for="iigsw"></label>
                                </div>
                            </label>
                        </div>
                    </div>
                    <div class="span4">
                        <div class="label">
                            <label unrequired>
                                <p>Incluír canales</p>
                                <div class="switch">
                                    <input id="icasw" type="checkbox" name="channels" <?php echo ((Session::get_value('settings')['surveys']['reports']['filter']['channels'] == true) ? 'checked' : ''); ?> data-switcher>
                                    <label for="icasw"></label>
                                </div>
                            </label>
                        </div>
                    </div>
                    <div class="span4">
                        <div class="label">
                            <label unrequired>
                                <p>Incluír comentarios</p>
                                <div class="switch">
                                    <input id="icosw" type="checkbox" name="comments" <?php echo ((Session::get_value('settings')['surveys']['reports']['filter']['comments'] == true) ? 'checked' : ''); ?> data-switcher>
                                    <label for="icosw"></label>
                                </div>
                            </label>
                        </div>
                    </div>
                    <div class="span12">
                        <div class="buttons">
                            <a class="delete" button-close><i class="fas fa-times"></i></a>
                            <button type="submit" class="new"><i class="fas fa-check"></i></button>
                        </div>
                    </div>
                </div>
            </form>
        </main>
    </div>
</section>
<?php endif; ?> -->
