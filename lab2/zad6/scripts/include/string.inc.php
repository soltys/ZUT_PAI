<?php


function str_replace_first($AOld, $ANew, $AResult)
{
    $oldlength = strlen($AOld);

    $pos = strpos($AResult, $AOld);
    $dlugosc = strlen($AResult);

    $tmp_przed = substr($AResult, 0, $pos);
    $tmp_po = substr($AResult, $pos + $oldlength, $dlugosc - $pos - $oldlength);            

    return $tmp_przed . $ANew . $tmp_po;
}

