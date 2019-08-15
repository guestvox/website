<?php

defined('_EXEC') or die;

$this->dependencies->add(['css', '{$path.plugins}chosen-select/chosen.css']);
$this->dependencies->add(['js', '{$path.plugins}chosen-select/chosen.jquery.js']);
$this->dependencies->add(['css', '{$path.plugins}data-tables/jquery.dataTables.min.css']);
$this->dependencies->add(['js', '{$path.plugins}data-tables/jquery.dataTables.min.js']);
$this->dependencies->add(['css', '{$path.plugins}date-picker/jquery-ui.min.css']);
$this->dependencies->add(['js', '{$path.plugins}date-picker/jquery-ui.min.js']);
$this->dependencies->add(['css', '{$path.plugins}time-picker/timepicker.css']);
$this->dependencies->add(['js', '{$path.plugins}time-picker/timepicker.js']);
$this->dependencies->add(['js', '{$path.js}Tasks/index.js']);
$this->dependencies->add(['other', '<script>menu_focus("tasks");</script>']);

?>

%{header}%
<main>
    <section class="box-container complete">
        <div class="main">
            <article>
                <main class="tables">
                    <form name="new_task">
                        <div class="row">
                            <div class="span4">
                                <div class="label">
                                    <label>
                                        <p>Descripción</p>
                                        <input type="text" name="description" />
                                    </label>
                                </div>
                            </div>
                            <div class="span4">
                                <div class="label">
                                    <label>
                                        <p>{$lang.assigned_users}</p>
                                        <select name="assigned_users[]" class="chosen-select" multiple>
                                            {$opt_users}
                                        </select>
                                        <p class="description">{$lang.assigned_users_keep_in_mind}</p>
                                    </label>
                                </div>
                            </div>
                            <div class="span4">
                                <div class="label">
                                    <label>
                                        <p>{$lang.opportunity_area}</p>
                                        <select name="assigned_areas[]" class="chosen-select" multiple>
                                            {$opt_opportunity_areas}
                                        </select>
                                        <p class="description">{$lang.assigned_users_keep_in_mind}</p>
                                    </label>
                                </div>
                            </div>
                            <div class="span2">
                                <div class="label">
                                    <label>
                                        <p>{$lang.date}</p>
                                        <input type="text" name="creation_date" class="datepicker" placeholder="{$lang.choose}" value="<?php echo Functions::get_current_date('Y-m-d'); ?>" />
                                        <p class="description">{$lang.what_date_need}</p>
                                        <p class="description hidden">{$lang.what_date_happened}</p>
                                    </label>
                                </div>
                            </div>
                            <div class="span2">
                                <div class="label">
                                    <label>
                                        <p>{$lang.end_date}</p>
                                        <input type="text" name="expiration_date" class="datepicker" placeholder="{$lang.choose}" value="<?php echo Functions::get_current_date('Y-m-d'); ?>" />
                                    </label>
                                </div>
                            </div>
                            <div class="span2">
                                <div class="label">
                                    <label class="success">
                                        <p>{$lang.hour}</p>
                                        <div class="time__input">
                                            <input type="text" name="expiration_hour" class="timepicker" placeholder="{$lang.choose}" value="<?php echo Functions::get_current_hour(); ?>" />
                                        </div>
                                    </label>
                                </div>
                            </div>
                            <div class="span2">
                                <div class="label">
                                    <label>
                                        <p>Repetición</p>
                                        <select name="repetition">
                                            <option value="dayli">Diaria</option>
                                            <option value="weekly">Semanal</option>
                                            <option value="monthly">Mensual</option>
                                            <option value="annual">Anual</option>
                                            <option value="free">Libre</option>
                                        </select>
                                    </label>
                                </div>
                            </div>
                        </div>
                    </form>
                </main>
                <footer>
                    <div class="buttons text-center">
                        <a class="btn" data-action="new_task">{$lang.add}</a>
                    </div>
                </footer>
            </article>
            <article>
                <main class="tables">
                    <div class="table-container">
                        <table id="tasks" class="table">
                            <thead>
                                <tr>
                                    <th align="left">Descripción</th>
                                    <th align="left" width="100px">Fecha de creación</th>
                                    <th align="left" width="100px">Fecha de expiración</th>
                                    <th align="left" width="100px">Hora de expiración</th>
                                    <th align="left" width="100px">Repetición</th>
                                    <th align="right" class="icon"></th>
                                    <th align="right" class="icon"></th>
                                </tr>
                            </thead>
                            <tbody>
                                {$tbl_tasks}
                            </tbody>
                        </table>
                    </div>
                </main>
            </article>
        </div>
    </section>
</main>
<section class="modal" data-modal="delete_task">
    <div class="content">
        <header>
            <h3>{$lang.delete}</h3>
        </header>
        <footer>
            <div class="action-buttons">
                <button class="btn btn-flat" button-close>{$lang.cancel}</button>
                <button class="btn" button-success>{$lang.accept}</button>
            </div>
        </footer>
    </div>
</section>
<section class="modal" data-modal="edit_task">
    <div class="content">
        <header>
            <h3>{$lang.edit}</h3>
        </header>
        <main>
            <form name="edit_task">
                    <div class="row">
                        <div class="span12">
                            <div class="label">
                                <label>
                                    <p>Descripción</p>
                                    <input type="text" name="description" />
                                </label>
                            </div>
                        </div>
                        <div class="span5">
                            <div class="label">
                                <label>
                                    <p>{$lang.assigned_users}</p>
                                    <select name="assigned_users[]" class="chosen-select" multiple>
                                        {$opt_users}
                                    </select>
                                    <p class="description">{$lang.assigned_users_keep_in_mind}</p>
                                </label>
                            </div>
                        </div>
                        <div class="span4">
                            <div class="label">
                                <label>
                                    <p>{$lang.date}</p>
                                    <input type="text" name="creation_date" class="datepicker" placeholder="{$lang.choose}" value="<?php echo Functions::get_current_date('Y-m-d'); ?>" />
                                    <p class="description">{$lang.what_date_need}</p>
                                    <p class="description hidden">{$lang.what_date_happened}</p>
                                </label>
                            </div>
                        </div>
                        <div class="span4">
                            <div class="label">
                                <label>
                                    <p>{$lang.end_date}</p>
                                    <input type="text" name="expiration_date" class="datepicker" placeholder="{$lang.choose}" value="<?php echo Functions::get_current_date('Y-m-d'); ?>" />
                                </label>
                            </div>
                        </div>
                        <div class="span2">
                            <div class="label important">
                                <label class="success">
                                    <p>{$lang.hour}</p>
                                    <div class="time__input">
                                        <input type="text" name="expiration_hour" class="timepicker" placeholder="{$lang.choose}" value="<?php echo Functions::get_current_hour(); ?>" />
                                    </div>
                                </label>
                            </div>
                        </div>
                        <div class="span3">
                            <div class="label">
                                <label>
                                    <p>Repetición</p>
                                    <select name="repetition">
                                        <option value="dayli">Diaria</option>
                                        <option value="weekly">Semanal</option>
                                        <option value="monthly">Mensual</option>
                                        <option value="annual">Anual</option>
                                        <option value="free">Libre</option>
                                    </select>
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
