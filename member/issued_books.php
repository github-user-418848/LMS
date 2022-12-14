<?php

    require_once($_SERVER['DOCUMENT_ROOT'] . "/" . basename(dirname(dirname(__FILE__))) . "/snippets/user_member.php");
    
    $book_issue_log = new Book_Issue_Log();
    $book_issue_log_list = $book_issue_log -> List($_SESSION["username"]);

?>
<div class="row justify-content-center text-center">
    <div class="col-md-12">
        <h1>Welcome <?=$_SESSION["username"]?>!</h1>
    </div>
</div>
<div class="row justify-content-center">
    <?php if (!empty($book_issue_log_list)): ?>
        <?php foreach ($book_issue_log_list as $book_issue): ?>
            <div class="col-md-7">
                <div class="card">
                    <p><strong>Book:</strong> <a href="books.php?s=<?= $book_issue -> book_isbn ?>&csrf_token=<?=$_SESSION['csrf_token']?>&submit"><?= $book_issue -> book_isbn ?></a></p><hr>
                    <p><strong>Number of copies:</strong> <?= $book_issue -> copies ?></p><hr>
                    <p><strong>Date Requested:</strong> <?= $book_issue -> date_requested ?></p><hr>
                    <p><strong>Due Date:</strong> <?= $book_issue -> due_date ?></p>
                </div>
            </div>
        <?php endforeach; ?>
    <?php elseif (empty($book_issue_log_list)): ?>
        <div class="col-md-12">
            <hr><h1 class="text-center d-flex align-items-center justify-content-center" style="min-height: 50vh">No Books Has Been Added Yet</h1><hr>
        </div>
    <?php endif; ?>
</div>
<?php

    require_once($_SERVER['DOCUMENT_ROOT'] . "/" . basename(dirname(dirname(__FILE__))) . "/snippets/footer.php");?>

