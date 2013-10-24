<?php

/**
 * Walidacja danych
 *
 * Funkcje sluzace do walidacji identyfikatorow
 * przekazywanych w adresach URL postaci:
 *     index.php?id1=12&id2=34&id3=56
 *
 * Zawartosc tablicy $_GET stanowia zawsze napisy.
 * Zatem wszystkie funkcje walidujace sprawdzaja
 * typ parametrow.
 *
 *
 * @package    WALIDACJA
 * @author     Wlodzimierz Gajda, gajdaw
 * @copyright  1997-2009 Wlodzimierz Gajda, gajdaw
 * @link       http://gajdaw.pl
 * @license    GPL
 * @version    walidacja.inc.php, v 1.1, 2009/02/24, 08:47
 */


/*
 * Maksymalna liczba calkowita
 * ma wartosc 2 147 483 647.
 *
 * Przyjmujemy: dziewiec cyfr.
 *
 */


/**
 * Maksymalna dlugosc napisu.
 *
 */
define('WALIDACJA_MAX_DL_INT',   10);
define('WALIDACJA_MAX_DL_SLUG', 255);


/**
 * str_ievpi(): Is exactly valid positive integer?
 *
 * Czy liczba jest poprawna, calkowita, nieujemna?
 * Wykluczamy wiodace zera: 001, 000004.
 * Sprawdzamy typ i dlugosc zmiennej.
 *
 * @param string badana liczba
 * @return bool czy badana liczba spelnia kryteria
 */
function str_ievpi($number)
{
    if (
        is_string($number) &&
        (strlen($number) <= WALIDACJA_MAX_DL_INT) &&
        preg_match('/^(([1-9][0-9]+)|([0-9]))$/', $number)
    ) {
        return true;
    } else {
        return false;
    }
}


/**
 * str_ievpifr(): Is exactly valid positive integer from range?
 *
 * Czy liczba jest poprawna, calkowita, nieujemna i z podanego zakresu?
 * Wykluczamy wiodace zera: 001, 000004.
 *
 * @param string badana liczba
 * @param string maksymalna dopuszczalna wartosc
 * @param string minimalna dopuszczalna wartosc 
 * @return bool czy badana liczba spelnia kryteria
 */
function str_ievpifr($number, $rmin, $rmax)
{
    if (
        str_ievpi($number) &&
        ($number >= $rmin) &&
        ($number <= $rmax)
    ) {
        return true;
    } else {
        return false;
    }
}




function str_ivslug($s)
{
    if (
        is_string($s) &&
        (strlen($s) <= WALIDACJA_MAX_DL_SLUG) &&
        preg_match('/^[a-z0-9_\-]+$/', $s)
    ) {
        return true;
    } else {
        return false;
    }
}