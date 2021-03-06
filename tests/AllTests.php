<?php

require_once 'BoardTest.php';
require_once 'PlayerTest.php';
require_once 'GameTest.php';
require_once 'SimpleBoardPrinterTest.php';
require_once 'WinCheckerTest.php';
require_once 'CliReaderTest.php';
require_once 'CounterTest.php';
require_once 'PositionTest.php';

class AllTests {
	public static function suite() {		
		$suite = new PHPUnit_Framework_TestSuite('PHPUnit');		
		$suite->addTestSuite('PlayerTest');		
		$suite->addTestSuite('PositionTest');
		$suite->addTestSuite('CounterTest');		
		$suite->addTestSuite('CliReaderTest');
		$suite->addTestSuite('BoardTest');
		$suite->addTestSuite('SimpleBoardPrinterTest');
		$suite->addTestSuite('WinCheckerTest');
		$suite->addTestSuite('GameTest');
		return $suite;
	}

}
?>