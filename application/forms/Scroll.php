<?php

class Form_scroll extends Zend_Form
{

    public function init()
    {
        $x=$this->createElement('text', 'x');
        $x->addValidator('Int')->addValidator('GreaterThan',null,array('min'=>'31'));
        $this->addElement($x);
        
        $y=$this->createElement('text', 'y');
        $y->addValidator('Int')->addValidator('GreaterThan',null,array('min'=>'31'));
        $this->addElement($y);
        
        $fx=$this->createElement('text', 'fx');
        $fx->addValidator('Int')->addValidator('GreaterThan',null,array('min'=>'31'));
        $this->addElement($fx);
        
        $fy=$this->createElement('text', 'fy');
        $fy->addValidator('Int')->addValidator('GreaterThan',null,array('min'=>'31'));
        $this->addElement($fy);
        
        $name=new Zend_Form_Element_Text('name');
        $file=new Zend_Validate_File_NotExists();
        $path=Zend_Registry::get('userPath');
        $file->setDirectory($path);
        $name->addValidator($file);
        $this->addElement($name);
        
        $delay=$this->createElement('text', 'delay');
        $delayT->addValidator('Int')->addValidator('GreaterThan',null,array('min'=>'10'));
        $this->addElement($delay);
        
        $prop=new Zend_Form_Element_Checkbox('prop');
        $prop->setCheckedValue('true');
        $prop->setUncheckedValue('false');
        $this->addElement($prop);
        
        $scrollType=new Zend_Form_Element_Radio('scrollType');
        $scrollType->addMultiOptions(array('v'=>'vertical','h'=>'horizontal'));
        $this->addElement($scrollType);
        
        $start=new Zend_Form_Element_Radio('start');
        $start->addMultiOptions(array('1'=>'1','2'=>'2'));
        $this->addElement($start);
        
        $custom=new Zend_Form_Element_Checkbox('custom');
        $custom->setCheckedValue('true');
        $custom->setUncheckedValue('false');
        $this->addElement($custom);
        
        $fox=$this->createElement('text', 'fox');
        $fox->addValidator('Regex',null,array('pattern' => '^[tep\d\+\-\*\/\^\(\)]+?$'));
        $this->addElement($fox);
        
        $fy=$this->createElement('text', 'foy');
        $foy->addValidator('Regex',null,array('pattern' => '^[tep\d\+\-\*\/\^\(\)]+?$'));
        $this->addElement($foy);
    }


}

