<?php

//skrypt wstaw.php

header('Content-Type: text/plain;  charset=utf-8');
set_time_limit(0);

set_include_path(
    '../aplikacja/scripts' . PATH_SEPARATOR .
    '../aplikacja/scripts/include' . PATH_SEPARATOR .
    '../lib' . PATH_SEPARATOR .
    get_include_path()
);

require_once 'propel/Propel.php';
//require_once '{$conf.database}/Klasa.php';
Propel::init('{$conf.database}-conf.php');

//TabelaPeer::doDeleteAll();
