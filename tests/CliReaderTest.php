<?php

require_once dirname(dirname(__FILE__)) . "/src/CliReader.php";

class CliReaderTest extends PHPUnit_Framework_TestCase {

	protected $reader;
	protected $observer;

	protected function setup() {
		$this->reader = $this->getMock('CliReader', array('readFromCli'));
		$this->observer = $this->getMock('Observer', array('notify'));
	}
	
	/**
     * @dataProvider formattedValues
     */
	public function testObserversAreNotifiedOnRead($raw, $formatted){		
		$this->reader->expects($this->any())
                 ->method('readFromCli')
				 ->will($this->returnValue($raw));
				 
        $this->observer->expects($this->once())
                 ->method('notify')
                 ->with($this->equalTo($formatted)); 
				 
		$this->expectOutputString("Player 1s move: \n");
		$this->reader->addObserver($this->observer);
		$this->reader->read('Player 1');
	}
	
	public function testObserversArentNotifiedOnInvalidInput(){
		$this->reader->expects($this->once())
                 ->method('readFromCli')
				 ->will($this->returnValue(''));
				 
        $this->observer->expects($this->never())
                 ->method('notify'); 
				 
		$this->expectOutputString("Player 1s move: \n");
		$this->reader->addObserver($this->observer);
		$this->reader->read('Player 1');
	}
	
	/**
	 * @expectedException ExitSignalException
	 */
	public function testExitCharacterDoesntNotify(){
		$exitChar = 'x';
		$this->reader->expects($this->any())
                 ->method('readFromCli')
				 ->will($this->returnValue($exitChar));
				 
        $this->observer->expects($this->never())
                 ->method('notify'); 
				 
		$this->expectOutputString("Player 1s move: \n");
		$this->reader->addObserver($this->observer);
		$this->reader->setExitCharacter($exitChar);
		$this->reader->read('Player 1');
	}
	
	/**
     * @dataProvider formattedValues
     */
	public function testIntergerFormatting($raw, $formatted){
		$this->assertEquals($formatted, $this->reader->formatAsInt($raw));
	}

	public function formattedValues(){
		return array(
				array(0, 0),
				array(1, 1),
				array('0', 0),
				array(-123, -123),
				array('1abc', 1),
				array('abc', 0)
			);
	}	
	
	public function testInputPrompt(){
		$this->assertEquals("Player 1s move: ", $this->reader->prompt('Player 1'));
	}
	
}
?>