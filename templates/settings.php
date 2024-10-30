<?php
// Šablona stránky "nastavení"
?>

<div class="wrap">
    <h2>Nastavení pluginu</h2>
    <?php settings_errors(); ?>

    <form method="post" action="options.php">
        <?php
        settings_fields('collabim_options_group');
        do_settings_sections('collabim_sett');
        submit_button();
        ?>
    </form>
</div>

