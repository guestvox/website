<?php

defined('_EXEC') or die;

$this->dependencies->add(['js', '{$path.js}Qr/index.js']);
$this->dependencies->add(['other', '<script>menu_focus("qr");</script>']);

?>

%{header}%
<main class="dashboard">
    <section class="workspace">
        <div class="qr">
            <figure>
                <img src="{$path.uploads}<?php echo Session::get_value('account')['qr']; ?>">
            </figure>
            <div>
    			<div>
    				<p><strong>{$lang.myvox}:</strong><span><?php echo 'https://' . Configuration::$domain . '/' . Session::get_value('account')['path'] . '/myvox'; ?></span></p>
    				<a href="<?php echo 'https://' . Configuration::$domain . '/' . Session::get_value('account')['path'] . '/myvox'; ?>" target="_blank"><i class="fas fa-share"></i></a>
    				<a data-action="copy_to_clipboard"><i class="fas fa-copy"></i></a>
    			</div>
                {$div_url_reviews}
            </div>
        </div>
    </section>
</main>
