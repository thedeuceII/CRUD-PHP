<?php
	$config['debug'] = false;
	$config['facebook'] = true;
	$config['localhost'] = "";

if($_SERVER['HTTP_HOST']==$config['localhost']){
	$config['environment'] = "local";
} else {
	$config['environment'] = "production";
	$config['debug'] = false;
}

if ($config['environment'] == "local") {
    $bdconfig['server'] = "";
    $bdconfig['user'] = "";
    $bdconfig['password'] = "";
    $bdconfig['database'] = "";
} else {
    $bdconfig['server'] = "";
    $bdconfig['user'] = "";
    $bdconfig['password'] = "";
    $bdconfig['database'] = "";
}

function __autoload($class_name) {
    $file = "classes/" . $class_name . '.class.php';
    if (file_exists($file)) {
        include_once $file;
    } else {
        throw new Exception("Class $file could not be autoloaded");
    }
}

