<?php

namespace System;

defined('BASE_PATH') OR exit('No direct script access allowed');

class MVC
{
    public function __construct()
    { 
        //load router
        new \System\Router;
    }
}

new \System\MVC;