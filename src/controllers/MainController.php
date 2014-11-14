<?php

class MainController extends Controller
{
    public function indexAction()
    {
        $model = $this->getModel('nmkd');
        //$sessionList = $model->getSessionList();
        $disciplines = $model->getDisciplines();

        foreach ($disciplines as $row => $discipline) {
            if ($model->nmkdExist($discipline['id'])) {
                $disciplines[$row]['nmkd_exists'] = 1;
            } else {
                $disciplines[$row]['nmkd_exists'] = 0;
            }
        }
        
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
