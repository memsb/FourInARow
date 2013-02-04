<?php

require_once dirname(dirname(__FILE__)) . "/src/Game.php";

class GameTest extends PHPUnit_Framework_TestCase {

	protected $cols = 3;
	protected $rows = 3;
	protected $inARow = 3;

	protected $game;
	protected $board;
	protected $checker;
	protected $player1;
	protected $player2;

	protected function setup() {
		$this->board = $this->getMockBoard(); 
		$this->checker = $this->getDummyChecker();
		$this->game = new Game($this->board, $this->checker);
		$this->player1 = $this->getDummyPlayer();
		$this->game->addPlayer($this->player1);
		$this->player2 = $this->getDummyPlayer();
		$this->game->addPlayer($this->player2);
	}
	
	protected function getMockBoard(){
		$board = $this->getMock('Board', array(), array($this->cols, $this->rows));
		$board->expects($this->any())
			->method('getLastPosition')
			->will($this->returnValue(new Position(0, 0)));
		return $board;
	}
	
	protected function getDummyChecker(){
		return $this->getMock('WinChecker', array(), array($this->inARow));
	}
	
	protected function getDummyPlayer(){
		return $this->getMock('Player', array(), array('Player', $this->getDummyCounter()));
	}
	
	protected function getDummyCounter(){
		return $this->getMock('Counter', array(), array(''));
	}
	
	protected function getObserverThatExpectsToBeCalled(){
		$observer = $this->getMock('Observer', array('notify'));
		$observer->expects($this->once())
                 ->method('notify');
		return $observer;
	}

	public function testGetBoard(){
		$this->assertTrue($this->game->getBoard() instanceof Board);
	}
	
	public function testFirstPlayer() {
		$this->assertEquals($this->player1, $this->game->getCurrentPlayer());
	}

	public function testMakingAMoveChangesPlayer() {
		$this->assertEquals($this->player1, $this->game->getCurrentPlayer());
		$this->game->move(0);
		$this->assertEquals($this->player2, $this->game->getCurrentPlayer());
		$this->game->move(0);
		$this->assertEquals($this->player1, $this->game->getCurrentPlayer());
	}

	public function testIllegalMoveDoesntChangePlayer() {		
		$this->board->expects($this->any())
			->method('placeCounter')
			->will($this->throwException(new InvalidPositionException()));
		$this->assertEquals($this->player1, $this->game->getCurrentPlayer());
		$this->game->move(-1);
		$this->assertEquals($this->player1, $this->game->getCurrentPlayer());
	}
	
	public function testNotifyingObserverMakesAMove(){
		$this->board->expects($this->once())
			->method('placeCounter');
		$this->game->notify(0);
	}
	
		
	public function testMakingAMoveNotifiesObservers(){			
		$this->game->addObserver($this->getObserverThatExpectsToBeCalled());
		$this->game->move(0);
	}	

	public function testStartingAGameNotifiesObservers(){		
		$this->game->addObserver($this->getObserverThatExpectsToBeCalled());
		$this->game->start();
	}

	public function testInvalidMoveSetsMessage(){
		$msg = 'test';
		$this->board->expects($this->at(0))
			->method('placeCounter')
			->will($this->throwException(new InvalidPositionException($msg)));
			
		$this->assertEquals('', $this->game->getMessage());
		$this->game->move(-1);
		$this->assertEquals($msg, $this->game->getMessage());
		$this->game->move(0);
		$this->assertEquals('', $this->game->getMessage());
	}

	public function testFullColumnSetsMessage(){		
		$msg = 'test';
		$this->board->expects($this->at(0))
			->method('placeCounter')
			->will($this->throwException(new InvalidPositionException($msg)));			
		
		$this->assertEquals('', $this->game->getMessage());
		$this->game->move(0);
		$this->assertEquals($msg, $this->game->getMessage());
	}
	
	/**
	 * @expectedException GameOverException 
	 */
	public function testFullBoardEndsGame(){
		$this->board->expects($this->any())
			->method('isFull')
			->will($this->returnValue(True));
			
		$this->game->move(0);
	}
	
	/**
	 * @expectedException GameOverException 
	 */
	public function testGameWithWin() {
		$this->checker->expects($this->any())
			->method('hasWin')
			->will($this->returnValue(True));
		$this->game->move(0);
	}
}
?>