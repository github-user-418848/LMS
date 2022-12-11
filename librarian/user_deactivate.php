<?php

    require_once($_SERVER['DOCUMENT_ROOT'] . "/" . basename(dirname(dirname(__FILE__))) . "/snippets/header.php");
    
    if (!$user -> Is_Logged_in() || !$user -> Is_Admin()) {
        Redirect(location: BASE_URL);
    }

    $user = new User();
    
    $request = new Request_Validate($_GET, ["id", "token",]);

    $request -> CSRF($_GET["token"]);
    $id = $request -> DigitField($_GET["id"]);

    unset($_SESSION["csrf_token"]);

    if (!empty($user -> List($id))) {
        $user -> Deactivate($id);
        Redirect("User account has been deactivated", "users.php");
    }
    else {
        Redirect("Invalid ID", "users.php");
    }

?>

<?php

    require_once($_SERVER['DOCUMENT_ROOT'] . "/" . basename(dirname(dirname(__FILE__))) . "/snippets/footer.php");?>

