<?php
    
    require_once($_SERVER['DOCUMENT_ROOT'] . "/" . basename(dirname(dirname(__FILE__))) . "/snippets/header.php");

    if (!$user -> Is_Logged_in() || !$user -> Is_Admin()) {
        Redirect(location: BASE_URL);
    }

    $books = new Book();
    $pending_books = new Pending_Books();

?>
<div class="row justify-content-center">
    <div class="col-md-12 text-center">
        <h1>Welcome <?=$_SESSION["username"]?>!</h1>
    </div>
    <div class="col-md-7">
        <div class="card">
            <h2>Books</h2>
            <?php foreach ($books -> List(limit:3) as $book): ?>
                <p><?=$book -> isbn?></p>
                <p><?=$book -> title?></p>
                <p><?=$book -> author?></p>
                <p><?=$book -> category?></p>
                <p><?=$book -> copies?></p>
            <?php endforeach; ?>
        </div>
    </div>
    <div class="col-md-5">
        <row>
            <div class="col-md-12">
                <div class="card">
                    <h2>Recent Books Added</h2>
                    <hr>
                    <?php foreach ($books -> List(limit:3) as $book): ?>
                        <p><a href="books.php?s=<?=$book->isbn?>&csrf_token=<?=$_SESSION["csrf_token"]?>&submit"><strong><?=$book -> title?></strong></a></p>
                        <hr>
                    <?php endforeach; ?>
                    <a class="btn" href="books.php">See more</a>
                </div>
            </div>
            <div class="col-md-12">
                <div class="card">
                    <h2>Requests Pending for Approval</h2>
                    <hr>
                    <?php foreach ($pending_books -> List(limit:3) as $pending): ?>
                        <p><strong><?=$pending -> book_isbn?></strong></p>
                        <p>Requested by <strong><?=$pending -> username?></strong></p>
                        <hr>
                    <?php endforeach; ?>
                    <a class="btn" href="pending_books.php">See more</a>
                </div>
            </div>
        </row>
    </div>
</div>
<?php

    require_once($_SERVER['DOCUMENT_ROOT'] . "/" . basename(dirname(dirname(__FILE__))) . "/snippets/footer.php");