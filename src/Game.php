<?php

require_once "CounterFactory.php";
require_once "Board.php";
require_once "WinChecker.php";

class Game {

    protected $currentPlayer;

    protected $board;
    protected $winChecker;
    protected $numberOfPlayers;

    public function __construct(Board $board, WinChecker $winChecker, $numberOfPlayers = 2) {
        $this->board = $board;
        $this->winChecker = $winChecker;
        $this->numberOfPlayers = $numberOfPlayers;
        $this->currentPlayer = 1;
    }

    public function getCurrentPlayer() {
        return $this->currentPlayer;
    }

    public function move($col) {
        $this->board->placeCounter(new Counter('X'), $col);
        $this->changePlayer();
    }

    public function changePlayer() {
        if ($this->currentPlayer++ >= $this->numberOfPlayers) {
            $this->currentPlayer = 1;
        }
    }

}
?>