<?php

    require_once($_SERVER['DOCUMENT_ROOT'] . "/" . basename(dirname(dirname(__FILE__))) . "/snippets/user_librarian.php");
    
    $request = new Request_Validate($_GET, ["id", "token",]);

    $request -> CSRF($_GET["token"]);
    $id = $request -> DigitField($_GET["id"]);

    unset($_SESSION["csrf_token"]);

    if (!empty($user -> List($id))) {
        $user -> Activate($id);
        Redirect("User account is now active", "users.php");
    }
    else {
        Redirect("Invalid ID", "users.php");
    }

?>

<?php

    require_once($_SERVER['DOCUMENT_ROOT'] . "/" . basename(dirname(dirname(__FILE__))) . "/snippets/footer.php");?>

