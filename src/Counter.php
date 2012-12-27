<?php

class Counter {
	
	public $char;
	
	function __construct($char){
		$this->char = $char;
	}
	
	public function equals(Counter $c){
		return $this->char == $c->char;
	}
}
?>