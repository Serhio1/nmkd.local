<?php

class Services
{

    public static function registerServices()
    {
        Container::register('router',function(){
            $routes = new Routes();
            $router = new Router();
            $router->setRoutes($routes->routes);

            return $router;
        });
        
        Container::register('params',function(){
            return new Parameters;
        });
        
        Container::register('twig',function(){
            $loader = new Twig_Loader_Filesystem(Container::get('params')
                ->getViewDir());
                
            return new Twig_Environment($loader);
            
//uncomment to enable cache
            /*return new Twig_Environment($loader, array(
                'cache' => Container::get('params')
                ->getCacheDir(),
            ));*/
        });

        Container::register('twigStr',function(){
            $loader = new Twig_Loader_String();
                
            return new Twig_Environment($loader);
        });
        
        Container::register('static_storage',function(){
            return new StaticStorage();
        });

        Container::register('form_mngr',function(){
            $formManager = new FormManager();
            $formManager->getForms(new Forms());
            return $formManager;
        });

        Container::register('pdf',function(){
            
            include(Container::get('params')->getMPdfLocation());
            $pdf = new Pdf();
            //left, right, top, bottom
            $pdf->getMPDF(new mPDF('utf-8', 'A4', '8', '', 25, 15, 20, 20, 10, 10));

            return $pdf;
        });

        Container::register('errors',function(){
            
            return Errors::getInstance();
        });
    }
    
}

