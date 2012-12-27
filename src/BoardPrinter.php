<?php

require_once "Board.php";

class BoardPrinter {
	
	protected $board;
	
	protected $verticalDivider = '|';
	protected $emptySpace = '_';
	
	public function __construct(Board $board){
		$this->board = $board;	
	}
	
	public function draw(){
		$output = '';
		for($col = 0; $col < $this->board->getWidth(); $col++){
			$pos = new Position($col, 0);
			$output .= $this->drawCell($pos);			
		}
		$output .= $this->verticalDivider;
		return $output;		
	}
	
	protected function drawCell($pos){
		$cell = '';
		if( $this->board->positionIsEmpty($pos) ){
			$cell .= $this->verticalDivider . $this->emptySpace;	
		}else{
			$counter = $this->board->getCell($pos);
			$cell .= $this->verticalDivider . $counter->char;			
		}
		return $cell;
	}
}

?>