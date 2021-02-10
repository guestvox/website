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
                <figure>
                    <h2>Myvox</h2>
                    <img src="{$path.uploads}<?php echo Session::get_value('account')['qrs']['account']; ?>">
                </figure>
                {$fgr_qr_menu_delivery}
                {$fgr_qr_reviews}
            </div>
            <div>
    			<div>
    				<p><strong>Myvox:</strong><span><?php echo 'https://' . Configuration::$domain . '/' . Session::get_value('account')['path'] . '/myvox'; ?></span></p>
                    <a data-action="copy_to_clipboard"><i class="fas fa-copy"></i></a>
                    <a href="{$path.uploads}<?php echo Session::get_value('account')['qrs']['account']; ?>" download="<?php echo Session::get_value('account')['qrs']['account']; ?>"><i class="fas fa-download"></i></a>
                    <a href="<?php echo 'https://' . Configuration::$domain . '/' . Session::get_value('account')['path'] . '/myvox'; ?>" target="_blank"><i class="fas fa-share"></i></a>
    			</div>
                {$div_url_menu_delivery}
                {$div_url_reviews}
            </div>
        </div>
    </section>
</main>
