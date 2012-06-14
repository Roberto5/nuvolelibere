<?php

class CreateController extends Zend_Controller_Action
{

    public function init() {
        $auth=Zend_Auth::getInstance();
		if ($auth->hasIdentity()) $this->view->user=$auth->getIdentity()->uid;
		else $this->view->user=Model_guest::getgid();
    }

    public function indexAction() {
    	
    }

	public function frameAction() {
		
	}
	public function scrollAction() {
		
	}
}

