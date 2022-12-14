<?php

    require_once($_SERVER['DOCUMENT_ROOT'] . "/" . basename(dirname(dirname(__FILE__))) . "/snippets/user_member.php");

    $book = new Book();

    if (isset($_GET["submit"])) {
        $request = new Request_Validate($_GET, ["s", "csrf_token"]);
        $request -> redirect = "books.php";
        $request -> CSRF($_GET["csrf_token"]);
        $search = $request -> TextField($_GET["s"], 1);

        $book = new Book("%{$search}%", "%{$search}%", "%{$search}%", "%{$search}%", "0");
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
    </div>
    <?php if (!empty($book_list)): ?>
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="table-container">
                    <table class="mx-auto table" cellspacing="0">
                    <?php if (isset($search)): ?>
                    <tr class="table-head">
                        <th colspan="100%"><a href='books.php'>Clear Search Result</a></th>
                    </tr>
                    <?php endif; ?>
                    <tr class="table-head">
                        <th>ISBN</th>
                        <th>Title</th>
                        <th>Author</th>
                        <th>Category</th>
                        <th>Copies</th>
                        <th></th>
                    </tr>
                    <?php foreach ($book_list as $books): ?>
                        <tr>
                            <td><?= $books -> isbn ?></td>
                            <td><?= $books -> title ?></td>
                            <td><?= $books -> author ?></td>
                            <td><?= $books -> category ?></td>
                            <td><?= $books -> copies ?></td>
                            <td>
                                <a class="btn" href='pending_book_request.php?id=<?=$books -> id?>&token=<?=$_SESSION["csrf_token"]?>'>
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="d-inline va-middle bi bi-plus-circle" viewBox="0 0 16 16">
                                    <path d="M8 15A7 7 0 1 1 8 1a7 7 0 0 1 0 14zm0 1A8 8 0 1 0 8 0a8 8 0 0 0 0 16z"/>
                                    <path d="M8 4a.5.5 0 0 1 .5.5v3h3a.5.5 0 0 1 0 1h-3v3a.5.5 0 0 1-1 0v-3h-3a.5.5 0 0 1 0-1h3v-3A.5.5 0 0 1 8 4z"/>
                                </svg>&nbsp;
                                Request
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