<?php

require_once dirname(dirname(__FILE__)) . "/src/Board.php";
require_once dirname(dirname(__FILE__)) . "/src/Counter.php";
require_once dirname(dirname(__FILE__)) . "/src/WinChecker.php";
require_once dirname(dirname(__FILE__)) . "/src/Position.php";

class BoardTest extends PHPUnit_Framework_TestCase {	
	
	protected $board;
	protected $checker;
	
	protected function setup(){
		$this->board = new Board(6, 5);
		$this->checker = new WinChecker($this->board, 4);
	}
	
	public function testWinningColumn(){			
		$this->board->placeCounter(new Counter('X'), 0);
		$this->board->placeCounter(new Counter('X'), 0);
		$this->board->placeCounter(new Counter('X'), 0);
		$this->assertFalse($this->checker->hasWinInColumn(0));	
		$this->board->placeCounter(new Counter('X'), 0);		
		$this->assertTrue($this->checker->hasWinInColumn(0));
	}	
	
	public function testWinningRow(){			
		$this->board->placeCounter(new Counter('X'), 0);
		$this->board->placeCounter(new Counter('X'), 1);
		$this->board->placeCounter(new Counter('X'), 2);
		$this->assertFalse($this->checker->hasWinInRow(0));	
		$this->board->placeCounter(new Counter('X'), 3);		
		$this->assertTrue($this->checker->hasWinInRow(0));
	}		
	
	public function testWinningDiagonal(){
		$pos = new Position(2, 2);
		$this->assertFalse($this->checker->hasWinInDiagonal($pos));
		$this->board = $this->fillBoard($this->board, new Counter('X'));		
		$this->assertTrue($this->checker->hasWinInDiagonal($pos));
	}
	
	protected function fillBoard($board, $counter){
		foreach( range(0, $board->getWidth()-1) as $col ){
			foreach( range(0, $board->getHeight()-1) as $row ){
				$board->placeCounter($counter, $col);
			}
		}
		return $board;
	}
}
?>

?>
