<?php

/**
 * Created by PhpStorm.
 * User: Liam
 * Date: 4/29/20
 * Time: 11:54 AM
 */


namespace game;


class GameView
{
    /**
     * GameView constructor.
     * @param Game $g Game object in session
     * @param $get array GET
     */
    public function __construct(Game $g, $get){
        $this->name = $get['n'];
        $this->game = $g;

        // See if user has correct solution
        if($this->game->win()){
            $this->win = true;
        }

        // Get clicked row/column element and its shading
        if (isset($get['r']) && isset($get['c']) && isset($get['s'])){
            $this->r = $get['r'];
            $this->c = $get['c'];
            $this->s = $get['s'];
        }

        // Check the board
        if(isset($get['check'])){
            $this->check = true;
        }


    }

    /**
     * @return string Present head HTML
     */
    public function presentHead(){
        $html = <<<HTML
<meta charset="utf-8">
<link href="hitori.css" type="text/css" rel="stylesheet" />
<title>Super Hitori</title>
HTML;

        return $html;
    }

    /**
     * @return string Present form Table in HTML
     */
    public function presentForm(){
        $html = <<<HTML
<form id="gameform" action="post/game-post.php" method="POST">
<fieldset>
<p>$this->name's Super Hitori</p>
HTML;

        // This is just some dummy code to create an example of what
        // the HTML should look like, though not including any contents
        // of the cells other than the numbers.
        $values = [
            [8, 5, 4, 7, 7, 2, 3, 5],
            [6, 8, 7, 2, 5, 4, 5, 1],
            [7, 1, 4, 4, 6, 5, 2, 3],
            [2, 8, 3, 8, 7, 5, 3, 4],
            [5, 7, 8, 1, 3, 5, 6, 7],
            [1, 8, 2, 8, 5, 3, 4, 7],
            [5, 3, 6, 2, 1, 7, 7, 7],
            [5, 2, 5, 3, 4, 7, 8, 6]
        ];

        $html .= '<table>';

        for($r=0;  $r<count($values);  $r++) {
            $html .= '<tr>';
            $row = $values[$r];

            for($c=0; $c<count($row);  $c++) {

                // Used to determine unset, unshaded, or shaded
                $s = $this->game->getValue($r, $c);

                if ($s == 0){
                    $html .= '<td>';
                    $html .= '<button type="submit" id="cell" name="cell" value=' . $r . ',' . $c . ',' . $s . '>'.
                        $row[$c] . '</button>';
                    $html .= '</td>';
                }
                else if ($s == 1){
                    $html .= '<td class="unshaded">';
                    $html .= '<button type="submit" id="cell" name="cell" value=' . $r . ',' . $c . ',' . $s . '>'.
                        $row[$c] . '</button>';
                    $html .= '</td>';
                }
                else{
                    $html .= '<td class="shaded">';
                    $html .= '<button type="submit" id="cell" name="cell" value=' . $r . ',' . $c . ',' . $s . '>'.
                        $row[$c] . '</button>';
                    $html .= '</td>';
                }
            }


            $html .= '</tr>';
        }

        $html .= '</table>';

        // If player hasn't won yet
        if ($this->win == false) {
            $html .= <<<HTML
<p><input type="submit" name="check" id="check" value="Check"></p>
<p><input type="submit" name="giveup" id="giveup" value="Give Up"></p>
<p><input type="submit" name="newgame" id="newgame" value="New Game"></p>
<input type="hidden" name="name" id="name" value="$this->name">
<p><a href="exit.php">Goodbye!</a></p>
</fieldset>
</form>
HTML;

            return $html;
        }

        // Player has correct solution
        else{
            $html .= <<<HTML
<p>Solution is correct!</p>
<p><input type="submit" name="newgame" id="newgame" value="New Game"></p>
<input type="hidden" name="name" id="name" value="$this->name">
<p><a href="exit.php">Goodbye!</a></p>
</fieldset>
</form>
HTML;

            return $html;
        }

    }


    /**
     * @return string Present form table check in HTML
     */
    public function presentCheck(){
        $wrong = $this->game->check();
        $wrongArray = [
            [0, 0, 0, 0, 0, 0, 0, 0],
            [0, 0, 0, 0, 0, 0, 0, 0],
            [0, 0, 0, 0, 0, 0, 0, 0],
            [0, 0, 0, 0, 0, 0, 0, 0],
            [0, 0, 0, 0, 0, 0, 0, 0],
            [0, 0, 0, 0, 0, 0, 0, 0],
            [0, 0, 0, 0, 0, 0, 0, 0],
            [0, 0, 0, 0, 0, 0, 0, 0]
        ];

        if(count($wrong) != 0){
            foreach($wrong as $val){
                $wrongArray[$val[0]][$val[1]] = 1;
            }
        }



        $html = <<<HTML
<form id="gameform1" action="post/game-post.php" method="POST">
<fieldset>
<p>$this->name's Super Hitori</p>
HTML;

        // This is just some dummy code to create an example of what
        // the HTML should look like, though not including any contents
        // of the cells other than the numbers.
        $values = [
            [8, 5, 4, 7, 7, 2, 3, 5],
            [6, 8, 7, 2, 5, 4, 5, 1],
            [7, 1, 4, 4, 6, 5, 2, 3],
            [2, 8, 3, 8, 7, 5, 3, 4],
            [5, 7, 8, 1, 3, 5, 6, 7],
            [1, 8, 2, 8, 5, 3, 4, 7],
            [5, 3, 6, 2, 1, 7, 7, 7],
            [5, 2, 5, 3, 4, 7, 8, 6]
        ];

        $html .= '<table>';

        for($r=0;  $r<count($values);  $r++) {
            $html .= '<tr>';
            $row = $values[$r];

            for ($c = 0; $c < count($row); $c++) {

                // Used to determine unset, unshaded, or shaded
                $s = $this->game->getValue($r, $c);

                // Check pressed but all entries unset
                if (count($wrong) == 0) {
                    if ($s == 0){
                        $html .= '<td>';
                        $html .= '<button type="submit" id="cell" name="cell" value=' . $r . ',' . $c . ',' . $s . '>'.
                            $row[$c] . '</button>';
                        $html .= '</td>';
                    }
                    else if ($s == 1){
                        $html .= '<td class="unshaded">';
                        $html .= '<button type="submit" id="cell" name="cell" value=' . $r . ',' . $c . ',' . $s . '>'.
                            $row[$c] . '</button>';
                        $html .= '</td>';
                    }
                    else{
                        $html .= '<td class="shaded">';
                        $html .= '<button type="submit" id="cell" name="cell" value=' . $r . ',' . $c . ',' . $s . '>'.
                            $row[$c] . '</button>';
                        $html .= '</td>';
                    }
                }

                // Check pressed and wrong answers entered
                else{
                    if (($s == 1) && ($wrongArray[$r][$c] == 1)){
                        $html .= '<td class="unshaded wrong">';
                        $html .= '<button type="submit" id="cell" name="cell" value=' . $r . ',' . $c . ',' . $s . '>'.
                            $row[$c] . '</button>';
                        $html .= '</td>';
                    }
                    else if (($s == 2) && ($wrongArray[$r][$c] == 1)){
                        $html .= '<td class="shaded wrong">';
                        $html .= '<button type="submit" id="cell" name="cell" value=' . $r . ',' . $c . ',' . $s . '>'.
                            $row[$c] . '</button>';
                        $html .= '</td>';
                    }
                    else if (($s == 1) && ($wrongArray[$r][$c] == 0)){
                        $html .= '<td class="unshaded">';
                        $html .= '<button type="submit" id="cell" name="cell" value=' . $r . ',' . $c . ',' . $s . '>'.
                            $row[$c] . '</button>';
                        $html .= '</td>';
                    }
                    else if (($s == 2) && ($wrongArray[$r][$c] == 0)){
                        $html .= '<td class="shaded">';
                        $html .= '<button type="submit" id="cell" name="cell" value=' . $r . ',' . $c . ',' . $s . '>'.
                            $row[$c] . '</button>';
                        $html .= '</td>';
                    }
                    else{
                        $html .= '<td>';
                        $html .= '<button type="submit" id="cell" name="cell" value=' . $r . ',' . $c . ',' . $s . '>'.
                            $row[$c] . '</button>';
                        $html .= '</td>';
                    }
                }

            }

            $html .= '</tr>';
        }

        $html .= '</table>';


        $html .= <<<HTML
<p><input type="submit" name="uncheck" id="uncheck" value="Uncheck"></p>
<p><input type="submit" name="giveup" id="giveup" value="Give Up"></p>
<p><input type="submit" name="newgame" id="newgame" value="New Game"></p>
<input type="hidden" name="name" id="name" value="$this->name">
<p><a href="exit.php">Goodbye!</a></p>
</fieldset>
</form>
HTML;

        return $html;
    }


    /**
     * @return bool Determine if check button pressed or not
     */
    public function checking(){
        return $this->check;
    }


    private $name;
    private $game;
    private $r = null;   // Row variable used to modify cell that is clicked on
    private $c = null;   // Column variable used to modify cell that is clicked on
    private $s = null;   // Shade variable used to modify cell that is clicked on
    private $check = false;  // Flag used to check board
    private $win = false;   // Flag used to signify correct solution
}