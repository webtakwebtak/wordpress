<?php

namespace System;

defined('BASE_PATH') OR exit('No direct script access allowed');

class Model
{
    var $cache;
    
    public function __construct() {
        //load cache
        $this->cache    = new \System\Cache;
    }
    
    public function modeloutput($data) {
        if( $this->cache->cacheDatabaseOn ){
            $this->cache->createDatabaseCache($data);
        }
        return $data;
    }
}