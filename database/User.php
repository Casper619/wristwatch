<?php

class User{
    public $db = null;

    public function __construct(DBController $db1){
        if(!isset($db1->con)) return null;
         $this->db = $db1;
    }

    
}

?>