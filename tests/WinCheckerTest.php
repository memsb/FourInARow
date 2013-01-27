<?php

require_once dirname(dirname(__FILE__)) . "/src/Counter.php";
require_once dirname(dirname(__FILE__)) . "/src/WinChecker.php";

class WinCheckerTest extends PHPUnit_Framework_TestCase {

	protected $cols = 6;
	protected $rows = 5;

	public function testWinningColumn() {				
		$checker = new WinChecker($this->getMockBoardWithCounters(4, $this->getMockEqualCounter()), 4);
		$this->assertTrue($checker->hasWinInColumn(0));
	}
	
	public function testNonWinningcolumn(){
		$checker = new WinChecker($this->getMockBoardWithCounters(0, $this->getMockEqualCounter()), 4);
		$this->assertFalse($checker->hasWinInColumn(0));
		$checker = new WinChecker($this->getMockBoardWithCounters(3, $this->getMockEqualCounter()), 4);
		$this->assertFalse($checker->hasWinInColumn(0));
		$checker = new WinChecker($this->getMockBoardWithCounters(5, $this->getMockUnequalCounter()), 4);
		$this->assertFalse($checker->hasWinInColumn(0));
	}
	
	public function testWinningRow() {		
		$checker = new WinChecker($this->getMockBoardWithCounters(4, $this->getMockEqualCounter()), 4);
		$this->assertTrue($checker->hasWinInRow(0));
	}
	
	public function testNonWinningRow(){
		$checker = new WinChecker($this->getMockBoardWithCounters(0, $this->getMockEqualCounter()), 4);
		$this->assertFalse($checker->hasWinInRow(0));
		$checker = new WinChecker($this->getMockBoardWithCounters(3, $this->getMockEqualCounter()), 4);
		$this->assertFalse($checker->hasWinInRow(0));
		$checker = new WinChecker($this->getMockBoardWithCounters(5, $this->getMockUnequalCounter()), 4);
		$this->assertFalse($checker->hasWinInRow(0));
	}
	
	public function testWinningDiagonal() {
		$pos = new Position(0, 0);
		$checker = new WinChecker($this->getMockBoardWithCounters(0, $this->getMockEqualCounter()), 4);
		$this->assertFalse($checker->hasWinInDiagonal($pos));
		$checker = new WinChecker($this->getMockBoardWithCounters(3, $this->getMockEqualCounter()), 4);
		$this->assertFalse($checker->hasWinInDiagonal($pos));
		$checker = new WinChecker($this->getMockBoardWithCounters(4, $this->getMockUnequalCounter()), 4);
		$this->assertFalse($checker->hasWinInDiagonal($pos));
	}
	
	public function testWinningCheckForAnyTypeOfWin() {
		$pos = new Position(0, 0);
		$checker = new WinChecker($this->getMockBoardWithCounters(0, $this->getMockEqualCounter()), 4);
		$this->assertFalse($checker->hasWin($pos));
		$checker = new WinChecker($this->getMockBoardWithCounters(3, $this->getMockEqualCounter()), 4);
		$this->assertFalse($checker->hasWin($pos));
		$checker = new WinChecker($this->getMockBoardWithCounters(4, $this->getMockUnequalCounter()), 4);
		$this->assertFalse($checker->hasWin($pos));
	}
	
	public function testNonWinningCheckForAnyTypeOfWin() {
		$pos = new Position(0, 0);
		$checker = new WinChecker($this->getMockBoardWithCounters(0, $this->getMockEqualCounter()), 4);
		$this->assertFalse($checker->hasWin($pos));
		$checker = new WinChecker($this->getMockBoardWithCounters(3, $this->getMockEqualCounter()), 4);
		$this->assertFalse($checker->hasWin($pos));
		$checker = new WinChecker($this->getMockBoardWithCounters(4, $this->getMockUnequalCounter()), 4);
		$this->assertFalse($checker->hasWin($pos));
	}
	
	public function testHasWin() {
		$pos = new Position(0, 0);
		$checker = new WinChecker($this->getMockBoardWithCounters(4, $this->getMockEqualCounter()), 4);
		$this->assertTrue($checker->hasWin($pos));
	}
	
	protected function getMockBoardWithCounters($numOfCounters, $counter){
		$board = $this->getMock('Board', array('getCell'), array($this->cols, $this->rows));
		for($i = 0; $i < $numOfCounters; $i++){
			$board->expects($this->at($i))
						->method('getCell')
					 	->will($this->returnValue($counter));
		}
		return $board;
	}
	
	protected function getMockEqualCounter(){
		$counter = $this->getMock('Counter', array(), array('X'));
		$counter->expects($this->any())
					->method('equals')
				 	->will($this->returnValue(True));
		return $counter;
	}	
	
	protected function getMockUnequalCounter(){
		$counter = $this->getMock('Counter', array(), array('X'));
		$counter->expects($this->any())
					->method('equals')
				 	->will($this->returnValue(False));
		return $counter;
	}
}

?>
