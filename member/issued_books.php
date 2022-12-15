<?php

    require_once($_SERVER['DOCUMENT_ROOT'] . "/" . basename(dirname(dirname(__FILE__))) . "/snippets/user_member.php");
    
    $issued_book_log = new Issued_Book_Log();
    $issued_book_log_list = $issued_book_log -> List($_SESSION["username"]);

    if (isset($_GET["submit"])) {
        $request = new Request_Validate($_GET, ["s", "csrf_token"]);
        $request -> redirect = "issued_books.php";
        $request -> CSRF($_GET["csrf_token"]);
        $search = $request -> TextField($_GET["s"], 1);

        $issued_book_log = new Issued_Book_Log("%{$search}%", "%{$search}%", "%{$search}%", "%{$search}%", "0");
        $issued_book_log_list = $issued_book_log -> List($_SESSION["username"]);
    }

?>
<div class="row justify-content-center text-center">
    <div class="col-md-12">
        <h1>My Books</h1>
        <form method="get">
            <input type="text" name="s" id="search" placeholder="Filter Books" <?=isset($search) ? "value='{$search}'" : ""?>>
            <input type="hidden" name="csrf_token" value="<?=$_SESSION["csrf_token"]?>">
            <input type="submit" value="Search" name="submit">
        </form>
        <?=isset($search) ? "<h3>Search results for: {$search}</h3>" : ""?>
    </div>
</div>
<div class="row justify-content-center">
    <?php if (!empty($issued_book_log_list)): ?>
        <?php foreach ($issued_book_log_list as $book): ?>
            <div class="col-md-7">
                <div class="card">
                    <p><strong>Book:</strong> <a href="books.php?s=<?= $book -> book_isbn ?>&csrf_token=<?=$_SESSION['csrf_token']?>&submit"><?= $book -> book_isbn ?></a></p><hr>
                    <p><strong>Number of copies:</strong> <?= $book -> copies ?></p><hr>
                    <p><strong>Date Requested:</strong> <?= $book -> date_requested ?></p><hr>
                    <p><strong>Due Date:</strong> <?= $book -> due_date ?></p>
                </div>
            </div>
        <?php endforeach; ?>
    <?php elseif (empty($issued_book_log_list)): ?>
        <div class="col-md-12">
            <hr><h1 class="text-center d-flex align-items-center justify-content-center" style="min-height: 50vh">No Books Has Been Added Yet</h1><hr>
        </div>
    <?php endif; ?>
</div>
<?php

    require_once($_SERVER['DOCUMENT_ROOT'] . "/" . basename(dirname(dirname(__FILE__))) . "/snippets/footer.php");?>

