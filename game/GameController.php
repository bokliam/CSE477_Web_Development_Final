<?php

/**
 * Created by PhpStorm.
 * User: Liam
 * Date: 4/29/20
 * Time: 12:14 PM
 */


namespace game;


class GameController
{
    /**
     * GameController constructor.
     * @param Game $g Game object in session
     * @param $post array POST
     */
    public function __construct(Game $g, $post){
        $this->page = "$this->root/index.php";
        $this->game = $g;

        // Get name for redirect
        if(isset($post['name'])){
            $this->name = $post['name'];
        }

        // Check pressed
        if(isset($post['check'])){
            $this->page = "$this->root/hitori.php?n=$this->name&check=1";
        }

        // Uncheck pressed
        if(isset($post['uncheck'])){
            $this->page = "$this->root/hitori.php?n=$this->name";
        }

        // Giveup pressed
        if(isset($post['giveup'])){
            $this->game->giveUp();
            $this->page = "$this->root/hitori.php?n=$this->name";
        }

        // Newgame pressed
        if(isset($post['newgame'])){
            $this->reset = true;
            $this->page = "$this->root/hitori.php?n=$this->name";
        }

        // If cell was clicked
        if(isset($post['cell'])){
            // Get row and column
            $val = explode(',', $post['cell']);
            $row = $val[0];
            $col = $val[1];
            $s = $val[2];

            // What shading to set cell to?
            if($s == 0){
                $s = 1;
            }
            else if ($s == 1){
                $s = 2;
            }
            else{
                $s = 0;
            }

            $this->game->setValue($row, $col, $s);

            // Redirect back to Gameview
            $this->page = "$this->root/hitori.php?n=$this->name";
        }

    }

    /**
     * @return string Current Page
     */
    public function getPage(){
        return $this->page;
    }

    /**
     * @return bool Reset Flag
     */
    public function isReset(){
        return $this->reset;
    }


    private $page = "index.php";
    private $root = 'http://webdev.cse.msu.edu/~bokliam/exam';
    private $name;
    private $game;
    private $reset = false;
}