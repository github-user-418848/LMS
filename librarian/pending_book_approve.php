<?php

    require_once($_SERVER['DOCUMENT_ROOT'] . "/" . basename(dirname(dirname(__FILE__))) . "/snippets/user_librarian.php");

    $pending_book = new Pending_Books();
    $request = new Request_Validate($_GET, ["id", "token",]);

    $id = $request -> DigitField($_GET["id"]);
    $request -> CSRF($_GET["token"]);
    $pending_book_details = $pending_book -> List(book_id:$id);

    if (empty($pending_book_details)) {
        Redirect("Invalid ID", "pending_books.php");
    }
?>
<div class="row justify-content-center text-center">
        <div class="col-md-12">
            <h1>Approve Request</h1>
        </div>
    </div>
<?php if (empty($pending_book_details)): ?>
        <h1 class="text-center d-flex align-items-center justify-content-center" style="min-height: 50vh">No Pending Books</h1>
<?php elseif (!empty($pending_book_details)): ?>
    <div class="row justify-content-center align-items-stretch">
        <div class="col-md-5">
            <div class="card">
                <h2>Request Details</h2><hr>
                <p><strong>ISBN</strong> <?=$pending_book_details -> book_isbn ?></p><hr>
                <p><strong>Email</strong> <?=$pending_book_details -> email ?></p><hr>
                <p><strong>Username</strong> <?=$pending_book_details -> username ?></p><hr>
                <p><strong>Number of Copies</strong> <?=$pending_book_details -> copies ?></p><hr>
                <p><strong>Date Requested</strong> <?=$pending_book_details -> date ?></p>
            </div>
        </div>
        <div class="col-md-7">
            <form method="post">
                <input type="hidden" name="csrf_token" id="csrf_token" value="<?= $_SESSION["csrf_token"] ?>">
                <p><strong>Issue Date</strong></p>
                <input type="date" name="date" id="date">
                <div class="d-flex-wrap justify-content-center">
                    <div class="col-md-5">
                        <a id="back" class="btn">Cancel</a>
                    </div>
                    <div class="col-md-5">
                        <input type="submit" value="Approve Request" name="submit">
                    </div>
                </div>
            </form>
        </div>
    </div>
<?php endif; ?>
<script nonce="<?=$_SESSION['nonce']?>">
    const back = document.getElementById("back");
    back.onclick = function () {
        window.history.back();
    }
</script>
<?php

    if (isset($_POST["submit"])) {

        $request = new Request_Validate($_POST, ["date", "csrf_token"]);
        $request -> CSRF($_POST["csrf_token"]);

        $pending_book = new Pending_Books($pending_book_details -> username, $pending_book_details -> book_isbn, $pending_book_details -> copies);
        $pending_book -> Approve($pending_book_details -> id, $request -> DateField($_POST["date"]));

        unset($_SESSION["csrf_token"]);
        Redirect("User request has been approved", "pending_books.php");
    }

    require_once($_SERVER['DOCUMENT_ROOT'] . "/" . basename(dirname(dirname(__FILE__))) . "/snippets/footer.php");?>

