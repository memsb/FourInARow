<?php

require_once "Observable.php";

class CliReader implements Observable {

	protected $observers = array();
	
	public function addObserver(Observer $observer){
		$this->observers[] = $observer;
	}
	
	public function notifyObservers($data){
		foreach($this->observers as $observer){
			$observer->notify($data);
		}
	}
	
	public function formatAsInt($data){
		return intval($data);
	}
	
	public function prompt($name){
		return "{$name}s move: ";
	}
	
	public function read($playerNumber){
		echo $this->prompt($playerNumber) . PHP_EOL;
		$input = fread(STDIN, 10);
		$int = $this->formatAsInt($input);
		$this->notifyObservers($int);
	}
}

?>