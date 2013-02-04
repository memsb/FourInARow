<?php

class FourInARowException extends Exception{}

class InvalidBoardSizeException extends FourInARowException{}

class ExitSignalException extends FourInARowException{}

class GameplayException extends FourInARowException{}

class InvalidPositionException extends GameplayException{}

class NoCounterException extends GameplayException{}

class GameOverException extends FourInARowException{}

class BoardIsFullException extends GameOverException{}

class GameWonException extends GameOverException{}

class GameDrawnException extends GameOverException{}


?>
