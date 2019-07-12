<?php 

namespace Controllers;

defined('BASE_PATH') OR exit('No direct script access allowed');

class Error extends \System\Base 
{
    function __construct()
    {
        parent::__construct();
    }

    function error_404()
    {
        http_response_code(404);
       // $this->cache->setViewCache('errors/404',3000);
        $this->view('errors/404');
    }
}


