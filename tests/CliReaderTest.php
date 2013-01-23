<?php

require_once dirname(dirname(__FILE__)) . "/src/CliReader.php";

class CliReaderTest extends PHPUnit_Framework_TestCase {

	protected $reader;

	protected function setup() {
		$this->reader = new CliReader();
	}
	
	public function testObserversAreNotifiedOnRead(){		
		$data = 1;		
		$observer = $this->getMock('Observer', array('notify'));		
        $observer->expects($this->once())
                 ->method('notify')
                 ->with($this->equalTo($data)); 
				 
		$this->reader->addObserver($observer);
		$this->reader->notifyObservers($data);
	}
	
	public function testIntergerFormatting(){
		$this->assertEquals(0, $this->reader->formatAsInt(0));		
		$this->assertEquals(1, $this->reader->formatAsInt(1));		
		$this->assertEquals(0, $this->reader->formatAsInt('0'));		
		$this->assertEquals(-123, $this->reader->formatAsInt(-123));		
		$this->assertEquals(1, $this->reader->formatAsInt('1abc'));		
		$this->assertEquals(0, $this->reader->formatAsInt('abc'));
	}
	
	public function testInputPrompt(){
		$this->assertEquals("Player freds move: ", $this->reader->prompt('fred'));
		$this->assertEquals("Player 1s move: ", $this->reader->prompt(1));
		$this->assertEquals("Player 2s move: ", $this->reader->prompt(2));
	}
}
?>