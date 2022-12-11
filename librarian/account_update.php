<?php
    
    require_once($_SERVER['DOCUMENT_ROOT'] . "/" . basename(dirname(dirname(__FILE__))) . "/snippets/header.php");

    if (!$user -> Is_Logged_in() && !$user -> Is_Admin()) {
        Redirect(location: BASE_URL);
    }
    

    $user_list = $user -> List($_SESSION["id"]);

?>
<div class="row justify-content-center">
    <div class="col-md-7">
        <h1>My Account</h1>
    </div>
    <div class="col-md-7">
        
        <?php foreach($user_list as $user_detail): ?>
        <form method="post">
            <input type="text" name="email" id="email" value="<?=$user_detail -> email ?>" placeholder="Email">
            <input type="text" name="username" id="username" value="<?=$user_detail -> username ?>" placeholder="Username">
            <input type="text" name="password" id="password" placeholder="New Password">
            <select name="is_admin" id="is_admin">
                <option value="true" <?=$user_detail -> is_admin === "true" ? "selected": ""?>>Admin</option>
                <option value="false"  <?=$user_detail -> is_admin === "false" ? "selected": ""?>>Member</option>
            </select>
            <input type="hidden" name="csrf_token" id="csrf_token" value="<?= $_SESSION["csrf_token"] ?>">
            <div class="d-flex-wrap justify-content-center">
                <div class="col-md-5">
                    <a href="users.php" class="btn">Cancel</a>
                </div>
                <div class="col-md-5">
                    <input type="submit" value="Update User" name="submit">
                </div>
            </div>
        </form>
        <a href="account_deactivate.php?ccsrf_token=<?= $_SESSION["csrf_token"] ?>">Deactivate My Account</a>
        <?php endforeach; ?>
    </div>
</div>
<?php

    if (isset($_POST["submit"])) {

        $request = new Request_Validate($_POST, ["email", "username", "password", "is_admin", "csrf_token"]);
        $request -> CSRF($_POST["csrf_token"]);

        $user = new User(
            $request -> EmailField($_POST["email"]),
            $request -> TextField($_POST["username"]),
            $request -> PasswordField($_POST["password"]),
            $request -> ChoicesField($_POST["is_admin"], array("true", "false")),
            "true"
        );
        $user -> Update($_SESSION["id"]);

        unset($_SESSION["csrf_token"]);
        Redirect("Account has been updated");

    }
    require_once($_SERVER['DOCUMENT_ROOT'] . "/" . basename(dirname(dirname(__FILE__))) . "/snippets/footer.php");