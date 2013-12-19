<?php
set_include_path(
'../projekt-01-01/scripts' . PATH_SEPARATOR .
'../projekt-01-01/scripts/include' . PATH_SEPARATOR .
'../lib' . PATH_SEPARATOR .
get_include_path()
);
require_once 'vh-array.inc.php';
require_once 'Doctrine.php';
spl_autoload_register(array('Doctrine', 'autoload'));
$conn =
Doctrine_Manager::connection('mysql://root:kupa@localhost/tatry');
Doctrine::loadModels('./../lib');
$conn->setCollate('utf8_polish_ci');
$conn->setCharset('utf8');
$dane = string2HArray(file_get_contents('tatry.txt'));
foreach ($dane['items'] as $sz) {
$szczyt = new Szczyt();
$szczyt->nazwa = $sz[0];
$szczyt->wysokosc = $sz[1];
$szczyt->save();
}