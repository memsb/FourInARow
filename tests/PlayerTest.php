<?php

require_once dirname(dirname(__FILE__)) . "/src/Player.php";

class PlayerTest extends PHPUnit_Framework_TestCase {
	
	protected $name = 'Player 1';
	protected $counter;
	protected $player;
	
	protected function setup(){
		$this->counter = $this->getMock('Counter', array(), array(null));
		$this->player = new Player($this->name, $this->counter);
	}
	
	public function testPlayerHasACounter(){
		$this->assertEquals($this->counter, $this->player->getCounter());
	}
	
	public function testPlayersName(){
		$this->assertEquals($this->name, $this->player->getName());
	}
}

?>