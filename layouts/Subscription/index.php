<?php

defined('_EXEC') or die;

$this->dependencies->add(['css', '{$path.plugins}data-tables/jquery.dataTables.min.css']);
$this->dependencies->add(['js', '{$path.plugins}data-tables/jquery.dataTables.min.js']);

$this->dependencies->add(['js', '{$path.js}Subscription/index.js']);

$this->dependencies->add(['other', '<script>menu_focus("subscription");</script>']);

?>

%{header}%
<main>
    <section class="box-container complete">
        <div class="main">
            <article>
                <main class="tables">

                </main>
            </article>
        </div>
    </section>
</main>
