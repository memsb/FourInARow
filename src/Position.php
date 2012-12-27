<?php

class Position {
	
	public $col;
	public $row;
	
	public function __construct($col, $row){
		$this->col = $col;
		$this->row = $row;
	}
	
	public function equals(Position $p){
		return $p->col == $this->col && $p->row == $this->row;
	}
}

?>