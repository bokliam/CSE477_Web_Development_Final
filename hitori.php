<?php
require 'game.inc.php';

$view = new \game\GameView($game, $_GET);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <?php echo $view->presentHead();?>
</head>

<body>
    <?php
    if ($view->checking()){
        echo $view->presentCheck();
    }
    else {
        echo $view->presentForm();
    }
    ?>
</body>
</html>
