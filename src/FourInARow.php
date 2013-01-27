<?php
require_once "Game.php";
require_once "Player.php";
require_once "Board.php";
require_once "WinChecker.php";
require_once "SimpleBoardPrinter.php";
require_once "CliReader.php";

class FourInARow {
	
	protected $cols = 6;
	protected $rows = 5;
	protected $inARow = 4;
	
	protected $board;
	protected $checker;
	protected $printer;
	protected $inputReader;	
	
	function __construct(){
		$board = new Board($this->cols, $this->rows);
		$checker = new WinChecker($board, $this->inARow);
		
		$this->game = new Game($board, $checker);
		$this->game->addPlayer(new Player('Dave', new Counter('X')));
		$this->game->addPlayer(new Player('Mike', new Counter('O')));
		$this->game->addObserver(new SimpleBoardPrinter());
		
		$this->inputReader = new CliReader();
		$this->inputReader->addObserver($this->game);
	}
	
	public function play(){
		$this->game->start();
		$this->gameLoop();		
	}
	
	protected function gameLoop(){
		try{
			while( true ){
				$player = $this->game->getCurrentPlayer();
				$this->inputReader->read($player->getName());
			}
		}catch(ExitSignalException $e){
			echo $e->getMessage() . PHP_EOL;
		}catch(GameOverException $e){
		}
	}
}

$fourInARow = new FourInARow();
$fourInARow->play();

?>