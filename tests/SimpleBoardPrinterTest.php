<?php

require_once dirname(dirname(__FILE__)) . "/src/SimpleBoardPrinter.php";
require_once dirname(dirname(__FILE__)) . "/src/Counter.php";

class SimpleBoardPrinterTest extends PHPUnit_Framework_TestCase {
	
	protected $printer;
	
	protected function setup(){
		$this->printer = new SimpleBoardPrinter();
	}

    public function testPrintEmptySingleCellBoard() {
    	$board = new Board(1, 1);
        $this->assertEquals("|0|\n|_|" . PHP_EOL, $this->printer->draw($board));
    }

    public function testPrintRow() {
        $board = new Board(6, 1);
        $board->placeCounter(new Counter('X'), 3);
        $this->assertEquals("|0|1|2|3|4|5|\n|_|_|_|X|_|_|" . PHP_EOL, $this->printer->draw($board));
    }

    public function testPrintColumn() {
        $board = new Board(1, 5);
        $this->assertEquals("|0|\n|_|\n|_|\n|_|\n|_|\n|_|" . PHP_EOL, $this->printer->draw($board));
    }

    public function testPrintSmallBoard() {
        $board = new Board(2, 2);        
        $board->placeCounter(new Counter('X'), 1);        
        $board->placeCounter(new Counter('O'), 1);
        $this->assertEquals("|0|1|\n|_|O|\n|_|X|" . PHP_EOL, $this->printer->draw($board));
    }
}
?>
