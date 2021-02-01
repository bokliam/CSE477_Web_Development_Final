<?php
require 'game.inc.php';

// Unset the session when user clicks goodbye link
unset($_SESSION[HITORI_SESSION]);

header('Location: ' . 'index.php');