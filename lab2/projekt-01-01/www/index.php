<?php
error_reporting(E_ALL); 
ini_set('display_errors', 1); 

set_include_path( 
'../scripts' . PATH_SEPARATOR .
'../scripts/include' . PATH_SEPARATOR . 
get_include_path()
);
require_once 'Controller.class.php';
$controller = new Controller();
$controller->dispatch();