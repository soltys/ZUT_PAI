<?php

require_once 'url-manage.inc.php';
require_once 'comment.inc.php';

/*
 * RODZAJE ADRESÓW URL:
 *
 * relative       =>  ./any/dir/file.html
 * root           =>  /root/dir/file.html
 * absolute       =>  http://localhost/root/dir/file.html
 *
 */



class URLTranslator
{
    private $options;

    private $adr;
    private $path_prefix_root;
    private $path_prefix_relative;
    private $path_prefix_absolute;
    private $path_prefix;

    private $input_routes;
    private $input_translated_routes;
    private $input_routes_count;

    private $output_routes;
    private $output_translated_routes;
    private $output_routes_count;
    
    
    public function getUpDir()
    {
        $tmp = explode('/', $this->adr);
        $ile = count($tmp);
        $result = str_repeat('../', $ile - 2);
        $result = trim($result, '/');
        
        if ($result == '') {
            return '.';
        } else {
            return $result;
        }
    }
    
    public function setOptions($options)
    {
        $this->options = array();
        $this->options['filename']     = '../scripts/translations.txt';
        $this->options['pathType']     = 'relative';
        $this->options['friendlyUrls'] = true;
        $this->options['host']         = 'http://localhost:8080';

        if (!is_null($options)) {
        
            if (isset($options['filename'])) {
                $this->options['filename'] = $options['filename'];
            }
            
            if (isset($options['pathType'])) {
                $this->options['pathType'] = $options['pathType'];
            }
            
            if (isset($options['friendlyUrls'])) {
                $this->options['friendlyUrls'] = $options['friendlyUrls'];
            }
            
            if (isset($options['host'])) {
                $this->options['host'] = $options['host'];
            }
        
        }
    }
    
    public function parseRoutes()
    {
        $REGEXP = '([^\/" <>&]+)';
    
        $plk = file_uncomment_and_trim($this->options['filename']);

        $this->input_routes = array();
        $this->input_translated_routes = array();

        $this->output_routes = array();
        
        $this->output_translated_routes = array();
        $this->output_translated_routes['raw'] = array();
        $this->output_translated_routes['unfriendly'] = array();
        $this->output_translated_routes['input'] = array();
        foreach ($plk as $route) {
            $e = preg_split('/\s+/', trim($route));

            $tmp_input = preg_quote($e[0], '/');
            $tmp_input = preg_replace('/REGEXP([0-9])/', $REGEXP, $tmp_input);
            $tmp_input = '/^"' . $tmp_input . '"$/';
            $this->input_routes[] = $tmp_input;
            
            $this->input_translated_routes[] = $e[1];

            $tmp_output = preg_quote($e[1], '/');
            $tmp_output = preg_replace('/REGEXP([0-9])/', $REGEXP, $tmp_output);
            $tmp_output = '/"' . $tmp_output . '"/m';
            $this->output_routes[] = $tmp_output;
            
            
            $tmp_unfriendly = $e[1];
            $tmp_unfriendly = preg_replace('/REGEXP([0-9])/', '\\\\\\1', $tmp_unfriendly);
            $this->output_translated_routes['unfriendly'][] = htmlspecialchars($tmp_unfriendly);
            
            
            $tmp_unfriendly_input = preg_quote($e[1], '/');
            $tmp_unfriendly_input = preg_replace('/REGEXP([0-9])/', $REGEXP, $tmp_unfriendly_input);
            $tmp_unfriendly_input = '/"\/' . $tmp_unfriendly_input . '"/m';
            $this->output_translated_routes['input'][] = $tmp_unfriendly_input;
            

            $output_raw_route = $e[0];
            $output_raw_route = preg_replace('/REGEXP([0-9])/',  '\\\\\\1', $output_raw_route);
            $this->output_translated_routes['raw'][] = $output_raw_route;

        }
        
        $this->input_routes_count = count($this->input_routes);
        $this->output_routes_count = count($this->output_routes);
        
        $this->output_translated_routes['relative'] = array();
        $this->output_translated_routes['absolute'] = array();
        $this->output_translated_routes['root'] = array();
        

    	if ($this->options['friendlyUrls']) {
    	
            for ($i = 0; $i < $this->output_routes_count; $i++) {

                $this->output_translated_routes['relative'][$i] = '"' .
                    $this->path_prefix_relative . $this->output_translated_routes['raw'][$i] . '"';

                $this->output_translated_routes['absolute'][$i] = '"' .
            	    $this->path_prefix_absolute . $this->output_translated_routes['raw'][$i] . '"';

                $this->output_translated_routes['root'][$i] = '"' .
                    $this->path_prefix_root . $this->output_translated_routes['raw'][$i] . '"';

            }

        } else {
        
            $this->input_routes = $this->output_translated_routes['input'];
            
            /*
             *usuwamy duplikaty
             *
             */
             
            $this->output_routes = array_unique($this->output_routes);
            $this->output_routes_count = count($this->output_routes);
            
            foreach ($this->output_routes as $k => $v) {
            
                $this->output_translated_routes['relative'][$k] = '"' .
                    $this->path_prefix_relative . '/' . $this->output_translated_routes['unfriendly'][$k] . '"';

                $this->output_translated_routes['absolute'][$k] = '"' .
            	    $this->path_prefix_absolute . '/' . $this->output_translated_routes['unfriendly'][$k] . '"';

                $this->output_translated_routes['root'][$k] = '"' .
                    $this->path_prefix_root . '/' . $this->output_translated_routes['unfriendly'][$k] . '"';
            }
        
        }
        
    }
    
    public function __construct($options = null)
    {
        $this->setOptions($options);
        $this->resolvePrefixes();
        $this->parseRoutes();
        $this->resolveCurrentRequest();
    }

    public function findInputRoute($url)
    {
        $url = '"' . $url . '"';

        for ($i = 0; $i < $this->input_routes_count; $i++) {
            if (preg_match($this->input_routes[$i], $url, $m)) {
                break;
            }
        }

        if ($i == $this->input_routes_count) {
            return false;
        } else {

            $r = $this->input_translated_routes[$i];

            for ($i = 1; $i < count($m); $i++) {
                $r = str_replace('REGEXP' . $i, $m[$i], $r);
            }

            /*
             *  Usuwamy początek: nazwę skryptu php
             *  ze znakiem zapytania włącznie, np.
             *
             *    index.php?
             *    s.php?
             *    dziwny-skrypt.php?
             */
            return preg_replace('/^[^.]+\.php\?/', '', $r);

        }
    }
    
    
    /*
     * relative       =>  ./any/dir/file.html
     * root           =>  /root/dir/file.html
     * absolute       =>  http://localhost/root/dir/file.html
     *
     */
    public function setPathPrefix($pathType)
    {
    	if ($pathType == 'relative') {
    	    $this->path_prefix = $this->path_prefix_relative . '/';
    	} else if ($pathType == 'root') {
    	    $this->path_prefix = $this->path_prefix_root . '/';
    	} else if ($pathType == 'absolute') {
    	    $this->path_prefix = $this->options['host'] . $this->path_prefix_root . '/';
    	}
    }
    
    public function getUrl($unfiriendly, $type = null)
    {
        return preg_replace($this->getOutputRoutes(), $this->getOutputTranslatedRoutes($type), $unfiriendly);
    }

    public function redirect($url)
    {
        $url = $this->getUrl($url, 'absolute');
        header('Location: ' . $url);
        exit();
    }

    public function getOutputRoutes()
    {
        return $this->output_routes;
    }
    
    public function getOutputTranslatedRoutes($type = null)
    {
    
        if (is_null($type)) {
            $tmp = $this->options['pathType'];
        } else {
            $tmp = $type;
        }

        return $this->output_translated_routes[$tmp];
    }
    
    
    public function resolvePrefixes()
    {
        /*
         * Adres URL bieżąco przetwarzanego żądania URL
         *
         */
        $this->adr = url_manage_get_friendly_url();

        $this->path_prefix_root = url_manage_get_rootdir();
        $this->path_prefix_relative = $this->getUpDir();
        $this->path_prefix_absolute = $this->options['host'] . $this->path_prefix_root;
        
        $this->setPathPrefix($this->options['pathType']);
    }

    
    public function resolveCurrentRequest()
    {

        /*
         * Czy adres bieżącego żądania URL zawarty w zmiennej $adr
         * ma zdefiniowaną regułę translacji?
         *     przyjazny <==> wewnętrzny?
         *     lub wewnętrzny  <==> wewnętrzny?
         *
         *
         * Jeśli tak to do tablicy $_GET dodajemy zmienne powstałe
         * po translacji adresu.
         */
        $route = $this->findInputRoute($this->adr);
        if ($route) {
            parse_str($route, $_GET);
        } else {
        
            foreach ($_GET as $k => $v) {
                unset($_GET[$k]);
            }

        };

    }
    
    public function getPathPrefix()
    {
        return $this->path_prefix;
    }

}
