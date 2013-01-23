<?php

interface Observable {
	public function addObserver(Observer $observer);
	
	public function notifyObservers($data);
}
?>