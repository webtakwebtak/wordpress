<?php 

namespace Controllers;

defined('BASE_PATH') OR exit('No direct script access allowed');

class News extends \System\Base 
{
    public function __construct()
    {
        parent::__construct();
    }
    
    public function test($str)
    {
        $this->cache->setViewCache('news',3000);
        $data = array('test' => $str); 
        $this->view('news',$data);
    }
    
    function index()
    {
        $data = array('test' => 'Hallo nieuws');
        $this->view('test',$data);
    }
}


