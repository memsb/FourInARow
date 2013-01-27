<?php

require_once dirname(dirname(__FILE__)) . "/src/Game.php";

class GameTest extends PHPUnit_Framework_TestCase {

	protected $cols = 3;
	protected $rows = 3;
	protected $inARow = 3;

	protected $game;
	protected $player1;
	protected $player2;

	protected function setup() {
		$board = new Board($this->cols, $this->rows);	
		$checker = new WinChecker($board, $this->inARow);
				 
		$this->player1 = new Player('player 1', new Counter('X'));
		$this->player2 = new Player('player 1', new Counter('O'));				 
				 
		$this->game = new Game($board, $checker);		
		$this->game->addPlayer($this->player1);
		$this->game->addPlayer($this->player2);
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
		$this->assertEquals($this->player1, $this->game->getCurrentPlayer());
		$this->game->move(-1);
		$this->assertEquals($this->player1, $this->game->getCurrentPlayer());
	}
	
	public function testMakingAMoveNotifiesObservers(){
		$observer = $this->getMock('Observer', array('notify'));
		$observer->expects($this->once())
                 ->method('notify');
		$this->game->addObserver($observer);
		$this->game->move(0);
	}	
	
	public function testStartingAGameNotifiesObservers(){
		$observer = $this->getMock('Observer', array('notify'));
		$observer->expects($this->once())
                 ->method('notify');
		$this->game->addObserver($observer);
		$this->game->start();
	}
	
	public function testInvalidMoveSetsMessage(){
		$this->assertEmpty($this->game->getMessage());
		$this->game->move(-1);
		$this->assertNotEmpty($this->game->getMessage());
		$this->game->move(0);
		$this->assertEmpty($this->game->getMessage());
	}
	
	public function testFullColumnSetsMessage(){
		$this->assertEmpty($this->game->getMessage());
		$this->game->move(0);
		$this->game->move(0);
		$this->game->move(0);
		$this->game->move(0);
		$this->assertNotEmpty($this->game->getMessage());
	}
		
	/**
	 * @expectedException GameOverException 
	 */
	public function testFullBoardEndsGame(){
		$this->assertEmpty($this->game->getMessage());
		for($col = 0; $col < $this->cols; $col++){
			for($row = 0; $row < $this->rows; $row++){
				$this->game->move($col);
			}
		}
	}
	
	/**
	 * @expectedException GameOverException 
	 */
	public function testGameWithWin() {
		$this->game->move(0);
		$this->game->move(1);
		$this->game->move(0);
		$this->game->move(1);
		$this->game->move(0);
	}

	public function testGameWithoutWin() {
		$this->game->move(0);
		$this->game->move(0);
		$this->game->move(0);
	}

}
?>