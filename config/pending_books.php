<?php

class Pending_Books extends DB {

    public function __construct($user=null, $book=null, $copies=null) {

        parent::__construct();

        $this -> user = $user;
        $this -> book = $book;
        $this -> copies = $copies;

        $this -> data = array($this -> user, $this -> book, $this -> copies);

    }
    
    public function List($id=null, $book_id=null, $limit=50) {
        if ($id !== null) {
            $stmt = $this -> conn_str -> prepare(
                "SELECT pending_book_requests.id 'id', pending_book_requests.copies 'copies', user.id 'user_id', user.username, user.email, 
                book.id 'book_id', pending_book_requests.book_isbn, pending_book_requests.date 
                FROM pending_book_requests join user on (pending_book_requests.member_name=user.username) 
                join book on (pending_book_requests.book_isbn=book.isbn) WHERE user.id=? ORDER BY pending_book_requests.id DESC "
            );
            $stmt->execute(array($id));
            return $stmt -> fetchAll();
        }
        elseif ($book_id !== null) {
            $stmt = $this -> conn_str -> prepare(
                "SELECT pending_book_requests.id 'id', pending_book_requests.copies 'copies', user.id 'user_id', user.username, user.email, 
                book.id 'book_id', pending_book_requests.book_isbn, pending_book_requests.date 
                FROM pending_book_requests join user on (pending_book_requests.member_name=user.username) 
                join book on (pending_book_requests.book_isbn=book.isbn) WHERE pending_book_requests.id=? ORDER BY pending_book_requests.id DESC "
            );
            $stmt->execute(array($book_id));
            return $stmt -> fetch();
        }
        else {
            $stmt = $this -> conn_str -> prepare(
                "SELECT pending_book_requests.id 'id', pending_book_requests.copies 'copies', user.id 'user_id', user.username, user.email, 
                book.id 'book_id', book.copies 'copies', pending_book_requests.book_isbn, pending_book_requests.date 
                FROM pending_book_requests join user on (pending_book_requests.member_name=user.username) 
                join book on (pending_book_requests.book_isbn=book.isbn) ORDER BY pending_book_requests.id DESC LIMIT {$limit}"
            );
            $stmt->execute();
            return $stmt -> fetchAll();
        }
    }
    
    public function Approve($id, $date) {
        // decrease number of books
        // insert into issued books
        
        $stmt = $this -> conn_str -> prepare("UPDATE book SET copies=:copies WHERE isbn=:isbn AND DELETE pending_book_requests WHERE id=:id");
        $stmt -> bindValue(":copies", $this -> copies);
        $stmt -> bindValue(":isbn", $this -> book);
        $stmt -> bindValue(":id", $id);
        $stmt -> execute();

        // $stmt = $this -> conn_str -> prepare("DELETE FROM pending_book_requests WHERE id=?");
        // $stmt->execute(array($id));

        if ($this -> copies <= $book -> copies) {
            $stmt = $this -> conn_str -> prepare("INSERT INTO pending_book_requests (member_name, book_isbn, copies) values (?, ?, ?)");
            $stmt->execute($this -> data);
        }

    }

    public function Remove($id) {
        $stmt = $this -> conn_str -> prepare("DELETE FROM pending_book_requests WHERE id=?");
        $stmt->execute(array($id));
    }

    public function Save() {
        
        $stmt = $this -> conn_str -> prepare("SELECT * FROM book WHERE isbn=?");
        $stmt->execute(array($this -> book));
        $book = $stmt -> fetch();

        if ($this -> copies <= $book -> copies) {
            $stmt = $this -> conn_str -> prepare("INSERT INTO pending_book_requests (member_name, book_isbn, copies) values (?, ?, ?)");
            $stmt->execute($this -> data);
        }
        else {
            Redirect("Number of copies should be less than {$book -> copies}");
        }
    }
}