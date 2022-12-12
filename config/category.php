<?php

class Category extends DB {

    public function __construct($id=null, $name=null) {

        parent::__construct();

        $this -> id = $id;
        $this -> name = $name;
        
        $this -> data = array($this -> id, $this -> name);
    }

    public function List($id=null) {
        if ($id !== null) {
            $stmt = $this -> conn_str -> prepare("SELECT * FROM category WHERE id=?");
            $stmt->execute(array($id));
        }

        else {
            $stmt = $this -> conn_str -> prepare("SELECT * FROM category");
            $stmt->execute();
        }

        return $stmt -> fetchAll();
    }
}