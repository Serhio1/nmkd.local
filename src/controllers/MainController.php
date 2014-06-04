<?php

class MainController extends Controller
{
	public function indexAction()
	{
		$model = $this->getModel('nmkd');
		$sessionList = $model->getSessionList();
		
		return $this->render('main/homepage.html.twig', array(
			'sessionList' => $sessionList
		));
	}
	
	public function notFoundAction()
	{
		echo 'Page not Found';
	}
}
