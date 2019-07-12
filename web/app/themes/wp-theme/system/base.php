<?php 

namespace System;

defined('BASE_PATH') OR exit('No direct script access allowed');

class Base
{
    var $cache;
    var $helper;
    var $model;
    
    public function __construct()
    {
        //load helpers
        $this->helper  = new \System\Helper;
        
        //load cache
        $this->cache    = new \System\Cache;
        
        //load models
        $this->model    = new \System\Model;
    }
    
    public function view($template,$variables = array(), $print = true)
    {
        $view_path =__DIR__.'/../views/'.$template.'.php';
        $output = $this->loadView($view_path,$variables);
        if( $this->cache->cacheViewOn ){        
            $this->cache->createViewCache($template,$output);
        }
        if ($print) {
            print $output;
        }
        else{
            return $output; 
        }
    }
    
    private function loadView($view_path,$variables = array()){
        if(file_exists($view_path)){
            // Extract the variables to a local namespace
            if($variables){
                extract($variables);
            }
            
            // Start output buffering
            ob_start();
            
            // Include the template file
            include $view_path;
            
            // End buffering and return its contents
            $output = ob_get_clean();
        }
        return $output;
    }
    
    public function loadModel($name)
    {
        $modelname              = ucfirst($name).'_model';
        $classname              = '\\Models\\'.$modelname;
        $this->models{$name}    = new $classname;
    }

}


