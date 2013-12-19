<?php
error_reporting(E_ALL); 
ini_set('display_errors', 1); 

set_include_path( 
'../scripts' . PATH_SEPARATOR .
'../scripts/include' . PATH_SEPARATOR . 
get_include_path()
);

require_once 'Doctrine.php';
spl_autoload_register(array('Doctrine', 'autoload'));
$conn =
Doctrine_Manager::connection('mysql://root:kupa@localhost/tatry');
Doctrine::loadModels('./scripts/lib');
$conn->setCollate('utf8_polish_ci');
$conn->setCharset('utf8');
set_include_path('../scripts/lib' . PATH_SEPARATOR . get_include_path());

require_once 'MyController.class.php';
$controller = new MyController();
$controller->dispatch();