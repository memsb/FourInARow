<?php
require_once "Player.php";
require_once "Board.php";
require_once "WinChecker.php";
require_once "Observer.php";
require_once "Observable.php";

class Game implements Observer, Observable {

	protected $currentPlayerNumber;
	protected $player;
	protected $board;
	protected $winChecker;
	protected $observers = array();	
	protected $message = '';
	protected $hasWinner = False;
	
	public function __construct(Board $board, WinChecker $winChecker) {
		$this->board = $board;
		$this->winChecker = $winChecker;
		$this->currentPlayerNumber = 0;
		$this->hasWinner = False;
	}
	
	public function addObserver(Observer $observer){
		$this->observers[] = $observer;
	}
	
	public function notifyObservers($data){
		foreach($this->observers as $observer){
			$observer->notify($data);
		}
	}
	
	public function addPlayer(Player $player){
		$this->players[] = $player;
	}
		
	public function getCurrentPlayer() {
		return $this->players[$this->currentPlayerNumber];
	}
	
	public function getBoard(){
		return $this->board;
	}
	
	public function hasWinner(){
		return $this->hasWinner;
	}
	
	public function getMessage(){
		return $this->message;
	}	
	
	public function notify($data){		
		$this->move($data);		
		$this->notifyObservers($this);
	}
	
	public function start(){
		$this->notifyObservers($this);
	}
	
	public function move($col) {
		try{
			$currentPlayer = $this->getCurrentPlayer();
			$counter = $currentPlayer->getCounter();
			$this->board->placeCounter($counter, $col);
			
			$lastPosition = $this->board->getLastPosition();
			if($this->winChecker->hasWin($lastPosition)){ //overflow of column, full board
				$this->hasWinner = True;
				throw new FourInARowException("Player {$this->currentPlayer} Wins!");
			}
			$this->changePlayer();
		}catch(FourInARowException $e){
			$this->message = $e->getMessage();
		}
	}

	public function changePlayer() {
		if (++$this->currentPlayerNumber >= count($this->players)) {
			$this->currentPlayerNumber = 0;
		}
	}

}
?>