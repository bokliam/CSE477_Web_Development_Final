<?php

/**
 * Created by PhpStorm.
 * User: Liam
 * Date: 4/29/20
 * Time: 2:00 PM
 */


namespace game;


use phpDocumentor\Reflection\Types\This;

class Game
{
    /**
     * Game constructor.
     */
    public function __construct(){
        $this->values = [
            [0, 0, 0, 0, 0, 0, 0, 0],
            [0, 0, 0, 0, 0, 0, 0, 0],
            [0, 0, 0, 0, 0, 0, 0, 0],
            [0, 0, 0, 0, 0, 0, 0, 0],
            [0, 0, 0, 0, 0, 0, 0, 0],
            [0, 0, 0, 0, 0, 0, 0, 0],
            [0, 0, 0, 0, 0, 0, 0, 0],
            [0, 0, 0, 0, 0, 0, 0, 0]
        ];

        $this->solution = [
            [0, 1, 0, 0, 1, 0, 0, 0],
            [0, 0, 0, 0, 0, 0, 1, 0],
            [0, 0, 1, 0, 0, 1, 0, 0],
            [0, 1, 0, 1, 0, 0, 1, 0],
            [1, 0, 0, 0, 0, 1, 0, 1],
            [0, 1, 0, 0, 1, 0, 0, 0],
            [0, 0, 0, 1, 0, 1, 0, 1],
            [1, 0, 0, 0, 0, 0, 0, 0]
        ];
    }

    /**
     * Set value in table where user clicked
     * @param $row int row
     * @param $col int column
     * @param $shade int Shading
     */
    public function setValue($row, $col, $shade){
        $this->values[$row][$col] = $shade;
    }

    /**
     * Get value in table where user clicked
     * @param $row int row
     * @param $col int column
     * @return mixed
     */
    public function getValue($row, $col){
        return $this->values[$row][$col];
    }

    /**
     * @return array Array containing coordinates of wrong values
     */
    public function check(){
        $res = array();
        for($r = 0; $r<count($this->values); $r++){
            for($c = 0; $c<8; $c++){
                if( $this->values[$r][$c] == 1 && $this->solution[$r][$c] == 1 ){
                    array_push($res, [$r, $c]);
                }
                else if ( $this->values[$r][$c] == 2 && $this->solution[$r][$c] == 0 ){
                    array_push($res, [$r, $c]);
                }
            }
        }

        return $res;
    }

    /**
     * User pressed give up button, set solution
     */
    public function giveUp(){
        $res = [
            [0, 0, 0, 0, 0, 0, 0, 0],
            [0, 0, 0, 0, 0, 0, 0, 0],
            [0, 0, 0, 0, 0, 0, 0, 0],
            [0, 0, 0, 0, 0, 0, 0, 0],
            [0, 0, 0, 0, 0, 0, 0, 0],
            [0, 0, 0, 0, 0, 0, 0, 0],
            [0, 0, 0, 0, 0, 0, 0, 0],
            [0, 0, 0, 0, 0, 0, 0, 0]
        ];

        for($r = 0; $r<count($this->values); $r++) {
            for ($c = 0; $c < 8; $c++) {
                if ($this->solution[$r][$c] == 1){
                    $res[$r][$c] = 2;
                }
                else{
                    $res[$r][$c] = 1;
                }
            }
        }

        $this->values = $res;
    }

    /**
     * @return bool Did the User win?
     */
    public function win(){

        for($r = 0; $r<count($this->values); $r++) {
            for ($c = 0; $c < 8; $c++) {
                if ( ($this->solution[$r][$c] == 1) && ($this->values[$r][$c] != 2)){
                    return false;
                }
            }
        }

        return true;
    }


    private $values;    // Array containing cells shading info
    private $solution;
}