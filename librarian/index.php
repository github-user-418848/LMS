<?php
    
    require_once($_SERVER['DOCUMENT_ROOT'] . "/" . basename(dirname(dirname(__FILE__))) . "/snippets/user_librarian.php");

    $books = new Book();
    $pending_books = new Pending_Books();
    $issued_book_log = new Issued_Book_Log();

?>
<div class="row justify-content-center">
    <div class="col-md-12">
        <h1>Welcome <?=$_SESSION["username"]?>!</h1>
    </div>
    <div class="col-md-7">
        <div class="card">
            <h2>Issued Books</h2>
            <hr>
            <?php if (empty($issued_book_log -> List())): ?>
                <h3 style="min-height: 120px" class="my-auto d-flex align-items-center justify-content-center">
                    No Books Added Yet
                </h3>
            <?php else:?>
                <?php foreach ($issued_book_log -> List(limit:3) as $book): ?>
                    <p><strong>User</strong> <?=$book -> member_name?></p>
                    <p><strong>Book</strong> <?=$book -> book_isbn?></p>
                    <small>
                    <p><strong>Date Requested</strong> <?=date_format(date_create($book -> date_requested), "D, M d, Y")?> | 
                    <strong>Date Issued</strong> <?=date_format(date_create($book -> due_date), "D, M d, Y")?></p>
                    </small>
                    <hr>
                <?php endforeach; ?>
                <a href="issued_books.php"><h4>See more</h4></a>
            <?php endif ?>
        </div>
    </div>
    <div class="col-md-5">
        <row>
            <div class="col-md-12">
                <div class="card">
                    <h2>Recent Books Added</h2>
                    <hr>
                    <?php if (empty($books -> List())): ?>
                        <h3 style="min-height: 120px" class="my-auto d-flex align-items-center justify-content-center">
                            No Books Added Yet
                        </h3>
                    <?php else:?>
                        <?php foreach ($books -> List(limit:3) as $book): ?>
                            <p><?=$book -> title?></p>
                            <hr>
                        <?php endforeach; ?>
                        <a href="books.php"><h4>See more</h4></a>
                    <?php endif ?>
                </div>
            </div>
            <div class="col-md-12">
                <div class="card">
                    <h2>Book Requests Pending for Approval</h2>
                    <hr>
                    <?php if (empty($pending_books -> List())): ?>
                        <h3 style="min-height: 120px" class="my-auto d-flex align-items-center justify-content-center">
                            No Requests Pending Yet
                        </h3>
                    <?php else:?>
                        <?php foreach ($pending_books -> List(limit:3) as $pending): ?>
                            <p><strong><?=$pending -> book_isbn?></strong></p>
                            <p>Requested by <strong><?=$pending -> username?></strong></p>
                            <hr>
                        <?php endforeach; ?>
                        <a href="pending_books.php"><h4>See more</h4></a>
                    <?php endif ?>
                </div>
            </div>
        </row>
    </div>
</div>
<?php

    require_once($_SERVER['DOCUMENT_ROOT'] . "/" . basename(dirname(dirname(__FILE__))) . "/snippets/footer.php");