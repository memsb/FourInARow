<?php

require_once 'Position.php';
require_once 'Board.php';

class WinChecker {
	
	private $inARow = 0;
	private $board;

	function __construct(Board $board, $inARow = 4) {
		$this->board = $board;
		$this->inARow = $inARow;
	}	
	
	public function hasWin(Position $pos){
		return $this->hasWinInColumn($pos->col) OR $this->hasWinInRow($pos->row) OR $this->hasWinInDiagonal($pos);
	}
	
	public function hasWinInColumn($col){
		$cells = array();
		foreach(range(0, $this->board->getHeight()) as $row){
			$pos = new Position($col, $row);
			$cells[] = $this->board->getCell($pos);
		}
		return $this->checkPositionsForWin($cells);
	}
	
	public function hasWinInRow($row){
		$cells = array();
		foreach(range(0, $this->board->getWidth()) as $col){
			$pos = new Position($col, $row);
			$cells[] = $this->board->getCell($pos);
		}
		return $this->checkPositionsForWin($cells);
	}
	
	public function hasWinInDiagonal($pos){
		$diag1 = $this->getDiagonalDownRight($pos, 'up');
		$diag2 = $this->getDiagonalDownLeft($pos, 'down');
		return $this->checkPositionsForWin($diag1) OR $this->checkPositionsForWin($diag2);
	}
	
	protected function getDiagonalDownRight($pos){
		$currentPos = $this->getMostUpperLeft($pos);		
		$cells = array();
		while($currentPos->row > 0 && $currentPos->col < $this->board->getWidth()){
			$currentPos->row--;
			$currentPos->col++;
			$cells[] = $this->board->getCell($currentPos);
		}
		return $cells;
	}
	
	protected function getMostUpperLeft($pos){
		$col = $pos->col;
		$row = $pos->row;
		while($row < $this->board->getHeight() && $col > 0){
			$row++;
			$col--;	
		}
		return new Position($col, $row);
	}
	
	protected function getDiagonalDownLeft($pos){		
		$currentPos = $this->getMostUpperRight($pos);		
		$cells = array();
		while($currentPos->row > 0 && $currentPos->col > 0){
			$currentPos->row--;
			$currentPos->col--;
			$cells[] = $this->board->getCell($currentPos);
		}
		return $cells;
	}
	
	protected function getMostUpperRight($pos){
		$col = $pos->col;
		$row = $pos->row;
		while($row < $this->board->getHeight() && $col < $this->board->getWidth()){
			$row++;
			$col++;	
		}
		return new Position($col, $row);
	}
	
	public function checkPositionsForWin($cells){
		$last = null;
		$found = 0;
		foreach($cells as $current){
			if( $this->board->isCellEmpty($current) ){
				$last = null;
				$found = 0;
			}else{			
				if( $last !== null && $current->equals($last) ){
					$found++;
					if( $found >= $this->inARow ){
						return True;
					}					
				}else{
					$last = $current;
					$found = 1;
				}
			}
		}
		return False;
	}

}

?>