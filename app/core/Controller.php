<?php

class Controller
{
    protected $errors = '';
    protected $hints = array();
    
    public function render($view, $data=array())
    {
        $twig = Container::get('twig');
        $data = array_merge($data, $this->preRenderProcessing());
        echo $twig->render($view, $data);
    }
    
    protected function redirect($url, $data=array())
    {
        Container::get('router')->redirect($url, $data);
    }
    
    protected function storage()
    {
        return Container::get('session_storage');
    }
    
    public function getModel($model)
    {
        $modelStr = ucfirst($model).'Model';
        $model = $modelStr::getInstance();

        return $model;
    }

    protected function preRenderProcessing()
    {
        $globalTemplateData = array(
            'errors'=>$this->errors,
        );
        //dynamic template data, wich uses in all templates (many templates)
        //menu data, sidebar data, etc

        return $globalTemplateData;
    }

    protected function getFormData($form)
    {
        return Container::get('form_mngr')->getFormData($form);
    }

    protected function outErrors()
    {
        return Container::get('errors')->outErrors();
    }

    protected function getForm($form)
    {
        return Container::get('form_mngr')->getForm($form);
    }

    protected function params()
    {
        return Container::get('params');
    }
}
