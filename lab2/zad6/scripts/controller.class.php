<?php

require_once 'actionsbase.class.php';
require_once 'urltranslator.class.php';
require_once 'helpers.inc.php';

class Controller
{
    private static $MVC_CONTROLLER = null;
    private $options;
    
    private $actions;


    /*
     * Wybrany modul
     */
    private $module_name;


    /*
     * Wybrana akcja
     */
    private $action_name;


    /*
     * Lista wszystkich poprawnych modulow
     */
    private $module_names;


    /*
     * Lista wszystkich poprawnych akcji
     */
    private $action_names;


    /*
     * Wynik przetwarzania szablonu przed translacjami wyjściowymi
     */
    protected $output;


    /*
     * Klasa konwertująca URL-e przyjazne <==> wewnętrzne
     * Konwersja dwukierunkowa
     */
    private $urlTranslator;
    
    private $outputStringTranslations;
    
    
    public function setOptions($options)
    {
        $this->options = array();
        $this->options['viewClass'] = 'PHPView';
        $this->options['outputTranslations'] = true;
        
        if (!is_null($options)) {
        
            if (isset($options['viewClass'])) {
                $this->options['viewClass'] = $options['viewClass'];
            }

            if (isset($options['outputTranslations'])) {
                $this->options['outputTranslations'] = $options['outputTranslations'];
            }
            
        }
    }
    
    public function getOption($name)
    {
        return $this->options[$name];
    }

    public function __construct($options = null)
    {
        $this->setOptions($options);
    
        $this->urlTranslator = new URLTranslator($options);
        $this->outputStringTranslations = array(
            'src' => array(),
            'dest' => array(),
        );
        
        $this->resolveAllowedModules();
        $this->resolveCurrentModule();
        
        require_once 'modules/' . $this->module_name . '/actions.class.php';
        $this->actions = new Actions($this, $this->options['viewClass']);
        
        $this->resolveAllowedActions();
        $this->resolveCurrentAction();
        
        self::$MVC_CONTROLLER = $this;
    }

    public function dispatch()
    {
        $this->preActions();
        $this->executeCurrentAction();
        $this->postActions();
        
        if ($this->actions->hasLayout()) {
            $this->output = $this->actions->display();
            $this->outputTranslations();
            echo $this->output;
        }
    }
    
    private function outputTranslations()
    {
        if ($this->options['outputTranslations']) {
        
            $this->output = preg_replace(
                $this->urlTranslator->getOutputRoutes(),
                $this->urlTranslator->getOutputTranslatedRoutes(),
                $this->output
            );
            
            $this->addOutputStringTranslations('###PATH_PREFIX###', $this->getPathPrefix());
            
            $this->output = str_replace(
                $this->outputStringTranslations['src'],
                $this->outputStringTranslations['dest'],
                $this->output
            );
            
            $this->customOutputTranslations();
            
        }
    }

    public function addOutputStringTranslations($src, $dest)
    {
        $this->outputStringTranslations['src'][] =   $src;
        $this->outputStringTranslations['dest'][] =  $dest;
    }

    public function preActions()
    {
    }

    public function postActions()
    {

    }
    
    public function customOutputTranslations()
    {

    }
    
    private function resolveAllowedModules()
    {
        $this->module_names = glob('../scripts/modules/*');
        $tmp = count($this->module_names);
        for ($i = 0; $i < $tmp; $i++) {
            $this->module_names[$i] =
            str_replace('../scripts/modules/', '', $this->module_names[$i]);
        }
    }
    
    private function resolveAllowedActions()
    {
        $methods = get_class_methods('Actions');
        $this->action_names = array();
        foreach ($methods as $method) {
            if (preg_match('/^execute_([a-zA-Z0-9_]+)$/', $method, $m)) {
                $this->action_names[] = $m[1];
            }
        }
    }
    
    private function resolveCurrentModule()
    {
        $this->module_name = 'main';
        if (
            isset($_GET['module']) &&
            in_array($_GET['module'], $this->module_names)
        ) {
            $this->module_name = $_GET['module'];
        };
    }
    
    private function resolveCurrentAction()
    {
        if (
            isset($_GET['action']) &&
            in_array($_GET['action'], $this->action_names)
        ) {
            $this->action_name = $_GET['action'];
        } else {
            $this->module_name = 'main';
            $this->action_name = '404';
        }
    }
    
    private function executeCurrentAction()
    {
        $method_name = 'execute_' . $this->action_name;
        $this->actions->$method_name();
    }
    
    public function getModule()
    {
        return $this->module_name;
    }

    public function setModule($module)
    {
        $this->module_name = $module;
    }

    public function getAction()
    {
        return $this->action_name;
    }
    
    public function setAction($action)
    {
        $this->action_name = $action;
    }
    
    public function getPathPrefix()
    {
        return $this->urlTranslator->getPathPrefix();
    }
	
	public function getUrl($u, $type = null)
	{
        return $this->urlTranslator->getUrl($u, $type);
	}
	
	public static function autoload($className)
	{
        require_once $className . '.class.php';
	}
	
	public function set($name, $value)
	{
	    $this->actions->set($name, $value);
	}
	
	public static function getInstance()
	{
	    return self::$MVC_CONTROLLER;
	}

}

spl_autoload_register(array('Controller', 'autoload'));