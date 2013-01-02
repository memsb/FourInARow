<?php

require_once "Position.php";

class Board {

	private $cols = 0;
	private $rows = 0;
	private $cells;

	function __construct($cols, $rows) {
		$this->cols = $cols;
		$this->rows = $rows;
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

	public function positionIsEmpty($pos) {
		try {
			return $this->isCellEmpty($this->getCell($pos));
		} catch(Exception $e) {
			return true;
		}
	}

	public function isCellEmpty($cell) {
		return empty($cell);
	}

	public function getCell($pos) {
		return $this->cells[$pos->col][$pos->row];
	}

	public function columnIsFull($col) {
		for ($row = 0; $row < $this->rows; $row++) {
			if ($this->positionIsEmpty(new Position($col, $row))) {
				return false;
			}
		}
		return true;
	}

	public function placeCounter($counter, $col) {
		if ($this->isInvalidPosition($col)) {
			throw new InvalidPositionException("{$col} is outside of acceptable position range 0 to {$this->cols}");
		}
		for ($row = 0; $row < $this->rows; $row++) {
			$pos = new Position($col, $row);
			if ($this->positionIsEmpty($pos)) {
				$this->cells[$pos->col][$pos->row] = $counter;
				return;
			}
		}
	}

	protected function isInvalidPosition($col) {
		return ! $this->isValidPosition($col);
	}

	protected function isValidPosition($col) {
		return $col >= 0 && $col < $this->cols;
	}

}
?>
