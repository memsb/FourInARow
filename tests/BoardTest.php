<?php

require_once dirname(dirname(__FILE__)) . "/src/Board.php";
require_once dirname(dirname(__FILE__)) . "/src/Counter.php";

class BoardTest extends PHPUnit_Framework_TestCase {

	protected $board;

	protected function setup() {
		$this->board = new Board(2, 2);
	}
	
	/**
	 * @expectedException InvalidBoardSizeException
	 */
	public function testCannotCreateZeroSizeboard() {
		$board = new Board(0, 0);
	}	

	public function testPlacingACounter() {
		$this->board->placeCounter(new Counter('X'), 0);
		$this->assertNotNull($this->board->getCell(new Position(0, 0)));
		$this->board->placeCounter(new Counter('X'), 0);
		$this->assertNotNull($this->board->getCell(new Position(0, 1)));
	}

	public function testGetLastPosition() {
		$this->board->placeCounter(new Counter('X'), 0);
		$this->assertEquals(new Position(0, 0), $this->board->getLastPosition());
		$this->board->placeCounter(new Counter('X'), 0);
		$this->assertEquals(new Position(0, 1), $this->board->getLastPosition());
	}

	public function testBoardSpaceIsEmpty() {
		$pos1 = new Position(0, 0);
		$this->assertTrue($this->board->positionIsEmpty($pos1));
		$this->board->placeCounter(new Counter('X'), 0);
		$this->assertFalse($this->board->positionIsEmpty($pos1));

		$pos2 = new Position(0, 1);
		$this->board->placeCounter(new Counter('X'), 0);
		$this->assertFalse($this->board->positionIsEmpty($pos1));
	}

	public function testColumnIsNotFull() {
		$this->assertFalse($this->board->columnIsFull(0));
		$this->board->placeCounter(new Counter('X'), 0);
		$this->assertFalse($this->board->columnIsFull(0));
		$this->board->placeCounter(new Counter('X'), 0);
		$this->assertTrue($this->board->columnIsFull(0));
	}

	public function testBoardIsFull() {
		$smallBoard = new Board(1, 1);
		$this->assertFalse($smallBoard->isFull());
		$smallBoard->placeCounter(new Counter('X'), 0);
		$this->assertTrue($smallBoard->isFull());
	}

	public function testCounterEquality() {
		$c = new Counter('X');
		$this->assertTrue($c->equals(new Counter('X')));
		$this->assertFalse($c->equals(new Counter('O')));
	}

	/**
	 * @expectedException InvalidPositionException
	 */
	public function testCounterOffLeftOfBoard() {
		$this->board->placeCounter(new Counter('X'), -1);
	}

	/**
	 * @expectedException InvalidPositionException
	 */
	public function testCounterOffRightOfBoard() {
		$this->board->placeCounter(new Counter('X'), 9);
	}


	public function testBoardHeight() {
		$this->assertEquals(2, $this->board->getHeight());
		$this->assertEquals(0, $this->board->getBottomRow());
		$this->assertEquals(1, $this->board->getTopRow());
		$this->assertEquals(array(1, 0), $this->board->getRowsFromTopDown());		
		$this->assertEquals(array(0, 1), $this->board->getRowsFromBottomUp());
	}

	public function testBoardWidth() {
		$this->assertEquals(2, $this->board->getWidth());
		$this->assertEquals(0, $this->board->getLeftColumn());
		$this->assertEquals(1, $this->board->getRightColumn());
		$this->assertEquals(array(0, 1), $this->board->getColumnsFromLeftToRight());
		$this->assertEquals(array(1, 0), $this->board->getColumnsFromRightToLeft());
	}

}
?>
