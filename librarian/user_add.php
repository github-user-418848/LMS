<?php

    require_once($_SERVER['DOCUMENT_ROOT'] . "/" . basename(dirname(dirname(__FILE__))) . "/snippets/user_librarian.php");

?>
<div class="row justify-content-center">
    <div class="col-md-7">
        <h1>Add User</h1>
        <form method="post">
            <input type="text" name="email" id="email" placeholder="Email">
            <input type="text" name="username" id="username" placeholder="Username">
            <input type="password" name="password" id="password" placeholder="Password">
            <select name="is_admin" id="is_admin">
                <option value="true">Admin</option>
                <option value="false">Member</option>
            </select>
            <select name="is_active" id="is_active">
                <option value="true">Active</option>
                <option value="false">Inactive</option>
            </select>
            <input type="hidden" name="csrf_token" id="csrf_token" value="<?= $_SESSION["csrf_token"] ?>">
            <div class="d-flex-wrap justify-content-center">
                <div class="col-md-5">
                    <a href="users.php" class="btn">Cancel</a>
                </div>
                <div class="col-md-5">
                    <input type="submit" value="Add User" name="submit">
                </div>
            </div>
        </form>
    </div>
</div>
<script nonce="<?=$_SESSION['nonce']?>">
    const back = document.getElementById("back");
    back.onclick = function () {
        window.history.back();
    }
</script>
<?php

    if (isset($_POST["submit"])) {
        $request = new Request_Validate($_POST, ["email", "username", "password", "is_admin", "is_active", "csrf_token",]);
        $request -> CSRF($_POST["csrf_token"]);

        $user = new User(
            $request -> EmailField($_POST["email"]),
            $request -> TextField($_POST["username"]),
            $request -> PasswordField($_POST["password"]),
            $request -> ChoicesField($_POST["is_active"], array("true", "false")),
            $request -> ChoicesField($_POST["is_admin"], array("true", "false")),
        );
        
        $user -> Create();

        unset($_SESSION["csrf_token"]);
        Redirect("User has been added", "users.php");
    }

    require_once($_SERVER['DOCUMENT_ROOT'] . "/" . basename(dirname(dirname(__FILE__))) . "/snippets/footer.php");?>

