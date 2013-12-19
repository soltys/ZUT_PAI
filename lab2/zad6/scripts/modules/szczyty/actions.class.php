<?php
class Actions extends ActionsBase
{
public function execute_lista()
{
$szczyty = Doctrine_Query::create()->from('Szczyt')->fetchArray();
$this->set('szczyty', $szczyty);
}
}