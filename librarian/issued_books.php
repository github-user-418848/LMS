<?php

    require_once($_SERVER['DOCUMENT_ROOT'] . "/" . basename(dirname(dirname(__FILE__))) . "/snippets/user_librarian.php");
    
    $issued_book_log = new Issued_Book_Log();
    $issued_book_log_list = $issued_book_log -> List();

?>    
    <div class="row justify-content-center text-center">
        <div class="col-md-12">
            <h1>Issued Book Logs</h1>
            <form method="get">
                <input type="text" name="s" id="search" placeholder="Filter Books" <?=isset($search) ? "value='{$search}'" : ""?>>
                <input type="hidden" name="csrf_token" value="<?=$_SESSION["csrf_token"]?>">
                <input type="submit" value="Search" name="submit">
            </form>
            <?=isset($search) ? "<h3>Search results for: {$search}</h3>" : ""?>
        </div>
    </div>
    <?php if (empty($issued_book_log_list)): ?>
       <hr><h1 class="text-center d-flex align-items-center justify-content-center" style="min-height: 50vh">No Books Issued</h1><hr>
    <?php elseif (!empty($issued_book_log_list)): ?>
    <div class="row justify-content-center align-items-stretch">
        <div class="table-container">
            <table class="mx-auto table" cellspacing="0" style="overflow-x: auto">
                <tr class="table-head">
                    <th>User</th>
                    <th>Email</th>
                    <th>ISBN</th>
                    <th>Date Requested</th>
                    <th>Due Date</th>
                    <th>Book Copies</th>
                    <th>Complete Status</th>
                </tr>
                <?php foreach ($issued_book_log_list as $book): ?>
                <tr>
                    <td><a href='user_update.php?id=<?=$book -> user_id ?>&token=<?=$_SESSION["csrf_token"] ?>'><?=$book -> member_name ?></a></td>
                    <td><?=$book -> member_name ?></td>
                    <td><a href='books.php?s=<?=$book -> book_isbn ?>&csrf_token=<?=$_SESSION["csrf_token"] ?>&submit'><?=$book -> book_isbn ?></a></td>
                    <td><?= $book -> date_requested ?></td>
                    <td><?= $book -> due_date ?></td>
                    <td><?= $book -> copies ?></td>
                    <td>
                        <a href='issued_books_complete.php?id=<?=$book -> id?>&isbn=<?=$book -> book_isbn ?>&token=<?=$_SESSION["csrf_token"] ?>'>
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor" class="bi bi-check-circle" viewBox="0 0 16 16">
                                <path d="M8 15A7 7 0 1 1 8 1a7 7 0 0 1 0 14zm0 1A8 8 0 1 0 8 0a8 8 0 0 0 0 16z"/>
                                <path d="M10.97 4.97a.235.235 0 0 0-.02.022L7.477 9.417 5.384 7.323a.75.75 0 0 0-1.06 1.06L6.97 11.03a.75.75 0 0 0 1.079-.02l3.992-4.99a.75.75 0 0 0-1.071-1.05z"/>
                            </svg>
                        </a>
                    </td>
                </tr>
                <?php endforeach; ?>
            </table>
        </div>
    </div>
    <?php endif; ?>
<?php

    require_once($_SERVER['DOCUMENT_ROOT'] . "/" . basename(dirname(dirname(__FILE__))) . "/snippets/footer.php");?>

