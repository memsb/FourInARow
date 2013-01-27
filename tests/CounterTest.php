<?php

require_once dirname(dirname(__FILE__)) . "/src/Counter.php";

class CounterTest extends PHPUnit_Framework_TestCase  {
	public function testCounterEquality() {
		$c = new Counter('X');
		$this->assertTrue($c->equals($c));
		$this->assertTrue($c->equals(new Counter('X')));
		$this->assertFalse($c->equals(new Counter('O')));
		$c = new Counter('');
		$this->assertFalse($c->equals(new Counter(0)));
	}
	
	/**
	 * @dataProvider counterValues
	 */
	public function testCounterValues($value) {
		$c = new Counter($value);
		$this->assertEquals($value, $c->char);
	}
	
	public function counterValues(){
		return array(
			array('X'),
			array('x'),
			array('O'),
			array('XOX'),
			array(''),
			array(7),			
			array(null)
		);
	}
}
?>