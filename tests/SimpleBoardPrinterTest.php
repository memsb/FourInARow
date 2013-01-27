<?php

require_once dirname(dirname(__FILE__)) . "/src/SimpleBoardPrinter.php";
require_once dirname(dirname(__FILE__)) . "/src/Game.php";
require_once dirname(dirname(__FILE__)) . "/src/Counter.php";

class SimpleBoardPrinterTest extends PHPUnit_Framework_TestCase {
	
	protected $printer;
	
	protected function setup(){		
		$this->printer = new SimpleBoardPrinter();
	}	

    public function testPrintEmptySingleCellBoard() {
    	$game = $this->getGameWithEmptyBoard(1, 1);
    	$this->expectOutputString("|0|\n|_|\n\n");
        $this->printer->notify($game);
    }

    public function testPrintFullSingleCellBoard() {
    	$game = $this->getGameWithFullBoard(1, 1);
    	$this->expectOutputString("| |\n|X|\n\n");
        $this->printer->notify($game);
    }
	
	public function testPrintEmptyBoard() {
    	$game = $this->getGameWithEmptyBoard(3, 2);
    	$this->expectOutputString("|0|1|2|\n|_|_|_|\n|_|_|_|\n\n");
        $this->printer->notify($game);
    }
	
	public function testPrintFullBoard() {
    	$game = $this->getGameWithFullBoard(3, 2);
    	$this->expectOutputString("| | | |\n|X|X|X|\n|X|X|X|\n\n");
        $this->printer->notify($game);
    }
	
	public function testInfoMessage(){
		$game = $this->getGameWithEmptyBoard(1, 1, 'test');
    	$this->expectOutputString("|0|\n|_|\ntest\n");
        $this->printer->notify($game);
	}
	
	protected function getGameWithEmptyBoard($cols, $rows, $msg = ''){		
		$board = $this->getMock('Board', array('getCell'), array($cols, $rows));		
		return $this->getGame($board, $msg);
	}	
		
	protected function getGameWithFullBoard($cols, $rows, $msg = ''){
		$counter = $this->getMock('Counter', array(), array('X'));		
		$board = $this->getMock('Board', array('getCell', 'getMessage'), array($cols, $rows));
		$board->expects($this->any())
					->method('getCell')
				 	->will($this->returnValue($counter));		
		return $this->getGame($board, $msg);
	}
	
	protected function getGame($board, $msg = ''){		
		$winChecker = $this->getMock('WinChecker', array(), array($board));		
		$game = $this->getMock('Game', array('getBoard', 'getMessage'), array($board, $winChecker));
				 
		$game->expects($this->once())
                 	->method('getBoard')					
				 	->will($this->returnValue($board));
					 
		$game->expects($this->any())
                 	->method('getMessage')					
				 	->will($this->returnValue($msg)); 
		return $game;
	}
}
?>
