<?php

class PHPView extends View
{
    private $variables;
    
    public function __construct()
    {
        $this->variables = array();
    }
    
    public function assign($name, $value)
    {
        $this->variables[$name] = $value;
    }

    public function fetch($tpl_filename)
    {
        foreach ($this->variables as $k => $v) {
            $$k = $v;
        };
        
        ob_start();
        include '../scripts/templates/' . $tpl_filename;
        $tmp = ob_get_contents();
        ob_end_clean();
        return $tmp;
        
    }
}