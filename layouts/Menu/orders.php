<?php

defined('_EXEC') or die;

$this->dependencies->add(['js', '{$path.js}Menu/orders.js?v=1.0']);
$this->dependencies->add(['other', '<script>menu_focus("menu_orders");</script>']);
$this->dependencies->add(['other', '<script async defer src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBLCea8Q6BtcTHwY3YFCiB0EoHE5KnsMUE"></script>']);

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
            <div id="menu_order_map"></div>
            <div class="buttons">
                <a class="success" button-close><i class="fas fa-check"></i></a>
            </div>
        </main>
    </div>
</section>
<section class="modal delete" data-modal="decline_menu_order">
    <div class="content">
        <footer>
            <a button-close><i class="fas fa-times"></i></a>
            <a button-success><i class="fas fa-check"></i></a>
        </footer>
    </div>
</section>
<section class="modal edit" data-modal="accept_menu_order">
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
