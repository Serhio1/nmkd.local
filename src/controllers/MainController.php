<?php

class MainController extends Controller
{
    public function indexAction()
    {
        $model = $this->getModel('nmkd');
        //$sessionList = $model->getSessionList();
        $disciplines = $model->getDisciplines();
        
        return $this->render('main/homepage.html.twig', array(
            //'sessionList' => $sessionList
            'disciplines' => $disciplines,
        ));
    }
    
    public function notFoundAction()
    {
        echo 'Page not Found';
    }
}
