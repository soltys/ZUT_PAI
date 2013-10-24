<?php

require_once 'walidacja.inc.php';

class ActionsBase
{
    private   $view;
    protected $controller;
    
    protected $template = 'layout.html';

    public function __construct($controller, $view_class_name = 'PHPView')
    {
        require_once $view_class_name . '.class.php';
        $this->view = new $view_class_name();
        $this->controller = $controller;
    }
    
    public function display()
    {
        $this->set('module', $this->controller->getModule());
        $this->set('action', $this->controller->getAction());
        $this->set('path_prefix', $this->controller->getPathPrefix());
        
        return $this->view->fetch($this->template);
    }    
    
    public function set($name, $value)
    {
        $this->view->assign($name, $value);
    }        
    
    public function execute_404()
    {
        $this->controller->setModule('main');
        $this->controller->setAction('404');
        header('HTTP/1.x 404 Not Found');    
    }    
    
    public function setTemplate($t)
    {
        $this->template = $t;
    }

    public function hasLayout()
    {
        return ($this->template != '');
    }

    public function noLayout()
    {
        $this->setTemplate('');
    }
    
}