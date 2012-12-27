<?php

require_once dirname(dirname(__FILE__)) . "/src/BoardPrinter.php";
require_once dirname(dirname(__FILE__)) . "/src/Board.php";
require_once dirname(dirname(__FILE__)) . "/src/Counter.php";

class BoardPrinterTest extends PHPUnit_Framework_TestCase {
	
	public function testNoBoardPrintsEmpty() {
		$printer = new BoardPrinter(new Board(0, 0));
		$this->assertEquals('|', $printer->draw());
	}

	public function testPrintEmptySingleCellBoard() {
		$printer = new BoardPrinter(new Board(1, 1));
		$this->assertEquals('|_|', $printer->draw());
	}	

	public function testPrintRow() {
		$board = new Board(6, 1);
		$board->placeCounter(new Counter('X'), 3);
		$printer = new BoardPrinter($board);
		$this->assertEquals('|_|_|_|X|_|_|', $printer->draw());
	}
	
	public function testPrintColumn() {
		$board = new Board(1, 5);
		$printer = new BoardPrinter($board);
		$this->assertEquals("|_|
							|_|
							|_|
							|_|
							|_|", $printer->draw());
	}
}
?>
