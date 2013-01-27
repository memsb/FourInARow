<?php

class FourInARowException extends Exception{}

class InvalidBoardSizeException extends FourInARowException{}

class ExitSignalException extends FourInARowException{}

class GameplayException extends FourInARowException{}

class InvalidPositionException extends GameplayException{}

class NoCounterException extends GameplayException{}

class BoardIsFullException extends GameplayException{}

class GameOverException extends FourInARowException{}

class GameFinishedException extends FourInARowException{}

class GameWonException extends GameFinishedException{}

class GameDrawnException extends GameFinishedException{}


?>
