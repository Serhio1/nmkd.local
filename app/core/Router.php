<?php

class Router
{
    private $routes;
    
    public function init()
    {
        $uri = $this->getURI();

        foreach($this->routes as $regExp => $route) {
            if(preg_match("~$regExp~", $uri)) {
                $internalRoute = preg_replace("~$regExp~", $route, $uri);
                $segments = explode('/', $internalRoute);
                if ($segments[0] == Container::get('params')->vendor) {
                    array_shift($segments);
                }
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
    
    protected function getURI()
    {
        if(!empty($_SERVER['REQUEST_URI'])) {
        
            return trim($_SERVER['REQUEST_URI'], '/');
        }
        if(!empty($_SERVER['PATH_INFO'])) {
        
            return trim($_SERVER['PATH_INFO'], '/');
        }
        if(!empty($_SERVER['QUERY_STRING'])) {
        
            return trim($_SERVER['QUERY_STRING'], '/');
        }
    }
    
    public function setRoutes($routes)
    {
        $this->routes = $routes;
    }
    
    public function redirect($url, $data=array())
    {
        $_SESSION['redirectData'] = $data;
        header('location: '.Container::get('params')->vendor.'/'.$url);
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
    
}
