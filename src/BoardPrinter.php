<?php
require_once "Observer.php";

interface BoardPrinter extends Observer {

    public function draw();

}
?>