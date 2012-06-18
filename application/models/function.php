<?php

function prova() {
	
}

class Model_function {
	private $call;
	private $opt;
	private $scalex;
	public $scaley;
	function __construct($callback,Array $option) {
		$this->call=$callback;
		$this->opt=$option;
		$this->scalex=(($option['x']-$option['fx']))/($option['nframe']-1);
		$this->scaley=(($option['y']-$option['fy']))/($option['nframe']-1);
	}
	function get($t) {
		return @call_user_method($this->call,$this, $t);
	} 
	function SimpleScrool($t) {
		switch ($this->opt['scrollType'].$this->opt['start']) {
			// v/h 1/2 (top/left bottom/rigth)
			default://vertical 
			case 'v1':// top->bottom \/
				$c=array('x'=>0,'y'=>intval($t*$this->scaley));
			break;
			case 'v2'://bottom->top /\
				$c=array('x'=>0,'y'=>intval(($this->opt['y']-$this->opt['fy'])-$t*$this->scaley));
			break;//horizzontal
			case 'h1'://left->rigth >>
				$c=array('y'=>0,'x'=>intval($t*$this->scalex));
			break;
			case 'h2'://rigth->left <<
				$c=array('y'=>0,'x'=>intval(($this->opt['x']-$this->opt['fx'])-$t*$this->scalex));
			break;
		}
		return $c;
	}
}

?>