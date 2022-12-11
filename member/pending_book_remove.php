<?php
    
    require_once($_SERVER['DOCUMENT_ROOT'] . "/" . basename(dirname(dirname(__FILE__))) . "/snippets/header.php");

    if (!$user -> Is_Logged_in() || $user -> Is_Admin()) {
        Redirect(location: BASE_URL);
    }

    $pending_books = new Pending_Books();
    
    $request = new Request_Validate($_GET, ["id", "token"]);
    $id = $request -> DigitField($_GET["id"]);
    $request -> CSRF($_GET["token"]);

    if (!empty($pending_books -> List(book_id: $id))) {
        $pending_books -> Remove($id);
        Redirect("Request removed", "pending_books.php");
    }
    else {
        Redirect("Invalid ID", "pending_books.php");
    }