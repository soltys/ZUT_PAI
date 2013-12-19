<?php
$tab = unserialize(file_get_contents('lorem-ipsum-words.txt'));

function random_line($t, $c)
{
    $result = '';
    for ($i = 0; $i < rand(4, 6); $i++) {
        $index = rand(0, $c - 1);
        $result .= ' ' . $t[$index];;
    }
    return ucfirst(trim($result));
}


function random_verse($t, $c)
{
    $result = '';
    for ($i = 0; $i < 4; $i++) {
        $result .= random_line($t, $c) . ',' . "\r\n";
    }
    return ucfirst(trim($result, "\r\n,")) . '.';
}

function random_lyrics($t, $c)
{
    $result = '';
    for ($i = 0; $i < rand(2, 8); $i++) {
        $result .= random_verse($t, $c) . "\r\n\r\n";
    }
    return ucfirst(trim($result, "\r\n,"));
}
