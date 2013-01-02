<?php

require_once dirname(dirname(__FILE__)) . "/src/CounterFactory.php";
require_once dirname(dirname(__FILE__)) . "/src/Counter.php";

class ConterFactoryTest extends PHPUnit_Framework_TestCase {
    
    protected $factory;
    protected $chars = array('X', 'O');
    
    protected function setup(){
        $this->factory = new CounterFactory( array($this->chars[0], $this->chars[1]));
    }

    public function testReturnCounter() {
        $counter1 = $this->factory->getCounterForPlayer(1);
        $this->assertEquals($this->chars[0], $counter1->char);
        $counter2 = $this->factory->getCounterForPlayer(2);
        $this->assertEquals($this->chars[1], $counter2->char);
    }

    public function testReturnsSameCounter() {
        $this->assertTrue($this->factory->getCounterForPlayer(1) === $this->factory->getCounterForPlayer(1));
        $this->assertTrue($this->factory->getCounterForPlayer(2) === $this->factory->getCounterForPlayer(2));
    }
    
        /**
     * @expectedException NoCounterException
     */
     public function testInvalidCounterThrowsException(){
         $this->factory->getCounterForPlayer(0);
     }
}
?>
