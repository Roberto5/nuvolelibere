<?php

class CreateController extends Zend_Controller_Action
{

    public function init()
    {
        /* Initialize action controller here */
    }

    public function indexAction()
    {
        // action body
    }

	public function frameAction() {
		$auth=Zend_Auth::getInstance();
		if ($auth->hasIdentity()) $this->view->user=$auth->getIdentity()->uid;
		else $this->view->user=Model_guest::getgid();
	}
	public function scrollAction() {
		
	}
}

