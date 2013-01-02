<?php

require_once dirname(dirname(__FILE__)) . "/src/SimpleBoardPrinter.php";
require_once dirname(dirname(__FILE__)) . "/src/Board.php";
require_once dirname(dirname(__FILE__)) . "/src/Counter.php";

class SimpleBoardPrinterTest extends PHPUnit_Framework_TestCase {

    public function testNoBoardPrintsEmpty() {
        $printer = new SimpleBoardPrinter(new Board(0, 0));
        $this->assertEquals('', $printer->draw());
    }

    public function testPrintEmptySingleCellBoard() {
        $printer = new SimpleBoardPrinter(new Board(1, 1));
        $this->assertEquals('|_|' . PHP_EOL, $printer->draw());
    }

    public function testPrintRow() {
        $board = new Board(6, 1);
        $board->placeCounter(new Counter('X'), 3);
        $printer = new SimpleBoardPrinter($board);
        $this->assertEquals('|_|_|_|X|_|_|' . PHP_EOL, $printer->draw());
    }

    public function testPrintColumn() {
        $board = new Board(1, 5);
        $printer = new SimpleBoardPrinter($board);
        $this->assertEquals("|_|\n|_|\n|_|\n|_|\n|_|" . PHP_EOL, $printer->draw());
    }

    public function testPrintSmallBoard() {
        $board = new Board(2, 2);        
        $board->placeCounter(new Counter('X'), 1);        
        $board->placeCounter(new Counter('O'), 1);
        $printer = new SimpleBoardPrinter($board);
        $this->assertEquals("|_|O|\n|_|X|" . PHP_EOL, $printer->draw());
    }

}
?>
