<?php


function string2HArray($s, $separator = '|')
{
    if (trim($s) == '') {
        return array(
            'rows'  => 0,
            'cols'  => 0,
            'items' => array()
        );
    }
    
    $linie  = explode("\n", trim($s));
    $liniec = count($linie);

    $t = array();

    for ($i = 0; $i < $liniec; $i++) {
        $linia   = explode($separator, trim($linie[$i]));
        $t[] = $linia;
    }

    $kolumnyc = count($t[0]);

    for ($i = 0; $i < $liniec; $i++) {
        $tmp = count($t[$i]);
        if ($tmp != $kolumnyc) {
            return false;
        }
    }

    return array(
        'rows'  => $liniec,
        'cols'  => $kolumnyc,
        'items' => $t
    );
}


function string2VArray($s, $separator = '|')
{
    if (trim($s) == '') {
        return array(
            'rows'  => 0,
            'cols'  => 0,
            'items' => array()
        );
    }

    $linie  = explode("\n", trim($s));
    $liniec = count($linie);

    $linia     = explode($separator, trim($linie[0]));
    $liczbapol = count($linia);
    
    $t = array();
    for ($j = 0; $j < $liczbapol; $j++) {
        $t[$j] = array();
    }    

    for ($i = 0; $i < $liniec; $i++) {
        $linia = explode($separator, trim($linie[$i]));

        if (count($linia) !== $liczbapol) {
            return false;
        }

        for ($j = 0; $j < $liczbapol; $j++) {
            $t[$j][] = $linia[$j];
        }
    }

    return array(
        'rows'  => $liniec, 
        'cols'  => $liczbapol,
        'items' => $t
    );
}


function stringArrayIsOK($s, $separator = '|')
{
    $linie  = explode("\n", trim($s));
    $liniec = count($linie);
    
    $pierwsza = count(explode($separator, trim($linie[0])));

    $bledy = array();

    for ($i = 0; $i < $liniec; $i++) {
        $linia = explode($separator, trim($linie[$i]));    
        $linia_c = count($linia);
        if ($linia_c != $pierwsza) {
            $bledy[] = trim($linie[$i]);
        }
    }
    
    if (empty($bledy)) {
        return true;;
    } else {
        return $bledy;
    }

}


function transposeVArray($AArray)
{
    $ARows = count($AArray[0]);
    $AColumns = count($AArray);

    $result = array();

    for ($i = 0; $i < $ARows; $i++) {
        $tmp = array();
        for ($j = 0; $j < $AColumns; $j++) {
            $tmp[] = $AArray[$j][$i];
        }
        $result[] = $tmp;
    }

    return array(
        'cols' => $AColumns,
	'rows' => $ARows,
	'items' => $result
    );
}


function vArray2String($AArray, $ASeparator = '|')
{
    $ARows = count($AArray[0]);
    $AColumns = count($AArray);
    $result = '';
    for ($i = 0; $i < $ARows; $i++) {
        $tmp = '';
        for ($j = 0; $j < $AColumns; $j++) {
            $tmp .= $AArray[$j][$i] . $ASeparator;
        }
        $tmp = trim($tmp, $ASeparator);
        $result .= $tmp . "\r\n";
    }
    return $result;
}


function hArray2String($AArray, $ASeparator = '|')
{
    $ARows = count($AArray);
    $result = '';
    for ($i = 0; $i < $ARows; $i++) {
        $tmp = implode($ASeparator, $AArray[$i]);
        $result .= $tmp . "\r\n";
    }
    return $result;
}


function loadAssocArray($f, $re = '/\s*=>\s*/')
{
    $tmp = file($f);
    $result = array();
    foreach ($tmp as $l) {
        if (trim($l)) {
            $e = preg_split($re, trim($l));
            $key = $e[0];
            $value = $e[1];
            $result[$key] = $value;
        }
    }
    return $result;
}


