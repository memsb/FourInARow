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
	
	public function __construct(Board $board, WinChecker $winChecker) {
		$this->board = $board;
		$this->winChecker = $winChecker;
		$this->currentPlayerNumber = 0;
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
	
	public function getMessage(){
		return $this->message;
	}	
	
	public function notify($data){		
		$this->move($data);		
	}
	
	public function start(){
		$this->notifyObservers($this);
	}
	
	public function move($col) {
		try{
			$this->board->placeCounter($this->getPlayersCounter(), $col);			
			$this->checkBoardState();
			$this->changePlayer();
			$this->message = '';
			$this->notifyObservers($this);
		}catch(GameFinishedException $e){
			$this->message = $e->getMessage();
			$this->notifyObservers($this);
			throw new GameOverException("The game has ended.");
		}catch(GameplayException $e){
			$this->message = $e->getMessage();
			$this->notifyObservers($this);
		}
	}
	
	protected function getPlayersCounter(){
		$currentPlayer = $this->getCurrentPlayer();
		return $currentPlayer->getCounter();
	}
	
	protected function checkBoardState(){
		$lastPosition = $this->board->getLastPosition();
		if( $this->winChecker->hasWin($lastPosition) ){
			$winner = $this->getCurrentPlayer();
			$winnersName = $winner->getName();
			throw new GameWonException("{$winnersName} Wins!");
		}
		if( $this->board->isFull() ){
			throw new GameDrawnException("It's a draw!");
		}
	}

	protected function changePlayer() {
		if (++$this->currentPlayerNumber >= count($this->players)) {
			$this->currentPlayerNumber = 0;
		}
	}

}
?>