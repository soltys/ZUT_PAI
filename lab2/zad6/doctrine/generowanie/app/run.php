<?php

require 'vendor/autoload.php';
/*
 *
 *    db-frame-tool ver. 1.6
 *    http://db-frame-tool.net 
 *
 *    Copyright (C) 2009 W³odzimierz Gajda, http://gajdaw.pl
 *
 *    This program is free software: you can redistribute it and/or modify
 *    it under the terms of the GNU General Public License as published by
 *    the Free Software Foundation, either version 3 of the License, or
 *    (at your option) any later version.
 *
 *    This program is distributed in the hope that it will be useful,
 *    but WITHOUT ANY WARRANTY; without even the implied warranty of
 *    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 *    GNU General Public License for more details.
 *
 *    You should have received a copy of the GNU General Public License
 *    along with this program.  If not, see <http://www.gnu.org/licenses/>.
 *
 */




require_once 'Smarty.class.php';

function set_defaults($conf)
{
    $defaults = array(
        'host'         => 'localhost',
        'database'     => 'mydb',
        'username'     => 'myuser',
        'password'     => 'mypassword',
        'filename'     => 'model.xml',
        'root'         => 'root',
        'rootpassword' => '',
        'encoding'     => 'utf8',
        'orm'          => 'propel',
        'folder'       => '',
    );
    $default_keys = array_diff(array_keys($defaults), array_keys($conf));
    
    $result = array();
    
    foreach ($default_keys as $k) {
        $result[$k] = $defaults[$k];        
    }
    
    return array_merge($result, $conf);
}

$conf = parse_ini_file('input/conf.ini');
$conf = set_defaults($conf);

$conf['modelfilename'] = 'input/' . $conf['filename'];

if (!file_exists($conf['modelfilename'])) {
    die('model not found');
}

$conf['folder'] = getcwd();

$s = new Smarty();
$s->template_dir = './app/templates/';
$s->compile_dir = './app/templates_c/';
$s->assign('conf', $conf);

file_put_contents('create-db.bat', $s->fetch('create-db.bat.tpl'));
file_put_contents('output/sql/sql-create-base.sql', $s->fetch('sql-create-base.sql.tpl'));
file_put_contents('create-db-filled.bat', $s->fetch('create-db-filled.bat.tpl'));
file_put_contents('output/txt/symfony-cfg.txt', $s->fetch('symfony-cfg.txt.tpl'));


if ($conf['orm'] == 'propel') {
    copy($conf['modelfilename'], 'output/propel/schema.xml');
    file_put_contents('output/propel/build.properties', $s->fetch('build.properties.tpl'));
    file_put_contents('output/propel/runtime-conf.xml', $s->fetch('runtime-conf.xml.tpl'));
    file_put_contents('output/txt/propel-wstaw.php', $s->fetch('propel-wstaw.php.tpl'));
    shell_exec('propel-gen.bat .\\output\\propel\\');
} else {
    require_once 'Doctrine/lib/doctrine.php';
    spl_autoload_register(array('Doctrine', 'autoload'));
    $conn = Doctrine_Manager::connection(
        'mysql://' . $conf['username'] . ':' . $conf['password'] .
        '@' . $conf['host'] . '/' . $conf['database']
    );

    //generowanie klas dostêpu
    Doctrine::generateModelsFromYaml($conf['modelfilename'], '../lib/', array('generateTableClasses' => true));
    $sql = Doctrine::generateSqlFromModels();
    
    file_put_contents('output/sql/doctrine-tables.sql', $sql);
    file_put_contents('output/txt/doctrine-wstaw.php', $s->fetch('doctrine-wstaw.php.tpl'));
    
}


$sql = '';
if (file_exists('input/triggers.sql')) {
    $sql = "\r\n\r\n\r\n" . file_get_contents('input/triggers.sql') . "\r\n\r\n\r\n";
}

file_put_contents('output/sql/triggers.sql', $sql);