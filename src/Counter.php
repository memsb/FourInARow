<?php

class Counter {
	
	public $char;
	
	function __construct($char){
		$this->char = $char;
	}
	
	public function equals(Counter $c){
		return strcmp($this->char, $c->char) == 0;
	}
}
?>