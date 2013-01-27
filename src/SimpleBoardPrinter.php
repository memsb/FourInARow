<?php

require_once "Board.php";
require_once "BoardPrinter.php";

class SimpleBoardPrinter implements BoardPrinter {

    protected $board;

    protected $verticalDivider = '|';
    protected $emptySpace = '_';
	
	public function notify($game){
		$this->board = $game->getBoard();
		echo $this->draw();
		echo $game->getMessage() . PHP_EOL;
	}
	
    public function draw() {    	
        $output = $this->drawTopRow();
        foreach($this->board->getRowsFromTopDown() AS $row) {
            $output .= $this->drawRow($row);
        }
        return $output;
    }
	
	protected function drawTopRow(){
		$output = '';
		foreach ($this->board->getColumnsFromLeftToRight() AS $col) {
			$label = $col;
			if( $this->board->columnIsFull($col)){
				$label = ' ';
			}
			$output .= $this->drawPositionIndicator($label);			
		}		
        $output .= $this->verticalDivider . PHP_EOL;
		return $output;
	}
	
	protected function drawPositionIndicator($label){
		return $this->verticalDivider . $label;
	}

    protected function drawRow($row) {
        $output = '';
        foreach ($this->board->getColumnsFromLeftToRight() AS $col) {
            $pos = new Position($col, $row);
            $output .= $this->drawCell($pos);
        }
        $output .= $this->verticalDivider . PHP_EOL;
        return $output;
    }

    protected function drawCell($pos) {
        $cell = '';
        if ($this->board->positionIsEmpty($pos)) {
            $cell .= $this->verticalDivider . $this->emptySpace;
        } else {
            $counter = $this->board->getCell($pos);
            $cell .= $this->verticalDivider . $counter->char;
        }
        return $cell;
    }

}
?>