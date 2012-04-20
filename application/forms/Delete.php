<?php

class Form_Delete extends Zend_Form
{

    public function init()
    {
        $val=new Zend_Validate_File_Exists();
        $val->setDirectory(Zend_Registry::get('userPath'));
        $file=$this->createElement('text', 'file');
        $file->addValidator($val);
        $this->addElement($file);
    }


}

