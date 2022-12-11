<?php
    
    require_once($_SERVER['DOCUMENT_ROOT'] . "/" . basename(dirname(dirname(__FILE__))) . "/snippets/header.php");

    if (!$user -> Is_Logged_in() || !$user -> Is_Admin()) {
        Redirect(location: BASE_URL);
    }
    
    $request = new Request_Validate($_GET, ["id", "token",]);

    $id = $request -> DigitField($_GET["id"]);
    $request -> CSRF($_GET["token"]);

    $user_list = $user -> List($id);

    if (empty($user_list)) {
        Redirect("Invalid ID", "users.php");
    }

?>
<div class="row justify-content-center">
    <div class="col-md-7">
        <h1>Update User</h1>
    </div>
    <div class="col-md-7">
        <?php foreach($user_list as $user_detail): ?>
        <form method="post">
            <input type="text" name="username" id="username" value="<?=$user_detail -> username ?>" placeholder="Username">
            <input type="text" name="email" id="email" value="<?=$user_detail -> email ?>" placeholder="Email">
            <input type="text" name="password" id="password" placeholder="New Password">
            <select name="is_admin" id="is_admin">
                <option value="true" <?=$user_detail -> is_admin === "true" ? "selected": ""?>>Admin</option>
                <option value="false"  <?=$user_detail -> is_admin === "false" ? "selected": ""?>>Member</option>
            </select>
            <select name="is_active" id="is_active">
                <option value="true" <?=$user_detail -> is_active === "true" ? "selected": ""?>>Active</option>
                <option value="false" <?=$user_detail -> is_active === "false" ? "selected": ""?>>Inactive</option>
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
        <?php endforeach; ?>
    </div>
</div>
<?php

    if (isset($_POST["submit"])) {

        $request = new Request_Validate($_POST, ["username", "email", "password", "is_admin", "is_active", "csrf_token"]);
        $request -> CSRF($_POST["csrf_token"]);

        $user = new User(
            $request -> TextField($_POST["username"]),
            $request -> EmailField($_POST["email"]),
            $request -> PasswordField($_POST["password"]),
            $request -> ChoicesField($_POST["is_active"], array("true", "false")),
            $request -> ChoicesField($_POST["is_admin"], array("true", "false")),
        );
        $user -> Update($id);

        unset($_SESSION["csrf_token"]);
        Redirect("User has been updated", "users.php");

    }
    require_once($_SERVER['DOCUMENT_ROOT'] . "/" . basename(dirname(dirname(__FILE__))) . "/snippets/footer.php");