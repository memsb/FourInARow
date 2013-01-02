<?php

require_once 'Counter.php';
require_once 'Exceptions.php';

class CounterFactory {

    protected $chars;
    protected $counters = array();

    public function __construct($chars) {
        $this->chars = $chars;
    }

    public function getCounterForPlayer($player) {
        $this->checkNumInRange($player);
        return $this->getOrMakeCounterForPlayer($player);
    }

    protected function getOrMakeCounterForPlayer($player) {
        $counterNum = $this->getCounterNumberForPlayer($player);
        if (empty($this->counters[$counterNum])) {
            $this->counters[$counterNum] = $this->makeNewCounter($counterNum);
        }
        return $this->counters[$counterNum];
    }

    protected function getCounterNumberForPlayer($player) {
        return $player - 1;
    }

    protected function makeNewCounter($counterNum) {
        $char = $this->chars[$counterNum];
        return new Counter($char);
    }

    protected function checkNumInRange($num) {
        $maxPlayer = count($this->chars);
        if ($num < 1 || $num > $maxPlayer) {
            throw new NoCounterException("A counter for player number $num is outside of valid range (0-$maxPlayer)");
        }
    }

}
?>