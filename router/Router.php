<?php

class Router {
    private $get;
    private $post;
    private $route;
    private $root;
    private $controller_list;
    private $controller;
    private $controller_name;
    
    function __construct($get, $post, $self, $url) {
        $this->get = $get;
        $this->post = $post;
        $this->controller_list = ['index','utilisateur','membre','gerant'];
        $this->controller_name = false;
        $this->controller = false;
        $this->root = $this->parseRoot($self);
        $this->route = $this->parseURL($url);
        $this->run();
    }
    
    private function parseRoot($self) {
        return str_replace('index.php', '', $self);
		
    }
    
    private function parseURL($url) {
        $path = str_replace($this->root, '', $url);
        $path = explode('/', $path);
        $controller = false;
        if($path && count($path) && strlen($path[0])) {
            $controller = $path[0];
			
        } else if(count($path) && !strlen($path[0])) {
            $controller = 'index';
        }
	
        if($controller && in_array($controller, $this->controller_list)) {
            $this->controller_name = ucfirst($controller.'Controller');
        }
        return $path;
    }
    
    private function run() {
        if($this->controller_name) {
            $this->controller = new $this->controller_name($this->get, $this->post, $this->route);
        }
    }
}

?>