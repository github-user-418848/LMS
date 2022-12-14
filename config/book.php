<?php

class Book extends DB {

    public function __construct($isbn=null, $title=null, $author=null, $category=null, $copies=null) {

        parent::__construct();

        $this -> isbn = $isbn;
        $this -> title = $title;
        $this -> author = $author;
        $this -> category = $category;
        $this -> copies = $copies;

        $this -> data = array($this -> isbn, $this -> title, $this -> author, $this -> category, $this -> copies);

    }
    
    public function List($id=null, $limit=50) {
        if ($id !== null) {
            $stmt = $this -> conn_str -> prepare("SELECT * FROM book WHERE id=? AND copies !='0' ORDER BY id DESC");
            $stmt->execute(array($id));
            return $stmt -> fetch();
        }
        elseif($this -> title !== null) {
            $stmt = $this -> conn_str -> prepare("SELECT * FROM book WHERE isbn LIKE ? OR title LIKE ? OR author LIKE ? OR category LIKE ? AND copies != ? ORDER BY id DESC LIMIT {$limit}");
            $stmt->execute($this -> data);
            return $stmt -> fetchAll();
        }
        else {
            $stmt = $this -> conn_str -> prepare("SELECT * FROM book WHERE copies !='0' ORDER BY id DESC LIMIT {$limit}");
            $stmt->execute();
            return $stmt -> fetchAll();
        }

    }

    public function Save() { 
        $stmt = $this -> conn_str -> prepare("INSERT INTO book (isbn, title, author, category, copies) values (?, ?, ?, ?, ?)");
        $stmt->execute($this -> data);
    }

    public function Update($id) {
        $stmt = $this -> conn_str -> prepare("UPDATE book SET isbn=?, title=?, author=?, category=?, copies=? WHERE id=?");
        array_push($this -> data, $id);
        $stmt->execute($this -> data);
    }

    public function Delete($id) {
        $stmt = $this -> conn_str -> prepare("DELETE FROM book WHERE id=?");
        $stmt->execute(array($id));
    }

}