<?php

class Routes
{
    public $routes = array(
    //regexp => controller/action 
    
    //userControler
        'user/register' => 'user/register',
        'user/login' => 'user/login',
        'user' => 'user/index',
    
    //nmkdController
        'nmkd/input' => 'nmkd/input',
        'input' => 'nmkd/index',
        'nmkd/set-hierarchy' => 'nmkd/setHierarchy',
        'nmkd/set-types' => 'nmkd/setTypes',
        'questions-themes' => 'nmkd/questionsToThemes',
        /*'set-themes' => 'nmkd/setThemes',
        'set-modules' => 'nmkd/setModules',*/
        'themes-modules' => 'nmkd/themesToModules',
        'save-session' => 'nmkd/saveSession',
        'restore-session' => 'nmkd/restoreSession',
        'nmkd/edit' => 'nmkd/editNmkd',
        'nmkd/download-pdf' => 'nmkd/downloadPdf',
        'nmkd/download-pdffromstr' => 'nmkd/downloadPdfFromStr',
        'questions-upload' => 'nmkd/uploadQuestions',
        
        
    //mainController
        '' => 'main/index',     //route with empty regexp must stand at last
    );
    
    
    ///([-_a-z0-9]+)
    
}
