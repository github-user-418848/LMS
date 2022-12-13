<?php 
    require_once $_SERVER['DOCUMENT_ROOT'] . "/" . basename(dirname(dirname(__FILE__))) . "/config/init.php";
    $user = new User();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>LMS - Library Management System</title>
    <link rel="icon" type="image/x-icon" href="<?=BASE_URL?>/static/img/cspc.png">
    <link rel="stylesheet" href="<?=BASE_URL?>/static/style.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Jost:wght@100;200;300;400;500;600;700;800;900&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@100;200;300;400;500;600;700;800;900&display=swap" rel="stylesheet">
</head>
<body>
<!-- Header Reference: https://1stwebdesigner.com/pure-css-navigation-menus/ -->
<header class="header align-items-center">
    <a href="<?=BASE_URL?>" class="logo"><img src="<?=BASE_URL?>/static/img/cspc.png" alt="Logo" width="50"> LMS</a>
    <?php if ($user -> Is_Logged_in() && $user -> Is_Admin()): ?>
        <input class="menu-btn" type="checkbox" id="menu-btn" />
        <label class="menu-icon" for="menu-btn"><span class="navicon"></span></label>
        <ul class="menu">
            <li><a href="<?=BASE_URL?>/librarian" <?=CheckActiveUrl("librarian/index")?>>Home</a></li>
            <li class="dropdown">
                <a href="<?=BASE_URL?>/librarian/books.php" <?=CheckActiveUrl("librarian/books")?>>Books</a>
                <div class="dropdown-content">
                    <a href="<?=BASE_URL?>/librarian/pending_books.php" <?=CheckActiveUrl("librarian/pending_books")?>>Pending</a>
                    <a href="<?=BASE_URL?>/librarian/issued_books.php" <?=CheckActiveUrl("librarian/issued_books")?>>Issued</a>
                </div>
            </li>
            <li><a href="<?=BASE_URL?>/librarian/users.php" <?=CheckActiveUrl("librarian/users")?>>Users</a></li>
            <li><a href="<?=BASE_URL?>/librarian/account_update.php" <?=CheckActiveUrl("librarian/my_account")?>>My Account</a></li>
            <li><a href="<?=BASE_URL?>/logout.php">Logout</a></li>
        </ul>
    <?php endif; ?>
    <?php if ($user -> Is_Logged_in() && !$user -> Is_Admin()): ?>
        <input class="menu-btn" type="checkbox" id="menu-btn" />
        <label class="menu-icon" for="menu-btn"><span class="navicon"></span></label>
        <ul class="menu">
            <li><a href="<?=BASE_URL?>/member" <?=CheckActiveUrl("member/index")?>>Home</a></li>
            <li class="dropdown">
                <a href="<?=BASE_URL?>/member/books.php" <?=CheckActiveUrl("member/books")?>>Books</a>
                <div class="dropdown-content">
                    <a href="<?=BASE_URL?>/member/pending_books.php" <?=CheckActiveUrl("member/pending_books")?>>Pending</a>
                    <a href="<?=BASE_URL?>/member/issued_books.php" <?=CheckActiveUrl("member/issued_books")?>>Issued</a>
                </div>
            </li>
            <li><a href="<?=BASE_URL?>/member/account_update.php" <?=CheckActiveUrl("member/account")?>>My Account</a></li>
            <li><a href="<?=BASE_URL?>/logout.php">Logout</a></li>
        </ul>
    <?php endif; ?>
</header>
<div class="container">
    <?php 
        if (isset($_SESSION["msg"]) && !empty($_SESSION["msg"])) {
            echo "<div id='msg'>".$_SESSION["msg"] ."</div>";
            unset($_SESSION["msg"]);
        }
    ?>