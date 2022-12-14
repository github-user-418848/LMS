<?php

class Issued_Book_Log extends DB {


    public function __construct($user=null, $book=null, $due_date=null, $last_reminded=null) {

        parent::__construct();

        $this -> user = $user;
        $this -> book = $book;
        $this -> due_date = $due_date;
        $this -> last_reminded = $last_reminded;

        $this -> data = array($this -> user, $this -> book, $this -> due_date, $this -> last_reminded);

    }

    
    public function List($user=null, $limit=50) {
        if ($user !== null) {
            $stmt = $this -> conn_str -> prepare("SELECT * FROM book_issue_log WHERE member_name=? LIMIT {$limit}");
            $stmt->execute(array($user));
        }
        else {
            $stmt = $this -> conn_str -> prepare("SELECT * FROM book_issue_log LIMIT {$limit}");
            $stmt->execute();
        }
        return $stmt -> fetchAll();
    }

    public function Complete($id) {

        $stmt = $this -> conn_str -> prepare("SELECT * FROM book_issue_log WHERE id=?");
        $stmt->execute(array($id));
        $book_issue_log = $stmt -> fetch();

        $stmt = $this -> conn_str -> prepare("SELECT * FROM book WHERE isbn=?");
        $stmt -> execute(array($this -> book));
        $book = $stmt -> fetch();

        $remaining_copies = $book -> copies + $book_issue_log -> copies;
        
        $stmt = $this -> conn_str -> prepare("UPDATE book SET copies=:copies WHERE isbn=:isbn");
        $stmt -> bindValue(":copies", $remaining_copies);
        $stmt -> bindValue(":isbn", $this -> book);
        $stmt -> execute();

        $stmt = $this -> conn_str -> prepare("DELETE FROM book_issue_log WHERE id=?");
        $stmt->execute(array($id));

    }
}