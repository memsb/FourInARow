<?php

require_once dirname(dirname(__FILE__)) . "/src/Position.php";

class PositionTest extends PHPUnit_Framework_TestCase {

	protected $position;
	protected $col = 10;
	protected $row = 1;

	protected function setup() {
		$this->position = new Position($this->col, $this->row);
	}

	public function testPositionAttributeAssignment() {
		$this->assertEquals($this->col, $this->position->col);
		$this->assertEquals($this->row, $this->position->row);
		
		$newCol = 99;
		$newRow = 49;
		$this->position->col = $newCol;
		$this->position->row = $newRow;
		$this->assertEquals($newCol, $this->position->col);
		$this->assertEquals($newRow, $this->position->row);
	}

	public function testPositionEquality() {
		$this->assertTrue($this->position->equals($this->position));
		$similarPosition = new Position($this->col, $this->row);
		$this->assertTrue($similarPosition->equals($this->position));
		$dissimilarPosition = new Position(0, 0);
		$this->assertFalse($dissimilarPosition->equals($this->position));
	}

}
?>