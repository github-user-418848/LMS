<?php

    require_once($_SERVER['DOCUMENT_ROOT'] . "/" . basename(dirname(dirname(__FILE__))) . "/snippets/header.php");
    
    if (!$user -> Is_Logged_in() || !$user -> Is_Admin()) {
        Redirect(location: BASE_URL);
    }

    $category = new Category();
    $category_list = $category -> List();
    $category_array = [];

?>
<div class="row justify-content-center">
    <div class="col-md-7">
        <h1>Add Book</h1>
        <form method="post">
            <input type="text" name="isbn" id="isbn" placeholder="ISBN Number">
            <input type="text" name="title" id="book_title" placeholder="Book Title">
            <input type="text" name="author" id="author" placeholder="Book Author">
            <select name="category" id="category">
                <?php foreach($category_list as $categories): array_push($category_array, $categories -> name);?>
                <option value="<?=$categories -> name?>"><?=$categories -> name?></option>
                <?php endforeach; ?>
            </select>
            <input type="text" name="copies" id="copies" placeholder="Number of copies">
            <input type="hidden" name="csrf_token" id="csrf_token" value="<?= $_SESSION["csrf_token"] ?>">
            <div class="d-flex-wrap justify-content-center">
                <div class="col-md-5">
                    <a id="back" class="btn">Cancel</a>
                </div>
                <div class="col-md-5">
                    <input type="submit" value="Add Book" name="submit">
                </div>
            </div>
        </form>
    </div>
</div>
<?php

    if (isset($_POST["submit"])) {

        $request = new Request_Validate($_POST, ["isbn", "title", "author", "category", "copies", "csrf_token",]);
        $request -> CSRF($_POST["csrf_token"]);

        $book = new Book(
            $request -> DigitField($_POST["isbn"], 1, 13),
            $request -> TextField($_POST["title"]),
            $request -> TextField($_POST["author"]),
            $request -> ChoicesField($_POST["category"], $category_array),
            $request -> DigitField($_POST["copies"], 1, 10)
        );
        
        $book -> Save();

        unset($_SESSION["csrf_token"]);
        Redirect("Book has been added", "books.php");
    }

    require_once($_SERVER['DOCUMENT_ROOT'] . "/" . basename(dirname(dirname(__FILE__))) . "/snippets/footer.php");?>