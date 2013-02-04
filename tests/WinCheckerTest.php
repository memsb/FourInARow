<?php

require_once dirname(dirname(__FILE__)) . "/src/Counter.php";
require_once dirname(dirname(__FILE__)) . "/src/WinChecker.php";

class WinCheckerTest extends PHPUnit_Framework_TestCase {

	protected $cols = 6;
	protected $rows = 5;
	protected $inARow = 4;
	protected $checker;
	
	protected function setup(){
		$this->checker = new WinChecker($this->inARow);
	}

	public function testWinningColumn() {
		$this->assertTrue($this->checker->hasWinInColumn($this->getMockBoardWithCounters(4, $this->getMockEqualCounter()), 0));
	}
	/*
	public function testNonWinningcolumn(){
		$this->assertFalse($this->checker->hasWinInColumn($this->getMockBoardWithCounters(0, $this->getMockEqualCounter()), 0));
		$this->assertFalse($this->checker->hasWinInColumn($this->getMockBoardWithCounters(3, $this->getMockEqualCounter()), 0));
		$this->assertFalse($this->checker->hasWinInColumn($this->getMockBoardWithCounters(5, $this->getMockUnequalCounter()), 0));
	}
	
	public function testWinningRow() {
		$this->assertTrue($this->checker->hasWinInRow($this->getMockBoardWithCounters(4, $this->getMockEqualCounter()), 0));
	}
	
	public function testNonWinningRow(){
		$this->assertFalse($this->checker->hasWinInRow($this->getMockBoardWithCounters(0, $this->getMockEqualCounter()), 0));
		$this->assertFalse($this->checker->hasWinInRow($this->getMockBoardWithCounters(3, $this->getMockEqualCounter()), 0));
		$this->assertFalse($this->checker->hasWinInRow($this->getMockBoardWithCounters(5, $this->getMockUnequalCounter()), 0));
	}
	
	public function testWinningDiagonal() {
		$pos = new Position(3, 4);
		$board = $this->getMockBoardWithCounters(4, $this->getMockEqualCounter());
		$this->assertTrue($this->checker->hasWinInDiagonal($board, $pos));
	}
	
	/**
	public function testNonWinningDiagonal() {
		$pos = new Position(0, 0);
		$this->assertFalse($this->checker->hasWinInDiagonal($this->getMockBoardWithCounters(0, $this->getMockEqualCounter()), $pos));
		$this->assertFalse($this->checker->hasWinInDiagonal($this->getMockBoardWithCounters(3, $this->getMockEqualCounter()), $pos));
		$this->assertFalse($this->checker->hasWinInDiagonal($this->getMockBoardWithCounters(4, $this->getMockUnequalCounter()), $pos));
	}
	
	public function testWinningCheckForAnyTypeOfWin() {
		$pos = new Position(0, 0);
		$this->assertFalse($this->checker->hasWin($this->getMockBoardWithCounters(0, $this->getMockEqualCounter()), $pos));
		$this->assertFalse($this->checker->hasWin($this->getMockBoardWithCounters(3, $this->getMockEqualCounter()), $pos));
		$this->assertFalse($this->checker->hasWin($this->getMockBoardWithCounters(4, $this->getMockUnequalCounter()), $pos));
	}
	
	public function testNonWinningCheckForAnyTypeOfWin() {
		$pos = new Position(0, 0);
		$this->assertFalse($this->checker->hasWin($this->getMockBoardWithCounters(0, $this->getMockEqualCounter()), $pos));
		$this->assertFalse($this->checker->hasWin($this->getMockBoardWithCounters(3, $this->getMockEqualCounter()), $pos));
		$this->assertFalse($this->checker->hasWin($this->getMockBoardWithCounters(4, $this->getMockUnequalCounter()), $pos));
	}
		 * 
	 */
	protected function getMockBoardWithCounters($numOfCounters, $counter){
		$board = $this->getMock('Board', array('getCell', 'getWidth', 'getHeight'), array($this->cols, $this->rows));
		$board->expects($this->any())
				->method('getWidth')
				->will($this->returnValue($this->cols));
		$board->expects($this->any())
				->method('getHeight')
				->will($this->returnValue($this->rows));
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
