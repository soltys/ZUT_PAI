<?php


/*
 * Helper do konwersji adresów URL
 *
 *
 */
function url($u, $type = null)
{

    $dl = strlen($u);
    if ($dl == 0) {
        return '';
    }
    
    $controller = Controller::getInstance();
    
    if (
        ($u[0] == '"') &&
        ($u[$dl - 1] == '"')
    ) {
        return $controller->getUrl($u, $type);
    } else {
        return trim($controller->getUrl('"' . $u . '"', $type), '"');
    }

}

/*
 * Helper do partiali
 *
 *
 */
function partial($template, $vars = null)
{
    $controller = Controller::getInstance();
    $view_class_name = $controller->getOption('viewClass');
    require_once $view_class_name . '.class.php';
    $view = new $view_class_name();
    
    if (is_null($vars)) {
        $vars = array();
    }

    $vars['module'] = $controller->getModule();
    $vars['action'] = $controller->getAction();
    $vars['path_prefix'] = $controller->getPathPrefix();
    
    foreach ($vars as $k=>$v) {
        $view->assign($k, $v);
    }
    return $view->fetch($template);
}

