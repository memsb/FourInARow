<?php

require_once dirname(dirname(__FILE__)) . "/src/Board.php";
require_once dirname(dirname(__FILE__)) . "/src/Exceptions.php";
require_once dirname(dirname(__FILE__)) . "/src/Counter.php";
require_once dirname(dirname(__FILE__)) . "/src/Position.php";

class BoardTest extends PHPUnit_Framework_TestCase {

	protected $board;

	protected function setup() {
		$this->board = new Board(6, 5);
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
		$this->board->placeCounter(new Counter('X'), 0);
		$this->board->placeCounter(new Counter('X'), 0);
		$this->board->placeCounter(new Counter('X'), 0);
		$this->board->placeCounter(new Counter('X'), 0);
		$this->assertTrue($this->board->columnIsFull(0));
	}

	public function testCounterEquality() {
		$c = new Counter('X');
		$this->assertTrue($c->equals(new Counter('X')));
		$this->assertFalse($c->equals(new Counter('O')));
	}

	/**
	 * @expectedException InvalidPositionException
	 */
	public function testCounterOffBoard() {
		$this->board->placeCounter(new Counter('X'), -1);
		$this->board->placeCounter(new Counter('X'), 9);
	}

}
?>
