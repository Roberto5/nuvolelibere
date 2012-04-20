<?php

class DeleteController extends Zend_Controller_Action
{

    public function init()
    {
        Zend_Layout::getMvcInstance()->disableLayout();
    }

    public function indexAction()
    {
        $form=new Form_Delete();
        if ($form->isValid($_POST)) {
        	$path=Zend_Registry::get('userPath');
        	$name=$form->getValue('file');
        	unlink("$path/$name");
        	unlink("$path/thumb$name");
        	echo "cancello $path/$name e $path/thumb$name";
        }
        else print_r($form->getErrorMessages());
    }


}

