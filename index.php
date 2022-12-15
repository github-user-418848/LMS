<?php
    
    require_once($_SERVER['DOCUMENT_ROOT'] . "/" . basename(dirname(__FILE__)) . "/snippets/header.php");

    if ($user -> Is_Logged_in() && $user -> Is_Admin()) {
        Redirect(location: "librarian");
    }
    else if ($user -> Is_Logged_in() && !$user -> Is_Admin()) {
        Redirect(location: "member");
    }

    if (isset($_POST["submit"])) {

        $request = new Request_Validate(
            $_POST,
            [
                "csrf_token",
                "email",
                "password",
            ]
        );

        $request -> CSRF($_POST["csrf_token"]);
        $email = $request -> EmailField($_POST["email"]);
        $password = $request -> TextField($_POST["password"]);

        $user -> Login($email, $password);

        if ($user -> Is_Logged_in() && $user -> Is_Admin()) {
            Redirect(location: "librarian");
        }
        else if ($user -> Is_Logged_in() && !$user -> Is_Admin()) {
            Redirect(location: "member");
        }

    }

?>
<div class="row justify-content-center">
    <div class="col-md-5 text-center">
        <a href="https://cspc.edu.ph" target="_blank"><img src="<?php echo BASE_URL; ?>/static/img/cspc.png" alt="Logo" width="180" class="text-center"></a>
        <h1 class="text-center">Login</h1>
        <form method="post">
            <input type="text" name="email" placeholder="Email">
            <input type="password" name="password" placeholder="Password">
            <input type="hidden" name="csrf_token" value="<?=$_SESSION['csrf_token'];?>">
            <input type="submit" value="Login" name="submit"/>
        </form>
        <a href="register.php">Register</a>
    </div>
</div>
<?php

    require_once($_SERVER['DOCUMENT_ROOT'] . "/" . basename(dirname(__FILE__)) . "/snippets/footer.php");