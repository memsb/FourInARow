<?php

require_once dirname(dirname(__FILE__)) . "/src/Game.php";
require_once dirname(dirname(__FILE__)) . "/src/Board.php";
require_once dirname(dirname(__FILE__)) . "/src/WinChecker.php";
require_once dirname(dirname(__FILE__)) . "/src/SimpleBoardPrinter.php";

class GameTest extends PHPUnit_Framework_TestCase {
    
    const cols = 2;
    const rows = 2;
    const inARow = 2;
    const players = 2;
    
    protected $game;
    protected $board;
    
    protected function setup(){
        $this->board = new Board(self::cols, self::rows);
        $checker = new WinChecker($this->board, self::inARow);
        $printer = new SimpleBoardPrinter($this->board);
        $this->game = new Game($this->board, $checker, $printer, self::players);
    }
	
	public function testFirstPlayer() {
        $this->assertEquals(1, $this->game->getCurrentPlayer());
	}

    public function testMakingAMoveChangesPlayer() {
        $this->assertEquals(1, $this->game->getCurrentPlayer());
        $this->game->move(0);        
        $this->assertEquals(2, $this->game->getCurrentPlayer());
        $this->game->move(0);        
        $this->assertEquals(1, $this->game->getCurrentPlayer());
    }
    
    /**
     * @expectedException InvalidPositionException
     */
    public function testIllegalMoveDoesntChangePlayer(){        
        $this->assertEquals(1, $this->game->getCurrentPlayer());
        $this->game->move(-1);        
        $this->assertEquals(1, $this->game->getCurrentPlayer());
    }
    
    public function testSimpleGameScenario(){
        $printer = new SimpleBoardPrinter($this->board);
        echo $printer->draw();
        $this->game->move(0); 
        echo $printer->draw();
        $this->game->move(1); 
        echo $printer->draw();
        $this->game->move(1); 
        echo $printer->draw();
        $this->game->move(0); 
    }
    
}
?>