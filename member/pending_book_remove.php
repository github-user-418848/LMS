<?php

    require_once($_SERVER['DOCUMENT_ROOT'] . "/" . basename(dirname(dirname(__FILE__))) . "/snippets/user_member.php");

    $pending_books = new Pending_Books();
    
    $request = new Request_Validate($_GET, ["id", "token"]);
    $request -> redirect = "pending_books.php";
    $id = $request -> DigitField($_GET["id"]);
    $request -> CSRF($_GET["token"]);

    if (!empty($pending_books -> List(book_id: $id))) {
        $pending_books -> Remove($id);
        Redirect("Request removed", "pending_books.php");
    }
    else {
        Redirect("Invalid ID", "pending_books.php");
    }