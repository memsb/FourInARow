<?php

require_once 'GameTest.php';
require_once 'BoardTest.php';

class AllTests {
	public static function suite() {
		$suite = new PHPUnit_Framework_TestSuite('PHPUnit');

		$suite->addTestSuite('ArrayTwoTest');
		$suite->addTestSuite('ArrayTest');
		return $suite;
	}

}
?>