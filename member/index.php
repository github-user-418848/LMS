<?php

    require_once($_SERVER['DOCUMENT_ROOT'] . "/" . basename(dirname(dirname(__FILE__))) . "/snippets/header.php");

    if (!$user -> Is_Logged_in() || $user -> Is_Admin()) {
        Redirect(location: BASE_URL);
    }

    $book = new Book();
    $book_list = $book -> List();

?>


<div class="row justify-content-center">
    <div class="col-md-12 text-center">
        <h1>Welcome <?=$_SESSION["username"]?>!</h1>
    </div>
    <div class="col-md-7">
        <p>Books You've Requested</p>
        <p>Borrowed Books: 12</p>
    </div>
    <div class="col-md-5">
        <p>Date Issue</p>
        <p>Lorem ipsum dolor sit amet.</p>
        <p>Lorem ipsum dolor sit amet.</p>
        <p>Lorem ipsum dolor sit amet.</p>
    </div>
</div>
<?php

    require_once($_SERVER['DOCUMENT_ROOT'] . "/" . basename(dirname(dirname(__FILE__))) . "/snippets/footer.php");?>