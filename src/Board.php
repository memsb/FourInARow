<?php

require_once "Position.php";
require_once "Exceptions.php";

class Board {

	private $cols = 0;
	private $rows = 0;
	private $cells;
	private $lastPosition;

	function __construct($cols, $rows) {
		$this->checkBoardSizeIsValid($cols, $rows);
		$this->cols = $cols;
		$this->rows = $rows;
	}
	
	protected function checkBoardSizeIsValid($cols, $rows){
		if ($cols < 1 || $rows < 1) {
			throw new InvalidBoardSizeException('Board width or height cannot be zero or less');
		}
	}
	
	public function getLastPosition(){
		return $this->lastPosition;
	}

	public function positionIsEmpty($pos) {
		return $this->isCellEmpty($this->getCell($pos));
	}

	public function isCellEmpty($cell) {
		return empty($cell);
	}

	public function getCell($pos) {
		if(isset($this->cells[$pos->col][$pos->row])){
			return $this->cells[$pos->col][$pos->row];
		}
		return null;
	}

	public function isFull() {
		foreach (range(0, $this->getRightColumn()) AS $col) {
			if ($this->columnIsNotFull($col)) {
				return False;
			}
		}
		return True;
	}

	protected function columnIsNotFull($col) {
		return $this->positionIsEmpty(new Position($col, $this->getTopRow()));
	}

	public function columnIsFull($col) {
		return !$this->columnIsNotFull($col);
	}

	public function placeCounter($counter, $col) {
		if ($this->isInvalidPosition($col)) {
			throw new InvalidPositionException("{$col} is outside of acceptable position range {$this->getLeftColumn()} to {$this->getRightColumn()}");
		}
		if($this->columnIsFull($col)){
			throw new InvalidPositionException("{$col} is full, please try another position.");
		}
		foreach ($this->getRowsFromBottomUp() AS $row) {
			$pos = new Position($col, $row);
			if ($this->positionIsEmpty($pos)) {
				$this->cells[$pos->col][$pos->row] = $counter;
				$this->lastPosition = $pos;
				break;
			}
		}
	}

	public function getRowsFromTopDown() {
		return range($this->getTopRow(), $this->getBottomRow());
	}

	public function getRowsFromBottomUp() {
		return range($this->getBottomRow(), $this->getTopRow());
	}

	public function getColumnsFromLeftToRight() {
		return range($this->getLeftColumn(), $this->getRightColumn());
	}

	public function getColumnsFromRightToLeft() {
		return range($this->getRightColumn(), $this->getLeftColumn());
	}
	
	public function getWidth() {
		return $this->cols;
	}

	public function getLeftColumn() {
		return 0;
	}

	public function getRightColumn() {
		return $this->cols - 1;
	}

	public function getHeight() {
		return $this->rows;
	}

	public function getTopRow() {
		return $this->rows - 1;
	}

	public function getBottomRow() {
		return 0;
	}

	protected function isInvalidPosition($col) {
		return !$this->isValidPosition($col);
	}

	protected function isValidPosition($col) {
		return $col >= $this->getLeftColumn() && $col <= $this->getRightColumn();
	}

}
?>
