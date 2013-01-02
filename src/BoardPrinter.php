<?php

interface BoardPrinter {

    public function __construct(Board $board);

    public function draw();

}
?>