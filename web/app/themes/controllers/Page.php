<?php 

namespace Controllers;

defined('BASE_PATH') OR exit('No direct script access allowed');

class Page extends \System\Base 
{
    
    public function __construct()
    {
        parent::__construct();
    }
    
    function index()
    {
        $this->view('page');
    }
}




