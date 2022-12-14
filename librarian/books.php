<?php

    require_once($_SERVER['DOCUMENT_ROOT'] . "/" . basename(dirname(dirname(__FILE__))) . "/snippets/user_librarian.php");

    $book = new Book();

    if (isset($_GET["submit"])) {
        $request = new Request_Validate($_GET, ["s", "csrf_token"]);
        $request -> redirect = "books.php";
        $request -> CSRF($_GET["csrf_token"]);
        $search = $request -> TextField($_GET["s"], 1);

        $book = new Book("%{$search}%", "%{$search}%", "%{$search}%", "%{$search}%", "%{$search}%");
    }

    $book_list = $book -> List();

?>
    <div class="row justify-content-center text-center">
        <div class="col-md-12">
            <h1>Books</h1>
            <form method="get">
                <input type="text" name="s" id="search" placeholder="Filter Books" <?=isset($search) ? "value='{$search}'" : ""?>>
                <input type="hidden" name="csrf_token" value="<?=$_SESSION["csrf_token"]?>">
                <input type="submit" value="Search" name="submit">
            </form>
            <?=isset($search) ? "<h3>Search results for: {$search}</h3>" : ""?>
        </div>
        <div class="col-md-3">
            <a class="btn" href="book_add.php">+ Add New Book</a>
        </div>
    </div>
    <?php if (!empty($book_list)): ?>
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="table-container">
                    <table class="mx-auto table" cellspacing="0">
                    <tr class="table-head">
                        <th>ISBN</th>
                        <th>Title</th>
                        <th>Author</th>
                        <th>Category</th>
                        <th>Copies</th>
                        <th colspan="2">Actions</th>
                    </tr>
                    <?php foreach ($book_list as $books): ?>
                        <tr>
                            <td><?= $books -> isbn ?></td>
                            <td><?= $books -> title ?></td>
                            <td><?= $books -> author ?></td>
                            <td><?= $books -> category ?></td>
                            <td><?= $books -> copies ?></td>
                            <td>
                                <a href='book_update.php?id=<?=$books -> id?>&token=<?=$_SESSION["csrf_token"] ?>'>
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor" class="bi bi-pencil-square" viewBox="0 0 16 16">
                                        <path d="M15.502 1.94a.5.5 0 0 1 0 .706L14.459 3.69l-2-2L13.502.646a.5.5 0 0 1 .707 0l1.293 1.293zm-1.75 2.456-2-2L4.939 9.21a.5.5 0 0 0-.121.196l-.805 2.414a.25.25 0 0 0 .316.316l2.414-.805a.5.5 0 0 0 .196-.12l6.813-6.814z"/>
                                        <path fill-rule="evenodd" d="M1 13.5A1.5 1.5 0 0 0 2.5 15h11a1.5 1.5 0 0 0 1.5-1.5v-6a.5.5 0 0 0-1 0v6a.5.5 0 0 1-.5.5h-11a.5.5 0 0 1-.5-.5v-11a.5.5 0 0 1 .5-.5H9a.5.5 0 0 0 0-1H2.5A1.5 1.5 0 0 0 1 2.5v11z"/>
                                    </svg>
                                </a>&nbsp;
                                <a href='book_delete.php?id=<?=$books -> id?>&token=<?=$_SESSION["csrf_token"]?>'>
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor" class="bi bi-trash3" viewBox="0 0 16 16">
                                        <path d="M6.5 1h3a.5.5 0 0 1 .5.5v1H6v-1a.5.5 0 0 1 .5-.5ZM11 2.5v-1A1.5 1.5 0 0 0 9.5 0h-3A1.5 1.5 0 0 0 5 1.5v1H2.506a.58.58 0 0 0-.01 0H1.5a.5.5 0 0 0 0 1h.538l.853 10.66A2 2 0 0 0 4.885 16h6.23a2 2 0 0 0 1.994-1.84l.853-10.66h.538a.5.5 0 0 0 0-1h-.995a.59.59 0 0 0-.01 0H11Zm1.958 1-.846 10.58a1 1 0 0 1-.997.92h-6.23a1 1 0 0 1-.997-.92L3.042 3.5h9.916Zm-7.487 1a.5.5 0 0 1 .528.47l.5 8.5a.5.5 0 0 1-.998.06L5 5.03a.5.5 0 0 1 .47-.53Zm5.058 0a.5.5 0 0 1 .47.53l-.5 8.5a.5.5 0 1 1-.998-.06l.5-8.5a.5.5 0 0 1 .528-.47ZM8 4.5a.5.5 0 0 1 .5.5v8.5a.5.5 0 0 1-1 0V5a.5.5 0 0 1 .5-.5Z"/>
                                    </svg>
                                </a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                    </table>
                </div>
            </div>
        </div>
    <?php elseif(empty($book_list)): ?>
        <div class="row">
            <div class="col-md-12">
                <hr><h1 class="text-center d-flex align-items-center justify-content-center" style="min-height: 50vh">No Books Available</h1><hr>
            </div>
        </div>
    <?php endif; ?>
<?php

    require_once($_SERVER['DOCUMENT_ROOT'] . "/" . basename(dirname(dirname(__FILE__))) . "/snippets/footer.php");?>