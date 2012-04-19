<?php

class UploaderController extends Zend_Controller_Action
{

	public function init()
	{
		$this->_helper->layout->disableLayout();
	}

	public function indexAction()
	{
		$maxsize=ini_get('upload_max_filesize');
		$maxsize=str_replace("M", "", $maxsize);
		$maxsize*=1048576;
		$rEFileTypes ="/^\.(jpg|jpeg|gif|png){1}$/i";
		$auth=Zend_Auth::getInstance();
		if ($auth->hasIdentity())  $user=$auth->getIdentity()->uid;
		else $user=Model_guest::getgid();
		$thumb=new Plugin_thumb($user);
		$uploaddir = APPLICATION_PATH.'/../upload/';
		@mkdir($uploaddir.$user);
		$uploaddir.=$user;
		$filename = preg_replace(
		array("/\s+/", "/[^-\.\w]+/"),
		array("_", ""),
		trim($_FILES['uploadfile']['name']));
		$file = $uploaddir .'/'. basename($filename);
		if ($_FILES['uploadfile']['size']>$maxsize) {
			$this->view->result= $this->_t->_('E_SIZE');
		}
		elseif (preg_match($rEFileTypes, strrchr($filename, '.'))) {
			if (move_uploaded_file($_FILES['uploadfile']['tmp_name'], $file)) {
				$this->view->result= "true";
				$thumb->create($filename);
			} else {
				$this->view->result= $this->_t->_('E_FATAL');
			}
		}
		else $this->view->result= $this->_t->_('E_TYPE');
	}


}

