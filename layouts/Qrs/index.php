<?php

defined('_EXEC') or die;

$this->dependencies->add(['js', '{$path.js}Qrs/index.js']);
$this->dependencies->add(['other', '<script>menu_focus("qrs");</script>']);

?>

%{header}%
<main class="dashboard">
    <section class="workspace">
        <div class="qrs">
            <div>
                {$fgr_qr_menu_delivery}
                {$fgr_qr_reviews}
            </div>
            <div>
                <div>
    				<p>{$lang.to_get_personal_qr}</p>
    			</div>
                {$div_url_menu_delivery}
                {$div_url_reviews}
            </div>
        </div>
    </section>
</main>
