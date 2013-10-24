<?php

function url_manage_get_rootdir()
{
    $root_dir = dirname($_SERVER['PHP_SELF']);
    if ($root_dir == '\\') {
        $root_dir = '';
    }
    return $root_dir;
}


function url_manage_get_request_url($root_dir)
{
    $adr = $_SERVER['REQUEST_URI'];
    $adr = preg_replace(
        '/^' . preg_quote($root_dir, '/') . '/', 
        '', 
        $adr
    );
    return $adr;
}

function url_manage_get_friendly_url()
{
    $root_dir = url_manage_get_rootdir();
    $adr = $_SERVER['REQUEST_URI'];
    $adr = preg_replace(
        '/^' . preg_quote($root_dir, '/') . '/', 
        '', 
        $adr
    );
    return $adr;
}