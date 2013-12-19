<?php
require_once 'Controller.class.php';
require_once 'slugs.inc.php';
class MyController extends Controller
{
public function preActions()
{
$this->menu = array(); // dzięki temu te dwie zmienne będą
$this->slugi = array(); // dostępne we wszystkich kontrolerach
$plks = glob('../scripts/dane/fraszki/*.txt'); // wyszukujemy
foreach ($plks as $plk) { // wszystkie pliki txt
$tmp = file($plk);
$opcja = array(
'nazwapliku' => $plk,
'tytul' => trim($tmp[0]),
'slug' => string2slug($tmp[0]), // zamienia spacje na '_'
); // i usuwa polskie znaki
$this->menu[] = $opcja;
$this->slugi[] = $opcja['slug'];
}
$this->set('menu', $this->menu); // przekazanie tablicy do widoku
}
}