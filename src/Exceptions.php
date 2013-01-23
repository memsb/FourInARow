<?php

class FourInARowException extends Exception{}

class InvalidBoardSizeException extends FourInARowException{}

class InvalidPositionException extends FourInARowException{}

class NoCounterException extends FourInARowException{}

class GameWonException extends Exception{}
?>
