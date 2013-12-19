<?php

function akapitowanie($s)
{
    return preg_split("/(\r\n){2,}/", trim($s));        
}


function remove_new_lines($s)
{
    return preg_replace("/(\r?\n)/", ' ', $s);        
}

function file_akapitowanie($nazwapliku)
{
    $t = file_get_contents($nazwapliku);
    $out = akapitowanie($t);
    $out = array_map('remove_new_lines', $out);
    return $out;
}


