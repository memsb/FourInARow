<?php

require_once dirname(dirname(__FILE__)) . "/src/Board.php";
require_once dirname(dirname(__FILE__)) . "/src/Counter.php";

class BoardTest extends PHPUnit_Framework_TestCase {

	protected $board;
	protected $counter;

	protected function setup() {
		$this->board = new Board(2, 2);
		$this->counter = $this->getMock('Counter', array(), array(null));
	}
	
	/**
	 * @expectedException InvalidBoardSizeException
	 */
	public function testCannotCreateZeroSizeboard() {
		$board = new Board(0, 0);
	}	

	public function testPlacingACounter() {
		$col = 0;
		$this->board->placeCounter($this->counter, $col);
		$this->assertNotNull($this->board->getCell(new Position($col, 0)));
		$this->board->placeCounter($this->counter, $col);
		$this->assertNotNull($this->board->getCell(new Position($col, 1)));
	}

	public function testGetLastPosition() {
		$col = 0;
		$this->board->placeCounter($this->counter, $col);
		$this->assertEquals(new Position($col, 0), $this->board->getLastPosition());
		$this->board->placeCounter($this->counter, $col);
		$this->assertEquals(new Position($col, 1), $this->board->getLastPosition());
	}

	public function testBoardSpaceIsEmpty() {
		$col = 0;
		$pos1 = new Position($col, 0);
		$this->assertTrue($this->board->positionIsEmpty($pos1));
		$this->board->placeCounter($this->counter, $col);
		$this->assertFalse($this->board->positionIsEmpty($pos1));

		$pos2 = new Position($col, 1);
		$this->board->placeCounter($this->counter, $col);
		$this->assertFalse($this->board->positionIsEmpty($pos1));
	}

	/**
	 * @expectedException InvalidPositionException
	 */
	public function testColumnIsFull() {
		$col = 0;
		$this->assertFalse($this->board->columnIsFull($col));
		$this->board->placeCounter($this->counter, $col);
		$this->assertFalse($this->board->columnIsFull($col));
		$this->board->placeCounter($this->counter, $col);
		$this->assertTrue($this->board->columnIsFull($col));
		$this->board->placeCounter($this->counter, $col);
	}

 	public function testBoardIsFull() {
		$smallBoard = new Board(1, 1);
		$this->assertFalse($smallBoard->isFull());
		$col = 0;
		$smallBoard->placeCounter($this->counter, $col);
		$this->assertTrue($smallBoard->isFull());
	}

	/**
	 * @expectedException InvalidPositionException
	 */
	public function testCounterOffLeftOfBoard() {
		$this->board->placeCounter($this->counter, -1);		
	}

	/**
	 * @expectedException InvalidPositionException
	 */
	public function testCounterOffRightOfBoard() {
		$this->board->placeCounter($this->counter, 9);
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
