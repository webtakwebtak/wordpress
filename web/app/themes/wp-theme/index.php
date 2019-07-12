<?php
//load MVC for front-end
echo "Hello world";
if(!is_admin()){
    require('system/mvc.php');
}