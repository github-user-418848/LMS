<?php
    
    require_once($_SERVER['DOCUMENT_ROOT'] . "/" . basename(dirname(dirname(__FILE__))) . "/snippets/header.php");

    if (!$user -> Is_Logged_in() || !$user -> Is_Admin()) {
        Redirect(location: BASE_URL);
    }

    $book = new Book();
    
    $request = new Request_Validate(
        $_GET,
        [
            "id",
            "token",
        ]
    );

    $id = $request -> DigitField($_GET["id"]);
    $request -> CSRF($_GET["token"]);
    $book_details = $book -> List($id);

    if (empty($book_details)) {
        Redirect("Invalid ID", "books.php");
    }

    $category = new Category();
    $category_list = $category -> List();

    $category_array = [];

?>
<div class="row justify-content-center">
    <div class="col-md-7">
        <h1>Update Book</h1>
    </div>
    <div class="col-md-7">
        <?php foreach($book_details as $book_detail): ?>
        <form method="post">
            <input type="text" name="isbn" id="isbn" value="<?=$book_detail -> isbn ?>">
            <input type="text" name="title" id="title" value="<?=$book_detail -> title ?>">
            <input type="text" name="author" id="author" value="<?=$book_detail -> author ?>">
            <select name="category" id="category">
                <?php foreach($category_list as $categories): array_push($category_array, $categories -> name);?>
                <option value="<?=$categories -> name?>" <?=$categories -> name == $book_detail -> category ? "selected": ""?>><?=$categories -> name?></option>
                <?php endforeach; ?>
            </select>
            <input type="text" name="copies" id="copies" value="<?=$book_detail -> copies ?>">
            <input type="hidden" name="csrf_token" id="csrf_token" value="<?= $_SESSION["csrf_token"] ?>">
            <div class="d-flex-wrap justify-content-center">
                <div class="col-md-5">
                    <a id="back" class="btn">Cancel</a>
                </div>
                <div class="col-md-5">
                    <input type="submit" value="Update Book" name="submit">
                </div>
            </div>
        </form>
        <?php endforeach; ?>
    </div>
</div>
<?php


    if (isset($_POST["submit"])) {

        $request = new Request_Validate($_POST, ["isbn", "title", "author", "category", "copies", "csrf_token",]);
        $request -> CSRF($_POST["csrf_token"]);
        $isbn = $request -> DigitField($_POST["isbn"], 1, 13);

        $book = new Book(
            $isbn,
            $request -> TextField($_POST["title"]),
            $request -> TextField($_POST["author"]),
            $request -> ChoicesField($_POST["category"], 
                    $category_array
            ),
            $request -> DigitField($_POST["copies"], 1, 10),
        );
        $book -> Update($id);

        unset($_SESSION["csrf_token"]);
        Redirect("Book number {$isbn} has been updated", "books.php");

    }
    require_once($_SERVER['DOCUMENT_ROOT'] . "/" . basename(dirname(dirname(__FILE__))) . "/snippets/footer.php");?>