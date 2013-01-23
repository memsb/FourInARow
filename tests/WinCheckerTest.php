<?php

require_once dirname(dirname(__FILE__)) . "/src/Counter.php";
require_once dirname(dirname(__FILE__)) . "/src/WinChecker.php";

class WinCheckerTest extends PHPUnit_Framework_TestCase {

	protected $board;
	protected $checker;

	protected function setup() {
		$this->board = new Board(6, 5);
		$this->checker = new WinChecker($this->board, 4);
	}

	public function testWinningColumn() {
		$col = 0;
		$counter = new Counter('X');
		$this->board->placeCounter($counter, $col);
		$this->board->placeCounter($counter, $col);
		$this->board->placeCounter($counter, $col);
		$this->assertFalse($this->checker->hasWinInColumn($col));
		$this->board = $this->fillColumn($col, $this->board, $counter);
		$this->assertTrue($this->checker->hasWinInColumn($col));
	}

	public function testWinningRow() {
		$counter = new Counter('X');
		$this->board->placeCounter($counter, 0);
		$this->board->placeCounter($counter, 1);
		$this->board->placeCounter($counter, 2);
		$this->assertFalse($this->checker->hasWinInRow(0));
		$this->board = $this->PlaceCounterInEachColumn($this->board, $counter);
		$this->assertTrue($this->checker->hasWinInRow(0));
	}

	public function testWinningDiagonal() {
		$pos = new Position(2, 2);
		$this->assertFalse($this->checker->hasWinInDiagonal($pos));
		$this->board = $this->fillBoard($this->board, new Counter('X'));
		$this->assertTrue($this->checker->hasWinInDiagonal($pos));
	}

	public function testHasWin() {
		$pos = new Position(0, 0);
		$this->winningColumn($pos);
		$this->winningRow($pos);
		$this->winningDiagonal($pos);
	}

	protected function winningColumn($pos) {
		$board = new Board(6, 5);
		$checker = new WinChecker($board, 4);
		$this->assertFalse($checker->hasWin($pos));
		$this->fillColumn($pos->col, $board, new Counter('X'));
		$this->assertTrue($checker->hasWin($pos));
	}

	protected function winningRow($pos) {
		$board = new Board(6, 5);
		$checker = new WinChecker($board, 4);
		$this->assertFalse($checker->hasWin($pos));
		$this->PlaceCounterInEachColumn($board, new Counter('X'));
		$this->assertTrue($checker->hasWin($pos));
	}

	protected function winningDiagonal($pos) {
		$o = new Counter('O');
		$x = new Counter('X');
		$board = new Board(6, 5);
		
		$checker = new WinChecker($board, 4);		
		$this->assertFalse($checker->hasWin($pos));
		
		$board->placeCounter($x, 0);
		
		$board->placeCounter($o, 1);
		$board->placeCounter($x, 1);
		
		$board->placeCounter($o, 2);
		$board->placeCounter($o, 2);
		$board->placeCounter($x, 2);
		
		$board->placeCounter($o, 3);
		$board->placeCounter($o, 3);
		$board->placeCounter($o, 3);
		$board->placeCounter($x, 3);
		
		$this->assertTrue($checker->hasWin($pos));
	}

	protected function PlaceCounterInEachColumn(Board $board, Counter $counter) {
		foreach ($board->getColumnsFromLeftToRight() as $col) {
			$board->placeCounter($counter, $col);
		}
		return $board;
	}

	protected function fillColumn($col, Board $board, Counter $counter) {
		foreach ($board->getRowsFromTopDown() as $row) {
			$board->placeCounter($counter, $col);
		}
		return $board;
	}

	protected function fillBoard(Board $board, Counter $counter) {
		foreach ($board->getColumnsFromLeftToRight() as $col) {
			$this->fillColumn($col, $board, $counter);
		}
		return $board;
	}

}
?>

?>
