<?php 

// require_once "init.php";

// $user = new Pending_Books($_SESSION[""]);
// $user -> email = "asd";
// $user -> username = "asd";
// $user -> Update(1);

// public function Save() {

//     $stmt = $this -> conn_str -> prepare(
//         "SELECT user.username 'pending_book_username', book.isbn 'isbn', book.copies 'copiesssssss' 
//         FROM pending_book_requests 
//         JOIN user ON (pending_book_requests.member_name=user.username) 
//         JOIN book ON (pending_book_requests.book_isbn=book.isbn)
//         WHERE user.username=? AND book.isbn=?"
//     );
//     $stmt -> execute(array($this -> user, $this -> book));
//     $pending_book = $stmt -> fetchAll();
    


//     if (empty($pending_book)) {
//         // foreach ($pending_book_list as $pending_book) {
//         if ($this -> copies <= $pending_book -> copiessssss) {
//             $stmt2 = $this -> conn_str -> prepare("INSERT INTO pending_book_requests (member_name, book_isbn, copies) values (?, ?, ?)");
//             $stmt2 -> execute(array($this -> user, $this -> book, $this -> copies));
//         }
//         else {
//             Redirect("Number of copies should be less than the copies of the book");
//         }
//         // }
//     }
//     else {
//         Redirect("You have already requested for this book");
//     }
//     // $stmt = $this -> conn_str -> prepare("SELECT * FROM book WHERE isbn=?");
//     // $stmt->execute(array($this -> book));
//     // $book = $stmt -> fetch();

//     // if ($this -> copies <= $book -> copies) {
//     // }
//     // else {
//     //     Redirect("Number of copies should be less than {$book -> copies}");
//     // }
// }
// }