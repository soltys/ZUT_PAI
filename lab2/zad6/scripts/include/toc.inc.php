<?php

require_once 'string.inc.php';

/*
 * toc.inc.php
 * ver 0.2
 * 2009/02/21
 * (c)2009 Włodzimierz Gajda, gajdaw
 * http://gajdaw.pl
 */



/*
 * Parsuje dokument
 * Tworzy tablicę zawierającą tytuły rozdziałów i podrozdziałów
 */
function getTableOfContents($AStr)
{
    preg_match_all("|<h([34])>(.*)</h[34]>|U", $AStr, $regs);
    $toc       = array();
    $chapters  = array();
    $numer     = 1;
    $podnumer  = 1;
    $ile = count($regs[1]);
    for ($i = 0; $i < $ile; $i++) {
        if ($regs[1][$i] == '3') {
            $chapters[$numer]['title'] = $regs[2][$i];
            $chapters[$numer]['subchapters'] = array();
            $numer++;
            $podnumer = 1;
        } else {
            $chapters[$numer - 1]['subchapters'][$podnumer] = $regs[2][$i];
            $podnumer++;
        }
    }
    return $chapters;
}


/*
 * Przekształca tablicę zwracaną przez funkcję getTableOfContents($AStr)
 * w kod html spisu treści
 */
function getTableOfContentsAsString($ATocArray)
{

    $result = "\r\n<div class=\"toc\">\r\n<h3>Spis treści</h3>\r\n" . '<ol>';
    $ile = count($ATocArray);
    for ($i = 1; $i <= $ile; $i++) {
        $result .=  "\r\n" . '<li>';
        $result .= "<a href=\"#R{$i}\">{$i}. {$ATocArray[$i]['title']}</a>";
        $ilePodr = count($ATocArray[$i]['subchapters']);
        if ($ilePodr > 0) {
            $result .= "\r\n" . '    <ol>';
            for ($j = 1; $j <= $ilePodr; $j++) {
                $result .= "\r\n" . '        <li>';
                $result .= "<a href=\"#P{$i}-{$j}\">{$i}.{$j} {$ATocArray[$i]['subchapters'][$j]}</a>";
                $result .= '</li>';
            }
            $result .= "\r\n" . '    </ol>'  . "\r\n";
        }
        $result .= '</li>';
    }
    $result .= "\r\n" . '</ol>' . "\r\n" . '</div>' . "\r\n\r\n";
    return $result;
}


/*
 * Dodaje identyfikatory oraz numerację rozdziałów i podrozdziałów
 * czyli elementów h3, h4
 * Robi to samo co obie funkcje: addID() oraz renumberChapters()
 */
function replaceChapters($ATocArray, $AText)
{
    $result = $AText;

    $ile = count($ATocArray);
    for ($i = 1; $i <= $ile; $i++) {
        $result = str_replace(
            "<h3>{$ATocArray[$i]['title']}</h3>",
            "<h3 id=\"R{$i}\">{$i}. {$ATocArray[$i]['title']}</h3>",
            $result
        );

        $ilePodr = count($ATocArray[$i]['subchapters']);
        if ($ilePodr > 0) {
            for ($j = 1; $j <= $ilePodr; $j++) {
                $result = str_replace(
                    "<h4>{$ATocArray[$i]['subchapters'][$j]}</h4>",
                    "<h4 id=\"P{$i}-{$j}\">{$i}.{$j} {$ATocArray[$i]['subchapters'][$j]}</h4>",
                    $result
                );
            }
        }
    }
    return $result;
}

/*
 * Przeksztalca tablice zwracana przez funkcje getTableOfContents($AStr)
 * w kod html spisu tresci
 *
 * Kazdy podrozdzial: na stronie $AURL px  (x to numer rozdzialu)
 * Podrozdzialy: na stronach rozdzialow
 */
function getTableOfContentsAsStringPages($ATocArray, $AURL)
{

    $result = "\r\n<div class=\"toc\">\r\n<h3>Spis treści</h3>\r\n" . '<ol>';
    $ile = count($ATocArray);
    for ($i = 1; $i <= $ile; $i++) {
        $result .=  "\r\n" . '<li>';
        $result .= "<a href=\"{$AURL}p{$i}.html\">{$i}. {$ATocArray[$i]['title']}</a>";
        $ilePodr = count($ATocArray[$i]['subchapters']);
        if ($ilePodr > 0) {
            $result .= "\r\n" . '<ol>';
            for ($j = 1; $j <= $ilePodr; $j++) {
                $result .= "\r\n" . '<li>';
                $result .= "<a href=\"{$AURL}p{$i}.html#P{$i}-{$j}\">{$i}.{$j} {$ATocArray[$i]['subchapters'][$j]}</a>";
                $result .= '</li>';
            }
            $result .= "\r\n" . '</ol>'  . "\r\n";
        }
        $result .= '</li>';
    }
    $result .= "\r\n" . '</ol>' . "\r\n" . '</div>' . "\r\n";
    return $result;
}

/*
 * Dodaje identyfikatory oraz numeracje podrozdzialow, czyli elementow h4
 * Elementy h3 pozostawiamy: ich adresy beda wyznaczone przez URL
 * Robi to samo co obie funkcje: addID() oraz renumberChapters()
 */
function replaceChaptersPages($ATocArray, $AText)
{
    $result = $AText;

    $ile = count($ATocArray);
    for ($i = 1; $i <= $ile; $i++) {
        $result = str_replace_first(
            "<h3>{$ATocArray[$i]['title']}</h3>",
            "<h3>{$i}. {$ATocArray[$i]['title']}</h3>",
            $result
        );

        $ilePodr = count($ATocArray[$i][subchapters]);

        if ($ilePodr > 0) {
            for ($j = 1; $j <= $ilePodr; $j++) {

                $result = str_replace_first(
                    "<h4>{$ATocArray[$i]['subchapters'][$j]}</h4>",
                    "<h4 id=\"P{$i}-{$j}\">{$i}.{$j} {$ATocArray[$i]['subchapters'][$j]}</h4>",
                    $result
                );

            }
        }
    }
    
    return $result;
}

