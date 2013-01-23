<?php

require_once "Counter.php";

class Player {
	
	protected $name;
	protected $counter;
	
	public function __construct($name, Counter $counter){
		$this->name = $name;
		$this->counter = $counter;
	}
	
	public function getName(){
		return $this->name;
	}
	
	public function getCounter(){
		return $this->counter;
	}
}
?>