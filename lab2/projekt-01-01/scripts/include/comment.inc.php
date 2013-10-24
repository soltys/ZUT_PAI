<?php

function file_uncomment_and_trim($filename, $comment = '#')
{
    $plk = file($filename);
    $wynik = array();
    foreach ($plk as $l) {
        $comment = preg_quote($comment, '/');
        $re = '/' . $comment . '.*$' . '/';
        $tmp = preg_replace($re, '', $l);
        $tmp = trim($tmp);
        if ($tmp) {
            $wynik[] = $tmp;
        }
    }
    return $wynik;
}



function uncomment($AStr, $AComment = '#')
{
    $wynik = '';
    $tmp = split("\n|\r\n", $AStr);
    $ile = count($tmp);
    for ($i = 0; $i < $ile; $i++) {
        $tmp[$i] = ereg_replace("#.*$", "", $tmp[$i]);
        if ($tmp[$i]) {
            $wynik .= $tmp[$i] . "\r\n";
        }
    }

    return $wynik;
}


function uncomment_and_trim($AStr, $AComment = '#')
{
    $wynik = '';
    $tmp = split("\n|\r\n", $AStr);
    $ile = count($tmp);
    for ($i = 0; $i < $ile; $i++) {
        $tmp[$i] = ereg_replace($AComment . ".*$", "", $tmp[$i]);
        $tmp[$i] = trim($tmp[$i]);
        if ($tmp[$i]) {
            $wynik .= $tmp[$i] . "\r\n";
        }
    }

    return trim($wynik);
}
