<?php

require '../game.inc.php';

$controller = new \game\StartController($game, $_POST);
header('Location: ' . $controller->getPage());
