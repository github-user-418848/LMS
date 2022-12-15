<?php
    
    require_once($_SERVER['DOCUMENT_ROOT'] . "/" . basename(dirname(dirname(__FILE__))) . "/snippets/user_member.php");

    $user_detail = $user -> List($_SESSION["id"]);

?>
<div class="row justify-content-center">
    <div class="col-md-7">
        <h1>My Account</h1>
        <form method="post">
            <input type="text" name="email" id="email" value="<?=$user_detail -> email ?>" placeholder="Email">
            <input type="text" name="username" id="username" value="<?=$user_detail -> username ?>" placeholder="Username">
            <input type="password" name="confirm_password" id="confirm_password" placeholder="New Password">
            <input type="password" name="password" id="password" placeholder="Confirm Password">
            <input type="hidden" name="csrf_token" id="csrf_token" value="<?= $_SESSION["csrf_token"] ?>">
            <input type="submit" value="Update" name="submit">
        </form>
        <a href="account_deactivate.php?csrf_token=<?= $_SESSION["csrf_token"] ?>">Deactivate My Account</a>
    </div>
</div>
<?php

    if (isset($_POST["submit"])) {

        $request = new Request_Validate($_POST, ["email", "username", "confirm_password", "password", "csrf_token"]);
        $request -> CSRF($_POST["csrf_token"]);

        if ($request -> TextField($_POST["confirm_password"]) === $request -> TextField($_POST["password"])) {

            $user = new User(
                $request -> EmailField($_POST["email"]),
                $request -> TextField($_POST["username"]),
                $request -> PasswordField($_POST["password"]),
                "false", "false"
            );
            $user -> Update($_SESSION["id"]);

            unset($_SESSION["csrf_token"]);
            Redirect("Account has been updated");
        }
        else {
            Redirect("Two password fields doesn't match. Please try again.");
        }

    }

    require_once($_SERVER['DOCUMENT_ROOT'] . "/" . basename(dirname(dirname(__FILE__))) . "/snippets/footer.php");