<?php
require_once 'vh-array.inc.php';
class Actions extends ActionsBase
{
public function execute_drukuj()
{
$tmp1 = date('d.m.Y');
$this->set('dzisiejsza_data', $tmp1);
$tmp2 = date('h:i');
$this->set('godzina', $tmp2);
$tmp = file_get_contents('../scripts/dane/ojciec_i_syn.txt');
$tmp = nl2br($tmp);
$this->set('tytul', 'Ojciec i syn');
$this->set('tresc', $tmp);
$tmp3 = file_get_contents('../scripts/dane/140-kolory-css.txt');
$dane = string2HArray($tmp3, ':');
$this->set('kolory', $dane['items']);
}
}