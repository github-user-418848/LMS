<?php

    require_once($_SERVER['DOCUMENT_ROOT'] . "/" . basename(dirname(dirname(__FILE__))) . "/snippets/header.php");

    $auth = new Authenticate();
    if($auth -> Logged_In("librarian")) {
        Redirect(location: "books.php");
    }

    if (isset($_POST["submit"])) {

        $request = new Request_Validate(
            $_POST,
            [
                "csrf_token",
                "username",
                "password",
            ]
        );

        $request -> CSRF($_POST["csrf_token"]);
        $username = $request -> TextField($_POST["username"]);
        $password = $request -> TextField($_POST["password"]);

        $auth -> Login($username, $password);

        echo isset($_SESSION["librarian"]) ? $_SESSION["librarian"] : "None" ;

    }
    
?>
<div class="row justify-content-center">
    <div class="col-md-5">
        <h1>Librarian Login</h1>
        <form method="POST" action="#">
            <input type="text" name="username" placeholder="Username" value="<?=(!empty($username)) ? $username : ""?>">
            <input type="password" name="password" placeholder="Password">
            <input type="text" name="csrf_token" value="<?=$_SESSION['csrf_token'];?>">
            <input type="submit" value="Login" name="submit"/>
        </form>
    </div>
</div>
<?php

    require_once($_SERVER['DOCUMENT_ROOT'] . "/" . basename(dirname(dirname(__FILE__))) . "/snippets/footer.php");?>