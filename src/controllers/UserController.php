<?php

class UserController extends Controller
{
        
    public function registerAction()
    {       
        if ($this->getFormData('registerForm')) {
            $model = $this->getModel('user');
            $model->register();
        }
        
        return $this->render('user/register.html.twig');
    }

    public function loginAction()
    {
        if ($this->getFormData('loginForm')) {
            $model = $this->getModel('user');
            $model->login();

            return $this->redirect('');
        }
        
        return $this->render('user/login.html.twig');
    }
}
