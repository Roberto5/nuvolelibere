<?php

class Form_Frame extends Zend_Form
{

    public function init()
    {
        $x=$this->createElement('text', 'x');
        $x->addValidator('Int')->addValidator('GreaterThan',null,array('min'=>'31'));
        $this->addElement($x);
        $y=$this->createElement('text', 'y');
        $y->addValidator('Int')->addValidator('GreaterThan',null,array('min'=>'31'));
        $this->addElement($y);
        $name=new Zend_Form_Element_MultiCheckbox('name');
        $name->setRegisterInArrayValidator(false);
        $file=new Zend_Validate_File_NotExists();
        $path=Zend_Registry::get('userPath');
        $file->setDirectory($path);
        $name->addValidator($file);
        $this->addElement($name);
        $delay=new Zend_Form_Element_MultiCheckbox('delay');
        $delay->setRegisterInArrayValidator(false);
        $delay->addValidator('Int')->addValidator('GreaterThan',null,array('min'=>'9'));
        $this->addElement($delay);
        $delayTot=new Zend_Form_Element_Checkbox('delayTot');
        $delayTot->setCheckedValue("true")->setUncheckedValue("false");
        $this->addElement($delayTot);
        $delayT=$this->createElement('text', 'delayT');
        $delayT->addValidator('Int')->addValidator('GreaterThan',null,array('min'=>'10'));
        $this->addElement($delayT);
        $frameadd=new Zend_Form_Element_Radio('frameadd');
        $frameadd->setMultiOptions(array('1'=>'combine','2'=>'replace','0'=>'0','3'=>'3'));
        $this->addElement($frameadd);
        $prop=new Zend_Form_Element_Checkbox('prop');
        $prop->setCheckedValue('true');
        $prop->setUncheckedValue('false');
        $this->addElement($prop);
        $dimT=new Zend_Form_Element_Checkbox('dimT');
        $dimT->setCheckedValue('true');
        $dimT->setUncheckedValue('false');
        $this->addElement($dimT);
        $dimx=new Zend_Form_Element_MultiCheckbox('dimx');
        $dimx->setRegisterInArrayValidator(false);
        $dimx->addValidator('Int')->addValidator('GreaterThan',null,array('min'=>'31'));
        $this->addElement($dimx);
        $dimy=new Zend_Form_Element_MultiCheckbox('dimy');
        $dimy->setRegisterInArrayValidator(false);
        $dimy->addValidator('Int')->addValidator('GreaterThan',null,array('min'=>'31'));
        $this->addElement($dimy);
    }


}

