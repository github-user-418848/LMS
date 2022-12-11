<?php
    
    require_once($_SERVER['DOCUMENT_ROOT'] . "/" . basename(dirname(dirname(__FILE__))) . "/snippets/header.php");

    if (!$user -> Is_Logged_in() || $user -> Is_Admin()) {
        Redirect(location: BASE_URL);
    }

    $book = new Book();
    
    $request = new Request_Validate($_GET, ["id", "token"]);
    $id = $request -> DigitField($_GET["id"]);
    $request -> CSRF($_GET["token"]);
    $book_details = $book -> List($id);

    if (empty($book_details)) {
        Redirect("Invalid ID", "books.php");
    }

    $isbn = "";

?>
<div class="row justify-content-center">
    <div class="col-md-7">
        <h1>Request Book</h1>
    </div>
    <div class="col-md-7">
        <form method="post">
            <input type="text" name="copies" id="copies" placeholder="Number of copies">
            <input type="hidden" name="csrf_token" id="csrf_token" value="<?= $_SESSION["csrf_token"] ?>">
            <?php foreach($book_details as $book_detail): ?>
                <p><strong>ISBN</strong> <?=$isbn = $book_detail -> isbn ?></p>
                <hr>
                <p><strong>Title</strong> <?=$book_detail -> title ?></p>
                <hr>
                <p><strong>Author</strong> <?=$book_detail -> author ?></p>
                <hr>
                <p><strong>Category</strong> <?=$book_detail -> category ?></p>
                <hr>
                <p><strong>Books Remaining</strong> <?=$book_detail -> copies ?></p>
            <?php endforeach; ?>
            <div class="d-flex-wrap justify-content-center">
                <div class="col-md-5">
                    <a id="back" class="btn">Cancel</a>
                </div>
                <div class="col-md-5">
                    <input type="submit" value="Request Book" name="submit">
                </div>
            </div>
        </form>
    </div>
</div>
<?php

    if (isset($_POST["submit"])) {

        $request = new Request_Validate($_POST, ["copies", "csrf_token",]);
        $request -> CSRF($_POST["csrf_token"]);
        $copies = $request -> DigitField($_POST["copies"], 1, 10);

        $book = new Pending_Books($_SESSION["username"], $isbn, $copies);
        $book -> Save();

        unset($_SESSION["csrf_token"]);
        Redirect("Book {$isbn} has been requested. Please wait for the administrator to review for approval", "books.php");

    }
    require_once($_SERVER['DOCUMENT_ROOT'] . "/" . basename(dirname(dirname(__FILE__))) . "/snippets/footer.php");?>