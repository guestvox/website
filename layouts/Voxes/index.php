<?php

defined('_EXEC') or die;

$this->dependencies->add(['css', '{$path.plugins}data-tables/jquery.dataTables.min.css']);
$this->dependencies->add(['js', '{$path.plugins}data-tables/jquery.dataTables.min.js']);
$this->dependencies->add(['js', '{$path.js}Voxes/index.js']);
$this->dependencies->add(['other', '<script>menu_focus("voxes");</script>']);

?>

%{header}%
<main>
    <section class="box-container complete">
        <div class="main">
            <article>
                <main class="tables">
                    <div class="search">
                        <div class="label">
                            <label>
                                <input name="search" type="text" placeholder="{$lang.search}">
                            </label>
                        </div>
                    </div>
                    <div class="table-container">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th align="left">{$lang.abr_room}</th>
                                    <th align="left">{$lang.abr_guest}</th>
                                    <th align="left">{$lang.abr_subject}</th>
                                    <th align="left">{$lang.abr_opportunity_area}</th>
                                    <th align="left">{$lang.abr_opportunity_type}</th>
                                    <th align="left">{$lang.abr_location}</th>
                                    <th align="left">{$lang.abr_started_date}</th>
                                    <th align="left">{$lang.abr_elapsed_time}</th>
                                    <th align="right" class="icon"></th>
                                    <th align="right" class="icon"></th>
                                    <th align="right" class="icon"></th>
                                    <th align="right" class="icon"></th>
                                    <th align="right" class="icon"></th>
                                </tr>
                            </thead>
                            <tbody>
                                {$tbl_voxes}
                            </tbody>
                        </table>
                    </div>
                </main>
            </article>
        </div>
    </section>
</main>
