<?php

    require_once($_SERVER['DOCUMENT_ROOT'] . "/" . basename(dirname(dirname(__FILE__))) . "/snippets/user_librarian.php");
    
    $pending_books = new Pending_Books();

    if (isset($_GET["submit"])) {
        $request = new Request_Validate($_GET, ["s", "csrf_token"]);
        $request -> redirect = "pending_books.php";
        $request -> CSRF($_GET["csrf_token"]);
        $search = $request -> TextField($_GET["s"], 1);

        $pending_books = new Pending_Books("%{$search}%", "%{$search}%", "%{$search}%");
    }

    $pending_books_list = $pending_books -> List();

?>    
    <div class="row justify-content-center text-center">
        <div class="col-md-12">
            <h1>Pending Books</h1>
            <form method="get">
                <input type="text" name="s" id="search" placeholder="Filter Books" <?=isset($search) ? "value='{$search}'" : ""?>>
                <input type="hidden" name="csrf_token" value="<?=$_SESSION["csrf_token"]?>">
                <input type="submit" value="Search" name="submit">
            </form>
            <?=isset($search) ? "<h3>Search results for: {$search}</h3>" : ""?>
        </div>
    </div>
    <?php if (empty($pending_books_list)): ?>
        <hr><h1 class="text-center d-flex align-items-center justify-content-center" style="min-height: 50vh">No Pending Books</h1><hr>
    <?php elseif (!empty($pending_books_list)): ?>
    <div class="row justify-content-center align-items-stretch col-md-12">
        <div class="table-container">
            <table class="mx-auto table" cellspacing="0" style="overflow-x: auto">
                <tr class="table-head">
                    <th>User</th>
                    <th>ISBN</th>
                    <th>Date Requested</th>
                    <th>Book Copies</th>
                    <th colspan="2">Approve Request?</th>
                </tr>
                <?php foreach ($pending_books_list as $pending): ?>
                <tr>
                    <td><a href='user_update.php?id=<?=$pending -> user_id ?>&token=<?=$_SESSION["csrf_token"] ?>'><?=$pending -> username ?></a></td>
                    <td><a href='books.php?s=<?=$pending -> book_isbn ?>&csrf_token=<?=$_SESSION["csrf_token"] ?>&submit'><?=$pending -> book_isbn ?></a></td>
                    <td><?= $pending -> date ?></td>
                    <td><?= $pending -> request_copies ?></td>
                    <td>
                        <a href='pending_book_approve.php?id=<?=$pending -> id?>&token=<?=$_SESSION["csrf_token"] ?>'>
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor" class="bi bi-check-circle" viewBox="0 0 16 16">
                                <path d="M8 15A7 7 0 1 1 8 1a7 7 0 0 1 0 14zm0 1A8 8 0 1 0 8 0a8 8 0 0 0 0 16z"/>
                                <path d="M10.97 4.97a.235.235 0 0 0-.02.022L7.477 9.417 5.384 7.323a.75.75 0 0 0-1.06 1.06L6.97 11.03a.75.75 0 0 0 1.079-.02l3.992-4.99a.75.75 0 0 0-1.071-1.05z"/>
                            </svg>
                        </a>&nbsp;
                        <a href='pending_books_deny.php?id=<?=$pending -> id?>&token=<?=$_SESSION["csrf_token"] ?>'>
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor" class="bi bi-x-circle" viewBox="0 0 16 16">
                            <path d="M8 15A7 7 0 1 1 8 1a7 7 0 0 1 0 14zm0 1A8 8 0 1 0 8 0a8 8 0 0 0 0 16z"/>
                            <path d="M4.646 4.646a.5.5 0 0 1 .708 0L8 7.293l2.646-2.647a.5.5 0 0 1 .708.708L8.707 8l2.647 2.646a.5.5 0 0 1-.708.708L8 8.707l-2.646 2.647a.5.5 0 0 1-.708-.708L7.293 8 4.646 5.354a.5.5 0 0 1 0-.708z"/>
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

