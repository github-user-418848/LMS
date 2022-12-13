<?php

    require_once($_SERVER['DOCUMENT_ROOT'] . "/" . basename(dirname(dirname(__FILE__))) . "/snippets/header.php");

    if (!$user -> Is_Logged_in() || $user -> Is_Admin()) {
        Redirect(location: BASE_URL);
    }

    $pending_books = new Pending_Books();
    $pending_books_list = $pending_books -> List($_SESSION["id"]);
    
?>
<div class="row justify-content-center text-center">
    <div class="col-md-12">
        <h1>Pending Books</h1>
    </div>
</div>
<div class="row justify-content-center">
    <?php if (!empty($pending_books_list)): ?>
        <?php foreach ($pending_books_list as $pending): ?>
            <div class="col-md-7">
                <div class="card">
                    <div class="d-flex-wrap justify-content-center align-items-center">
                        <div class="col-md-8">
                            <p><strong>Book:</strong> <a href="books.php?s=<?= $pending -> book_isbn ?>&csrf_token=<?=$_SESSION['csrf_token']?>&submit"><?= $pending -> book_isbn ?></a></p><hr>
                            <p><strong>Date Requested:</strong> <?= $pending -> date ?></p><hr>
                            <p><strong>Number of copies:</strong> <?= $pending -> copies ?></p><hr>
                        </div>
                        <div class="col-md-4 text-right">
                            <a class="btn" href='pending_book_remove.php?id=<?=$pending -> id?>&token=<?=$_SESSION["csrf_token"] ?>'>
                                <svg xmlns="http://www.w3.org/2000/svg" width="21" height="21" fill="currentColor" class="d-inline va-middle bi bi-arrow-counterclockwise" viewBox="0 0 16 16">
                                    <path fill-rule="evenodd" d="M8 3a5 5 0 1 1-4.546 2.914.5.5 0 0 0-.908-.417A6 6 0 1 0 8 2v1z"/>
                                    <path d="M8 4.466V.534a.25.25 0 0 0-.41-.192L5.23 2.308a.25.25 0 0 0 0 .384l2.36 1.966A.25.25 0 0 0 8 4.466z"/>
                                </svg>
                                Undo Request
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>
    <?php elseif (empty($pending_books_list)): ?>
        <div class="col-md-12">
            <hr><h1 class="text-center d-flex align-items-center justify-content-center" style="min-height: 50vh">No Books Has Been Added Yet</h1><hr>
        </div>
    <?php endif; ?>
</div>
<?php

    require_once($_SERVER['DOCUMENT_ROOT'] . "/" . basename(dirname(dirname(__FILE__))) . "/snippets/footer.php");?>






