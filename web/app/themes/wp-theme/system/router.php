<?php

namespace System;

defined('BASE_PATH') OR exit('No direct script access allowed');

class Router
{
    public function __construct()
    {
        //load routes
        $route_path =__DIR__.'/../config/routes.php';
        $routes     = include($route_path);

        //get url segments
        $uri = $this->getSegments();
        
        //check segements against route
        $request = $this->matchRoutes($uri,$routes);
        
        //initate class
        $classname = '\\controllers\\'.$request['controller'];
        $class = new $classname;
     
        //call method
        $params = "";
        if(!empty($request['vars'])){
            $params = implode(',',$request['vars']);
        }
        
        //call method with optiona parameters
        $class->{$request['method']}($params);
    }
    
    private function matchRoutes($uri,$routes){
        $skip       =  array('default','404');
        $segments   = $uri['segments'];
        if($segments){
            foreach($routes as $path => $route){
                if(!in_array($path,$skip)){
                    $parts  = explode('/',$path);
                    if(count($segments) == count($parts)){
                        $match = true;
                        $vars  = array();
                        foreach($parts as $key => $part){
                            $value = $segments[$key];
                            switch ($part) {
                                case "(:num)":
                                    if(!is_numeric($value)){
                                        $match = false;
                                    }
                                    else{
                                        $vars[] = $value;
                                    }
                                    break;
                                case "(:any)":
                                    if (!preg_match('/^[a-zA-Z0-9-]+$/',$value)) {
                                        $match = false;
                                    }
                                    else{
                                        $vars[] = $value;
                                    }
                                    break;
                                default:
                                    if($value != $part){
                                        $match = false;
                                    }
                            }
                        }
                        if($match){
                            $route   = explode('/',$route);
                            return  array(
                                'controller' => $route[0],
                                'method'     => $route[1],
                                'vars'       => $vars
                            );
                        }
                    }
                }
            }
            $route   = explode('/',$routes['404']);
            return  array(
                'controller' => $route[0],
                'method'     => $route[1],
                'vars'       => array()
            );
        }
        else {
            $route   = explode('/',$routes['default']);
            return  array(
                'controller' => $route[0],
                'method'     => $route[1],
                'vars'       => array()
            );
        }
    }
    
    private function getSegments(){
        $result     = array('segments' => array(),'vars' => array());
        $request    = $_SERVER['REQUEST_URI'];
        $home       = $_SERVER['WP_HOME'];
        $basesegments   = $this->getBaseSegments($request,$home);
        $segments       = explode('/',$request);
        foreach($segments as $segment){
            if(!empty($segment) && !in_array($segment,$basesegments)){
                if( substr($segment, 0, 1) == '?' ){
                    $result['vars'] = $this->getGetVars($segment);
                }
                else{
                    $result['segments'][] = $segment;
                }
            }
        }
        return $result;
    }
      
    private function getBaseSegments($request,$home){
        $result     = array();
        $pieces1 = str_word_count($request, 1);
        $pieces2 = str_word_count($home, 1);
        $result=array_intersect(array_unique($pieces1), array_unique($pieces2));
        return $result;
    }
    
    private function getGetVars($str){
        $result     = array();
        $str = substr($str, 1, strlen($str));
        parse_str($str, $result);
        return $result;
    }
    
}