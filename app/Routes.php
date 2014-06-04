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
		'input' => 'nmkd/index',
		'questions-themes' => 'nmkd/questionsToThemes',
		'set-themes' => 'nmkd/setThemes',
		'set-modules' => 'nmkd/setModules',
		'themes-modules' => 'nmkd/themesToModules',
		'set-types' => 'nmkd/setTypes',
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
