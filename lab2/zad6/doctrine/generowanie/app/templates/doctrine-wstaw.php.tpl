<?php

//skrypt wstaw.php

error_reporting(E_ALL);
ini_set('display_errors', 1);

header('Content-Type: text/plain;  charset=utf-8');
set_time_limit(0);

set_include_path(
    '../aplikacja/scripts' . PATH_SEPARATOR .
    '../aplikacja/scripts/include' . PATH_SEPARATOR .
    '../lib' . PATH_SEPARATOR .
    get_include_path()
);

require_once 'Doctrine/lib/Doctrine.php';
spl_autoload_register(array('Doctrine', 'autoload'));
$conn = Doctrine_Manager::connection('mysql://{$conf.username}:{$conf.password}@{$conf.host}/{$conf.database}');
Doctrine::loadModels('./../lib', Doctrine::MODEL_LOADING_CONSERVATIVE);
$conn->setCollate('{$conf.collate}');
$conn->setCharset('{$conf.encoding}');

//$conn->exec('truncate table ...');

//Doctrine::dropDatabases();
//Doctrine::createDatabases();
//Doctrine::createTablesFromModels();

