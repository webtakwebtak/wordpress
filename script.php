<?php

/* Run this script once after installing WP
 * It remove default data and adds default settings
 * When done delete file
 * */

require_once 'vendor/autoload.php';
$dotenv = Dotenv\Dotenv::create(__DIR__);
$dotenv->load();

//remove default themes
deleteDirectory("web/wp/wp-content/themes/");

//remove default themes
deleteDirectory("web/wp/wp-content/plugins/");

//activate default theme
activateTheme();

//remove default comments
removeComments();

//remove default comments
removePosts();

//Discussion setting most strict
shutDownComments();

//Ping post en mailserver removed
emptyWriteSettings();

//Discourage search engines from indexing this site
discourageSearchEngines();

//Search friendly URLS
setPermalinkStructure();

//Remove cleanup file
activatePlugins();

//Remove cleanup file
//removeCleanUpFile();

//Add salts
addNewSalts();


function activateTheme() {
    $sql = "UPDATE wp_options SET option_value = 'wp-theme' WHERE option_name = 'template';UPDATE wp_options SET option_value = 'wp-theme' WHERE option_name = 'stylesheet';UPDATE wp_options SET option_value = 'Webtak thema' WHERE option_name = 'current_theme';UPDATE wp_options SET option_value = '' WHERE option_name = 'theme_switched';";
    executeSQL($sql);
    echo "Custom theme activated\n";
}

function removeComments() {
    $sql = "TRUNCATE wp_commentmeta;TRUNCATE wp_comments;";
    executeSQL($sql);
    echo "Comments removed\n";
}

function removePosts() {
    $sql = "TRUNCATE wp_postmeta;TRUNCATE wp_posts;";
    executeSQL($sql);
    echo "Posts removed\n";
}

function deleteDirectory($dir) {
    system('rm -rf ' . escapeshellarg($dir), $retval);
    echo "Delete ".$dir."\n";
}

function shutDownComments() {
    $sql = "UPDATE wp_options SET option_value = NULL WHERE option_name = 'show_avatars';UPDATE wp_options SET option_value = NULL WHERE option_name = 'default_pingback_flag';UPDATE wp_options SET option_value = 'closed' WHERE option_name = 'default_ping_status';UPDATE wp_options SET option_value = 'closed' WHERE option_name = 'default_comment_status';UPDATE wp_options SET option_value = NULL WHERE option_name = 'comments_notify';UPDATE wp_options SET option_value = NULL WHERE option_name = 'moderation_notify';UPDATE wp_options SET option_value = '1' WHERE option_name = 'comment_moderation';UPDATE wp_options SET option_value = '0' WHERE option_name = 'comment_max_links';UPDATE wp_options SET option_value = '1' WHERE option_name = 'close_comments_for_old_posts';UPDATE wp_options SET option_value = '0' WHERE option_name = 'close_comments_days_old';UPDATE wp_options SET option_value = '0' WHERE option_name = 'thread_comments_depth';UPDATE wp_options SET option_value = NULL WHERE option_name = 'page_comments';UPDATE wp_options SET option_value = '0' WHERE option_name = 'comments_per_page';UPDATE wp_options SET option_value = '1' WHERE option_name = 'comment_registration';";
    executeSQL($sql);
    echo "Comments shutdown \n";
}

function emptyWriteSettings() {
    $sql ="UPDATE wp_options SET option_value = '1' WHERE option_name = 'default_category';UPDATE wp_options SET option_value = '1' WHERE option_name = 'default_email_category';UPDATE wp_options SET option_value = '0' WHERE option_name = 'default_link_category';UPDATE wp_options SET option_value = '' WHERE option_name = 'mailserver_url';UPDATE wp_options SET option_value = '0' WHERE option_name = 'mailserver_port';UPDATE wp_options SET option_value = '' WHERE option_name = 'mailserver_login';UPDATE wp_options SET option_value = '' WHERE option_name = 'mailserver_pass';UPDATE wp_options SET option_value = '' WHERE option_name = 'ping_sites';";
    executeSQL($sql);
    echo "Write settings applied shutdown \n";
}


function discourageSearchEngines() {
    $sql = "UPDATE wp_options SET option_value = '0' WHERE option_name = 'blog_public';";
    executeSQL($sql);
    echo "Search engines discouragd \n";
}

function setPermalinkStructure() {
    $sql = "UPDATE wp_options SET option_value = '/%postname%/' WHERE option_name = 'permalink_structure';";
    executeSQL($sql);
    echo "Permalink structure changed\n";
}

function activatePlugins(){
    $statement = 'a:2:{i:0;s:34:"advanced-custom-fields-pro/acf.php";i:1;s:33:"classic-editor/classic-editor.php";}';
    $sql = "UPDATE wp_options SET option_value = '".addslashes($statement)."' WHERE option_name = 'active_plugins';";
    executeSQL($sql);
    echo "Plugins activated\n";
}

function removeCleanUpFile() {
    system('rm -rf script.php');
    echo "Cleanup script destroyed\n";
}

function addNewSalts() {
    $lines  = file('.env');
    $output = "";
    $salts = array('AUTH_KEY','SECURE_AUTH_KEY','LOGGED_IN_KEY','NONCE_KEY','AUTH_SALT','SECURE_AUTH_SALT','LOGGED_IN_SALT','NONCE_SALT');
    foreach($lines as $line) {     
        foreach( $salts as $salt ){
            if( substr($line, 0, strlen($salt)) === $salt ){
                $line = $salt."='".generateSalt()."'\n";
            }
        }
        $output .= $line;
    }
    file_put_contents('.env', $output);
    echo "Salts added\n";
}

function generateSalt($max = 66) {
    $characterList = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789!@#$%&*<>|?~-+=.,";
    $i = 0;
    $salt = "";
    while ($i < $max) {
        $salt .= $characterList{mt_rand(0, (strlen($characterList) - 1))};
        $i++;
    }
    return $salt;
}

function executeSQL($sql) {
    $cmd = shell_exec('mysql --user='.$_ENV['DB_USER'].' --host='.$_ENV['DB_HOST'].' --password='.$_ENV['DB_PASSWORD'].' '.$_ENV['DB_NAME'].' -e "'.$sql.'"');
}
