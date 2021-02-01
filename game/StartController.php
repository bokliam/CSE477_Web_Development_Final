<?php

/**
 * Created by PhpStorm.
 * User: Liam
 * Date: 4/29/20
 * Time: 10:46 AM
 */

namespace game;

class StartController
{
    /**
     * StartController constructor.
     * @param $session array session
     * @param $post array Post
     */
    public function __construct($session, $post) {

        $this->page = "$this->root/index.php";

        if(isset($post['name']) && $post['name'] != ""){
            $this->page = "$this->root/hitori.php?n=" . $post['name'];
        }

    }

    /**
     * @return string Page
     */
    public function getPage(){
        return $this->page;
    }


    private $page;
    private $root = 'http://webdev.cse.msu.edu/~bokliam/exam';

}