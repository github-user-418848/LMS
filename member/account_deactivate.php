<?php

    require_once($_SERVER['DOCUMENT_ROOT'] . "/" . basename(dirname(dirname(__FILE__))) . "/snippets/user_member.php");

    $request = new Request_Validate($_GET, ["csrf_token"]);
    $request -> CSRF($_GET["csrf_token"]);

    $user = new User();
    $user -> Deactivate($_SESSION["id"]);
    $user -> Logout();

    Redirect("Your account has been deactivated.", BASE_URL);

?>

<?php

    require_once($_SERVER['DOCUMENT_ROOT'] . "/" . basename(dirname(dirname(__FILE__))) . "/snippets/footer.php");