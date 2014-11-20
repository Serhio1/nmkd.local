<?php

class MainController extends Controller
{
    public function indexAction()
    {
        $model = $this->getModel('nmkd');
        //$sessionList = $model->getSessionList();
        $disciplines = $model->getDisciplines();
        $options = array();

        foreach ($disciplines as $row => $discipline) {
            $disciplineOptions[$discipline['id']] = array(
                'create' => array(
                        'url' => Router::buildUrl('/nmkd/input/', array($discipline['id'])),
                        'title' => 'Сформувати НМЗД',
                        'icon' => 'glyphicon-cog',
                        'classes' => '',
                    ),
                'edit' => array(
                        'url' => Router::buildUrl('/nmkd/input/', array($discipline['id'])),
                        'title' => 'Редагувати НМЗД',
                        'icon' => 'glyphicon-wrench',
                        'classes' => '',
                    ),
                'view' => array(
                        'url' => Router::buildUrl('/nmkd/edit/', array($discipline['id'])),
                        'title' => 'Переглянути НМЗД',
                        'icon' => 'glyphicon-eye-open',
                        'classes' => '',
                    ),
            );

            if ($model->nmkdExist($discipline['id'])) {
                $disciplineOptions[$discipline['id']]['create']['classes'] .= 'submenu-disabled ';
                $disciplineOptions[$discipline['id']]['create']['url'] = '#';
            } else {
                $disciplineOptions[$discipline['id']]['edit']['classes'] .= 'submenu-disabled ';
                $disciplineOptions[$discipline['id']]['edit']['classes'] = '#';
            }
        }
        
        return $this->render('main/homepage.html.twig', array(
            //'sessionList' => $sessionList
            'disciplines' => $disciplines,
            'discipline_options' => $disciplineOptions,
        ));
    }
    
    public function notFoundAction()
    {
        echo 'Page not Found';
    }
}
