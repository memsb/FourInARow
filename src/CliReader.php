<?php

require_once "Observable.php";
require_once "Exceptions.php";

class CliReader implements Observable {

	protected $observers = array();
	protected $exitChar = 'x';
	
	public function addObserver(Observer $observer){
		$this->observers[] = $observer;
	}
	
	public function notifyObservers($data){
		foreach($this->observers as $observer){
			$observer->notify($data);
		}
	}
	
	public function setExitCharacter($char){
		$this->exitChar = $char;
	}
	
	public function formatAsInt($data){
		return intval($data);
	}
	
	public function prompt($name){
		return "{$name}s move: ";
	}
	
	public function read($playerName){
		echo $this->prompt($playerName) . PHP_EOL;
		$input = $this->getInputString();
		if( strlen($input) > 0 ){
			$int = $this->formatAsInt($input);
			$this->notifyObservers($int);
		}
	}
	
	protected function getInputString(){
		$input = $this->readFromCli();
		if(strcmp($input, $this->exitChar) == 0){
			throw new ExitSignalException("Exiting.");
		}
		return $input;
	}
	
	/**
	 * Function contents is untestable and has been isolated to be mocked.
	 * @codeCoverageIgnoreStart
	 */ 
	protected function readFromCli(){            
		return trim(fread(STDIN, 4));
	}
	// @codeCoverageIgnoreEnd
}

?>