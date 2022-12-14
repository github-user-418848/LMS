<?php
    
    require_once($_SERVER['DOCUMENT_ROOT'] . "/" . basename(dirname(__FILE__)) . "/snippets/header.php");

    if ($user -> Is_Logged_in() && $user -> Is_Admin()) {
        Redirect(location: "librarian/books.php");
    }
    else if ($user -> Is_Logged_in() && !$user -> Is_Admin()) {
        Redirect(location: "member/home.php");
    }

?>
<div class="row justify-content-center">
    <div class="col-md-5 text-center">
        <img src="<?php echo BASE_URL; ?>/static/img/cspc.png" alt="Logo" width="180" class="text-center">
        <h1 class="text-center">Register</h1>
        <form method="post">
            <input type="email" name="email" placeholder="Email">
            <input type="text" name="username" placeholder="Username">
            <input type="password" name="confirm_password" placeholder="Confirm Password">
            <input type="password" name="password" placeholder="Password">
            <input type="hidden" name="csrf_token" value="<?=$_SESSION['csrf_token'];?>">
            <input type="submit" value="Register" name="submit"/>
        </form>
        <a href="index.php">Back to Login</a>
    </div>
</div>
<?php

    if (isset($_POST["submit"])) {

        $request = new Request_Validate($_POST, ["username", "email", "confirm_password", "password", "csrf_token",]);
        $request -> CSRF($_POST["csrf_token"]);
        
        if ($_POST["confirm_password"] === $_POST["password"]) {
            
            $user = new User(
                $request -> EmailField($_POST["email"]),
                $request -> TextField($_POST["username"]),
                $request -> PasswordField($_POST["password"]),
                "false", "false",
            );

            $user -> Create();
            Redirect("You have been successfully registered. An administrator will review and approve the activation of your account", "index.php");
        }
        else {
            Redirect("The two password fields doesn't match. Please try again");
        }

    }


    require_once($_SERVER['DOCUMENT_ROOT'] . "/" . basename(dirname(__FILE__)) . "/snippets/footer.php");