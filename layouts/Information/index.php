<?php

defined('_EXEC') or die;

$this->dependencies->add(['css', '{$path.plugins}data-tables/jquery.dataTables.min.css']);
$this->dependencies->add(['js', '{$path.plugins}data-tables/jquery.dataTables.min.js']);
$this->dependencies->add(['js', '{$path.js}Information/index.js']);
$this->dependencies->add(['other', '<script>menu_focus("other");</script>']);

?>

%{header}%
<main>
    <nav>
        <h2><i class="fas fa-compass"></i>{$lang.myvox_information}</h2>
    </nav>
    <article>
        <main>
            <div class="table">
                <aside>
                    <label>
                        <span><i class="fas fa-search"></i></span>
                        <input type="text" name="tbl_myvox_information_search">
                    </label>
                    <a data-button-modal="new_myvox_information" class="new"><i class="fas fa-plus"></i></a>
                </aside>
                <table id="tbl_myvox_information">
                    <thead>
                        <tr>
                            <th align="left">{$lang.name}</th>
                            <th align="left">{$lang.description}</th>
                            <!-- <th align="left" class="flag">{$lang.files}</th> -->
                            <th align="right" class="icon"></th>
                            <th align="right" class="icon"></th>
                        </tr>
                    </thead>
                    <tbody>
                        {$tbl_myvox_information}
                    </tbody>
                </table>
            </div>
        </main>
    </article>
</main>
<section class="modal new" data-modal="new_myvox_information">
    <div class="content">
        <header>
            <h3>{$lang.new}</h3>
        </header>
        <main>
            <form name="new_myvox_information">
                <div class="row">
                    <div class="span6">
                        <div class="label">
                            <label>
                                <p>(ES) {$lang.name}</p>
                                <input type="text" name="name_es" />
                            </label>
                        </div>
                    </div>
                    <div class="span6">
                        <div class="label">
                            <label>
                                <p>(EN) {$lang.name}</p>
                                <input type="text" name="name_en" />
                            </label>
                        </div>
                    </div>
                    <div class="span12">
                        <div class="label">
                            <label>
                                <p>(EN) {$lang.name}</p>
                                <textarea name="description" rows="8" cols="80"></textarea>
                            </label>
                        </div>
                    </div>
                    <!-- <div class="span12">
                        <figure>
                            <img src="{$file_image}" data-image-preview>
                            <a data-image-select><i class="fas fa-upload"></i></a>
                            <input type="file" name="file_image" accept="image/*" data-image-upload>
                        </figure>
                    </div> -->
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
<section class="modal delete" data-modal="delete_myvox_information">
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
