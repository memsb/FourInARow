<?php

require_once dirname(dirname(__FILE__)) . "/src/Game.php";

class GameTest extends PHPUnit_Framework_TestCase {

	protected $cols = 3;
	protected $rows = 3;
	protected $inARow = 3;

	protected $game;
	protected $board;

	protected function setup() {
		$this->board = new Board($this->cols, $this->rows);
		$this->factory = new CounterFactory( array('X', 'O') );
		
		$this->checker = $this->getMock('WinChecker', array('hasWin'), array($this->board));		
        $this->checker->expects($this->any())
                 ->method('hasWin')
				 ->will($this->returnValue(False));
		$this->game = new Game($this->board, $this->factory, $this->checker);
	}
	
	public function testNewGameHasNoWinner(){
		$this->assertFalse($this->game->hasWinner());
	}
	
	public function testGetBoard(){
		$this->assertTrue($this->game->getBoard() instanceof Board);
	}

	public function testFirstPlayer() {
		$this->assertEquals(1, $this->game->getCurrentPlayer());
	}

	public function testMakingAMoveChangesPlayer() {
		$this->assertEquals(1, $this->game->getCurrentPlayer());
		$this->game->move(0);
		$this->assertEquals(2, $this->game->getCurrentPlayer());
		$this->game->move(0);
		$this->assertEquals(1, $this->game->getCurrentPlayer());
	}

	public function testIllegalMoveDoesntChangePlayer() {
		$this->assertEquals(1, $this->game->getCurrentPlayer());
		$this->game->move(-1);
		$this->assertEquals(1, $this->game->getCurrentPlayer());
	}
	
	public function testNotifyObservers(){
		$observer = $this->getMockObserver();
		$this->game->addObserver($observer);
		$this->game->notifyObservers(null);
	}
	
	public function testStartingAGameNotifiesObservers(){
		$observer = $this->getMockObserver();
		$this->game->addObserver($observer);
		$this->game->notifyObservers(null);	
	}
	
	protected function getMockObserver(){
		$observer = $this->getMock('Observer', array('notify'));
		$observer->expects($this->once())
                 ->method('notify');
		return $observer;
	}
	
	public function testInvalidMoveSetsMessage(){
		$this->game->move(-1);
		$this->assertNotEmpty($this->game->getMessage());
	}	

	/**
	 * expectedException GameWonException
	 
	public function testGameWithWin() {
		$this->game->move(0);
		$this->game->move(1);
		$this->game->move(0);
		$this->game->move(1);
		$this->game->move(0);
	}
*/
	public function testGameWithoutWin() {
		$this->game->move(0);
		$this->game->move(0);
		$this->game->move(0);
	}

}
?>