<?php

function array_1dim_to_2dimH($a, $columns, $default = false)
{
    $items = count($a);
    $rows = round(ceil($items / $columns));

    $result = array();
    for ($i = 0; $i < $rows; $i++) {
        for ($j = 0; $j < $columns; $j++) {
            $index = $i * $columns + $j;
            if (isset($a[$index])) {
                $result[$i][$j] = $a[$index];
            } else {
                if ($default !== false) {
                    $result[$i][$j] = $default;
                }
            }
        }
    }

    return array(
        'items' => $result,
        'rows' => $rows,
        'cols' => $columns
    );
}

function array_1dim_to_2dimV($a, $columns, $default = '')
{
    $items = count($a);
    $rows = round(ceil($items / $columns));

    $result = array();
    for ($j = 0; $j < $columns; $j++) {    
        for ($i = 0; $i < $rows; $i++) {
            $index = $i + $rows * $j;
            if (isset($a[$index])) {
                $result[$j][$i] = $a[$index];
            } else {
                $result[$j][$i] = $default;
            }
        }
    }

    return array(
        'items' => $result,
        'rows' => $rows,
        'cols' => $columns
    );
}


