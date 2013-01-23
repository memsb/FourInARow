<?php

require_once "Board.php";
require_once "BoardPrinter.php";
require_once "Observer.php";

class SimpleBoardPrinter implements BoardPrinter, Observer {

    protected $board;

    protected $verticalDivider = '|';
    protected $emptySpace = '_';

    public function __construct(){
    }
	
	public function notify($game){
		echo $this->draw($game->getBoard());
		echo $game->getMessage() . PHP_EOL;
	}
	
    public function draw(Board $board) {
    	$this->board = $board;
        $output = $this->drawTopRow();
        foreach($this->board->getRowsFromTopDown() AS $row) {
            $output .= $this->drawRow($row);
        }
        return $output;
    }
	
	protected function drawTopRow(){
		$output = '';
		foreach ($this->board->getColumnsFromLeftToRight() AS $col) {
			$output .= $this->drawPositionIndicator($col);
		}		
        $output .= $this->verticalDivider . PHP_EOL;
		return $output;
	}
	
	protected function drawPositionIndicator($num){
		return $this->verticalDivider . $num;
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