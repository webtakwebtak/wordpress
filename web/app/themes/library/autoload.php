<?php 

function my_autoloader($class)
{
    $filename = BASE_PATH . '/' . str_replace('\\', '/', strtolower($class)) . '.php';
    include($filename);
}
spl_autoload_register('my_autoloader');

?>