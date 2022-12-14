<?php

    require_once($_SERVER['DOCUMENT_ROOT'] . "/" . basename(dirname(dirname(__FILE__))) . "/snippets/user_librarian.php");
    
    $request = new Request_Validate($_GET, ["id", "isbn", "token"]);
    $request -> redirect = "issued_books.php";

    $id = $request -> DigitField($_GET["id"]);
    $isbn = $request -> TextField($_GET["isbn"]);

    $request -> CSRF($_GET["token"]);
    
    $issued_book_log = new Issued_Book_Log(null, $isbn, null, null);

    $issued_book_log -> Complete($id);
    Redirect("Book returned successfully", "issued_books.php");