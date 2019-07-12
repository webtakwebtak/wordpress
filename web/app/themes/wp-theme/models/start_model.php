<?php 

namespace Models;

defined('BASE_PATH') OR exit('No direct script access allowed');

class Start_model extends \System\Model 
{
    function getBodyText()
    {
       global $post;
       if(!$data = $this->cache->setDatabaseCache('post-data-'.$post->ID,3000)){
           $data = array(
               'link' => get_permalink($post->ID),
               'title' => get_the_title($post->ID)
           );
       }
       return $this->modeloutput($data,'post-data-'.$post->ID);
    }
}




