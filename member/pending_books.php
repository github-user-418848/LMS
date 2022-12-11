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
                    <p><strong>Book:</strong> <a href="books.php?s=<?= $pending -> book_isbn ?>&csrf_token=<?=$_SESSION['csrf_token']?>&submit"><?= $pending -> book_isbn ?></a></p>
                    <p><strong>Date Requested:</strong> <?= $pending -> date ?></p>
                    <p><strong>Number of copies:</strong> <?= $pending -> copies ?></p>
                    <a href='pending_book_remove.php?id=<?=$pending -> id?>&token=<?=$_SESSION["csrf_token"] ?>'>Undo Request</a>
                </div>
            </div>
        <?php endforeach; ?>
    <?php elseif (empty($pending_books_list)): ?>
        <h1 class="text-center d-flex align-items-center justify-content-center" style="min-height: 50vh">No Books Has Been Added Yet</h1>
    <?php endif; ?>
</div>
<?php

    require_once($_SERVER['DOCUMENT_ROOT'] . "/" . basename(dirname(dirname(__FILE__))) . "/snippets/footer.php");?>






