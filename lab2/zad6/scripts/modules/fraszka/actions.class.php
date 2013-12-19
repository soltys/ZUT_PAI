<?php
class Actions extends ActionsBase
{
public function execute_show()
{
if (
isset($_GET['slug']) &&
str_ivslug($_GET['slug']) &&
in_array($_GET['slug'], $this->controller->slugi)
) {
$index = array_search($_GET['slug'], $this->controller->slugi);
$tresc = file($this->controller->menu[$index]['nazwapliku']);
$tresc[0] = '';
$tresc = implode('', $tresc);
$this->set('tresc', $tresc);
$this->set('tytul', $this->controller->menu[$index]['tytul']);
} else {
$this->execute_404();
}
}
}