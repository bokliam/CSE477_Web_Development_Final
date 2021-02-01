<?php
require '../game.inc.php';

$controller = new \game\GameController($game, $_POST);

if($controller->isReset()){
    unset($_SESSION[HITORI_SESSION]);
    $_SESSION[HITORI_SESSION] = new game\Game();
}

header('Location: ' . $controller->getPage());