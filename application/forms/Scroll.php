<?php

class Form_Scroll extends Zend_Form
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
        
        $nframe=$this->createElement('text', 'nframe');
        $nframe->addValidator('Int')->addValidator('GreaterThan',null,array('min'=>'1'))
        	->addValidator('LessThan',null,array('max'=>'51'));
        $this->addElement($nframe);
        
        $name=new Zend_Form_Element_Text('name');
        $file=new Zend_Validate_File_Exists();
        $path=Zend_Registry::get('userPath');
        $file->setDirectory($path);
        $name->addValidator($file);
        $this->addElement($name);
        
        $delay=$this->createElement('text', 'delay');
        $delay->addValidator('Int')->addValidator('GreaterThan',null,array('min'=>'9'));
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
        
        $fb=new Zend_Form_Element_Checkbox('fb');
        $fb->setCheckedValue('true');
        $fb->setUncheckedValue('false');
        $this->addElement($fb);
        
        $custom=new Zend_Form_Element_Checkbox('custom');
        $custom->setCheckedValue('true');
        $custom->setUncheckedValue('false');
        $this->addElement($custom);
        
        $fox=$this->createElement('text', 'fox');
        $fox->addValidator('Regex',null,array('pattern' => '/^[tep\d\+\-\*\/\^\(\)]+?$/'));
        $this->addElement($fox);
        
        $foy=$this->createElement('text', 'foy');
        $foy->addValidator('Regex',null,array('pattern' => '/^[tep\d\+\-\*\/\^\(\)]+?$/'));
        $this->addElement($foy);
    }


}

