<?php

require_once 'BoardTest.php';
require_once 'PlayerTest.php';
require_once 'GameTest.php';
require_once 'SimpleBoardPrinterTest.php';
require_once 'WinCheckerTest.php';
require_once 'CliReaderTest.php';

class AllTests {
	public static function suite() {		
		$suite = new PHPUnit_Framework_TestSuite('PHPUnit');

		$suite->addTestSuite('BoardTest');
		$suite->addTestSuite('PlayerTest');
		//$suite->addTestSuite('GameTest');
		$suite->addTestSuite('SimpleBoardPrinterTest');
		$suite->addTestSuite('WinCheckerTest');
		$suite->addTestSuite('CliReaderTest');
		return $suite;
	}

}
?>