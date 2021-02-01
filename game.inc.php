<?php
require __DIR__ . "/vendor/autoload.php";

session_start();

define("HITORI_SESSION", 'hitori');

// If session isn't set, then set it
if(!isset($_SESSION[HITORI_SESSION])){
    $_SESSION[HITORI_SESSION] = new game\Game();
}

$game = $_SESSION[HITORI_SESSION];