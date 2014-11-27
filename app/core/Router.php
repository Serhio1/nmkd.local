<?php

class Router
{
    private $routes;
    
    public function init()
    {
        $uri = $this->getURI();
        
        
        
        
        
        
        /*$url = $this->getURL();
        $vendor = Container::get('params')->vendor;
        $vendorPos = strpos($url, $vendor);
        
        //echo $vendor;
        
        if (substr_count($url, $vendor) > 0) {
            print_r(substr($url, $vendorPos+strlen($vendor)+1));
        } else {
            //echo 'false';
        }*/
        
        
        
        foreach($this->routes as $regExp => $route) {
            //echo $uri.'<br>';
            if(preg_match("~$regExp~", $uri)) {
            
            //if (substr_count($regExp, $uri)) {
                $internalRoute = preg_replace("~$regExp~", $route, $uri);
                $segments = explode('/', $internalRoute);
                /*if ($segments[0] == Container::get('params')->vendor) {
                    array_shift($segments);
                }*/
                $controller = ucfirst(array_shift($segments)).'Controller';
                $action = array_shift($segments).'Action';
                $params = $segments;                
                if(!is_callable(array($controller, $action))){
                    $controller = new MainController();
                    $controller->notFoundAction();
                    
                    return;
                }
                if(isset($_SESSION['redirectData'])) {
                    $_POST['redirectData'] = $_SESSION['redirectData'];
                    unset($_SESSION['redirectData']);
                }


                $this->preControllerProcessing();

                
                $controller = new $controller();
                $controller->$action($params);
                
                return;
            }
            
        }
        $controller = new MainController();
        $controller->notFoundAction();
        
        return;
    }
    
    public function getURI()
    {
        $url = $this->getURL();
        $vendor = Container::get('params')->vendor;
        $vendorPos = strpos($url, $vendor);
        if (substr_count($url, $vendor) > 0) {
            return substr($url, $vendorPos+strlen($vendor)+1);
        } else {
            return false;
        }
        
        /*if(!empty($_SERVER['REQUEST_URI'])) {
        
            return trim($_SERVER['REQUEST_URI'], '/');
        }
        if(!empty($_SERVER['PATH_INFO'])) {
        
            return trim($_SERVER['PATH_INFO'], '/');
        }
        if(!empty($_SERVER['QUERY_STRING'])) {
        
            return trim($_SERVER['QUERY_STRING'], '/');
        }*/
    }
    
    public function getURL() {
        return $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];
    }
    
    public function setRoutes($routes)
    {
        $this->routes = $routes;
    }
    
    public function redirect($url, $data=array())
    {
        $_SESSION['redirectData'] = $data;
        header('location: ' . $url);
    }

    private function preControllerProcessing()
    {
        //user access inspection, ajax handling, etc...
        if(isset($_SERVER['HTTP_X_REQUESTED_WITH']) &&
           !empty($_SERVER['HTTP_X_REQUESTED_WITH']) &&
           strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest') {
        
            $_POST['isAjax'] = true;
        }

    }

    /**
     * Returns http or https, depends on used protocol.
     *
     * @return string
     */
    public static function getProtocol()
    {
        $protocol = isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] != 'off' ? 'https://' : 'http://';
        return $protocol;
    }

    /**
     * Returns domain name.
     *
     * @return string
     * @throws Exception
     */
    public static function getBaseUrl()
    {
        $baseUrl = ($_SERVER['HTTP_HOST'] != Container::get('params')->vendor) ? $_SERVER['HTTP_HOST'] . '/' . Container::get('params')->vendor : $_SERVER['HTTP_HOST'];
        return $baseUrl;
    }

    /**
     * Builds absolute url address.
     *
     * Example of usage: url('/nmkd/input', array($id));.
     *
     * @param string $uri
     * @param array $params
     * @return string
     */
    public static function buildUrl($uri, $params = array())
    {
        $strParams = implode( '/', $params);
        $protocol = self::getProtocol();
        $baseUrl = self::getBaseUrl();
        return $protocol . $baseUrl . $uri . $strParams;
    }

}
