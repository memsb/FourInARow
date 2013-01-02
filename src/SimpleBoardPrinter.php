<?php

require_once "Board.php";
require_once "BoardPrinter.php";

class SimpleBoardPrinter implements BoardPrinter {

    protected $board;

    protected $verticalDivider = '|';
    protected $emptySpace = '_';

    public function __construct(Board $board) {
        $this->board = $board;
    }

    public function draw() {
        $output = '';
        for ($row = $this->board->getTopRow(); $row >= $this->board->getBottomRow(); $row--) {
            $output .= $this->drawRow($row);
        }
        return $output;
    }

    protected function drawRow($row) {
        $output = '';
        for ($col = $this->board->getLeftColumn(); $col <= $this->board->getRightColumn(); $col++) {
            $pos = new Position($col, $row);
            $output .= $this->drawCell($pos);
        }
        $output .= $this->verticalDivider . PHP_EOL;
        return $output;
    }

    protected function drawCell($pos) {
        $cell = '';
        if ($this->board->positionIsEmpty($pos)) {
            $cell .= $this->verticalDivider . $this->emptySpace;
        } else {
            $counter = $this->board->getCell($pos);
            $cell .= $this->verticalDivider . $counter->char;
        }
        return $cell;
    }

}
?>