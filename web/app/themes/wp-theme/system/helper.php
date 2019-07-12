<?php

namespace System;

defined('BASE_PATH') OR exit('No direct script access allowed');

class Helper
{
    public function __construct()
    { 
        $route_path =__DIR__.'/../helpers/*.php';
        foreach (glob($route_path) as $filename)
        {
            include($filename);
        }
    }
}