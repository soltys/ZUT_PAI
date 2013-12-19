<?php

abstract class View
{
    abstract public function assign($name, $value);
    abstract public function fetch($tpl_filename);
}