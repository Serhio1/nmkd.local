<?php

class Controller
{
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
        return Container::get('static_storage');
    }
    
    public function getModel($model)
    {
        $modelStr = ucfirst($model).'Model';
        $model = $modelStr::getInstance();

        return $model;
    }

    protected function preRenderProcessing()
    {
		$globalTemplateData = array();
		//dynamic template data, wich uses in all templates (many templates)
		//menu data, sidebar data, etc

		return $globalTemplateData;
	}

	protected function getFormData($form)
	{
		return Container::get('form_mngr')->getFormData($form);
	}
    
}
