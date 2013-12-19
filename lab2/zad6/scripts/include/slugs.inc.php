<?php

require_once 'pl.inc.php';

function string2slug($AStr, $separator = '_', $kodowanie = 'utf-8', $default = 'brak')
{
    switch ($kodowanie) {
    case 'utf-8':
        $tmp = pl_utf82ascii($AStr);
        break;
    
    case 'iso-8859-2':
        $tmp = pl_iso2ascii($AStr);
        break;
        
    case 'windows-1250':
        $tmp = pl_win2ascii($AStr);
        break;        
    }
    
    $tmp = preg_replace('/[^A-Za-z0-9]/', $separator, $tmp);
    
    $tmp = strtolower($tmp);
    $tmp = preg_replace('/' . preg_quote($separator, '/') . '{2,}/', $separator, $tmp);
    $tmp = trim($tmp, $separator);
    
    if ($tmp === '') {
        return $default;
    } else {
        return $tmp;
    }
}



function html2slug($AStr, $separator = '_', $kodowanie = 'utf-8')
{
    $tmp = $AStr;
    $tmp = strip_tags($tmp);
    $tmp = html_entity_decode($tmp, ENT_QUOTES, $kodowanie);
    $tmp = string2slug($tmp, $separator, $kodowanie);
    return $tmp;
}

