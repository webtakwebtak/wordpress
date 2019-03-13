<?php

/*Run this script after installing WP*/

require_once 'vendor/autoload.php';
$dotenv = Dotenv\Dotenv::create(__DIR__);
$dotenv->load();


//remove default themes
deleteDirectory("web/wp/wp-content/themes/");

//remove default themes
deleteDirectory("web/wp/wp-content/plugins/");

//activate default theme
activateTheme();


function activateTheme() {
    $sql = "UPDATE `wp_options` SET `option_value` = 'wp-theme' WHERE `option_name` = 'template';UPDATE `wp_options` SET `option_value` = 'wp-theme' WHERE `option_name` = 'stylesheet';UPDATE `wp_options` SET `option_value` = 'Webtak thema' WHERE `option_name` = 'current_theme';UPDATE `wp_options` SET `option_value` = '' WHERE `option_name` = 'theme_switched';";
    $cmd = escapeshellcmd('mysql --user='.$_ENV['DB_USER'].' --password='.$_ENV['DB_PASSWORD'].' composer-example -e "'.$sql.'"');
    echo "Custom theme activated\n";
}


function deleteDirectory($dir) {
    system('rm -rf ' . escapeshellarg($dir), $retval);
    echo "Delete ".$dir."\n";
}

