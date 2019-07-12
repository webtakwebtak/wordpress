<?php 

namespace System;

defined('BASE_PATH') OR exit('No direct script access allowed');

class Cache
{
    var $cacheViewOn        = false;
    var $cacheDatabaseOn    = false;
    var $cacheDatabaseName;
    
    public function __construct() {}
    
    public function readDatabaseCache($name,$duration)
    {
        $cache_file = BASE_PATH . "/cache/db/" . $name . '.cache';
        if (file_exists($cache_file) && (filemtime($cache_file) > (time() - $duration ))) {
            $output = file_get_contents($cache_file, 'w');
            return json_decode($output,true);
        }
        return false;
    }
    
    public function createDatabaseCache($output)
    {
        $name = $this->cacheDatabaseName;
        $file = BASE_PATH."/cache/db/" . $name . '.cache';
        file_put_contents($file,json_encode($output));
    }
    
    public function setDatabaseCache($name,$duration = 3000)
    {
        $this->cacheDatabaseOn     = true;
        $this->cacheDatabaseName   = $name;
        if($output = $this->readDatabaseCache($name,$duration)){
            return $output;
        }
        return false;
    }
    
    public function readViewCache($template,$duration)
    {
        $template = str_replace("/",".",$template);
        $cache_file = BASE_PATH . "/cache/views/" . $template . '.cache';
        if (file_exists($cache_file) && (filemtime($cache_file) > (time() - $duration ))) {
            $output = file_get_contents($cache_file, 'w');
            return $output;
        }
        return false;
    }
    
    public function createViewCache($template,$output)
    {
        $template = str_replace("/",".",$template);
        $file = BASE_PATH."/cache/views/" . $template . '.cache';
        file_put_contents($file,$output);
    }
    
    public function setViewCache($template,$duration = 3000)
    {
        $this->cacheViewOn = true;
        if($output = $this->readViewCache($template,$duration)){
            echo $output;
            exit;
        }
    }
}


