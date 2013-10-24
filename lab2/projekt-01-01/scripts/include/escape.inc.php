<?php

function escape($AStr, $ASeparator = '%')
{
    $wynik = '';
    $ile   = strlen($AStr);
    for ($i = 0; $i < $ile; $i++) {
        $wynik .= $ASeparator . bin2hex($AStr[$i]);
    }
    return trim($wynik);
}
