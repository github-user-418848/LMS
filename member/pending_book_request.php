<?php

    require_once($_SERVER['DOCUMENT_ROOT'] . "/" . basename(dirname(dirname(__FILE__))) . "/snippets/user_member.php");

    $book = new Book();
    
    $request = new Request_Validate($_GET, ["id", "token"]);
    $id = $request -> DigitField($_GET["id"]);
    $request -> CSRF($_GET["token"]);
    $book_detail = $book -> List($id);

    if (empty($book_detail)) {
        Redirect("Invalid ID", "books.php");
    }

?>
<div class="row justify-content-center">
    <div class="col-md-7 text-center">
        <h1>Request Book</h1>
    </div>
    <div class="col-md-7">
        <form method="post">
            <div class="col-md-12">
                <p><strong>ISBN</strong> <?=$book_detail -> isbn ?></p><hr>
                <p><strong>Title</strong> <?=$book_detail -> title ?></p><hr>
                <p><strong>Author</strong> <?=$book_detail -> author ?></p><hr>
                <p><strong>Category</strong> <?=$book_detail -> category ?></p><hr>
                <p><strong>Number of Book Copies Remaining</strong> <?=$book_detail -> copies ?></p><hr>
            </div>
            <div class="d-flex-wrap align-items-center justify-content-center">
                <div class="col-md-2">
                    <a id="back" class="btn">Cancel</a>
                </div>
                <div class="col-md-5">
                    <input type="text" name="copies" id="copies" placeholder="Number of copies">
                    <input type="hidden" name="csrf_token" id="csrf_token" value="<?= $_SESSION["csrf_token"] ?>">
                </div>
                <div class="col-md-5">
                    <input type="submit" value="Request Book" name="submit">
                </div>
            </div>
        </form>
    </div>
</div>
<script nonce="<?=$_SESSION['nonce']?>">
    const back = document.getElementById("back");
    back.onclick = function () {
        window.history.back();
    }
</script>
<?php

    if (isset($_POST["submit"])) {

        $request = new Request_Validate($_POST, ["copies", "csrf_token",]);
        $request -> CSRF($_POST["csrf_token"]);
        $copies = $request -> DigitField($_POST["copies"], 1, 10);

        $pending_books = new Pending_Books($_SESSION["username"], $book_detail -> isbn, $copies);
        $pending_books -> Save();

        unset($_SESSION["csrf_token"]);
        Redirect("Book {$book_detail -> isbn} has been requested. Please wait for the administrator to review for approval", "books.php");

    }
    require_once($_SERVER['DOCUMENT_ROOT'] . "/" . basename(dirname(dirname(__FILE__))) . "/snippets/footer.php");?>