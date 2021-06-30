<?php
spl_autoload_register(function($class) {
	
	if($class == "Router"){
        include "router/Router.php";
    }
    else if (strpos($class,"Controller")){
        include"controllers/{$class}.php";
    }
	else if (strpos($class, "View")) {
        include "views/{$class}.php";
	}
    else if (strpos($class,"DAO")){
        include"models/dao/{$class}.php";
    }
	else if (strpos($class, "Behavior")) {
        include "models/Behavior/{$class}.php";
	}
    else {
        include"models/entities/{$class}.php";
    }
});

$router = new Router($_GET, $_POST, $_SERVER['PHP_SELF'], $_SERVER['REQUEST_URI']);

// URL =URL ET PHP_SELF VA A LA RACINE + INDEX.PHP

?>