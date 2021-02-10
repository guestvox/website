<?php

defined('_EXEC') or die;

$this->dependencies->add(['js', '{$path.js}Menu/orders.js']);
$this->dependencies->add(['other', '<script>menu_focus("menu_orders");</script>']);

?>

%{header}%
<main class="dashboard">
    <section class="workspace">
        <div class="tbl_stl_2" data-table>
            {$tbl_menu_orders}
        </div>
    </section>
</main>
<section class="modal fullscreen" data-modal="view_map_menu_order">
    <div class="content">
        <main>
            <div id="view_map_menu_order"></div>
        </main>
    </div>
</section>
<section class="modal new" data-modal="accept_menu_order">
    <div class="content">
        <footer>
            <a button-close><i class="fas fa-times"></i></a>
            <a button-success><i class="fas fa-check"></i></a>
        </footer>
    </div>
</section>
<section class="modal new" data-modal="deliver_menu_order">
    <div class="content">
        <footer>
            <a button-close><i class="fas fa-times"></i></a>
            <a button-success><i class="fas fa-check"></i></a>
        </footer>
    </div>
</section>
